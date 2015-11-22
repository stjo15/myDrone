-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 22 nov 2015 kl 20:59
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
-- Tabellstruktur `drone_question`
--

CREATE TABLE IF NOT EXISTS `drone_question` (
`id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `tag` varchar(80) NOT NULL,
  `tagslug` varchar(80) NOT NULL,
  `mail` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  `userid` int(11) NOT NULL,
  `answers` int(20) NOT NULL,
  `comments` int(20) NOT NULL,
  `web` varchar(200) NOT NULL,
  `gravatar` varchar(200) NOT NULL,
  `ip` varchar(80) NOT NULL,
  `updated` datetime NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `drone_question`
--

INSERT INTO `drone_question` (`id`, `title`, `content`, `tag`, `tagslug`, `mail`, `name`, `userid`, `answers`, `comments`, `web`, `gravatar`, `ip`, `updated`, `timestamp`) VALUES
(13, 'Testfråga', 'Testar fråga för XP!', 'Design,Lagar och regler', 'design,lagar-och-regler', 'stalle.johansson@gmail.com', 'Staffan', 6, 2, 1, 'www.gudsforsamling.se', 'http://www.gravatar.com/avatar/12a91909d4b7acb466cac07a76e0fc51.jpg', '127.0.0.1', '0000-00-00 00:00:00', '2015-11-20 23:30:42'),
(14, 'Testfråga nummer 2', 'Testar igen för att dubbelkolla allt', 'Programmering,Flygning,Inköp,Design,Lagar och regler,Användning', 'programmering,flygning,inkop,design,lagar-och-regler,anvandning', 'stalle.johansson@gmail.com', 'Staffan', 6, 2, 2, 'www.gudsforsamling.se', 'http://www.gravatar.com/avatar/12a91909d4b7acb466cac07a76e0fc51.jpg', '::1', '0000-00-00 00:00:00', '2015-11-22 19:13:50');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `drone_question`
--
ALTER TABLE `drone_question`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `drone_question`
--
ALTER TABLE `drone_question`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
