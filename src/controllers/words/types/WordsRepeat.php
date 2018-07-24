<?php declare(strict_types=1);

namespace src\controllers\words\types;

use src\controllers\words\WordsController;

class WordsRepeat extends WordsController
{
    /**
     * @var string
     */
    protected $name = 'repeat';

    /**
     * @var string
     */
    protected $title = 'Повтор изученных недавно слов';

    /**
     * How many words to display.
     *
     * @var int|null
     */
    private $_cut = null;

    public function __construct(int $count = 5, int $offset = 0, ?int $cut = null)
    {
        parent::__construct($count, $offset);
        $this->_cut = $cut;
    }

    /**
     * Get an array of words from the database.
     *
     * @return array
     */
    public function getWords(): array
    {
        $words = $this->model->getList($this->count, $this->offset, 'published_at', 'DESC');

        if ($this->_cut) {
            shuffle($words);
            array_splice($words, $this->_cut);
        }

        return $words;
    }

    /**
     * Code execution after a successful post.
     *
     * @param  array  $ids
     * @return bool
     */
    public function complete(array $ids): bool
    {
        return true;
    }
}
