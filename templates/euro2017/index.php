<?php // Cron every 5 minutes.

require_once __DIR__ . '/../../public/run.php';

use tmp\euro2017\Euro;
use gvk\vk\methods\Exam;
use gvk\vk\methods\Learn;
use gvk\vk\methods\Polls;
use gvk\vk\methods\Verbs;
use gvk\vk\methods\Video;
use gvk\vk\methods\Photos;
use gvk\vk\methods\Translate;

$m = date('i');
$d = date('d');

Euro::parsePoll(1); die;

$round = 0;
switch ($d) {
    case 9: case 10:  $round = 1; break;
    case 11: case 12: $round = 2; break;
}

Euro::changeHeader($round);
//Euro::createPost();


// Basic: 26/50
//if ($m % 30 != 0)
//    return;
//
//if ( $m == 30 )
//{
//    if     ( in_array($h, ['12']) )
//        Learn::createPost(456241870);
//
//    elseif ( in_array($h, ['8', '20']) )
//        Video::createPost();
//
//    elseif ( in_array($h, ['9', '16', '21']) )
//        Verbs::createPost(20, 456242834);
//
//    elseif ( in_array($h, ['4', '10', '14']) )
//        Photos::createPost();
//
//    elseif ( in_array($h, ['0']) )
//        Exam::createPost(456242833);
//
//    elseif ( in_array($h, ['14']) )
//        Polls::createPost(Polls::TABLE_3, 0);
//}
//else
//{
//    if     ( in_array($h, ['0', '3', '6', '9', '12']) )
//        Polls::createPost(Polls::TABLE_1, 456240697);
//
//    elseif ( in_array($h, ['1', '4', '7', '10', '13']) )
//        Polls::createPost(Polls::TABLE_2, 456240698);
//
//    elseif ( in_array($h, ['2', '5', '8', '11', '14']) )
//        Translate::createPost(20, 456240584);
//}
//
//Video::downloadInVK(5);
