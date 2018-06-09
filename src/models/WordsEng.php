<?php declare(strict_types=1);

namespace src\models;

class WordsEng
{
    const TABLE = 'words_eng';
    
    const WEIGHT_SMALL    = 0;
    const WEIGHT_AVERAGE  = 1;
    const WEIGHT_LARGE    = 2;

    /**
     * Get word list.
     *
     * @param int    $count
     * @param int    $offset
     * @param string $orderBy
     *
     * @return array
     */
    public static function getListOrderPublishedAt(int $count = 5, int $offset = 0, string $orderBy = 'ASC'): array
    {
        $query = \QB::table(self::TABLE)
            ->selectDistinct(self::TABLE . '.*')
            ->leftJoin('word_eng_rus', 'word_eng_rus.word_eng_id', '=', self::TABLE . '.word_eng_id')
            ->where(self::TABLE . '.enabled', '=', 1)
            ->whereIn('word_eng_rus.weight', [self::WEIGHT_AVERAGE, self::WEIGHT_LARGE])
            ->orderBy(self::TABLE . '.published_at', $orderBy)
            ->limit($count)
            ->offset($offset);

        $words = $query->get();

        self::appendRusWords($words);

        return $words;
    }

    /**
     * Set published_at to now.
     *
     * @param array|int $ids
     *
     * @return bool
     */
    public static function setPublishedAtNow($ids): bool
    {
        return \QB::table(self::TABLE)
            ->whereIn('word_eng_id', is_array($ids) ? $ids : [$ids])
            ->update(['published_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * Decrease rating by 1.
     *
     * @param array|int $ids
     *
     * @return bool
     */
    public static function decrementRating($ids): bool
    {
        return \QB::table(self::TABLE)
            ->whereIn('word_eng_id', is_array($ids) ? $ids : [$ids])
            ->where('rating', '>', 0)
            ->update(['rating' => \QB::raw('rating - 1')]);
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
