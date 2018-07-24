<?php declare(strict_types=1);

namespace src\models;

use core\database\Model;

class WordsEng extends Model
{
    const WEIGHT_SMALL = 0;
    const WEIGHT_AVERAGE = 1;
    const WEIGHT_LARGE = 2;

    /**
     * @var string
     */
    protected $table = 'words_eng';

    /**
     * @var string
     */
    protected $primaryKey = 'word_eng_id';

    /**
     * Get a list of English words along with the translation.
     *
     * @param  int  $count
     * @param  int  $offset
     * @param  string|null  $orderColumn
     * @param  string  $orderBy
     * @param  bool  $appendRusWords
     * @return array
     */
    public function getList(int $count = 5, int $offset = 0, ?string $orderColumn = null,
                            string $orderBy = 'ASC', $appendRusWords = true): array
    {
        $query = $this->getTable()->select('*')->where('enabled', 1);

        if ($orderColumn) {
            $query->orderBy($orderColumn, $orderBy);
        }

        $words = $query->limit($count)->offset($offset)->get();

        if ($appendRusWords) {
            $this->appendRusWords($words);
        }

        return $words;
    }

    /**
     * Change the current word rating.
     *
     * @param  array|int  $ids
     * @param  int  $value
     * @return bool
     */
    public function addRating($ids, int $value): bool
    {
        $query = $this->getTable()->where('rating', '>', 0);

        if (is_array($ids)) {
            $query->whereIn($this->primaryKey, $ids);
        } else {
            $query->where($this->primaryKey, '=', $ids);
        }

        return (bool) $query->update(['rating' => \QB::raw("rating + {$value}")])
            ->rowCount();
    }

    /**
     * Change the current word favorite.
     *
     * @param  array|int  $ids
     * @param  int  $value
     * @return bool
     */
    public function addFavorite($ids, int $value): bool
    {
        $query = $this->getTable()->where('favorite', '>', 0);

        if (is_array($ids)) {
            $query->whereIn($this->primaryKey, $ids);
        } else {
            $query->where($this->primaryKey, '=', $ids);
        }

        return (bool) $query->update(['favorite' => \QB::raw("favorite + {$value}")])
            ->rowCount();
    }

    /**
     * Get data from the database and add to the current array.
     *
     * @param  array  $words
     * @return void
     */
    private function appendRusWords(array &$words): void
    {
        $ids = array_column($words, $this->primaryKey);

        $wordsRus = $this->getTable()
            ->select([
                $this->getTablePrimaryColumn(),
                'words_rus.*',
                'word_eng_rus.weight'
            ])
            ->join('word_eng_rus', 'word_eng_rus.word_eng_id', '=', $this->getTablePrimaryColumn())
            ->join('words_rus', 'words_rus.word_rus_id', '=', 'word_eng_rus.word_rus_id')
            ->whereIn('word_eng_rus.weight', [self::WEIGHT_AVERAGE, self::WEIGHT_LARGE])
            ->whereIn($this->getTablePrimaryColumn(), $ids)
            ->get();

        foreach ($wordsRus as $word) {
            $words[array_search($word->word_eng_id, $ids)]->{'translate'}[] = $word;
        }
    }
}
