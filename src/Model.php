<?php

namespace src;

abstract class Model
{
    const TABLE = '';

    /**
     * Set published_at to now.
     *
     * @param array $ids
     *
     * @return bool
     */
    protected static function setPublishedAtNow(array $ids): bool
    {
        return (bool) \QB::table(static::TABLE)
            ->whereIn('word_eng_id', $ids)
            ->update(['published_at' => date('Y-m-d H:i:s')])
            ->rowCount();
    }
}
