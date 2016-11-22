<?php
/**
 * @package       johnpancoast/code-challenge
 * @copyright (c) 2016 John Pancoast
 * @license       Public Domain
 */

namespace Pancoast\CodeChallenge\Serializer;

use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\SerializerBuilder;
use Pancoast\CodeChallenge\Serializer\Handler\CsvHandler;
use Pancoast\CodeChallenge\Serializer\Handler\JsonHandler;
use Pancoast\CodeChallenge\Serializer\Handler\XmlHandler;
use Pancoast\CodeChallenge\Serializer\Handler\YamlHandler;

/**
 * Factory to create serializer
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class SerializerFactory
{
    /**
     * Create serializer
     *
     * @return \JMS\Serializer\Serializer
     */
    public static function createSerializer()
    {
        // allows JMS annotations on objects
        AnnotationRegistry::registerLoader('class_exists');

        $jmsSerializer = SerializerBuilder::create()->build();

        $serializer = new Serializer();
        $serializer->registerHandlers([
            new CsvHandler($jmsSerializer),
            new JsonHandler($jmsSerializer),
            new YamlHandler($jmsSerializer),
            new XmlHandler($jmsSerializer),
        ]);

        return $serializer;
    }
}