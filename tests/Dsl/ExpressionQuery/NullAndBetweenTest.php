<?php

use App\Logic\Dsl\ExpressionQueryParser;
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

function expectQueryCount(Builder $query, int $count): void {
    if ($query->count() !== $count) {
        dump($query->toSql(), $query->getBindings());
    }
    expect($query->count())->toBe($count);
};

it('filters using "between" operator on json path', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'between(":meta.level", 5, 10)');
    expectQueryCount($query, 1);
});

it('filters using "in range" operator on json path', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, '":meta.level" in 5..10');
    expectQueryCount($query, 1);
});

it('filters with is_null operator', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'is_null(":meta.level")');
    expect($query->count())->toBe(1);
});

it('filters with is_not_null operator', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'is_not_null(":meta.level")');
    expect($query->count())->toBe(1);
});
