<?php // Cron every 1 minute.

require_once __DIR__ . '/../../public/run.php';

\tmp\game\Game::updateBestUsers();

// TODO: night -> updateBestUsers
