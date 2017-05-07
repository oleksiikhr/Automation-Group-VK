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
}
