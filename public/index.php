<?php declare(strict_types=1);

use src\controllers\WordsController;

require_once __DIR__ . '/../server.php';

if (! \core\Protect::cron()) {
    die;
}

die('Here');

WordsController::start(WordsController::RUN_REPEAT, 10, 456240584);
//\src\controllers\VerbsController::start();





echo '<br><br>time: ' . (microtime(true) - APP_START);
