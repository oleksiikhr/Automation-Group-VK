<?php declare(strict_types=1);

namespace core;

class Request
{
    /**
     * @todo Name
     *
     * @param string $name
     *
     * @return null|string
     */
    public static function getString(string $name)
    {
        if (isset($_REQUEST[$name]) && !empty($_REQUEST[$name])) {
            return mb_strtolower(trim($_REQUEST[$name]));
        }

        return null;
    }
}
