<?php declare(strict_types=1);

namespace src\models;

use src\Model;

class WordsEng extends Model
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
            ->where(self::TABLE . '.enabled', '=', 1)
            ->orderBy(self::TABLE . '.' . $orderColumn, $orderBy)
            ->limit($count)
            ->offset($offset);

        $words = $query->get();

        self::appendRusWords($words);

        return $words;
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
    public static function appendRusWords(array &$words, bool $mainTranslate = true): void
    {
        $ids = array_column($words, 'word_eng_id');

        $query = \QB::table(self::TABLE)
            ->select([
                self::TABLE . '.word_eng_id',
                WordsRus::TABLE . '.*', WordEngRus::TABLE . '.weight'
            ])
            ->join(WordEngRus::TABLE, WordEngRus::TABLE . '.word_eng_id', '=', self::TABLE . '.word_eng_id')
            ->join(WordsRus::TABLE, WordsRus::TABLE . '.word_rus_id', '=', WordEngRus::TABLE . '.word_rus_id')
            ->whereIn(self::TABLE . '.word_eng_id', $ids);

        if ($mainTranslate) {
            $query->whereIn(WordEngRus::TABLE . '.weight', [self::WEIGHT_AVERAGE, self::WEIGHT_LARGE]);
        }

        $wordsRus = $query->get();

        foreach ($wordsRus as $word) {
            $words[array_search($word->word_eng_id, $ids)]->{'translate'}[] = $word;
        }
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
