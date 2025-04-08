<?php

use App\Logic\Dsl\QueryExpressionParser;
use App\Models\Chat;
use App\Models\Memory;

beforeEach(function () {
    $chat = Chat::factory()->create();

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Epic Sword',
        'meta' => ['attributes' => ['strength' => 15]],
    ]);
});

it('filters using nested json path with #>>', function () {
    $query = Memory::query();
    (new QueryExpressionParser())->apply($query, '":meta.attributes.strength" >= 10');
    expect($query->count())->toBe(1);
})->group('dsl', 'dsl-query', 'dsl:gte', 'dsl:#>>');
