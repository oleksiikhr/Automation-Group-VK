<?php

namespace gvk\vk\methods;

use gvk\DB;
use gvk\vk\VK;

class Exam
{
    /**
     * Create a new post exam.
     *
     * @param int $photoID
     *
     * @return object
     */
    public static function createPost($photoID = null)
    {
        if ( ! empty($photoID) )
            $photoID = 'photo-' . G_ID . '_' . $photoID;

        $translate = DB::getRandomData(Translate::TABLE);
        $verb = DB::getRandomData(Verbs::TABLE);

        $message = "&#8505; Экспериментальная функция.\n\n"
            . "Необходимо ответить на вопросы:\n"
            . "&#127468;&#127463; 1. Переведите слово: {$translate->word_eng}\n"
            . "&#128203; 2. Вторая форма глагола: {$verb->first_form}\n\n"
            . "Ответов нет. &#128521;\n"
            . "#exam@eng_day";

        return VK::wallPost($message, $photoID);
    }
}
