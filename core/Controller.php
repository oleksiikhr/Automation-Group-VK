<?php declare(strict_types=1);

namespace core;

abstract class Controller
{
    /**
     * @var array
     */
    protected $hashtags;

    /**
     * @var string
     */
    protected $smile;

    /**
     * Get a hashtag for separating posts and improving search.
     *
     * @return string
     */
    protected function getHashtag(): string
    {
        $hashtags = '';

        foreach ($this->hashtags as $hashtag) {
            $hashtags .= '#' . $hashtag . '@' . G_DOMAIN . ' ';
        }

        return $hashtags;
    }

    /**
     * Add a one or multiply hashtags.
     *
     * @param  int|array  $values
     * @return void
     */
    protected function addHashtag($values): void
    {
        if (is_array($values)) {
            foreach ($values as $value) {
                $this->hashtags[] = $value;
            }
        } else {
            $this->hashtags[] = $values;
        }
    }
}
