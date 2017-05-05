<?php

namespace gvk\vk\methods;

use gvk\Web;
use gvk\vk\VK;
use gvk\youtube\Youtube;

class Video
{
    const T_VIDEOS    = 'videos';
    const VIDEOS_LINK = 'https://vk.com/videos-' . G_ID;

    /**
     * Add a playlist of YouTube to VK.
     *
     * @param string $text
     *
     * @return bool
     */
    public static function addBD($text)
    {
        $arr = self::checkCallback($text);

        if ( empty($arr) )
            return false;

        $videos = Youtube::getPlaylistItems('id', $arr[0], 0);
        $numAlbum = \QB::table(self::T_VIDEOS)->where('playlist', $arr[0])->first();

        if ( empty($numAlbum) && empty($arr[1]) )
            return false;

        if ( empty($numAlbum->album_id) ) {
            $addedAlbum = self::addAlbum($arr[1]);
            $numAlbum = $addedAlbum->response->album_id;
        } else {
            $numAlbum = $numAlbum->album_id;
        }

        $count = 50;
        $videos = ceil($videos->pageInfo->totalResults / $count);
        $nextPageToken = '';

        for ($i = 0; $i < $videos; $i++) {
            $json = Youtube::getPlaylistItems('snippet', $arr[0], $count, $nextPageToken);

            foreach ($json->items as $item) {
                $title = preg_replace('/ +/', ' ', $item->snippet->title);
                $videoYoutubeID = preg_replace('/ +/', ' ', $item->snippet->resourceId->videoId);

                if ( ! empty(\QB::table(self::T_VIDEOS)->where('videoYoutubeID', '=', $videoYoutubeID)->first()) )
                    continue;

                \QB::table(self::T_VIDEOS)->inser([
                    'title'          => $title,
                    'videoYoutubeID' => $videoYoutubeID,
                    'album_id'       => $numAlbum,
                    'playlist'       => $arr[0],
                    'is_added'       => 0
                ]);
            }

            $nextPageToken = isset($json->nextPageToken) ? $json->nextPageToken : '';
        }

        return true;
    }

    /**
     * Screening.
     *
     * @param string $text
     *
     * @return array|false
     */
    public static function checkCallback($text)
    {
        $text = preg_replace('/ +/', ' ', $text);
        $text = preg_split('/\n/', $text);
        $text = array_map('trim', $text);

        if ( count($text) != 2 && count($text) != 1 )
            return false;

        if ( ! preg_match('/^[a-z0-9_-]+$/ui', $text[0]) )
            return false;

        return $text;
    }

    /**
     * Add video to VK from DB.
     *
     * @param int $count
     *
     * @return void
     */
    public static function downloadInVK($count)
    {
        $videos = \QB::table(self::T_VIDEOS)->where('is_added', '=', 0)->limit($count)->get();

        if ( empty($videos) )
            return;

        foreach ($videos as $video) {
            $video->album_id = 1;
            $savedVideo = self::save($video->title, $video->videoYoutubeID, $video->album_id);

            if ( ! empty($savedVideo->error) )
                return;

            $send = Web::request($savedVideo->response->upload_url, true);
            $is_added = 1;

            if ( ! empty($send->error_code) ) {
                if ($send->error_code != 7)
                    continue;

                $is_added = 2;
            }

            \QB::table(self::T_VIDEOS)
                ->where('videoYoutubeID', $video->videoYoutubeID)
                ->update([
                    'is_added'  => $is_added,
                    'videoVKID' => $savedVideo->response->video_id
                ]);
        }
    }

    /**
     * Save video in VK from Youtube.
     *
     * @param string $name
     * @param string $link
     * @param int $album_id
     *
     * @return object
     */
    public static function save($name, $link, $album_id)
    {
        return VK::send('video.save', [
            'name'     => $name,
            'link'     => Youtube::L_WATCH . $link,
            'group_id' => G_ID,
            'album_id' => $album_id
        ], T_USR);
    }

    /**
     * Get a random album from VK and create a new post.
     *
     * @return object
     */
    public static function createPost()
    {
        $albums = self::getAlbums(0);
        $albums = self::getAlbums(1, rand(0, $albums->response->count - 1));

        $albumsCount = self::get($albums->response->items[0]->id, 0);
        $offset = ($albumsCount->response->count > 10) ? $albumsCount->response->count - 10 : 0;
        $album = self::get($albums->response->items[0]->id, 10, $offset);

        $arrVideos = [];
        foreach ($album->response->items as $item) {
            $arrVideos[] = 'video-' . G_ID . '_' . $item->id;
        }

        $comment = "&#128193; " . $albums->response->items[0]->title . "\n"
            . "&#10133; " . self::VIDEOS_LINK . "?section=album_" . $albums->response->items[0]->id . "\n"
            . "#videos@eng_day";

        return VK::wallPost( $comment, implode( ',', array_reverse($arrVideos) ) );
    }

    /**
     * Get an album with video.
     *
     * @param int $count
     * @param int $offset
     *
     * @return object
     */
    public static function getAlbums($count, $offset = null)
    {
        return VK::send('video.getAlbums', [
            'owner_id' => '-' . G_ID,
            'count'    => $count,
            'offset'   => $offset
        ], T_USR);
    }

    /**
     * Get a video from VK.
     *
     * @param int $albumID
     * @param int $count
     * @param int $offset
     *
     * @return object
     */
    public static function get($albumID, $count = null, $offset = null)
    {
        return VK::send('video.get', [
            'owner_id' => '-' . G_ID,
            'album_id' => $albumID,
            'count'    => $count,
            'offset'   => $offset
        ], T_USR);
    }

    /**
     * Add a new album.
     *
     * @param string $title
     *
     * @return object
     */
    public static function addAlbum($title)
    {
        return VK::send('video.addAlbum', [
            'group_id' => G_ID,
            'title'    => $title
        ], T_USR);
    }
}
