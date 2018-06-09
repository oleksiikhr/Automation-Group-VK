-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 09 2018 г., 10:49
-- Версия сервера: 10.1.33-MariaDB
-- Версия PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `english`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `verbs`
--

CREATE TABLE `verbs` (
  `word_eng_id` int(11) NOT NULL,
  `second_form` varchar(255) NOT NULL,
  `third_form` varchar(255) NOT NULL,
  `published_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `words_eng`
--

CREATE TABLE `words_eng` (
  `word_eng_id` int(11) NOT NULL,
  `word_eng` varchar(255) NOT NULL,
  `transcription_eng` varchar(255) DEFAULT NULL,
  `transcription_rus` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `favorite` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `published_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `words_rus`
--

CREATE TABLE `words_rus` (
  `word_rus_id` int(11) NOT NULL,
  `word_rus` varchar(255) NOT NULL,
  `pos` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `word_eng_rus`
--

CREATE TABLE `word_eng_rus` (
  `word_eng_id` int(11) NOT NULL,
  `word_rus_id` int(11) NOT NULL,
  `weight` tinyint(4) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `verbs`
--
ALTER TABLE `verbs`
  ADD PRIMARY KEY (`word_eng_id`);

--
-- Индексы таблицы `words_eng`
--
ALTER TABLE `words_eng`
  ADD PRIMARY KEY (`word_eng_id`),
  ADD UNIQUE KEY `word_eng` (`word_eng`);

--
-- Индексы таблицы `words_rus`
--
ALTER TABLE `words_rus`
  ADD PRIMARY KEY (`word_rus_id`),
  ADD UNIQUE KEY `word_rus` (`word_rus`);

--
-- Индексы таблицы `word_eng_rus`
--
ALTER TABLE `word_eng_rus`
  ADD PRIMARY KEY (`word_eng_id`,`word_rus_id`),
  ADD KEY `word_eng_rus_fk1` (`word_rus_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `words_eng`
--
ALTER TABLE `words_eng`
  MODIFY `word_eng_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `words_rus`
--
ALTER TABLE `words_rus`
  MODIFY `word_rus_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `verbs`
--
ALTER TABLE `verbs`
  ADD CONSTRAINT `verbs_fk0` FOREIGN KEY (`word_eng_id`) REFERENCES `words_eng` (`word_eng_id`);

--
-- Ограничения внешнего ключа таблицы `word_eng_rus`
--
ALTER TABLE `word_eng_rus`
  ADD CONSTRAINT `word_eng_rus_fk0` FOREIGN KEY (`word_eng_id`) REFERENCES `words_eng` (`word_eng_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `word_eng_rus_fk1` FOREIGN KEY (`word_rus_id`) REFERENCES `words_rus` (`word_rus_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
