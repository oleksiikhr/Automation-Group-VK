<?php

namespace gvk\youtube;

use gvk\Web;

class Youtube extends Web
{
    /**
     * Decode get answer.
     *
     * @param string $method
     * @param array $params
     *
     * @return object
     */
    function send($method, $params = [])
    {
        return $this->request( METHOD_YOUTUBE . $method . '?' . http_build_query($params)
            . '&key=' . TOKEN_GOOGLE, true );
    }
}
