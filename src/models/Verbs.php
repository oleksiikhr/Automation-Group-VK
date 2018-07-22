<?php declare(strict_types=1);

namespace src\models;

use core\database\Model;

class Verbs extends Model
{
    /**
     * @var string
     */
    protected $table = 'verbs';

    /**
     * @var string
     */
    protected $primaryKey = 'word_eng_id';

    /**
     * Get random records from the table.
     *
     * @param  int     $count
     * @param  int     $offset
     * @param  string  $orderColumn
     * @param  string  $orderBy
     * @return array
     */
    public function getList(int $count = 5, int $offset = 0, string $orderColumn = 'published_at',
                            string $orderBy = 'ASC'): array
    {
        return $this->getTable()
            ->select([
                $this->table . '.*',
                'words_eng.word_eng'
            ])
            ->leftJoin('words_eng', 'words_eng.word_eng_id', '=', $this->table . '.word_eng_id')
            ->where('words_eng.enabled', 1)
            ->orderBy($orderColumn, $orderBy)
            ->limit($count)
            ->offset($offset)
            ->get();
    }
}
