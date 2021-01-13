-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 13. Jan 2021 um 15:58
-- Server-Version: 10.4.14-MariaDB
-- PHP-Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `happyplace`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `apprentices`
--

CREATE TABLE `apprentices` (
  `id` int(11) NOT NULL,
  `prename` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `place_id` int(10) UNSIGNED NOT NULL,
  `markers_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `apprentices`
--

INSERT INTO `apprentices` (`id`, `prename`, `lastname`, `place_id`, `markers_id`) VALUES
(61, 'Tobias', 'Bertschi', 1, 1),
(62, 'Dimitrios', 'Lanaras', 2, 2),
(63, 'Yves', 'Huber', 3, 3),
(64, 'Severin', 'Machaz', 4, 4),
(65, 'Maurin', 'Schucan', 5, 5),
(66, 'Alex', 'Smolders', 6, 6),
(67, 'Andrew', 'Longe', 7, 7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT '#FFFFFF',
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `markers`
--

INSERT INTO `markers` (`id`, `icon`, `color`, `description`) VALUES
(1, NULL, '#FFFFFF', NULL),
(2, NULL, '#FFFFFF', NULL),
(3, NULL, '#FFFFFF', NULL),
(4, NULL, '#FFFFFF', NULL),
(5, NULL, '#FFFFFF', NULL),
(6, NULL, '#FFFFFF', NULL),
(7, NULL, '#FFFFFF', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `places`
--

CREATE TABLE `places` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `places`
--

INSERT INTO `places` (`id`, `name`, `latitude`, `longitude`) VALUES
(1, 'Niederglatt', '47.490152785384154', ' 8.497734158564215'),
(2, 'Stäfa', '47.23923550513441', ' 8.70953150644875'),
(3, 'Urdorf', '47.381825425772966 ', '8.42103321287224'),
(4, 'Weiningen', '47.421145522432646 ', '8.43839884129973'),
(5, 'Uetikon am See', '47.2675954625272', ' 8.676715922199275'),
(6, 'Adliswil', '47.312995094785634', ' 8.523242354779939'),
(7, 'Kloten', '47.458497553099185', ' 8.58662490845184');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `prename` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `username` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `prename`, `lastname`, `password`, `username`) VALUES
(1, 'Tobias', 'Bertschi', 'tobber', 'tobber');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `apprentices`
--
ALTER TABLE `apprentices`
  ADD PRIMARY KEY (`id`,`place_id`,`markers_id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_apprentices_place_idx` (`place_id`),
  ADD KEY `fk_apprentices_markers1_idx` (`markers_id`);

--
-- Indizes für die Tabelle `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `icon_UNIQUE` (`icon`);

--
-- Indizes für die Tabelle `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `apprentices`
--
ALTER TABLE `apprentices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT für Tabelle `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `apprentices`
--
ALTER TABLE `apprentices`
  ADD CONSTRAINT `fk_apprentices_markers1` FOREIGN KEY (`markers_id`) REFERENCES `markers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_apprentices_place` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
