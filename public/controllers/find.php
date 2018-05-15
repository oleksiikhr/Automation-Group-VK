<?php require_once __DIR__ . '/../run.php';

use gvk\vk\methods\Polls;

if (empty($_GET['method'])) {
    return false;
}

switch ($_GET['method']) {
    case 'poll_type1':
        if (! preg_match('/[.?!]$/ui', $_GET['val']))
            $_GET['val'] .= '.';

        echo (bool) QB::table(Polls::TABLE_1)
            ->select('*')
            ->where($_GET['key'], '=', $_GET['val'])
            ->first();
        die;

    case 'poll_type2':
        if (! preg_match('/[.?!]$/ui', $_GET['val']))
            $_GET['val'] .= '.';

        echo (bool) QB::table(Polls::TABLE_2)
            ->select('*')
            ->where($_GET['key'], '=', str_replace('@', '___', $_GET['val']))
            ->first();
        die;

    case 'poll_type3':
        if (! preg_match('/[.?!]$/ui', $_GET['val']))
            $_GET['val'] .= '.';

        echo (bool) QB::table(Polls::TABLE_3)
            ->select('*')
            ->where($_GET['key'], '=', $_GET['val'])
            ->first();
        die;

}
