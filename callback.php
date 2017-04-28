<?php // Receives requests from VK.

use classes\vk\callback\Wall;
use classes\vk\callback\Board;
use classes\vk\callback\Group;

require_once __DIR__ . '/config.php';

if ( ! isset($_REQUEST) ) return;

$data = json_decode( file_get_contents('php://input') );

if ($data->type === 'confirmation') die('17ff977d');
if ($data->secret !== SECRET) die;

switch ($data->type) {
    case 'board_post_new':
        ( new Board() )->boardPostNew($data->object);
        break;

//    case 'wall_reply_new':
//        ( new Wall() )->replyNew($data->object);
//        break;

//    case 'group_join':
//        ( new Group() )->groupJoin($data->object);
//        break;
}

echo 'ok';
