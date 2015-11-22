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
-- Tabellstruktur `drone_comment`
--

CREATE TABLE IF NOT EXISTS `drone_comment` (
`id` int(11) NOT NULL,
  `content` text NOT NULL,
  `mail` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  `userid` int(11) NOT NULL,
  `pagekey` varchar(80) NOT NULL,
  `timestamp` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `ip` varchar(80) NOT NULL,
  `web` varchar(200) NOT NULL,
  `gravatar` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `drone_comment`
--

INSERT INTO `drone_comment` (`id`, `content`, `mail`, `name`, `userid`, `pagekey`, `timestamp`, `updated`, `ip`, `web`, `gravatar`) VALUES
(35, 'Testar kommentera också!!!!', 'stalle.johansson@gmail.com', 'Staffan', 6, '13', '2015-11-19 18:11:06', '2015-11-22 18:50:01', '::1', 'www.gudsforsamling.se', 'http://www.gravatar.com/avatar/12a91909d4b7acb466cac07a76e0fc51.jpg'),
(40, 'Testar kommentera', 'stalle.johansson@gmail.com', 'Staffan', 6, '14', '2015-11-22 19:57:45', '0000-00-00 00:00:00', '::1', 'www.gudsforsamling.se', 'http://www.gravatar.com/avatar/12a91909d4b7acb466cac07a76e0fc51.jpg'),
(41, 'KOMMENTARTEST!!!', 'stalle.johansson@gmail.com', 'Staffan', 6, '14', '2015-11-22 20:38:46', '2015-11-22 20:41:17', '::1', 'www.gudsforsamling.se', 'http://www.gravatar.com/avatar/12a91909d4b7acb466cac07a76e0fc51.jpg');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `drone_comment`
--
ALTER TABLE `drone_comment`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `drone_comment`
--
ALTER TABLE `drone_comment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
