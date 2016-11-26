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
    private $expLang;

    /**
     * @var string
     */
    private $expression;

    /**
     * @var string
     */
    private $dataRoot;

    /**
     * Constructor
     *
     * @param ExpressionLanguage $expressionLanguage
     * @param string             $expressionRule
     * @param string             $dataRoot
     */
    public function __construct(
        ExpressionLanguage $expressionLanguage,
        $expressionRule,
        $dataRoot
    )
    {
        Util::validateType($expressionRule, 'string', '$expressionRule');
        Util::validateType($dataRoot, 'string', '$baseName');

        $this->expLang = $expressionLanguage;
        $this->expression = $expressionRule;
        $this->dataRoot = $dataRoot;
    }

    /**
     * {@inheritdoc}
     */
    public function true($value)
    {
        return $this->expLang->evaluate(
            $this->expression,
            [
                $this->dataRoot => $value
            ]
        );
    }
}
