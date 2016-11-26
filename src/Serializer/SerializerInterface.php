<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor\Serializer;

/**
 * Serializes data between formats
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface SerializerInterface
{
    /**
     * Get the types the serializer supports
     *
     * @return array
     */
    public function getSupportedTypes();

    /**
     * Register handlers
     *
     * @param HandlerInterface[] $handlers
     *
     * @return $this
     */
    public function registerHandlers(array $handlers);

    /**
     * Serialize data
     *
     * @param mixed $data
     * @param string $handler Handler's supported format string
     *
     * @return mixed
     */
    public function serialize($data, $handler);

    /**
     * Deserialize data
     *
     * @param mixed $data
     * @param object $type The type to deserialize to
     * @param string $handler Handler's supported format string
     *
     * @return mixed
     */
    public function deserialize($data, $type, $handler);
}
