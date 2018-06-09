<?php declare(strict_types=1);

namespace src\models;

use src\Model;

class Verbs extends Model
{
    const TABLE = 'verbs';

    /**
     * Get random records from the table.
     *
     * @param int    $count
     * @param int    $offset
     * @param string $orderColumn
     * @param string $orderBy
     *
     * @return array
     */
    public static function getList(int $count = 5, int $offset = 0, string $orderColumn = 'published_at',
                                   string $orderBy = 'ASC'): array
    {
        $query = \QB::table(self::TABLE)
            ->selectDistinct([
                self::TABLE . '.*',
                WordsEng::TABLE . '.word_eng'
            ])
            ->join(WordsEng::TABLE, WordsEng::TABLE . '.word_eng_id', '=', self::TABLE . '.word_eng_id')
            ->orderBy($orderColumn, $orderBy)
            ->limit($count)
            ->offset($offset);

        $words = $query->get();

        WordsEng::appendRusWords($words);

        return $words;
    }

    /**
     * Set published_at to now.
     *
     * @param array $ids
     *
     * @return bool
     */
    public static function setPublishedAtNow(array $ids): bool
    {
        return parent::setPublishedAtNow($ids);
    }
}
