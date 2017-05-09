<?php

require_once __DIR__ . '/../configs/defines.php';

if ( empty($_GET['secret']) ) die;

require_once D_ROOT . '/vendor/autoload.php';

$db = require D_ROOT . '/configs/db.php';
new Pixie\Connection($db['driver'], $db, 'QB');

if ( $_GET['secret'] !== SECRET_KEY && $_GET['secret'] !== \gvk\Config::getSecretKey() ) die;
