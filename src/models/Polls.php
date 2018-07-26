<?php declare(strict_types=1);

namespace src\models;

use core\database\Model;

class Polls extends Model
{
    /**
     * @var string
     */
    protected $table = 'polls';

    /**
     * @var string
     */
    protected $primaryKey = 'poll_id';

    /**
     * Get random records from the table.
     *
     * @param  int|null  $type
     * @param  int  $offset
     * @param  string  $orderColumn
     * @param  string  $orderBy
     * @return object
     */
    public function first(?int $type = null, int $offset = 0, string $orderColumn = 'published_at', string $orderBy = 'ASC'): object
    {
        $query = $this->getTable()->select('*');

        if (! is_null($type)) {
            $query->where('type', '=', $type);
        }

        $poll = $query->orderBy($orderColumn, $orderBy)
            ->offset($offset)
            ->first();

        $this->appendAnswers($poll);

        return $poll;
    }

    /**
     * Get data from the answers database and add to the current object.
     *
     * @param  object  $poll
     * @return void
     */
    public function appendAnswers(object &$poll): void
    {
        $answers = $this->getTable()
            ->select('poll_answers.*')
            ->leftJoin('poll_answers', 'poll_answers.poll_id', '=', $this->getTablePrimaryColumn())
            ->get();

        $poll->answers = $answers;
    }
}
