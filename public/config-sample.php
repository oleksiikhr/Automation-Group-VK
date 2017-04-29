<?php if ( empty($_GET['secret']) || $_GET['secret'] !== '__SECRET_KEY__' ) die;

define('DIR_ROOT', __DIR__ . '/..');
define('DIR_IMAGE', DIR_ROOT . '/img/');
define('CONFIRMATION', '');

define('METHOD_VK', 'https://api.vk.com/method/');
define('METHOD_YOUTUBE', 'https://www.googleapis.com/youtube/v3/');
define('GROUP_ID', '');
define('VERSION_VK', '5.63');

define('DB_HOST', '');
define('DB_USER', ''); // eng
define('DB_PASS', ''); // 11c9269822b40ca293aab
define('DB_NAME', 'english');

define('TOKEN_USER',      '');
define('TOKEN_GROUP_MSG', '');
define('TOKEN_GROUP_IMG', '');
define('TOKEN_GOOGLE',    '');

define('BOARD_ADD_POOL',   '');
define('BOARD_ADD_WORD',   '');
define('BOARD_ADD_VIDEO',  '');
define('BOARD_ADD_CHOOSE', '');

ini_set('date.timezone', '');
mb_internal_encoding('UTF-8');

require_once DIR_ROOT . '/vendor/autoload.php';
