<?php

namespace gvk;

class Config
{
    use Methods;

    const TABLE = 'config';

    /**
     * Set and get a random key.
     *
     * @return string
     */
    public static function setRandomSecretKey()
    {
        $key = self::getRandomString(15);

        \QB::table(self::TABLE)->where('name', '=', 'secret_key')->update([
            'value' => $key
        ]);

        return $key;
    }

    /**
     * Get a secret key to access the file.
     *
     * @return string
     */
    public static function getSecretKey()
    {
        $key = \QB::table(self::TABLE)->select('value')->where('name', '=', 'secret_key')->first();

        return $key->value;
    }

    /**
     * Get Youtube playlist from DB.
     *
     * @return array
     */
    public static function getYoutubePlayList()
    {
        $playlists = \QB::table(self::TABLE)->select('value')->where('name', '=', 'youtube_playlists')->first();

        return empty($playlists->value) ? [] : unserialize( base64_decode($playlists->value) );
    }

    /**
     * Add Youtube playlist to DB.
     *
     * @param string $value
     *
     * @return void
     */
    public static function addYoutubePlaylist($value)
    {
        $playlists = self::getYoutubePlayList();
        $playlists[] = $value;

        \QB::table(self::TABLE)->where('name', '=', 'youtube_playlists')->update([
            'value' => base64_encode( serialize( array_unique($playlists) ) )
        ]);
    }
}
