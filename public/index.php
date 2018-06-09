<?php declare(strict_types=1);

use src\controllers\WordsController;

require_once __DIR__ . '/../server.php';

if (! \core\Protect::cron()) {
    die;
}

WordsController::start(WordsController::RUN_NEW, 10, 10, 0);
//\src\controllers\VerbsController::start();





echo '<br><br>time: ' . (microtime(true) - APP_START);
