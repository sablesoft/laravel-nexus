<?php

use App\Logic\Dsl\ExpressionQueryParser;
use App\Models\Chat;
use App\Models\Memory;

beforeEach(function () {
    $chat = Chat::factory()->create();

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Fire Sword',
        'meta' => [
            'tags' => ['fire', 'weapon'],
        ],
    ]);

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Water Shield',
        'meta' => [
            'tags' => ['water', 'defense'],
        ],
    ]);

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Dual Blade',
        'meta' => [
            'tags' => ['fire', 'water'],
        ],
    ]);

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Basic Torch',
        'meta' => [
            'tags' => ['fire'],
        ],
    ]);
});


it('filters with @>(contains) against array of tags', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, '":meta.tags" contains ["fire"]');
    expectQueryCount($query, 3);
})->group('dsl', 'dsl-query', 'dsl:contains');

it('filters where tags array equals exactly one value', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, '":meta.tags" == ["fire"]');
    expectQueryCount($query, 1); // Only Basic Torch
})->group('dsl', 'dsl-query', 'dsl:eq');

it('filters with has on json array (not key)', function () {
    // PostgreSQL: 'tags' ? 'fire' works even if tags is array
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'has(":meta.tags", "defense")');
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query', 'dsl:has');

it('filters with has_any on array of tags', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'has_any(":meta.tags", ["fire", "defense"])');
    expectQueryCount($query, 4); // Fire Sword, Water Shield, Dual Blade, Basic Torch
})->group('dsl', 'dsl-query', 'dsl:has_any');

it('filters with has_all on array of tags', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'has_all(":meta.tags", ["fire", "weapon"])');
    expectQueryCount($query, 1); // Only Fire Sword
})->group('dsl', 'dsl-query', 'dsl:has_all');

it('filters with has_all requiring both fire and water', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'has_all(":meta.tags", ["fire", "water"])');
    expectQueryCount($query, 1); // Only Dual Blade
})->group('dsl', 'dsl-query', 'dsl:has_all');

it('filters with has_all that returns nothing', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'has_all(":meta.tags", ["fire", "ice"])');
    expectQueryCount($query, 0);
})->group('dsl', 'dsl-query', 'dsl:has_all');
