<?php

/**
 * Connect to Database.
 *
 * @see https://github.com/usmanhalalit/pixie docs
 *
 * @return array
 */

return [
    'driver'    => getenv('DB_CONNECTION') ?: 'mysql',
    'host'      => getenv('DB_HOST') ?: '127.0.0.1',
    'database'  => getenv('DB_DATABASE') ?: 'english',
    'username'  => getenv('DB_USERNAME') ?: 'root',
    'password'  => getenv('DB_PASSWORD') ?: '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
];
