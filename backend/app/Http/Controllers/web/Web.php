<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\web\enums\HttpMethod;

class Web
{
    /**
     * Send request to any Website.
     *
     * @param string  $url - with GET params
     * @param string  $method - HttpMethod class
     * @param array   $fields - used if the HttpMethod is not GET
     *
     * @return mixed
     */
    public static function curl(string $url, string $method = HttpMethod::GET, ?array $fields = null): mixed
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

        return $result;
    }
}
