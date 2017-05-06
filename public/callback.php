<?php

use gvk\vk\callback\Board;
use gvk\vk\callback\Group;

require_once __DIR__ . '/run.php';

$data = json_decode( file_get_contents('php://input') );

switch ($data->type) {
    case 'confirmation':
        die(CONFIRMATION);

    case 'board_post_new':
        Board::postNew($data->object);
        break;

//    case 'group_join':
//        Group::groupJoin($data->object);
//        break;
}

echo 'ok';
