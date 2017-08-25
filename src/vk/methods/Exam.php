<?php

namespace gvk\vk\methods;

use gvk\DB;
use gvk\vk\VK;

class Exam
{
    const TABLE = 'exam';
    const SMILE = '&#9999;';

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

        $translate = DB::getDistinctData(Translate::TABLE, 3);
        $verbs = DB::getDistinctData(Verbs::TABLE, 3);
        $polls = DB::getDistinctData(Polls::TABLE_1, 3);

        $message = "&#8505; Для лучшего запоминания/закрепления знаний, ответьте на вопросы ниже.\n\n"

            . "1. " . Translate::SMILE . " Слова:\n"
            . "- " . $translate[0]->word_eng . " [рус., транскрипция]\n"
            . "- " . $translate[1]->word_eng . " [рус., транскрипция]\n"
            . "- " . $translate[2]->word_eng . " [рус., транскрипция]\n\n"

            . "2. " . Verbs::SMILE . " Неправильные глаголы:\n"
            . "- " . $verbs[0]->second_form . " [1-я форма]\n"
            . "- " . $verbs[1]->first_form . " [2-я форма]\n"
            . "- " . $verbs[2]->first_form . " [3-я форма]\n\n"

            . "3. " . Polls::SMILE . " Предложения:\n"
            . "- " . $polls[0]->quest . " [англ.]\n"
            . "- " . $polls[1]->quest . " [англ.]\n"
            . "- " . $polls[2]->correct_answer . " [рус.]\n\n"

            . "4. " . self::SMILE . " Вопросы:\n"
            . "- " . "Пусто.\n"
            . "Пишите в комментариях вопросы, которые вы бы хотели видеть тут.\n\n"

            . "Ответов нет. &#128521;\n";

        return VK::wallPost($message . self::getHashtag(), $photoID, 'POST');
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
