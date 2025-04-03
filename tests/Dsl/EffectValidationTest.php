<?php

use App\Logic\Effect\EffectValidator;

it('validates simple set and unset effects', function () {
    $effects = [
        ['set' => ['score' => 42, 'name' => 'player.name']],
        ['unset' => ['score', 'name']],
        ['validate' => ['score' => 'required|integer']],
    ];

    EffectValidator::validate($effects);
    expect(true)->toBe(true);
})->group('dsl', 'validation', 'effect', 'effect:set', 'effect:unset', 'effect:validate');

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
})->group('dsl', 'validate', 'effect', 'effect:if');

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
})->group('dsl', 'validate', 'effect', 'effect:if');

it('fails on unknown effect key', function () {
    EffectValidator::validate([['unknown' => ['foo' => 'bar']]]);
})->throws(InvalidArgumentException::class, 'Unknown effect type: [unknown]')
    ->group('dsl', 'validate', 'effect');

it('fails if missing then block in if', function () {
    EffectValidator::validate([['if' => ['condition' => 'true']]]);
})->throws(InvalidArgumentException::class, 'Validation failed in [if]:')
    ->group('dsl', 'validate', 'effect', 'effect:if');

it('fails if nested effect has validation error', function () {
    EffectValidator::validate([
        ['if' => [
            'condition' => 'true',
            'then' => [
                ['validate' => ['is', 'not', 'string']],
            ],
        ]],
    ]);
})->throws(InvalidArgumentException::class)
    ->group('dsl', 'validate', 'effect', 'effect:if');
