<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor\Rule;

use Pancoast\DataProcessor\Expression\ExpressionLanguageProvider;
use Pancoast\DataProcessor\RuleInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * A rule for symfony/expression-language.
 *
 * @see http://symfony.com/doc/current/components/expression_language.html
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class ExpressionRule implements RuleInterface
{
    private $rule;
    private $el;
    private $baseName;

    public function __construct($rule, $baseName)
    {
        // TODO inject me
        $this->el = new ExpressionLanguage(
            null,
            [
                new ExpressionLanguageProvider(),
            ]
        );

        $this->rule = $rule;
        $this->baseName = $baseName;
    }

    public function passes($value)
    {
        return $this->el->evaluate(
            $this->rule,
            [
                $this->baseName => $value
            ]
        );
    }
}
