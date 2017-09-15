<?php

namespace tmp\game;

use gvk\Web;
use gvk\vk\VK;
use gvk\vk\methods\Images;

class Game
{
    const TABLE = 'game';

    /**
     * New member in the group.
     *
     * @param object $data
     *
     * @return bool
     */
    public static function getBestUsers($data)
    {

    }

    public static function checkingGame()
    {
//        $q = \DB::table(Game::TABLE)->where('is_finished', '=', 0)->first();
//
//        if ($q && strtotime($q->time) > time() + 1080) {
//
//        } else {
//            $q = \DB::table(Game::TABLE)->where('is_finished', '=', 1)->first();
//            if ($q && strtotime($q->time) > time() + 360) {
//                $word = DB::getRandomData(Translate::TABLE);
//                \DB::talbe(Game::TABLE)->insert([
//                    'word' => $word->word_eng,
//                    'answer' => str_repeat('*', strlen($word->word_eng)),
//                ]);
//                // Generate Templates 1
//            }
//        }
    }

    /**
     * Generate a logo for the group.
     *
     * @param string $text
     * @param string $img
     *
     * @return void
     */
    public static function generateLogo($text, $img)
    {
        $fon  = imagecreatefrompng(__DIR__ . '/header/fon.png');
        $photo = imagecreatefromjpeg($img);

        imagecopymerge($fon, $photo, 638, 49, 0, 0, 100, 100, 100);

        imagettftext(
            $fon, 11, 0, 657, 164, 0,
            __DIR__ . '/fonts/DroidSerif-Regular.ttf', $text
        );

        imagepng($fon, __DIR__ . '/header/temp.png');
    }

    /**
     * Pour the generated photo into the group.
     *
     * @return object
     */
    public static function setNewPhoto()
    {
        $uploadURL = Images::getOwnerCoverPhotoUploadServer();

        $upload = Web::request(
            $uploadURL->response->upload_url, true, 'POST',
            ['photo' => curl_file_create(__DIR__ . '/header/temp.png')]
        );

        return Images::saveOwnerCoverPhoto($upload->hash, $upload->photo);
    }
}
