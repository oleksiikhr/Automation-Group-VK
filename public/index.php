<?php

use src\database\models\Verbs;

require_once __DIR__ . '/../server.php';

$db = Verbs::get();

var_dump($db); die;

var_dump($_SERVER['REQUEST_URI']);
