<?php

require_once __DIR__ . './configs/defines.php';
require_once D_ROOT . '/vendor/autoload.php';

/*
 * | ---------------------------------------------------------------------
 * | LIBRARIES
 * | ---------------------------------------------------------------------
 * |
 */

$db = require D_ROOT . '/configs/db.php';
new Pixie\Connection($db['driver'], $db, 'QB');

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

if (getenv('APP_DEBUG')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
