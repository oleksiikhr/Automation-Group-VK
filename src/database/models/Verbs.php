<?php declare(strict_types=1);

namespace src\database\models;

use PDO;
use src\database\DB;

class Verbs extends DB
{
    public static function get()
    {
        return self::instance()->query('SELECT * FROM verbs LIMIT 10')->fetchAll(PDO::FETCH_OBJ);
    }
}
