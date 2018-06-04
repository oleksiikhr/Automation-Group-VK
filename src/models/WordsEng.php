<?php

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
     * Get records that have been published a long time ago.
     *
     * @param int $count
     *
     * @return array
     */
    public static function getNewList(int $count = 5): array
    {
        // TODO GROUP_CONCAT(col1 SEPARATOR '') - tags
        $stmt = self::instance()->prepare('
            SELECT *
            FROM ' . self::$table . ' as wr
            WHERE enabled = 1
                AND EXISTS (SELECT * FROM word_eng_rus wer WHERE wr.word_eng_id = wer.word_eng_id)
            ORDER BY published_at
            LIMIT :limit
        ');

        $stmt->bindParam(':limit', $count, PDO::PARAM_INT);
        $stmt->execute();
        $words = $stmt->fetchAll(PDO::FETCH_OBJ);

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
    public static function setPublishedAtNow($ids)
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
     * Get data from the database and add to the current array.
     *
     * @param array $words
     * @param bool  $basicWords
     *
     * @return void
     */
    private static function appendRusWords(array &$words, bool $basicWords = true): void
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

        if ($basicWords) {
            $sql .= ' AND (wer.weight = '.self::WEIGHT_AVERAGE.' OR wer.weight = '.self::WEIGHT_LARGE.')';
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
