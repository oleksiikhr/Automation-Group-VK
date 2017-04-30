<?php

require_once __DIR__ . '/run.php';

$data = json_decode( file_get_contents('php://input') );

switch ($data->type) {
    case 'confirmation':
        die(CONFIRMATION);

    case 'board_post_new':
        ( new gvk\vk\callback\Board() )->boardPostNew($data->object);
        echo 'ok';
        break;

//    case 'wall_reply_new':
//        ( new gvk\vk\callback\Wall() )->replyNew($data->object);
//        echo 'ok';
//        break;

//    case 'group_join':
//        ( new gvk\vk\callback\Group() )->groupJoin($data->object);
//        echo 'ok';
//        break;
}
