<?php declare(strict_types=1);

namespace src\models;

use core\database\DB;
use PDO;

class Verbs extends DB
{
    const TABLE = 'verbs';

    /**
     * Get records in random order.
     *
     * @param int $count
     *
     * @return array
     */
    public static function getRandom(int $count = 20): array
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' ORDER BY RAND() LIMIT 20';

        $stmt = self::instance()->prepare($query);
        $stmt->bindValue(1, $count, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
