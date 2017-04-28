<?php // Cron each hour.

use classes\vk\parse\Parse;

require_once __DIR__ . '/config.php';

if ($_GET['secret'] !== SECRET) die;

$transcription = new Parse();

// Update transcription.
$transcription->updateTranscription(3);

// Update random playlist from youtube to VK.
$transcription->updateRandomPlaylist();
