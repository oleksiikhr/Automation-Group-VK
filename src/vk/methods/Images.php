<?php

namespace gvk\vk\methods;

use gvk\Web;
use gvk\vk\VK;

class Images
{
    const F_IMG   = 'img';
    const F_CARD  = 'card';
    const F_FUNNY = 'fun';

    /**
     * Get images from the folder and create a new post.
     *
     * @param string $type
     *
     * @return false|object
     */
    public static function createPost($type)
    {
        $images = self::getImages($type == self::F_IMG ? self::F_IMG : $type);

        if (! $images) {
            return false;
        }

        if ($type == self::F_IMG) {
            $attachments = '';

            foreach ($images[1] as $image) {
                $attachments .= self::getUploadWallImageComplex($images[0] . '/' . $image) . ',';
            }
        } else {
            $attachments = self::getUploadWallImageComplex($images[0] . '/' . $images[1][mt_rand(0, count($images[1]))]);
        }

        $message = Translate::getRandom() . "\n" . Verbs::getRandom() . "\n";

        return VK::wallPost($message . self::getHashtag($type), $attachments);
    }

    /**
     * Get Hashtag for post.
     *
     * @param string $type
     *
     * @return string
     */
    public static function getHashtag($type)
    {
        if ($type == self::F_IMG)
            return '#images@' . G_URL . ' #img@' . G_URL;

        if ($type == self::F_FUNNY)
            return '#images@' . G_URL . ' #fun@' . G_URL;

        if ($type == self::F_CARD)
            return '#images@' . G_URL . ' #card@' . G_URL;

        return '';
    }

    /**
     * All in one method.
     *
     * @param string $uri - URL Image
     *
     * @return string
     */
    public static function getUploadWallImageComplex($uri)
    {
        $upload = Web::request(self::getWallUploadServer()->response->upload_url, true, 'POST',
            ['photo' => curl_file_create($uri)]);

        $res = self::saveWallPhoto($upload->server, $upload->photo, $upload->hash);
        return 'photo' . $res->response[0]->owner_id . '_' . $res->response[0]->id . ',';
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

        if (! file_exists($dir)) {
            return false;
        }

        $files = array_slice(scandir($dir), 2);

        if (is_dir($dir . '/' . $files[0]))
            return self::getImages($folder . '/' . $files[array_rand($files)]);

        return [$dir, $files];
    }

    /**
     * Gets the address to download the cover of the community.
     *
     * @param int $x
     * @param int $y
     *
     * @return object
     */
    public static function getOwnerCoverPhotoUploadServer($x = null, $y = null)
    {
        return VK::send('photos.getOwnerCoverPhotoUploadServer', [
            'group_id' => G_ID,
            'crop_x2'  => $x,
            'crop_y2'  => $y
        ], T_IMG);
    }

    /**
     * Saves the image for the community cover after a successful download.
     *
     * @param string $hash
     * @param string $photo
     *
     * @return object
     */
    public static function saveOwnerCoverPhoto($hash, $photo)
    {
        return VK::send('photos.saveOwnerCoverPhoto', [
            'hash'   => $hash,
            'photo'  => $photo
        ], T_IMG);
    }
}
