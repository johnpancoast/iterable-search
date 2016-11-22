<?php
/**
 * @package       johnpancoast/code-challenge
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
    public function serialize($data, $format)
    {
        return $this->jmsSerializer->serialize($data, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize($data, $type, $format)
    {
        return $this->jmsSerializer->deserialize($data, $type, $format);
    }
}
