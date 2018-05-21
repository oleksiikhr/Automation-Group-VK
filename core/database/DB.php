<?php declare(strict_types=1);

namespace core\database;

use PDO;

class DB
{
    const TABLE = ''; // FIXME

    private static $_instance;

    /**
     * Establish a connection to the database.
     *
     * @return PDO
     */
    protected static function instance(): PDO
    {
        if (is_null(self::$_instance)) {
            try {

                self::$_instance = new PDO(
                    'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE,
                    DB_USERNAME,
                    DB_PASSWORD,
                    [
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
                    ]
                );
                self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (\PDOException $e) {
                die('PDO Connection error: ' . $e->getMessage());
            }
        }

        return self::$_instance;
    }

    /**
     * Get the number of records from the table.
     *
     * @return int
     */
    protected static function getCount(): int
    {
        return self::instance()->query('SELECT COUNT(*) FROM ' . static::TABLE)
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
            FROM ' . static::TABLE . '
            WHERE RAND()<(SELECT ((:limit/COUNT(*))*10) FROM ' . static::TABLE . ')
            ORDER BY RAND()
            LIMIT :limit
        ');

        $stmt->bindParam(':limit', $count, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
