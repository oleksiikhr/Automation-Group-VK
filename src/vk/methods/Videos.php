<?php

namespace gvk\vk\methods;

use gvk\vk\VK;
use gvk\youtube\Youtube;

class Videos extends VK
{
    protected $table = 'videos';

    /**
     * Add in vk playlist from youtube.
     *
     * @param $text
     *
     * @return bool
     */
    function addBD($text)
    {
        $youtube = new Youtube();

        $words = $this->checkCallback($text);
        $count = 50; // Temporary*

        if ( is_bool($words) ) {
            return false;
        }

        $list = $words[0];
        $titleAlbum = isset($words[1]) ? $words[1] : 'New Album ' . rand();

        $video = $youtube->send('playlistItems', [
            'part'       => 'id',
            'playlistId' => $list,
            'maxResults' => 0
        ]);

        // Если нету в БД этого плейлиста, то создаем новый альбом
        $num_album = $this->getData(['playlist' => $list])[0];
        $num_album = empty($num_album->album_id) ? 0 : $num_album->album_id;

        if ( ! $num_album ) {
            $num_album = $this->send('video.addAlbum', [
                'group_id' => GROUP_ID,
                'title'    => $titleAlbum
            ], TOKEN_USER);

            $num_album = $num_album->response->album_id;
        }

        $video = ceil($video->pageInfo->totalResults / $count);
        $nextPageToken = '';

        for ($i = 0; $i < $video; $i++) {
            $json = $youtube->send('playlistItems', [
                'part'       => 'snippet',
                'playlistId' => $list,
                'maxResults' => $count,
                'pageToken'  => $nextPageToken
            ]);

            foreach ($json->items as $item) {
                $title = preg_replace('| +|', ' ', $item->snippet->title);
                $videoYoutubeID = preg_replace('| +|', ' ', $item->snippet->resourceId->videoId);

                if ( ! empty( $this->getData(['videoYoutubeID' => $videoYoutubeID]) ) ) {
                    continue;
                }

                $this->insert([
                    'title' => $title,
                    'videoYoutubeID' => $videoYoutubeID,
                    'album_id' => $num_album,
                    'playlist' => $list,
                    'is_added' => 0
                ]);
            }
            $nextPageToken = isset($json->nextPageToken) ? $json->nextPageToken : '';
        }

        return true;
        //https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=PL3KDFIV9zTkzKyHAKHhZSIWfRZwY6UBNX&maxResults=50&key=AIzaSyB3fBIqZ70S2LNqSq6ID8frsNVJESJSQG4
    }

    /**
     * Screening.
     *
     * @param string $words
     *
     * @return array|false
     */
    function checkCallback($words)
    {
        $words = preg_replace('| +|', ' ', $words); // Убираем n-пробелы
        $words = preg_split('/\n/', $words); // Разбиваем на массив

        if ( count($words) != 2 && count($words) != 1 ) {
            return false;
        }

        if ( ! preg_match('/^[a-z0-9_-]+$/ui', $words[0]) ) {
            return false;
        }

        return $words;
    }

    /**
     * Add video in vk form Database.
     *
     * @param int $num
     *
     * @return void
     */
    function downloadInVK($num)
    {
        $videos = $this->getData( ['is_added' => 0], \PDO::FETCH_CLASS, (int)$num );

        if ( ! $videos ) return;

        foreach ($videos as $video) {
            $saveVideo = $this->saveVideoInVK($video->title, $video->videoYoutubeID, $video->album_id);
            if ( ! empty($saveVideo->error) ) return;

            $videoVKID = $saveVideo->response->video_id;

            $send = $this->request($saveVideo->response->upload_url, true);
            $is_added = 1;

            if ($send->error_code == 7) {
                $send->response = 1;
                $is_added = 2;
            } elseif ( ! empty($send->error_code) ) {
                return;
            }

            if ($send->response) {
                $isAdded = $this->update(
                    ['is_added' => $is_added, 'videoVKID' => $videoVKID],
                    ['videoYoutubeID' => $video->videoYoutubeID]
                );
                if ( ! $isAdded ) return;
                continue;
            }
            return;
        }
    }

    /**
     * Save video in vk.
     *
     * @param string $name
     * @param string $link
     * @param int $album_id
     *
     * @return object
     */
    function saveVideoInVK($name, $link, $album_id)
    {
        return $this->send('video.save', [
            'name'     => $name,
            'link'     => 'https://www.youtube.com/watch?v=' . $link,
            'group_id' => GROUP_ID,
            'album_id' => $album_id
        ], TOKEN_USER);
    }

    /**
     * Get Random Album from vk and post on wall.
     *
     * @return object
     */
    public function createPostVideos()
    {
        $albums = $this->send('video.getAlbums', [
            'owner_id' => '-' . GROUP_ID,
            'count'    => 100
        ], TOKEN_USER);

        $albumRND = rand(0, $albums->response->count - 1);
        $albumID = $albums->response->items[$albumRND]->id;

        $albumCount = $this->send('video.get', [
            'owner_id' => '-' . GROUP_ID,
            'album_id' => $albumID,
            'count'    => 0
        ], TOKEN_USER);

        $albumCount = $albumCount->response->count;

        $arrVideos = [];
        $offset = 0;

        if ($albumCount > 10) {
            $offset = $albumCount - 10;
        }

        $album = $this->send('video.get', [
            'owner_id' => '-' . GROUP_ID,
            'album_id' => $albumID,
            'count'    => 10,
            'offset'   => $offset
        ], TOKEN_USER);

        foreach ($album->response->items as $item) {
            $arrVideos[] = 'video-' . GROUP_ID . '_' . $item->id;
        }

        $comment = "&#128193; " . $albums->response->items[$albumRND]->title . "\n"
            . "&#10133; https://vk.com/videos-132378855?section=album_" . $albumID . "\n"
            . "#videos@eng_day";

        return $this->createPost( $comment, implode( ',', array_reverse($arrVideos) ) );
    }
}
