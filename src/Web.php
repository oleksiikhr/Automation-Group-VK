<?php

namespace gvk;

class Web
{
    /**
     * Send request to website.
     *
     * @param string $url
     * @param bool   $decode
     * @param string $typeMethod
     * @param array  $fields
     *
     * @return object
     */
    public static function request($url, $decode = false, $typeMethod = 'GET', $fields = [])
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

        return $decode ? json_decode($result) : $result;
    }
}
