<?php

namespace App\Logic\Dsl;

namespace App\Logic\Dsl;

use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\Node\BinaryNode;
use Symfony\Component\ExpressionLanguage\Node\ConstantNode;
use Symfony\Component\ExpressionLanguage\Node\GetAttrNode;
use Symfony\Component\ExpressionLanguage\Node\NameNode;
use Symfony\Component\ExpressionLanguage\Node\UnaryNode;
use Symfony\Component\ExpressionLanguage\Node\FunctionNode;
use Symfony\Component\ExpressionLanguage\Node\Node;

class ExpressionQueryParser
{
    protected ExpressionLanguage $el;
    protected string $fieldPrefix;

    public function __construct(?ExpressionLanguage $el = null)
    {
        $this->el = $el ?? new ExpressionLanguage();
        $this->fieldPrefix = config('dsl.field_prefix', ':');

        $this->el->register('in', fn($a, $b) => '', fn($args, $list, $value) => in_array($value, $list));
        $this->el->register('not_in', fn($a, $b) => '', fn($args, $list, $value) => !in_array($value, $list));
        $this->el->register('like', fn($a, $b) => '', fn($args, $field, $pattern) => true);
        $this->el->register('ilike', fn($a, $b) => '', fn($args, $field, $pattern) => true);
        $this->el->register('between', fn($a, $b, $c) => '', fn($args, $field, $min, $max) => true);
        $this->el->register('is_null', fn($a) => '', fn($args, $field) => true);
        $this->el->register('is_not_null', fn($a) => '', fn($args, $field) => true);
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
        $operator = $node->getAttribute('operator');
        if ($operator === 'not') {
            $query->whereNot(function ($q) use ($node) {
                $this->walk($q, $node->getNode());
            });
        } else {
            throw new \RuntimeException("Unsupported unary operator: $operator");
        }
    }

    protected function handleFunction(Builder $query, FunctionNode $node): void
    {
        $name = $node->getAttribute('name');
        $args = $node->getNodes()['arguments']->nodes;

        match ($name) {
            'in' => $this->handleWhereIn($query, $args, false),
            'not_in' => $this->handleWhereIn($query, $args, true),
            'like' => $this->handleLike($query, $args, false),
            'ilike' => $this->handleLike($query, $args, true),
            'between' => $this->handleBetween($query, $args),
            'is_null' => $this->handleNull($query, $args, true),
            'is_not_null' => $this->handleNull($query, $args, false),
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
        $min = $this->resolveNodeToValue($minNode);
        $max = $this->resolveNodeToValue($maxNode);

        $query->whereBetween($field, [$min, $max]);
    }

    protected function handleNull(Builder $query, array $args, bool $isNull): void
    {
        $field = $this->resolveNodeToField($args[0]);
        $isNull ? $query->whereNull($field) : $query->whereNotNull($field);
    }

    protected function handleBinary(Builder $query, BinaryNode $node): void
    {
        $operator = $node->getAttribute('operator');

        if ($operator === 'and') {
            $query->where(function ($q) use ($node) {
                $this->walk($q, $node->getLeftNode());
                $this->walk($q, $node->getRightNode());
            });
            return;
        }

        if ($operator === 'or') {
            $query->orWhere(function ($q) use ($node) {
                $this->walk($q, $node->getLeftNode());
                $this->walk($q, $node->getRightNode());
            });
            return;
        }

        $left = $this->resolveNodeToField($node->getLeftNode());
        $right = $this->resolveNodeToValue($node->getRightNode());

        match ($operator) {
            '==' => $query->where($left, '=', $right),
            '!=' => $query->where($left, '!=', $right),
            '>' => $query->where($left, '>', $right),
            '<' => $query->where($left, '<', $right),
            '>=' => $query->where($left, '>=', $right),
            '<=' => $query->where($left, '<=', $right),
            default => throw new \RuntimeException("Unsupported binary operator: $operator")
        };
    }

    protected function resolveNodeToField(Node $node): string
    {
        // Прямое обращение к переменной — допустим NameNode
        if ($node instanceof NameNode) {
            return $node->attributes['name'];
        }

        // Константа со специальным префиксом — это поле
        if ($node instanceof ConstantNode) {
            $value = $node->attributes['value'];

            if (is_string($value) && str_starts_with($value, $this->fieldPrefix)) {
                return substr($value, strlen($this->fieldPrefix));
            }

            throw new \RuntimeException("Expected string field with prefix '{$this->fieldPrefix}', got constant: ".var_export($value, true));
        }

        // Обращение вида object.property или json.field
        if ($node instanceof GetAttrNode) {
            $base = $this->resolveNodeToField($node->nodes['node']);
            $attr = $this->resolveNodeToField($node->nodes['attribute']);
            return "{$base}.{$attr}"; // точечная нотация
        }

        throw new \RuntimeException("Unsupported node type: " . get_class($node));
    }


    protected function resolveNodeToValue(Node $node): mixed
    {
        if ($node instanceof ConstantNode) {
            return $node->getAttribute('value');
        }

        if ($node instanceof NameNode) {
            return $node->getAttribute('name');
        }

        if ($node instanceof GetAttrNode) {
            $base = $this->resolveNodeToValue($node->getNode('node'));
            $attr = $this->resolveNodeToValue($node->getNode('attribute'));
            return "{$base}.{$attr}";
        }

        if ($node instanceof FunctionNode) {
            return $this->resolveFunctionToValue($node);
        }

        throw new \RuntimeException('Unsupported value node type: ' . get_class($node));
    }

    protected function resolveFunctionToValue(FunctionNode $node): mixed
    {
        $name = $node->getAttribute('name');
        $args = array_map([$this, 'resolveNodeToValue'], $node->getNodes()['arguments']->nodes);

        return match ($name) {
            'array' => $args,
            default => throw new \RuntimeException("Unsupported value function: $name")
        };
    }
}
