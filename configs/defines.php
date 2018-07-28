<?php declare(strict_types=1);

// Application
define('APP_DEBUG', getenv('APP_DEBUG') === 'true' ?: false);
define('APP_SECRET', getenv('APP_SECRET') ?: '');
define('APP_TIMEZONE', getenv('APP_TIMEZONE') ?: 'Europe/Berlin');

// DIR
define('D_ROOT', __DIR__ . '/..');
define('D_RESOURCES',  D_ROOT . '/resources');

// VK
define('VK_CONFIRMATION', getenv('VK_CONFIRMATION') ?: '');
define('VK_SECRET', getenv('VK_SECRET') ?: '');
define('VK_LANG', getenv('VK_LANG') ?: 'ru');

// Group
define('G_ID', getenv('G_ID') ?: '');
define('G_DOMAIN', getenv('G_DOMAIN') ?: '');
