<?php

namespace tmp\euro2017;

use gvk\Web;
use gvk\vk\VK;
use gvk\vk\methods\Polls;
use gvk\vk\methods\Photos;

class Euro
{
    const TABLE = 'euro';

    public static function createPost($round = 0)
    {
        if ( empty($round) )
            $data = \QB::table(self::TABLE)
                ->where('isFinal', '=', '1')
                ->where('final_poll', '=', '0')
                ->orderBy('final_pos', 'ASC')
                ->first();
        else
            $data = \QB::table(self::TABLE)
                ->where('poll_id', '=', '0')
                ->where('round', '=', $round)
                ->first();

        $poll = self::createPoll();
        $attachments = null;

        if ( ! empty($data->music_id) )
            $attachments .= 'audio' . $data->music_id . ',';

        if ( ! empty($poll->response) )
            $attachments .= 'poll-' . G_ID . '_' . $poll->response->id . ',';

        if ( file_exists(__DIR__ . '/members/artists/' . $data->id . '.jpg') )
            $attachments .= Photos::getUploadWallImageComplex(__DIR__ . '/members/artists/' . $data->id . '.jpg') . ',';

        if ( file_exists(__DIR__ . '/members/translate/' . $data->id . '.png') )
            $attachments .= Photos::getUploadWallImageComplex(__DIR__ . '/members/translate/' . $data->id . '.png') . ',';

        $message = "&#128204; Country: {$data->country}\n&#10004; Artist: {$data->name}\n&#127925; Song: {$data->song}";
        VK::wallPost($message . "\n\n" . self::getHashtag($round), $attachments);

        if ( empty($round) )
            \QB::table(self::TABLE)->where('id', '=', $data->id)->update([
                'final_poll' => $poll->response->id
            ]);
        else
            \QB::table(self::TABLE)->where('id', '=', $data->id)->update([
                'poll_id' => $poll->response->id
            ]);
    }

    public static function createPoll()
    {
        return Polls::create('Do you like this song?', ['Yes', 'No']);
    }

    public static function getHashtag($round = 0)
    {
        if ( empty($round) )
            return '#eurovision2017@' . G_URL . ' #eurovision2017_final@' . G_URL;

        return '#eurovision2017@' . G_URL . ' #eurovision2017_semi' . $round . '@' . G_URL;
    }

    public static function changeHeader($round = 0)
    {
        if ( empty($round) )
            self::generateHeaderFinal( \QB::table(self::TABLE)
                ->where('isFinal', '=', true)
                ->orderBy('final_rating', 'DESC')
                ->get(), $round );
        else
            self::generateHeaderSemi( \QB::table(self::TABLE)
                ->where('round', '=', $round)
                ->orderBy('rating', 'DESC')
                ->get(), $round );

        self::setNewCoverPhoto($round);
    }

    public static function parsePoll($round = null)
    {
        if ( empty($round) )
            $pollIDs = \QB::table(self::TABLE)
                ->where('final_poll', '>', 0)
                ->where('isFinal', '=', true)
                ->orderBy('time', 'ASC')
                ->limit(4)
                ->get();
        else
            $pollIDs = \QB::table(self::TABLE)
                ->where('poll_id', '>', 0)
                ->where('round', '=', $round)
                ->orderBy('time', 'ASC')
                ->limit(4)
                ->get();

        if ( empty($pollIDs) )
            return;

        $tokens = [T_USR, T_USR2, T_USR3, T_USR4];

        foreach ($pollIDs as $key => $pollID) {
            $poll = Polls::getById($pollID->poll_id, $tokens[$key % count($tokens)]);

            if ( ! empty($poll->error) )
                continue;

            if ( empty($round) )
                \QB::table(self::TABLE)->where('id', '=', $pollID->id)->update([
                    'final_rating' => empty($poll->response->answers[0]->rate) ? 0 : $poll->response->answers[0]->rate,
                    'time'   => date( 'Y-m-d H:i:s', time() )
                ]);
            else
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

    public static function generateHeaderFinal($data, $round)
    {
        $fon = imagecreatefrompng(__DIR__ . '/header/final.png');
        $count = count($data) / 2;

        for ($i = 0; $i < $count; $i++) {
            $li = ($i % 2 == 0) ? $i * 23 - 5 : $i * 25 - 17;
            $offset = ($i % 2 == 0) ? 20 : 230;
            $num = $i < 9 ? '0' . ($i + 1) : $i + 1;

            self::addFlag($fon, $data[$i]->country, 30 + $offset, 10 + $li);
            self::addText($fon, $offset, 32 + $li, $num, false, 12);
            self::addText($fon, 60 + $offset, 19 + $li, $data[$i]->name, false, 10);
            self::addText($fon, 60 + $offset, 38 + $li, '"' . $data[$i]->song . '"', false, 10);
            self::addText($fon, 30 + $offset, 45 + $li, $data[$i]->rating, false, 12);

            self::addFlag($fon, $data[$i + $count]->country, 1225 - $offset, 10 + $li);
            self::addText($fon, $offset, 32 + $li, $i + $count + 1, true, 12);
            self::addText($fon, 60 + $offset, 19 + $li, $data[$i + $count]->name, true, 10);
            self::addText($fon, 60 + $offset, 38 + $li, '"' . $data[$i + $count]->song . '"', true, 10);
            self::addText($fon, 30 + $offset, 45 + $li, $data[$i + $count]->rating, true, 12);
        }

        imagepng($fon, __DIR__ . '/header/temp' . $round . '.png');
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
        list($width, $height) = getimagesize(__DIR__ . '/members/flags/' . $flag . '.png');
        $photo = imagecreatefrompng(__DIR__ . '/members/flags/' . $flag . '.png');
        imagecopymerge($fon, $photo, $x, $y, 0, 0, $width, $height, 100);
    }

    public static function setNewCoverPhoto($round)
    {
        $uploadURL = Photos::getOwnerCoverPhotoUploadServer(1279, 322);

        $upload = Web::request(
            $uploadURL->response->upload_url, true, 'POST',
            ['photo' => curl_file_create(__DIR__ . '/header/temp' . $round . '.png')]
        );

        return Photos::saveOwnerCoverPhoto($upload->hash, $upload->photo);
    }
}
