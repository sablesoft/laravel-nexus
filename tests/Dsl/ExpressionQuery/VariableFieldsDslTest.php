<?php

use App\Logic\Dsl\ExpressionQueryParser;
use App\Models\Chat;
use App\Models\Memory;

beforeEach(function () {
    $chat = Chat::factory()->create();

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Epic Sword',
        'meta' => ['tags' => ['epic', 'weapon'], 'level' => 10],
    ]);

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Common Shield',
        'meta' => ['tags' => ['common', 'defense'], 'level' => 3],
    ]);

    Memory::factory()->for($chat)->create([
        'type' => 'quest',
        'title' => 'Find the Blade',
        'meta' => ['tags' => ['epic', 'quest'], 'level' => 7],
    ]);
});

it('filters by variable used as field name (root field)', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'field == "inventory"', ['field' => 'type']);
    expectQueryCount($query, 2);
})->group('dsl', 'dsl-query');

it('filters by variable used as json field name', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'field > 5', ['field' => 'meta.level']);
    expectQueryCount($query, 2);
})->group('dsl', 'dsl-query');

it('filters using variable as json field with contains operator', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'field contains ["epic"]', ['field' => 'meta.tags']);
    expectQueryCount($query, 2);
})->group('dsl', 'dsl-query');

it('filters using variable as field compared to another variable', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'field == value', ['field' => 'type', 'value' => 'quest']);
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query');

it('filters using json field with contains object using field as variable', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'field contains data', [
        'field' => 'meta',
        'data' => ['tags' => ['epic', 'weapon']]
    ]);
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query');

it('filters using json field path through variable and range', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'field in 5..10', ['field' => 'meta.level']);
    expectQueryCount($query, 2);
})->group('dsl', 'dsl-query');
