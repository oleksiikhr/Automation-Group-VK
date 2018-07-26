<?php declare(strict_types=1);

namespace src\controllers\polls;

use src\models\Polls as PollModel;
use core\vk\methods\Polls;
use core\vk\methods\Wall;
use core\vk\Attachment;
use core\Controller;
use core\Token;

abstract class PollsController extends Controller
{
    /**
     * @var string
     */
    protected $smile = '&#128218;';

    /**
     * @var string
     */
    protected $hashtags = ['polls'];

    /**
     * @var string
     */
    protected $defaultQuest;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var int
     */
    protected $maxAnswers = 4;

    /**
     * @var PollModel
     */
    private $_model;

    public function __construct()
    {
        $this->_model = new PollModel;
        $this->addHashtag("polls_type{$this->type}");
    }

    /**
     * Main method.
     *
     * @param  int|null  $photoId from photo album in VK
     * @return void
     */
    public function start(?int $photoId = null): void
    {
        $poll = $this->_model->first($this->type);

        // No question - use the default value
        if (! $poll->quest) {
            $poll->quest = $this->defaultQuest;
        }

        $answers = array_column($poll->answers, 'answer');
        $this->getAnswers($answers, $poll->correctAnswer);

        try {
            $pollVk = Polls::create(Token::getToken(), $poll->quest, $answers);

            $attachments = Attachment::generate([
                Attachment::PHOTO => $photoId,
                Attachment::POLL => $pollVk->response->id
            ]);

            $wall = Wall::post(Token::getToken(), $this->getHashtag(), $attachments);

            $this->_model->setPublishedAtNow($poll->poll_id);

            $this->addComment($wall->response->post_id, $poll->correctAnswer);

        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Mix the answers and get the right amount.
     *
     * @param  array  $answers
     * @param  string  $correctAnswer
     * @return void
     */
    private function getAnswers(array &$answers, string $correctAnswer): void
    {
        shuffle($answers);

        if ($this->maxAnswers < count($answers)) {
            $answers = array_slice($answers, $this->maxAnswers);
        }

        $answers[] = $correctAnswer;

        shuffle($answers);
    }

    /**
     * Add the correct answer under the post.
     *
     * @param  int  $postId
     * @param  string  $correctAnswer
     * @throws \Exception
     */
    private function addComment($postId, $correctAnswer): void
    {
        $comment = "&#9989; Правильный ответ:\n"
            . str_repeat("&#128315; &#128315; &#128315;\n", 8)
            . $this->smile . " " . $correctAnswer;

        Wall::createComment(Token::getToken(), $postId, $comment);
    }
}
