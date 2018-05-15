<?php

//use gvk\vk\callback\Board;
//use gvk\vk\callback\Group;

require_once __DIR__ . '/../configs/defines.php';

$data = json_decode(file_get_contents('php://input'));

if ($data->secret !== SECRET_KEY) {
	die;
}

require_once D_ROOT . '/vendor/autoload.php';

$db = require D_ROOT . '/configs/db.php';
new Pixie\Connection($db['driver'], $db, 'QB');

switch ($data->type) {
    case 'confirmation':
        die(CONFIRMATION);

//    case 'board_post_new':
//        $res = Board::postNew($data->object);
//        break;

//    case 'group_join':
//        $res = Group::groupJoin($data->object);
//        break;
}

echo 'ok';
