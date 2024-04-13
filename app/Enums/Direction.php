<?php

namespace App\Enums;

enum Direction: string
{
    case NORTH = "N";
    case SOUTH = "S";
    case EAST = "E";
    case WEST = "W";

    public static function isValid(string $value): bool
    {
        return !empty(self::getEnum($value));
    }

    public static function getEnum(string $value): ?Direction
    {
        foreach (self::cases() as $direction) {
            if ($value === $direction->value) {
                return $direction;
            }
        }

        return null;
    }
}
