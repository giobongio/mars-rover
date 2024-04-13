<?php

namespace App\Enums;

enum RoverDirection: string
{
    case NORTH = "N";
    case SOUTH = "S";
    case EAST = "E";
    case WEST = "W";

    public static function isValid(string $value): bool
    {
        return !empty(self::getEnum($value));
    }

    /*public static function getValueFromName(string $name): ?int
    {
        foreach (self::cases() as $roverDirection) {
            if ($name === $roverDirection->name) {
                return $roverDirection->value;
            }
        }

        return null;
    }

    public static function getNameFromValue(string $value): ?string
    {
        foreach (self::cases() as $roverDirection) {
            if ($value === $roverDirection->value) {
                return $roverDirection->name;
            }
        }

        return null;
    }*/

    public static function getValue(RoverDirection $roverDirection): ?string
    {
        return self::isValid($roverDirection->value) ? $roverDirection->value : null;
    }

    public static function getName(RoverDirection $roverDirection): ?string
    {
        return self::isValid($roverDirection->value) ? $roverDirection->name : null;
    }

    public static function getEnum(string $value): ?RoverDirection
    {
        foreach (self::cases() as $roverDirection) {
            if ($value === $roverDirection->value) {
                return $roverDirection;
            }
        }

        return null;
    }
}
