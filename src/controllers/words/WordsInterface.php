<?php declare(strict_types=1);

namespace src\controllers\words;

interface WordsInterface
{
    /**
     * Receive the name of the post.
     *
     * @return string
     */
    public function getTitle(): string;

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
