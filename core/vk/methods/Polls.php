<?php declare(strict_types=1);

namespace core\vk\methods;

use core\enums\HttpMethod;
use core\vk\VK;

class Polls
{
    /**
     * Creates polls that can be attached to the users' or communities' posts.
     *
     * @param  string  $token
     * @param  string  $question
     * @param  array  $answers
     * @param  bool  $isAnonymous
     * @return mixed
     * @throws \Exception
     *
     * @see https://vk.com/dev/polls.create
     */
    public static function create(string $token, string $question, array $answers, bool $isAnonymous = true)
    {
        return VK::send($token, 'polls.create', [
            'owner_id'     => '-' . G_ID,
            'question'     => $question,
            'is_anonymous' => $isAnonymous,
            'add_answers'  => json_encode($answers),
        ], HttpMethod::POST);
    }
}
