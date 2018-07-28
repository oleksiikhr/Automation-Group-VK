<?php declare(strict_types=1);

namespace src\controllers\polls\types;

use src\controllers\polls\PollsController;

class PollsFind extends PollsController
{
    /**
     * @var int
     */
    protected $type = 2;

    /**
     * @var int
     */
    protected $maxAnswers = 4;

    /**
     * @var string
     */
    protected $name = 'find';

    /**
     * @var string
     */
    protected $defaultQuest = 'Выберите правильный вариант.';
}
