<?php declare(strict_types=1);

namespace src\controllers\photos\types;

use src\controllers\photos\PhotosController;

class Card extends PhotosController
{
    protected $folder = 'card';

    public function __construct()
    {
        parent::__construct();
        $this->addHashtag("photos_{$this->folder}");
    }

    /**
     * Choose file to upload on servers VK.
     *
     * @param  array $files
     * @return array indexes
     */
    public function chooseFiles(array $files): array
    {
        return [array_rand($files, 1)];
    }
}
