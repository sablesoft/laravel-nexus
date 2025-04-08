<?php

use App\Logic\Dsl\QueryExpressionParser;
use App\Models\Chat;
use App\Models\Memory;

beforeEach(function () {
    $chat = Chat::factory()->create();

    Memory::factory()->for($chat)->create([
        'type' => 'inventory',
        'title' => 'Nested Meta Item',
        'meta' => ['extra' => ['info' => ['tag' => 'special']]],
    ]);
});

it('resolves nested variable paths like screen.extra.info.tag', function () {
    $query = Memory::query();

    (new QueryExpressionParser())->apply(
        $query,
        '":meta.extra.info.tag" == screen.extra.info.tag',
        [
            'screen' => [
                'extra' => [
                    'info' => [
                        'tag' => 'special'
                    ]
                ]
            ]
        ]
    );

    expectQueryCount($query, 1);
})->group('dsl', 'dsl-query', 'dsl:eq', 'dsl:#>>');
