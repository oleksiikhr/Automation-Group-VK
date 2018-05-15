<?php

//use gvk\vk\callback\Board;
//use gvk\vk\callback\Group;

require_once __DIR__ . '../server.php';

$data = json_decode(file_get_contents('php://input'));

if ($data->secret !== getenv('VK_SECRET')) {
	die;
}

switch ($data->type) {
    case 'confirmation':
        die(getenv('VK_CONFIRMATION'));

//    case 'board_post_new':
//        $res = Board::postNew($data->object);
//        break;

//    case 'group_join':
//        $res = Group::groupJoin($data->object);
//        break;
}

echo 'ok';
