<?php

require_once __DIR__ . '/configs/Config.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/App.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
