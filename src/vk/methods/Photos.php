<?php

namespace gvk\vk\methods;

use gvk\Web;
use gvk\vk\VK;

class Photos
{
    const F_IMG   = 'img';
    const F_FUNNY = 'funny';

    /**
     * Get images from the folder and create a new post.
     *
     * @return object|false
     */
    public static function createPost()
    {
        $images = self::getImages(self::F_IMG);

        if ( ! $images )
            return false;

        $photo = '';
        foreach ($images[1] as $image) {
            $upload = Web::request(self::getWallUploadServer()->response->upload_url, true, 'POST',
                ['photo' => curl_file_create($images[0] . '/' . $image)]);

            $res = self::saveWallPhoto($upload->server, $upload->photo, $upload->hash);
            $photo .= 'photo' . $res->response[0]->owner_id . '_' . $res->response[0]->id . ',';
        }

        $message = Translate::getRandom() . "\n" . Verbs::getRandom();
        return VK::wallPost($message . "\n#images@eng_day", $photo);
    }

    /**
     * Get link to download pictures.
     *
     * @return object
     */
    public static function getWallUploadServer()
    {
        return VK::send('photos.getWallUploadServer', [
            'group_id' => G_ID
        ], T_USR);
    }

    /**
     * Save photo to the wall.
     *
     * @param string $server
     * @param string $photo
     * @param string $hash
     *
     * @return object
     */
    public static function saveWallPhoto($server, $photo, $hash)
    {
        return VK::send('photos.saveWallPhoto', [
            'group_id' => G_ID,
            'server'   => $server,
            'photo'    => $photo,
            'hash'     => $hash
        ], T_USR);
    }

    /**
     * Get the directory and pictures from the folder.
     *
     * @param string $folder
     *
     * @return array|false
     */
    public static function getImages($folder)
    {
        $dir = D_IMG . '/' . $folder;

        if ( ! file_exists($dir) )
            return false;

        $files = array_slice( scandir($dir), 2 );

        if ( is_dir($dir . '/' . $files[0]) )
            return self::getImages($folder . '/' . $files[array_rand($files)]);

        return [$dir, $files];
    }
}
