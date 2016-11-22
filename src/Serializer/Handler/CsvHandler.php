<?php
/**
 * @package       johnpancoast/code-challenge
 * @copyright (c) 2016 John Pancoast
 * @license       Public Domain
 */

namespace Pancoast\CodeChallenge\Serializer\Handler;

use JMS\Serializer\SerializerInterface;

/**
 * Csv Handler
 *
 * Note that handling CSVs in jms/serializer is not supported so we had to wrap it and handle ourselves
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class CsvHandler extends AbstractJmsHandler
{
    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var string
     */
    private $enclosure;

    /**
     * @var string
     */
    private $escape;

    const DEFAULT_DELIMITER = ',';
    const DEFAULT_ENCLOSURE = '"';
    const DEFAULT_ESCAPE = '\\';

    /**
     * Constructor
     *
     * @param SerializerInterface $jmsSerializer
     * @param string              $delimiter
     * @param string              $enclosure
     * @param string              $escape
     */
    public function __construct(
        SerializerInterface $jmsSerializer,
        $delimiter = self::DEFAULT_DELIMITER,
        $enclosure = self::DEFAULT_ENCLOSURE,
        $escape = self::DEFAULT_ESCAPE
    )
    {
        parent::__construct($jmsSerializer);

        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escape = $escape;
    }

    /**
     * Given an array, create a csv line using a function similar to PHP's str_getcsv() signature and functionality.
     *
     * @param        $input
     *
     * @return string
     */
    private function strPutCsv($input) {
        // TODO - fix if suboptimal, we're testing
        $fp = fopen('php://memory', 'r+b');
        rewind($fp);
        fputcsv($fp, $input, $this->delimiter, $this->enclosure, $this->escape);
        $data = rtrim(stream_get_contents($fp), "\n");
        fclose($fp);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedFormat()
    {
        return 'csv';
    }

    /**
     * {@inheritdoc}
     */
    public function serialize($data, $format)
    {
        if (is_object($data)) {
            $data = $this->jmsSerializer->toArray($data);
        }

        return $this->strPutCsv($data);
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize($data, $type, $format)
    {
        return $this->jmsSerializer->fromArray(
            str_getcsv(
                $data,
                $this->delimiter,
                $this->enclosure,
                $this->escape
            )
        , $type);
    }
}
