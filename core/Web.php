<?php declare(strict_types=1);

namespace core;

use core\enums\HttpMethod;

class Web
{
    /**
     * Send request to any Website.
     *
     * @param string $url - with GET params
     * @param string $method - HttpMethod class
     * @param string|null $fields - used if the HttpMethod is not GET
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function curl(string $url, string $method = HttpMethod::GET, ?string $fields = null): string
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($method !== HttpMethod::GET) {
            if ($method === HttpMethod::POST) {
                curl_setopt($ch, CURLOPT_POST, true);
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }

        $result = curl_exec($ch);
        curl_close($ch);

        if (! $result) {
            throw new \Exception('Server error');
        }

        return $result;
    }
}
