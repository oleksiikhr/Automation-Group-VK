<?php

namespace classes\vk\methods;

use classes\vk\VK;

class Verbs extends VK
{
    protected $table = 'verbs';

    /**
     * New post only Verbs.
     *
     * @param int $count
     * @param int $photoID
     *
     * @return object
     */
    public function createPostVerbs($count, $photoID)
    {
        $data = $this->getRandomCountData($count);
        $message = "";

        foreach ($data as $key => $item) {
            $i = $key + 1;
            $message .= $i . ". " . $item->first_form . " - " . $item->second_form . " - " . $item->third_form . "\n";

            if ($i % 5 == 0) {
                $message .= "\n";
            }
        }

        $message .= "#verbs@eng_day";
        $attachments = 'photo-' . GROUP_ID . '_' . $photoID;

        return $this->createPost($message, $attachments);
    }

    /**
     * Get random verb for new Post.
     *
     * @return string
     */
    public function getRandomVerb()
    {
        $data = $this->getRandomSingleData();

        return '&#128203; ' . $data->first_form . ' - ' . $data->second_form . ' - ' . $data->third_form;
    }
}
