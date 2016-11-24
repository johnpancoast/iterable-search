<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor\Serializer\Handler;

/**
 * Xml Handler
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class XmlHandler extends AbstractJmsHandler
{
    /**
     * {@inheritdoc}
     */
    public function getSupportedFormat()
    {
        return 'xml';
    }
}
