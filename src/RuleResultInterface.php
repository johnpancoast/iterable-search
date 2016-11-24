<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor;
use Pancoast\DataProcessor\Exception\RuleResultException;

/**
 * A rule result is what happens after a rule passes
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface RuleResultInterface
{
    /**
     * Run the result
     *
     * @throws RuleResultException If internal exception occurs
     */
    public function run();
}
