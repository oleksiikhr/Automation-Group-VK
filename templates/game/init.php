<?php

require_once __DIR__ . '/../../public/run.php';

use \tmp\game\Game;

QB::query('CREATE TABLE IF NOT EXISTS ' . Game::TABLE_GAME . ' (
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(60) NOT NULL,
    ans VARCHAR(60) NOT NULL,
    tip VARCHAR(60),
    game_type SMALLINT NOT NULL,
    is_finished BOOLEAN NOT NULL DEFAULT 0,
    time TIMESTAMP on update CURRENT_TIMESTAMP() NOT NULL DEFAULT CURRENT_TIMESTAMP()
)');

QB::query('CREATE TABLE IF NOT EXISTS ' . Game::TABLE_USER . ' (
	id BIGINT(20) NOT NULL PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    image VARCHAR(255) NOT NULL,
    rating INT NOT NULL DEFAULT 0,
    time TIMESTAMP on update CURRENT_TIMESTAMP() NOT NULL DEFAULT CURRENT_TIMESTAMP()
)');
