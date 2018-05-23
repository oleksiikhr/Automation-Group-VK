<?php declare(strict_types=1);

namespace core\database;

use PDO;

class DB
{
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
}
