<?php

require_once __DIR__ . '/../configs/defines.php';

if (empty($_REQUEST['secret'])) {
    die;
}

date_default_timezone_set('Europe/London');

if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

require_once D_ROOT . '/vendor/autoload.php';

$db = require D_ROOT . '/configs/db.php';
new Pixie\Connection($db['driver'], $db, 'QB');

if ($_REQUEST['secret'] !== SECRET_KEY && $_REQUEST['secret'] !== \gvk\Config::getSecretKey()) {
    die;
}
