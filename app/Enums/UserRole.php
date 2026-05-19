<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Editor = 'editor';
    case Viewer = 'viewer';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Editor => 'Editor',
            self::Viewer => 'Viewer',
        };
    }

    public function canAccessPanel(): bool
    {
        return match ($this) {
            self::Admin, self::Editor => true,
            self::Viewer => false,
        };
    }
}
