<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor;

/**
 * An iterator that provides data and specifies its current format
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface DataProviderInterface extends \Iterator
{
    /**
     * Set format of data
     *
     * @param string $format
     */
    public function setFormat($format);

    /**
     * Get format of data
     *
     * @return string
     */
    public function getFormat();
}
