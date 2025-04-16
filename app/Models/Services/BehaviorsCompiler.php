<?php

namespace App\Models\Services;

use App\Models\Character;
use InvalidArgumentException;

class BehaviorsCompiler
{
    public function compile(Character $character): array
    {
        $chat = $character->chat;
        $compiled = [];

        $base = $chat->behaviors['can'] ?? [];
        foreach ($base as $verb => $config) {
            $compiled[$verb] = $config;
        }

        $roleBehaviors = [];
        foreach ($character->roles as $role) {
            foreach ($role->behaviors['can'] ?? [] as $verb => $config) {
                $roleBehaviors[$verb][] = $config;
            }
        }

        foreach ($roleBehaviors as $verb => $variants) {
            $hasCommon = array_key_exists($verb, $compiled);
            $baseConfig = $compiled[$verb] ?? null;

            $merged = $this->mergeRoleVariants($variants, $verb);

            if ($hasCommon) {
                $merged = $this->mergeCommonAndRole($baseConfig, $merged, $verb);
            }

            $compiled[$verb] = $merged;
        }

        return ['can' => $compiled];
    }

    public function save(Character $character): void
    {
        $character->behaviors = $this->compile($character);
        $character->save();
    }

    protected function mergeRoleVariants(array $configs, string $verb): array
    {
        $strategies = array_filter(array_map(fn($c) => $c['merge']['role'] ?? null, $configs));

        if (in_array('replace', $strategies)) {
            $replaces = array_filter($configs, fn($c) => ($c['merge']['role'] ?? null) === 'replace');
            if (count($replaces) > 1) {
                throw new InvalidArgumentException("Conflicting 'replace' merge.role strategies for '{$verb}'.");
            }
            return reset($replaces);
        }

        $strategies = array_unique($strategies);
        if (count($strategies) > 1) {
            throw new InvalidArgumentException("Conflicting merge.role strategies for '{$verb}'.");
        }

        $strategy = $strategies[0] ?? 'or';
        $merged = $configs[0];

        foreach (array_slice($configs, 1) as $config) {
            $merged['condition'] = $this->combineConditions($merged['condition'] ?? true, $config['condition'] ?? true, $strategy);
            $merged['description'] = $this->combineText($merged['description'] ?? '', $config['description'] ?? '', $strategy);
            foreach (['target', 'stuff', 'modifiers'] as $key) {
                if (!isset($merged[$key]) && isset($config[$key])) {
                    $merged[$key] = $config[$key];
                }
            }
        }

        return $merged;
    }

    protected function mergeCommonAndRole(array $common, array $role, string $verb): array
    {
        $strategy = $role['merge']['common'] ?? 'or';

        if (($role['merge']['common'] ?? null) === 'replace') {
            return $role;
        }

        $merged = $role;
        $merged['condition'] = $this->combineConditions($common['condition'] ?? true, $role['condition'] ?? true, $strategy);
        $merged['description'] = $common['description'] ?? $role['description'] ?? '';

        foreach (['target', 'stuff', 'modifiers'] as $key) {
            $merged[$key] = $common[$key] ?? $role[$key] ?? null;
        }

        return $merged;
    }

    protected function combineConditions(mixed $a, mixed $b, string $strategy): string
    {
        $a = is_bool($a) ? ($a ? 'true' : 'false') : $a;
        $b = is_bool($b) ? ($b ? 'true' : 'false') : $b;

        return "dsl(({$a}) {$strategy} ({$b}))";
    }

    protected function combineText(string $a, string $b, string $strategy): string
    {
        if (trim($a) === trim($b) || $b === '') return $a;
        if ($a === '') return $b;

        return $a . ' / ' . $b;
    }
}
