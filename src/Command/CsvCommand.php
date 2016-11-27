<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor\Command;

use Pancoast\DataProcessor\DataProcessor;
use Pancoast\DataProcessor\DataProvider\FileProvider;
use Pancoast\DataProcessor\Expression\ExpressionLanguageFactory;
use Pancoast\DataProcessor\Rule\ExpressionRule;
use Pancoast\DataProcessor\RuleHandler;
use Pancoast\DataProcessor\RuleHandlerInterface;
use Pancoast\DataProcessor\RuleResult\OutputterRuleResult;
use Pancoast\DataProcessor\Serializer\Format;
use Pancoast\DataProcessor\Serializer\SerializerFactory;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Command to run rules against iterations of data
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class CsvCommand extends BaseCommand
{
    /**
     * @var \Symfony\Component\ExpressionLanguage\ExpressionLanguage
     */
    private $exprLang;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * Amount of rule options we allow
     */
    const RULE_OPTION_AMT = 5;

    /**
     * OPT_*
     *
     * Command option names. Helps avoid bugs and assists changes.
     */
    const OPT_FILE = 'file';
    const OPT_FILE_S = 'f';
    const OPT_DATA_CLASS = 'data-class';
    const OPT_DATA_CLASS_S = 'd';
    const OPT_EXPR_ROOT = 'expr-root';
    const OPT_EXPR_ROOT_S = 'r';
    const OPT_OUT_FORMAT = 'out-format';
    const OPT_OUT_FORMAT_S = 'o';
    const OPT_CFG_FILE = 'config-file';
    const OPT_CFG_FILE_S = 'c';
    // these don't receive short options (*_S above) because console
    // doesn't allow multi-char short opts by default
    const OPT_EXPR_PREFIX = 'expr'; // prefix for N'th expression
    const OPT_EXPR_OUT_PREFIX = 'out'; // prefix for N'th output

    /**
     * {@inheritdoc}
     */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->exprLang = ExpressionLanguageFactory::createInstance();
        $this->serializer = SerializerFactory::createSerializer();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('csv')
            ->setDescription("Iterate over csv data and filter it to various outputs based on rules you specify.")
            ->addOption(
                self::OPT_FILE,
                self::OPT_FILE_S,
                InputOption::VALUE_REQUIRED,
                "A csv file containing data to iterate"
            )
            ->addOption(
                self::OPT_DATA_CLASS,
                self::OPT_DATA_CLASS_S,
                InputOption::VALUE_REQUIRED,
                "A class you define that represents one iteration of the csv you're iterating. It should contain\n" .
                "jms/serializer annotations for it to be validated and (de)serialized.\n"
            )
            ->addOption(
                self::OPT_EXPR_ROOT,
                self::OPT_EXPR_ROOT_S,
                InputOption::VALUE_REQUIRED,
                "The root of the data you specify for using expression language (e.g., The expression 'post.created_by' has root of 'post'))"
            )
            ->addOption(
                self::OPT_OUT_FORMAT,
                self::OPT_OUT_FORMAT_S,
                InputOption::VALUE_REQUIRED,
                sprintf("Output format. Available: %s", implode(', ', Format::getFormats())),
                Format::CSV
            )
            ->addOption(
                self::OPT_CFG_FILE,
                self::OPT_CFG_FILE_S,
                InputOption::VALUE_REQUIRED,
                "A yaml config file holding command options values. Useful for shortening your CLI commands. Values passed in CLI take precedence."
            )
        ;

        // due to symfony console not having the ability to add dynamic options, we just add a bunch of options
        // TODO fix - this implies that each expression will have exactly one output if true which works for a lot of
        //      cases but not all, so fix
        for ($i = 0; $i < self::RULE_OPTION_AMT; $i++) {
            $this->addOption(
                sprintf("%s%s", self::OPT_EXPR_PREFIX, $i),
                null,
                InputOption::VALUE_OPTIONAL,
                "N'th expression"
            );

            $this->addOption(
                sprintf("%s%s", self::OPT_EXPR_OUT_PREFIX, $i),
                null,
                InputOption::VALUE_OPTIONAL,
                "N'th output"
            );
        }
    }

    /**
     * Initialize values
     *
     * Note that command argument values take precedence over those in config
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->loadConfigFile();
        $this->validateRequiredOptions();
    }

    /**
     * Execute command
     */
    protected function executeCmd()
    {
        $this->createProcessor()->process();
    }

    /**
     * Create processor
     *
     * @return DataProcessor
     */
    private function createProcessor()
    {
        return new DataProcessor(
            $this->createFileProvider(),
            $this->createRuleHandlers()
        );
    }

    /**
     * Create file provider
     *
     * @param string $format
     * @return FileProvider
     */
    private function createFileProvider($format = Format::CSV)
    {
        $provider = new FileProvider($this->input->getOption(self::OPT_FILE), 'r');
        $provider
            ->setClassName($this->input->getOption(self::OPT_DATA_CLASS))
            ->setFormat($format)
            ->setSerializer(SerializerFactory::createSerializer());

        return $provider;
    }

    /**
     * Create rule handlers
     *
     * @return RuleHandlerInterface[] Array of RuleHandlerInterface's
     */
    private function createRuleHandlers()
    {
        $handlers = [];

        for ($i = 0; $i < self::RULE_OPTION_AMT; $i++) {
            $ekey = sprintf('%s%s', self::OPT_EXPR_PREFIX, $i);
            $okey = sprintf('%s%s', self::OPT_EXPR_OUT_PREFIX, $i);

            if (!$this->input->getOption($ekey)) {
                continue;
            }

            // assume initialization validated that we have both expression and output
            $exp = $this->input->getOption($ekey);
            $out = $this->input->hasOption($okey) ? $this->input->getOption($okey) : null;

            // TODO load output based on user's choice, for now its outputting to STDOUT

            $handlers[] = new RuleHandler(
                new ExpressionRule($this->exprLang, $exp, $this->input->getOption(self::OPT_EXPR_ROOT)),
                [
                    new OutputterRuleResult($this->output, $this->serializer, $this->input->getOption(self::OPT_OUT_FORMAT)),
                ]
            );
        }

        return $handlers;
    }

    /**
     * Get required options
     *
     * Symfony treats "options" as optional according to doctext, however, we're only using options to allow for
     * flexibility in how values can be set (command args or config file) so we still define necessary options.
     *
     * @return array
     */
    private function getRequiredOptions()
    {
        return [
            self::OPT_FILE,
            self::OPT_DATA_CLASS,
            self::OPT_EXPR_ROOT,
            self::OPT_OUT_FORMAT
        ];
    }

    /**
     * Validate required options are here
     *
     * @throws InvalidOptionException
     */
    private function validateRequiredOptions()
    {
        foreach ($this->getRequiredOptions() as $o) {
            if (!$this->input->hasOption($o) || !$this->input->getOption($o)) {
                throw new InvalidOptionException(sprintf("Missing required option '%s'", $o));
            }
        }
    }

    /**
     * Load config file
     */
    private function loadConfigFile()
    {
        if (!$path = $this->input->getOption(self::OPT_CFG_FILE)) {
            return;
        }

        $config = Yaml::parse(file_get_contents($path));

        // Note that command argument values take precedence over those in config
        foreach ($config as $k => $v) {
            if (!$this->input->getOption($k)) {
                $this->input->setOption($k, $v);
            }
        }
    }
}
