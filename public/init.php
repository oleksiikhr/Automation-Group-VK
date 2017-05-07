<?php

require_once __DIR__ . '/../configs/defines.php';
require_once D_ROOT . '/vendor/autoload.php';

$db = require D_ROOT . '/configs/db.php';
new Pixie\Connection($db['driver'], $db, 'QB');

//rename(__DIR__ . '/../configs/defines-sample.php', __DIR__ . '/../configs/defines.php');

// TABLE CONFIG
//QB::query('CREATE TABLE ' . \gvk\Config::TABLE . ' (
//	id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//    name VARCHAR(255) NOT NULL UNIQUE,
//    value TEXT
//)');
//QB::table(\gvk\Config::TABLE)->insert([
//    'name'  => 'secret_key',
//    'value' => \gvk\Config::setRandomSecretKey()
//]);

// TABLE POLLS
//QB::query('CREATE TABLE ' . \gvk\vk\methods\Polls::TABLE_1 . ' (
//    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//    quest VARCHAR(255) NOT NULL UNIQUE,
//    answers TEXT NOT NULL,
//    correct_answer VARCHAR(255) NOT NULL
//)');
//QB::query('CREATE TABLE ' . \gvk\vk\methods\Polls::TABLE_2 . '(
//    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//    quest VARCHAR(255) NOT NULL UNIQUE,
//    answers TEXT NOT NULL,
//    correct_answer VARCHAR(255) NOT NULL
//)');
//QB::query('CREATE TABLE ' . \gvk\vk\methods\Polls::TABLE_3 . '(
//    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//    answers TEXT NOT NULL,
//    correct_answer VARCHAR(255) NOT NULL
//)');

//unlink(__FILE__);
