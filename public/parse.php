<?php // Cron each hour.

require_once __DIR__ . '/config.php';

$parse = new gvk\vk\parse\Parse();

$parse->updateTranscription(3);
$parse->updateRandomPlaylist();
