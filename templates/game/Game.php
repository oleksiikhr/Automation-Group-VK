<?php

namespace tmp\game;

use gvk\DB;
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
     * @return boolean
     */
    public static function parseInputData($data)
    {
        $q = \QB::table(self::TABLE_GAME)
            ->where('is_finished', '=', 0)
            ->where('game_type', '=', 0)
            ->first();

        if ($q) {
            if (mb_strtolower(trim($data->body)) == mb_strtolower($q->ans)) {
                $u = \QB::table(self::TABLE_USER)->where('id', '=', $data->user_id)->first();
                $vkUser = VK::send('users.get', [
                    'user_ids' => $data->user_id,
                    'fields' => 'photo_50',
                ], T_USR);

                \QB::table(self::TABLE_GAME)->where('id', '=', $q->id)->update([
                    'word' => $q->ans,
                    'is_finished' => 1,
                ]);

                $rating = substr_count($q->word, '_');

                if ($u) {
                    \QB::table(self::TABLE_USER)->where('id', '=', $data->user_id)
                        ->update([
                            'first_name' => $vkUser->response[0]->first_name,
                            'last_name' => $vkUser->response[0]->last_name,
                            'rating' => $u->rating + $rating,
                        ]);

                    VK::messageSend('Correctly! Rating:' . ($u->rating + $rating) . ' (+' . $rating . ')', $data->user_id);
                } else {
                    \QB::table(self::TABLE_USER)->insert([
                        'id' => $data->user_id,
                        'first_name' => $vkUser->response[0]->first_name,
                        'last_name' => $vkUser->response[0]->last_name,
                        'rating' => $rating,
                    ]);

                    VK::messageSend('Correctly! Rating:' . $rating, $data->user_id);
                }

                file_put_contents(__DIR__ . '/avatars/' . $data->user_id . '.jpg',
                    file_get_contents($vkUser->response[0]->photo_50)
                );

                self::generateTemplate(2);
            }
            elseif (strlen(trim($data->body)) != strlen($q->ans)) {
                VK::messageSend('Wrong, ' . strlen($q->ans) . ' characters', $data->user_id);
            }
            else {
                VK::messageSend('Wrong', $data->user_id);
            }
        } else {
            VK::messageSend('Wait for the next word', $data->user_id);
        }

        return true;
    }

    public static function checkingGame()
    {
        $q = \QB::table(self::TABLE_GAME)
            ->where('game_type', '=', 0)
            ->first();

        if ($q) {
            if ($q->is_finished == 0 && strtotime($q->time) + 3600 < time() - 1200) {
                $word = self::getNextRndLetter($q->word, $q->ans);

                \QB::table(self::TABLE_GAME)
                    ->where('id', '=', $q->id)
                    ->update([
                        'word' => $word,
                        'is_finished' => $word == $q->ans,
                    ]);

                if ($word == $q->ans) {
                    self::generateTemplate(2);
                } else {
                    self::generateTemplate(1);
                }
            }
            elseif ($q->is_finished == 1 && strtotime($q->time) + 3600 < time() - 600) {
                $w = DB::getRandomData(Translate::TABLE);

                \QB::table(self::TABLE_GAME)->insert([
                    'word' => self::getNextRndLetter(str_repeat('_', strlen($w->word_eng)), $w->word_eng),
                    'ans' => $w->word_eng,
                    'game_type' => 0,
                ]);

                \QB::table(self::TABLE_GAME)
                    ->where('id', '=', $q->id)
                    ->delete();

                self::generateTemplate(1);
            }
        }
    }

    public static function updateBestUsers()
    {
        self::deleteAllAvatars();

        $users = self::getBestUsers();

        $ids = implode(',', array_map(function ($user) {
            return $user->id;
        }, $users));

        $usersVK = VK::send('users.get', [
            'user_ids' => $ids,
            'fields' => 'photo_50',
        ], T_USR);

        for ($i = 0; $i < count($users); $i++) {
            \QB::table(self::TABLE_USER)->where('id', '=', $usersVK->response[$i]->id)->update([
                'first_name' => $usersVK->response[$i]->first_name,
                'last_name' => $usersVK->response[$i]->last_name,
            ]);

            file_put_contents(__DIR__ . '/avatars/' . $usersVK->response[$i]->id . '.jpg',
                file_get_contents($usersVK->response[$i]->photo_50)
            );
        }
    }

    public static function deleteAllAvatars()
    {
        $directory = __DIR__ . '/avatars';
        $files = array_diff(scandir($directory), ['..', '.']);

        foreach ($files as $file) {
            unlink(__DIR__ . '/avatars/' . $file);
        }
    }

    public static function generateTemplate($template)
    {
        $game = \QB::table(self::TABLE_GAME)
            ->where('is_finished', '=', $template == 1 ? 0 : 1)
            ->where('game_type', '=', 0)
            ->first();

        $users = self::getBestUsers();
        $fon  = imagecreatefrompng(__DIR__ . '/header/fon.png');

        for ($i = 0; $i < count($users); $i++) {
            self::addAvatar($users[$i]->id, $fon, 599, 33 + ($i * 57));
            self::addText($fon, 655, 50 + ($i * 57), $users[$i]->last_name . ' ' . $users[$i]->first_name, 10);
            self::addText($fon, 655, 70 + ($i * 57), $users[$i]->rating);
        }

        self::addText($fon, 100, 105, join(' ', str_split($game->word)), 27, 0, 0, 0);
        self::addText($fon, 543, 188, date('H:i'), 10);

        if ($template == 1) {
            self::addText($fon, 457, 188, date('H:i', strtotime($game->time) + 3600 + 1200), 10);
        }

        imagepng($fon, __DIR__ . '/header/temp0.png');
        self::setNewPhoto(__DIR__ . '/header/temp0.png');
    }

    public static function addText($fon, $x, $y, $text, $size = 11, $r = 255, $g = 255, $b = 255)
    {
        imagettftext(
            $fon, $size, 0, $x, $y, imagecolorallocate($fon, $r, $g, $b),
            __DIR__ . '/fonts/Roboto.ttf', $text
        );
    }

    public static function addAvatar($img, $fon, $x, $y)
    {
        $dir = __DIR__ . '/avatars/' . $img . '.jpg';

        switch (mime_content_type($dir)) {
            case 'image/jpeg':
                $photo = imagecreatefromjpeg($dir);
                break;

            case 'image/png':
                $photo = imagecreatefrompng($dir);
                break;

            default:
                return;
        }

        imagecopymerge($fon, $photo, $x, $y, 0, 0, 50, 50, 100);
    }

    public static function getBestUsers()
    {
        return \QB::table(self::TABLE_USER)->orderBy('rating', 'DESC')->limit(3)->get();
    }

    public static function getNextRndLetter($text, $ans)
    {
        preg_match_all('/_/ui', $text, $matches, PREG_OFFSET_CAPTURE);

        $pos = $matches[0][array_rand($matches[0])][1];
        $text{$pos} = $ans{$pos};

        return $text;
    }

    /**
     * Pour the generated photo into the group.
     *
     * @param string $img
     *
     * @return object
     */
    public static function setNewPhoto($img)
    {
        $uploadURL = Images::getOwnerCoverPhotoUploadServer();

        $upload = Web::request(
            $uploadURL->response->upload_url, true, 'POST',
            ['photo' => curl_file_create($img)]
        );

        return Images::saveOwnerCoverPhoto($upload->hash, $upload->photo);
    }
}
