<?php // Cron each hour.

require_once __DIR__ . '/run.php';

$parse = new gvk\vk\parse\Parse();

$parse->updateTranscription(3);
$parse->updateRandomPlaylist();
