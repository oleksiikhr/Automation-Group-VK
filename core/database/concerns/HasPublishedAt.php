<?php declare(strict_types=1);

namespace core\database\concerns;

trait HasPublishedAt
{
    public $publishedAt = true;

    /**
     * Set published_at to now.
     *
     * @param  array|int  $ids
     * @return bool
     */
    public function setPublishedAtNow($ids): bool
    {
        return (bool) $this->insert($ids, date('Y-m-d H:i:s'));
    }

    /**
     * Set published_at to $value.
     *
     * @param  array|int  $ids
     * @param  string     $value
     * @return bool
     */
    public function setPublishedAt($ids, string $value): bool
    {
        return (bool) $this->insert($ids, $value);
    }

    /**
     * Insert published_at to DB.
     *
     * @param  array|int  $ids
     * @param  string     $date
     * @return int
     */
    private function insert($ids, string $date): int
    {
        $query = $this->getTable();

        if (is_array($ids)) {
            $query->whereIn($this->getPrimaryKey(), $ids);
        } else {
            $query->where($this->getPrimaryKey(), '=', $ids);
        }

        return $query->update([static::PUBLISHED_AT => $date])
            ->rowCount();
    }
}
