-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Exportiere Datenbank Struktur für temperatur
DROP DATABASE IF EXISTS `temperatur`;
CREATE DATABASE IF NOT EXISTS `temperatur` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `temperatur`;

-- Exportiere Struktur von Tabelle temperatur.api_tokens
DROP TABLE IF EXISTS `api_tokens`;
CREATE TABLE IF NOT EXISTS `api_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(100) NOT NULL,
  `token` varchar(20) NOT NULL,
  `uses` int(11) NOT NULL DEFAULT 0,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='Tabelle für Token';

-- Exportiere Daten aus Tabelle temperatur.api_tokens: ~1 rows (ungefähr)
DELETE FROM `api_tokens`;
INSERT INTO `api_tokens` (`id`, `user_id`, `ip`, `token`, `uses`, `active`, `updated_at`, `created_at`) VALUES
	(1, 1, '10.204.194.51', 'ae5Lh9E3YY2zsV1oBP7B', 0, 'true', '2024-08-15 11:45:40', '2024-08-15 11:45:40');

-- Exportiere Struktur von Tabelle temperatur.applications
DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT 'Syntax-Sabberer',
  `version` varchar(10) NOT NULL DEFAULT 'v.1.0.0',
  `downloads` int(11) NOT NULL DEFAULT 0,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.applications: ~9 rows (ungefähr)
DELETE FROM `applications`;
INSERT INTO `applications` (`id`, `name`, `version`, `downloads`, `active`, `updated_at`, `created_at`) VALUES
	(1, 'Syntax-Sabberer', 'v.1.0.0', 1, 'true', '2024-08-13 07:13:52', '2024-08-13 06:59:34'),
	(2, 'Syntax-Sabberer', 'v.1.0.1', 5, 'true', '2024-08-13 19:13:00', '2024-08-13 07:27:16'),
	(3, 'Syntax-Sabberer', 'v.1.0.2', 5, 'true', '2024-08-14 06:07:46', '2024-08-13 19:13:36'),
	(4, 'Syntax-Sabberer', 'v.1.0.3', 1, 'true', '2024-08-14 08:31:45', '2024-08-14 08:29:46'),
	(5, 'Syntax-Sabberer', 'v.1.0.4', 1, 'true', '2024-08-14 08:38:10', '2024-08-14 08:37:59'),
	(6, 'Syntax-Sabberer', 'v.1.0.5', 1, 'true', '2024-08-14 09:48:38', '2024-08-14 09:09:45'),
	(7, 'Syntax-Sabberer', 'v.1.0.6', 2, 'true', '2024-08-14 09:55:01', '2024-08-14 09:50:56'),
	(8, 'Syntax-Sabberer', 'v.2.0.0', 2, 'true', '2024-08-15 09:01:24', '2024-08-15 08:56:39'),
	(9, 'Syntax-Sabberer', 'v.2.0.1', 0, 'true', '2024-08-15 10:26:33', '2024-08-15 10:26:33');

-- Exportiere Struktur von Tabelle temperatur.images
DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `src` varchar(255) NOT NULL DEFAULT 'default.png',
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.images: ~3 rows (ungefähr)
DELETE FROM `images`;
INSERT INTO `images` (`id`, `src`, `active`, `updated_at`, `created_at`) VALUES
	(1, 'default.png', 'true', '2024-08-13 12:26:26', '2024-08-13 12:26:26'),
	(2, 'default.png', 'true', '2024-08-15 07:59:34', '2024-08-15 07:59:34'),
	(3, 'default.png', 'true', '2024-08-15 11:02:49', '2024-08-15 11:02:49');

-- Exportiere Struktur von Tabelle temperatur.pages
DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `index` int(11) NOT NULL,
  `showAlways` enum('true','false') NOT NULL DEFAULT 'false',
  `hideInHeader` enum('true','false') NOT NULL DEFAULT 'false',
  `hideInFooter` enum('true','false') NOT NULL DEFAULT 'false',
  `mustBeLoggedIn` enum('true','false','both') NOT NULL DEFAULT 'both',
  `color` varchar(7) NOT NULL DEFAULT '#ffffff',
  `icon` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `subline` varchar(500) NOT NULL,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `index` (`index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='K.a wofür aber für die Seiten IG';

-- Exportiere Daten aus Tabelle temperatur.pages: ~0 rows (ungefähr)
DELETE FROM `pages`;

-- Exportiere Struktur von Tabelle temperatur.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#ffffff',
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.roles: ~2 rows (ungefähr)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `name`, `color`, `active`, `updated_at`, `created_at`) VALUES
	(1, 'User', '#ffffff', 'true', '2024-08-13 12:28:32', '2024-08-13 12:28:32'),
	(2, 'Admin', '#ffffff', 'true', '2024-08-13 12:28:37', '2024-08-13 12:28:37');

-- Exportiere Struktur von Tabelle temperatur.sensors
DROP TABLE IF EXISTS `sensors`;
CREATE TABLE IF NOT EXISTS `sensors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#ffffff',
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='Eintrag für die Sensoren';

-- Exportiere Daten aus Tabelle temperatur.sensors: ~3 rows (ungefähr)
DELETE FROM `sensors`;
INSERT INTO `sensors` (`id`, `name`, `color`, `active`, `updated_at`, `created_at`) VALUES
	(1, 'Sensor #1', '#fff', 'false', '2024-08-13 11:27:32', '2024-08-12 00:00:00'),
	(2, 'Sensor #2', '#fff', 'true', '2024-08-13 11:27:37', '2024-08-12 00:00:00'),
	(3, 'Sensor #3', '#fff', 'false', '2024-08-13 11:27:30', '2024-08-12 00:00:00');

-- Exportiere Struktur von Tabelle temperatur.temperatures
DROP TABLE IF EXISTS `temperatures`;
CREATE TABLE IF NOT EXISTS `temperatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sensor_id` int(11) NOT NULL,
  `temperature` float NOT NULL,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updatetd_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8mb4 COMMENT='Aufnahme der Temperatur';

-- Exportiere Daten aus Tabelle temperatur.temperatures: ~208 rows (ungefähr)
DELETE FROM `temperatures`;
INSERT INTO `temperatures` (`id`, `sensor_id`, `temperature`, `active`, `updatetd_at`, `created_at`) VALUES
	(1, 1, 23, 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
	(2, 2, 24, 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
	(3, 1, 13, 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
	(4, 2, 30, 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
	(5, 1, 23, 'true', '2024-08-12 00:00:01', '2024-08-12 00:00:00'),
	(6, 2, 14, 'true', '2024-08-12 00:00:01', '2024-08-12 00:00:00'),
	(7, 3, 23, 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
	(8, 3, 24, 'true', '2024-08-12 00:00:01', '2024-08-12 00:00:00'),
	(9, 3, 25, 'true', '2024-08-12 00:00:02', '2024-08-12 00:00:00'),
	(10, 1, 27, 'true', '2024-08-13 10:08:22', '2024-08-13 10:08:22'),
	(11, 1, 27.5, 'true', '2024-08-13 10:08:41', '2024-08-13 10:08:41'),
	(12, 3, 27.5, 'true', '2024-08-13 10:12:03', '2024-08-13 10:12:03'),
	(13, 3, 27.5, 'true', '2024-08-13 10:14:25', '2024-08-13 10:14:25'),
	(14, 2, 27.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(15, 3, 27.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(16, 1, 20.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(17, 2, 14.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(18, 3, 17.9, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(19, 1, 12.8, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(20, 2, 24.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(21, 2, 10.8, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(22, 3, 12.5, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(23, 1, 13.9, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(24, 1, 27.2, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(25, 1, 23.7, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(26, 2, 20, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(27, 2, 24.7, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(28, 1, 13.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(29, 1, 29.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(30, 2, 22, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(31, 3, 25.6, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(32, 2, 22.8, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(33, 2, 23.6, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(34, 3, 29, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(35, 2, 13.5, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(36, 1, 11.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(37, 1, 10.9, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(38, 1, 17.2, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(39, 1, 12.5, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(40, 3, 24.2, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(41, 2, 24.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(42, 1, 28.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(43, 3, 13.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(44, 2, 23.2, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(45, 1, 14.8, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(46, 2, 18.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(47, 3, 11.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(48, 3, 18.7, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(49, 1, 21.9, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(50, 2, 10.7, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(51, 1, 25, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(52, 2, 14.2, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(53, 1, 26, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(54, 2, 14.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(55, 3, 11.8, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(56, 1, 15.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(57, 2, 28.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(58, 3, 16.8, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(59, 2, 16.8, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(60, 3, 16.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(61, 3, 13.5, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(62, 3, 12.6, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(63, 2, 17.5, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(64, 1, 17.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(65, 2, 29.7, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(66, 1, 15.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(67, 2, 13.9, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(68, 3, 11.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(69, 2, 24.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(70, 1, 14.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(71, 2, 23.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(72, 2, 24.2, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(73, 1, 24.9, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(74, 1, 14.5, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(75, 3, 10.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(76, 2, 25.7, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(77, 1, 27.7, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(78, 1, 20.2, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(79, 2, 28.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(80, 3, 28.7, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(81, 3, 14.5, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(82, 1, 27.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(83, 1, 27.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(84, 3, 16, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(85, 2, 16.7, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(86, 1, 24, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(87, 1, 29.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(88, 2, 26.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(89, 1, 11.5, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(90, 2, 11.9, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(91, 3, 28.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(92, 2, 17.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(93, 2, 29.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(94, 3, 22, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(95, 1, 20.9, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(96, 1, 23.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(97, 2, 17.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(98, 2, 12.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(99, 2, 18.1, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(100, 1, 21.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(101, 1, 29.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(102, 1, 23.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(103, 3, 12.6, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(104, 1, 15.3, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(105, 3, 25.4, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(106, 1, 24.2, 'true', '2024-08-13 10:24:28', '2024-08-13 10:24:28'),
	(107, 3, 23.8, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(108, 2, 23.8, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(109, 1, 15.9, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(110, 3, 16.6, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(111, 2, 14.3, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(112, 1, 11.2, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(113, 1, 29.9, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(114, 3, 20.8, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(115, 1, 24.1, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(116, 1, 11.9, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(117, 1, 27.1, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(118, 2, 27.1, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(119, 3, 23.5, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(120, 3, 14.3, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(121, 2, 24.1, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(122, 1, 18.6, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(123, 1, 26.1, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(124, 1, 22.2, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(125, 1, 23.4, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(126, 2, 25.7, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(127, 1, 27.4, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(128, 2, 17.3, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(129, 1, 13.4, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(130, 1, 11.7, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(131, 1, 11.5, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(132, 2, 10.2, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(133, 2, 15.3, 'true', '2024-08-13 10:24:45', '2024-08-13 10:24:45'),
	(134, 3, 24.4, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(135, 3, 26.8, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(136, 1, 16, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(137, 1, 25.1, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(138, 1, 28.1, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(139, 1, 14.9, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(140, 1, 24.7, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(141, 2, 27.9, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(142, 1, 21, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(143, 3, 19.7, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(144, 2, 22.8, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(145, 2, 29.5, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(146, 2, 16.4, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(147, 1, 26.9, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(148, 1, 20.6, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(149, 1, 22.4, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(150, 2, 22.5, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(151, 2, 17.4, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(152, 3, 22, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(153, 3, 18.9, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(154, 1, 17.5, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(155, 1, 20.5, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(156, 1, 11, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(157, 1, 18, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(158, 1, 13.7, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(159, 1, 16.7, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(160, 3, 22.6, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(161, 1, 14.3, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(162, 2, 15.9, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(163, 2, 16.6, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(164, 3, 21.8, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(165, 3, 16.1, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(166, 1, 16.8, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(167, 2, 21.8, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(168, 3, 29.9, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(169, 1, 12.2, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(170, 2, 17, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(171, 3, 16.5, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(172, 1, 18.9, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(173, 2, 16.4, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(174, 2, 22.6, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(175, 3, 18.1, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(176, 3, 26.7, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(177, 2, 21.2, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(178, 3, 16.7, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(179, 2, 18.6, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(180, 2, 15, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(181, 2, 27.8, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(182, 1, 14.1, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(183, 1, 25.7, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(184, 1, 17.6, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(185, 3, 26.2, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(186, 2, 19.9, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(187, 1, 25.4, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(188, 1, 10.1, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(189, 2, 14.1, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(190, 1, 28.4, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(191, 1, 18.6, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(192, 3, 20.9, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(193, 2, 11.6, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(194, 3, 10.7, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(195, 2, 30, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(196, 1, 26.9, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(197, 2, 12, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(198, 2, 23.2, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(199, 2, 23.3, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(200, 2, 14.4, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(201, 2, 25.4, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(202, 1, 14.1, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(203, 1, 27.7, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(204, 3, 26.2, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(205, 2, 18.8, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(206, 2, 25.6, 'true', '2024-08-13 10:24:46', '2024-08-13 10:24:46'),
	(207, 2, 0, 'true', '2024-08-13 10:34:43', '2024-08-13 10:34:43'),
	(208, 2, 45, 'true', '2024-08-13 10:35:37', '2024-08-13 10:35:37');

-- Exportiere Struktur von Tabelle temperatur.translations
DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL DEFAULT 'site',
  `value` varchar(2000) DEFAULT NULL,
  `de` varchar(2000) DEFAULT NULL,
  `en` varchar(2000) DEFAULT NULL,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.translations: ~20 rows (ungefähr)
DELETE FROM `translations`;
INSERT INTO `translations` (`id`, `category`, `value`, `de`, `en`, `active`, `updated_at`, `created_at`) VALUES
	(1, 'site', 'controller not found.', 'Der Controller wurde nicht gefunden.', 'Controller not found.', 'true', '2024-08-13 10:35:53', '2024-08-13 10:27:19'),
	(2, 'site', 'this is the default action. please provide a valid controller with a valid action. if you do not know any available actions, just call the controller and it will display all.', 'Das ist die Standard Funktion. Bitte geben eine korrekte Funktion an. Falls du keine Funktionen kennst, kannst du hier alle verfügbaren sehen.', 'This is the default action. Please provide a valid controller with a valid action. If you do not know any available actions, just call the controller and it will display all.', 'true', '2024-08-13 10:37:38', '2024-08-13 10:33:40'),
	(3, 'site', 'you can call the following functions.', 'Du kannst die folgenden Funktionen benutzen.', 'You can call the following functions.', 'true', '2024-08-13 10:38:00', '2024-08-13 10:33:43'),
	(4, 'site', 'seems like nothing was returned.', 'Anscheinend wurde nichts zurückgegeben.', 'Seems like nothing was returned.', 'true', '2024-08-13 10:38:14', '2024-08-13 10:33:53'),
	(5, 'site', 'action not found.', 'Funktion nicht gefunden.', 'Action not found.', 'true', '2024-08-13 10:38:20', '2024-08-13 10:34:09'),
	(6, 'site', 'invalid sensor_id (first param) provided.', 'Falsche "sensor_id" (erster Param) gegeben.', 'Invalid "sensor_id" (first param) provided.', 'true', '2024-08-13 10:38:49', '2024-08-13 10:34:32'),
	(7, 'site', 'invalid temperature (second param) provided.', 'Falsche "temperatur" (zweiter Param) gegeben.', 'Invalid temperature (second param) provided.', 'true', '2024-08-13 10:39:00', '2024-08-13 10:34:35'),
	(8, 'site', 'temperature inserted.', 'Temperatur wurde gespeichert.', 'Temperature inserted.', 'true', '2024-08-13 10:39:17', '2024-08-13 10:34:43'),
	(9, 'site', 'invalid "username" (first param) given.', NULL, 'Invalid "username" (first param) given.', 'true', '2024-08-13 11:59:36', '2024-08-13 11:59:36'),
	(10, 'site', 'invalid "password" (second param) given.', NULL, 'Invalid "password" (second param) given.', 'true', '2024-08-13 11:59:41', '2024-08-13 11:59:41'),
	(11, 'site', 'invalid "passwordrepeat" (third param) given.', NULL, 'Invalid "passwordRepeat" (third param) given.', 'true', '2024-08-13 11:59:44', '2024-08-13 11:59:44'),
	(12, 'site', 'passwords do not match.', NULL, 'Passwords do not match.', 'true', '2024-08-13 11:59:47', '2024-08-13 11:59:47'),
	(13, 'site', 'account created.', NULL, 'Account created.', 'true', '2024-08-13 11:59:49', '2024-08-13 11:59:49'),
	(14, 'site', 'there was an error while creating a new user', NULL, 'There was an error while creating a new user', 'true', '2024-08-13 12:05:26', '2024-08-13 12:05:26'),
	(15, 'site', 'username already exists.', NULL, 'Username already exists.', 'true', '2024-08-13 12:11:21', '2024-08-13 12:11:21'),
	(16, 'site', 'your password is not correct.', NULL, 'Your password is not correct.', 'true', '2024-08-13 12:20:56', '2024-08-13 12:20:56'),
	(17, 'site', 'welcome back, {username}', NULL, 'Welcome back, {username}', 'true', '2024-08-13 12:21:33', '2024-08-13 12:21:33'),
	(18, 'site', 'the latest version could not be found.', NULL, 'The latest version could not be found.', 'true', '2024-08-14 11:43:53', '2024-08-14 11:43:53'),
	(19, 'site', 'username not found.', NULL, 'Username not found.', 'true', '2024-08-14 12:26:27', '2024-08-14 12:26:27'),
	(20, 'site', 'invalid "id" or "username" (first param) given.', NULL, 'Invalid "id" or "username" (first param) given.', 'true', '2024-08-15 07:46:11', '2024-08-15 07:46:11'),
	(21, 'site', 'invalid user id given.', NULL, 'Invalid user id given.', 'true', '2024-08-15 11:44:07', '2024-08-15 11:44:07'),
	(22, 'site', 'invalid token provided!', NULL, 'Invalid token provided!', 'true', '2024-08-15 11:49:24', '2024-08-15 11:49:24'),
	(23, 'site', 'error while updating account.', NULL, 'Error while updating account.', 'true', '2024-08-15 11:54:33', '2024-08-15 11:54:33'),
	(24, 'site', 'account updated successfully.', NULL, 'Account updated successfully.', 'true', '2024-08-15 11:55:48', '2024-08-15 11:55:48'),
	(25, 'site', 'no "password" given.', NULL, 'No "password" given.', 'true', '2024-08-15 11:57:48', '2024-08-15 11:57:48');

-- Exportiere Struktur von Tabelle temperatur.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `avatar_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 1,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `last_seen` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='Datenbank für User in Temperaturüberwachung';

-- Exportiere Daten aus Tabelle temperatur.users: ~3 rows (ungefähr)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `password`, `avatar_id`, `role_id`, `active`, `last_seen`, `created_at`, `updated_at`) VALUES
	(1, 'Tim', '$2y$10$RXDSPXFNo0s2tyFX6oIUqO1LyRphtkXmQdkiMgrMgyFbbMFfKhBvK', 1, 2, 'true', '2024-08-13 12:26:26', '2024-08-15 12:24:03', '2024-08-13 12:26:26'),
	(2, 'Alex', '$2y$10$ULr9T0RYziJDgQh2cLwHb.FhPiiBt1QB2Wto/v7uHSDcgM2XllStu', 2, 1, 'true', '2024-08-15 07:59:34', '2024-08-15 07:59:34', '2024-08-15 07:59:34'),
	(3, 'Username', '$2y$10$7K4sFPy9GBePczX0rFCeXueAJUQgMk6LEX0ExEQ7dat4m7LIVMwj2', 3, 1, 'true', '2024-08-15 11:02:49', '2024-08-15 11:02:49', '2024-08-15 11:02:49');

-- Exportiere Struktur von Tabelle temperatur.user_settings
DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'en',
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Nutzereinstellungen';

-- Exportiere Daten aus Tabelle temperatur.user_settings: ~0 rows (ungefähr)
DELETE FROM `user_settings`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
