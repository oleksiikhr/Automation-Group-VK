<?php // Cron each hour.

use gvk\vk\parse\Parse;

require_once __DIR__ . '../server.php';

if (empty($_REQUEST['secret']) && $_REQUEST['secret'] !== getenv('APP_KEY')) {
    die;
}

( new Parse() )->updateTranscription(3);

Parse::updateRandomPlaylist();
