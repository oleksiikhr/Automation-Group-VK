<?php

require_once __DIR__ . '/../configs/defines.php';
require_once D_ROOT . '/vendor/autoload.php';

$db = require D_ROOT . '/configs/db.php';
new Pixie\Connection($db['driver'], $db, 'QB');

rename(__DIR__ . '/../configs/defines-sample.php', __DIR__ . '/../configs/defines.php');

QB::query('CREATE TABLE IF NOT EXISTS ' . \gvk\Config::TABLE . ' (
	id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    value TEXT
)');
QB::table(\gvk\Config::TABLE)->insert([
    'name'  => 'secret_key',
    'value' => \gvk\Config::setRandomSecretKey()
]);
QB::table(\gvk\Config::TABLE)->insert([
    'name' => 'youtube_playlists'
]);

QB::query('CREATE TABLE IF NOT EXISTS ' . \gvk\vk\methods\Polls::TABLE_1 . ' (
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quest VARCHAR(255) NOT NULL UNIQUE,
    answers TEXT NOT NULL,
    correct_answer VARCHAR(255) NOT NULL
)');
QB::query('CREATE TABLE IF NOT EXISTS ' . \gvk\vk\methods\Polls::TABLE_2 . '(
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quest VARCHAR(255) NOT NULL UNIQUE,
    answers TEXT NOT NULL,
    correct_answer VARCHAR(255) NOT NULL
)');
QB::query('CREATE TABLE IF NOT EXISTS ' . \gvk\vk\methods\Polls::TABLE_3 . '(
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    answers TEXT NOT NULL,
    correct_answer VARCHAR(255) NOT NULL
)');

QB::query('CREATE TABLE IF NOT EXISTS ' . \gvk\vk\methods\Verbs::TABLE . '(
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_form VARCHAR(255) NOT NULL UNIQUE,
    second_form VARCHAR(255),
    third_form VARCHAR(255)
)');

QB::query('CREATE TABLE IF NOT EXISTS ' . \gvk\vk\methods\Translate::TABLE . '(
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    word_eng VARCHAR(255) NOT NULL UNIQUE,
    transcription VARCHAR(255),
    word_rus VARCHAR(255)
)');

QB::query('CREATE TABLE IF NOT EXISTS ' . \gvk\vk\methods\Learn::TABLE . '(
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL UNIQUE,
    text TEXT
)');

QB::query('CREATE TABLE IF NOT EXISTS ' . \gvk\vk\methods\Video::TABLE . '(
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    videoYoutubeID VARCHAR(255) UNIQUE,
    videoVKID VARCHAR(255) UNIQUE,
    album_id INT(11),
    playlist VARCHAR(255),
    is_added BOOLEAN
)');

unlink(__FILE__);
