<?php declare(strict_types=1);

namespace src\controllers\verbs;

use src\controllers\PostController;
use core\vk\methods\Wall;
use core\vk\Attachment;
use src\models\Verbs;
use core\Token;

class VerbsController extends PostController
{
    /**
     * @var string
     */
    protected $smile = '&#128203;';

    /**
     * @var string
     */
    protected $hashtags = ['verbs'];

    /**
     * @var string
     */
    private $_title = 'Список неправильных глаголов';

    public function __construct(int $count = 5, int $offset = 0)
    {
        parent::__construct(new Verbs, $count, $offset);
    }

    /**
     * Main method.
     *
     * @param  int|null  $photoId from photo album in VK
     * @return void
     */
    public function start(?int $photoId = null): void
    {
        $verbs = $this->model->getList($this->count, $this->offset);

        $message = $this->smile . " {$this->_title}\n\n" . self::getTextWords($verbs) . "\n\n" . $this->getHashtag();

        $attachments = Attachment::generate([Attachment::PHOTO => $photoId]);

        try {
            Wall::post(Token::getToken(), $message, $attachments);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $this->model->setPublishedAtNow(array_column($verbs, $this->model->getPrimaryKey()));
    }

    /**
     * Get the text words.
     *
     * @param array $words
     *
     * @return string
     */
    private static function getTextWords(array $words)
    {
        $message = "";

        /*
         * Structure:
         *     - Eng_word, second_form, third_form [#id]
         */
        foreach ($words as $word) {
            $message .= "- " . ucfirst($word->word_eng) . ", {$word->second_form}, {$word->third_form} [#{$word->word_eng_id}]\n\n";
        }

        return trim($message);
    }
}
