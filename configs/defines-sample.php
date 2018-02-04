<?php

// Debug mode
define('DEBUG', false);

// Dir
define('D_ROOT', __DIR__ . '/..');
define('D_IMG',  D_ROOT . '/resources');

// Secret data
define('CONFIRMATION', ''); // For confirmation group (dialogs group)
define('SECRET_KEY',   '');

// Database
define('DB_HOST',  'localhost');
define('DB_TABLE', '');
define('DB_USER',  '');
define('DB_PASS',  '');

// Group
define('G_ID',  '');
define('G_URL', ''); // For hashtags in the posts

// Tokens
define('T_USR',    ''); // Main token (administrator to the group)
define('T_MSG',    ''); // For answer in dialogs group
define('T_IMG',    ''); // For upload image in VK server
define('T_GOOGLE', ''); // For Youtube API

/**
 * Only for Board. (For add a new question in DB)
 * Not support now.
 *
 * @see \gvk\vk\callback\Board
 */
define('B_POLL',   '');
define('B_WORD',   '');
define('B_VIDEO',  '');
define('B_CHOOSE', '');

/**
 * Additional token accounts.
 * Uses only for Euro.
 *
 * @see \tmp\euro2017\Euro
 */
define('T_USR2', '');
define('T_USR3', '');
