<?php

class AuthService
{
    public static function login(string $username): void
    {
        $_SESSION["admin"] = true;
        $_SESSION["username"] = $username;
    }

    public static function logout(): void
    {
        session_unset();
        session_destroy();
    }

    public static function isAdmin(): bool
    {
        return !empty($_SESSION["admin"]);
    }

    public static function requireAdmin(): void
    {
        if (!self::isAdmin()) {
            header("Location: index.php?route=admin");
            exit;
        }
    }

    public static function username(): ?string
    {
        return $_SESSION["username"] ?? null;
    }
}