<?php

use App\Logic\Dsl\ExpressionQueryParser;
use App\Models\Chat;
use App\Models\Memory;

beforeEach(function () {
    $chat = Chat::factory()->create();

    Memory::factory()->for($chat)->create([
        'type' => 'note',
        'title' => 'Reminder',
        'meta' => ['level' => 1],
    ]);

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Scroll of Power',
        'meta' => ['level' => 5, 'rarity' => 'rare'],
    ]);
});

it('filters using equality operator', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, '":type" == "note"');
    expect($query->count())->toBe(1);
})->group('dsl', 'dsl-query');

it('filters using in operator', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, '":type" in ["note", "inventory"]');
    expect($query->count())->toBe(2);
})->group('dsl', 'dsl-query');

it('filters using like operator', function () {
    $query = Memory::query();
    (new ExpressionQueryParser())->apply($query, 'like(":title", "%Scroll%")');
    expect($query->count())->toBe(1);
})->group('dsl', 'dsl-query');
