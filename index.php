<?php // Cron every 30 minutes.

use classes\vk\methods\Exam;
use classes\vk\methods\Learn;
use classes\vk\methods\Polls;
use classes\vk\methods\Verbs;
use classes\vk\methods\Videos;
use classes\vk\methods\Images;
use classes\vk\methods\Translate;

require_once __DIR__ . '/config.php';

/*
 * Learn       | 12                           : |30|  => 1
 * Videos      | 8, 20                        : |30|  => 2
 * Verb        | 9, 16, 21                    : |30|  => 3
 * Image       | 4, 10, 13, 17, 22            : |30|  => 5
 * Poll_type1  | 0, 3, 6, 9, 12, 15, 18, 21   : |00|  => 8
 * Poll_type2  | 1, 4, 7, 10, 13, 16, 19, 22  : |00|  => 8
 * Words       | 2, 5, 8, 11, 14, 17, 20, 23  : |00|  => 8
 *
 * Count: 35
 */

if ($_GET['secret'] !== SECRET) die;

$hour = date('G');
$minute = date('i');

$videos = new Videos();

if ( ($hour == 12) && $minute == 30 ) {

    ( new Learn() )->createPostLearn(456241870);

} elseif ( ($hour == 8 || $hour == 20) && $minute == 30 ) {

    $videos->createPostVideos();

} elseif ( ($hour == 9 || $hour == 16 || $hour == 21) && $minute == 30) {

    ( new Verbs() )->createPostVerbs(20, 456242834);

} elseif ( ($hour == 4 || $hour == 10 || $hour == 13 || $hour == 17 || $hour == 22) && $minute == 30 ) {

    ( new Images() )->createPostImages();

} elseif ( ($hour % 3 == 0) && $minute == 0 ) {

    ( new Polls('type1') )->createPostPolls(456240697);

} elseif ( ($hour % 3 == 1) && $minute == 0 ) {

    ( new Polls('type2') )->createPostPolls(456240698);

} elseif ( ($hour % 3 == 2) && $minute == 0 ) {

    ( new Translate() )->newPostOnlyWords(20, 456240584);

}

$videos->downloadInVK(5);
