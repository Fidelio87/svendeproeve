-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2017 at 10:04 AM
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
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `album_id` mediumint(8) UNSIGNED NOT NULL,
  `album_kunstner` varchar(64) NOT NULL,
  `album_titel` varchar(128) NOT NULL,
  `album_oprettet` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_genre_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `fk_pris_id` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `anmeldelser`
--

CREATE TABLE `anmeldelser` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `overskrift` mediumtext NOT NULL,
  `tekst` text NOT NULL,
  `link` varchar(255) DEFAULT '#',
  `oprettet` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_bruger_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `fk_album_id` mediumint(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brugere`
--

CREATE TABLE `brugere` (
  `bruger_id` mediumint(8) UNSIGNED NOT NULL,
  `bruger_status` tinyint(1) UNSIGNED DEFAULT '1',
  `bruger_oprettet` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bruger_brugernavn` varchar(50) NOT NULL,
  `bruger_beskrivelse` text,
  `bruger_password` varchar(255) NOT NULL,
  `bruger_img` varchar(255) DEFAULT NULL,
  `fk_rolle_id` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brugere`
--

INSERT INTO `brugere` (`bruger_id`, `bruger_status`, `bruger_oprettet`, `bruger_brugernavn`, `bruger_beskrivelse`, `bruger_password`, `bruger_img`, `fk_rolle_id`) VALUES
(1, 1, '2017-10-02 19:10:51', 'admin', 'lorem ipsum dolor sit amet', '$2y$10$1X9ITA0jvKlr9ZeY9QWnVu5EpIJ02S94/TTLbYelGNOgnvWaCKpm.', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `genrer`
--

CREATE TABLE `genrer` (
  `genre_id` mediumint(8) UNSIGNED NOT NULL,
  `genre_navn` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genrer`
--

INSERT INTO `genrer` (`genre_id`, `genre_navn`) VALUES
(1, 'Pop'),
(2, 'Rock'),
(3, 'Dansk'),
(4, 'Folk'),
(5, 'Latin'),
(6, 'Jazz'),
(7, 'Hiphop');

-- --------------------------------------------------------

--
-- Table structure for table `kontakt`
--

CREATE TABLE `kontakt` (
  `kontakt_id` int(10) UNSIGNED NOT NULL,
  `kontakt_navn` varchar(64) NOT NULL,
  `kontakt_adresse` varchar(128) NOT NULL,
  `kontakt_tlf` smallint(10) UNSIGNED NOT NULL,
  `kontakt_email` varchar(128) NOT NULL,
  `kontakt_besked` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `konti`
--

CREATE TABLE `konti` (
  `konto_id` mediumint(8) UNSIGNED NOT NULL,
  `konto_saldo` tinyint(128) UNSIGNED NOT NULL,
  `fk_bruger_id` mediumint(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(10) UNSIGNED NOT NULL,
  `log_tid` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_beskrivelse` text NOT NULL,
  `fk_bruger_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `fk_log_type` tinyint(3) UNSIGNED DEFAULT NULL
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
-- Table structure for table `priser`
--

CREATE TABLE `priser` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `vaerdi` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `priser`
--

INSERT INTO `priser` (`id`, `vaerdi`) VALUES
(1, 50),
(2, 100),
(3, 150);

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
(1, 'bruger', 100),
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
  `fk_side_include_id` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sider`
--

INSERT INTO `sider` (`side_id`, `side_status`, `side_url`, `side_nav_sortering`, `side_nav_visning`, `side_nav_label`, `side_titel`, `side_indhold`, `fk_side_include_id`) VALUES
(1, 1, '', 1, 1, 'Forside', 'Velkommen Hos DJ Grunk.', 'Her hos DJ Grunk kan du være med til at bestemme hvilken musik der skal indkøbes til Musikbiblioteket. Hvis du ikke allerede er oprettet som bruger så skynd dig at blive det. Så får du nemlig også 1500 Grunker som du kan bruge til at “købe” for i musikbutikken.					\r\nDe cd’er der bliver købt flest gange havner på hitlisten her til venstre og hvis du er med til at få dine favoritter på hitlisten er der større chance for at du hurtigere kan låne dem på Musikbiblioteket.					\r\nDu kan også lave dine egne anmeldelser, så andre brugere kan se hvilken musik der er på toppen i øjeblikket.					\r\nKik dig omkring og vær med til at sætte liv i kludene.DJ Grunk.					\r\n', 1),
(2, 1, 'musikbutikken', 2, 1, 'Musikbutikken', 'Musikbutikken', NULL, 2),
(3, 1, 'anmeldelser', 3, 1, 'Anmeldelser', 'Anmeldelser af musik', NULL, 3),
(4, 1, 'profil', 4, 1, 'Min Profil', 'Din profil', NULL, 4),
(5, 1, 'kontakt', 5, 1, 'Kontakt', 'Kontakt DJ Grunk og hans venner', 'Hvis du har spørgsmål eller til DJ Grunk eller en af hans venner på biblioteket er du velkommen til at komme forbi. Vi har åbent på biblioteket alle hver- og lørdage. 					\r\nDu kan ogås ringe eller skrive, eller brug formularen nederst til højre så skal vi nok sørge for at DJ Grunk får din besked.					\r\n', 5),
(6, 1, 'opret-profil', 11, 0, NULL, 'Opret en profil', '', 6);

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
(1, 'forside', 'velkommen.php'),
(2, 'musikbutikken', 'musikbutik.php'),
(3, 'anmeldelser', 'anmeldelser.php'),
(4, 'profil', 'profil.php'),
(5, 'kontakt', 'kontakt.php'),
(6, 'opret bruger', 'opret-profil.php');

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

-- --------------------------------------------------------

--
-- Table structure for table `transaktioner`
--

CREATE TABLE `transaktioner` (
  `id` int(10) UNSIGNED NOT NULL,
  `fk_konto_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `fk_album_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adresser`
--
ALTER TABLE `adresser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `fk_genre_id` (`fk_genre_id`),
  ADD KEY `fk_pris_id` (`fk_pris_id`);

--
-- Indexes for table `anmeldelser`
--
ALTER TABLE `anmeldelser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_album_id` (`fk_album_id`),
  ADD KEY `fk_bruger_id` (`fk_bruger_id`);

--
-- Indexes for table `brugere`
--
ALTER TABLE `brugere`
  ADD PRIMARY KEY (`bruger_id`),
  ADD UNIQUE KEY `bruger_brugernavn` (`bruger_brugernavn`),
  ADD KEY `fk_rolle_id` (`fk_rolle_id`);

--
-- Indexes for table `genrer`
--
ALTER TABLE `genrer`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `kontakt`
--
ALTER TABLE `kontakt`
  ADD PRIMARY KEY (`kontakt_id`);

--
-- Indexes for table `konti`
--
ALTER TABLE `konti`
  ADD PRIMARY KEY (`konto_id`),
  ADD KEY `fk_bruger_id` (`fk_bruger_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `logs_ibfk_1` (`fk_log_type`),
  ADD KEY `fk_bruger_id` (`fk_bruger_id`);

--
-- Indexes for table `log_typer`
--
ALTER TABLE `log_typer`
  ADD PRIMARY KEY (`log_type_id`);

--
-- Indexes for table `priser`
--
ALTER TABLE `priser`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `transaktioner`
--
ALTER TABLE `transaktioner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_album_id` (`fk_album_id`),
  ADD KEY `fk_konto_id` (`fk_konto_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adresser`
--
ALTER TABLE `adresser`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `anmeldelser`
--
ALTER TABLE `anmeldelser`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `brugere`
--
ALTER TABLE `brugere`
  MODIFY `bruger_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `genrer`
--
ALTER TABLE `genrer`
  MODIFY `genre_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `kontakt`
--
ALTER TABLE `kontakt`
  MODIFY `kontakt_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `konti`
--
ALTER TABLE `konti`
  MODIFY `konto_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `priser`
--
ALTER TABLE `priser`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `roller`
--
ALTER TABLE `roller`
  MODIFY `rolle_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sider`
--
ALTER TABLE `sider`
  MODIFY `side_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `side_includes`
--
ALTER TABLE `side_includes`
  MODIFY `side_include_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tidspunkter`
--
ALTER TABLE `tidspunkter`
  MODIFY `tidspunkt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `transaktioner`
--
ALTER TABLE `transaktioner`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`fk_genre_id`) REFERENCES `genrer` (`genre_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `albums_ibfk_2` FOREIGN KEY (`fk_pris_id`) REFERENCES `priser` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `anmeldelser`
--
ALTER TABLE `anmeldelser`
  ADD CONSTRAINT `anmeldelser_ibfk_1` FOREIGN KEY (`fk_album_id`) REFERENCES `albums` (`album_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `anmeldelser_ibfk_2` FOREIGN KEY (`fk_bruger_id`) REFERENCES `brugere` (`bruger_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `brugere`
--
ALTER TABLE `brugere`
  ADD CONSTRAINT `brugere_ibfk_1` FOREIGN KEY (`fk_rolle_id`) REFERENCES `roller` (`rolle_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `konti`
--
ALTER TABLE `konti`
  ADD CONSTRAINT `konti_ibfk_1` FOREIGN KEY (`fk_bruger_id`) REFERENCES `brugere` (`bruger_id`) ON UPDATE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`fk_log_type`) REFERENCES `log_typer` (`log_type_id`),
  ADD CONSTRAINT `logs_ibfk_2` FOREIGN KEY (`fk_bruger_id`) REFERENCES `brugere` (`bruger_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `sider`
--
ALTER TABLE `sider`
  ADD CONSTRAINT `sider_ibfk_1` FOREIGN KEY (`fk_side_include_id`) REFERENCES `side_includes` (`side_include_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transaktioner`
--
ALTER TABLE `transaktioner`
  ADD CONSTRAINT `transaktioner_ibfk_1` FOREIGN KEY (`fk_album_id`) REFERENCES `albums` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaktioner_ibfk_2` FOREIGN KEY (`fk_konto_id`) REFERENCES `konti` (`konto_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
