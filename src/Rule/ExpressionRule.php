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
    private $exprLang;

    /**
     * @var string
     */
    private $expression;

    /**
     * @var string
     */
    private $expressionRoot;

    /**
     * Constructor
     *
     * @param ExpressionLanguage $expressionLanguage
     * @param string             $expressionRule
     * @param string             $expressionRoot
     */
    public function __construct(
        ExpressionLanguage $expressionLanguage,
        $expressionRule,
        $expressionRoot
    )
    {
        Util::validateType($expressionRule, 'string', '$expressionRule');
        Util::validateType($expressionRoot, 'string', '$expressionRoot');

        $this->exprLang = $expressionLanguage;
        $this->expression = $expressionRule;
        $this->expressionRoot = $expressionRoot;
    }

    /**
     * {@inheritdoc}
     */
    public function true($value)
    {
        return $this->exprLang->evaluate(
            $this->expression,
            [
                $this->expressionRoot => $value
            ]
        );
    }
}
