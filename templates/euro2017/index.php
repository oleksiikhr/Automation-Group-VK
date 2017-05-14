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
$h = date('G');

$round = 0;
switch ($d) {
    case 9: case 10:  $round = 1; break;
    case 11: case 12: $round = 2; break;
}

if ($d > 14)
	return;

Euro::parsePoll($round);
Euro::changeHeader($round);

// Basic: 25/50
if ($m % 30 != 0)
    return;

if ( $m == 30 )
{
    if     ( in_array($h, ['11']) )
        Video::createPost();

    // elseif ( in_array($h, ['12']) )
    //     Learn::createPost(456241870);

    // elseif ( in_array($h, ['4', '13', '19']) )
    //     Verbs::createPost(20, 456242834);

    elseif ( in_array($h, ['5', '14']) )
        Photos::createPost();

    // elseif ( in_array($h, ['14']) )
    //     Exam::createPost(456242833);
}
else
{
    if     ( in_array($h, ['4', '13']) )
        Polls::createPost(Polls::TABLE_1, 456240697);

    elseif ( in_array($h, ['8', '19']) )
        Polls::createPost(Polls::TABLE_2, 456240698);

    elseif ( in_array($h, ['2', '9', '16']) )
        Translate::createPost(20, 456240584);
}

Video::downloadInVK(5);
