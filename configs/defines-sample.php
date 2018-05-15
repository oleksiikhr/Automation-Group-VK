<?php declare(strict_types=1);

// APP
define('APP_DEBUG', false);
define('APP_SECRET', '');

// DIR
define('D_ROOT', __DIR__ . '/..');
define('D_IMG',  D_ROOT . '/resources');

// Secret data
define('VK_CONFIRMATION', '');
define('VK_SECRET',       '');
define('VK_LANG',         'ru');

// Database
define('DB_DRIVER',   'mysql');
define('DB_HOST',     'localhost');
define('DB_DATABASE', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_PREFIX',   '');

// Group
define('G_ID',  '');
define('G_URL', '');

// Token
// Site - vk, google, etc
// Type - user, group
// Access - management, message, photo, document
define('TOKENS', [
    'user-main' => [
        'site' => 'vk',
        'type' => 'user',
        'access' => [],
        'token' => ''
    ],
    'group-message' => [
        'site' => 'vk',
        'type' => 'group',
        'access' => ['message'],
        'token' => ''
    ],
    'group-photo' => [
        'site' => 'vk',
        'type' => 'group',
        'access' => ['photo'],
        'token' => ''
    ]
]);
