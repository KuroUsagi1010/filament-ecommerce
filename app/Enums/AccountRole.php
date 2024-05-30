<?php

namespace App\Enums;

enum AccountRole: string
{
    case Admin = "admin";
    case User = "user";

    /**
     * returns all properties in array format
     * @return array
     */
    public static function all(): array
    {
        return array_combine(
            array_map(fn ($case) => $case->value, self::cases()),
            array_map(fn ($case) => $case->name, self::cases())
        );
    }

    /**
     * checks if a given case is existing in the group
     * @param string $case
     * @return bool
     */
    public static function isValid($case): bool
    {
        return in_array($case, self::all());
    }
}
