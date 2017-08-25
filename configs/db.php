<?php

/**
 * Connect to DB.
 *
 * @see https://github.com/usmanhalalit/pixie docs
 */

return [
    'driver'    => 'mysql',
    'host'      => DB_HOST,
    'database'  => DB_TABLE,
    'username'  => DB_USER,
    'password'  => DB_PASS,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
];
