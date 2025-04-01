<?php

use App\Logic\Effect\EffectValidator;
use Illuminate\Validation\ValidationException;

it('passes with no parameters (refresh all)', function () {
    EffectValidator::validate([
        ['chat.refresh' => null],
    ]);
    expect(true)->toBeTrue();
})->group('dsl', 'logic', 'effect', 'refresh');

it('passes with list of screen codes', function () {
    EffectValidator::validate([
        ['chat.refresh' => ['>>main', '>>lobby']],
    ]);
    expect(true)->toBeTrue();
})->group('dsl', 'logic', 'effect', 'refresh');

it('fails with boolean true', function () {
    EffectValidator::validate([
        ['chat.refresh' => true],
    ]);
})->throws(InvalidArgumentException::class)
    ->group('dsl', 'logic', 'effect', 'refresh');

it('fails with invalid parameter type (object)', function () {
    EffectValidator::validate([
        ['chat.refresh' => (object) ['invalid' => 'structure']],
    ]);
})->throws(InvalidArgumentException::class)
->group('dsl', 'logic', 'effect', 'refresh');

it('fails with non-string screen code', function () {
    EffectValidator::validate([
        ['chat.refresh' => [123, '>>main']],
    ]);
})->throws(InvalidArgumentException::class)
    ->group('dsl', 'logic', 'effect', 'refresh');
