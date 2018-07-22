<?php declare(strict_types=1);

namespace src\controllers\photos;

interface PhotosInterface
{
    /**
     * Choose file to upload on servers VK.
     *
     * @param  array  $files
     * @return array
     */
    public function chooseFiles(array $files): array;
}
