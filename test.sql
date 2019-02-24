-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: 22 Apr 2014 la 20:27
-- Versiune server: 5.6.12-log
-- Versiune PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Bază de date: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `autori`
--

CREATE TABLE IF NOT EXISTS `autori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(100) NOT NULL,
  `prenume` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Salvarea datelor din tabel `autori`
--

INSERT INTO `autori` (`id`, `nume`, `prenume`) VALUES
(1, 'Verne', 'Jules'),
(2, 'Creanga', 'Ion'),
(3, 'Eminescu', 'Mihai'),
(4, 'Preda', 'Marin'),
(5, 'Twain', 'Mark'),
(6, 'Dumas', 'Alexandre');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `carti`
--

CREATE TABLE IF NOT EXISTS `carti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titlu` varchar(200) NOT NULL,
  `id_autor` varchar(200) NOT NULL,
  `nr_exemplare` int(11) NOT NULL,
  `nr_exemplare_disp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Salvarea datelor din tabel `carti`
--

INSERT INTO `carti` (`id`, `titlu`, `id_autor`, `nr_exemplare`, `nr_exemplare_disp`) VALUES
(1, 'Capitan la 15 ani', '1', 3, 0),
(2, 'Fat-Frumos din Lacrima', '3', 5, 0),
(3, 'Morometii', '4', 1, 0),
(4, 'Poezii', '3', 5, 0),
(5, 'Contele de Monte Cristo', '6', 2, 0),
(6, 'Laleaua neagra', '6', 4, 0);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `imprumuturi`
--

CREATE TABLE IF NOT EXISTS `imprumuturi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_carte` int(11) NOT NULL,
  `id_cititor` int(11) NOT NULL,
  `id_bibliotecar` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `data_imprumut` date NOT NULL,
  `data_returnare` date NOT NULL,
  `nr_exemplare` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Salvarea datelor din tabel `imprumuturi`
--

INSERT INTO `imprumuturi` (`id`, `id_carte`, `id_cititor`, `id_bibliotecar`, `status`, `data_imprumut`, `data_returnare`, `nr_exemplare`) VALUES
(1, 2, 3, 0, 1, '2014-04-19', '2014-05-03', 0),
(2, 3, 3, 0, 0, '2014-04-25', '2014-05-31', 0),
(3, 3, 4, 0, 0, '2014-04-24', '2014-05-30', 0),
(4, 2, 0, 2, 0, '2014-04-25', '2014-05-26', 1),
(5, 3, 1, 2, 0, '2014-04-12', '2014-05-13', 2);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `useri`
--

CREATE TABLE IF NOT EXISTS `useri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(100) NOT NULL,
  `prenume` varchar(100) NOT NULL,
  `rang` int(11) NOT NULL,
  `parola` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `activ` int(11) NOT NULL,
  `adresa` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Salvarea datelor din tabel `useri`
--

INSERT INTO `useri` (`id`, `nume`, `prenume`, `rang`, `parola`, `email`, `telefon`, `activ`, `adresa`) VALUES
(1, 'Beleiu', 'Nelutu', 2, '202cb962ac59075b964b07152d234b70', 'nelutzu_ucl_25@yahoo.com', '0754456738', 0, 'aleea daliei bl. 52'),
(2, 'Popa ', 'Nicolae', 1, '202cb962ac59075b964b07152d234b70', 'popa@yahoo.com', '0754456738', 0, ''),
(3, 'Popescu', 'Ion', 0, '202cb962ac59075b964b07152d234b70', 'popescu@yahoo.com', '0754456731', 0, 'adresa 1'),
(4, 'Ionescu', 'Ion', 0, '202cb962ac59075b964b07152d234b70', 'ionescu@yahoo.com', '0754458741', 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
