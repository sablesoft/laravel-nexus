<?php

use App\Logic\Effect\EffectValidator;
use App\Logic\Effect\Handlers\PushHandler;
use Illuminate\Validation\ValidationException;

it('valid push effect with nested path and literal', function () {
    $effects = [[
        'push' => [
            'path' => '>>log.items',
            'value' => ['type' => '>>info', 'message' => '>>hello'],
        ]
    ]];

    EffectValidator::validate($effects);
    expect(true)->toBeTrue();
})->group('dsl', 'validation', 'effect', 'effect:push');

it('valid push with path to empty container list', function () {
    $effects = [[
        'push' => [
            'path' => 'steps_path',
            'value' => 'step.id'
        ]
    ]];

    EffectValidator::validate($effects);
    expect(true)->toBeTrue();
})->group('dsl', 'validation', 'effect', 'effect:push');

it('fails if path is missing', function () {
    $effects = [[
        'push' => [
            'value' => 'step.name'
        ]
    ]];

    EffectValidator::validate($effects);
})->throws(InvalidArgumentException::class, 'The path field is required.')
  ->group('dsl', 'validation', 'effect', 'effect:push');

it('fails if value is missing', function () {
    $effects = [[
        'push' => [
            'path' => 'queue.items'
        ]
    ]];

    EffectValidator::validate($effects);
})->throws(InvalidArgumentException::class, 'The value field is required.')
  ->group('dsl', 'validation', 'effect', 'effect:push');

it('fails at runtime if target is not a list', function () {
    $process = new \App\Logic\Process();
    $process->set('log.items', ['type' => 'not-list']);

    $handler = new PushHandler([
        'path' => '>>log.items',
        'value' => ['foo' => '>>bar']
    ]);

    $handler->execute($process);
})->throws(RuntimeException::class, 'Cannot push to [log.items]: value must be an indexed array.')
  ->group('dsl', 'effect', 'process', 'effect:push');
