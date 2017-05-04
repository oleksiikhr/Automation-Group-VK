<?php

require_once __DIR__ . '/../configs/defines.php';

//if ( empty($_REQUEST['secret']) || $_REQUEST['secret'] !== SECRET_KEY ) die;

require_once D_ROOT . '/vendor/autoload.php';

$db = require D_ROOT . '/configs/db.php';
new Pixie\Connection($db['driver'], $db, 'QB');
