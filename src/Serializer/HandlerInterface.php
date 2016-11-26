<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */


namespace Pancoast\DataProcessor\Serializer;

/**
 * A serializer handler handles serialization (doy)
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface HandlerInterface
{
    /**
     * @return string Supported format of this handler, one of the {@see Format} constants.
     */
    public function getSupportedFormat();

    /**
     * Does this handler support a particular type
     *
     * @param $format
     *
     * @return bool
     */
    public function isSupportedFormat($format);

    /**
     * @param mixed $data
     *
     * @return mixed Serialized data
     */
    public function serialize($data);

    /**
     * Deserialize data into a type
     *
     * @param mixed $data
     * @param mixed $type
     *
     * @return mixed Deserialized data
     */
    public function deserialize($data, $type);

    // TODO perhaps add a method for the handlers to auto-determine if they can support se(dese)rialization.
}
