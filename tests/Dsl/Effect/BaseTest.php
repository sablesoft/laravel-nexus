<?php

use App\Logic\Effect\Handlers\SetHandler;
use App\Logic\Process;
use App\Logic\Validators\EffectsValidator;

it('validates simple set and unset effects', function () {
    $effects = [
        ['set' => ['score' => 42, 'name' => '>>player.name']],
        ['set' => ['score' => 42, '!name' => 'player.name']],
        ['unset' => ['score', 'name']],
        ['validate' => ['score' => 'required|integer']],
    ];

    EffectsValidator::validate($effects);
    expect(true)->toBe(true);
})->group('dsl', 'dsl-raw', 'effect-validate', 'effect', 'effect:set', 'effect:unset', 'effect:validate');

it('fails on unknown effect key', function () {
    EffectsValidator::validate([['unknown' => ['foo' => 'bar']]]);
})->throws(InvalidArgumentException::class, 'Unknown effect type: [unknown]')
    ->group('dsl', 'effect-validate', 'effect');

it('executes set with raw key and skips value resolution', function () {
    $process = new Process();

    $handler = new SetHandler(['!title' => 'call.title']);
    $handler->execute($process);

    expect($process->get('title'))->toBe('call.title');
})->group('dsl', 'effect', 'effect-execute', 'effect:set', 'dsl-raw');
