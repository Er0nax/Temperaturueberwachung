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
  `ip` varchar(100) NOT NULL,
  `token` varchar(20) NOT NULL,
  `uses` int(11) NOT NULL DEFAULT 0,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabelle für Token';

-- Exportiere Daten aus Tabelle temperatur.api_tokens: ~0 rows (ungefähr)
DELETE FROM `api_tokens`;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.applications: ~1 rows (ungefähr)
DELETE FROM `applications`;
INSERT INTO `applications` (`id`, `name`, `version`, `downloads`, `active`, `updated_at`, `created_at`) VALUES
	(1, 'Syntax-Sabberer', 'v.1.0.0', 1, 'true', '2024-08-13 07:13:52', '2024-08-13 06:59:34');

-- Exportiere Struktur von Tabelle temperatur.images
DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `src` varchar(255) NOT NULL,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.images: ~0 rows (ungefähr)
DELETE FROM `images`;

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
	(1, 'Sensor1', '#fff', 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
	(2, 'Sensor2', '#fff', 'false', '2024-08-12 09:38:55', '2024-08-12 00:00:00'),
	(3, 'Sensor3', '#fff', 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='Aufnahme der Temperatur';

-- Exportiere Daten aus Tabelle temperatur.temperatures: ~9 rows (ungefähr)
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
	(9, 3, 25, 'true', '2024-08-12 00:00:02', '2024-08-12 00:00:00');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle temperatur.translations: ~0 rows (ungefähr)
DELETE FROM `translations`;

-- Exportiere Struktur von Tabelle temperatur.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `avatar_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 1,
  `active` enum('true','false') NOT NULL DEFAULT 'true',
  `last_seen` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Datenbank für User in Temperaturüberwachung';

-- Exportiere Daten aus Tabelle temperatur.user: ~0 rows (ungefähr)
DELETE FROM `user`;

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
