<?php declare(strict_types=1);

namespace core\vk\methods;

use core\enums\HttpMethod;
use core\vk\VK;

class Wall
{
    /**
     * Allows you to create a record on the wall.
     *
     * @param string $token
     * @param string|null $message
     * @param string|null $attachments
     * @param bool $fromGroup
     *
     * @return mixed
     *
     * @see https://vk.com/dev/wall.post
     *
     * @throws \Exception
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
