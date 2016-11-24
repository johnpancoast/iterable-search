<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       Public Domain
 */

namespace Pancoast\CodeChallenge\Serializer\Handler;

use JMS\Serializer\SerializerInterface;
use Pancoast\CodeChallenge\Serializer\HandlerInterface;

/**
 * An abstract handler for those that can delegate to jms/serializer
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
abstract class AbstractJmsHandler implements HandlerInterface
{
    /**
     * @var SerializerInterface
     */
    protected $jmsSerializer;

    /**
     * Get supported format of handler
     *
     * It's important that our handlers that wrap jms/serializer support the
     * same formats. Meaning, our JsonHandler that wraps jsm/serializer's 'json'
     * format should support 'json' locally.
     *
     * @return string
     */
    abstract public function getSupportedFormat();

    /**
     * Constructor
     *
     * @param SerializerInterface $jmsSerializer
     */
    public function __construct(SerializerInterface $jmsSerializer)
    {
        $this->jmsSerializer = $jmsSerializer;
    }

    /**
     * {@inheritdoc}
     */
    public function isSupportedFormat($format)
    {
        return $format === $this->getSupportedFormat();
    }

    /**
     * {@inheritdoc}
     */
    public function serialize($data)
    {
        return $this->jmsSerializer->serialize($data, $this->getSupportedFormat());
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize($data, $type)
    {
        return $this->jmsSerializer->deserialize($data, $type, $this->getSupportedFormat());
    }
}
