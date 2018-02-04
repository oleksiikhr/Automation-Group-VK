<?php require_once __DIR__ . '/../run.php';

use gvk\vk\methods\Polls;

//TODO: Complete the code

if (empty($_GET['method'])) {
    return false;
}

if (! preg_match('/[.?!]$/ui', $_GET['val'])) {
    $_GET['val'] .= '.';
}

echo $_GET['val']; die;
