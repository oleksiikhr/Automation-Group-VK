<?php die; // TODO: File die

use gvk\vk\callback\Board;
use gvk\vk\callback\Group;

require_once __DIR__ . '/run.php';

$data = json_decode( file_get_contents('php://input') );
$res = false;

switch ($data->type) {
    case 'confirmation':
        die(CONFIRMATION);

    case 'board_post_new':
        $res = Board::postNew($data->object);
        break;

//    case 'group_join':
//        $res = Group::groupJoin($data->object);
//        break;
}

if ($res) {
    echo 'ok';
}
