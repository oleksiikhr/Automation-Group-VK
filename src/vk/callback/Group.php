<?php

namespace gvk\vk\callback;

use gvk\vk\VK;

class Group extends VK
{
    public function groupJoin($data)
    {
        $user = $this->send('users.get', [
            'user_ids' => $data->user_id,
            'fields'   => 'photo_100'
        ], TOKEN_USER);

        $this->generateLogo($user->response[0]->first_name, $user->response[0]->photo_100);
        $this->setNewPhoto();
    }

    public function generateLogo($text, $img)
    {
        $fon  = imagecreatefrompng(__DIR__ . '/header/fon.png');
        $photo = imagecreatefromjpeg($img);

        imagecopymerge($fon, $photo, 638, 49, 0, 0, 100, 100, 100);

        imagettftext(
            $fon,
            11,
            0,
            657,
            164,
            0,
            __DIR__ . '/header/MarckScript.ttf',
            $text
        );

        imagepng($fon, __DIR__ . '/header/temp.png');
    }

    public function setNewPhoto()
    {
        $uploadURL = $this->send('photos.getOwnerCoverPhotoUploadServer', [
            'group_id' => GROUP_ID
        ], TOKEN_GROUP_IMG);

        $upload = $this->request(
            $uploadURL->response->upload_url,
            true,
            'POST',
            [ 'photo' => curl_file_create( realpath( __DIR__ . '/header/temp.png' ) ) ]
        );

        $this->send('photos.saveOwnerCoverPhoto', [
            'hash'   => $upload->hash,
            'photo'  => $upload->photo
        ], TOKEN_GROUP_IMG);
    }
}
