<?php

use App\Logic\Dsl\QueryExpressionParser;
use App\Models\Chat;
use App\Models\Memory;
use Illuminate\Database\Eloquent\Builder;

beforeEach(function () {
    $chat = Chat::factory()->create();

    Memory::factory()->for($chat)->create([
        'type' => 'note',
        'title' => 'With level',
        'meta' => ['level' => 7],
    ]);

    Memory::factory()->for($chat)->create([
        'type' => 'note',
        'title' => 'No level',
        'meta' => ['tags' => ['memo']],
    ]);
});

it('filters using "between" operator on json path', function () {
    $query = Memory::query();
    (new QueryExpressionParser())->apply($query, 'between(":meta.level", 5, 10)');
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query', 'dsl:between');

it('filters using "in range" operator on json path', function () {
    $query = Memory::query();
    (new QueryExpressionParser())->apply($query, '":meta.level" in 5..10');
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query', 'dsl:in', 'dsl:range');

it('filters with is_null operator', function () {
    $query = Memory::query();
    (new QueryExpressionParser())->apply($query, 'is_null(":meta.level")');
    expect($query->count())->toBe(1);
})->group('dsl', 'dsl-query', 'dsl:is_null');

it('filters with is_not_null operator', function () {
    $query = Memory::query();
    (new QueryExpressionParser())->apply($query, 'is_not_null(":meta.level")');
    expect($query->count())->toBe(1);
})->group('dsl', 'dsl-query', 'dsl:is_not_null');
