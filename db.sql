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
  PRIMARY KEY (`id`) USING BTREE,
  KEY `api_tokens_users` (`user_id`),
  CONSTRAINT `api_tokens_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='Tabelle für Token';

-- Exportiere Daten aus Tabelle temperatur.api_tokens: ~6 rows (ungefähr)
DELETE FROM `api_tokens`;
INSERT INTO `api_tokens` (`id`, `user_id`, `ip`, `token`, `uses`, `active`, `updated_at`, `created_at`) VALUES
	(1, 1, '10.204.194.51', 'ae5Lh9E3YY2zsV1oBP7B', 25, 'true', '2024-10-17 10:07:01', '2024-08-15 11:45:40'),
	(2, 4, '10.204.193.170', '8l1Zyohk4V8s0XkPbqlE', 35, 'true', '2024-10-17 10:10:43', '2024-08-16 10:30:24'),
	(3, 5, '10.204.193.170', '0MVWT7bHr1qstx3GL8LR', 0, 'true', '2024-08-16 10:45:22', '2024-08-16 10:45:22'),
	(4, 6, '10.204.161.165', 'FcxB5RhcT8A9dGgzgzAe', 18, 'true', '2024-10-17 10:08:05', '2024-08-21 11:09:39'),
	(5, 7, '127.0.0.1', 'wnGvNy1EjgNiPIHUs9Db', 0, 'true', '2024-10-17 10:02:50', '2024-10-17 10:02:50'),
	(6, 8, '127.0.0.1', 'vfecImMekhd7uCVXkoHq', 3, 'true', '2024-10-17 10:10:05', '2024-10-17 10:03:43');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.applications: ~11 rows (ungefähr)
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
	(9, 'Syntax-Sabberer', 'v.2.0.1', 1, 'true', '2024-08-16 07:14:37', '2024-08-15 10:26:33'),
	(10, 'Syntax-Sabberer', 'v.2.0.2', 1, 'true', '2024-08-16 08:27:56', '2024-08-16 08:26:58'),
	(11, 'Syntax-Sabberer', 'v.2.0.3', 5, 'true', '2024-10-17 08:11:45', '2024-08-16 08:47:45');

-- Exportiere Struktur von Tabelle temperatur.images
DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `src` varchar(255) NOT NULL DEFAULT 'default.png',
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.images: ~8 rows (ungefähr)
DELETE FROM `images`;
INSERT INTO `images` (`id`, `src`, `active`, `updated_at`, `created_at`) VALUES
	(1, 'default.png', 'true', '2024-08-13 12:26:26', '2024-08-13 12:26:26'),
	(2, 'default.png', 'true', '2024-08-15 07:59:34', '2024-08-15 07:59:34'),
	(3, 'default.png', 'true', '2024-08-15 11:02:49', '2024-08-15 11:02:49'),
	(4, 'default.png', 'true', '2024-08-16 10:30:24', '2024-08-16 10:30:24'),
	(5, 'default.png', 'true', '2024-08-16 10:45:22', '2024-08-16 10:45:22'),
	(6, 'default.png', 'true', '2024-08-21 11:09:39', '2024-08-21 11:09:39'),
	(7, 'default.png', 'true', '2024-10-17 11:16:39', '2024-10-17 11:16:40'),
	(8, 'default.png', 'true', '2024-10-17 11:16:41', '2024-10-17 11:16:41');

-- Exportiere Struktur von Tabelle temperatur.logs
DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `sensor_id` int(11) NOT NULL DEFAULT 0,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `logs_user` (`user_id`),
  KEY `logs_sensor` (`sensor_id`),
  CONSTRAINT `logs_sensor` FOREIGN KEY (`sensor_id`) REFERENCES `sensors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.logs: ~0 rows (ungefähr)
DELETE FROM `logs`;

-- Exportiere Struktur von Tabelle temperatur.manufacturers
DROP TABLE IF EXISTS `manufacturers`;
CREATE TABLE IF NOT EXISTS `manufacturers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.manufacturers: ~3 rows (ungefähr)
DELETE FROM `manufacturers`;
INSERT INTO `manufacturers` (`id`, `name`, `active`, `updated_at`, `created_at`) VALUES
	(1, 'Dell', 'true', '2024-10-17 10:48:34', '2024-10-17 10:48:34'),
	(2, 'Lenovo', 'true', '2024-10-17 10:48:52', '2024-10-17 10:48:52'),
	(3, 'Siemens', 'true', '2024-10-17 10:49:03', '2024-10-17 10:48:59');

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
  `server_id` int(11) NOT NULL DEFAULT 0,
  `manufacturer_id` int(11) NOT NULL DEFAULT 0,
  `maxTemp` float NOT NULL DEFAULT 30,
  `minTemp` float NOT NULL DEFAULT -30,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#ffffff',
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `sensors_server` (`server_id`),
  KEY `sensors_manufacturer` (`manufacturer_id`),
  CONSTRAINT `sensors_manufacturer` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sensors_server` FOREIGN KEY (`server_id`) REFERENCES `servers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='Eintrag für die Sensoren';

-- Exportiere Daten aus Tabelle temperatur.sensors: ~3 rows (ungefähr)
DELETE FROM `sensors`;
INSERT INTO `sensors` (`id`, `server_id`, `manufacturer_id`, `maxTemp`, `minTemp`, `name`, `address`, `color`, `active`, `updated_at`, `created_at`) VALUES
	(1, 1, 1, 30, -30, 'Sensor #1', 'Berlin', '#fff', 'true', '2024-10-17 10:54:31', '2024-08-12 00:00:00'),
	(2, 3, 2, 30, -30, 'Sensor #2', 'Magdeburg', '#fff', 'true', '2024-10-17 11:28:07', '2024-08-12 00:00:00'),
	(3, 2, 3, 30, -30, 'Sensor #3', 'München', '#fff', 'false', '2024-10-17 10:54:37', '2024-08-12 00:00:00');

-- Exportiere Struktur von Tabelle temperatur.servers
DROP TABLE IF EXISTS `servers`;
CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.servers: ~3 rows (ungefähr)
DELETE FROM `servers`;
INSERT INTO `servers` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
	(1, 'Main', 'true', '2024-10-17 08:49:19', '2024-10-17 08:49:19'),
	(2, 'Raum 42', 'true', '2024-10-17 08:49:24', '2024-10-17 08:49:24'),
	(3, 'Erfurt', 'true', '2024-10-17 08:49:30', '2024-10-17 08:49:30');

-- Exportiere Struktur von Tabelle temperatur.temperatures
DROP TABLE IF EXISTS `temperatures`;
CREATE TABLE IF NOT EXISTS `temperatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sensor_id` int(11) NOT NULL,
  `temperature` float NOT NULL,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `temperatures_sensors` (`sensor_id`),
  CONSTRAINT `temperatures_sensors` FOREIGN KEY (`sensor_id`) REFERENCES `sensors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8mb4 COMMENT='Aufnahme der Temperatur';

-- Exportiere Daten aus Tabelle temperatur.temperatures: ~209 rows (ungefähr)
DELETE FROM `temperatures`;
INSERT INTO `temperatures` (`id`, `sensor_id`, `temperature`, `active`, `updated_at`, `created_at`) VALUES
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
	(208, 2, 45, 'true', '2024-08-13 10:35:37', '2024-08-13 10:35:37'),
	(209, 1, 28, 'true', '2024-10-17 11:03:06', '2024-10-17 11:03:06');

-- Exportiere Struktur von Tabelle temperatur.translations
DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL DEFAULT 'site',
  `value` varchar(2000) DEFAULT NULL,
  `de` varchar(2000) DEFAULT NULL,
  `en` varchar(2000) DEFAULT NULL,
  `ru` varchar(2000) DEFAULT NULL,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.translations: ~34 rows (ungefähr)
DELETE FROM `translations`;
INSERT INTO `translations` (`id`, `category`, `value`, `de`, `en`, `ru`, `active`, `updated_at`, `created_at`) VALUES
	(1, 'site', 'controller not found.', 'Der Controller wurde nicht gefunden.', 'Controller not found.', NULL, 'true', '2024-08-13 10:35:53', '2024-08-13 10:27:19'),
	(2, 'site', 'this is the default action. please provide a valid controller with a valid action. if you do not know any available actions, just call the controller and it will display all.', 'Das ist die Standard Funktion. Bitte geben eine korrekte Funktion an. Falls du keine Funktionen kennst, kannst du hier alle verfügbaren sehen.', 'This is the default action. Please provide a valid controller with a valid action. If you do not know any available actions, just call the controller and it will display all.', NULL, 'true', '2024-08-13 10:37:38', '2024-08-13 10:33:40'),
	(3, 'site', 'you can call the following functions.', 'Du kannst die folgenden Funktionen benutzen.', 'You can call the following functions.', NULL, 'true', '2024-08-13 10:38:00', '2024-08-13 10:33:43'),
	(4, 'site', 'seems like nothing was returned.', 'Anscheinend wurde nichts zurückgegeben.', 'Seems like nothing was returned.', 'Похоже, ничего не было возвращено.', 'true', '2024-10-17 08:49:38', '2024-08-13 10:33:53'),
	(5, 'site', 'action not found.', 'Funktion nicht gefunden.', 'Action not found.', NULL, 'true', '2024-08-13 10:38:20', '2024-08-13 10:34:09'),
	(6, 'site', 'invalid sensor_id (first param) provided.', 'Falsche "sensor_id" (erster Param) gegeben.', 'Invalid "sensor_id" (first param) provided.', NULL, 'true', '2024-08-13 10:38:49', '2024-08-13 10:34:32'),
	(7, 'site', 'invalid temperature (second param) provided.', 'Falsche "temperatur" (zweiter Param) gegeben.', 'Invalid temperature (second param) provided.', NULL, 'true', '2024-08-13 10:39:00', '2024-08-13 10:34:35'),
	(8, 'site', 'temperature inserted.', 'Temperatur wurde gespeichert.', 'Temperature inserted.', NULL, 'true', '2024-08-13 10:39:17', '2024-08-13 10:34:43'),
	(9, 'site', 'invalid "username" (first param) given.', NULL, 'Invalid "username" (first param) given.', NULL, 'true', '2024-08-13 11:59:36', '2024-08-13 11:59:36'),
	(10, 'site', 'invalid "password" (second param) given.', NULL, 'Invalid "password" (second param) given.', NULL, 'true', '2024-08-13 11:59:41', '2024-08-13 11:59:41'),
	(11, 'site', 'invalid "passwordrepeat" (third param) given.', NULL, 'Invalid "passwordRepeat" (third param) given.', NULL, 'true', '2024-08-13 11:59:44', '2024-08-13 11:59:44'),
	(12, 'site', 'passwords do not match.', NULL, 'Passwords do not match.', NULL, 'true', '2024-08-13 11:59:47', '2024-08-13 11:59:47'),
	(13, 'site', 'account created.', NULL, 'Account created.', NULL, 'true', '2024-08-13 11:59:49', '2024-08-13 11:59:49'),
	(14, 'site', 'there was an error while creating a new user', NULL, 'There was an error while creating a new user', NULL, 'true', '2024-08-13 12:05:26', '2024-08-13 12:05:26'),
	(15, 'site', 'username already exists.', NULL, 'Username already exists.', NULL, 'true', '2024-08-13 12:11:21', '2024-08-13 12:11:21'),
	(16, 'site', 'your password is not correct.', NULL, 'Your password is not correct.', NULL, 'true', '2024-08-13 12:20:56', '2024-08-13 12:20:56'),
	(17, 'site', 'welcome back, {username}', 'Willkommen zurück, {username}', 'Welcome back, {username}', NULL, 'true', '2024-10-17 11:52:36', '2024-08-13 12:21:33'),
	(18, 'site', 'the latest version could not be found.', NULL, 'The latest version could not be found.', NULL, 'true', '2024-08-14 11:43:53', '2024-08-14 11:43:53'),
	(19, 'site', 'username not found.', NULL, 'Username not found.', NULL, 'true', '2024-08-14 12:26:27', '2024-08-14 12:26:27'),
	(20, 'site', 'invalid "id" or "username" (first param) given.', NULL, 'Invalid "id" or "username" (first param) given.', NULL, 'true', '2024-08-15 07:46:11', '2024-08-15 07:46:11'),
	(21, 'site', 'invalid user id given.', NULL, 'Invalid user id given.', NULL, 'true', '2024-08-15 11:44:07', '2024-08-15 11:44:07'),
	(22, 'site', 'invalid token provided!', NULL, 'Invalid token provided!', NULL, 'true', '2024-08-15 11:49:24', '2024-08-15 11:49:24'),
	(23, 'site', 'error while updating account.', NULL, 'Error while updating account.', NULL, 'true', '2024-08-15 11:54:33', '2024-08-15 11:54:33'),
	(24, 'site', 'account updated successfully.', NULL, 'Account updated successfully.', NULL, 'true', '2024-08-15 11:55:48', '2024-08-15 11:55:48'),
	(25, 'site', 'no "password" given.', NULL, 'No "password" given.', NULL, 'true', '2024-08-15 11:57:48', '2024-08-15 11:57:48'),
	(26, 'site', 'your account is not active.', NULL, 'Your account is not active.', NULL, 'true', '2024-08-16 10:24:52', '2024-08-16 10:24:52'),
	(27, 'site', 'nothing to update.', NULL, 'Nothing to update.', NULL, 'true', '2024-08-16 10:31:26', '2024-08-16 10:31:26'),
	(28, 'site', 'you can call the following functions. some functions may need an personal access token. you can get this by logging into your account. once you are loggedin, we will add the token for you.', NULL, 'You can call the following functions. Some functions may need an personal access token. You can get this by logging into your account. Once you are loggedin, we will add the token for you.', NULL, 'true', '2024-10-16 09:26:16', '2024-10-16 09:26:16'),
	(29, 'site', 'this is a {test}', NULL, 'This is a {test}', NULL, 'true', '2024-10-17 11:48:36', '2024-10-17 11:48:36'),
	(30, 'site', 'this is another {test}', NULL, 'this is another {test}', NULL, 'true', '2024-10-17 11:51:20', '2024-10-17 11:51:20'),
	(31, 'okay', 'this is another {test}', NULL, 'this is another {test}', NULL, 'true', '2024-10-17 11:51:41', '2024-10-17 11:51:41'),
	(32, 'okay', 'aaaand another {test}', NULL, 'aaaand another {test}', NULL, 'true', '2024-10-17 11:51:48', '2024-10-17 11:51:48'),
	(33, '', 'username not found.', NULL, 'Username not found.', NULL, 'true', '2024-10-17 11:53:25', '2024-10-17 11:53:25'),
	(34, '', 'controller not found.', NULL, 'Controller not found.', NULL, 'true', '2024-10-17 11:53:30', '2024-10-17 11:53:30');

-- Exportiere Struktur von Tabelle temperatur.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `snowflake` varchar(100) DEFAULT NULL,
  `password` varchar(1000) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `avatar_id` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT 1,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `last_seen` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `snowflake` (`snowflake`),
  KEY `users_avatars` (`avatar_id`),
  KEY `users_roles` (`role_id`),
  CONSTRAINT `users_avatars` FOREIGN KEY (`avatar_id`) REFERENCES `images` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='Datenbank für User in Temperaturüberwachung';

-- Exportiere Daten aus Tabelle temperatur.users: ~8 rows (ungefähr)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `snowflake`, `password`, `phone`, `avatar_id`, `role_id`, `active`, `last_seen`, `created_at`, `updated_at`) VALUES
	(1, 'Tim', 'tim', '$2y$10$RXDSPXFNo0s2tyFX6oIUqO1LyRphtkXmQdkiMgrMgyFbbMFfKhBvK', NULL, 1, 2, 'true', '2024-10-17 10:01:29', '2024-10-17 10:07:01', '2024-08-13 12:26:26'),
	(2, 'Alex', 'alex', '$2y$10$ULr9T0RYziJDgQh2cLwHb.FhPiiBt1QB2Wto/v7uHSDcgM2XllStu', NULL, 2, 1, 'true', '2024-08-15 07:59:34', '2024-10-16 13:03:11', '2024-08-15 07:59:34'),
	(3, 'Leander', 'leander', '$2y$10$7K4sFPy9GBePczX0rFCeXueAJUQgMk6LEX0ExEQ7dat4m7LIVMwj2', NULL, 3, 1, 'true', '2024-08-15 11:02:49', '2024-10-16 13:03:13', '2024-08-15 11:02:49'),
	(4, 'Pascal', 'smooth', '$2y$10$UzRrD0rbJQqhvOmj35nP5u1YMCnrcNYrozYWqNRtPl0UPUE7b1fyK', NULL, 4, 1, 'true', '2024-08-16 10:30:24', '2024-10-17 10:08:18', '2024-08-16 10:30:24'),
	(5, 'Administrator', 'administrator', '$2y$10$JJDU1ZfGogSzOhUzH8ZIHOuN/y7j2/WI0UYiOXnWPxrohbUbbrGVu', NULL, 5, 1, 'true', '2024-08-16 10:45:22', '2024-10-16 13:03:21', '2024-08-16 10:45:22'),
	(6, 'le', 'le', '$2y$10$Kn.xj9otH9C11PHyR27.fOGaKEgkju6TZeAW.wmvJ7sN1HAteWCve', NULL, 6, 1, 'true', '2024-08-21 11:09:39', '2024-10-17 10:08:05', '2024-08-21 11:09:39'),
	(7, 'Root', 'root', '$2y$10$/LNlMSyQ6bOFkFvGoJ39x.wd8P870OK4sRx6p./wjjiBJtAu0VEei', NULL, 7, 1, 'true', '2024-10-17 10:02:50', '2024-10-17 11:16:45', '2024-10-17 10:02:50'),
	(8, 'Tim Zapfe', 'timzapfe', '$2y$10$n/ib2T3Z35L./onktoFIhODxiv/vRAZYA.995EvRLwn4A2VC9LfZO', NULL, 8, 1, 'true', '2024-10-17 10:03:43', '2024-10-17 11:16:46', '2024-10-17 10:03:43');

-- Exportiere Struktur von Tabelle temperatur.user_settings
DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `language` enum('en','de','ru') NOT NULL DEFAULT 'en',
  `imperial_system` enum('c','k','f') NOT NULL DEFAULT 'c',
  `darkmode` enum('true','false') NOT NULL DEFAULT 'true',
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_settings_users` (`user_id`),
  CONSTRAINT `user_settings_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='Nutzereinstellungen';

-- Exportiere Daten aus Tabelle temperatur.user_settings: ~3 rows (ungefähr)
DELETE FROM `user_settings`;
INSERT INTO `user_settings` (`id`, `user_id`, `language`, `imperial_system`, `darkmode`, `active`, `updated_at`, `created_at`) VALUES
	(1, 4, 'ru', 'c', 'true', 'true', '2024-10-17 08:49:04', '2024-10-17 08:47:59'),
	(2, 7, 'en', 'c', 'true', 'true', '2024-10-17 10:02:50', '2024-10-17 10:02:50'),
	(3, 8, 'en', 'c', 'true', 'true', '2024-10-17 10:03:43', '2024-10-17 10:03:43');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
