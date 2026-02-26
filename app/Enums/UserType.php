<?php
namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case SUPERADMIN = 'super_admin';

    public static function toArray(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}