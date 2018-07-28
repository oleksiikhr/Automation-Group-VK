<?php declare(strict_types=1);

namespace src\controllers;

use core\database\Model;
use core\Controller;

abstract class PostController extends Controller
{
    /**
     * @var int
     */
    protected $count = 5;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var mixed
     */
    protected $model;

    public function __construct(Model $model, int $count = 5, int $offset = 0)
    {
        $this->model = $model;
        $this->count = $count;
        $this->offset = $offset;
    }
}
