<?php

require_once __DIR__ . '/../../configs/defines.php';
require_once D_ROOT . '/vendor/autoload.php';

$db = require D_ROOT . '/configs/db.php';
new Pixie\Connection($db['driver'], $db, 'QB');

\tmp\euro2017\Euro::createPost();
