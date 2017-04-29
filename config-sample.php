<?php if ( empty($_GET['secret']) || $_GET['secret'] !== '__SECRET_KEY__' ) die;

require_once __DIR__ . '/vendor/autoload.php';

// Rename to "config.php"

define('ROOT', __DIR__);
define('DIR_IMAGE', __DIR__ . '/img/');
define('CONFIRMATION', '');

define('METHOD_VK', 'https://api.vk.com/method/');
define('METHOD_YOUTUBE', 'https://www.googleapis.com/youtube/v3/');
define('GROUP_ID', '');
define('VERSION_VK', '5.62');

define('DB_HOST', 'localhost');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');

define('TOKEN_USER', '');
define('TOKEN_GROUP_MSG', '');
define('TOKEN_GROUP_IMG', '');
define('TOKEN_GOOGLE', '');

define('BOARD_ADD_POOL', '');
define('BOARD_ADD_WORD', '');
define('BOARD_ADD_VIDEO', '');
define('BOARD_ADD_CHOOSE', '');

ini_set('date.timezone', '');
mb_internal_encoding('UTF-8');
