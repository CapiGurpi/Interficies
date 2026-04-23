<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user']);
}

function current_user(): ?string
{
    return $_SESSION['user'] ?? null;
}

function current_user_type(): ?string
{
    return $_SESSION['user_type'] ?? null;
}

function current_user_info(): ?array
{
    return $_SESSION['user_info'] ?? null;
}

function is_promotor(): bool
{
    return strtolower(trim((string) current_user_type())) === 'promotor';
}

function is_aficionado(): bool
{
    return strtolower(trim((string) current_user_type())) === 'aficionado';
}

function login_user(string $email, string $type, array $info = []): void
{
    $_SESSION['user'] = $email;
    $_SESSION['user_type'] = $type;
    if (!empty($info)) {
        $_SESSION['user_info'] = $info;
    }
}

function logout_user(): void
{
    $_SESSION = [];
    if (session_status() !== PHP_SESSION_NONE) {
        session_destroy();
    }
}

function require_login(string $redirect = 'Vista/fan-login.php'): void
{
    if (!is_logged_in()) {
        header('Location: ' . $redirect);
        exit();
    }
}
