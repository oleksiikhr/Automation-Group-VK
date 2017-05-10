<?php

namespace gvk\vk\methods;

use gvk\DB;
use gvk\vk\VK;
use gvk\Methods;

class Translate
{
    use Methods;

    const TABLE = 'translate';
    const SMILE = '&#127468;&#127463;';

    /**
     * Screening.
     *
     * @param string $text
     *
     * @return array|false
     */
    public static function checkCallback($text)
    {
        $words = preg_replace('/ +/', ' ', $text);
        $words = preg_split('/\n/', $words);

        if ( count($words) != 3 )
            return false;

        $words = array_map('trim', $words);
        $words = preg_replace('/[\.\!\?]/u', '', $words);

        foreach ($words as $key => $value) {
            $words[$key] = mb_strtolower($value);
        }

        // Eng word
        if ( ! preg_match('/^[a-z\s\']+$/u', $words[0]) )
            return false;

        // Transcription
        if ( ! preg_match('/^[а-я\,\sёЁ]+$/u', $words[1]) )
            return false;

        // Rus word
        if ( ! preg_match('/^[а-я\,\sёЁ]+$/u', $words[2]) )
            return false;

        $words[0] = self::upFirst( self::upI($words[0]) );
        $words[2] = self::upFirst($words[2]);

        return $words;
    }

    /**
     * Add data to the DB.
     *
     * @param string $text
     *
     * @return bool
     */
    public static function addDB($text)
    {
        $words = self::checkCallback($text);

        if ( empty($words) )
            return false;

        if ( ! empty( \QB::table(self::TABLE)->where('word_eng', '=', $words[0])->first() ) )
            return false;

        return \QB::table(self::TABLE)->insert([
            'word_eng'      => $words[0],
            'transcription' => $words[1],
            'word_rus'      => $words[2]
        ]);
    }

    /**
     * Get random unique values from the DB and create a new post.
     *
     * @param int $count
     * @param int $photoID
     *
     * @return object
     */
    public static function createPost($count, $photoID = null)
    {
        $data = DB::getDistinctData(self::TABLE, $count);
        $message = self::SMILE . " Перевод английских слов.\n\n";
        $i = 1;

        foreach ($data as $item) {
            $message .= "$i. {$item->word_eng} [{$item->transcription}] - {$item->word_rus}\n";

            if ($i++ % 5 == 0)
                $message .= "\n";
        }

        if ( ! empty($photoID) )
            $photoID = 'photo-' . G_ID . '_' . $photoID;

        return VK::wallPost($message . self::getHashtag(), $photoID);
    }

    /**
     * Get Hashtags for post.
     *
     * @return string
     */
    public static function getHashtag()
    {
        return '#words@' . G_URL;
    }

    /**
     * Get a random word for a new Post.
     *
     * @return string
     */
    public static function getRandom()
    {
        $data = DB::getRandomData(self::TABLE);

        return self::SMILE . " {$data->word_eng} [{$data->transcription}] - {$data->word_rus}";
    }
}
