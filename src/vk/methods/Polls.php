<?php

namespace gvk\vk\methods;

use gvk\vk\VK;

class Polls extends VK
{
    protected $table = null;

    /**
     * Constructor.
     *
     * @param string $table
     */
    public function __construct($table)
    {
        parent::__construct();

        if ($table == 'type1') {
            $this->table = 'polyglot';
        } elseif ($table == 'type2') {
            $this->table = 'choose';
        }
    }

    /**
     * Screening Polyglot.
     *
     * @param string $text
     *
     * @return array|false
     */
    public function checkCallbackPolyglot($text)
    {
        $words = preg_replace('| +|', ' ', $text); // Убираем n-пробелы
        $words = preg_split('/\n/', $words); // Разбиваем на массив

        if ( count($words) < 4 ) {
            return false;
        }

        $words = array_map('trim', $words);
        $quest = $words[0];
        $lastCharQuest = mb_substr($quest, -1);

        if ( preg_match('/[a-z]+/ui', $quest) ) {
            return false;
        }

        if ($lastCharQuest != '!' && $lastCharQuest != '?' && $lastCharQuest != '.') {
            $quest .= '.';
            $lastCharQuest = '.';
        }

        $words[0] = $this->upFirst($quest);

        // Для ответов
        foreach ($words as $key => $ans) {
            if ($key == 0) continue;

            if ( preg_match('/[а-яёЁ]+/ui', $ans) ) { // Если есть рус. символы
                return false;
            }

            $lastCharAnswer = mb_substr($ans, -1);

            if ( ($lastCharAnswer == '!' || $lastCharAnswer == '?' || $lastCharAnswer == '.')
                && $lastCharAnswer != $lastCharQuest ) return false;

            $words[$key] = $this->upI($words[$key]);
            $words[$key] = $this->upFirst($words[$key]);

            if ($lastCharQuest != $lastCharAnswer) {
                $words[$key] .= $lastCharQuest;
            }
        }

        return $words;
    }

    /**
     * Screening Choose.
     *
     * @param string $text
     *
     * @return array|false
     */
    public function checkCallbackChoose($text)
    {
        $words = preg_replace('| +|', ' ', $text); // Убираем n-пробелы
        $words = preg_split('/\n/', $words); // Разбиваем на массив

        if ( count($words) < 3 ) {
            return false;
        }

        $words = array_map('trim', $words);

        foreach ($words as $word) {
            if ( preg_match('/[а-яёЁ]+/ui', $word) ) {
                return false;
            }
        }

        $count = substr_count($words[0], '@');

        $words[0] = $this->upFirst($words[0]);
        $words[0] = str_replace('@', '___', $words[0]);

        $lastCharQuest = mb_substr($words[0], -1);
        if ($lastCharQuest != '!' && $lastCharQuest != '?' && $lastCharQuest != '.') {
            $words[0] .= '.';
        }

        if ( empty($count) ) {
            return false;
        }

        if ($count > 1) {
            foreach ($words as $key => $word) {
                if ($key == 0) continue;

                if ( ! preg_match('/^[a-z\s]+'.str_repeat('\s\/\s[a-z\s]+', $count - 1).'$/ui', $word) ) {
                    return false;
                }
            }
        }

        return $words;
    }

    /**
     * Screening.
     *
     * @param string $text
     *
     * @return array|false
     */
    public function checkCallback($text)
    {
        if ($this->table === 'polyglot') {
            return $this->checkCallbackPolyglot($text);
        } elseif ($this->table === 'choose') {
            return $this->checkCallbackChoose($text);
        } else {
            return false;
        }
    }

    /**
     * Get Hashtags for post Poll.
     *
     * @return string
     */
    public function getHashtags()
    {
        if ($this->table === 'type1') {
            return '#polls@eng_day #polls_type1@eng_day';
        } elseif ($this->table === 'type2') {
            return '#polls@eng_day #polls_type2@eng_day';
        } else {
            return false;
        }
    }

    /**
     * Database Addition.
     *
     * @param string $text
     *
     * @return bool
     */
    public function addDB($text)
    {
        $words = $this->checkCallback($text);

        if ( is_bool($words) ) {
            return false;
        }

        $quest = array_shift($words);
        $correct_answer = array_shift($words);
        $answers = base64_encode( serialize($words) );

        if ( ! empty( $this->getData(['quest' => $quest], \PDO::FETCH_COLUMN) ) ) {
            return false;
        }

        return $this->insert([
            'quest' => $quest,
            'correct_answer' => $correct_answer,
            'answers' => $answers
        ]);
    }

    /**
     * Create new post poll.
     *
     * @param int $photo_id
     *
     * @return object
     */
    public function createPostPolls($photo_id = null)
    {
        $data = $this->getRandomSingleData();

        $quest = $data->quest;
        $answers = $data->answers;
        $correct_answer = $data->correct_answer;
        $message = ( new Translate() )->getRandom() . "\n"
            . ( new Verbs() )->getRandom() . "\n"
            . $this->getHashtags();

        $answers = unserialize( base64_decode($answers) );
        shuffle($answers);
        $answers = array_slice($answers, 0, 2);
        array_unshift($answers, $correct_answer);
        shuffle($answers);
        $answers[count($answers)] = 'Узнать результаты.';
        $answers = '["' . implode('","', $answers) . '"]';

        $json = $this->send('polls.create', [
            'question'     => $quest,
            'is_anonymous' => 1,
            'owner_id'     => '-' . G_ID,
            'add_answers'  => $answers
        ], T_USR);

        $attachments = 'poll' . $json->response->owner_id . '_' . $json->response->id;

        if ( ! empty($photo_id) ) {
            $attachments .= ',photo-' . G_ID . '_' . $photo_id;
        }

        $createPost = $this->wallPost($message, $attachments);

        $comment = "&#9989; Правильный ответ:\n"
            . str_repeat("&#128315;\n", 8)
            . "&#127468;&#127463; " . $correct_answer;

        return $this->wallCreateComment($comment, $createPost->response->post_id);
    }
}
