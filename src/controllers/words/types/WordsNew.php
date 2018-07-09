<?php declare(strict_types=1);

namespace src\controllers\words\types;

use src\controllers\words\WordsController;

class WordsNew extends WordsController
{
    public function __construct(int $count = 5, int $offset = 0)
    {
        parent::__construct($count, $offset);
        $this->addHashtag('words_new');
    }

    public function getTitle(): string
    {
        return 'Изучение новых слов';
    }

    public function getWords(): array
    {
        return $this->model->getList($this->count, $this->offset);
    }

    public function complete(array $ids): bool
    {
        return $this->model->setPublishedAtNow($ids);
    }
}
