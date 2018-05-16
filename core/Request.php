<?php declare(strict_types=1);

namespace core;

class Request
{
    /**
     * Get value from Request in lowercase.
     *
     * @param string $name
     *
     * @return null|string
     */
    public static function getStringLowerCase(string $name)
    {
        if (isset($_REQUEST[$name]) && !empty($_REQUEST[$name])) {
            return mb_strtolower(trim($_REQUEST[$name]));
        }

        return null;
    }
}
