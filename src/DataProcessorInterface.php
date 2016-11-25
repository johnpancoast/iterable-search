<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor;

use Pancoast\DataProcessor\Exception\RuleException;
use Pancoast\DataProcessor\Exception\RuleResultException;

/**
 * Data processor iterates a data provider and deserializes each iteration to a type specified, then runs rule handlers.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
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
     * Process data
     *
     * @throws RuleException Exception for a failing rule
     * @throws RuleResultException Exception for a failing rule result
     */
    public function process();
}
