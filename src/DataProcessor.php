<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser;

use Pancoast\IterableParser\Exception\RuleException;
use Pancoast\IterableParser\Exception\RuleResultException;
use Pancoast\IterableParser\Exception\UnknownRuleHandlerException;
use Pancoast\IterableParser\Serializer\SerializerInterface;

/**
 * Abstract data processor
 *
 * @author John Pancoast <johnpancoast.tech@gmail.com>
 */
class DataProcessor implements DataProcessorInterface
{
    /**
     * @var DataProviderInterface
     */
    private $dataProvider;

    /**
     * @var array
     */
    private $ruleHandlers;

    /**
     * Constructor
     *
     * @param DataProviderInterface     $dataProvider
     * @param RuleHandlerInterface[]    $ruleHandlers
     */
    public function __construct(DataProviderInterface $dataProvider, array $ruleHandlers = [])
    {
        $this->dataProvider = $dataProvider;
        $this->ruleHandlers = $ruleHandlers;
    }

    /**
     * {@inheritdoc}
     */
    public function process(array $skipIterations = [])
    {
        $this->validateRuleHandlers();

        // Skip iterations
        $skipIterations = array_combine($skipIterations, $skipIterations);

        $iteration = 0;

        foreach ($this->dataProvider as $data) {
            $iteration++;

            // skip empty data or if specified to be skipped
            if (empty($data) || isset($skipIterations[$iteration])) {
                continue;
            }

            // current iteration, deserialized
            $obj = $this->dataProvider->deserialized();

            foreach ($this->ruleHandlers as $ruleHandler) {
                try {
                    $ruleHandler->run($obj);
                } catch (\Exception $e) {
                    // wrap unknown exceptions with a rule exception
                    if (!$e instanceof RuleException && !$e instanceof RuleResultException) {
                        $e = new RuleException(
                            "Caught exception while attempting to execute a rule, review internal exception",
                            $e->getCode(),
                            $e
                        );
                    }

                    // throw up
                    throw $e;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDataProvider(DataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function setRuleHandlers(array $ruleHandlers = [])
    {
        $this->ruleHandlers = $ruleHandlers;
    }

    /**
     * Are our rule handlers valid
     *
     * @throws UnknownRuleHandlerException If unknown rule found
     */
    private function validateRuleHandlers()
    {
        foreach ($this->ruleHandlers as $ruleHandler) {
            if (!$ruleHandler instanceof RuleHandlerInterface) {
                throw new UnknownRuleHandlerException(
                    sprintf(
                        'Rule handlers must be instances of \Pancoast\IterableParser\RuleHandlerInterface. Received %s',
                        gettype($ruleHandler)
                    )
                );
            }
        }
    }
}
