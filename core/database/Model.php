<?php declare(strict_types=1);

namespace core\database;

abstract class Model
{
    use concerns\HasPublishedAt;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name of the "published at" column.
     *
     * @var string
     */
    const PUBLISHED_AT = 'published_at';

    /**
     * Get current table name.
     *
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table;
    }

    /**
     * Get current primary key.
     *
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * Get count of records.
     *
     * @return int
     */
    public function getCountRecords(): int
    {
        return $this->getTable()->count();
    }

    /**
     * Get string for query builder.
     *
     * @return string
     */
    public function getTablePrimaryColumn(): string
    {
        return $this->table . '.' . $this->primaryKey;
    }

    /**
     * @return mixed
     */
    protected function getTable(): object
    {
        return \QB::table($this->getTableName());
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}
