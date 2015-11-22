-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 22 nov 2015 kl 23:17
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
-- Tabellstruktur `drone_user`
--

CREATE TABLE IF NOT EXISTS `drone_user` (
`id` int(11) NOT NULL,
  `acronym` varchar(20) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `xp` int(200) NOT NULL,
  `web` varchar(200) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `active` datetime DEFAULT NULL,
  `gravatar` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `drone_user`
--

INSERT INTO `drone_user` (`id`, `acronym`, `email`, `name`, `xp`, `web`, `password`, `created`, `updated`, `deleted`, `active`, `gravatar`) VALUES
(1, 'admin', 'admin@dbwebb.se', 'Administratör', 0, '', 'secret', '2015-11-15 16:24:27', '2015-11-15 16:24:27', NULL, '2015-10-26 12:55:13', 'http://www.gravatar.com/avatar/81c4568c5b5d51d31cd93aa357f1ad1b.jpg');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `drone_user`
--
ALTER TABLE `drone_user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `acronym` (`acronym`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `drone_user`
--
ALTER TABLE `drone_user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
