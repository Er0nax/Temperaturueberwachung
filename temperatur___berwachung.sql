-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 12. Aug 2024 um 10:38
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `temperatur_überwachung`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `api_tokens`
--

CREATE TABLE `api_tokens` (
  `ID` int(11) NOT NULL,
  `IP` varchar(100) NOT NULL,
  `Token` varchar(20) NOT NULL,
  `Uses` int(11) NOT NULL DEFAULT 0,
  `active` varchar(5) NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabelle für Token';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `images`
--

CREATE TABLE `images` (
  `ID` int(11) NOT NULL,
  `src` varchar(255) NOT NULL,
  `active` varchar(5) NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pages`
--

CREATE TABLE `pages` (
  `ID` int(11) NOT NULL,
  `index` int(11) NOT NULL,
  `showAlways` varchar(5) NOT NULL DEFAULT 'false',
  `hideInHeader` varchar(5) NOT NULL DEFAULT 'false',
  `hideInFooter` varchar(5) NOT NULL DEFAULT 'false',
  `mustBeLoggedIn` varchar(5) NOT NULL DEFAULT 'false',
  `active` varchar(5) NOT NULL DEFAULT 'true',
  `color` varchar(7) NOT NULL DEFAULT '#fff',
  `icon` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `subline` varchar(500) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='K.a wofür aber für die Seiten IG';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sensors`
--

CREATE TABLE `sensors` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Color` varchar(7) DEFAULT '#fff',
  `Activ` varchar(5) NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Eintrag für die Sensoren';

--
-- Daten für Tabelle `sensors`
--

INSERT INTO `sensors` (`ID`, `Name`, `Color`, `Activ`, `updated_at`, `created_at`) VALUES
(1, 'Sensor1', '#fff', 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
(2, 'Sensor2', '#fff', 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
(3, 'Sensor3', '#fff', 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `temperatures`
--

CREATE TABLE `temperatures` (
  `ID` int(11) NOT NULL,
  `sensor_id` int(11) NOT NULL,
  `temperatur` float NOT NULL,
  `active` varchar(5) NOT NULL DEFAULT 'true',
  `updatetd_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Aufnahme der Temperatur';

--
-- Daten für Tabelle `temperatures`
--

INSERT INTO `temperatures` (`ID`, `sensor_id`, `temperatur`, `active`, `updatetd_at`, `created_at`) VALUES
(1, 1, 23, 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
(2, 2, 24, 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
(3, 1, 13, 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
(4, 2, 30, 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
(5, 1, 23, 'true', '2024-08-12 00:00:01', '2024-08-12 00:00:00'),
(6, 2, 14, 'true', '2024-08-12 00:00:01', '2024-08-12 00:00:00'),
(7, 3, 23, 'true', '2024-08-12 00:00:00', '2024-08-12 00:00:00'),
(8, 3, 24, 'true', '2024-08-12 00:00:01', '2024-08-12 00:00:00'),
(9, 3, 25, 'true', '2024-08-12 00:00:02', '2024-08-12 00:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `translations`
--

CREATE TABLE `translations` (
  `ID` int(11) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'site',
  `value` varchar(2000) DEFAULT NULL,
  `de` varchar(2000) DEFAULT NULL,
  `en` varchar(2000) DEFAULT NULL,
  `active` varchar(5) NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `VName` varchar(100) NOT NULL,
  `Password` varchar(1000) NOT NULL,
  `idAvatar` int(11) NOT NULL,
  `IdRolle` int(11) NOT NULL DEFAULT 1,
  `Activ` varchar(5) NOT NULL DEFAULT 'true',
  `Last_seen` datetime NOT NULL,
  `Created_at` datetime NOT NULL,
  `Updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Datenbank für User in Temperaturüberwachung';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_settings`
--

CREATE TABLE `user_settings` (
  `ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'en',
  `active` varchar(5) NOT NULL DEFAULT 'true',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Nutzereinstellungen';

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `api_tokens`
--
ALTER TABLE `api_tokens`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `sensors`
--
ALTER TABLE `sensors`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `temperatures`
--
ALTER TABLE `temperatures`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `api_tokens`
--
ALTER TABLE `api_tokens`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `images`
--
ALTER TABLE `images`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `pages`
--
ALTER TABLE `pages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `sensors`
--
ALTER TABLE `sensors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `temperatures`
--
ALTER TABLE `temperatures`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `translations`
--
ALTER TABLE `translations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
