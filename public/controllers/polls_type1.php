<?php use gvk\vk\methods\Polls;

require_once __DIR__ . '/../run.php';

$isAdded = \gvk\vk\methods\Polls::addDB($_GET['text'], Polls::TABLE_1);

echo $isAdded ? 'ok' : 'bad';
