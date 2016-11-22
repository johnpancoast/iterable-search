<?php
/**
 * @package       johnpancoast/code-challenge
 * @copyright (c) 2016 John Pancoast
 * @license       Public Domain
 */


namespace Pancoast\CodeChallenge\Serializer;

/**
 * A serializer handler handles serialization (doy)
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface HandlerInterface
{
    /**
     * @return string Supported format of this handler
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
    public function serialize($data, $format);

    /**
     * Deserialize data into a type
     *
     * @param mixed $data
     * @param mixed $type
     * @param string $format
     *
     * @return mixed Deserialized data
     */
    public function deserialize($data, $type, $format);
}
