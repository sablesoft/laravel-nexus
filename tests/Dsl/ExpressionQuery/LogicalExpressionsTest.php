<?php

use App\Logic\Dsl\ExpressionQueryParser;
use App\Models\Chat;
use App\Models\Memory;

beforeEach(function () {
    $chat = Chat::factory()->create();

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Magic Ring',
        'meta' => ['level' => 10, 'rarity' => 'epic'],
    ]);

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Old Scroll',
        'meta' => ['level' => 3, 'rarity' => 'common'],
    ]);
});

it('filters with AND condition', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, '":type" == "inventory" and ":meta.level" > 5');
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query');

it('filters with OR condition', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, '":meta.rarity" == "epic" or ":meta.rarity" == "common"');
    expectQueryCount($query, 2);
})->group('dsl', 'dsl-query');

it('filters with nested logic using parentheses', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, '(":type" == "inventory" and ":meta.level" > 5) or ":meta.rarity" == "common"');
    expectQueryCount($query, 2);
})->group('dsl', 'dsl-query');

it('filters using NOT expression', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'not (":meta.rarity" == "common")');
    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query');
