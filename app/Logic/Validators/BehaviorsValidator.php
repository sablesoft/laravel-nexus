<?php

namespace App\Logic\Validators;

use App\Logic\Act;
use App\Logic\Contracts\DslValidatorContract;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class BehaviorsValidator implements DslValidatorContract
{
    public static function validate(mixed $dsl): void
    {
        if (empty($dsl)) {
            return;
        }

        if (!is_array($dsl)) {
            throw new InvalidArgumentException("Behaviors must be an array.");
        }

        if (!array_key_exists('can', $dsl)) {
            throw new InvalidArgumentException("Behaviors must contain a 'can' root block.");
        }

        $behaviors = $dsl['can'];
        if (!is_array($behaviors) || array_is_list($behaviors)) {
            throw new InvalidArgumentException("The 'can' block must be an associative array.");
        }

        $allowedKeys = self::allowedTopKeys();

        foreach ($behaviors as $name => $config) {
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_.]*$/', $name)) {
                throw new InvalidArgumentException("Invalid behavior name: '{$name}'. Use variable-like keys.");
            }

            if (!is_array($config) || array_is_list($config)) {
                throw new InvalidArgumentException("Behavior '{$name}' must have an associative config.");
            }

            // check for unknown top-level keys
            $unknownKeys = array_diff(array_keys($config), $allowedKeys);
            if ($unknownKeys) {
                throw new InvalidArgumentException("Behavior '{$name}' has unknown keys: " . implode(', ', $unknownKeys));
            }

            // validate content
            $validator = Validator::make($config, self::configRules());
            if ($validator->fails()) {
                throw new InvalidArgumentException("Behavior '{$name}' is invalid: " . $validator->errors()->first());
            }

            // validate condition manually
            if (isset($config['condition']) && !self::isValidCondition($config['condition'])) {
                throw new InvalidArgumentException("Behavior '{$name}' has invalid 'condition'. It must be a DSL string or boolean.");
            }

            // validate merge subkeys
            if (isset($config['merge']) && is_array($config['merge'])) {
                $allowedMergeKeys = ['common', 'role'];
                $unknownMergeKeys = array_diff(array_keys($config['merge']), $allowedMergeKeys);
                if ($unknownMergeKeys) {
                    throw new InvalidArgumentException("Behavior '{$name}' has unknown merge keys: " . implode(', ', $unknownMergeKeys));
                }
            }

            // validate string form of merge
            if (isset($config['merge']) && is_string($config['merge'])) {
                if (!in_array($config['merge'], ['replace', 'and', 'or'])) {
                    throw new InvalidArgumentException("Behavior '{$name}' has invalid merge strategy '{$config['merge']}'.");
                }
            }
        }
    }

    protected static function configRules(): array
    {
        $propertyRules = [];
        foreach (Act::propertyKeys() as $property) {
            $propertyRules[$property] = ['sometimes', 'string'];
        }

        return array_merge([
            'description'   => ['sometimes', 'string'],
            'condition'     => ['sometimes'], // validated manually
            'merge'         => ['sometimes'],
            'merge.common'  => ['sometimes', 'in:replace,and,or'],
            'merge.role'    => ['sometimes', 'in:replace,and,or'],
        ], $propertyRules);
    }

    protected static function allowedTopKeys(): array
    {
        $ruleKeys = array_keys(self::configRules());
        return array_unique(array_map(fn($k) => explode('.', $k)[0], $ruleKeys));
    }

    /**
     * todo
     */
    protected static function isValidCondition(mixed $condition): bool
    {
        return is_bool($condition) || is_string($condition);
    }
}
