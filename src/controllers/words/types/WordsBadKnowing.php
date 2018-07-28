<?php declare(strict_types=1);

namespace src\controllers\words\types;

use src\controllers\words\WordsController;

class WordsBadKnowing extends WordsController
{
    /**
     * @var string
     */
    protected $name = 'bad_knowing';

    /**
     * @var string
     */
    protected $title = 'Повтор плохо изученных слов';

    /**
     * Get an array of words from the database.
     *
     * @return array
     */
    public function getWords(): array
    {
        return $this->model->getList($this->count, $this->offset, 'rating', 'DESC');
    }

    /**
     * Code execution after a successful post.
     *
     * @param  array  $ids
     * @return bool
     */
    public function complete(array $ids): bool
    {
        return $this->model->addRating($ids, -1);
    }
}
