<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser\Expression;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * Expression lang provider
 *
 * Currently used to add callable functions for end user of expression lang.
 *
 * @author John Pancoast <johnpancoast.tech@gmail.com>
 */
class ExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions()
    {
        return [
            new ExpressionFunction(
                'len',
                function($str){
                    return $str;
                },
                function($arguments, $str){
                    if (!is_string($str)) {
                        return $str;
                    }

                    return strlen($str);
                }
            ),
        ];
    }
}
