<?php

namespace gvk\vk\methods;

use gvk\DB;
use gvk\vk\VK;

class Learn
{
    const TABLE = 'learn';

    /**
     * Create a new post learn.
     *
     * @param int $photoID
     *
     * @return object
     */
    public static function createPost($photoID = null)
    {
        $data = DB::getRandomData(self::TABLE);

        $title = $data->title;
        $text = self::formatText($data->text);

        if ( ! empty($photoID) )
            $photoID = 'photo-' . G_ID . '_' . $photoID;

        $message = "&#128221; {$title}\n\n{$text}\n\n";
        return VK::wallPost($message . self::getHashtag(), $photoID, 'POST');
    }

    /**
     * Get Hashtag for post.
     *
     * @return string
     */
    public static function getHashtag()
    {
        return '#learn@' . G_URL;
    }

    /**
     * Formatting text.
     *
     * @param string $text
     *
     * @return string
     */
    public static function formatText($text)
    {
        $text = str_replace('%subtitle%', '&#128161;', $text);
        $text = str_replace('%li%', '&#128204;', $text);

        return $text;
    }
}
