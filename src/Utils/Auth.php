<?php

namespace Quiksnip\Quiksnip\Utils;

class Auth
{
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION["user"]);
    }

    public static function getUser()
    {
        if (self::isLoggedIn()) {
            return $_SESSION["user"];
        }

        return null;
    }

    public static function login(\Quiksnip\Quiksnip\Models\User $user): void
    {
        $_SESSION["user"] = $user;
    }

    public static function logout(): void
    {
        unset($_SESSION["user"]);
    }
}