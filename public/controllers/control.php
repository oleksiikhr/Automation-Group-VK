<?php require_once __DIR__ . '/../run.php';

use gvk\vk\methods\Polls;

if ( ! empty($_GET['action']) && $_GET['action'] === 'poll_type1' )
    echo Polls::addDB($_GET['text'], Polls::TABLE_1) ? true : false;

