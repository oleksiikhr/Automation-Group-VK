<?php declare(strict_types=1);

namespace src\controllers\polls\types;

use src\controllers\polls\PollsController;

class PollsTranslate extends PollsController
{
    /**
     * @var int
     */
    protected $type = 0;

    /**
     * @var int
     */
    protected $maxAnswers = 4;

    /**
     * @var string
     */
    protected $name = 'translate';

    /**
     * @var string
     */
    protected $defaultQuest;
}
