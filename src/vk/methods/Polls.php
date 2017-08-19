<?php

namespace gvk\vk\methods;

use gvk\DB;
use gvk\vk\VK;
use gvk\Methods;

class Polls
{
    use Methods;

    const TABLE_1 = 'poll_type1';
    const TABLE_2 = 'poll_type2';
    const TABLE_3 = 'poll_type3';
    const SMILE   = '&#128218;';

    /**
     * Screening - distribute.
     *
     * @param string $text
     * @param string $table
     *
     * @return array|false
     */
    public static function checkCallback($text, $table)
    {
        if ($table == self::TABLE_1)
            return self::checkCallbackType1($text);

        if ($table == self::TABLE_2)
            return self::checkCallbackType2($text);

        if ($table == self::TABLE_3)
            return self::checkCallbackType3($text);

        return false;
    }

    /**
     * Screening Type 1.
     *
     * @param string $text
     *
     * @return array|false
     */
    public static function checkCallbackType1($text)
    {
        $words = preg_replace('/ +/', ' ', trim($text));
        $words = preg_split('/\n/', $words,  -1, PREG_SPLIT_NO_EMPTY);

        if (count($words) < 4) {
            return false;
        }

        $words = array_map('trim', $words);
        $lastCharQuest = mb_substr($words[0], -1);

        if (preg_match('/[a-z]+/ui', $words[0])) {
            return false;
        }

        if ($lastCharQuest != '!' && $lastCharQuest != '?' && $lastCharQuest != '.') {
            $words[0] .= '.';
            $lastCharQuest = '.';
        }

        $words[0] = self::upFirst($words[0]);

        foreach ($words as $key => $ans) {
            if ($key == 0) {
                continue;
            }

            if (preg_match('/[а-яёЁ]+/ui', $ans)) {
                return false;
            }

            $lastCharAnswer = mb_substr($ans, -1);

            if (($lastCharAnswer == '!' || $lastCharAnswer == '?' || $lastCharAnswer == '.')
                    && $lastCharAnswer != $lastCharQuest) {
                return false;
            }

            $words[$key] = self::upI(self::upFirst($words[$key]));

            if ($lastCharQuest != $lastCharAnswer) {
                $words[$key] .= $lastCharQuest;
            }
        }

        return $words;
    }

    /**
     * Screening type 2.
     *
     * @param string $text
     *
     * @return array|false
     */
    public static function checkCallbackType2($text)
    {
        $words = preg_replace('/ +/', ' ', trim($text));
        $words = preg_split('/\n/', $words,  -1, PREG_SPLIT_NO_EMPTY);

        if (count($words) < 3)
            return false;

        $words = array_map('trim', $words);

        foreach ($words as $word) {
            if ( preg_match('/[а-яёЁ]+/ui', $word) ) {
                return false;
            }
        }

        $count = substr_count($words[0], '@');

        $words[0] = self::upFirst($words[0]);
        $words[0] = str_replace('@', '___', $words[0]);

        $lastCharQuest = mb_substr($words[0], -1);

        if ($lastCharQuest != '!' && $lastCharQuest != '?' && $lastCharQuest != '.') {
            $words[0] .= '.';
        }

        if (empty($count)) {
            return false;
        }

        if ($count > 1) {
            foreach ($words as $key => $word) {
                if ($key == 0) {
                    continue;
                }

                if (! preg_match('/^[a-z\s]+' . str_repeat('\s\/\s[a-z\s]+', $count - 1) . '$/ui', $word)) {
                    return false;
                }
            }
        }

        return $words;
    }

    /**
     * Screening type 3.
     *
     * @param string $text
     *
     * @return array|false
     */
    public static function checkCallbackType3($text)
    {
        $words = preg_replace('/ +/', ' ', $text);
        $words = preg_split('/\n/', $words,  -1, PREG_SPLIT_NO_EMPTY);

        if (count($words) < 3) {
            return false;
        }

        $words = array_map('trim', $words);

        foreach ($words as $word) {
            if (preg_match('/[а-яёЁ]+/ui', $word)) {
                return false;
            }
        }

        $lastCharQuest = mb_substr($words[0], -1);

        if ($lastCharQuest != '!' && $lastCharQuest != '?' && $lastCharQuest != '.') {
            $words[0] .= '.';
            $lastCharQuest = '.';
        }

        $words[0] = self::upFirst($words[0]);

        foreach ($words as $key => $ans) {
            if (preg_match('/[а-яёЁ]+/ui', $ans)) {
                return false;
            }

            $lastCharAnswer = mb_substr($ans, -1);

            if (($lastCharAnswer == '!' || $lastCharAnswer == '?' || $lastCharAnswer == '.')
                && $lastCharAnswer != $lastCharQuest) {
                return false;
            }

            $words[$key] = self::upI(self::upFirst($words[$key]));

            if ($lastCharQuest != $lastCharAnswer) {
                $words[$key] .= $lastCharQuest;
            }
        }

        return $words;
    }

    /**
     * Get Hashtag for post.
     *
     * @param string $table
     *
     * @return string
     */
    public static function getHashtag($table)
    {
        if ($table == self::TABLE_1)
            return '#polls@' . G_URL . ' #polls_type1@' . G_URL;

        if ($table == self::TABLE_2)
            return '#polls@' . G_URL . ' #polls_type2@' . G_URL;

        if ($table == self::TABLE_3)
            return '#polls@' . G_URL . ' #polls_type3@' . G_URL;

        return '';
    }

    /**
     * Database Addition.
     *
     * @param string $text
     * @param string $table
     *
     * @return bool
     */
    public static function addDB($text, $table)
    {
        $words = self::checkCallback($text, $table);

        if (empty($words)) {
            return false;
        }

        if ($table == self::TABLE_1 || $table == self::TABLE_2) {
            $quest = array_shift($words);
            $correct_answer = array_shift($words);
            $answers = base64_encode(serialize($words));

            if (! empty(\QB::table($table)->select('*')->where('quest', '=', $quest)->first())) {
                return false;
            }

            return \QB::table($table)->insert([
                'quest'          => $quest,
                'correct_answer' => $correct_answer,
                'answers'        => $answers
            ]);
        }

        // For Poll_type3

        $correct_answer = array_shift($words);
        $answers = base64_encode(serialize($words));

        if (! empty(\QB::table($table)->select('*')->where('correct_answer', '=', $correct_answer)->first())) {
            return false;
        }

        return \QB::table($table)->insert([
            'correct_answer' => $correct_answer,
            'answers'        => $answers
        ]);
    }

    /**
     * Create a new post with poll.
     *
     * @param string $table
     * @param int    $photo_id
     *
     * @return object
     */
    public static function createPost($table, $photo_id = null)
    {
        if ($table == self::TABLE_3) {
            return self::createPostType3($table, $photo_id);
        }

        $data = DB::getRandomData($table);
        $message = Translate::getRandom() . "\n" . Verbs::getRandom() . "\n" . self::getHashtag($table);

        $data->answers = unserialize(base64_decode($data->answers));
        shuffle($data->answers);
        $data->answers = array_slice($data->answers, 0, 2);
        array_unshift($data->answers, $data->correct_answer);
        shuffle($data->answers);
        $data->answers[] = 'Узнать результаты.';

        $createdPoll = self::create(self::SMILE . ' ' . $data->quest, $data->answers);
        $attachments = 'poll' . $createdPoll->response->owner_id . '_' . $createdPoll->response->id;

        if (! empty($photo_id)) {
            $attachments .= ',photo-' . G_ID . '_' . $photo_id;
        }

        $createdPost = VK::wallPost($message, $attachments);

        $comment = "&#9989; Правильный ответ:\n"
            . str_repeat("&#128315;\n", 8)
            . self::SMILE . " " . $data->correct_answer;
//            . "\n\n" . "&#128394; Объяснений нет..";
//        TODO: add explanation

        return VK::wallCreateComment($comment, $createdPost->response->post_id);
    }

    /**
     * Create a new post with poll.
     *
     * @param string $table
     * @param int    $photo_id
     *
     * @return object
     */
    public static function createPostType3($table, $photo_id = null)
    {
        $data = DB::getRandomData($table);
        $message = Translate::getRandom() . "\n" . Verbs::getRandom() . "\n" . self::getHashtag($table);

        $data->answers = unserialize(base64_decode($data->answers));
        shuffle($data->answers);
        $data->answers = array_slice($data->answers, 0, 2);
        array_unshift($data->answers, $data->correct_answer);
        shuffle($data->answers);
        $data->answers[] = 'Узнать результаты.';

        $createdPoll = self::create(self::SMILE . ' Выберите правильный вариант.', $data->answers);
        $attachments = 'poll' . $createdPoll->response->owner_id . '_' . $createdPoll->response->id;

        if (! empty($photo_id)) {
            $attachments .= ',photo-' . G_ID . '_' . $photo_id;
        }

        $createdPost = VK::wallPost($message, $attachments);

        $comment = "&#9989; Правильный ответ:\n"
            . str_repeat("&#128315;\n", 8)
            . self::SMILE . " " . $data->correct_answer;
//            . "\n\n" . "&#128394; Объяснений нет..";
//        TODO: add explanation

        return VK::wallCreateComment($comment, $createdPost->response->post_id);
    }

    /**
     * Create a new poll.
     *
     * @param string $quest
     * @param array  $answers
     * @param bool   $isAnonymous
     *
     * @return object
     */
    public static function create($quest, $answers, $isAnonymous = true)
    {
        return VK::send('polls.create', [
            'question'     => $quest,
            'owner_id'     => '-' . G_ID,
            'add_answers'  => json_encode($answers),
            'is_anonymous' => $isAnonymous
        ], T_USR);
    }

    /**
     * Returns detailed information about the poll by its identifier.
     *
     * @param int    $pollID
     * @param string $token
     *
     * @return object
     */
    public static function getById($pollID, $token = T_USR)
    {
        return VK::send('polls.getById', [
            'owner_id' => '-' . G_ID,
            'poll_id'  => $pollID
        ], $token);
    }
}
