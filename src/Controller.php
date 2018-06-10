<?php declare(strict_types=1);

namespace src;

abstract class Controller
{
    /**
     * @var string
     */
    protected const HASHTAG = '';

    // TODO?
    protected const SMILE = '';

    /**
     * Get a hashtag for separating posts and improving search.
     *
     * @return string
     */
    protected static function getHashtag(): string
    {
        $hashtag = '#' . static::HASHTAG . '@' . G_DOMAIN;

        // FIXME Temporary
        return $hashtag . ' #ver2@' . G_DOMAIN;
    }
}
