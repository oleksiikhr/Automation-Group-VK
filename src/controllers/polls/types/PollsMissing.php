<?php declare(strict_types=1);

namespace src\controllers\polls\types;

use src\controllers\polls\PollsController;

class PollsMissing extends PollsController
{
    /**
     * @var int
     */
    protected $type = 1;

    /**
     * @var int
     */
    protected $maxAnswers = 4;

    /**
     * @var string
     */
    protected $name = 'missing';

    /**
     * @var string
     */
    protected $defaultQuest;
}
