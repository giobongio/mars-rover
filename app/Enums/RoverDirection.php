<?php

namespace App\Enums;

enum RoverDirection: string
{
    case NORTH = "N";
    case SOUTH = "S";
    case EAST = "E";
    case WEST = "W";

    public static function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return match ((int)$value) {
            (self::NORTH)->value,
            (self::SOUTH)->value,
            (self::EAST)->value,
            (self::WEST)->value => true,
            default => false,
        };
    }

    public static function getValueFromName(string $name): ?int
    {
        foreach (self::cases() as $roverDirection) {
            if ($name === $roverDirection->name) {
                return $roverDirection->value;
            }
        }

        return null;
    }

    public static function getNameFromValue(int $value): ?string
    {
        foreach (self::cases() as $roverDirection) {
            if ($value === $roverDirection->value) {
                return $roverDirection->name;
            }
        }

        return null;
    }
}
