<?php

namespace gvk\vk\callback;

use gvk\vk\VK;
use gvk\vk\methods\Polls;
use gvk\vk\methods\Videos;
use gvk\vk\methods\Translate;

class Board extends VK
{
    /**
     * New comment in the board.
     *
     * @param object $data
     *
     * @return void
     */
    public function boardPostNew($data)
    {
        if ($data->from_id != '-' . GROUP_ID) {
            return; // Если сообщение не от администратора
        }

        $topic_id = $data->topic_id;

        if ($topic_id != BOARD_ADD_WORD && $topic_id != BOARD_ADD_VIDEO
            && $topic_id != BOARD_ADD_POOL && $topic_id != BOARD_ADD_CHOOSE) {
            return; // Если топик не от нужных тем
        }

        $text = trim($data->text);
        $commentIDMessage = (int)substr( $text, strpos($text, '_') + 1 );

        // [id207909600:bp-132378855_418|Алексей],
        if ( ! preg_match('/^\[(id|club)[0-9]+:bp-[0-9]+_[0-9]+\|.+],$/ui', $text) ) {
            $this->addContent($text, $topic_id, $data->id);
            return;
        }

        $this->send('board.deleteComment', [
            'group_id'   => GROUP_ID,
            'topic_id'   => $topic_id,
            'comment_id' => $data->id
        ], TOKEN_USER);

        $comment = $this->send('board.getComments', [
            'group_id'         => GROUP_ID,
            'topic_id'         => $topic_id,
            'start_comment_id' => $commentIDMessage,
            'count'            => 1
        ], TOKEN_USER);

        $is_add = false;
        if ($topic_id == BOARD_ADD_VIDEO) {
            $video = new Videos();
            $is_add = $video->addBD($comment->response->items[0]->text);
        }

        if ($topic_id == BOARD_ADD_POOL) {
            $polyglot = new Polls('type1');
            $is_add = $polyglot->addBD($comment->response->items[0]->text);
        }

        if ($topic_id == BOARD_ADD_WORD) {
            $words = new Translate();
            $is_add = $words->addBD($comment->response->items[0]->text);
        }

        if ($topic_id == BOARD_ADD_CHOOSE) {
            $choose = new Polls('type2');
            $is_add = $choose->addBD($comment->response->items[0]->text);
        }

        if ($is_add) {
            $this->send('board.deleteComment', [
                'group_id'   => GROUP_ID,
                'topic_id'   => $topic_id,
                'comment_id' => $commentIDMessage
            ], TOKEN_USER);
        }
    }

    /**
     * New comment in the board for admin text.
     *
     * @param string $text
     * @param int $topic_id
     * @param int $id
     *
     * @return void
     */
    public function addContent($text, $topic_id, $id)
    {
        $is_add = false;
        if ($topic_id == BOARD_ADD_VIDEO) {
            $video = new Videos();
            $is_add = $video->addBD($text);
        }

        if ($topic_id == BOARD_ADD_POOL) {
            $polyglot = new Polls('type1');
            $is_add = $polyglot->addBD($text);
        }

        if ($topic_id == BOARD_ADD_WORD) {
            $words = new Translate();
            $is_add = $words->addBD($text);
        }

        if ($topic_id == BOARD_ADD_CHOOSE) {
            $choose = new Polls('type2');
            $is_add = $choose->addBD($text);
        }

        if ($is_add) {
            $this->send('board.deleteComment', [
                'group_id' => GROUP_ID,
                'topic_id' => $topic_id,
                'comment_id' => $id
            ], TOKEN_USER);
        }
    }
}
