<?php

namespace App\Logic\Validators;

use App\Logic\Contracts\DslValidatorContract;
use App\Logic\Dsl\QueryExpressionRegistry;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

class QueryExpressionValidator implements DslValidatorContract
{

    /**
     * @throws SyntaxError|RuntimeException
     */
    public static function validate(mixed $dsl): void
    {
        if (empty($dsl)) {
            return;
        }

        if (!is_string($dsl)) {
            throw new InvalidArgumentException("Query expression must be a string.");
        }

        $el = new ExpressionLanguage();
        QueryExpressionRegistry::register($el);
        $el->parse($dsl, self::allowedVariables());
    }

    protected static function allowedVariables(): array
    {
        // todo
        return [
            'screen', 'chat', 'application', 'character', 'mask',
            'characters', 'onlineCharacters', 'offlineCharacters'
        ];
    }
}
