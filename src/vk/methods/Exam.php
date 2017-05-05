<?php

namespace gvk\vk\methods;

use gvk\vk\VK;

class Exam extends VK
{
    protected $table = null;

    /**
     * Create new post exam.
     *
     * @param int $photo_id
     *
     * @return bool
     */
    public function createPostExam($photo_id = null)
    {
        $this->table = 'polyglot';
        $data = $this->getRandomSingleData();
        $attachment = null;

        if ( ! empty($photo_id) ) {
            $attachment = 'photo-' . G_ID . '_' . $photo_id;
        }

        $message = 'Тестовая функция! #exam@eng_day' . "\n"
            . 'Нужно написать ответ на вопрос в комментариях под этой записью.' . "\n\n"
            . "&#_128293; Переведите: " . $data->quest . "\n\n"
            . '1. Нужно быть участником группы.' . "\n"
            . '2. Не блокировать получение сообщений от группы.' . "\n\n"
            . 'В данный момент имеет разница между didn\'t и did not и других сокращений.';

        $newPost = $this->wallPost($message,$attachment);

        $this->table = 'exam';
        return $this->insert([
            'id_post' => $newPost->response->post_id,
            'id_poll' => $data->id
        ]);
    }
}
