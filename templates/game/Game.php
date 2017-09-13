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
        $user = VK::send('users.get', [
            'user_ids' => $data->user_id,
            'fields'   => 'photo_100'
        ], T_USR);

        self::generateLogo($user->response[0]->first_name, $user->response[0]->photo_100);
        $photo = self::setNewPhoto();

        return empty($photo->error);
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
