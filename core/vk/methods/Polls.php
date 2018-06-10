<?php declare(strict_types=1);

namespace core\vk\methods;

use core\enums\HttpMethod;
use core\vk\VK;

class Polls
{
    /**
     * Allows you to create polls.
     *
     * @param string $token
     * @param string $question
     * @param array  $answers - MAX 10
     * @param bool   $isAnonymous
     *
     * @return mixed
     *
     * @see https://vk.com/dev/polls.create
     *
     * @throws \Exception
     */
    public static function create(string $token, string $question, array $answers, bool $isAnonymous = true)
    {
        $count = count($answers);

        if ($count < 1 || 10 < $count) {
            throw new \Exception('polls.create - Количество ответов должно быть от 0 до 10');
        }

        return VK::send($token, 'polls.create', [
            'owner_id'     => '-' . G_ID,
            'question'     => $question,
            'is_anonymous' => $isAnonymous,
            'add_answers'  => json_encode($answers),
        ], HttpMethod::GET);
    }
}
