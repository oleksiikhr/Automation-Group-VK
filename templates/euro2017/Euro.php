<?php

namespace tmp\euro2017;

use gvk\Web;
use gvk\vk\methods\Polls;
use gvk\vk\methods\Photos;

class Euro
{
    const TABLE = 'euro';

    public static function changeHeader($round = null)
    {
        // 1272px x 320px

        if ( empty($round) )
            self::generateHeaderFinal( \QB::table(self::TABLE)->where('isFinal', '=', true)->get() );
        else
            self::generateHeaderSemi( \QB::table(self::TABLE)->where('round', '=', $round)->get() );

//        self::setNewPhoto();
    }

    public static function parsePoll($round = null)
    {
        if ( empty($round) )
            $pollIDs = \QB::table(self::TABLE)
                ->where('poll_id', '>', 0)
                ->where('isFinal', '=', true)
                ->orderBy('time', 'ASC')
                ->get();
        else
            $pollIDs = \QB::table(self::TABLE)
                ->where('poll_id', '>', 0)
                ->where('round', '=', $round)
                ->orderBy('time', 'ASC')
                ->get();

        // ! Несколько токенов
        var_dump($pollIDs);
//        Polls::getById($pollIDs[0]->poll_id, T_USR);
    }

    public static function generateHeaderSemi($data)
    {
        $fon  = imagecreatefrompng(__DIR__ . '/resources/header.png');
        $count = count($data) / 2;

        for ($i = 0; $i < $count; $i++) {
            $li = $i * 34;
            $offset = ($i % 2 == 0) ? 0 : 160;

            self::addFlag($fon, $data[$i]->country, 30 + $offset, 10 + $li);
            self::addText($fon, 8 + $offset, 32 + $li, $i + 1, false, 18);
            self::addText($fon, 60 + $offset, 19 + $li, $data[$i]->name);
            self::addText($fon, 60 + $offset, 34 + $li, '"' . $data[$i]->song . '"');
            self::addText($fon, 28 + $offset, 41 + $li, $data[$i]->rating . '%', false, 11);

            self::addFlag($fon, $data[$i + $count]->country, 1220 - $offset, 10 + $li);
            self::addText($fon, 4 + $offset, 32 + $li, $i + $count + 1, true, 16);
            self::addText($fon, 60 + $offset, 19 + $li, $data[$i + $count]->name, true);
            self::addText($fon, 60 + $offset, 34 + $li, '"' . $data[$i + $count]->song . '"', true);
            self::addText($fon, 28 + $offset, 41 + $li, $data[$i + $count]->rating . '%', true, 11);
        }

        imagepng($fon, __DIR__ . '/resources/temp.png');
    }

    public static function generateHeaderFinal($data)
    {

    }

    public static function addText($fon, $x, $y, $text, $isRight = false, $size = 10)
    {
        if ($isRight) {
            $dimensions = imagettfbbox($size, 0, __DIR__ . '/resources/OpenSans.ttf', $text);
            $x = imagesx($fon) - abs($dimensions[4] - $dimensions[0]) - $x;
        }

        imagettftext(
            $fon, $size, 0, $x, $y, imagecolorallocate($fon, 255, 255, 255),
            __DIR__ . '/resources/OpenSans.ttf', $text
        );
    }

    public static function addFlag($fon, $flag, $x, $y)
    {
        list($width, $height) = getimagesize(__DIR__ . '/flags/' . $flag . '.png');
        $photo = imagecreatefrompng(__DIR__ . '/flags/' . $flag . '.png');
        imagecopymerge($fon, $photo, $x, $y, 0, 0, $width, $height, 100);
    }

    public static function setNewPhoto()
    {
        $uploadURL = Photos::getOwnerCoverPhotoUploadServer();

        $upload = Web::request(
            $uploadURL->response->upload_url, true, 'POST',
            ['photo' => curl_file_create(__DIR__ . '/resources/temp.png')]
        );

        return Photos::saveOwnerCoverPhoto($upload->hash, $upload->photo);
    }
}
