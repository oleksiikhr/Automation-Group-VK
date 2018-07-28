<?php declare(strict_types=1);

namespace src\controllers;

use core\Controller;

abstract class FileController extends Controller
{
    /**
     * @var string
     */
    protected $pathEntry;

    /**
     * @var string
     */
    protected $pathExit;

    /**
     * @var bool
     */
    protected $isExists;

    public function __construct(string $folder)
    {
        $this->pathEntry = realpath(D_RESOURCES . '/' . $folder);
        $this->isExists = file_exists($this->pathEntry);
    }

    /**
     * Recursively search for files in subfolders.
     *
     * @param  string  $path
     * @return array
     */
    public function getFilesRecursive(string $path)
    {
        $files = array_slice(scandir($path), 2);

        if (count($files) < 1) {
            return [];
        }

        if (is_dir($path . '/' . $files[0])) {
            return $this->getFilesRecursive($path . '/' . $files[array_rand($files)]);
        }

        $this->pathExit = realpath($path);

        return $files;
    }
}
