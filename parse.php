<?php // Cron each hour.

require_once __DIR__ . '/config.php';

$parse = new gvk\vk\parse\Parse();

// Update transcription.
$parse->updateTranscription(3);

// Update random playlist from youtube to VK.
$parse->updateRandomPlaylist();
