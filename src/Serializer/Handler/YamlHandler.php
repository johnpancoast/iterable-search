<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor\Serializer\Handler;

/**
 * Yaml Handler
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class YamlHandler extends AbstractJmsHandler
{
    /**
     * {@inheritdoc}
     */
    public function getSupportedFormat()
    {
        return 'yaml';
    }
}
