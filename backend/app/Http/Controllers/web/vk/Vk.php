<?php

namespace App\Http\Controllers\web\vk;

use App\UserToken;
use Carbon\Carbon;
use App\Http\Controllers\web\Web;

class Vk extends Web
{
    const VK_API = 'https://api.vk.com/method/';
    const VK_VERSION = '5.73';

    /**
     * @var string
     */
    protected $_token;

    public function __construct(?string $token = null)
    {
        if (! $token) {
            $model = UserToken::where('expiry_at', '>', Carbon::now())
                ->orderBy('updated_at')
                ->first();

            if (! $model) {
                return response()->json(['message' => 'Токен ВК отсутствует'], 412);
            }

            $token = $model->token;
        }

        $this->_token = $token;
    }

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
    public static function request(string $method, ?array $params, string $token, string $typeMethod = self::METHOD_GET): mixed
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
