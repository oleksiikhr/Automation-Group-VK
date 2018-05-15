<?php // Cron each hour.

use gvk\vk\parse\Parse;

require_once __DIR__ . '../server.php';

( new Parse() )->updateTranscription(3);

Parse::updateRandomPlaylist();
