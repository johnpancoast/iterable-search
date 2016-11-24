<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       Public Domain
 */

namespace Pancoast\DataProcessor\Serializer\Handler;

/**
 * Json Handler
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class JsonHandler extends AbstractJmsHandler
{
    /**
     * {@inheritdoc}
     */
    public function getSupportedFormat()
    {
        return 'json';
    }
}
