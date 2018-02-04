<?php

namespace gvk\vk\parse;

use gvk\Web;
use gvk\Config;
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

            if (empty($data)) {
                return;
            }

            $html = str_get_html($data);
            $transcription = '';

            foreach ( $html->find('.transcribed_word') as $span ) {
                $partText = preg_replace('/[^а-яА-ЯёЁ\s]/ui', '', $span);
                $transcription .= $partText;
            }

            if (empty($transcription)) {
                $transcription = '-';
            }

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
     * Update video from YouTube to DB.
     *
     * @return void
     */
    public static function updateRandomPlaylist()
    {
        $playlists = Config::getYoutubePlayList();

        if (empty($playlists)) {
            return;
        }

        $playlist = $playlists[array_rand($playlists, 1)];
        $video = Youtube::getPlaylistItems('id', $playlist, 0);

        $num_album = \QB::table(Video::TABLE)->select('album_id')->where('playlist', '=', $playlist)->first();
        $num_album = $num_album->album_id;

        if (empty($num_album)) {
            return;
        }

        Video::updatePlaylist($video->pageInfo->totalResults, $playlist, $num_album);
    }
}
