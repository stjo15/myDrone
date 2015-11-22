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
-- Tabellstruktur `drone_rssfeed`
--

CREATE TABLE IF NOT EXISTS `drone_rssfeed` (
`id` int(11) NOT NULL,
  `pagekey` varchar(80) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `language` text,
  `image_title` text,
  `image_url` text,
  `image_link` text,
  `image_width` int(11) DEFAULT NULL,
  `image_height` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `drone_rssfeed`
--
ALTER TABLE `drone_rssfeed`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `drone_rssfeed`
--
ALTER TABLE `drone_rssfeed`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
