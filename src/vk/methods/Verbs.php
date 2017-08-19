<?php

namespace gvk\vk\methods;

use gvk\DB;
use gvk\vk\VK;

class Verbs
{
    const TABLE = 'verbs';
    const SMILE = '&#128203;';

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
        $message = self::SMILE . " Список неправильных глаголов.\n\n";

        foreach ($data as $key => $item) {
            $i = $key + 1;
            $message .= "$i. {$item->first_form} - {$item->second_form} - {$item->third_form}\n";

            if ($i % 5 == 0) {
                $message .= "\n";
            }
        }

        if (! empty($photoID)) {
            $photoID = 'photo-' . G_ID . '_' . $photoID;
        }

        return VK::wallPost($message . self::getHashtag(), $photoID, true);
    }

    /**
     * Get Hashtag for post.
     *
     * @return string
     */
    public static function getHashtag()
    {
        return '#verbs@' . G_URL;
    }

    /**
     * Get a random verb for a new post.
     *
     * @return string
     */
    public static function getRandom()
    {
        $data = DB::getRandomData(self::TABLE);

        return self::SMILE . " {$data->first_form} - {$data->second_form} - {$data->third_form}";
    }
}
