<?php

define('APP_START', microtime(true));

require_once __DIR__ . './configs/defines.php';

if (APP_DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

require_once D_ROOT . '/vendor/autoload.php';

try {
    \core\Token::parseInput();
} catch (Exception $e) {
    die($e->getMessage());
}
