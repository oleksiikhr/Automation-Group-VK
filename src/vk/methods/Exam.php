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
        $polls1 = DB::getDistinctData(Polls::TABLE_1, 3);
        $polls2 = DB::getDistinctData(Polls::TABLE_2, 3);

        $arrPolls2 = [];
        foreach ($polls2 as $poll) {
            $pattern = array_fill(0, substr_count($poll->quest, '___'), '/___/ui');
            $replacement = explode(' / ', $poll->correct_answer);
            $arrPolls2[] = preg_replace($pattern, $replacement, $poll->quest, 1);
        }

        $message = "&#8505; Для лучшего запоминания/закрепления знаний, ответьте на вопросы ниже.\n\n"

            . "1. " . Translate::SMILE . " Перевод слов [рус, транскрипция]:\n"
            . "- " . $translate[0]->word_eng . ".\n"
            . "- " . $translate[1]->word_eng . ".\n"
            . "- " . $translate[2]->word_eng . ".\n\n"

            . "2. " . Verbs::SMILE . " Неправильные глаголы [3 формы]:\n"
            . "- " . $verbs[0]->first_form . ".\n"
            . "- " . $verbs[1]->second_form . ".\n"
            . "- " . $verbs[2]->third_form . ".\n\n"

            . "3. " . Polls::SMILE . " Перевод предложений [англ.]:\n"
            . "- " . $polls1[0]->quest . "\n"
            . "- " . $polls1[1]->quest . "\n"
            . "- " . $polls1[2]->quest . "\n\n"

            . "4. " . Polls::SMILE . " Перевод предложений [рус.]:\n"
            . "- " . $arrPolls2[0] . "\n"
            . "- " . $arrPolls2[1] . "\n"
            . "- " . $arrPolls2[2] . "\n\n"

            . "5. " . self::SMILE . " Вопросы:\n"
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
