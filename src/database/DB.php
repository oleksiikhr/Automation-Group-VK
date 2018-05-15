<?php declare(strict_types=1);

namespace src\database;

use PDO;

class DB
{
    private static $_instance;

    protected static function instance(): PDO
    {
        if (self::$_instance === null) {
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
}
