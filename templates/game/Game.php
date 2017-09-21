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

                self::uploadImage(__DIR__ . '/avatars/' . $data->user_id . '.jpg',
                    $vkUser->response[0]->photo_50, 35, 35, 100);

                self::generateTemplate2();
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
                    self::generateTemplate2();
                } else {
                    self::generateTemplate1();
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

                self::generateTemplate1();
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

            self::uploadImage(__DIR__ . '/avatars/' . $usersVK->response[$i]->id . '.jpg',
                $usersVK->response[$i]->photo_50, 35, 35, 100);
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

    public static function generateTemplate1()
    {
        $game = \QB::table(self::TABLE_GAME)
            ->where('is_finished', '=', 0)
            ->where('game_type', '=', 0)
            ->first();

        $users = self::getBestUsers();
        $fon  = imagecreatefrompng(__DIR__ . '/header/fon-1.png');

        for ($i = 0; $i < count($users); $i++) {
            self::addAvatar($users[$i]->id, $fon, 606, 41 + ($i * 57));
            self::addText($fon, 651, 54 + ($i * 57),
                $users[$i]->last_name . ' ' . $users[$i]->first_name, 10, 255, 255, 255, true);
            self::addText($fon, 651, 70 + ($i * 57), $users[$i]->rating, 10, 170, 170, 170, true);
        }

        self::addText($fon, 100, 105, join(' ', str_split($game->word)), 27, 0, 0, 0);
        self::addText($fon, 543, 188, date('H:i'), 10);
        self::addText($fon, 457, 188, date('H:i', strtotime($game->time) + 3600 + 1200), 10);

        imagepng($fon, __DIR__ . '/header/temp-1.png');
        self::setNewPhoto(__DIR__ . '/header/temp-1.png');
    }

    public static function generateTemplate2()
    {
        $game = \QB::table(self::TABLE_GAME)
            ->where('is_finished', '=', 1)
            ->where('game_type', '=', 0)
            ->first();

        $word = \QB::table(Translate::TABLE)->where('word_eng', '=', $game->ans)->first();

        if (! $word) {
            return;
        }

        $users = self::getBestUsers();
        $fon  = imagecreatefrompng(__DIR__ . '/header/fon-2.png');

        for ($i = 0; $i < count($users); $i++) {
            self::addAvatar($users[$i]->id, $fon, 606, 41 + ($i * 57));
            self::addText($fon, 651, 54 + ($i * 57),
                $users[$i]->last_name . ' ' . $users[$i]->first_name, 10, 255, 255, 255, true);
            self::addText($fon, 651, 70 + ($i * 57), $users[$i]->rating, 10, 170, 170, 170, true);
        }

        $rus = strlen($word->word_rus) > 40 ? mb_substr($word->word_rus, 0, 40) . '..' : $word->word_rus;
        $tr = strlen($word->transcription) > 40 ? mb_substr($word->transcription, 0, 40) . '..' : $word->transcription;

        self::addText($fon, 100, 80, join(' ', str_split($word->word_eng)), 24, 0, 0, 0);
        self::addText($fon, 100, 110, $rus, 15, 0, 0, 0);
        self::addText($fon, 100, 140, '[' . $tr . ']', 15, 0, 0, 0);

        self::addText($fon, 460, 188, date('H:i', strtotime($game->time) + 3600 + 1200), 10);
        self::addText($fon, 543, 188, date('H:i'), 10);

        imagepng($fon, __DIR__ . '/header/temp-2.png');
        self::setNewPhoto(__DIR__ . '/header/temp-2.png');
    }

    public static function addText($fon, $x, $y, $text, $size = 11, $r = 255, $g = 255, $b = 255, $isBold = false)
    {
        imagettftext(
            $fon, $size, 0, $x, $y, imagecolorallocate($fon, $r, $g, $b),
            $isBold ? __DIR__ . '/fonts/Roboto-Bold.ttf' : __DIR__ . '/fonts/Roboto.ttf', $text
        );
    }

    public static function uploadImage($outfile, $infile, $neww, $newh, $quality)
    {
        $im = imagecreatefromjpeg($infile);
        $im1 = imagecreatetruecolor($neww, $newh);
        imagecopyresampled($im1, $im, 0, 0, 0, 0, $neww, $newh, imagesx($im), imagesy($im));

        imagejpeg($im1, $outfile, $quality);
        imagedestroy($im);
        imagedestroy($im1);
    }

    public static function addAvatar($img, $fon, $x, $y)
    {
        $dir = __DIR__ . '/avatars/' . $img . '.jpg';

        imagecopymerge($fon, imagecreatefromjpeg($dir), $x, $y, 0, 0, 35, 35, 100);
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
