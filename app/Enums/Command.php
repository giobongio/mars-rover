<?php

namespace App\Enums;

enum Command: string
{
    case MOVE_FORWARD = "f";
    case MOVE_BACKWARD = "b";
    case ROTATE_LEFT = "l";
    case ROTATE_RIGHT = "r";

    public static function isValid(string $value): bool
    {
        return !empty(self::getEnum($value));
    }

    public static function getEnum(string $value): ?Command
    {
        foreach (self::cases() as $command) {
            if (strtolower($value) === strtolower($command->value)) {
                return $command;
            }
        }

        return null;
    }
}
