<?php declare(strict_types=1);

namespace src\controllers\words;

interface WordsInterface
{
    /**
     * Get an array of words from the database.
     *
     * @return array
     */
    public function getWords(): array;

    /**
     * Code execution after a successful post.
     *
     * @param  array  $ids
     * @return bool
     */
    public function complete(array $ids): bool;
}
