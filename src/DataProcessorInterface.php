<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor;

/**
 * Data processor contract
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
     * @return mixed
     */
    public function process();
}
