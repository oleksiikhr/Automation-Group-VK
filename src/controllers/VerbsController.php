<?php declare(strict_types=1);

namespace src\controllers;

use core\vk\methods\Wall;
use src\models\Verbs;
use src\Controller;
use core\Token;

class VerbsController extends Controller
{
    const SMILE = '&#128203;';
    const HASHTAG = 'verbs';

    /**
     * Main method.
     *
     * @param int      $count
     * @param int      $offset
     * @param int|null $photoId from photo album in VK
     *
     * @return void
     */
    public static function start(int $count = 5, int $offset = 0, ?int $photoId = null): void
    {
        $verbs = Verbs::getList($count, $offset);
        $message = self::SMILE . " Список неправельных глаголов\n\n"
            . self::getTextWords($verbs) . "\n\n" . self::getHashtag();
        $attachment = $photoId ? self::getPhotoAttachment($photoId) : null;

        try {
            Wall::post(Token::getToken(), $message, $attachment);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        Verbs::setPublishedAtNow(array_column($verbs, 'word_eng_id'));
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

        /*
         * Structure:
         *     Eng_word, second_form, third_form [#id]
         *     rus_word1, rus_word2, ..
         */
        foreach ($words as $word) {
            $message .= "- " . ucfirst($word->word_eng) . ", {$word->second_form}, {$word->third_form} [#{$word->word_eng_id}]";

            // Rus words
            if (isset($word->translate)) {
                $message .= "\n" . implode(', ', array_column($word->translate, 'word_rus'));
            }

            $message .= "\n\n";
        }

        return trim($message);
    }
}
