<?php declare(strict_types=1);

namespace core\vk\methods;

use core\enums\HttpMethod;
use core\vk\VK;

class Photos
{
    /**
     * Returns the server address for photo upload onto a user's wall.
     *
     * @param  string  $token
     * @return mixed
     * @throws \Exception
     *
     * @see https://vk.com/dev/photos.getWallUploadServer
     */
    public static function getWallUploadServer(string $token)
    {
        return VK::send($token, 'photos.getWallUploadServer', [
            'group_id' => G_ID,
        ], HttpMethod::GET);
    }

    /**
     * Saves a photo to a user's or community's wall after being uploaded.
     *
     * @param  string  $token
     * @param  string|int  $photo
     * @param  string|int  $server
     * @param  string|int  $hash
     * @return mixed
     * @throws \Exception
     *
     * @see https://vk.com/dev/photos.saveWallPhoto
     */
    public static function saveWallPhotoGroup(string $token, $photo, $server, $hash)
    {
        return VK::send($token, 'photos.saveWallPhoto', [
            'group_id' => G_ID,
            'server'   => $server,
            'photo'    => $photo,
            'hash'     => $hash,
        ], HttpMethod::POST);
    }

    /**
     * Receives server address for uploading community cover.
     *
     * @param  string  $token
     * @param  int  $cropX - X coordinate of the left-upper corner.
     * @param  int  $cropY - Y coordinate of the left-upper corner.
     * @param  int  $cropX2 - X coordinate of the right-bottom corner.
     * @param  int  $cropY2 - Y coordinate of the right-bottom corner.
     * @return mixed
     * @throws \Exception
     *
     * @see https://vk.com/dev/photos.getOwnerCoverPhotoUploadServer
     */
    public static function getOwnerCoverPhotoUploadServer(string $token, int $cropX, int $cropY, int $cropX2, int $cropY2)
    {
        return VK::send($token, 'photos.getOwnerCoverPhotoUploadServer', [
            'group_id' => G_ID,
            'crop_x'   => $cropX,
            'crop_y'   => $cropY,
            'crop_x2'  => $cropX2,
            'crop_y2'  => $cropY2,
        ], HttpMethod::GET);
    }

    /**
     * Saves cover photo after successful uploading.
     *
     * @param  string  $token
     * @param  string  $hash
     * @param  string  $photo
     * @return mixed
     * @throws \Exception
     *
     * @see https://vk.com/dev/photos.saveOwnerCoverPhoto
     */
    public static function saveOwnerCoverPhoto(string $token, string $hash, string $photo)
    {
        return VK::send($token, 'photos.saveOwnerCoverPhoto', [
            'hash'  => $hash,
            'photo' => $photo,
        ], HttpMethod::POST);
    }
}
