<?php declare(strict_types=1);

//use src\controllers\words\types\WordsFavorite;
//use src\controllers\words\types\WordsNew;
//use src\controllers\verbs\VerbsController;

require_once __DIR__ . '/../server.php';

if (! \core\Protect::cron()) {
    die;
}

// Words
//(new WordsNew(10, 0))->start(456240584);
//(new WordsFavorite(10, 0))->start(456240584);

// Verbs
//(new VerbsController())->start(456242834);

echo '<br><br>time: ' . (microtime(true) - APP_START);
