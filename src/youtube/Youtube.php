<?php

namespace gvk\youtube;

use gvk\Web;

class Youtube extends Web
{
    const YOUTUBE_API = 'https://www.googleapis.com/youtube/v3/';

    /**
     * Send request to vk.
     *
     * @param string $method
     * @param array  $params
     * @param bool   $decode
     *
     * @return object
     */
    function send($method, $params, $decode = true)
    {
        return $this->request( self::YOUTUBE_API . $method . '?' . http_build_query($params)
            . '&key=' . T_GOOGLE, $decode );
    }
}
