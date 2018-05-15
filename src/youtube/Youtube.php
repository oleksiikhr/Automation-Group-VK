<?php

namespace gvk\youtube;

use gvk\Web;

class Youtube extends Web
{
    const Y_API   = 'https://www.googleapis.com/youtube/v3/';
    const L_WATCH = 'https://www.youtube.com/watch?v=';

    /**
     * Send request to Youtube.
     *
     * @param string $method
     * @param array  $params
     * @param bool   $decode
     *
     * @return object
     */
    public static function send($method, $params, $decode = true)
    {
        return self::request(self::Y_API . $method . '?' . http_build_query($params)
            . '&key=' . T_GOOGLE, $decode);
    }

    /**
     * Get PlaylistItems.
     *
     * @param string $part
     * @param string $playListID
     * @param int    $maxResults
     * @param string $pageToken
     *
     * @return object
     */
    public static function getPlaylistItems($part, $playListID, $maxResults, $pageToken = null)
    {
        return Youtube::send('playlistItems', [
            'part'       => $part,
            'playlistId' => $playListID,
            'maxResults' => $maxResults,
            'pageToken'  => $pageToken
        ]);
    }
}
