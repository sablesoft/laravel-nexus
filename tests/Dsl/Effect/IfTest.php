<?php

use App\Logic\Effect\EffectValidator;

it('validates if effect with nested then and else', function () {
    $effects = [
        ['if' => [
            'condition' => 'score > 10',
            'then' => [
                ['set' => ['flag' => true]],
            ],
            'else' => [
                ['unset' => ['flag']],
            ],
        ]],
    ];

    EffectValidator::validate($effects);
    expect(true)->toBe(true);
})->group('dsl', 'effect-validate', 'effect', 'effect:if');

it('fails if missing then block in if', function () {
    EffectValidator::validate([['if' => ['condition' => 'true']]]);
})->throws(InvalidArgumentException::class, 'Validation failed in [if]:')
    ->group('dsl', 'effect-validate', 'effect', 'effect:if');

it('fails if nested effect has effect-validate error', function () {
    EffectValidator::validate([
        ['if' => [
            'condition' => 'true',
            'then' => [
                ['validate' => ['is', 'not', 'string']],
            ],
        ]],
    ]);
})->throws(InvalidArgumentException::class)
    ->group('dsl', 'effect-validate', 'effect', 'effect:if');

it('validates nested if inside then', function () {
    $effects = [
        ['if' => [
            'condition' => 'lives > 0',
            'then' => [
                ['if' => [
                    'condition' => 'score > 100',
                    'then' => [['set' => ['rank' => '>>elite']]],
                ]],
            ],
        ]],
    ];

    EffectValidator::validate($effects);
    expect(true)->toBe(true);
})->group('dsl', 'effect-validate', 'effect', 'effect:if');
