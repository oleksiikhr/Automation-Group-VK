<?php

use gvk\vk\callback\Board;
use gvk\vk\callback\Group;
use gvk\vk\callback\Message;

require_once __DIR__ . '/run.php';

$data = json_decode( file_get_contents('php://input') );
$res = false;

switch ($data->type) {
    case 'confirmation':
        die(CONFIRMATION);

//    case 'board_post_new':
//        $res = Board::postNew($data->object);
//        break;

    case 'message_new':
        $res = Message::messageNew($data->object);
        break;

//    case 'group_join':
//        $res = Group::groupJoin($data->object);
//        break;
}

if ($res) {
    echo 'ok';
}
