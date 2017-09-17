<?php // Cron every 1 minute.

use tmp\game\Game;

require_once __DIR__ . '/../../public/run.php';

$h = date('G');
$m = date('i');

if ($h == 0 && $m == 0) {
    Game::updateBestUsers();
}

Game::checkingGame();
