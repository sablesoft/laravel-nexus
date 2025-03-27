<?php

use App\Logic\Dsl\ExpressionQueryParser;
use App\Models\Memory;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    DB::table('app.memories')->truncate();

    Memory::create([
        'chat_id' => 1,
        'type' => 'inventory',
        'title' => 'Magic Ring',
        'meta' => ['level' => 10, 'rarity' => 'epic', 'tags' => ['quest'], 'attributes' => ['strength' => 15]]
    ]);

    Memory::create([
        'chat_id' => 2,
        'type' => 'note',
        'title' => 'Old Scroll',
        'meta' => ['level' => 2, 'rarity' => 'common']
    ]);

    Memory::create([
        'chat_id' => 3,
        'type' => 'inventory',
        'title' => 'Iron Sword',
        'meta' => ['level' => 12, 'rarity' => 'legendary']
    ]);
});

it('filters using simple equality', function () {
    $count = (new ExpressionQueryParser)
        ->apply(Memory::query(), '":type" == "inventory"')
        ->count();

    expect($count)->toBe(2);
});

it('filters using in operator', function () {
    $count = (new ExpressionQueryParser)
        ->apply(Memory::query(), 'in(":type", ["inventory", "note"])')
        ->count();

    expect($count)->toBe(3);
});

it('filters using not_in operator', function () {
    $count = (new ExpressionQueryParser)
        ->apply(Memory::query(), 'not_in(":type", ["note"])')
        ->count();

    expect($count)->toBe(2);
});

it('filters using json field access', function () {
    $count = (new ExpressionQueryParser)
        ->apply(Memory::query(), '":meta.level" > 5')
        ->count();

    expect($count)->toBe(2);
});

it('filters with and/or logic', function () {
    $count = (new ExpressionQueryParser)
        ->apply(Memory::query(), '":type" == "inventory" and ":meta.level" >= 10')
        ->count();

    expect($count)->toBe(2);
});

it('filters using like', function () {
    $count = (new ExpressionQueryParser)
        ->apply(Memory::query(), 'like(":title", "%Ring%")')
        ->count();

    expect($count)->toBe(1);
});

it('filters using ilike', function () {
    $count = (new ExpressionQueryParser)
        ->apply(Memory::query(), 'ilike(":title", "%scroll%")')
        ->count();

    expect($count)->toBe(1);
});

it('filters using between', function () {
    $count = (new ExpressionQueryParser)
        ->apply(Memory::query(), 'between(":meta.level", 1, 10)')
        ->count();

    expect($count)->toBe(2);
});

it('filters using json nested path', function () {
    $count = (new ExpressionQueryParser)
        ->apply(Memory::query(), '":meta.attributes.strength" >= 15')
        ->count();

    expect($count)->toBe(1);
});
