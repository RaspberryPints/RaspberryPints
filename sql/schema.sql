-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2014 at 03:13 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `raspberrypints`
--
CREATE DATABASE IF NOT EXISTS `raspberrypints` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `raspberrypints`;

-- --------------------------------------------------------

--
-- Table structure for table `beers`
--

CREATE TABLE IF NOT EXISTS `beers` (
  `beerid` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `style` text NOT NULL,
  `notes` text NOT NULL,
  `og` decimal(4,3) NOT NULL,
  `fg` decimal(4,3) NOT NULL,
  `srm` int(3) NOT NULL,
  `ibu` int(4) NOT NULL,
  `kegstart` decimal(6,1) NOT NULL,
  `kegremain` decimal(6,1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `tapnumber` int(11) NOT NULL,

  PRIMARY KEY (`beerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;



-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(50) NOT NULL,
  `config_value` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_name_UNIQUE` (`config_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Data for table `config`
INSERT INTO `config` (config_name, config_value) VALUES ('showTapNumCol', 1);
INSERT INTO `config` (config_name, config_value) VALUES ('showSrmCol', 1);
INSERT INTO `config` (config_name, config_value) VALUES ('showIbuCol', 1);
INSERT INTO `config` (config_name, config_value) VALUES ('showAbvCol', 1);
INSERT INTO `config` (config_name, config_value) VALUES ('showKegCol', 1);


-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `username` varchar(65) CHARACTER SET utf8 NOT NULL,
  `password` varchar(65) CHARACTER SET utf8 NOT NULL,
  `name` varchar(65) CHARACTER SET utf8 NOT NULL,
  `email` varchar(65) CHARACTER SET utf8 NOT NULL,
  KEY `UserName` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` VALUES('admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'support@raspberrypints.com');




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
