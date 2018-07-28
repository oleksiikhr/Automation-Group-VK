<?php declare(strict_types=1);

namespace src\controllers\words;

use src\controllers\PostController;
use core\vk\methods\Wall;
use src\models\WordsEng;
use core\vk\Attachment;
use core\Token;

abstract class WordsController extends PostController implements WordsInterface
{
    /**
     * @var string
     */
    protected $smile = '&#127468;&#127463;';

    /**
     * @var string
     */
    protected $hashtags = ['words'];

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    public function __construct(int $count = 5, int $offset = 0)
    {
        parent::__construct(new WordsEng, $count, $offset);
        $this->addHashtag("words_{$this->name}");
    }

    /**
     * Main method.
     *
     * @param  int|null  $photoId from photo album in VK
     * @return void
     */
    public function start(?int $photoId = null): void
    {
        $words = $this->getWords();

        $message = "{$this->smile} {$this->title}\n\n" . self::getTextWords($words) . "\n\n{$this->getHashtag()}";

        $attachments = Attachment::generate([Attachment::PHOTO => $photoId]);

        try {
            Wall::post(Token::getToken(), $message, $attachments);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $this->complete(array_column($words, 'word_eng_id'));
    }

    /**
     * Get the text words.
     *
     * @param  array  $words
     * @return string
     */
    private static function getTextWords(array $words): string
    {
        $message = "";

        /*
         * Structure:
         *     - Eng_word [transcription_eng] [transcription_rus] [#id]
         *     rus_word1, rus_word2, ..
         */
        foreach ($words as $word) {
            $message .= "- " . ucfirst($word->word_eng);

            if ($word->transcription_eng) {
                $message .= " [{$word->transcription_eng}]";
            }

            if ($word->transcription_rus) {
                $message .= " [{$word->transcription_rus}]";
            }

            $message .= " [#{$word->word_eng_id}]";

            // Rus words
            if (isset($word->translate)) {
                $message .= "\n" . implode(', ', array_column($word->translate, 'word_rus'));
            }

            $message .= "\n\n";
        }

        return trim($message);
    }
}
