<?php

namespace Infrastructure\Tools;

class Assertion
{
    public static function greaterThan(float|int $value, float|int $limit): bool
    {
        return $value > $limit ? true: false;
    }
    
    public static function isNull($value): bool
    {
        return $value === null;
    }

    public static function isString($value): bool
    {
        return is_string($value);
    }

    public static function lessThan(float|int $value, float|int $limit): bool
    {
        return $value < $limit ? true: false;
    }

    public static function notNull($value): bool
    {
        return $value !== null;
    }
}