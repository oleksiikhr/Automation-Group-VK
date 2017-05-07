<?php require_once __DIR__ . '/../run.php';

use gvk\vk\methods\Polls;

$q = QB::table(Polls::TABLE_1)->select('*')->where('quest', '=', $_GET['quest'] . '.')->first();

echo $q ? true : false;
