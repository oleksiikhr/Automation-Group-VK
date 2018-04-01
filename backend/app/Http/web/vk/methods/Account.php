<?php

namespace App\Http\web\vk\methods;

use App\Http\web\vk\Vk;

class Account extends Vk
{
    /**
     * Gets settings of the user in this application.
     *
     * @param int|null  $userId
     *
     * @see https://vk.com/dev/account.getAppPermissions - Method
     *
     * @return mixed
     */
    public function getAppPermissions(?int $userId = null)
    {
        $response = self::request('account.getAppPermissions', [
            'user_id' => $userId
        ]);

        return json_decode($response);
    }
}
