<?php declare(strict_types=1);

/*
 * FIXME IMPORTANT - DELETE AFTER INITIAL
 */

require_once __DIR__ . '/../configs/defines.php';

$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE,
    DB_USERNAME,
    DB_PASSWORD,
    [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
    ]
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// TODO time
//$pdo->query('CREATE TABLE IF NOT EXISTS ' . \src\models\Verbs::TABLE . ' (
//
//)');
