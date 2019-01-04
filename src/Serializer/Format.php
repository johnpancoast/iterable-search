<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser\Serializer;

/**
 * Formats
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class Format
{
    const CSV = 'csv';
    const JSON = 'json';
    const XML = 'xml';

    /**
     * Get formats
     *
     * @return array
     */
    public static function getFormats()
    {
        return [
            self::CSV,
            self::JSON,
            self::XML
        ];
    }
}
