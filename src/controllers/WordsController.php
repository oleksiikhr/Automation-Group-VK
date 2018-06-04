<?php declare(strict_types=1);

namespace src\controllers;

use core\vk\methods\Wall;
use src\models\WordsEng;
use core\Token;

class WordsController
{
    const SMILE = '&#127468;&#127463;';

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
    public static function start(int $run, int $count = 5)
    {
        // TODO Get only words*
        // TODO Photo_id*
        switch ($run) {
            case self::RUN_NEW:
                self::runNew($count);
                break;
            default:
                die('RUN is not defined');
        }
    }

    private static function runNew(int $count)
    {
        $words = WordsEng::getNewList($count);
        $len = count($words);
        $message = self::SMILE . " Перевод английских слов.\n\n";

        for ($i = 0; $i < $len; $i++) {
            $word = $words[$i];
            $message .= "{$word->word_eng_id}. {$word->word_eng}";

            if ($word->transcription_eng) {
                $message .= " | {$word->transcription_eng}";
            }

            if ($word->transcription_rus) {
                $message .= " | {$word->transcription_rus}";
            }

            $message .= "\n" . implode(', ', array_column($word->translate, 'word_rus'));

            $message .= "\n\n";
        }

        Wall::post(Token::getToken(), trim($message));
    }
}
