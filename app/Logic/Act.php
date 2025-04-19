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
            $this->$property = self::prepareProperty($data[$property] ?? []);
        }
    }

    /**
     * @return string[]
     */
    public static function propertyKeys(bool $withDo = false): array
    {
        $keys = array_keys(self::properties());
        return $withDo ? array_merge(['do'], $keys) : $keys;
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

    public function match(array $filter): ?array
    {
        if (!array_key_exists('do', $filter)) {
            throw new \InvalidArgumentException("Act matching requires a 'do' key.");
        }

        if ($this->do !== $filter['do']) {
            return null;
        }

        unset($filter['do']);

        $match = ['do' => $this->do];
        foreach (self::propertyKeys() as $property) {
            if (empty($filter[$property])) {
                continue;
            }

            if (!$token = $this->matchProperty($property, (array) $filter[$property])) {
                return null;
            }
            $match[$property] = $token;
        }

        return $match;
    }

    protected function matchProperty(string $property, array $tokens): ?string
    {
        $actual = $this->{$property};

        foreach ($tokens as $token) {
            if (in_array(self::validateToken($token), $actual, true)) {
                return $token;
            }
        }

        return null;
    }

    public static function validateToken(string $token): string
    {
        $regex = self::TOKEN_PATTERN;
        if (!preg_match("/$regex/", $token)) {
            throw new \InvalidArgumentException("Invalid token: [$token]");
        }

        return $token;
    }

    public static function prepareToken(string $token): array
    {
        $tokens = [];
        foreach (explode(' ', $token) as $part) {
            $tokens[] = self::validateToken(trim($part));
        }

        return $tokens;
    }

    public static function prepareProperty(array $tokens): array
    {
        foreach ($tokens as $token) {
            if (!is_string($token)) {
                throw new \InvalidArgumentException("Invalid token type: expected string, got " . gettype($token));
            }
        }
        $result = [];
        foreach ($tokens as $token) {
            $result = array_merge($result, self::prepareToken($token));
        }

        return array_unique($result);
    }
}
