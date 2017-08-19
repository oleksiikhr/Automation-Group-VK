<?php require_once __DIR__ . '/../run.php';

use gvk\vk\methods\Polls;
use gvk\vk\methods\Video;

if (empty($_GET['method'])) {
    return false;
}

switch ($_GET['method']) {
    case 'poll_type1':
        echo pollType($_GET['quest'], $_GET['correct_answer'], $_GET['answers'], Polls::TABLE_1);
        return;

    case 'poll_type2':
        echo pollType($_GET['quest'], $_GET['correct_answer'], $_GET['answers'], Polls::TABLE_2);
        return;

    case 'poll_type3':
        echo pollType3($_GET['correct_answer'], $_GET['answers']);
        return;

    case 'youtube':
        echo Video::addDB($_GET['playlist'] . "\n" . $_GET['title']);
        return;

    default: die;
}

function pollType($quest, $correct_answer, $answers, $table)
{
    $answers = str_replace('\n', "\n", $answers);

    return Polls::addDB("{$quest}\n{$correct_answer}\n{$answers}", $table);
}

function pollType3($correct_answer, $answers)
{
    $answers = str_replace('\n', "\n", $answers);

    return Polls::addDB("{$correct_answer}\n{$answers}", Polls::TABLE_3);
}
