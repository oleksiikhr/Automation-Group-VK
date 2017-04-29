<?php

namespace gvk\vk\callback;

use gvk\vk\VK;

class Wall extends VK
{
    /**
     * Poll new comment for post.
     *
     * @param $object
     *
     * @return bool|object
     */
    public function replyNew($object)
    {
        $sql = 'SELECT polyglot.correct_answer
                FROM exam, polyglot
                WHERE exam.id_post = ? AND exam.id_poll = polyglot.id';

        $data = $this->pdo->prepare($sql);
        $data->execute([$object->post_id]);
        $data = $data->fetch(\PDO::FETCH_OBJ);

        if ($data) {
            $textUser = mb_strtolower( preg_replace('/[^a-z]+/ui', '', $object->text) );
            $textCorrect = mb_strtolower( preg_replace('/[^a-z]+/ui', '', $data->correct_answer) );

            if ($textUser === $textCorrect) {
                $this->sendMessage('Ответ верный!', $object->from_id);
            } else {
                $this->sendMessage('Ответ неверный!', $object->from_id);
            }

            return $this->deleteComment($object->id);
        }

        return false;
    }

    public function replace()
    {
        //
    }
}
