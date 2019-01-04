<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser;

use Pancoast\Common\Util\Util;
use Pancoast\IterableParser\Serializer\SerializerInterface;

/**
 * Data provider trait
 *
 * This is here as a trait instead of a base class so that your providers can extend whatever class they'd like while
 * still sticking to the interface and using this available functionality.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
trait DataProviderTrait
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var string
     */
    protected $className;

    /**
     * {@inheritdoc}
     */
    public function setFormat($format)
    {
        Util::validateType($format, 'string');
        $this->format = $format;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setClassName($className)
    {
        Util::validateType($className, 'string');
        $this->className = $className;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function deserialized()
    {
        if (!$this->serializer) {
            throw new \LogicException("Cannot deserialize without a serializer");
        }

        return $this->serializer->deserialize(
            $this->current(),
            $this->className,
            $this->format
        );
    }
}
