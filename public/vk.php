<?php // Cron every 30 minutes.

use gvk\vk\methods\Exam;
use gvk\vk\methods\Learn;
use gvk\vk\methods\Polls;
use gvk\vk\methods\Verbs;
use gvk\vk\methods\Video;
use gvk\vk\methods\Images;
use gvk\vk\methods\Translate;

require_once __DIR__ . '/run.php';

$h = date('G');
$m = date('i');

/*
 * Learn       | 12                           : |30|  => 1
 * Poll_type3  | 14                           : |30|  => 1
 * Exam        | 3, 16                        : |30|  => 2
 * Fun         | 5, 15                        : |30|  => 2
 * Videos      | 8, 20                        : |30|  => 2
 * Verb        | 0, 9, 21                     : |30|  => 3
 * Images      | 4, 7, 10, 17, 22             : |30|  => 5
 * Card        | 2, 6, 11, 13, 18, 23         : |30|  => 6
 * Poll_type1  | 0, 3, 6, 9, 12, 15, 18, 21   : |00|  => 8
 * Poll_type2  | 1, 4, 7, 10, 13, 16, 19, 22  : |00|  => 8
 * Words       | 2, 5, 8, 11, 14, 17, 20, 23  : |00|  => 8
 *
 * Count: 46/50
 */

if ( $m == 30 )
{
    if     ( in_array($h, ['3', '16']) )
        Exam::createPost(456242833);

    elseif ( in_array($h, ['12']) )
        Learn::createPost(456241870);

    elseif ( in_array($h, ['8', '20']) )
        Video::createPost();

    elseif ( in_array($h, ['0', '9', '21']) )
        Verbs::createPost(20, 456242834);

    elseif ( in_array($h, ['4', '7', '10', '17', '22']) )
        Images::createPost(Images::F_IMG);

    elseif ( in_array($h, ['5', '15']) )
        Images::createPost(Images::F_FUNNY);

    elseif ( in_array($h, ['2', '6', '11', '13', '18', '23']) )
        Images::createPost(Images::F_CARD);

    elseif ( in_array($h, ['14']) )
        Polls::createPost(Polls::TABLE_3, 456245830);
}
else
{
    if     ($h % 3 == 0)
        Polls::createPost(Polls::TABLE_1, 456240697);

    elseif ($h % 3 == 1)
        Polls::createPost(Polls::TABLE_2, 456240698);

    elseif ($h % 3 == 2)
        Translate::createPost(20, 456240584);
}

Video::downloadInVK(1);
