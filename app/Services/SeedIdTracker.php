<?php

namespace App\Services;

class SeedIdTracker
{
    protected static array $map = [];

    protected static array $keysMap = [
        'app.masks.portrait_id' => 'image',
        'app.transfers.screen_from_id' => 'screen',
        'app.transfers.screen_to_id' => 'screen',
        'app.steps.parent_id' => 'scenario',
        'App\\Models\\Step.noteable_id' => 'steps',
        'App\\Models\\Screen.noteable_id' => 'screens',
        'App\\Models\\Transfer.noteable_id' => 'transfers',
        'App\\Models\\Scenario.noteable_id' => 'scenarios',
    ];

    protected static array $morphTables = [
        'app.note_usages' => 'noteable_type'
    ];

    public static function guessTableFromKey(string $key, \stdClass $row, string $table): string
    {
        $prefix = $table;
        if (array_key_exists($table, self::$morphTables)) {
            $field = self::$morphTables[$table];
            $prefix = $row->$field;
        }
        $name = array_key_exists("$prefix.$key", self::$keysMap) ?
            self::$keysMap["$prefix.$key"] :
            str_replace('_id', '', $key);
        if ($key === 'user_id') {
            $name = 'public.users';
        }

        return str_contains($name, '.') ? $name : "app.$name" . (str_ends_with($name, 's') ? '' : 's');
    }

    public static function resolveForeignKeys(\stdClass &$row, string $table): void
    {
        foreach ($row as $key => $value) {
            if (!str_ends_with($key, '_id') || !is_numeric($value)) {
                continue;
            }

            $relatedTable = self::guessTableFromKey($key, $row, $table);

//            dump("SEED FK [$table] field=$key, value=$value → relatedTable=$relatedTable");

            if (self::has($relatedTable, $value)) {
                $newValue = self::resolve($relatedTable, $value);
//                dump("SEED RESOLVED [$table] $key: $value → $newValue");
                $row->$key = $newValue;
            } else {
                dump("SEED NOT FOUND [$table] $key: $value (relatedTable=$relatedTable)");
            }
        }
    }

    public static function remember(string $table, int|string $oldId, int|string $newId): void
    {
//        dump("SEED remember [$table] $oldId → $newId");
        self::$map[$table][(int) $oldId] = (int) $newId;
    }

    public static function resolve(string $table, int|string $oldId): int
    {
        return self::$map[$table][(int) $oldId] ?? (int) $oldId;
    }

    public static function has(string $table, int $oldId): bool
    {
        return isset(self::$map[$table][$oldId]);
    }

    public static function reset(): void
    {
        self::$map = [];
    }

    public static function all(): array
    {
        return self::$map;
    }
}
