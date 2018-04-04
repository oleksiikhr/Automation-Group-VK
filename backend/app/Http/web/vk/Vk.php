<?php

namespace App\Http\web\vk;

use App\Http\web\vk\enums\Language;
use App\Http\web\enums\HttpMethod;
use App\Http\web\Web;
use App\UserToken;
use Carbon\Carbon;

class Vk extends Web
{
    const VK_API = 'https://api.vk.com/method/';
    const VK_VERSION = '5.74';

    /**
     * @var bool
     */
    public $hasError = false;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    private $_lang;

    /**
     * @var bool
     */
    private $_strict;

    /**
     * Config request.
     *
     * @param string  $token
     * @param bool    $strict
     * @param string  $lang
     */
    public function __construct(string $token, bool $strict = true, string $lang = Language::Russian)
    {
        $this->token = $token;
        $this->_strict = $strict;
        $this->_lang = $lang;
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
        $params['v'] = self::VK_VERSION;
        $params['access_token'] = $this->token;
        $params['lang'] = $this->_lang;

        if ($typeMethod === HttpMethod::GET) {
            $data = self::curl(self::VK_API . $method . '?' . http_build_query($params));
        } else {
            $data = self::curl(self::VK_API . $method, $typeMethod, http_build_query($params));
        }

        $response = json_decode($data);

        // TODO Check response
        // TODO Temporary
        $this->hasError = isset($response->error);

        if ($this->_strict && $this->hasError) {
            return response()->json(['message' => 'Ошибка при выполнении запроса в ВК'], 422);
        }
        // END

        return $response;
    }
}
