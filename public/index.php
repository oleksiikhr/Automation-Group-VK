<?php declare(strict_types=1);

//use src\controllers\VerbsController;
//use src\controllers\WordsController;

require_once __DIR__ . '/../server.php';

if (! \core\Protect::cron()) {
    die;
}

// Words
//WordsController::start(WordsController::RUN_NEW, 5, 0, 456240584);
//WordsController::start(WordsController::RUN_REPEAT, 20, 0, 456240584, 5);
//WordsController::start(WordsController::RUN_BAD_KNOWING, 5, 0, 456240584);
//WordsController::start(WordsController::RUN_FAVORITE, 5, 0, 456240584);

// Verbs
//VerbsController::start(5, 0, 456242834);

echo '<br><br>time: ' . (microtime(true) - APP_START);
