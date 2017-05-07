<?php

namespace gvk;

class Config
{
    const TABLE = 'config';

    /**
     * Set and get a random key.
     *
     * @return string
     */
    public static function setRandomSecretKey()
    {
        $key = bin2hex( openssl_random_pseudo_bytes(15) );

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
