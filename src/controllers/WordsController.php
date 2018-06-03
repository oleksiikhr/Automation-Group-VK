<?php declare(strict_types=1);

namespace src\controllers;

use core\vk\methods\Wall;
use src\models\WordsEng;
use core\Token;

class WordsController
{
    const RUN_NEW          = 1;
    const RUN_REPEAT       = 2;
    const RUN_BAD_KNOWING  = 3;
    const RUN_FAVORITE     = 4;

    /**
     * Main method.
     *
     * @param int $run
     * @param int $count
     *
     * @return mixed
     */
    public static function start($run, $count = 5)
    {
        // TODO if $run

        $words = WordsEng::getNewList($count);
        var_dump($words);

//        Wall::post(Token::getToken(), )
        // TODO: Implement start() method.
    }
}
