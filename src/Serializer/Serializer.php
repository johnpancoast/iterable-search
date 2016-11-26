<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor\Serializer;

/**
 * Serializer
 *
 * Note that our serializer calls on our handlers which wrap jms/serializer
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class Serializer implements SerializerInterface
{
    /**
     * @var HandlerInterface[]
     */
    private $handlers = [];

    /**
     * {@inheritdoc}
     */
    public function serialize($data, $handler)
    {
        if (!isset($this->handlers[$handler])) {
            throw new \UnexpectedValueException(sprintf("Unknown serialization handler '%s'", $handler));
        }

        if (empty($data)) {
            return;
        }

        /** @var $handler HandlerInterface */
        $handler = $this->handlers[$handler];
        return $handler->serialize($data);
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize($data, $type, $handler)
    {
        if (!isset($this->handlers[$handler])) {
            throw new \UnexpectedValueException(sprintf("Unknown serialization handler '%s'"));
        }

        if (empty($data)) {
            return;
        }

        /** @var $handler HandlerInterface */
        $handler = $this->handlers[$handler];
        return $handler->deserialize($data, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function registerHandlers(array $handlers)
    {
        foreach ($handlers as $h) {
            if (!$h instanceof HandlerInterface) {
                throw new \InvalidArgumentException("\$handlers must be an array of HandlerInterface objects");
            }

            $this->handlers[$h->getSupportedFormat()] = $h;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedTypes()
    {
        return array_keys($this->handlers);
    }
}
