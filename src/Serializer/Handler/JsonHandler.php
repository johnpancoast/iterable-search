<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser\Serializer\Handler;

use Pancoast\IterableParser\Serializer\Format;

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
        return Format::JSON;
    }
}
