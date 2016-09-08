-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Set 08, 2016 alle 11:19
-- Versione del server: 5.6.31-log
-- PHP Version: 5.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lollosfilm`
--

-- --------------------------------------------------------

USE amm15_melisLorenzo;
--
-- Struttura della tabella `clienti`
--

CREATE TABLE IF NOT EXISTS `clienti` (
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `nome` varchar(128) DEFAULT NULL,
  `cognome` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `numCivico` int(11) DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cap` varchar(5) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `clienti`
--

INSERT INTO `clienti` (`username`, `password`, `nome`, `cognome`, `email`, `numCivico`, `citta`, `id`, `cap`, `via`) VALUES
('cliente', 'password', 'Lorenzo', 'Melis', 'lorenzo.melis9@gmail.com', 3, 'Cagliari', 3, '09126', 'aquilona'),
('riccardo', 'riccardo', 'riccardo', 'tocco', 'riccardo.tocco@live.it', 31, 'ussana', 4, '09020', 'rsanzio');

-- --------------------------------------------------------

--
-- Struttura della tabella `oggetti`
--

CREATE TABLE IF NOT EXISTS `oggetti` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) DEFAULT NULL,
  `prezzo` int(11) DEFAULT NULL,
  `descrizione` varchar(250) DEFAULT NULL,
  `immagine` varchar(250) NOT NULL,
  `quantita` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dump dei dati per la tabella `oggetti`
--

INSERT INTO `oggetti` (`id`, `nome`, `prezzo`, `descrizione`, `immagine`, `quantita`) VALUES
(5, '2001 Odissea nello spazio', 0, '', '2001_piccola.jpg', 2),
(6, 'seller', 0, 'password', 'password', 3),
(7, 'seller', 0, 'password', 'password', 0),
(8, 'seller', 0, 'password', 'password', 5),
(9, 'seller', 0, 'password', 'password', 0),
(10, 'seller', 0, 'password', 'password', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `venditore`
--

CREATE TABLE IF NOT EXISTS `venditore` (
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `venditore`
--

INSERT INTO `venditore` (`username`, `password`, `id`) VALUES
('seller', 'password', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
