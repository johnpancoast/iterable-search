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
     * Set format of data in current form
     *
     * @param string $format
     * @return $this
     */
    public function setFormat($format);

    /**
     * Set serializer
     *
     * @param SerializerInterface $serializer
     *
     * @return mixed
     */
    public function setSerializer(SerializerInterface $serializer);

    /**
     * Set the class that represents a deserialized iteration of this provider
     *
     * @param string $className
     *
     * @return $this
     */
    public function setDeserializedClassName($className);

    /**
     * Get current iteration deserialized
     *
     * @return object An instance of the $className passed to self::setDeserializedClassName($className)
     */
    public function deserialize();
}
