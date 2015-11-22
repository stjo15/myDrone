-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 22 nov 2015 kl 21:00
-- Serverversion: 5.6.21
-- PHP-version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `mesidan`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `drone_tag`
--

CREATE TABLE IF NOT EXISTS `drone_tag` (
`id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `slug` varchar(80) NOT NULL,
  `questions` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `drone_tag`
--

INSERT INTO `drone_tag` (`id`, `name`, `slug`, `questions`) VALUES
(1, 'Programmering', 'programmering', 1),
(2, 'Flygning', 'flygning', 1),
(3, 'Inköp', 'inkop', 1),
(4, 'Design', 'design', 2),
(5, 'Lagar och regler', 'lagar-och-regler', 2),
(6, 'Användning', 'anvandning', 1),
(7, 'Allmänt', 'allmant', 0);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `drone_tag`
--
ALTER TABLE `drone_tag`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `drone_tag`
--
ALTER TABLE `drone_tag`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
