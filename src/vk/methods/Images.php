<?php

namespace gvk\vk\methods;

use gvk\vk\VK;

class Images extends VK
{
    /**
     * Create new post Images.
     *
     * @return object
     */
    public function createPostImages()
    {
        $folders = scandir(D_IMG);
        $count = $folders[count($folders) - 1];

        $rnd = rand(1, $count);
        $images = scandir(D_IMG . $rnd);

        $photo = '';
        foreach ($images as $key => $image) {
            if ($key == 0 || $key == 1) continue;

            $upload = $this->request(
                $this->photosGetWallUploadServer()->response->upload_url,
                true,
                'POST',
                [ 'photo' => curl_file_create( realpath( D_IMG . $rnd . '/' . $image ) ) ]
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
     * Get upload link from vk api.
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
     * Save photos wall on vk server.
     *
     * @param string $server
     * @param $photo
     * @param $hash
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
}
