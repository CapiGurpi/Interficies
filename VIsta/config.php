<?php
// config.php

// Database connection constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'trabajotrans');

// Site constants
define('SITE_NAME', 'Next Level Sports');
define('PROJECT_ROOT', __DIR__);
define('MODEL_DIR', PROJECT_ROOT . '/Model');
define('CONTROLLER_DIR', PROJECT_ROOT . '/Controller');
define('VIEWS_DIR', PROJECT_ROOT . '/Vista');

/**
 * Escapa contenido para salida en HTML.
 */
function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Enmascara un número de tarjeta dejando visibles solo los últimos 4 dígitos.
 */
function mask_credit_card(string $card): string
{
    $cleanCard = preg_replace('/\D+/', '', $card);
    if (strlen($cleanCard) <= 4) {
        return $cleanCard;
    }
    return str_repeat('*', max(0, strlen($cleanCard) - 4)) . substr($cleanCard, -4);
}
