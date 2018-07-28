<?php declare(strict_types=1);

use src\controllers\photos\types as photos;
use src\controllers\polls\types as polls;
use src\controllers\words\types as words;
use src\controllers\verbs;
use src\controllers\learn;

require_once __DIR__ . '/../server.php';

// .env - APP_SECRET
if (! \core\Protect::cron()) {
    die;
}

$h = (int)date('G');
$m = (int)date('i');

/**
 * | ------------------------------------------------------------------------
 * | The file is run using the crown every minute.
 * | ------------------------------------------------------------------------
 * |
 * | @var $h - Hours
 * | @var $m - Minutes
 * |
 */

// TODO Polls - start($photoId)
// TODO Create table?
// TODO Change time

if ($m === 0) {

    if     ($h % 3 == 0)
        (new polls\PollsTranslate)->start();

    elseif ($h % 3 == 1)
        (new polls\PollsMissing)->start();

    elseif ($h % 3 == 2)
        (new words\WordsNew(10, 0))->start(456240584);

}
elseif ($m === 30) {

    if (in_array($h, [12]))
        (new learn\LearnController)->start(456241870);

    // etc

}

// Polls
//(new polls\PollsFind)->start();

// Photos
//(new photos\PhotosCard(mt_rand(1, 10)))->start();
//(new photos\PhotosJoke(mt_rand(1, 10)))->start();
//(new photos\PhotosLearn(10))->start();

// Words
//(new words\WordsFavorite(10, 0))->start(456240584);
//(new words\WordsBadKnowing(10, 0))->start(456240584);
//(new words\WordsRepeat(mt_rand(10, 50), mt_rand(0, 20), 10))->start(456240584);

// Verbs
//(new verbs\VerbsController())->start(456242834);

echo '<br><br>time: ' . (microtime(true) - APP_START);
