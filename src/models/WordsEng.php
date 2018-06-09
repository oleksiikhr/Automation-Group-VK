<?php declare(strict_types=1);

namespace src\models;

class WordsEng
{
    const TABLE = 'words_eng';

    const WEIGHT_SMALL    = 0;
    const WEIGHT_AVERAGE  = 1;
    const WEIGHT_LARGE    = 2;

    /**
     * Get a list of English words along with the translation.
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
            ->selectDistinct(self::TABLE . '.*')
            ->leftJoin('word_eng_rus', 'word_eng_rus.word_eng_id', '=', self::TABLE . '.word_eng_id')
            ->where(self::TABLE . '.enabled', '=', 1)
            ->whereIn('word_eng_rus.weight', [self::WEIGHT_AVERAGE, self::WEIGHT_LARGE])
            ->orderBy(self::TABLE . '.' . $orderColumn, $orderBy)
            ->limit($count)
            ->offset($offset);

        $words = $query->get();

        self::appendRusWords($words);

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
        return (bool) \QB::table(self::TABLE)
            ->whereIn('word_eng_id', $ids)
            ->update(['published_at' => date('Y-m-d H:i:s')])
            ->rowCount();
    }

    /**
     * Change the current word rating.
     *
     * @param array $ids
     * @param int   $val
     *
     * @return bool
     */
    public static function addRating(array $ids, int $val): bool
    {
        return (bool) \QB::table(self::TABLE)
            ->whereIn('word_eng_id', $ids)
            ->update(['rating' => \QB::raw('rating + ' . $val)])
            ->rowCount();
    }

    /**
     * Change the current word favorite.
     *
     * @param array $ids
     * @param int   $val
     *
     * @return bool
     */
    public static function addFavorite(array $ids, int $val): bool
    {
        return (bool) \QB::table(self::TABLE)
            ->whereIn('word_eng_id', $ids)
            ->update(['rating' => \QB::raw('favorite + ' . $val)])
            ->rowCount();
    }

    /**
     * Get data from the database and add to the current array.
     *
     * @param array $words
     * @param bool  $mainTranslate
     *
     * @return void
     */
    private static function appendRusWords(array &$words, bool $mainTranslate = true): void
    {
        $ids = array_column($words, 'word_eng_id');

        $query = \QB::table(self::TABLE)
            ->select([self::TABLE . '.word_eng_id', 'words_rus.*', 'word_eng_rus.weight'])
            ->join('word_eng_rus', 'word_eng_rus.word_eng_id', '=', self::TABLE . '.word_eng_id')
            ->join('words_rus', 'words_rus.word_rus_id', '=', 'word_eng_rus.word_rus_id')
            ->whereIn(self::TABLE . '.word_eng_id', $ids);

        if ($mainTranslate) {
            $query->whereIn('word_eng_rus.weight', [self::WEIGHT_AVERAGE, self::WEIGHT_LARGE]);
        }

        $wordsRus = $query->get();

        foreach ($wordsRus as $word) {
            $words[array_search($word->word_eng_id, $ids)]->{'translate'}[] = $word;
        }
    }
}
