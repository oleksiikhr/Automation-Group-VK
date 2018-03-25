<?php

namespace App\Http\Controllers\vk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VkController extends Controller
{
    const VK_API = 'https://api.vk.com/method/';
    const VK_VERSION = '5.73';

    /**
     * Send request to VK.
     *
     * @param string $method
     * @param array  $params
     * @param string $token
     * @param string $typeMethod
     *
     * @return object
     */
    public static function request($method, $params, $token, $typeMethod = self::METHOD_GET)
    {
        $params['v'] = self::VK_VERSION;
        $params['access_token'] = $token;

        if ($typeMethod !== self::METHOD_POST) {
            $data = self::curl(self::VK_API . $method . '?' . http_build_query($params));
        } else {
            $data = self::curl(self::VK_API . $method, 'POST', http_build_query($params));
        }

        return $data;
    }
}
