<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser\Expression;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Expression lang factory
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class ExpressionLanguageFactory
{
    /**
     * Create and return an instance of expression lang
     *
     * @return ExpressionLanguage
     */
    public static function createInstance()
    {
        return new ExpressionLanguage(
            null,
            [
                new ExpressionLanguageProvider()
            ]
        );
    }
}
