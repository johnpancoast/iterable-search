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
 * Data processor iterates a data provider and deserializes each iteration to a type specified, then runs rule handlers.
 *
 * The processor is the main interface that outsiders interact with so this is probably unnecessary so this interface
 * probably doesn't need to be around. Also doesn't hurt to leave it.
 *
 * @author John Pancoast <johnpancoast.tech@gmail.com>
 */
interface DataProcessorInterface
{
    /**
     * Set data provider
     *
     * @param DataProviderInterface $dataProvider
     *
     * @return $this
     */
    public function setDataProvider(DataProviderInterface $dataProvider);

    /**
     * Set rule handlers
     *
     * @param RuleHandlerInterface[] $ruleHandlers Array of rule handlers
     *
     * @return $this
     */
    public function setRuleHandlers(array $ruleHandlers = []);

    /**
     * Process data by running each of the rule handlers against each iteration of data from the provider.
     *
     * @param array|int[] $skipIterations Array of integers representing iterations to skip, 1'th based, not 0'th.
     *                                    First iteration is 1, as to say: "the first row".
     * @return mixed
     *
     * @throws RuleException Exception for a failing rule
     * @throws RuleResultException Exception for a failing rule result
     */
    public function process(array $skipIterations = []);
}
