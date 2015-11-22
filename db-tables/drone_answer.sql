-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 22 nov 2015 kl 20:58
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
-- Tabellstruktur `drone_answer`
--

CREATE TABLE IF NOT EXISTS `drone_answer` (
`id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `tag` varchar(80) NOT NULL,
  `questionid` int(11) NOT NULL,
  `mail` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  `userid` int(11) NOT NULL,
  `pagekey` varchar(80) NOT NULL,
  `web` varchar(200) NOT NULL,
  `gravatar` varchar(200) NOT NULL,
  `ip` varchar(80) NOT NULL,
  `updated` datetime NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `drone_answer`
--

INSERT INTO `drone_answer` (`id`, `title`, `content`, `tag`, `questionid`, `mail`, `name`, `userid`, `pagekey`, `web`, `gravatar`, `ip`, `updated`, `timestamp`) VALUES
(1, 'Svar på fråga #13', 'Testar skriva om det här svaret', '', 0, 'stalle.johansson@gmail.com', 'Staffan', 6, '13', 'www.gudsforsamling.se', 'http://www.gravatar.com/avatar/12a91909d4b7acb466cac07a76e0fc51.jpg', '::1', '2015-11-20 17:49:23', '2015-11-19 21:02:04'),
(2, 'Svar på fråga #13', 'Svarar på frågan!!!', '', 0, 'stalle.johansson@gmail.com', 'Staffan', 6, '13', 'www.gudsforsamling.se', 'http://www.gravatar.com/avatar/12a91909d4b7acb466cac07a76e0fc51.jpg', '::1', '2015-11-22 18:49:46', '2015-11-22 18:43:40'),
(3, 'Svar på fråga #14', 'Testar att svara på den här också...', '', 0, 'stalle.johansson@gmail.com', 'Staffan', 6, '14', 'www.gudsforsamling.se', 'http://www.gravatar.com/avatar/12a91909d4b7acb466cac07a76e0fc51.jpg', '::1', '0000-00-00 00:00:00', '2015-11-22 19:14:35'),
(9, 'Svar på fråga #14', 'SVARTEST', '', 0, 'stalle.johansson@gmail.com', 'Staffan', 6, '14', 'www.gudsforsamling.se', 'http://www.gravatar.com/avatar/12a91909d4b7acb466cac07a76e0fc51.jpg', '::1', '0000-00-00 00:00:00', '2015-11-22 20:38:30');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `drone_answer`
--
ALTER TABLE `drone_answer`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `drone_answer`
--
ALTER TABLE `drone_answer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
