<?php declare(strict_types=1);

namespace src\controllers\words\types;

use src\controllers\words\WordsController;

class WordsBadKnowing extends WordsController
{
    public function __construct(int $count = 5, int $offset = 0)
    {
        parent::__construct($count, $offset);
        $this->addHashtag('words_bad_knowing');
    }

    public function getTitle(): string
    {
        return 'Повтор плохо изученных слов';
    }

    public function getWords(): array
    {
        return $this->model->getList($this->count, $this->offset, 'rating', 'DESC');
    }

    public function complete(array $ids): bool
    {
        return $this->model->addRating($ids, -1);
    }
}
