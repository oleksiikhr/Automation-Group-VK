<?php

namespace src\models;

use core\database\Model;
use PDO;

class WordsEng extends Model
{
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
        $stmt = self::instance()->prepare('
            SELECT *
            FROM ' . self::$table . '
            WHERE enabled = 1
            ORDER BY published_at
            LIMIT :limit
        ');

        // GROUP_CONCAT(col1 SEPARATOR '')

        $stmt->bindParam(':limit', $count, PDO::PARAM_INT);
        $stmt->execute();
        $wordsEng = $stmt->fetchAll(PDO::FETCH_OBJ);
        var_dump($wordsEng); echo '<br><br>';

//        $stmt = self::instance()->prepare('
//            SELECT we.word_eng, wr.word_rus
//            FROM   words_eng we
//            JOIN   word_eng_rus x ON s.stud_id = x.stud_id
//            JOIN   word_eng_rus y ON s.stud_id = y.stud_id
//            WHERE  wr.enabled = 1
//        ');

        $stmt = self::instance()->prepare('
            SELECT we.word_eng, wr.word_rus
            FROM words_eng AS we
            INNER JOIN words_rus AS wr
              ON wr.word_rus_id = wr.word_rus_id
            INNER JOIN word_eng_rus as wer
              ON we.word_eng_id = wer.word_eng_id
            LIMIT 10
        ');
        $stmt->execute();
        $wordsRus = $stmt->fetchAll(PDO::FETCH_OBJ);
        var_dump($wordsRus);

//        foreach ($wordsRus as $word) {
//            if ($word->word_rus_id === $wordsEng->word_eng_id) {
//
//            }
//        }

//        $stmt = self::instance()->prepare('
//            SELECT *
//            FROM ' . self::$table . '
//            WHERE word_eng_id IN (' . implode(',', array_column($wordsEng, 'word_eng_id')) . ')
//        ');
    }

    /**
     * Get random records from the table.
     *
     * @param int $count
     *
     * @return array
     */
    public static function getRandom(int $count = 20): array
    {
        $stmt = self::instance()->prepare('
            SELECT *
            FROM ' . static::$table . '
            WHERE RAND()<(SELECT ((:limit/COUNT(*))*10) FROM ' . static::$table . ')
                AND enabled = 1
            ORDER BY RAND()
            LIMIT :limit
        ');

        $stmt->bindParam(':limit', $count, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
