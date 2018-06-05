<?php declare(strict_types=1);

namespace src;

abstract class Controller
{
    /**
     * @var string
     */
    protected const HASHTAG = '';

    // todo?
    protected const SMILE = '';

    /**
     * Get a hashtag for separating posts and improving search.
     *
     * @return string
     */
    protected static function getHashtag(): string
    {
        $hashtag = '#' . static::HASHTAG . '@' . G_DOMAIN;

        return $hashtag . ' #ver_2@' . G_DOMAIN;
    }

    /**
     * todo All attachments (for)*
     *
     * @param int $photoId
     *
     * @return string
     */
    public static function getPhotoAttachment(int $photoId): string
    {
        return 'photo-' . G_ID . '_' . $photoId;
    }
}
