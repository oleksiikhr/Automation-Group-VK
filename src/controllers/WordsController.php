<?php declare(strict_types=1);

namespace src\controllers;

use core\vk\methods\Wall;
use src\models\WordsEng;
use src\Controller;
use core\Token;

class WordsController extends Controller
{
    const SMILE = '&#127468;&#127463;';
    const HASHTAG = 'words';

    const RUN_NEW          = 1;
    const RUN_REPEAT       = 2;
    const RUN_BAD_KNOWING  = 3;
    const RUN_FAVORITE     = 4;

    const COUNT_LAST_WORDS_REPEAT = 30;

    /**
     * Main method.
     *
     * @param int $run
     * @param int $count of words
     * @param int $limit the number of records to retrieve from the database
     * @param int $offset
     * @param int|null $photoId from photo album
     *
     * @return void
     */
    public static function start(int $run, int $count = 5, int $limit = 5, int $offset = 0, ?int $photoId = null): void
    {
        $message = self::SMILE . " ";

        switch ($run) {
            case self::RUN_NEW:
                $message .= "Изучение новых слов";
                $words = WordsEng::getListOrderPublishedAt($limit, $offset);
                break;
            case self::RUN_REPEAT:
                $message .= "Повтор изученных недавно слов";
                $words = WordsEng::getListOrderPublishedAt($limit, $offset, 'DESC');
                break;
//            case self::RUN_BAD_KNOWING:
//                $words = WordsEng::getListOrderRating($count);
//                $message .= "Повтор плохо знающий слов";
//                break;
            default:
                die('RUN is not defined');
        }

        if ($count > $limit) {
            shuffle($words);
            array_splice($words, $count);
        }

        echo json_encode($words); die;

        // TODO Temporary
        $message .= ' | ver2';

        $message .= ".\n\n" . self::getTextWords($words) . "\n\n" . self::getHashtag();
        $attachment = $photoId ? self::getPhotoAttachment($photoId) : null;

        try {
            Wall::post(Token::getToken(), $message, $attachment);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        self::endActions($run, $words);
    }

    /**
     * Call actions after creating a post.
     *
     * @param int $run
     * @param array $words
     *
     * @return void
     */
    private static function endActions(int $run, array $words): void
    {
        $ids = array_column($words, 'word_eng_id');

        switch ($run) {
            case self::RUN_NEW:
                WordsEng::setPublishedAtNow($ids);
                break;
            case self::RUN_BAD_KNOWING:
                WordsEng::decrementRating($ids);
                break;
            default:
                return;
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

        // Eng_word [transcription_eng] [transcription_rus] #id
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
