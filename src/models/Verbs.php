<?php declare(strict_types=1);

namespace src\models;

use core\database\DB;
use PDO;

class Verbs extends DB
{
    const TABLE = 'verbs';

    /**
     * Get random records from the table.
     *
     * @param int $count
     *
     * @return array
     */
    public static function getRandom(int $count = 20): array
    {
        return self::getRandomRecords($count);
    }
}
