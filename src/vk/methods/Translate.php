<?php

namespace gvk\vk\methods;

use gvk\vk\VK;

class Translate extends VK
{
    protected $table = 'translate'; // temporary
    const TABLE = 'translate';

    /**
     * Screening.
     *
     * @param string $comment
     *
     * @return array|false
     */
    public function checkCallback($comment)
    {
        $words = preg_replace('/ +/', ' ', $comment);
        $words = preg_split('/\n/', $words);

        if ( count($words) != 3 ) {
            return false;
        }

        $words = array_map('trim', $words);
        $words = preg_replace('/[\.|\!\?]/u', '', $words);

        foreach ($words as $key => $value) {
            $words[$key] = mb_strtolower($value);
        }

        $word_eng = $words[0];
        $transcription = $words[1];
        $word_rus = $words[2];

        // Англ. слово
        if ( ! preg_match('/^[a-z\s\']+$/u', $word_eng) ) {
            return false;
        }

        $word_eng = $this->upperFirst($word_eng);
        $words[0] = $this->upperI($word_eng);

        // Транскрипция
        if (!preg_match('/^[а-я\,\sёЁ]+$/u', $transcription)) {
            return false;
        }

        // Русское слово
        if (!preg_match('/^[а-я\,\sёЁ]+$/u', $word_rus)) {
            return false;
        }

        $words[2] = $this->upperFirst($word_rus);

        return $words;
    }

    /**
     * Database Addition.
     *
     * @param string $comment
     *
     * @return bool
     */
    public function addBD($comment)
    {
        $words = $this->checkCallback($comment);

        if ( is_bool($words) ) {
            return false;
        }

        $word_eng = array_shift($words);
        $transcription = array_shift($words);
        $word_rus = array_shift($words);

        if ( ! empty( $this->getData(['word_eng' => $word_eng], \PDO::FETCH_COLUMN) ) ) {
            return false;
        }

        return $this->insert([
            'word_eng'      => $word_eng,
            'transcription' => $transcription,
            'word_rus'      => $word_rus
        ]);
    }

    /**
     * New post only words.
     *
     * @param int $count
     * @param int $photoID
     *
     * @return object
     */
    public function newPostOnlyWords($count, $photoID)
    {
        $data = $this->getRandomCountData($count);
        $message = "";

        foreach ($data as $key => $item) {
            $i = $key + 1;
            $message .= $i . ". " . $item->word_eng . " [" . $item->transcription . "] - " . $item->word_rus . "\n";

            if ($i % 5 == 0) {
                $message .= "\n";
            }
        }

        $message .= "#words@eng_day";
        $attachments = 'photo-' . G_ID . '_' . $photoID;

        return $this->wallPost($message, $attachments);
    }

    /**
     * Get random word for new Post.
     *
     * @return string
     */
    public function getRandomWord()
    {
        $data = $this->getRandomSingleData();

        return '&#127468;&#127463; ' . $data->word_eng
            . ' [' . $data->transcription . '] - ' . $data->word_rus;
    }
}
