<?php

namespace App\Services\OpenAI\Enums;

use Exception;

enum ImageAspect: string
{
    const SIDE_SHORT = 1024;
    const SIDE_LONG = 1792;
    const SIDE_MD_SHORT = 512;
    const SIDE_MD_LONG = 896;
    const SIDE_SM_SHORT = 256;
    const SIDE_SM_LONG = 448;

    const FULL = 'full';
    const MEDIUM = 'md';
    const SMALL = 'sm';

    case Square = 'square';
    case Portrait = 'portrait';
    case Landscape = 'landscape';

    /**
     * @throws Exception
     */
    public function getSize(string $version = self::FULL, bool $asArray = false): string|array
    {
        $string = self::getSizes($version)[$this->value];
        return $asArray ? explode('x', $string) : $string;
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function options(): array
    {
        return [
            self::Square->value => 'Square',
            self::Portrait->value => 'Portrait',
            self::Landscape->value => 'Landscape',
        ];
    }

    public static function getDefault(): self
    {
        return self::Square;
    }

    /**
     * @throws Exception
     */
    public static function getSizes(string $version = self::FULL): array
    {
        $pair = match ($version) {
            self::FULL => [self::SIDE_SHORT, self::SIDE_LONG],
            self::MEDIUM => [self::SIDE_MD_SHORT, self::SIDE_MD_LONG],
            self::SMALL => [self::SIDE_SM_SHORT, self::SIDE_SM_LONG],
            default => throw new Exception('Unknown size version: '. $version)
        };

        return self::sizes(...$pair);
    }

    protected static function sizes(int $short, int $long): array
    {
        return [
            self::Square->value => "{$short}x$short",
            self::Portrait->value => "{$short}x$long",
            self::Landscape->value => "{$long}x$short",
        ];
    }
}
