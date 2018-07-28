<?php declare(strict_types=1);

namespace core;

class Protect
{
    /**
     * Checking the secret key for the files of the cron-tasks.
     *
     * @return bool
     */
    public static function cron(): bool
    {
        if (empty(APP_SECRET)) {
            return true;
        }

        return !empty($_REQUEST['secret']) || $_REQUEST['secret'] === APP_SECRET;
    }

    /**
     * Checking the secret key for the files of the callback-files.
     *
     * @return bool
     */
    public static function callback(): bool
    {
        // TODO
    }
}
