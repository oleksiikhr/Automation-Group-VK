<?php declare(strict_types=1);

namespace src\controllers;

use core\vk\methods\Wall;
use src\models\WordsEng;
use core\Token;

class WordsController
{
    /**
     * Main method.
     *
     * @param int $count
     *
     * @return mixed
     */
    public static function start($count = 5)
    {
        $words = WordsEng::getNewList();

//        Wall::post(Token::getToken(), )
        // TODO: Implement start() method.
    }
}
