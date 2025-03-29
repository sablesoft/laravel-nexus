<?php /** @noinspection PhpInternalEntityUsedInspection */

namespace App\Logic\Dsl;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\Node\ArrayNode;
use Symfony\Component\ExpressionLanguage\Node\BinaryNode;
use Symfony\Component\ExpressionLanguage\Node\ConstantNode;
use Symfony\Component\ExpressionLanguage\Node\FunctionNode;
use Symfony\Component\ExpressionLanguage\Node\GetAttrNode;
use Symfony\Component\ExpressionLanguage\Node\NameNode;
use Symfony\Component\ExpressionLanguage\Node\Node;
use Symfony\Component\ExpressionLanguage\Node\UnaryNode;

class ExpressionQueryParser
{
    protected ExpressionLanguage $el;
    protected string $fieldPrefix;

    protected array $context = [];

    public function __construct()
    {
        $this->el = new ExpressionLanguage();
        $this->fieldPrefix = config('dsl.field_prefix', ':');

        ExpressionQueryRegistry::register($this->el);
    }

    public function apply(Builder $query, string $expression, array $context = []): Builder
    {
        $this->context = $context;
        $ast = $this->el->parse($expression, array_keys($this->context));
        $callback = $this->walk($ast->getNodes());

        $query->where($callback);

        $this->debug($expression, $query);

        return $query;
    }

    protected function walk(Node $node): callable
    {
        return match (true) {
            $node instanceof BinaryNode => $this->handleBinary($node),
            $node instanceof UnaryNode => $this->handleUnary($node),
            $node instanceof FunctionNode => $this->handleFunction($node),
            default => throw new RuntimeException('Unsupported expression node: ' . get_class($node)),
        };
    }

    protected function handleUnary(UnaryNode $node): callable
    {
        $operator = $node->attributes['operator'];
        $operand = $this->walk($node->nodes['node']);

        if ($operator === 'not') {
            return fn(Builder $query) => $query->whereNot(fn($q) => $operand($q));
        }

        throw new RuntimeException("Unsupported unary operator: $operator");
    }

    protected function handleFunction(FunctionNode $node): callable
    {
        $name = $node->attributes['name'];
        $args = $node->nodes['arguments']->nodes;

        return match ($name) {
            'like' => fn($q) => $this->handleLike($q, $args, false),
            'ilike' => fn($q) => $this->handleLike($q, $args, true),
            'between' => fn($q) => $this->handleBetween($q, $args),
            'is_null' => fn($q) => $this->handleNull($q, $args, true),
            'is_not_null' => fn($q) => $this->handleNull($q, $args, false),
            'has' => fn($q) => $this->handleHas($q, $args),
            'has_any' => fn($q) => $this->handleHasAny($q, $args),
            'has_all' => fn($q) => $this->handleHasAll($q, $args),
            default => throw new RuntimeException("Unsupported function: $name"),
        };
    }

    protected function handleLike(Builder $query, array $args, bool $caseInsensitive): void
    {
        [$fieldNode, $patternNode] = $args;
        $field = $this->resolveNodeToField($fieldNode);
        $pattern = $this->resolveNodeToValue($patternNode);

        if ($caseInsensitive) {
            $query->whereRaw("LOWER($field) LIKE LOWER(?)", [$pattern]);
        } else {
            $query->where($field, 'like', $pattern);
        }
    }

    protected function handleBetween(Builder $query, array $args): void
    {
        [$fieldNode, $minNode, $maxNode] = $args;
        $field = $this->resolveNodeToField($fieldNode);
        $field = $this->castToNumericIfJsonPath($field);
        $min = $this->resolveNodeToValue($minNode);
        $max = $this->resolveNodeToValue($maxNode);

        $query->whereBetween($field, [$min, $max]);
    }

    protected function handleNull(Builder $query, array $args, bool $isNull): void
    {
        $field = $this->resolveNodeToField($args[0]);
        $isNull ? $query->whereNull($field) : $query->whereNotNull($field);
    }

    protected function handleHas(Builder $query, array $args): void
    {
        [$fieldNode, $keyNode] = $args;
        $field = $this->resolveNodeToField($fieldNode);
        $key = $this->resolveNodeToValue($keyNode);
        $field = $this->forceJsonb($field);

        $escapedKey = str_replace("'", "''", $key);
        $query->whereRaw("$field ?? '$escapedKey'");
    }

    protected function handleHasAny(Builder $query, array $args): void
    {
        [$fieldNode, $keysNode] = $args;
        $field = $this->resolveNodeToField($fieldNode);
        $keys = $this->resolveNodeToValue($keysNode);
        $field = $this->forceJsonb($field);

        $query->whereRaw("$field ??| array[" . implode(',', array_map(fn($k) => "'".str_replace("'", "''", $k)."'", $keys)) . "]");
    }

    protected function handleHasAll(Builder $query, array $args): void
    {
        [$fieldNode, $keysNode] = $args;
        $field = $this->resolveNodeToField($fieldNode);
        $keys = $this->resolveNodeToValue($keysNode);
        $field = $this->forceJsonb($field);

        $query->whereRaw("$field ??& array[" . implode(',', array_map(fn($k) => "'".str_replace("'", "''", $k)."'", $keys)) . "]");
    }

    protected function handleBinary(BinaryNode $node): callable
    {
        $operator = $node->attributes['operator'];

        if (in_array($operator, ['and', 'or'])) {
            $field = $this->walk($node->nodes['left']);
            $right = $this->walk($node->nodes['right']);

            return function (Builder $query) use ($operator, $field, $right) {
                $query->where(function ($q) use ($operator, $field, $right) {
                    $field($q);
                    if ($operator === 'or') {
                        $q->orWhere(function ($q2) use ($right) {
                            $right($q2);
                        });
                    } else {
                        $right($q);
                    }
                });
            };
        }

        if (
            $operator === 'in' &&
            $node->nodes['right'] instanceof BinaryNode &&
            $node->nodes['right']->attributes['operator'] === '..'
        ) {
            $leftField = $this->castToNumericIfJsonPath($this->resolveNodeToField($node->nodes['left']));
            $min = $this->resolveNodeToValue($node->nodes['right']->nodes['left']);
            $max = $this->resolveNodeToValue($node->nodes['right']->nodes['right']);

            return fn(Builder $query) => $query->whereBetween($leftField, [$min, $max]);
        }

        $field = $this->resolveNodeToField($node->nodes['left']);
        $right = $this->resolveNodeToValue($node->nodes['right']);

        if ($operator === 'contains') {
            return function (Builder $query) use ($field, $right) {
                $field = $this->forceJsonb($field);
                $query->whereRaw("$field @> ?", [json_encode($right)]);
            };
        }

        if (in_array($operator, ['>', '<', '>=', '<=', 'between'])) {
            $field = $this->castToNumericIfJsonPath($field);
        }

        return function (Builder $query) use ($operator, $field, $right) {
            match ($operator) {
                '==' => is_array($right) || is_object($right)
                    ? $query->whereRaw("{$this->forceJsonb($field)} = ?", [json_encode($right)])
                    : $query->where($field, '=', $right),
                '!=' => $query->where($field, '!=', $right),
                '>' => $query->where($field, '>', $right),
                '<' => $query->where($field, '<', $right),
                '>=' => $query->where($field, '>=', $right),
                '<=' => $query->where($field, '<=', $right),
                'in' => $query->whereIn($field, $right),
                'not in' => $query->whereNotIn($field, $right),
                '@>' => $query->whereRaw("$field @> ?", [json_encode($right)]),
                default => throw new RuntimeException("Unsupported binary operator: $operator")
            };
        };
    }

    protected function resolveNodeToField(Node $node): string|Expression
    {
        if ($node instanceof NameNode) {
            $name = $node->attributes['name'];

            if (!array_key_exists($name, $this->context)) {
                throw new \RuntimeException("Unknown variable: {$name}");
            }

            $value = $this->context[$name];

            if (!is_string($value)) {
                throw new \RuntimeException("Field variable '{$name}' must be a string");
            }

            if (!str_starts_with($value, $this->fieldPrefix)) {
                $value = $this->fieldPrefix . $value;
            }

            return $this->resolveNodeToField(new ConstantNode($value));
        }

        if ($node instanceof ConstantNode) {
            $value = $node->attributes['value'];

            if (is_string($value) && str_starts_with($value, $this->fieldPrefix)) {
                $fieldPath = substr($value, strlen($this->fieldPrefix));

                if (str_contains($fieldPath, '.')) {
                    $parts = explode('.', $fieldPath);
                    $jsonField = array_shift($parts);
                    $path = '{' . implode(',', $parts) . '}';

                    return DB::raw("$jsonField#>>'$path'");
                }

                return $fieldPath;
            }

            throw new RuntimeException("Expected field with prefix '$this->fieldPrefix', got constant: ".var_export($value, true));
        }

        if ($node instanceof GetAttrNode) {
            $base = $this->resolveNodeToField($node->nodes['node']);
            $attr = $this->resolveNodeToField($node->nodes['attribute']);

            if ($base instanceof Expression || $attr instanceof Expression) {
                throw new RuntimeException("Nested GetAttrNode not supported yet for Expression.");
            }

            return DB::raw("$base#>>'{{$attr}}'");
        }

        throw new RuntimeException("Unsupported node type: " . get_class($node));
    }

    protected function resolveNodeToValue(Node $node): mixed
    {
        if ($node instanceof ConstantNode) {
            return $node->attributes['value'];
        }

        if ($node instanceof ArrayNode) {
            $values = [];
            foreach (array_chunk($node->nodes, 2) as [$keyNode, $valNode]) {
                $values[$keyNode->attributes['value']] = $this->resolveNodeToValue($valNode);
            }
            return $values;
        }

        if ($node instanceof NameNode) {
            $name = $node->attributes['name'];
            if (array_key_exists($name, $this->context)) {
                return $this->context[$name];
            }

            throw new \RuntimeException("Unknown variable: {$name}");
        }

        if ($node instanceof GetAttrNode) {
            $base = $this->resolveNodeToValue($node->nodes['node']);
            $attr = $this->resolveNodeToValue($node->nodes['attribute']);
            if (is_array($base)) {
                if (!array_key_exists($attr, $base)) {
                    throw new \RuntimeException("Missing key '$attr' in array");
                }
                return $base[$attr];
            }

            if (is_object($base)) {
                return $base->$attr;
            }

            return "$base.$attr";
        }

        if ($node instanceof FunctionNode) {
            return $this->resolveFunctionToValue($node);
        }

        throw new RuntimeException("Unsupported value node: " . get_class($node));
    }

    protected function resolveFunctionToValue(FunctionNode $node): array
    {
        $name = $node->attributes['name'];
        $args = array_map([$this, 'resolveNodeToValue'], $node->nodes['arguments']->nodes);

        return match ($name) {
            'array' => $args,
            default => throw new RuntimeException("Unsupported function value: $name")
        };
    }

    protected function castToNumericIfJsonPath(string|Expression $field): string|Expression
    {
        $raw = $field->getValue(DB::connection()->getQueryGrammar());
        if ($field instanceof Expression && str_contains($raw, '#>>')) {
            return DB::raw("($raw)::numeric");
        }
        return $field;
    }

    protected function debug(string $dsl, Builder $query): void
    {
        if (!config('app.debug')) {
            return;
        }

        $sql = $query->toSql();
        $bindings = $query->getBindings();

        logger()->debug('[DSL][Query] Parsed expression', [
            'dsl' => $dsl,
            'sql' => $sql,
            'bindings' => $bindings,
        ]);
    }

    protected function forceJsonb(string|Expression $field): string
    {
        if ($field instanceof Expression) {
            $sql = $field->getValue(DB::connection()->getQueryGrammar());
            return str_replace('#>>', '#>', $sql);
        }

        return $field;
    }
}
