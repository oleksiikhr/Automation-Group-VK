<?php

namespace gvk\vk\methods;

use gvk\vk\VK;

class Images extends VK
{
    const F_IMG   = 'img';
    const F_FUNNY = 'funny';

    /**
     * Create a new post Images.
     *
     * @return object
     */
    public function createPostImages()
    {
        $images = $this->getImages(self::F_IMG);

        $photo = '';
        foreach ($images[1] as $image) {
            $upload = $this->request(
                $this->photosGetWallUploadServer()->response->upload_url,
                true,
                'POST',
                [ 'photo' => curl_file_create($images[0] . '/' . $image) ]
            );

            $res = $this->photosSaveWallPhoto($upload->server, $upload->photo, $upload->hash);
            $photo .= 'photo' . $res->response[0]->owner_id . '_' . $res->response[0]->id . ',';
        }

        $message = ( new Translate() )->getRandomWord() . "\n" . ( new Verbs() )->getRandomVerb();
        return $this->createPost(
            $message . "\n#images@eng_day",
            $photo
        );
    }

    /**
     * Get link to download pictures.
     *
     * @return object
     */
    public function photosGetWallUploadServer()
    {
        return $this->send('photos.getWallUploadServer', [
            'group_id' => G_ID
        ], T_USR, true);
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
    public function photosSaveWallPhoto($server, $photo, $hash)
    {
        return $this->send('photos.saveWallPhoto', [
            'group_id' => G_ID,
            'server'   => $server,
            'photo'    => $photo,
            'hash'     => $hash
        ], T_USR, true);
    }

    /**
     * Get the directory and pictures from the folder.
     *
     * @param string $folder
     *
     * @return array|false
     */
    public function getImages($folder)
    {
        $dir = D_IMG . '/' . $folder;

        if ( ! file_exists($dir) )
            return false;

        $files = array_slice(scandir($dir), 2);

        if ( is_dir($dir . '/' . $files[0]) ) {
            return $this->getImages($folder . '/' . $files[array_rand($files)]);
        }

        return [$dir, $files];
    }
}
