<?php

namespace gvk\vk\parse;

use gvk\vk\VK;
use gvk\youtube\Youtube;
use gvk\vk\methods\Videos;

class Parse extends VK
{
    protected $table = null;

    public function __construct()
    {
        parent::__construct();

        require_once DIR_ROOT . '/src/libs/SimpleHtmlDom.php';
    }

    /**
     * Update transcription with Lingorado in DB.
     *
     * @param int $count
     *
     * @return void
     */
    public function updateTranscription($count = 1)
    {
        $this->table = 'translate';

        $text = $this->getData(
            ['transcription' => ''],
            \PDO::FETCH_OBJ,
            $count
        );

        foreach ($text as $item) {
            $data = $this->getLingorado($item->word_eng);

            if ( ! $data ) {
                return;
            }

            $html = str_get_html($data);

            $transcription = '';
            foreach ( $html->find('.transcribed_word') as $span ) {
                $partText = preg_replace('/[^а-яА-ЯёЁ\s]/ui', '', $span);
                $transcription .= $partText;
            }

            if ( empty($transcription) ) {
                $transcription = '-';
            }

            $this->updateByID(
                ['transcription' => trim($transcription)],
                $item->id
            );
        }
    }

    /**
     * Get rus transcription with Lingorado.
     *
     * @param string $text
     *
     * @return object
     */
    function getLingorado($text)
    {
        $data = $this->request('http://lingorado.com/transcription/', false, 'POST', [
            'text_to_transcribe' => $text,
            'submit' => 'Показать транскрипцию',
            'output_dialect' => 'br',
            'output_style' => 'only_tr',
            'native' => 'on',
            'preBracket' => '',
            'postBracket' => '',
            'speech_support' => 1
        ]);

        return $data;
    }

    /**
     * Update video from youtube in vk.
     *
     * @return void
     */
    public function updateRandomPlaylist()
    {
        $this->table = 'videos';

        $video = new Videos();
        $youtube = new Youtube();

        $playlist = $video->getUniquePlaylist();
        $playlist = $playlist[rand( 0, count($playlist) - 1 )];
        $playlist = $playlist->playlist;

        $count = 50;

        $video = $youtube->send('playlistItems', [
            'part'       => 'id',
            'playlistId' => $playlist,
            'maxResults' => 0
        ]);

        // Если нету в БД этого плейлиста, то создаем новый альбом
        $num_album = $this->getData(['playlist' => $playlist])[0];
        $num_album = $num_album->album_id;

        $video = ceil($video->pageInfo->totalResults / $count);
        $nextPageToken = '';

        for ($i = 0; $i < $video; $i++) {
            $json = $youtube->send('playlistItems', [
                'part'       => 'snippet',
                'playlistId' => $playlist,
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
                    'playlist' => $playlist,
                    'is_added' => 0
                ]);
            }

            $nextPageToken = isset($json->nextPageToken) ? $json->nextPageToken : '';
        }
    }
}
