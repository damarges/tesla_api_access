-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 27. Mrz 2024 um 16:06
-- Server-Version: 10.6.17-MariaDB-1:10.6.17+maria~ubu2204
-- PHP-Version: 8.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `firstnamelastname_tesla`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ladevorgaenge`
--

CREATE TABLE `ladevorgaenge` (
  `ladeID` smallint(5) UNSIGNED NOT NULL,
  `datumStart` datetime NOT NULL DEFAULT current_timestamp(),
  `datumEnde` datetime DEFAULT NULL,
  `kilometerstand` mediumint(9) UNSIGNED DEFAULT NULL,
  `akkuStart` tinyint(4) UNSIGNED DEFAULT NULL,
  `akkuEnde` tinyint(4) UNSIGNED DEFAULT NULL,
  `kWhAuto` decimal(5,2) UNSIGNED DEFAULT NULL,
  `kWhQuelle` decimal(5,2) UNSIGNED DEFAULT NULL,
  `kosten` decimal(6,2) UNSIGNED DEFAULT NULL,
  `tarifid` tinyint(3) UNSIGNED DEFAULT NULL,
  `type` enum('AC','DC') DEFAULT NULL,
  `kommentar` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Daten für Tabelle `ladevorgaenge`
--

INSERT INTO `ladevorgaenge` (`ladeID`, `datumStart`, `datumEnde`, `kilometerstand`, `akkuStart`, `akkuEnde`, `kWhAuto`, `kWhQuelle`, `kosten`, `tarifid`, `type`, `kommentar`, `active`) VALUES
(2, '2021-12-18 00:00:00', NULL, 70, 0, 99, 12.00, 3.40, 1.29, NULL, 'AC', '', 0),
(3, '2021-12-19 00:00:00', NULL, 0, 0, 99, 12.00, 26.10, 9.93, NULL, 'AC', '', 0),
(4, '2021-12-23 00:00:00', NULL, 0, 0, 99, 12.00, 29.40, 11.17, NULL, 'AC', '', 0),
(5, '2022-01-07 00:00:00', NULL, 0, 5, 99, 12.00, 19.20, 7.30, NULL, 'AC', '', 0),
(6, '2022-01-08 00:00:00', NULL, 392, 31, 99, 12.00, 14.00, 3.92, NULL, 'AC', '', 0),
(7, '2022-01-13 00:00:00', NULL, 512, 4, 99, 12.00, 66.10, 25.13, NULL, 'AC', '', 0),
(8, '2022-01-17 00:00:00', NULL, 614, 60, 99, 12.00, 16.00, 6.09, NULL, 'AC', '', 0),
(9, '2022-01-19 00:00:00', NULL, 708, 47, 99, 12.00, 23.60, 8.97, NULL, 'AC', '', 0),
(10, '2022-01-25 00:00:00', NULL, 835, 32, 99, 12.00, 0.30, 0.00, NULL, 'AC', '3min', 0),
(11, '2022-01-25 00:00:00', NULL, 852, 28, 99, 12.00, 4.90, 1.86, NULL, 'AC', '', 0),
(12, '2022-01-25 00:00:00', NULL, 853, 34, 99, 12.00, 8.00, 3.60, NULL, 'DC', '', 0),
(13, '2022-01-28 00:00:00', NULL, 945, 10, 99, 12.00, 62.50, 23.75, NULL, 'AC', '', 0),
(14, '2022-02-11 00:00:00', NULL, 1123, 21, 99, 12.00, 36.70, 13.93, NULL, 'AC', '', 0),
(15, '2022-02-13 00:00:00', NULL, 1335, 17, 99, 12.00, 4.90, 1.86, NULL, 'AC', '', 0),
(16, '2022-02-13 00:00:00', NULL, 1339, 23, 99, 12.00, 19.90, 7.56, NULL, 'AC', '', 0),
(17, '2022-02-18 00:00:00', NULL, 1426, 26, 99, 12.00, 28.10, 10.68, NULL, 'AC', '', 0),
(18, '2022-02-18 00:00:00', NULL, 1437, 68, 99, 12.00, 23.60, 8.97, NULL, 'AC', '', 0),
(19, '2022-02-19 00:00:00', NULL, 1673, 27, 99, 12.00, 43.00, 0.00, NULL, 'AC', '', 0),
(20, '2022-02-26 00:00:00', NULL, 1907, 32, 99, 12.00, 34.60, 13.15, NULL, 'AC', '', 0),
(21, '2022-02-28 00:00:00', NULL, 1926, 81, 99, 12.00, 2.70, 1.01, NULL, 'AC', '', 0),
(22, '2022-03-12 00:00:00', NULL, 2045, 23, 99, 12.00, 24.00, 9.11, NULL, 'AC', 'Wächter', 0),
(23, '2022-03-12 00:00:00', NULL, 2193, 23, 99, 12.00, 48.50, 18.43, NULL, 'AC', '', 0),
(24, '2022-03-19 00:00:00', NULL, 2386, 32, 99, 12.00, 12.60, 4.77, NULL, 'DC', 'schnell gefahren', 0),
(25, '2022-03-20 00:00:00', NULL, 2443, 24, 99, 12.00, 34.60, 13.16, NULL, 'AC', '', 0),
(26, '2022-03-27 00:00:00', NULL, 2632, 18, 99, 12.00, 49.40, 18.77, NULL, 'AC', '', 0),
(27, '2022-04-02 00:00:00', NULL, 2832, 30, 99, 12.00, 4.70, 1.81, NULL, 'AC', '', 0),
(28, '2022-04-03 00:00:00', NULL, 2905, 3, 99, 12.00, 21.00, 9.87, NULL, 'DC', '', 0),
(29, '2022-04-03 00:00:00', NULL, 2941, 30, 99, 12.00, 35.90, 14.00, NULL, 'AC', '', 0),
(30, '2022-04-07 00:00:00', NULL, 3008, 67, 99, 12.00, 6.50, 2.52, NULL, 'AC', '', 0),
(31, '2022-04-13 00:00:00', NULL, 3128, 41, 99, 12.00, 15.60, 7.64, NULL, 'AC', '', 0),
(32, '2022-04-15 00:00:00', NULL, 3136, 64, 99, 12.00, 23.10, 11.31, NULL, 'AC', '', 0),
(33, '2022-04-29 00:00:00', NULL, 3349, 23, 99, 12.00, 18.60, 7.25, NULL, 'AC', '', 0),
(34, '2022-05-01 00:00:00', NULL, 3422, 27, 99, 12.00, 30.00, 11.70, NULL, 'AC', '', 0),
(35, '2022-05-02 00:00:00', NULL, 3436, 72, 99, 12.00, 18.40, 7.16, NULL, 'AC', '', 0),
(36, '2022-05-09 00:00:00', NULL, 3598, 49, 99, 12.00, 26.00, 10.14, NULL, 'AC', '', 0),
(37, '2022-05-17 00:00:00', NULL, 3714, 52, 99, 12.00, 16.20, 2.00, NULL, 'AC', '', 0),
(38, '2022-06-01 00:00:00', NULL, 3834, 34, 99, 12.00, 40.70, 15.86, NULL, 'AC', 'Wächter', 0),
(39, '2022-06-25 00:00:00', NULL, 4028, 37, 99, 12.00, 38.00, 0.00, NULL, 'AC', 'Hausstrom', 0),
(40, '2022-07-22 00:00:00', NULL, 4298, 14, 99, 12.00, 52.70, 18.97, NULL, 'AC', '', 0),
(41, '2022-07-29 00:00:00', NULL, 4489, 42, 99, 12.00, 35.00, 9.36, NULL, 'AC', '', 0),
(42, '2022-08-01 00:00:00', NULL, 4672, 41, 99, 12.00, 37.60, 18.80, NULL, 'AC', '', 0),
(43, '2022-08-17 00:00:00', NULL, 4940, 22, 99, 12.00, 35.70, 8.93, NULL, 'AC', 'Discount 50%', 0),
(44, '2022-08-28 00:00:00', NULL, 5099, 33, 99, 12.00, 12.50, 5.16, NULL, 'AC', 'Discount 25%', 0),
(45, '2022-09-17 00:00:00', NULL, 5227, 6, 99, 12.00, 58.80, 16.17, NULL, 'AC', 'Discount 50%', 0),
(46, '2022-09-28 00:00:00', NULL, 5430, 37, 99, 12.00, 14.10, 6.34, NULL, 'AC', '', 0),
(47, '2022-09-30 00:00:00', NULL, 5451, 54, 99, 12.00, 15.80, 7.09, NULL, 'AC', '', 0),
(48, '2022-10-07 00:00:00', NULL, 5527, 58, 99, 12.00, 15.70, 7.04, NULL, 'AC', '', 0),
(49, '2022-10-10 00:00:00', NULL, 5769, 18, 99, 12.00, 43.30, 19.48, NULL, 'AC', '', 0),
(50, '2022-10-17 00:00:00', NULL, 5860, 60, 99, 12.00, 25.40, 11.42, NULL, 'AC', '', 0),
(59, '2023-04-20 17:47:49', NULL, 9255, 74, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(60, '2023-04-24 08:19:54', NULL, 9565, 6, 97, 53.00, NULL, NULL, NULL, NULL, NULL, 0),
(63, '2023-05-07 14:59:36', NULL, 9881, 10, 100, 52.09, 56.30, 29.90, 2, 'AC', NULL, 0),
(64, '2023-05-31 08:24:25', NULL, 10218, 11, 99, 52.17, 56.00, 29.74, NULL, 'AC', NULL, 0),
(65, '2023-06-02 15:14:24', NULL, 10291, 79, 100, 12.29, NULL, NULL, NULL, 'AC', NULL, 0),
(66, '2023-06-02 21:38:49', NULL, 10591, 12, 84, 42.01, NULL, NULL, NULL, 'DC', NULL, 0),
(67, '2023-06-02 23:43:35', NULL, 10723, 45, 84, 22.89, NULL, NULL, NULL, 'DC', NULL, 0),
(68, '2023-06-03 12:09:47', NULL, 10918, 23, 99, 44.63, NULL, NULL, NULL, 'DC', NULL, 0),
(69, '2023-06-10 10:27:12', NULL, 11231, 2, 97, 55.50, NULL, NULL, NULL, 'DC', NULL, 0),
(70, '2023-06-10 16:06:41', NULL, 11509, 9, 94, 49.22, NULL, NULL, NULL, 'DC', NULL, 0),
(71, '2023-06-10 22:06:58', NULL, 11742, 29, 69, 23.44, NULL, NULL, NULL, 'DC', NULL, 0),
(73, '2023-06-15 18:37:09', NULL, 11959, 12, 80, 39.27, 41.30, 21.93, NULL, 'AC', NULL, 0),
(74, '2023-06-29 16:15:26', NULL, 12214, 7, 10, 1.45, 1.58, 0.84, NULL, 'AC', NULL, 0),
(75, '2023-06-30 08:48:09', NULL, 12227, 6, 100, 54.68, NULL, NULL, NULL, 'AC', NULL, 0),
(77, '2023-07-01 09:35:14', NULL, 12403, 50, 56, 3.14, 3.76, 2.21, NULL, 'AC', NULL, 0),
(78, '2023-07-02 13:45:56', NULL, 12569, 2, 45, 24.88, 8.70, 4.62, NULL, 'AC', NULL, 0),
(79, '2023-07-07 14:32:55', NULL, 12686, 13, 90, 44.23, 46.60, 24.74, NULL, 'AC', NULL, 0),
(80, '2023-07-10 16:00:14', NULL, 12950, 7, 90, 47.79, NULL, NULL, NULL, 'AC', NULL, 0),
(81, '2023-07-15 12:07:15', NULL, 13194, 15, 51, 20.54, NULL, NULL, NULL, 'AC', NULL, 0),
(82, '2023-07-16 10:56:51', NULL, 13194, 50, 75, 14.14, NULL, NULL, NULL, 'AC', NULL, 0),
(83, '2023-07-16 15:58:19', NULL, 13333, 42, 100, 33.38, NULL, NULL, NULL, 'AC', NULL, 0),
(84, '2023-07-20 13:00:00', NULL, 13580, 28, 86, 33.90, 35.70, 17.90, NULL, 'AC', NULL, 0),
(85, '2023-07-26 16:08:04', NULL, 13833, 15, 90, NULL, NULL, NULL, NULL, 'AC', NULL, 0),
(87, '2023-08-11 15:24:29', NULL, 14090, 15, 81, NULL, NULL, NULL, NULL, 'AC', NULL, 0),
(88, '2023-08-21 17:45:52', NULL, 14167, 57, 81, NULL, NULL, NULL, NULL, 'AC', NULL, 0),
(89, '2023-08-21 20:37:46', '2023-08-22 10:12:48', 14167, 81, 100, 11.14, NULL, NULL, NULL, 'AC', NULL, 0),
(91, '2023-08-04 08:38:07', NULL, 14014, 32, 42, NULL, NULL, NULL, NULL, 'AC', 'API war aus. Manueller Eintrag', 0),
(92, '2023-09-04 14:07:31', '2023-09-04 19:14:10', 14430, 22, 100, 45.28, NULL, NULL, NULL, 'AC', NULL, 0),
(93, '2023-09-10 17:55:01', '2023-09-10 17:58:15', 14772, 6, 16, 5.36, NULL, NULL, NULL, 'DC', NULL, 0),
(94, '2023-09-10 18:20:07', '2023-09-10 21:42:14', 14794, 8, 70, 35.60, NULL, NULL, NULL, 'AC', NULL, 0),
(95, '2023-09-10 21:42:37', '2023-09-11 08:23:14', 14794, 70, 78, 3.94, NULL, NULL, NULL, 'AC', NULL, 0),
(96, '2023-09-24 14:59:27', '2023-09-24 17:22:49', 14827, 67, 100, 19.70, NULL, NULL, NULL, 'AC', NULL, 0),
(97, '2023-10-04 13:28:35', '2023-10-04 15:06:16', 15106, 25, 55, 17.28, NULL, NULL, NULL, 'AC', NULL, 0),
(98, '2023-10-09 11:22:38', '2023-10-09 12:47:55', 15182, 32, 56, 14.26, NULL, NULL, NULL, 'AC', NULL, 0),
(99, '2023-10-09 19:56:11', '2023-10-09 22:11:17', 15225, 44, 79, 19.89, NULL, NULL, NULL, 'AC', NULL, 0),
(100, '2023-10-19 12:44:01', '2023-10-19 16:47:56', 15404, 18, 93, 43.73, NULL, NULL, NULL, 'AC', NULL, 0),
(101, '2023-10-29 15:28:41', '2023-10-29 18:48:40', 15661, 14, 75, 34.95, NULL, NULL, NULL, 'AC', NULL, 0),
(102, '2023-11-02 15:37:58', '2023-11-02 16:59:22', 15766, 46, 70, 14.26, NULL, NULL, NULL, 'AC', NULL, 0),
(103, '2023-11-03 12:04:01', '2023-11-03 15:25:46', 15856, 44, 100, 32.71, NULL, NULL, NULL, 'AC', NULL, 0),
(104, '2023-11-09 12:26:59', '2023-11-09 15:18:22', 16066, 39, 91, 29.84, NULL, NULL, NULL, 'AC', NULL, 0),
(105, '2023-11-17 12:15:06', '2023-11-17 13:22:27', 16200, 45, 65, 11.77, NULL, NULL, NULL, 'AC', NULL, 0),
(106, '2023-11-27 17:05:46', '2023-11-27 20:34:13', 16328, 22, 81, 33.91, NULL, NULL, NULL, 'AC', NULL, 0),
(107, '2023-12-13 13:23:02', '2023-12-13 13:49:35', 16501, 14, 22, 4.19, NULL, NULL, NULL, 'AC', NULL, 0),
(108, '2023-12-14 12:16:42', '2023-12-14 13:35:03', 16511, 18, 41, 12.84, NULL, NULL, NULL, 'AC', NULL, 0),
(109, '2023-12-21 19:13:55', '2023-12-22 10:37:43', 16594, 9, 100, 51.82, NULL, NULL, NULL, 'AC', NULL, 0),
(110, '2024-01-02 12:02:09', '2024-01-02 16:35:33', 16752, 50, 90, 22.91, NULL, NULL, NULL, 'AC', NULL, 0),
(111, '2024-01-11 06:00:38', '2024-01-11 18:05:03', 16908, 30, 80, 28.27, NULL, NULL, NULL, 'AC', NULL, 0),
(112, '2024-01-21 12:00:14', '2024-01-21 16:21:17', 17058, 15, 92, 44.12, NULL, NULL, NULL, 'AC', NULL, 0),
(113, '2024-02-04 18:00:00', '2024-02-05 10:23:04', 17307, 4, 100, 55.05, NULL, NULL, NULL, 'AC', NULL, 0),
(115, '2024-02-21 09:10:38', '2024-02-21 12:52:33', 17635, 10, 79, 39.52, NULL, NULL, NULL, 'AC', NULL, 0),
(116, '2024-02-26 10:26:29', '2024-02-26 14:45:58', 17841, 19, 90, 40.84, NULL, NULL, NULL, 'AC', NULL, 0),
(118, '2024-03-01 08:23:47', '2024-03-01 10:58:49', 17934, 61, 100, 22.51, NULL, NULL, NULL, 'AC', NULL, 0),
(119, '2024-03-01 15:21:24', '2024-03-01 15:36:42', 18244, 9, 58, 28.27, NULL, NULL, NULL, 'DC', NULL, 0),
(120, '2024-03-02 09:42:09', '2024-03-02 13:17:33', 18409, 13, 78, 37.17, NULL, NULL, NULL, 'AC', NULL, 0),
(121, '2024-03-02 20:26:40', '2024-03-03 10:54:22', 18415, 75, 100, 14.38, NULL, NULL, NULL, 'AC', NULL, 0),
(122, '2024-03-03 15:40:31', '2024-03-03 15:55:09', 18713, 2, 50, 27.50, NULL, NULL, NULL, 'DC', NULL, 0),
(123, '2024-03-04 15:11:19', '2024-03-04 18:42:52', 18824, 13, 77, 36.40, NULL, NULL, NULL, 'AC', NULL, 0),
(125, '2024-03-08 13:18:15', '2024-03-08 14:05:05', 18937, 43, 55, 7.48, NULL, NULL, NULL, 'AC', NULL, 0),
(126, '2024-03-13 14:29:14', '2024-03-13 18:42:36', 19088, 11, 90, 45.03, NULL, NULL, NULL, 'AC', NULL, 0),
(127, '2024-03-19 15:31:04', '2024-03-19 16:45:26', 19210, 58, 80, 12.82, NULL, NULL, NULL, 'AC', NULL, 0),
(128, '2024-03-25 07:31:53', '2024-03-25 08:56:40', 19415, 20, 47, 15.06, NULL, NULL, NULL, 'AC', NULL, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `provider`
--

CREATE TABLE `provider` (
  `providerid` tinyint(3) UNSIGNED NOT NULL,
  `providername` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Daten für Tabelle `provider`
--

INSERT INTO `provider` (`providerid`, `providername`) VALUES
(1, 'Bonnet'),
(2, 'ENBW');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tarif`
--

CREATE TABLE `tarif` (
  `tarifid` tinyint(3) UNSIGNED NOT NULL,
  `providerid` tinyint(3) UNSIGNED NOT NULL,
  `tarifname` varchar(255) NOT NULL,
  `ac-preis` decimal(4,2) DEFAULT NULL,
  `dc-preis` decimal(4,2) DEFAULT NULL,
  `validfrom` datetime NOT NULL DEFAULT current_timestamp(),
  `validtill` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Daten für Tabelle `tarif`
--

INSERT INTO `tarif` (`tarifid`, `providerid`, `tarifname`, `ac-preis`, `dc-preis`, `validfrom`, `validtill`) VALUES
(1, 1, 'Pay as you go', 0.59, NULL, '2023-05-11 17:21:07', '2024-01-01 00:00:00'),
(2, 1, 'Light Boost', 0.53, NULL, '2023-05-11 17:22:15', '2024-01-01 00:00:00');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ladevorgaenge`
--
ALTER TABLE `ladevorgaenge`
  ADD PRIMARY KEY (`ladeID`),
  ADD KEY `tarifid` (`tarifid`);

--
-- Indizes für die Tabelle `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`providerid`);

--
-- Indizes für die Tabelle `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`tarifid`),
  ADD KEY `providerid` (`providerid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ladevorgaenge`
--
ALTER TABLE `ladevorgaenge`
  MODIFY `ladeID` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT für Tabelle `provider`
--
ALTER TABLE `provider`
  MODIFY `providerid` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `tarif`
--
ALTER TABLE `tarif`
  MODIFY `tarifid` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ladevorgaenge`
--
ALTER TABLE `ladevorgaenge`
  ADD CONSTRAINT `ladevorgaenge_ibfk_1` FOREIGN KEY (`tarifid`) REFERENCES `tarif` (`tarifid`);

--
-- Constraints der Tabelle `tarif`
--
ALTER TABLE `tarif`
  ADD CONSTRAINT `tarif_ibfk_1` FOREIGN KEY (`providerid`) REFERENCES `provider` (`providerid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
