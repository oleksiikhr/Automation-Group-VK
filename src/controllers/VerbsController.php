<?php declare(strict_types=1);

namespace src\controllers;

use core\vk\methods\Wall;
use src\models\Verbs;
use src\Token;

class VerbsController
{
    const SMILE = '&#128203;';

    /**
     * Main method.
     *
     * @param int $count
     *
     * @return mixed
     */
    public static function start(int $count = 20)
    {
        $verbs = Verbs::getRandom($count);
        var_dump($verbs);
        die('DIE: VerbsController - start');
//
//        $message = self::SMILE . " Список неправильных глаголов.\n\n";
//
//        foreach ($verbs as $key => $verb) {
//            $i = $key + 1;
//            $message .= "$i. {$verb->first_form} - {$verb->second_form} - {$verb->third_form}\n";
//            if ($i % 5 == 0) {
//                $message .= "\n";
//            }
//        }
//
//        try {
//            return Wall::post(Token::getToken(), $message);
//        } catch (\Exception $e) {
//            return null;
//        }
    }
}
