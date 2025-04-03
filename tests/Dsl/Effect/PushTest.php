<?php

use App\Logic\Effect\EffectValidator;
use App\Logic\Effect\Handlers\PushHandler;
use App\Logic\Process;
use Illuminate\Validation\ValidationException;

it('validates push with literals and expressions', function () {
    $effects = [[
        'push' => [
            'log.entries' => ['level' => '>>info', 'message' => '>>started'],
            'steps' => '>>first_step',
        ]
    ]];

    EffectValidator::validate($effects);
    expect(true)->toBeTrue();
})->group('dsl', 'effect-validate', 'effect', 'effect:push');

it('fails effect-validate if value is missing', function () {
    $effects = [[
        'push' => [
            'log.entries' => null
        ]
    ]];

    EffectValidator::validate($effects);
})->throws(InvalidArgumentException::class, 'Validation failed in [push]:')
    ->group('dsl', 'effect-validate', 'effect', 'effect:push');

it('fails at runtime if target is not an array', function () {
    $process = new Process();
    $process->set('log.entries', 'not-an-array');

    $handler = new PushHandler([
        'log.entries' => ['level' => '>>info']
    ]);

    $handler->execute($process);
})->throws(RuntimeException::class, 'Cannot push to [log.entries]: target is not an indexed array.')
    ->group('dsl', 'effect-execute', 'process', 'effect', 'effect:push');

it('fails at runtime if target is associative and value should be pushed into indexed array', function () {
    $process = new Process();
    $process->set('steps', ['name' => 'intro']);

    $handler = new PushHandler([
        'steps' => '>>next_step'
    ]);

    $handler->execute($process);
})->throws(RuntimeException::class, 'Cannot push to [steps]: target is not an indexed array.')
    ->group('dsl', 'effect-execute', 'process', 'effect', 'effect:push');

it('appends to new key if path is missing in process', function () {
    $process = new Process();

    $handler = new PushHandler([
        'events' => ['type' => '>>info']
    ]);

    $handler->execute($process);
    expect($process->get('events'))->toBe([['type' => 'info']]);
})->group('dsl', 'effect-execute', 'process', 'effect', 'effect:push');
