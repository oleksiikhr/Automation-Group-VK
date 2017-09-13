<?php require_once __DIR__ . '/../../public/run.php';

use \tmp\game\Game;
use \tmp\game\User;

QB::query('CREATE TABLE IF NOT EXISTS ' . Game::TABLE . ' (
	id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    word_id INT NOT NULL,
    current_text VARCHAR(255) NOT NULL,
    rating INT NOT NULL DEFAULT(0),
    time TIMESTAMP on update CURRENT_TIMESTAMP() NOT NULL DEFAULT CURRENT_TIMESTAMP()
)');

QB::query('CREATE TABLE IF NOT EXISTS ' . User::TABLE . ' (
	id BIGINT(20) NOT NULL PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    time TIMESTAMP on update CURRENT_TIMESTAMP() NOT NULL DEFAULT CURRENT_TIMESTAMP()
)');
