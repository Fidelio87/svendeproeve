-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2017 at 10:57 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `svendeproeve`
--

-- --------------------------------------------------------

--
-- Table structure for table `adresser`
--

CREATE TABLE `adresser` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `navn` varchar(256) NOT NULL,
  `gade` varchar(128) NOT NULL,
  `husnr` smallint(4) NOT NULL,
  `postnr` smallint(4) NOT NULL,
  `bynavn` varchar(128) NOT NULL,
  `tlf` int(12) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adresser`
--

INSERT INTO `adresser` (`id`, `navn`, `gade`, `husnr`, `postnr`, `bynavn`, `tlf`, `email`) VALUES
(1, 'Skørby Bibliotek', 'Park Allé', 335, 2100, 'København Ø', 67912801, 'info@skoerby-bibliotek.dk');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(10) UNSIGNED NOT NULL,
  `log_tid` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_beskrivelse` text NOT NULL,
  `log_min_nivau` smallint(4) UNSIGNED NOT NULL,
  `fk_bruger_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `fk_log_type` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_typer`
--

CREATE TABLE `log_typer` (
  `log_type_id` tinyint(3) UNSIGNED NOT NULL,
  `log_type_navn` varchar(45) NOT NULL,
  `log_type_css` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `log_typer`
--

INSERT INTO `log_typer` (`log_type_id`, `log_type_navn`, `log_type_css`) VALUES
(1, 'opret', 'success'),
(2, 'opdater', 'warning'),
(3, 'slet', 'danger'),
(4, 'info', 'info');

-- --------------------------------------------------------

--
-- Table structure for table `roller`
--

CREATE TABLE `roller` (
  `rolle_id` tinyint(3) UNSIGNED NOT NULL,
  `rolle_navn` varchar(25) NOT NULL,
  `rolle_niveau` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roller`
--

INSERT INTO `roller` (`rolle_id`, `rolle_navn`, `rolle_niveau`) VALUES
(1, 'journalist', 200),
(2, 'admin', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `sider`
--

CREATE TABLE `sider` (
  `side_id` tinyint(3) UNSIGNED NOT NULL,
  `side_status` tinyint(1) UNSIGNED NOT NULL,
  `side_url` varchar(128) NOT NULL,
  `side_nav_sortering` tinyint(3) UNSIGNED NOT NULL,
  `side_nav_visning` tinyint(1) UNSIGNED NOT NULL,
  `side_nav_label` varchar(50) DEFAULT NULL,
  `side_titel` varchar(55) NOT NULL,
  `side_indhold` text,
  `fk_kategori_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `fk_side_include_id` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `side_includes`
--

CREATE TABLE `side_includes` (
  `side_include_id` tinyint(3) UNSIGNED NOT NULL,
  `side_include_navn` varchar(50) NOT NULL,
  `side_include_filnavn` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `side_includes`
--

INSERT INTO `side_includes` (`side_include_id`, `side_include_navn`, `side_include_filnavn`) VALUES
(1, 'velkommen', 'velkommen.php'),
(2, 'artikler', 'artikler.php'),
(3, 'redaktion', 'redaktion.php'),
(4, 'kontakt', 'kontakt.php'),
(5, 'artikel', 'artikel.php'),
(6, 'sponsor-info', 'sponsor-info.php'),
(7, 'tilmeldinger', 'tilmeldinger.php'),
(8, 'soegning', 'soegning.php');

-- --------------------------------------------------------

--
-- Table structure for table `tidspunkter`
--

CREATE TABLE `tidspunkter` (
  `tidspunkt_id` int(11) NOT NULL,
  `tidspunkt_ugedag` enum('Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag','Søndag') CHARACTER SET utf8 NOT NULL,
  `tidspunkt_tid_fra` time NOT NULL,
  `tidspunkt_tid_til` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `tidspunkter`
--

INSERT INTO `tidspunkter` (`tidspunkt_id`, `tidspunkt_ugedag`, `tidspunkt_tid_fra`, `tidspunkt_tid_til`) VALUES
(6, 'Mandag', '10:00:00', '18:00:00'),
(7, 'Tirsdag', '10:00:00', '18:00:00'),
(8, 'Onsdag', '10:00:00', '18:00:00'),
(9, 'Torsdag', '10:00:00', '18:00:00'),
(10, 'Fredag', '10:00:00', '18:00:00'),
(11, 'Lørdag', '09:00:00', '13:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adresser`
--
ALTER TABLE `adresser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_bruger_id` (`fk_bruger_id`),
  ADD KEY `fk_log_type` (`fk_log_type`);

--
-- Indexes for table `log_typer`
--
ALTER TABLE `log_typer`
  ADD PRIMARY KEY (`log_type_id`);

--
-- Indexes for table `roller`
--
ALTER TABLE `roller`
  ADD PRIMARY KEY (`rolle_id`);

--
-- Indexes for table `sider`
--
ALTER TABLE `sider`
  ADD PRIMARY KEY (`side_id`),
  ADD KEY `fk_kategori_id` (`fk_kategori_id`),
  ADD KEY `sider_ibfk_1` (`fk_side_include_id`);

--
-- Indexes for table `side_includes`
--
ALTER TABLE `side_includes`
  ADD PRIMARY KEY (`side_include_id`);

--
-- Indexes for table `tidspunkter`
--
ALTER TABLE `tidspunkter`
  ADD PRIMARY KEY (`tidspunkt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adresser`
--
ALTER TABLE `adresser`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log_typer`
--
ALTER TABLE `log_typer`
  MODIFY `log_type_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `roller`
--
ALTER TABLE `roller`
  MODIFY `rolle_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sider`
--
ALTER TABLE `sider`
  MODIFY `side_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `side_includes`
--
ALTER TABLE `side_includes`
  MODIFY `side_include_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tidspunkter`
--
ALTER TABLE `tidspunkter`
  MODIFY `tidspunkt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
