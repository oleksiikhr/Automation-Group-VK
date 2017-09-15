<?php

require_once __DIR__ . '/../../public/run.php';

use \tmp\game\Game;
use \tmp\game\User;

QB::query('CREATE TABLE IF NOT EXISTS ' . Game::TABLE . ' (
    word VARCHAR(60) NOT NULL,
    ans VARCHAR(60) NOT NULL,
    tip VARCHAR(60),
    game_type SMALLINT NOT NULL,
    is_finished BOOLEAN NOT NULL DEFAULT(0),
    time TIMESTAMP on update CURRENT_TIMESTAMP() NOT NULL DEFAULT CURRENT_TIMESTAMP()
)');

QB::query('CREATE TABLE IF NOT EXISTS ' . User::TABLE . ' (
	id BIGINT(20) NOT NULL PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    rating INT NOT NULL DEFAULT(0),
    time TIMESTAMP on update CURRENT_TIMESTAMP() NOT NULL DEFAULT CURRENT_TIMESTAMP()
)');
