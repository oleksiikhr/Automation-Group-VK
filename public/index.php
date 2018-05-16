<?php declare(strict_types=1);

require_once __DIR__ . '/../server.php';

if (! \core\Protect::cron()) {
    die;
}

echo '<br><br>time: ' . (microtime(true) - APP_START);

//\src\controllers\VerbsController::start();
