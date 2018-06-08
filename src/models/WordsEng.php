<?php declare(strict_types=1);

namespace src\models;

use core\database\Model;
use PDO;

class WordsEng extends Model
{
    const WEIGHT_SMALL    = 0;
    const WEIGHT_AVERAGE  = 1;
    const WEIGHT_LARGE    = 2;

    /**
     * @var string
     */
    protected static $table = 'words_eng';

    /**
     * Get word list.
     *
     * @param int  $count
     * @param int  $countDB
     * @param bool $orderDesc
     * @param bool $mainTranslate
     *
     * @return array
     */
    public static function getListOrderPublishedAt(int $count = 5, int $countDB = 5, bool $orderDesc = false, bool $mainTranslate = true): array
    {
        $sqlWhereWeight = $mainTranslate ? 'AND wer.weight IN (' . self::WEIGHT_AVERAGE . ',' . self::WEIGHT_LARGE . ')' : null;
        $sqlOrderByColumn = 'published_at' . ($orderDesc ? ' DESC' : null);

        $stmt = self::instance()->prepare('
            SELECT *
            FROM ' . self::$table . ' as wr
            WHERE enabled = 1
                AND EXISTS (
                    SELECT *
                    FROM word_eng_rus wer
                    WHERE wr.word_eng_id = wer.word_eng_id ' . $sqlWhereWeight . '
                )
            ORDER BY ' . $sqlOrderByColumn . '
            LIMIT :limit
        ');

        $stmt->bindParam(':limit', $count, PDO::PARAM_INT);
        $stmt->execute();
        $words = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($count < $countDB) {
            shuffle($words);
            array_splice($words, $count);
        }

        self::appendRusWords($words, $mainTranslate);

        return $words;
    }

    /**
     *
     */
    public static function getListOrderRating()
    {

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
        if (is_array($ids)) {
            $count = count($ids);
            $prepare = mb_substr(str_repeat('?,', $count), 0, $count * 2 - 1);
        } else {
            $prepare = '?';
        }

        $stmt = self::instance()->prepare('
            UPDATE ' . self::$table . '
            SET published_at = "' . date('Y-m-d H:i:s') . '"
            WHERE word_eng_id IN (' . $prepare . ')
        ');

        return $stmt->execute(is_array($ids) ? $ids : [$ids]);
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
        if (is_array($ids)) {
            $count = count($ids);
            $prepare = mb_substr(str_repeat('?,', $count), 0, $count * 2 - 1);
        } else {
            $prepare = '?';
        }

        $stmt = self::instance()->prepare('
            UPDATE ' . self::$table . '
            SET rating = rating - 1
            WHERE word_eng_id IN (' . $prepare . ')
                AND rating > 0
        ');

        return $stmt->execute(is_array($ids) ? $ids : [$ids]);
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

        // TODO table (models)
        $sql = 'SELECT we.word_eng_id, wr.*
            FROM ' . self::$table . ' AS we
            INNER JOIN word_eng_rus AS wer
              ON we.word_eng_id = wer.word_eng_id
            INNER JOIN words_rus AS wr
              ON wr.word_rus_id = wer.word_rus_id
            WHERE we.word_eng_id IN (' . implode(',', $ids) . ')';

        if ($mainTranslate) {
            $sql .= ' AND (wer.weight = ' . self::WEIGHT_AVERAGE . ' OR wer.weight = ' . self::WEIGHT_LARGE . ')';
        }

        $stmt = self::instance()->query($sql);
        $wordsRus = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($wordsRus as $word) {
            $searchIndex = array_search($word->word_eng_id, $ids);
            if ($searchIndex !== false) {
                $words[$searchIndex]->{'translate'}[] = $word;
                continue;
            }
        }
    }
}
