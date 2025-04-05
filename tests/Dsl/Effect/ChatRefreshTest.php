<?php

use App\Logic\Validators\EffectsValidator;

it('passes with no parameters (refresh all)', function () {
    EffectsValidator::validate([
        ['chat.refresh' => null],
    ]);
    expect(true)->toBeTrue();
})->group('dsl', 'effect-validate', 'effect', 'effect:chat.refresh');

it('passes with list of screen codes', function () {
    EffectsValidator::validate([
        ['chat.refresh' => ['>>main', '>>lobby']],
    ]);
    expect(true)->toBeTrue();
})->group('dsl', 'effect-validate', 'effect', 'effect:chat.refresh');

it('fails with boolean true', function () {
    EffectsValidator::validate([
        ['chat.refresh' => true],
    ]);
})->throws(InvalidArgumentException::class)
    ->group('dsl', 'effect-validate', 'effect', 'effect:chat.refresh');

it('fails with invalid parameter type (object)', function () {
    EffectsValidator::validate([
        ['chat.refresh' => (object) ['invalid' => 'structure']],
    ]);
})->throws(InvalidArgumentException::class)
->group('dsl', 'effect-validate', 'effect', 'effect:chat.refresh');

it('fails with non-string screen code', function () {
    EffectsValidator::validate([
        ['chat.refresh' => [123, '>>main']],
    ]);
})->throws(InvalidArgumentException::class)
    ->group('dsl', 'effect-validate', 'effect', 'effect:chat.refresh');
