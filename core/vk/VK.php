<?php declare(strict_types=1);

namespace core\vk;

use core\enums\HttpMethod;
use core\Web;

class VK
{
    const VK_API = 'https://api.vk.com/method/';

    const VK_VERSION = '5.74';

    /**
     * Send request to VK.
     *
     * @param string $method
     * @param array $params
     * @param string $token
     * @param string $typeMethod
     *
     * @see https://vk.com/dev/methods
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public static function send(string $token, string $method, array $params = [], string $typeMethod = HttpMethod::GET)
    {
        $params['v'] = self::VK_VERSION;
        $params['access_token'] = $token;
        $params['lang'] = VK_LANG;

        if ($typeMethod === HttpMethod::GET) {
            $data = Web::curl(self::VK_API . $method . '?' . http_build_query($params));
        } else {
            $data = Web::curl(self::VK_API . $method, $typeMethod, http_build_query($params));
        }

        $data = json_decode($data);

        if (isset($data->error)) {
            throw new \Exception('Error while executing the request in VK');
        }

        return $data;
    }
}
