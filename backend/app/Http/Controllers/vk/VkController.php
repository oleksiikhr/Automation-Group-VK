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
     * @param string $method - API
     * @param array  $params - parameters that the method takes
     * @param string $token - user or group
     * @param string $typeMethod - GET, POST, etc
     *
     * @see https://vk.com/dev/methods
     *
     * @return mixed
     */
    public static function request(string $method, array $params, string $token, string $typeMethod = self::METHOD_GET): mixed
    {
        $params['v'] = self::VK_VERSION;
        $params['access_token'] = $token;

        if ($typeMethod !== self::METHOD_POST) {
            $data = self::curl(self::VK_API . $method . '?' . http_build_query($params));
        } else {
            $data = self::curl(self::VK_API . $method, self::METHOD_POST, http_build_query($params));
        }

        return $data;
    }
}
