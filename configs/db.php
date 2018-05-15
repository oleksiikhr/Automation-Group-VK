<?php

/**
 * Connect to DB.
 *
 * @see https://github.com/usmanhalalit/pixie Docs
 */

return [
    'driver'    => getenv('DB_HOST'),
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_HOST'),
    'username'  => getenv('DB_HOST'),
    'password'  => getenv('DB_HOST'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => getenv('DB_PREFIX'),
];
