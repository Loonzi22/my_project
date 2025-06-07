-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Sob 07. čen 2025, 13:22
-- Verze serveru: 10.4.28-MariaDB
-- Verze PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `blog_db`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `comment`, `created_at`) VALUES
(1, 1, 'test1', '2025-06-04 22:53:13'),
(2, 1, 'test1', '2025-06-04 22:53:26'),
(3, 1, 'test_user2', '2025-06-04 22:54:11'),
(4, 2, 'test2_user2', '2025-06-04 22:55:12'),
(5, 2, 'test2_user2', '2025-06-04 22:55:27'),
(6, 1, ';)', '2025-06-05 14:06:45'),
(7, 4, 'komentar!', '2025-06-05 14:42:10'),
(8, 1, 'jfkjkgfkgjfkhfkgjkgjkjg', '2025-06-06 14:53:04');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'Usser1', 'usser1@gmail.com', '$2y$10$9KSkkq5yH1ViJIkqLZXjr.l/41bHggkXwrs.CVjyzEhAzmJ0gmM9e', 'user'),
(2, 'user2', 'user2@gmail.com', '$2y$10$5UaeqT7gRzUQ5axoTOTcZ.DjR9D/nLfmoDB3mWzOSAKFfX79ZHuz2', 'user'),
(3, 'user1', 'user1@gmail.com', '$2y$10$1ULWzKJx8ld4zaakukW.bukh.SJdt3fxHPeLxv9OM16Dp0GIWfnLK', 'user'),
(4, 'user', 'user@gmail.com', '$2y$10$n3L32bP4ruKuHhG/RDjid.Ppggpx/JUh5TJ4vmZTaxOmXtIKLdh0O', 'user');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
