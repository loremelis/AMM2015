-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Giu 18, 2016 alle 13:39
-- Versione del server: 5.5.35
-- Versione PHP: 5.4.6-1ubuntu1.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
  `password` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT, 
  `nome` varchar(128) DEFAULT NULL,
  `cognome` varchar(128) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  `numCivico` int(11) DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL, 
  `cap` varchar(5) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;

--
-- Dump dei dati per la tabella `clienti`
--
INSERT INTO `clienti` (`password`, `username`, `nome`, `cognome`, `via`, `numCivico`, `citta`, `cap`, `email`) VALUES
('password','cliente', 'Lorenzo', 'Melis',, 'via di cagliari',9 , 'Cagliari', 09124 , 'lorenzo.melis@unica.it');

--
-- Struttura della tabella `venditore`
--
CREATE TABLE IF NOT EXISTS `venditore` (
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



--
-- Dump dei dati per la tabella `venditore`
--
INSERT INTO `venditore` (`username`, `password`) VALUES
('seller', 'password');



--
-- Struttura tabella Oggetti
-- (id, nome, prezzo, descrizione, immagine, quantità,)
--

CREATE TABLE IF NOT EXISTS `oggetti` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT, 
  `nome` varchar(128) DEFAULT NULL,
  `prezzo` int(11) DEFAULT NULL,
  `descrizione` varchar(250) DEFAULT NULL,
  `immagine` varchar(250) NOT NULL,        
  `quantita` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;




INSERT INTO `oggetti` (`nome`, `prezzo`, `descrizione`, `immagine`, `quantita`) VALUES
('seller', 'password', 'password', 'password', 'password'),
('seller', 'password', 'password', 'password', 'password'),
('seller', 'password', 'password', 'password', 'password'),
('seller', 'password', 'password', 'password', 'password'),
('seller', 'password', 'password', 'password', 'password'),
('seller', 'password', 'password', 'password', 'password');
