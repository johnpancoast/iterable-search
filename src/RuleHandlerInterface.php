<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser;
use Pancoast\IterableParser\Exception\RuleException;
use Pancoast\IterableParser\Exception\RuleResultException;

/**
 * A rule handler specifies a rule and what to do if the rule is true
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface RuleHandlerInterface
{
    /**
     * Set rule
     *
     * @param RuleInterface $rule
     *
     * @return $this
     */
    public function setRule(RuleInterface $rule);

    /**
     * Get rule
     *
     * @return RuleInterface
     */
    public function getRule();

    /**
     * Add rule result
     *
     * @param RuleResultInterface $ruleResult
     *
     * @return mixed
     */
    public function addRuleResult(RuleResultInterface $ruleResult);

    /**
     * Get rule results
     *
     * @return RuleResultInterface[]
     */
    public function getRuleResults();

    /**
     * Give a $value to rule and if it passes, call on the rule results.
     *
     * @param $value
     * @throws RuleException If a rule fails
     * @throws RuleResultException If a rule result call fails
     */
    public function run($value);
}
