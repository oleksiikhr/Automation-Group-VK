<?php

namespace gvk;

class Web extends DB
{
    use Methods;

    /**
     * Send request from website.
     *
     * @param string $url
     * @param bool $decode
     * @param string $typeMethod
     * @param array $fields
     *
     * @return object
     */
    public function request($url, $decode = false, $typeMethod = 'GET', $fields = [])
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if ( mb_strtoupper($typeMethod) === 'POST' ) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields );
        }

        $result = curl_exec($ch);
        curl_close($ch);

        if ($decode) return json_decode($result);

        return $result;
    }
}
