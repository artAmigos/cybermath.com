-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 13 2025 г., 01:14
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cybermath`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Admin@ee.ee', 'Admin@ee.ee', '$2y$10$RYO5qDSlPPHi8aFdz1A9feysrfU0.Gsys3p/LqF9PD0Gk4DIX1wOm', '2025-04-29 10:05:52');

-- --------------------------------------------------------

--
-- Структура таблицы `moderator`
--

CREATE TABLE `moderator` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `moderator`
--

INSERT INTO `moderator` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Admin', 'Admin@ee.ee', '$2y$10$xDDHbHberMKbBR.VpNeMu.Hi/7./bW9TxOIIcScezQywLfKTDCnuu', '2025-05-06 11:13:39');

-- --------------------------------------------------------

--
-- Структура таблицы `moderator_requests`
--

CREATE TABLE `moderator_requests` (
  `id` int(11) NOT NULL,
  `moderator_id` int(11) NOT NULL,
  `target_name` varchar(255) NOT NULL,
  `action` enum('give_coins','block_user','delete_user') NOT NULL,
  `coins` int(11) DEFAULT 0,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `coins` int(11) DEFAULT 0,
  `status` enum('active','blocked') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `coins`, `status`) VALUES
(1, 'CyberMath0', 'cybermath0@gmail.com', '$2y$10$7usPUDEmhSgDNtQ8w5EsYulNe.7D8uBG284LEhoW6PHm0c3fw66B6', '2025-04-29 09:30:39', 390, 'active'),
(2, 'CyberMath1', 'cybermath1@gmail.com', '$2y$10$f9TCS7RxhS.f7A4Nw6EZeuZDafgz/Xj3HYPqcbSaDkcBlkjvGw986', '2025-04-29 11:22:53', 100, 'active'),
(3, 'CyberMath2', 'cybermath2@gmail.com', '$2y$10$Oo19wRNVdLiMdRbH4cv8x.vzSGabOVcKj0ZMse/r/kIxDWgxWYeN6', '2025-04-29 11:32:27', 100, 'active'),
(4, 'CyberMath3', 'cybermath3@gmail.com', '$2y$10$z3VswOG80aEPMa8I1HDqiOZk3UNc/3hKOLLANqPgtULMsis9URh3W', '2025-04-29 11:40:57', 100, 'active'),
(5, 'CyberMath4', 'cybermath4@gmail.com', '$2y$10$S2c0bSwEi276a3Z/u3iuLOKorFc5lmy07Xbo9CnhJjezS/kIklOgi', '2025-04-29 11:43:01', 100, 'active'),
(6, 'CyberMath5', 'cybermath5@gmail.com', '$2y$10$HwV.u94CsAcdIlVHTmrpseo0.vNUsclaHXnNygMmI3pbjn034g9r.', '2025-04-29 11:48:30', 100, 'active'),
(7, 'CyberMath6', 'cybermath6@gmail.com', '$2y$10$TpEOnXSnIvO741CzuX4Ri.DNCRLh6d1jswakpOq3Cza3NORAcHbG2', '2025-04-29 11:52:54', 100, 'active');

-- --------------------------------------------------------

--
-- Структура таблицы `user_tasks`
--

CREATE TABLE `user_tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `given` text NOT NULL,
  `solution` text NOT NULL,
  `answer` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `reward` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user_tasks`
--

INSERT INTO `user_tasks` (`id`, `user_id`, `topic_id`, `task_id`, `given`, `solution`, `answer`, `is_correct`, `reward`, `completed_at`) VALUES
(2, 1, 1, 1, 'рпопропропро', 'пропропро', '5', 1, 70, '2025-05-06 10:16:04'),
(3, 1, 1, 1, 'сидели 4 котенка. 2 котенка убежали, а ещё 3 кота сели на скамейку', '(4-2)+3', '5', 1, 0, '2025-05-06 10:26:09'),
(4, 1, 1, 1, 'паапап', 'апапап', '6', 0, 0, '2025-05-06 10:34:45'),
(5, 1, 1, 1, 'орпопроп', 'попропро', 'опропро', 0, 0, '2025-05-06 10:34:55'),
(6, 1, 1, 2, 'ывавыаыв', 'выавыавыа', 'выавыа', 0, 0, '2025-05-06 10:36:02'),
(7, 1, 1, 1, 'скамейке сидели 4 котенка. 2 котенка убежали, а ещё 3 кота сели на скамейку.', '(4-2)+3', '5', 1, 0, '2025-05-06 10:50:10');

-- --------------------------------------------------------

--
-- Структура таблицы `user_topics`
--

CREATE TABLE `user_topics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user_topics`
--

INSERT INTO `user_topics` (`id`, `user_id`, `topic_id`, `completed_at`) VALUES
(1, 1, 1, '2025-04-29 09:58:01'),
(2, 1, 2, '2025-04-29 11:16:11'),
(3, 2, 1, '2025-04-29 11:23:18'),
(4, 3, 1, '2025-04-29 11:33:31'),
(5, 4, 1, '2025-04-29 11:41:31'),
(6, 5, 1, '2025-04-29 11:45:57'),
(7, 6, 1, '2025-04-29 11:48:56'),
(8, 7, 1, '2025-04-29 11:53:19'),
(9, 8, 1, '2025-04-29 11:58:44'),
(10, 1, 21, '2025-05-05 10:17:52'),
(11, 1, 22, '2025-05-05 10:45:40'),
(12, 1, 17, '2025-05-06 05:17:32');

--
-- Триггеры `user_topics`
--
DELIMITER $$
CREATE TRIGGER `add_coins_after_topic_completed` AFTER INSERT ON `user_topics` FOR EACH ROW BEGIN
    -- Добавляем 50 монет пользователю после того, как он завершает тему
    UPDATE users
    SET coins = coins + 50
    WHERE id = NEW.user_id;
END
$$
DELIMITER ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `moderator`
--
ALTER TABLE `moderator`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `moderator_requests`
--
ALTER TABLE `moderator_requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `user_tasks`
--
ALTER TABLE `user_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_topics`
--
ALTER TABLE `user_topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`topic_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `moderator`
--
ALTER TABLE `moderator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `moderator_requests`
--
ALTER TABLE `moderator_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `user_tasks`
--
ALTER TABLE `user_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `user_topics`
--
ALTER TABLE `user_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
