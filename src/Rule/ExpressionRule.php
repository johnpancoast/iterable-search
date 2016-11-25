<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor\Rule;

use Pancoast\Common\Util\Util;
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
    /**
     * @var ExpressionLanguage
     */
    private $exlang;

    /**
     * @var string
     */
    private $expression;

    /**
     * @var string
     */
    private $baseName;

    /**
     * Constructor
     *
     * @param ExpressionLanguage $expressionLanguage
     * @param string             $expressionRule
     * @param string             $baseName
     */
    public function __construct(
        ExpressionLanguage $expressionLanguage,
        $expressionRule,
        $baseName
    )
    {
        Util::validateType($expressionRule, 'string', '$expressionRule');
        Util::validateType($baseName, 'string', '$baseName');

        $this->exlang = $expressionLanguage;
        $this->expression = $expressionRule;
        $this->baseName = $baseName;
    }

    /**
     * {@inheritdoc}
     */
    public function true($value)
    {
        return $this->exlang->evaluate(
            $this->expression,
            [
                $this->baseName => $value
            ]
        );
    }
}
