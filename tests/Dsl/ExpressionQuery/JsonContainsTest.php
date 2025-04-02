<?php

use App\Logic\Dsl\ExpressionQueryParser;
use App\Models\Chat;
use App\Models\Memory;

beforeEach(function () {
    $chat = Chat::factory()->create();

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Epic Sword',
        'meta' => ['tags' => ['epic', 'weapon'], 'attributes' => ['strength' => 12]],
    ]);

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Common Shield',
        'meta' => ['tags' => ['common', 'defense'], 'attributes' => ['defense' => 5]],
    ]);
});

it('filters with @>(contains) operator', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, '":meta" contains {"tags": ["epic", "weapon"]}');
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query');

it('filters with has operator', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'has(":meta.attributes", "strength")');
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query');

it('filters with has_any operator', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'has_any(":meta.tags", ["legendary", "epic"])');
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query');

it('filters with has_all operator', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'has_all(":meta.tags", ["epic", "weapon"])');
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query');
