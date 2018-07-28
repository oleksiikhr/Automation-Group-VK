<?php declare(strict_types=1);

namespace src\models;

use core\database\Model;

class WordsRus extends Model
{
    /**
     * @var string
     */
    protected $table = 'words_rus';

    /**
     * @var string
     */
    protected $primaryKey = 'word_rus_id';
}
