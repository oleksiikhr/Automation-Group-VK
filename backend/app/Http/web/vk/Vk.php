<?php

namespace App\Http\web\vk;

use App\Http\web\enums\HttpMethod;
use App\Http\web\Web;
use App\UserToken;
use Carbon\Carbon;

class Vk extends Web
{
    const VK_API = 'https://api.vk.com/method/';
    const VK_VERSION = '5.73';

    /**
     * @var string
     */
    protected $token;

    /**
     * @var bool
     */
    public $hasError = false;

    /**
     * Add a user or group token.
     *
     * @param null|string  $token
     */
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

        $this->token = $token;
    }

    /**
     * Send request to VK.
     *
     * @param string  $method - API
     * @param array   $params - parameters that the method takes
     * @param string  $typeMethod - GET, POST, etc
     *
     * @see https://vk.com/dev/methods
     *
     * @return object
     */
    public function request(string $method, array $params = [], string $typeMethod = HttpMethod::GET): object
    {
        // TODO lang
        $params['v'] = self::VK_VERSION;
        $params['access_token'] = $this->token;

        if ($typeMethod === HttpMethod::GET) {
            $data = self::curl(self::VK_API . $method . '?' . http_build_query($params));
        } else {
            $data = self::curl(self::VK_API . $method, $typeMethod, http_build_query($params));
        }

        $response = json_decode($data);

        // TODO Check response
        // TODO Temporary
        $this->hasError = isset($response->error);

        return $response;
    }
}
