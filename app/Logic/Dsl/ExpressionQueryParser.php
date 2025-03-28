<?php

namespace App\Logic\Dsl;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
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

    public function __construct(?ExpressionLanguage $el = null)
    {
        $this->el = $el ?? new ExpressionLanguage();
        $this->fieldPrefix = config('dsl.field_prefix', ':');

        $this->el->register('like', fn($a, $b) => '', fn($args, $field, $pattern) => true);
        $this->el->register('ilike', fn($a, $b) => '', fn($args, $field, $pattern) => true);
        $this->el->register('between', fn($a, $b, $c) => '', fn($args, $field, $min, $max) => true);
        $this->el->register('is_null', fn($a) => '', fn($args, $field) => true);
        $this->el->register('is_not_null', fn($a) => '', fn($args, $field) => true);
        $this->el->register('has', fn($a, $b) => '', fn($args, $field, $key) => true);
        $this->el->register('has_any', fn($a, $b) => '', fn($args, $field, $keys) => true);
        $this->el->register('has_all', fn($a, $b) => '', fn($args, $field, $keys) => true);

    }

    public function apply(Builder $query, string $expression): Builder
    {
        $ast = $this->el->parse($expression, []);
        $this->walk($query, $ast->getNodes());
        return $query;
    }

    protected function walk(Builder $query, Node $node): void
    {
        if ($node instanceof BinaryNode) {
            $this->handleBinary($query, $node);
        } elseif ($node instanceof UnaryNode) {
            $this->handleUnary($query, $node);
        } elseif ($node instanceof FunctionNode) {
            $this->handleFunction($query, $node);
        } else {
            throw new \RuntimeException('Unsupported expression node: ' . get_class($node));
        }
    }

    protected function handleUnary(Builder $query, UnaryNode $node): void
    {
        $operator = $node->attributes['operator'];
        if ($operator === 'not') {
            $query->whereNot(function ($q) use ($node) {
                $this->walk($q, $node->nodes['node']);
            });
        } else {
            throw new \RuntimeException("Unsupported unary operator: $operator");
        }
    }

    protected function handleFunction(Builder $query, FunctionNode $node): void
    {
        $name = $node->attributes['name'];
        $args = $node->nodes['arguments']->nodes;

        match ($name) {
            'like' => $this->handleLike($query, $args, false),
            'ilike' => $this->handleLike($query, $args, true),
            'between' => $this->handleBetween($query, $args),
            'is_null' => $this->handleNull($query, $args, true),
            'is_not_null' => $this->handleNull($query, $args, false),
            'has' => $this->handleHas($query, $args),
            'has_any' => $this->handleHasAny($query, $args),
            'has_all' => $this->handleHasAll($query, $args),
            default => throw new \RuntimeException("Unsupported function: $name")
        };
    }

    protected function handleWhereIn(Builder $query, array $args, bool $not): void
    {
        [$fieldNode, $listNode] = $args;
        $field = $this->resolveNodeToField($fieldNode);
        $list = $this->resolveNodeToValue($listNode);

        $not ? $query->whereNotIn($field, $list) : $query->whereIn($field, $list);
    }

    protected function handleLike(Builder $query, array $args, bool $caseInsensitive): void
    {
        [$fieldNode, $patternNode] = $args;
        $field = $this->resolveNodeToField($fieldNode);
        $pattern = $this->resolveNodeToValue($patternNode);

        if ($caseInsensitive) {
            $query->whereRaw("LOWER({$field}) LIKE LOWER(?)", [$pattern]);
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

        $query->whereRaw("{$field} ? ?", [$key]);
    }

    protected function handleHasAny(Builder $query, array $args): void
    {
        [$fieldNode, $keysNode] = $args;
        $field = $this->resolveNodeToField($fieldNode);
        $keys = $this->resolveNodeToValue($keysNode);

        $query->whereRaw("{$field} ?| array[" . implode(',', array_fill(0, count($keys), '?')) . "]", $keys);
    }

    protected function handleHasAll(Builder $query, array $args): void
    {
        [$fieldNode, $keysNode] = $args;
        $field = $this->resolveNodeToField($fieldNode);
        $keys = $this->resolveNodeToValue($keysNode);

        $query->whereRaw("{$field} ?& array[" . implode(',', array_fill(0, count($keys), '?')) . "]", $keys);
    }

    protected function handleBinary(Builder $query, BinaryNode $node): void
    {
        $operator = $node->attributes['operator'];

        if ($operator === 'and') {
            $query->where(function ($q) use ($node) {
                $this->walk($q, $node->nodes['left']);
                $this->walk($q, $node->nodes['right']);
            });
            return;
        }

        if ($operator === 'or') {
            $query->orWhere(function ($q) use ($node) {
                $this->walk($q, $node->nodes['left']);
                $this->walk($q, $node->nodes['right']);
            });
            return;
        }

        if ($operator === 'in' && $node->nodes['right'] instanceof BinaryNode &&
            $node->nodes['right']->attributes['operator'] === '..') {
            $leftField = $this->castToNumericIfJsonPath($this->resolveNodeToField($node->nodes['left']));
            $min = $this->resolveNodeToValue($node->nodes['right']->nodes['left']);
            $max = $this->resolveNodeToValue($node->nodes['right']->nodes['right']);

            $query->whereBetween($leftField, [$min, $max]);
            return;
        }

        $left = $this->resolveNodeToField($node->nodes['left']);
        $right = $this->resolveNodeToValue($node->nodes['right']);

        $left = match ($operator) {
            '>', '<', '>=', '<=', 'between' => $this->castToNumericIfJsonPath($left),
            default => $left,
        };

        match ($operator) {
            '==' => $query->where($left, '=', $right),
            '!=' => $query->where($left, '!=', $right),
            '>' => $query->where($left, '>', $right),
            '<' => $query->where($left, '<', $right),
            '>=' => $query->where($left, '>=', $right),
            '<=' => $query->where($left, '<=', $right),
            'in' => $query->whereIn($left, $right),
            'not in' => $query->whereNotIn($left, $right),
            '@>' => $query->whereRaw("{$left} @> ?", [json_encode($right)]),
            default => throw new \RuntimeException("Unsupported binary operator: $operator")
        };
    }

    protected function resolveNodeToField(Node $node): string|Expression
    {
        if ($node instanceof NameNode) {
            return $node->attributes['name'];
        }

        if ($node instanceof ConstantNode) {
            $value = $node->attributes['value'];

            if (is_string($value) && str_starts_with($value, $this->fieldPrefix)) {
                $fieldPath = substr($value, strlen($this->fieldPrefix));

                if (str_contains($fieldPath, '.')) {
                    $parts = explode('.', $fieldPath);
                    $jsonField = array_shift($parts);
                    $path = '{' . implode(',', $parts) . '}';

                    return DB::raw("{$jsonField}#>>'{$path}'");
                }

                return $fieldPath;
            }

            throw new \RuntimeException("Expected field with prefix '{$this->fieldPrefix}', got constant: ".var_export($value, true));
        }

        if ($node instanceof GetAttrNode) {
            $base = $this->resolveNodeToField($node->nodes['node']);
            $attr = $this->resolveNodeToField($node->nodes['attribute']);

            if ($base instanceof Expression || $attr instanceof Expression) {
                throw new \RuntimeException("Nested GetAttrNode not supported yet for Expression.");
            }

            return DB::raw("{$base}#>>'{{$attr}}'");
        }

        throw new \RuntimeException("Unsupported node type: " . get_class($node));
    }

    protected function resolveNodeToValue(Node $node): mixed
    {
        if ($node instanceof ConstantNode) {
            return $node->attributes['value'];
        }

        if ($node instanceof ArrayNode) {
            $values = [];
            foreach (array_chunk($node->nodes, 2) as [$_, $valNode]) {
                $values[] = $this->resolveNodeToValue($valNode);
            }
            return $values;
        }

        if ($node instanceof NameNode) {
            return $node->attributes['name'];
        }

        if ($node instanceof GetAttrNode) {
            $base = $this->resolveNodeToValue($node->nodes['node']);
            $attr = $this->resolveNodeToValue($node->nodes['attribute']);
            return "{$base}.{$attr}";
        }

        if ($node instanceof FunctionNode) {
            return $this->resolveFunctionToValue($node);
        }

        throw new \RuntimeException("Unsupported value node: " . get_class($node));
    }

    protected function resolveFunctionToValue(FunctionNode $node): mixed
    {
        $name = $node->attributes['name'];
        $args = array_map([$this, 'resolveNodeToValue'], $node->nodes['arguments']->nodes);

        return match ($name) {
            'array' => $args,
            default => throw new \RuntimeException("Unsupported function value: $name")
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
}
