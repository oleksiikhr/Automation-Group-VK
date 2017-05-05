<?php

namespace gvk\vk\parse;

use gvk\DB;
use gvk\Web;
use gvk\youtube\Youtube;
use gvk\vk\methods\Video;
use gvk\vk\methods\Translate;

class Parse
{
    /**
     * Update transcription with Lingorado in DB.
     *
     * @param int $count
     *
     * @return void
     */
    public function updateTranscription($count = 1)
    {
        require_once D_ROOT . '/src/libs/SimpleHtmlDom.php';

        $q = \QB::table(Translate::TABLE)->where('transcription', '=', '')->limit($count)->get();

        foreach ($q as $item) {
            $data = self::getLingorado($item->word_eng);

            if ( empty($data) )
                return;

            $html = str_get_html($data);
            $transcription = '';

            foreach ( $html->find('.transcribed_word') as $span ) {
                $partText = preg_replace('/[^а-яА-ЯёЁ\s]/ui', '', $span);
                $transcription .= $partText;
            }

            if ( empty($transcription) )
                $transcription = '-';

            \QB::table(Translate::TABLE)->where('id', '=', $item->id)->update([
                'transcription' => trim($transcription)
            ]);
        }
    }

    /**
     * To receive Russian transcription.
     *
     * @param string $text
     *
     * @return object
     */
    public static function getLingorado($text)
    {
        return Web::request('http://lingorado.com/transcription/', false, 'POST', [
            'text_to_transcribe' => $text,
            'submit' => 'Показать транскрипцию',
            'output_dialect' => 'br',
            'output_style' => 'only_tr',
            'native' => 'on',
            'preBracket' => '',
            'postBracket' => '',
            'speech_support' => 1
        ]);
    }

    /**
     * Update video from YouTube to VK.
     * !! NEW TABLE -> CONFIG !!
     *
     * @return void
     */
    public static function updateRandomPlaylist()
    {
//        $this->table = 'videos';
//
//        $video = new Video();
//        $youtube = new Youtube();
//
//        $playlist = $video->getUniquePlaylist();
//        $playlist = $playlist[rand( 0, count($playlist) - 1 )];
//        $playlist = $playlist->playlist;
//
//        $video = $youtube->send('playlistItems', [
//            'part'       => 'id',
//            'playlistId' => $playlist,
//            'maxResults' => 0
//        ]);
//
//        // Если нету в БД этого плейлиста, то создаем новый альбом
//        $num_album = $this->getData(['playlist' => $playlist])[0];
//        $num_album = $num_album->album_id;
//
//        $count = 50;
//        $video = ceil($video->pageInfo->totalResults / $count);
//        $nextPageToken = '';
//
//        for ($i = 0; $i < $video; $i++) {
//            $json = $youtube->send('playlistItems', [
//                'part'       => 'snippet',
//                'playlistId' => $playlist,
//                'maxResults' => $count,
//                'pageToken'  => $nextPageToken
//            ]);
//
//            foreach ($json->items as $item) {
//                $title = preg_replace('| +|', ' ', $item->snippet->title);
//                $videoYoutubeID = preg_replace('| +|', ' ', $item->snippet->resourceId->videoId);
//
//                if ( ! empty( $this->getData(['videoYoutubeID' => $videoYoutubeID]) ) ) {
//                    continue;
//                }
//
//                $this->insert([
//                    'title' => $title,
//                    'videoYoutubeID' => $videoYoutubeID,
//                    'album_id' => $num_album,
//                    'playlist' => $playlist,
//                    'is_added' => 0
//                ]);
//            }
//
//            $nextPageToken = isset($json->nextPageToken) ? $json->nextPageToken : '';
//        }
    }
}
