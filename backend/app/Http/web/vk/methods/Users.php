<?php

namespace App\Http\web\vk\methods;

use App\Http\web\vk\enums\NameCase;
use App\Http\web\vk\Vk;

class Users extends Vk
{
    /**
     * Returns detailed information on users.
     *
     * @param array|null $userIds
     * @param array|null $fields - User fields to return
     * @param null|string $nameCase - nom, gen, dat, etc
     *
     * @return object
     *
     * @throws \App\Http\web\vk\exceptions\VkApiException
     *
     * @see https://vk.com/dev/fields - User object
     * @see https://vk.com/dev/users.get - Method
     */
    public function get(?array $userIds = null, ?array $fields = null, ?string $nameCase = NameCase::NOMINATIVE): object
    {
        return self::request('users.get', [
            'user_ids'  => $userIds ? implode(',', $userIds) : null,
            'fields'    => $fields ? implode(',', $fields) : null,
            'name_case' => $nameCase
        ]);
    }
}
