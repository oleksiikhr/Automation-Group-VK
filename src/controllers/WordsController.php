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
     * @return void
     */
    public static function start(int $run, int $count = 5): void
    {
        // TODO Photo_id*
        $words = [];
        $message = self::SMILE;

        switch ($run) {
            case self::RUN_NEW:
                $words = WordsEng::getNewList($count);
                $message .= " Изучение новых слов.\n\n" . self::getTextWords($words);
                break;
            default:
                die('RUN is not defined');
        }

        WordsEng::setPublishedAtNow(array_column($words, 'word_eng_id'));

        try {
            Wall::post(Token::getToken(), $message);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Get the text words.
     *
     * @param array $words
     *
     * @return string
     */
    private static function getTextWords(array $words)
    {
        $message = "";

        foreach ($words as $word) {
            $message .= "- " . ucfirst($word->word_eng);

            if ($word->transcription_eng) {
                $message .= " [{$word->transcription_eng}]";
            }

            if ($word->transcription_rus) {
                $message .= " [{$word->transcription_rus}]";
            }

            $message .= " #{$word->word_eng_id}";

            // Rus words
            $message .= "\n" . implode(', ', array_column($word->translate, 'word_rus')) . "\n\n";
        }

        return trim($message);
    }
}
