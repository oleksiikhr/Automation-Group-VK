<?php

namespace gvk\vk\methods;

use gvk\DB;
use gvk\vk\VK;

class Exam
{
    const TABLE = 'exam';
    const SMILE = '&#128193;';

    /**
     * Get random data from different tables and create a post.
     *
     * @param int $photoID
     *
     * @return object
     */
    public static function createPost($photoID = null)
    {
        if (! empty($photoID)) {
            $photoID = 'photo-' . G_ID . '_' . $photoID;
        }

        $translate = DB::getRandomData(Translate::TABLE);
        $poll = DB::getRandomData(Polls::TABLE_1);
        $verb = DB::getRandomData(Verbs::TABLE);
//        $exam = DB::getRandomData(self::TABLE);

        $message = "&#8505; Нужно ответить на вопросы.\n\n"
            . "1. " . Translate::SMILE . " Переведите слово: {$translate->word_eng}\n"
            . "2. " . Polls::SMILE . " Переведите предложение: {$poll->quest}\n"
            . "3. " . Verbs::SMILE . " Вторая форма глагола: {$verb->first_form}\n"
//            . "4. " . self::SMILE . " {$exam->question}\n"
            . "\nОтветов нет. &#128521;\n";

        return VK::wallPost($message . self::getHashtag(), $photoID);
    }

    /**
     * Get Hashtag for post.
     *
     * @return string
     */
    public static function getHashtag()
    {
        return '#exam@' . G_URL;
    }
}
