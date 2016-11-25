<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor\RuleResult;

use Pancoast\Common\Util\Util;
use Pancoast\DataProcessor\AbstractRuleResult;
use Pancoast\DataProcessor\Serializer\SerializerInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Outputter rule result sends the (serialized) $value to the outputter
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class OutputterRuleResult extends AbstractRuleResult
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var string
     */
    private $serializedFormat;

    /**
     * Constructor
     *
     * @param OutputInterface     $output
     * @param SerializerInterface $serializer
     * @param                     $serializedFormat
     */
    public function __construct(
        OutputInterface $output,
        SerializerInterface $serializer,
        $serializedFormat
    )
    {
        Util::validateType($serializedFormat, 'string', $serializedFormat);

        $this->output = $output;
        $this->serializer = $serializer;
        $this->serializedFormat = $serializedFormat;
    }

    /**
     * {@inheritdoc}
     */
    public function runResult($value)
    {
        $this->output->write($this->serializer->serialize($value, $this->serializedFormat));
    }
}
