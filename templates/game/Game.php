<?php

namespace tmp\game;

use gvk\Web;
use gvk\vk\VK;
use gvk\vk\methods\Images;
use gvk\vk\methods\Translate;

class Game
{
    const TABLE_GAME = 'games';
    const TABLE_USER = 'users';

    /**
     * New member in the group.
     *
     * @param object $data
     *
     * @return void
     */
    public static function parseInputData($data)
    {
        $q = \QB::table(self::TABLE_GAME)
            ->where('is_finished', '=', 0)
            ->where('game_type', '=', 0)
            ->first();

        if ($q) {
            if (trim($data->body) == $q->word) {
                $u = \QB::table(self::TABLE_USER)->where('id', '=', $data->user_id)->first();
                $vkUser = VK::send('users.get', [
                    'user_ids' => $data->user_id,
                    'fields' => 'photo_50',
                ], T_USR);

                if ($u) {
                    \QB::table(self::TABLE_USER)->where('id', '=', $data->user_id)
                        ->update([
                            'first_name' => $vkUser->response[0]->first_name,
                            'last_name' => $vkUser->response[0]->last_name,
                            'image' => $vkUser->response[0]->photo_50,
                            'rating' => $u->rating + 1,
                        ]);
                } else {
                    \QB::table(self::TABLE_USER)->insert([
                        'id' => $data->user_id,
                        'first_name' => $vkUser->response[0]->first_name,
                        'last_name' => $vkUser->response[0]->last_name,
                        'image' => $vkUser->response[0]->photo_50,
                        'rating' => $u->rating + 1,
                    ]);
                }

                VK::messageSend('+ ' . ($u->rating + 1), $data->user_id);
                self::generateTemplate2();
            }
            VK::messageSend('-', $data->user_id);
        }
        VK::messageSend('..', $data->user_id);
    }

    public static function checkingGame()
    {
        $q = \QB::table(self::TABLE_GAME)
            ->where('is_finished', '=', 0)
            ->where('game_type', '=', 0)
            ->first();

        // TODO: check time at home

        if ($q) {
            if (strtotime($q->time) > time() - 1080) {
                $ans = self::getNextRndLetter($q->ans, $q->word);

                \QB::table(self::TABLE_GAME)
                    ->where('id', '=', $q->id)
                    ->update([
                        'ans' => $ans,
                        'is_finished' => $q->ans == $q->word,
                    ]);

                if ($q->ans == $q->word) {
                    self::generateTemplate2();
                } else {
                    self::generateTemplate1();
                }
            }
            elseif (strtotime($q->time) > time() - 360) {
                $w = \QB::getRandomData(Translate::TABLE);

                \QB::table(self::TABLE_GAME)->insert([
                    'word' => $w->word_eng,
                    'ans' => self::getNextRndLetter(str_repeat('_', strlen($w->word_eng)), $w->word_eng),
                    'game_type' => 0,
                ]);

                \QB::table(self::TABLE_GAME)
                    ->where('is_finished', '=', 1)
                    ->where('game_type', '=', 0)
                    ->delete();

                self::generateTemplate1();
            }
        }
    }

    public static function updateBestUsers()
    {
        $users = \QB::table(self::TABLE_USER)->orderBy('rating', 'DESC')->limit(3)->get();

        $ids = implode(',', array_map(function ($user) {
            return $user->rating;
        }, $users));

        $usersVK = VK::send('users.get', [
            'user_ids' => $ids,
            'fields' => 'photo_50',
        ], T_USR);

        for ($i = 0; $i < count($users); $i++) {
            \QB::table(self::TABLE_USER)->where('user_id', '=', $users[$i]->user_id)->update([
                'first_name' => $usersVK->response[$i]->first_name,
                'last_name' => $usersVK->response[$i]->last_name,
                'image' => $usersVK->response[$i]->photo_50,
            ]);
        }
    }

    public static function generateTemplate1()
    {

    }

    public static function generateTemplate2()
    {

    }

    public static function getNextRndLetter($text, $ans)
    {
        preg_match_all('/_/ui', $text, $matches, PREG_OFFSET_CAPTURE);

        $pos = $matches[0][array_rand($matches[0])][1];
        $text{$pos} = $ans{$pos};

        return $text;
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
//        $fon  = imagecreatefrompng(__DIR__ . '/header/fon.png');
//        $photo = imagecreatefromjpeg($img);
//
//        imagecopymerge($fon, $photo, 638, 49, 0, 0, 100, 100, 100);
//
//        imagettftext(
//            $fon, 11, 0, 657, 164, 0,
//            __DIR__ . '/fonts/ConcertOne-Regular.ttf', $text
//        );
//
//        imagepng($fon, __DIR__ . '/header/temp.png');
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
