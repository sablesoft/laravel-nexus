<?php

namespace App\Services\OpenAI\Enums;

enum ImageAspect: string
{
    case Square = 'square';
    case Portrait = 'portrait';
    case Landscape = 'landscape';

    public function getSize(): string
    {
        return self::getSizes()[$this->value];
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function options(): array
    {
        return array_reduce(self::cases(), function ($result, $case) {
            $value = $case->value;
            $result[$value] = ucfirst($value);
            return $result;
        }, []);
    }

    public static function getSizes(): array
    {
        return [
            self::Square->value => '1024x1024',
            self::Portrait->value => '1024x1792',
            self::Landscape->value => '1792x1024',
        ];
    }

    public static function getDefault(): self
    {
        return self::Square;
    }
}
