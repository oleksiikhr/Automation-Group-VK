<?php

namespace tmp\euro2017;

use gvk\Web;
use gvk\vk\VK;
use gvk\vk\methods\Polls;
use gvk\vk\methods\Photos;

class Euro
{
    const TABLE = 'euro';

    public static function createPost()
    {
        $data = \QB::table(self::TABLE)->where('poll_id', '=', '0')->first();

        $poll = self::createPoll();
        $message = "&#8505; Country: {$data->country}\n&#10004; Artist: {$data->name}\n&#127925; Song: {$data->song}";
        VK::wallPost($message . "\n\n" . self::getHashtag(), 'poll-' . G_ID . '_' . $poll->response->id);

        \QB::table(self::TABLE)->where('id', '=', $data->id)->update([
            'poll_id' => $poll->response->id
        ]);
    }

    public static function createPoll()
    {
        return Polls::create('Do you like this song?', ['Yes', 'No']);
    }

    public static function getHashtag()
    {
        return '#eurovision2017@' . G_URL;
    }

    public static function changeHeader($round = 0)
    {
        if ( empty($round) )
            self::generateHeaderFinal( \QB::table(self::TABLE)
                ->where('isFinal', '=', true)
                ->orderBy('rating', 'DESC')
                ->get() );
        else
            self::generateHeaderSemi( \QB::table(self::TABLE)
                ->where('round', '=', $round)
                ->orderBy('rating', 'DESC')
                ->get(), $round );

        self::setNewPhoto($round);
    }

    public static function parsePoll($round = null)
    {
        if ( empty($round) )
            $pollIDs = \QB::table(self::TABLE)
                ->where('poll_id', '>', 0)
                ->where('isFinal', '=', true)
                ->orderBy('time', 'ASC')
                ->limit(3)
                ->get();
        else
            $pollIDs = \QB::table(self::TABLE)
                ->where('poll_id', '>', 0)
                ->where('round', '=', $round)
                ->orderBy('time', 'ASC')
                ->limit(3)
                ->get();

        if ( empty($pollIDs) )
            return;

        $tokens = [T_USR, T_USR2, T_USR3];

        foreach ($pollIDs as $key => $pollID) {
            $poll = Polls::getById($pollID->poll_id, $tokens[$key % count($tokens)]);

            if ( ! empty($poll->error) )
                continue;

            \QB::table(self::TABLE)->where('id', '=', $pollID->id)->update([
                'rating' => empty($poll->response->answers[0]->rate) ? 0 : $poll->response->answers[0]->rate,
                'time'   => date( 'Y-m-d H:i:s', time() )
            ]);
        }
    }

    public static function generateHeaderSemi($data, $round)
    {
        $fon  = imagecreatefrompng(__DIR__ . '/header/fon.png');
        $count = count($data) / 2;

        for ($i = 0; $i < $count; $i++) {
            $li = $i * 33;
            $offset = ($i % 2 == 0) ? 0 : 200;

            self::addFlag($fon, $data[$i]->country, 30 + $offset, 10 + $li);
            self::addText($fon, 8 + $offset, 32 + $li, $i + 1, false, 14);
            self::addText($fon, 60 + $offset, 19 + $li, $data[$i]->name);
            self::addText($fon, 60 + $offset, 38 + $li, '"' . $data[$i]->song . '"');
            self::addText($fon, 25 + $offset, 45 + $li, $data[$i]->rating . '%', false, 12);

            self::addFlag($fon, $data[$i + $count]->country, 1225 - $offset, 10 + $li);
            self::addText($fon, 4 + $offset, 32 + $li, $i + $count + 1, true, 14);
            self::addText($fon, 60 + $offset, 19 + $li, $data[$i + $count]->name, true);
            self::addText($fon, 60 + $offset, 38 + $li, '"' . $data[$i + $count]->song . '"', true);
            self::addText($fon, 25 + $offset, 45 + $li, $data[$i + $count]->rating . '%', true, 12);
        }

        imagepng($fon, __DIR__ . '/header/temp' . $round . '.png');
    }

    public static function generateHeaderFinal($data)
    {

    }

    public static function addText($fon, $x, $y, $text, $isRight = false, $size = 11)
    {
        if ($isRight) {
            $dimensions = imagettfbbox($size, 0, __DIR__ . '/header/Roboto.ttf', $text);
            $x = imagesx($fon) - abs($dimensions[4] - $dimensions[0]) - $x;
        }

        imagettftext(
            $fon, $size, 0, $x, $y, imagecolorallocate($fon, 255, 255, 255),
            __DIR__ . '/header/Roboto.ttf', $text
        );
    }

    public static function addFlag($fon, $flag, $x, $y)
    {
        list($width, $height) = getimagesize(__DIR__ . '/flags/' . $flag . '.png');
        $photo = imagecreatefrompng(__DIR__ . '/flags/' . $flag . '.png');
        imagecopymerge($fon, $photo, $x, $y, 0, 0, $width, $height, 100);
    }

    public static function setNewPhoto($round)
    {
        $uploadURL = Photos::getOwnerCoverPhotoUploadServer(1279, 322);

        $upload = Web::request(
            $uploadURL->response->upload_url, true, 'POST',
            ['photo' => curl_file_create(__DIR__ . '/header/temp' . $round . '.png')]
        );

        return Photos::saveOwnerCoverPhoto($upload->hash, $upload->photo);
    }
}
