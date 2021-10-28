<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser;

use Pancoast\IterableParser\Exception\RuleResultException;

/**
 * Abstract rule result
 *
 * Mainly here to ensure that RuleException is thrown for caught exceptions of child objects
 *
 * @author John Pancoast <johnpancoast.tech@gmail.com>
 */
abstract class AbstractRuleResult implements RuleResultInterface
{
    /**
     * Run result
     *
     * @param $value
     */
    abstract protected function runResult($value);

    /**
     * {@inheritdoc}
     */
    public function run($value)
    {
        try {
            $this->runResult($value);
        } catch (\Exception $e) {
            throw new RuleResultException(
                "Failed to run rule result",
                $e->getCode(),
                $e
            );
        }
    }
}
