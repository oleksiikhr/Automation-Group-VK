<?php declare(strict_types=1);

//use src\controllers\words\types\WordsBadKnowing;
//use src\controllers\polls\types\PollsTranslate;
//use src\controllers\words\types\WordsFavorite;
//use src\controllers\photos\types\PhotosLearn;
//use src\controllers\polls\types\PollsMissing;
//use src\controllers\words\types\WordsRepeat;
//use src\controllers\photos\types\PhotosCard;
//use src\controllers\photos\types\PhotosJoke;
//use src\controllers\verbs\VerbsController;
//use src\controllers\learn\LearnController;
//use src\controllers\polls\types\PollsFind;
//use src\controllers\words\types\WordsNew;

require_once __DIR__ . '/../server.php';

if (! \core\Protect::cron()) {
    die;
}

// Polls
//(new PollsTranslate)->start();
//(new PollsMissing)->start();
//(new PollsFind)->start();

// Learn
//(new LearnController)->start(456241870);

// Images
//(new PhotosCard(mt_rand(1, 10)))->start();
//(new PhotosJoke(mt_rand(1, 10)))->start();
//(new PhotosLearn(10))->start();

// Words
//(new WordsNew(10, 0))->start(456240584);
//(new WordsFavorite(10, 0))->start(456240584);
//(new WordsBadKnowing(10, 0))->start(456240584);
//(new WordsRepeat(mt_rand(10, 50), mt_rand(0, 20), 10))->start(456240584);

// Verbs
//(new VerbsController())->start(456242834);

echo '<br><br>time: ' . (microtime(true) - APP_START);
