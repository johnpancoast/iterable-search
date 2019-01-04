<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser;

use Pancoast\IterableParser\Exception\RuleResultException;

/**
 * A rule result is what happens after a rule passes
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface RuleResultInterface
{
    /**
     * Run the result for $value
     *
     * @param mixed $value
     * @throws RuleResultException If internal exception occurs
     */
    public function run($value);
}
