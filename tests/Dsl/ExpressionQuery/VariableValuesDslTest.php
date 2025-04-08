<?php

use App\Logic\Dsl\QueryExpressionParser;
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
        'type' => 'inventory',
        'title' => 'Dual Blade',
        'meta' => ['tags' => ['rare', 'weapon'], 'level' => 7],
    ]);
});

it('filters by variable in root field', function () {
    $query = Memory::query();
    (new QueryExpressionParser())->apply($query, '":type" == selectedType', ['selectedType' => 'inventory']);
    expectQueryCount($query, 3);
})->group('dsl', 'dsl-query', 'dsl:eq');

it('filters by variable in json field', function () {
    $query = Memory::query();
    (new QueryExpressionParser())->apply($query, '":meta.level" > minLevel', ['minLevel' => 5]);
    expectQueryCount($query, 2);
})->group('dsl', 'dsl-query', 'dsl:gt');

it('filters with variable in json tag array (contains)', function () {
    $query = Memory::query();
    (new QueryExpressionParser())->apply($query, '":meta.tags" contains [tag]', ['tag' => 'weapon']);
    expectQueryCount($query, 2);
})->group('dsl', 'dsl-query', 'dsl:contains');

it('filters with variable for full json contains object', function () {
    $query = Memory::query();
    (new QueryExpressionParser())->apply($query, '":meta" contains expectedMeta', ['expectedMeta' => ['tags' => ['epic', 'weapon']]]);
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query', 'dsl:contains');

it('filters with mixed variables and literals', function () {
    $query = Memory::query();
    (new QueryExpressionParser())->apply($query, '":meta.level" >= min and ":meta.level" <= max', ['min' => 5, 'max' => 10]);
    expectQueryCount($query, 2);
})->group('dsl', 'dsl-query', 'dsl:gte', 'dsl:and', 'dsl:lte');
