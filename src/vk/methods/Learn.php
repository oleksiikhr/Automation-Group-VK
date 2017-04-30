<?php

namespace gvk\vk\methods;

use gvk\vk\VK;

class Learn extends VK
{
    protected $table = 'learn';

    /**
     * Create new post learn.
     *
     * @param int $photo_id
     *
     * @return object
     */
    public function createPostLearn($photo_id)
    {
        $data = $this->getRandomSingleData();

        $title = $data->title;
        $text = $this->formatText($data->text);

        return $this->createPost(
            "&#128221; " . $title . "\n\n" . $text . "\n\n#learn@eng_day",
            'photo-' . G_ID . '_' . $photo_id,
            'POST'
        );
    }

    /**
     * Formatting text.
     *
     * @param string $text
     *
     * @return string
     */
    public function formatText($text)
    {
        $text = str_replace('%subtitle%', '&#9642;&#9642;&#9642;&#9642;&#9642;', $text);
        $text = str_replace('%li%', '&#128204;', $text);

        return $text;
    }
}
