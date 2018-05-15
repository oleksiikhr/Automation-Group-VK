<?php declare(strict_types=1);

namespace src\controllers;

use core\vk\methods\Wall;
use src\models\Verbs;
use core\Controller;

class VerbsController implements Controller
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

        $message = self::SMILE . " Список неправильных глаголов.\n\n";

        foreach ($verbs as $key => $verb) {
            $i = $key + 1;
            $message .= "$i. {$verb->first_form} - {$verb->second_form} - {$verb->third_form}\n";
            if ($i % 5 == 0) {
                $message .= "\n";
            }
        }

        try {
            return Wall::post(TOKENS['user-main']['token'], $message);
        } catch (\Exception $e) {
            return null;
        }
    }
}
