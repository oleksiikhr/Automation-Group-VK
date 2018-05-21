<?php declare(strict_types=1);

require_once __DIR__ . '/../server.php';

if (! \core\Protect::cron()) {
    die;
}

\src\controllers\VerbsController::start();





echo '<br><br>time: ' . (microtime(true) - APP_START);
