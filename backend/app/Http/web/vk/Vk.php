<?php

namespace App\Http\web\vk;

use App\Http\web\vk\exceptions\VkApiException;
use App\Http\web\vk\enums\Language;
use App\Http\web\enums\HttpMethod;
use App\Http\web\Web;

class Vk extends Web
{
    const VK_API = 'https://api.vk.com/method/';
    const VK_VERSION = '5.74';

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    private $_lang;

    /**
     * Config request.
     *
     * @param string $token
     * @param string $lang
     */
    public function __construct(string $token, string $lang = Language::Russian)
    {
        $this->token = $token;
        $this->_lang = $lang;
    }

    /**
     * Send request to VK.
     *
     * @param string $method - API
     * @param array $params - parameters that the method takes
     * @param string $typeMethod - GET, POST, etc
     *
     * @see https://vk.com/dev/methods
     *
     * @throws VkApiException
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

        $data = $data ? json_decode($data) : null;

        if ($data === null) {
            throw new VkApiException('Ответ отсутствует от ВК');
        }

        if (isset($data->error)) {
            throw new VkApiException('Ошибка при выполнении запроса в ВК');
        }

        return $data;
    }

    /**
     * By URL filter standard images.
     *
     * @param string $image
     *
     * @return string|null
     */
    public static function filterDefaultImages($image)
    {
        switch ($image) {
            case 'https://vk.com/images/deactivated_200.png':
            case 'https://vk.com/images/deactivated_100.png':
            case 'https://vk.com/images/deactivated_50.png':
            case 'https://vk.com/images/camera_200.png':
            case 'https://vk.com/images/camera_100.png':
            case 'https://vk.com/images/camera_50.png';
                return null;
            default:
                return $image;
        }
    }
}
