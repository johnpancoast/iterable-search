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
use Pancoast\DataProcessor\Serializer\SerializerFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Command to run rules against iterations of data
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class EvaluateCommand extends BaseCommand
{
    /**
     * @var \Symfony\Component\ExpressionLanguage\ExpressionLanguage
     */
    private $expLang;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    // Amount of rule options we allow
    const RULE_OPTION_AMT = 10;

    /**
     * {@inheritdoc}
     */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->expLang = ExpressionLanguageFactory::createInstance();
        $this->serializer = SerializerFactory::createSerializer();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName("evaluate")
            ->setDescription("Evaluate rules against iterations of data and do something if true")
            ->addArgument(
                "input_csv",
                InputArgument::REQUIRED,
                "A csv file containing data to iterate"
            )
            ->addArgument(
                "data_class",
                InputArgument::REQUIRED,
                "The class that each iteration will be deserialized to"
            )
            ->addArgument(
                "data_root",
                InputArgument::REQUIRED,
                "The root of the data when using expression language (e.g., post.create_by has 'post' root))"
            )
            ->addArgument(
                "output_format",
                InputArgument::OPTIONAL,
                "Output format (csv, json, xml, yaml)",
                "csv"
            )
        ;

        // due to symfony console not having the ability to add dynamic options, we just add a bunch of options
        // TODO fix - this implies that each expression will have exactly one output if true which works for a lot of
        //      cases but not all, so fix
        for ($i = 0; $i < self::RULE_OPTION_AMT; $i++) {
            $this->addOption(
                sprintf("expression%s", $i),
                sprintf("e%s", $i),
                InputOption::VALUE_OPTIONAL,
                "N'th expression"
            );

            $this->addOption(
                sprintf("output%s", $i),
                sprintf("o%s", $i),
                InputOption::VALUE_OPTIONAL,
                "N'th output"
            );
        }
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
     * Create rule handlers
     *
     * @return RuleHandlerInterface[] Array of RuleHandlerInterface's
     */
    private function createRuleHandlers()
    {
        $handlers = [];

        for ($i = 0; $i < self::RULE_OPTION_AMT; $i++) {
            $ekey = sprintf('expression%s', $i);
            $okey = sprintf('output%s', $i);

            if (!isset($this->options[$ekey])) {
                continue;
            }

            // assume initialization validated that we have both expression and output
            $exp = $this->options[$ekey];
            $out = isset($this->options[$okey]) ? $this->options[$okey] : null;

            // TODO load output based on user's choice, for now its outputting to STDOUT

            $handlers[] = new RuleHandler(
                new ExpressionRule($this->expLang, $exp, $this->arguments['data_root']),
                [
                    new OutputterRuleResult($this->output, $this->serializer, $this->arguments['output_format']),
                ]
            );
        }

        return $handlers;
    }

    /**
     * Create file provider
     *
     * @param string $format
     * @return FileProvider
     */
    private function createFileProvider($format = 'csv')
    {
        $provider = new FileProvider($this->arguments['input_csv'], 'r');
        $provider
            ->setClassName($this->arguments['data_class'])
            ->setFormat($format)
            ->setSerializer(SerializerFactory::createSerializer());

        return $provider;
    }
}
