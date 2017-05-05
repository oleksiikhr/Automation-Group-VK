<?php // Cron every 30 minutes.

use gvk\vk\methods\Learn;
use gvk\vk\methods\Polls;
use gvk\vk\methods\Verbs;
use gvk\vk\methods\Video;
use gvk\vk\methods\Photos;
use gvk\vk\methods\Translate;

require_once __DIR__ . '/run.php';

$h = date('G');

/*
 * Learn       | 12                           : |30|  => 1
 * Videos      | 8, 20                        : |30|  => 2
 * Verb        | 9, 16, 21                    : |30|  => 3
 * Image       | 4, 10, 13, 17, 22            : |30|  => 5
 * Poll_type1  | 0, 3, 6, 9, 12, 15, 18, 21   : |00|  => 8
 * Poll_type2  | 1, 4, 7, 10, 13, 16, 19, 22  : |00|  => 8
 * Words       | 2, 5, 8, 11, 14, 17, 20, 23  : |00|  => 8
 *
 * Count: 35/50
 */

if ( date('i') == 30 )
{
    if ( in_array($h, ['12']) )
        Learn::createPost(456241870);

    elseif ( in_array($h, ['8', '20']) )
        Video::createPost();

    elseif ( in_array($h, ['9', '16', '21']) )
        Verbs::createPost(20, 456242834);

    elseif ( in_array($h, ['4', '10', '13', '17', '22']) )
        Photos::createPost();

    elseif ( in_array($h, []) )
        return;
}
else
{
    if ($h % 3 == 0)
        ( new Polls('type1') )->createPostPolls(456240697);

    elseif ($h % 3 == 1)
        ( new Polls('type2') )->createPostPolls(456240698);

    elseif ($h % 3 == 2)
        ( new Translate() )->newPostOnlyWords(20, 456240584);
}

( new Video() )->downloadInVK(5);
