<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser;

use Pancoast\IterableParser\Exception\RuleException;

/**
 * Rule handler evaluates a rule against a value and runs results if true
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class RuleHandler implements RuleHandlerInterface
{
    /**
     * @var RuleInterface
     */
    protected $rule;

    /**
     * @var RuleResultInterface[]|array
     */
    protected $ruleResults = [];

    /**
     * Constructor
     *
     * @param RuleInterface         $rule
     * @param RuleResultInterface[] $ruleResults
     */
    public function __construct(RuleInterface $rule, array $ruleResults = [])
    {
        $this->rule = $rule;

        // use available typehinting
        foreach ($ruleResults as $result) {
            $this->addRuleResult($result);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run($value)
    {
        // evaluate rule, throw RuleException for failure
        try {
            $passed = $this->rule->true($value);
        } catch (\Exception $e) {
            // wrap unknown exceptions, throw all up as RuleException
            if (!$e instanceof RuleException) {
                $e = new \Exception("Failed evaluating rule for value. See internals.", $e->getCode(), $e);
            }

            // throw up
            throw $e;
        }

        // run rule results, throw RuleResultException for failure
        if ($passed) {
            try {
                /** @var $result RuleResultInterface */
                foreach ($this->ruleResults as $result) {
                    $result->run($value);
                }
            } catch (\Exception $e) {
                // wrap unknown exceptions, throw all up as RuleResultException
                if (!$e instanceof RuleResultInterface) {
                    $e = new \Exception("Failed running rule result. See internals.", $e->getCode(), $e);
                }

                // throw up
                throw $e;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setRule(RuleInterface $rule)
    {
        $this->rule = $rule;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * {@inheritdoc}
     */
    public function addRuleResult(RuleResultInterface $ruleResult)
    {
        $this->ruleResults[] = $ruleResult;
    }

    /**
     * {@inheritdoc}
     */
    public function getRuleResults()
    {
        return $this->ruleResults;
    }
}
