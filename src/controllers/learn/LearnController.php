<?php declare(strict_types=1);

namespace src\controllers\learn;

use src\controllers\PostController;
use core\vk\methods\Wall;
use core\vk\Attachment;
use src\models\Learn;
use core\Token;

class LearnController extends PostController
{
    /**
     * @var string
     */
    protected $smile = '&#128204;';

    /**
     * @var string
     */
    protected $hashtags = ['learn'];

    public function __construct(int $offset = 0)
    {
        parent::__construct(new Learn, 1, $offset);
    }

    /**
     * Main method.
     *
     * @param  int|null  $photoId from photo album in VK
     * @return void
     */
    public function start(?int $photoId = null): void
    {
        $post = $this->model->first($this->offset);

        $content = $this->parse($post->content);

        $message = "{$this->smile} {$post->title}\n\n$content\n\n{$this->getHashtag()}";

        $attachments = Attachment::generate([Attachment::PHOTO => $photoId]);

        try {
            Wall::post(Token::getToken(), $message, $attachments);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $this->model->setPublishedAtNow($post->learn_id);
    }

    /**
     * Change the text according to the rules.
     *
     * @param  string  $content
     * @return string
     */
    private function parse(string $content): string
    {
        $rules = $this->rules();

        foreach ($rules as $key => $value) {
            $content = str_replace($key, $value, $content);
        }

        return $content;
    }

    /**
     * Text to be replaced.
     *
     * @return array
     */
    private function rules(): array
    {
        return [
            '%sub-title%' => '&#128495;',
            '%point%' => '&#9642;',
        ];
    }
}
