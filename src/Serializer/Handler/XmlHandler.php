<?php
/**
 * @package       johnpancoast/code-challenge
 * @copyright (c) 2016 John Pancoast
 * @license       Public Domain
 */

namespace Pancoast\CodeChallenge\Serializer\Handler;

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
