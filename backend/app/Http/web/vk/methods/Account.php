<?php

namespace App\Http\web\vk\methods;

use App\Http\web\vk\Vk;

class Account extends Vk
{
    /**
     * Gets settings of the user in this application.
     *
     * @param int|null $userId
     *
     * @return object
     *
     * @throws \App\Http\web\vk\exceptions\VkApiException
     *
     * @see https://vk.com/dev/account.getAppPermissions - Method
     */
    public function getAppPermissions(?int $userId = null): object
    {
        return self::request('account.getAppPermissions', [
            'user_id' => $userId
        ]);
    }
}
