<?php declare(strict_types=1);

namespace src\models;

use core\database\Model;

class Learn extends Model
{
    /**
     * @var string
     */
    protected $table = 'learn';

    /**
     * @var string
     */
    protected $primaryKey = 'learn_id';

    /**
     * Get random records from the table.
     *
     * @param  int  $offset
     * @param  string  $orderColumn
     * @param  string  $orderBy
     * @return object
     */
    public function first(int $offset = 0, string $orderColumn = 'published_at', string $orderBy = 'ASC'): object
    {
        return $this->getTable()
            ->select('*')
            ->orderBy($orderColumn, $orderBy)
            ->offset($offset)
            ->first();
    }
}
