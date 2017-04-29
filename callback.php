<?php if ( ! isset($_REQUEST) ) die;

require_once __DIR__ . '/config.php';

if ($data->type === 'confirmation') die('17ff977d');

$data = json_decode( file_get_contents('php://input') );

switch ($data->type) {
    case 'board_post_new':
        ( new gvk\vk\callback\Board() )->boardPostNew($data->object);
        break;

//    case 'wall_reply_new':
//        ( new gvk\vk\callback\Wall() )->replyNew($data->object);
//        break;

//    case 'group_join':
//        ( new gvk\vk\callback\Group() )->groupJoin($data->object);
//        break;
}

echo 'ok';
