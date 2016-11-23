<?php
/**
 * @package       johnpancoast/code-challenge
 * @copyright (c) 2016 John Pancoast
 * @license       Public Domain
 */

namespace Pancoast\CodeChallenge;

/**
 * Helper util
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class Util
{
    /**
     * Simple helper to check if value is of type
     *
     * @param $value
     * @param $type
     *
     * @return bool
     */
    public static function isType($value, $type)
    {
        switch ($type) {
            case 'bool':
                return is_bool($value);
            case 'int':
                return is_int($value);
            case 'string':
                return is_string($value);
        }
    }

    /**
     * Helper to validate that a value for a field is of a cerain type
     *
     * @param mixed $value
     * @param mixed $type
     * @param null $field
     *
     * @throws \InvalidArgumentException If value not expected type
     */
    public static function validateType($value, $type, $field = null)
    {
        if (!self::isType($value, $type)) {
            if ($field) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Expected type %s for "%s". Received value "%s".',
                        $type,
                        $field,
                        $value
                    )
                );
            } else {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Expected type %s. Received value "%s".',
                        $type,
                        $value
                    )
                );
            }
        }
    }
}
