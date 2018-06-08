<?php declare(strict_types=1);

namespace core\database;

use PDO;

abstract class Model extends DB
{
    /**
     * @var string
     */
    protected static $table;

    /**
     * Get the number of records from the table.
     *
     * @return int
     */
    protected static function getCount(): int
    {
        return self::instance()->query('SELECT COUNT(*) FROM ' . static::$table)
            ->fetch(PDO::FETCH_NUM)[0];
    }

    /**
     * Get random records from the table.
     *
     * @param int $count
     *
     * @return array
     */
    protected static function getRandomRecords(int $count = 1): array
    {
        $stmt = self::instance()->prepare('
            SELECT *
            FROM ' . static::$table . '
            WHERE RAND()<(SELECT ((:limit/COUNT(*))*10) FROM ' . static::$table . ')
            ORDER BY RAND()
            LIMIT :limit
        ');

        $stmt->bindParam(':limit', $count, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
