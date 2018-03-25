<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';

    /**
     * Send request to any Website.
     *
     * @param string $url
     * @param string $method
     * @param array  $fields
     *
     * @return mixed
     */
    public static function curl(string $url, string $method = self::METHOD_GET, array $fields = []): mixed
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if (mb_strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
