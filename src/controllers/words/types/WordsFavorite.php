<?php declare(strict_types=1);

namespace src\controllers\words\types;

use src\controllers\words\WordsController;

class WordsFavorite extends WordsController
{
    /**
     * @var string
     */
    protected $name = 'favorite';

    /**
     * @var string
     */
    protected $title = 'Изучение слов выбранных сообществом';

    /**
     * Get an array of words from the database.
     *
     * @return array
     */
    public function getWords(): array
    {
        return $this->model->getList($this->count, $this->offset, 'favorite', 'DESC');
    }

    /**
     * Code execution after a successful post.
     *
     * @param  array  $ids
     * @return bool
     */
    public function complete(array $ids): bool
    {
        return $this->model->addFavorite($ids, -1);
    }
}
