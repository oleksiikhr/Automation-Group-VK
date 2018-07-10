<?php declare(strict_types=1);

namespace core\vk\methods;

use core\enums\HttpMethod;
use core\vk\VK;

class Wall
{
    /**
     * Adds a new post on a user wall or community wall.
     * Can also be used to publish suggested or scheduled posts.
     *
     * @param  string       $token
     * @param  string|null  $message
     * @param  string|null  $attachments
     * @param  bool         $fromGroup
     * @return mixed
     * @throws \Exception
     *
     * @see https://vk.com/dev/wall.post
     */
    public static function post(string $token, ?string $message = null, ?string $attachments = null, bool $fromGroup = true)
    {
        return VK::send($token, 'wall.post', [
            'owner_id'    => '-' . G_ID,
            'from_group'  => $fromGroup,
            'message'     => $message,
            'attachments' => $attachments,
            'guid'        => mt_rand(),
        ], HttpMethod::POST);
    }
}
