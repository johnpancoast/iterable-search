<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser;

/**
 * A rule for a value
 *
 * The rule itself is implementation specific and the self::true($value) method should return if
 * the value passes the rule.
 *
 * @author John Pancoast <johnpancoast.tech@gmail.com>
 */
interface RuleInterface
{
    /**
     * Does this $value pass the current rule
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function true($value);
}
