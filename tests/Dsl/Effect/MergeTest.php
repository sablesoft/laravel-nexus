<?php

use App\Logic\Effect\EffectValidator;
use App\Logic\Effect\Handlers\MergeHandler;
use App\Logic\Process;
use Illuminate\Validation\ValidationException;

it('validates merge with indexed and associative arrays', function () {
    $effects = [[
        'merge' => [
            'tags' => ['>>magic', '>>stealth'],
            'stats' => ['hp' => 10, 'mp' => 5],
        ]
    ]];

    EffectValidator::validate($effects);
    expect(true)->toBeTrue();
})->group('dsl', 'effect', 'effect-validate', 'effect:merge');

it('fails effect-validate if value is not provided', function () {
    $effects = [[
        'merge' => [
            'tags' => null
        ]
    ]];

    EffectValidator::validate($effects);
})->throws(InvalidArgumentException::class, 'Validation failed in [merge]:')
    ->group('dsl', 'effect', 'effect-validate', 'effect:merge');

it('merges indexed arrays correctly', function () {
    $process = new Process();
    $process->set('tags', ['existing']);

    $handler = new MergeHandler([
        'tags' => ['>>new']
    ]);

    $handler->execute($process);
    expect($process->get('tags'))->toBe(['existing', 'new']);
})->group('dsl', 'effect', 'effect-execute', 'effect:merge', 'process');

it('merges associative arrays correctly', function () {
    $process = new Process();
    $process->set('stats', ['hp' => 5]);

    $handler = new MergeHandler([
        'stats' => ['mp' => 10]
    ]);

    $handler->execute($process);
    expect($process->get('stats'))->toBe(['hp' => 5, 'mp' => 10]);
})->group('dsl', 'effect', 'effect-execute', 'effect:merge', 'process');

it('fails if target is not an array', function () {
    $process = new Process();
    $process->set('stats', 'not-an-array');

    $handler = new MergeHandler([
        'stats' => ['mp' => 10]
    ]);

    $handler->execute($process);
})->throws(RuntimeException::class, 'Cannot merge data to [stats]: value must be an array.')
    ->group('dsl', 'effect', 'effect-execute', 'effect:merge', 'process');

it('fails if array types do not match', function () {
    $process = new Process();
    $process->set('stats', ['hp' => 5]); // associative

    $handler = new MergeHandler([
        'stats' => ['>>speed'] // indexed
    ]);

    $handler->execute($process);
})->throws(RuntimeException::class, 'Cannot merge data to [stats]: array types do not match (indexed vs associative).')
    ->group('dsl', 'effect', 'effect-execute', 'effect:merge', 'process');

it('initializes path if not exists', function () {
    $process = new Process();

    $handler = new MergeHandler([
        'stats' => ['hp' => 5]
    ]);

    $handler->execute($process);
    expect($process->get('stats'))->toBe(['hp' => 5]);
})->group('dsl', 'effect', 'effect-execute', 'effect:merge', 'process');
