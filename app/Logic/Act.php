<?php

namespace App\Logic;

final readonly class Act
{
    const TOKEN_PATTERN = '^[a-z]+(-[a-z]+)*$';

    public string $do;
    public array $what;
    public array $using;
    public array $from;
    public array $to;
    public array $for;
    public array $how;

    public function __construct(array $data)
    {
        if (!isset($data['do']) || !is_string($data['do'])) {
            throw new \InvalidArgumentException("Missing or invalid 'do' value in Act.");
        }
        $this->do = self::validateToken($data['do']);
        foreach (self::propertyKeys() as $property) {
            $this->$property = self::validateArray($data[$property] ?? []);
        }
    }

    /**
     * @return string[]
     */
    public static function propertyKeys(): array
    {
        return array_keys(self::properties());
    }

    public static function properties(): array
    {
        $common = 'List of 2-6 English keywords — related terms and synonyms that describe ';
        return [
            'what'  => 'What the action is directed at',
            'using' => 'Tool, item, method or body part used to perform the action',
            'from'  => 'Origin or starting context of the action',
            'to'    => 'Destination, target direction, receiver or result of the action',
            'for'   => 'Intent or purpose behind the action',
            'how'   => 'Manner, tone or style of the action'
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public function toArray(): array
    {
        $array = [
            'do' => $this->do
        ];
        foreach (self::propertyKeys() as $property) {
            $array[$property] = $this->$property;
        }

        return $array;
    }

    public function match(array $filter): bool
    {
        if (!array_key_exists('do', $filter)) {
            throw new \InvalidArgumentException("Act matching requires a 'do' key.");
        }

        if ($this->do !== $filter['do']) {
            return false;
        }

        unset($filter['do']);

        foreach ($filter as $property => $tokens) {
            if (!property_exists($this, $property)) {
                continue;
            }

            if (!$this->matchProperty($property, (array) $tokens)) {
                return false;
            }
        }

        return true;
    }

    protected function matchProperty(string $property, array $tokens): bool
    {
        $actual = $this->{$property};

        foreach ($tokens as $token) {
            if (in_array(self::validateToken($token), $actual, true)) {
                return true;
            }
        }

        return false;
    }

    public static function validateToken(string $token): string
    {
        $regex = self::TOKEN_PATTERN;
        if (!preg_match("/$regex/", $token)) {
            throw new \InvalidArgumentException("Invalid token: [$token]");
        }

        return $token;
    }

    public static function validateArray(array $tokens): array
    {
        foreach ($tokens as $token) {
            if (!is_string($token)) {
                throw new \InvalidArgumentException("Invalid token type: expected string, got " . gettype($token));
            }
        }

        return array_map([self::class, 'validateToken'], $tokens);
    }
}
