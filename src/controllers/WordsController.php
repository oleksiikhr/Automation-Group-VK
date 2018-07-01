<?php declare(strict_types=1);

namespace src\controllers;

use core\vk\methods\Wall;
use src\models\WordsEng;
use src\Controller;
use core\vk\VK;
use core\Token;

class WordsController extends Controller
{
    const SMILE   = '&#127468;&#127463;';
    const HASHTAG = 'words';

    const RUN_NEW          = 1;
    const RUN_REPEAT       = 2;
    const RUN_BAD_KNOWING  = 3;
    const RUN_FAVORITE     = 4;

    /**
     * Main method.
     *
     * @param int      $run
     * @param int      $count
     * @param int      $offset
     * @param int|null $cut of words
     * @param int|null $photoId from photo album in VK
     *
     * @return void
     */
    public static function start(int $run, int $count = 5, int $offset = 0, ?int $photoId = null, ?int $cut = null): void
    {
        $message = self::SMILE . " ";

        switch ($run) {
            case self::RUN_NEW:
                $message .= "Изучение новых слов";
                $words = WordsEng::getList($count, $offset);
                break;
            case self::RUN_REPEAT:
                $message .= "Повтор изученных недавно слов";
                $words = WordsEng::getList($count, $offset, 'published_at', 'DESC');
                break;
            case self::RUN_BAD_KNOWING:
                $message .= "Повтор плохо изученных слов";
                $words = WordsEng::getList($count, $offset, 'rating', 'DESC');
                break;
            case self::RUN_FAVORITE:
                $message .= "Изучение слов выбранных сообществом";
                $words = WordsEng::getList($count, $offset, 'favorite', 'DESC');
                break;
            default:
                die('WordsController - RUN is not defined');
        }

        if ($cut) {
            shuffle($words);
            array_splice($words, $cut);
        }

        $message .= ".\n\n" . self::getTextWords($words) . "\n\n" . self::getHashtag();

        try {
            Wall::post(Token::getToken(), $message, VK::getAttachmentGroup(['photo' => $photoId]));
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        self::endActions($run, array_column($words, 'word_eng_id'));
    }

    /**
     * Call actions after creating a post.
     *
     * @param int   $run
     * @param array $ids
     *
     * @return void
     */
    private static function endActions(int $run, array $ids): void
    {
        switch ($run) {
            case self::RUN_NEW:
                WordsEng::setPublishedAtNow($ids);
                break;
            case self::RUN_BAD_KNOWING:
                WordsEng::addRating($ids, -1);
                break;
            case self::RUN_FAVORITE:
                WordsEng::addFavorite($ids, -1);
                break;
        }
    }

    /**
     * Get the text words.
     *
     * @param array $words
     *
     * @return string
     */
    private static function getTextWords(array $words): string
    {
        $message = "";

        /*
         * Structure:
         *     Eng_word [transcription_eng] [transcription_rus] [#id]
         *     rus_word1, rus_word2, ..
         */
        foreach ($words as $word) {
            $message .= "- " . ucfirst($word->word_eng);

            if ($word->transcription_eng) {
                $message .= " [{$word->transcription_eng}]";
            }

            if ($word->transcription_rus) {
                $message .= " [{$word->transcription_rus}]";
            }

            $message .= " [#{$word->word_eng_id}]";

            // Rus words
            if (isset($word->translate)) {
                $message .= "\n" . implode(', ', array_column($word->translate, 'word_rus'));
            }

            $message .= "\n\n";
        }

        return trim($message);
    }
}
