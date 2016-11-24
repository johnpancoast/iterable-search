<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor\Serializer;

use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\SerializerBuilder;
use Pancoast\DataProcessor\Serializer\Handler\CsvHandler;
use Pancoast\DataProcessor\Serializer\Handler\JsonHandler;
use Pancoast\DataProcessor\Serializer\Handler\XmlHandler;
use Pancoast\DataProcessor\Serializer\Handler\YamlHandler;

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
     * @return SerializerInterface
     */
    public static function createSerializer()
    {
        // allows JMS annotations on objects
        AnnotationRegistry::registerLoader('class_exists');

        $jmsSerializer = SerializerBuilder::create()->build();

        // loading things this way allows us to have a similar API to jms/serializer
        // but it allows us to "bolt-on" our csv functionality. jms/serializer
        // doesn't support csv and adding a handler within their boundaries wasn't
        // working. The other handlers delegate directly to jms/serializer.
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
