<?php

namespace gvk\vk\callback;

use gvk\vk\VK;
use gvk\vk\methods\Polls;
use gvk\vk\methods\Video;
use gvk\vk\methods\Translate;

class Board
{
    /**
     * New comment in the board.
     *
     * @param object $data
     *
     * @return void
     */
    public static function postNew($data)
    {
        if ($data->from_id != '-' . G_ID)
            return;

        if ( ! in_array($data->topic_id, [B_WORD, B_VIDEO, B_POLL, B_CHOOSE]) )
            return;

        $text = trim($data->text);
        $commentID = (int)mb_substr( $text, mb_strpos($text, '_') + 1 );

        // [id100000000:bp-100000000_100|Admin], - Example
        if ( preg_match('/^\[(id|club)[0-9]+:bp-[0-9]+_[0-9]+\|.+],$/ui', $text) ) {
            self::deleteComment($data->topic_id, $data->id);

            $text = self::getComments($data->topic_id, $commentID);
            $text = $text->response->items[0]->text;
            $data->id = $commentID;
        }

        $is_add = false;
        switch ($data->topic_id) {
            case B_VIDEO:   $is_add = Video::addDB($text); break;
            case B_POLL:    $is_add = Polls::addDB($text, Polls::TABLE_1); break;
            case B_WORD:    $is_add = Translate::addDB($text); break;
            case B_CHOOSE:  $is_add = Polls::addDB($text, Polls::TABLE_2); break;
        }

        if ($is_add)
            self::deleteComment($data->topic_id, $data->id);
    }

    /**
     * Returns a list of messages in the specified topic.
     *
     * @param int $topicID
     * @param int $startID
     * @param int $count
     *
     * @return object
     */
    public static function getComments($topicID, $startID, $count = 1)
    {
        return VK::send('board.getComments', [
            'group_id'         => G_ID,
            'topic_id'         => $topicID,
            'start_comment_id' => $startID,
            'count'            => $count
        ], T_USR);
    }

    /**
     * Deletes a topic message in community discussions.
     *
     * @param int $topicID
     * @param int $commentID
     *
     * @return object
     */
    public static function deleteComment($topicID, $commentID)
    {
        return VK::send('board.deleteComment', [
            'group_id'   => G_ID,
            'topic_id'   => $topicID,
            'comment_id' => $commentID
        ], T_USR);
    }
}
