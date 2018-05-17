<?php declare(strict_types=1);

/*
 * FIXME IMPORTANT - DELETE AFTER INITIAL
 */

require_once __DIR__ . '/../configs/defines.php';

// Set connection.
$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE,
    DB_USERNAME,
    DB_PASSWORD,
    [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
    ]
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// TABLES

$pdo->query('CREATE TABLE `words_eng` (
    `word_eng_id`       INT NOT NULL AUTO_INCREMENT,
	`word_eng`          VARCHAR(255) NOT NULL UNIQUE,
	`transcription_eng` VARCHAR(255),
	`transcription_rus` VARCHAR(255),
	`published_at`      DATETIME,
	PRIMARY KEY (`word_eng_id`)
)');

$pdo->query('CREATE TABLE `words_rus` (
    `word_rus_id`       INT NOT NULL AUTO_INCREMENT,
	`word_eng_id`       INT NOT NULL,
	`word_rus`          VARCHAR(255) NOT NULL,
	PRIMARY KEY (`word_rus_id`)
)');

$pdo->query('CREATE TABLE `verbs` (
    `word_eng_id`       INT NOT NULL,
	`second_form`       VARCHAR(255) NOT NULL,
	`third_form`        VARCHAR(255) NOT NULL,
	`published_at`      DATETIME,
	PRIMARY KEY (`word_eng_id`)
)');

// INDEX

$pdo->query('CREATE INDEX `word_rus_index` ON `words_rus` (`word_rus`)');

// RELATIONSHIP

$pdo->query('ALTER TABLE `words_rus`
    ADD CONSTRAINT `words_rus_fk`
    FOREIGN KEY (`word_eng_id`)
    REFERENCES `words_eng`(`word_eng_id`)
');

$pdo->query('ALTER TABLE `verbs`
    ADD CONSTRAINT `verbs_fk`
    FOREIGN KEY (`word_eng_id`)
    REFERENCES `words_eng`(`word_eng_id`)'
);

echo 'OK';
