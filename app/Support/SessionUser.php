<?php
// app/Support/SessionUser.php

namespace App\Support;

use App\Enums\LoginProvider;
use App\Enums\UserRole;

class SessionUser
{
    public const KEY = 'auth_user';

    public static function put(array $data): void
    {
        session([
            self::KEY => [
                'id' => $data['id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'] instanceof UserRole ? $data['role']->value : $data['role'],
                'provider' => $data['provider'] instanceof LoginProvider ? $data['provider']->value : $data['provider'],
                'logged_in' => true,
            ]
        ]);
    }

    public static function get(): ?array
    {
        return session(self::KEY);
    }

    public static function check(): bool
    {
        return filled(session(self::KEY . '.id'));
    }

    public static function role(): ?UserRole
    {
        $value = session(self::KEY . '.role');

        return $value ? UserRole::from($value) : null;
    }

    public static function logout(): void
    {
        session()->forget(self::KEY);
        session()->invalidate();
        session()->regenerateToken();
    }
}