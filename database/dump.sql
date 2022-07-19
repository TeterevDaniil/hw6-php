-- Adminer 4.8.1 MySQL 5.7.38-log dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `clients` (`id`, `name`, `email`, `phone`, `address`, `insert_date`, `password`) VALUES
(336,	'Даниил Александрович Тетерев',	'teterevdanil@gmail.com',	NULL,	NULL,	'2022-07-04 05:25:15',	'e4dcb80fd2bf45f86483de903ac49c48ab47b8f1'),
(339,	'admin',	'admin@admin.com',	NULL,	NULL,	'2022-07-05 05:02:51',	'e4dcb80fd2bf45f86483de903ac49c48ab47b8f1');

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `message` (`id`, `text`, `insert_date`, `user_id`, `img`) VALUES
(34,	'ascascas',	'2022-07-18 09:39:06',	341,	'3057934c907f81a4b097414e62529a233a9888f5.jpg'),
(37,	'dfdqw',	'2022-07-19 05:19:23',	339,	'f9be61b453727c060707fa0e80073ff8c41969f4.jpg');

-- 2022-07-19 07:38:30
