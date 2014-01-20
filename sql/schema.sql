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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `style` text NOT NULL,
  `notes` text NOT NULL,
  `ogEst` decimal(4,3) NOT NULL,
  `fgEst` decimal(4,3) NOT NULL,
  `srmEst` decimal(3,1) NOT NULL,
  `ibuEst` int(4) NOT NULL,
  `createdDate` TIMESTAMP NULL,
  `modifiedDate` TIMESTAMP NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `kegTypes`
--

CREATE TABLE IF NOT EXISTS `kegTypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `displayName` int(11) NOT NULL,
  `maxAmount` decimal(6,2) NOT NULL,
  `createdDate` TIMESTAMP NULL,
  `modifiedDate` TIMESTAMP NULL,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegTypes`
--

INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Ball Lock (5 gal)', '5', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Ball Lock (2.5 gal)', '2.5', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Ball Lock (3 gal)', '3', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Ball Lock (10 gal)', '10', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Sanke (1/6 bbl)', '5.16', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Sanke (1/4 bbl)', '7.75', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Sanke (slim 1/4 bbl)', '7.75', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Sanke (1/2 bbl)', '15.5', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Cask (pin)', '10.81', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Cask (firkin)', '10.81', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Cask (kilderkin)', '21.62', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Cask (barrel)', '43.23', NOW(), NOW());
INSERT INTO `kegTypes`(displayName, maxAmount, createdDate, modifiedDate) VALUES('Cask (hogshead)', '64.85', NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `taps`
--

CREATE TABLE IF NOT EXISTS `taps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beerId` int(11) NOT NULL,
  `kegTypeId` int(11) NOT NULL,
  `tapNumber` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `ogAct` decimal(4,3) NOT NULL,
  `fgAct` decimal(4,3) NOT NULL,
  `srmAct` decimal(3,1) NOT NULL,
  `ibuAct` int(4) NOT NULL,
  `startAmount` decimal(6,1) NOT NULL,
  `createdDate` TIMESTAMP NULL,
  `modifiedDate` TIMESTAMP NULL,
  
  PRIMARY KEY (`id`),
  FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`kegTypeId`) REFERENCES kegTypes(`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `pours`
--

CREATE TABLE IF NOT EXISTS `pours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tapId` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `ogAct` decimal(4,3) NOT NULL,
  `fgAct` decimal(4,3) NOT NULL,
  `srmAct` decimal(3,1) NOT NULL,
  `ibuAct` int(4) NOT NULL,
  `kegTypeId` int(11) NOT NULL,
  `kegstart` decimal(6,1) NOT NULL,
  `createdDate` TIMESTAMP NULL,
  `modifiedDate` TIMESTAMP NULL,
  
  PRIMARY KEY (`id`),
  FOREIGN KEY (tapId) REFERENCES taps(id) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `configName` varchar(50) NOT NULL,
  `configValue` longtext NOT NULL,
  `displayName` varchar(65) NOT NULL,
  `createdDate` TIMESTAMP NULL,
  `modifiedDate` TIMESTAMP NULL,

  PRIMARY KEY (`id`),
  UNIQUE KEY `configName_UNIQUE` (`configName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config`(configName, configValue, displayName, createdDate, modifiedDate) VALUES('showTapNumCol', '1', 'Tap Column', NOW(), NOW());
INSERT INTO `config`(configName, configValue, displayName, createdDate, modifiedDate) VALUES('showSrmCol', '1', 'SRM Column', NOW(), NOW());
INSERT INTO `config`(configName, configValue, displayName, createdDate, modifiedDate) VALUES('showIbuCol', '1', 'IBU Column', NOW(), NOW());
INSERT INTO `config`(configName, configValue, displayName, createdDate, modifiedDate) VALUES('showAbvCol', '1', 'ABV Column', NOW(), NOW());
INSERT INTO `config`(configName, configValue, displayName, createdDate, modifiedDate) VALUES('showKegCol', '0', 'Keg Column', NOW(), NOW());
INSERT INTO `config`(configName, configValue, displayName, createdDate, modifiedDate) VALUES('useHighResolution', '0', '4k Monitor Support', NOW(), NOW());
INSERT INTO `config`(configName, configValue, displayName, createdDate, modifiedDate) VALUES('logoUrl', 'admin/img/logo.png', 'Logo Url', NOW(), NOW());
INSERT INTO `config`(configName, configValue, displayName, createdDate, modifiedDate) VALUES('headerText', 'Beers On Tap', 'Header Text', NOW(), NOW());


-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(65) CHARACTER SET utf8 NOT NULL,
  `password` varchar(65) CHARACTER SET utf8 NOT NULL,
  `name` varchar(65) CHARACTER SET utf8 NOT NULL,
  `email` varchar(65) CHARACTER SET utf8 NOT NULL,
  `createdDate` TIMESTAMP NULL,
  `modifiedDate` TIMESTAMP NULL,

  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `users`(`username`, `password`, `name`, `email`, createdDate, modifiedDate) VALUES('admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'support@raspberrypints.com', NOW(), NOW());


-- --------------------------------------------------------

--
-- Table structure for table `srmRgb`
--

CREATE TABLE IF NOT EXISTS `srmRgb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `srm` decimal(3,1) NOT NULL,
  `rgb` varchar(12) NOT NULL,
  `createdDate` TIMESTAMP NULL,
  `modifiedDate` TIMESTAMP NULL,

  PRIMARY KEY (`id`),
  UNIQUE KEY `srm_UNIQUE` (`srm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data for table `srmRgb`
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('0.0','255,255,255', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('0.1','248,248,230', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('0.2','248,248,220', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('0.3','247,247,199', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('0.4','244,249,185', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('0.5','247,249,180', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('0.6','248,249,178', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('0.7','244,246,169', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('0.8','245,247,166', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('0.9','246,247,156', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('1.0','243,249,147', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('1.1','246,248,141', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('1.2','246,249,136', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('1.3','245,250,128', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('1.4','246,249,121', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('1.5','248,249,114', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('1.6','243,249,104', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('1.7','246,248,107', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('1.8','248,247,99',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('1.9','245,247,92',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('2.0','248,247,83',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('2.1','244,248,72',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('2.2','248,247,73',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('2.3','246,247,62',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('2.4','241,248,53',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('2.5','244,247,48',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('2.6','246,249,40',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('2.7','243,249,34',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('2.8','245,247,30',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('2.9','248,245,22',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('3.0','246,245,19',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('3.1','244,242,22',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('3.2','244,240,21',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('3.3','243,242,19',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('3.4','244,238,24',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('3.5','244,237,29',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('3.6','238,233,22',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('3.7','240,233,23',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('3.8','238,231,25',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('3.9','234,230,21',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('4.0','236,230,26',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('4.1','230,225,24',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('4.2','232,225,25',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('4.3','230,221,27',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('4.4','224,218,23',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('4.5','229,216,31',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('4.6','229,214,30',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('4.7','223,213,26',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('4.8','226,213,28',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('4.9','223,209,29',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('5.0','224,208,27',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('5.1','224,204,32',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('5.2','221,204,33',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('5.3','220,203,29',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('5.4','218,200,32',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('5.5','220,197,34',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('5.6','218,196,41',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('5.7','217,194,43',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('5.8','216,192,39',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('5.9','213,190,37',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('6.0','213,188,38',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('6.1','212,184,39',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('6.2','214,183,43',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('6.3','213,180,45',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('6.4','210,179,41',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('6.5','208,178,42',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('6.6','208,176,46',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('6.7','204,172,48',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('6.8','204,172,52',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('6.9','205,170,55',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('7.0','201,167,50',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('7.1','202,167,52',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('7.2','201,166,51',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('7.3','199,162,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('7.4','198,160,56',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('7.5','200,158,60',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('7.6','194,156,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('7.7','196,155,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('7.8','198,151,60',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('7.9','193,150,60',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('8.0','191,146,59',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('8.1','190,147,57',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('8.2','190,147,59',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('8.3','190,145,60',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('8.4','186,148,56',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('8.5','190,145,58',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('8.6','193,145,59',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('8.7','190,145,58',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('8.8','191,143,59',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('8.9','191,141,61',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('9.0','190,140,58',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('9.1','192,140,61',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('9.2','193,138,62',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('9.3','192,137,59',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('9.4','193,136,59',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('9.5','195,135,63',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('9.6','191,136,58',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('9.7','191,134,67',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('9.8','193,131,67',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('9.9','190,130,58',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('10.0','191,129,58', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('10.1','191,131,57', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('10.2','191,129,58', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('10.3','191,129,58', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('10.4','190,129,55', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('10.5','191,127,59', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('10.6','194,126,59', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('10.7','188,128,54', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('10.8','190,124,55', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('10.9','193,122,55', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('11.0','190,124,55', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('11.1','194,121,59', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('11.2','193,120,56', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('11.3','190,119,52', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('11.4','182,117,54', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('11.5','196,116,59', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('11.6','191,118,56', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('11.7','190,116,57', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('11.8','191,115,58', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('11.9','189,115,56', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('12.0','191,113,56', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('12.1','191,113,53', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('12.2','188,112,57', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('12.3','190,112,55', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('12.4','184,110,52', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('12.5','188,109,55', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('12.6','189,109,55', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('12.7','186,106,50', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('12.8','190,103,52', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('12.9','189,104,54', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('13.0','188,103,51', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('13.1','188,103,51', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('13.2','186,101,51', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('13.3','186,102,56', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('13.4','185,100,56', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('13.5','185,98,59',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('13.6','183,98,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('13.7','181,100,53', NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('13.8','182,97,55',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('13.9','177,97,51',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('14.0','178,96,51',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('14.1','176,96,49',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('14.2','177,96,55',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('14.3','178,95,55',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('14.4','171,94,55',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('14.5','171,92,56',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('14.6','172,93,59',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('14.7','168,92,55',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('14.8','169,90,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('14.9','168,88,57',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('15.0','165,89,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('15.1','166,88,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('15.2','165,88,58',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('15.3','161,88,52',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('15.4','163,85,55',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('15.5','160,86,56',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('15.6','158,85,57',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('15.7','158,86,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('15.8','159,84,57',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('15.9','156,83,53',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('16.0','152,83,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('16.1','150,83,55',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('16.2','150,81,56',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('16.3','146,81,56',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('16.4','147,79,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('16.5','147,79,55',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('16.6','146,78,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('16.7','142,77,51',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('16.8','143,79,53',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('16.9','142,77,54',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('17.0','141,76,50',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('17.1','140,75,50',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('17.2','138,73,49',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('17.3','135,70,45',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('17.4','136,71,49',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('17.5','140,72,49',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('17.6','128,70,45',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('17.7','129,71,46',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('17.8','130,69,47',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('17.9','123,69,45',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('18.0','124,69,45',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('18.1','121,66,40',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('18.2','120,67,40',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('18.3','119,64,38',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('18.4','116,63,34',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('18.5','120,63,35',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('18.6','120,62,37',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('18.7','112,63,35',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('18.8','111,62,36',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('18.9','109,60,34',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('19.0','107,58,30',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('19.1','106,57,31',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('19.2','107,56,31',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('19.3','105,56,28',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('19.4','105,56,28',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('19.5','104,52,31',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('19.6','102,53,27',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('19.7','100,53,26',  NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('19.8','99,52,25',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('19.9','93,53,24',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('20.0','93,52,26',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('20.1','89,49,20',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('20.2','90,50,21',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('20.3','91,48,20',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('20.4','83,48,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('20.5','88,48,17',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('20.6','86,46,17',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('20.7','81,45,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('20.8','83,44,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('20.9','81,45,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('21.0','78,42,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('21.1','77,43,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('21.2','75,41,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('21.3','74,41,5',    NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('21.4','78,40,23',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('21.5','83,43,46',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('21.6','78,43,41',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('21.7','78,40,41',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('21.8','76,41,41',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('21.9','74,39,39',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('22.0','74,39,39',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('22.1','69,39,35',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('22.2','70,37,37',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('22.3','68,38,36',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('22.4','64,35,34',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('22.5','64,35,34',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('22.6','62,33,32',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('22.7','58,33,31',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('22.8','61,33,31',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('22.9','58,33,33',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('23.0','54,31,27',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('23.1','52,29,28',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('23.2','52,29,28',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('23.3','49,28,27',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('23.4','48,27,26',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('23.5','48,27,26',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('23.6','44,25,25',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('23.7','44,25,23',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('23.8','42,24,26',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('23.9','40,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('24.0','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('24.1','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('24.2','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('24.3','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('24.4','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('24.5','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('24.6','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('24.7','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('24.8','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('24.9','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('25.0','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('25.1','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('25.2','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('25.3','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('25.4','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('25.5','38,23,22',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('25.6','38,23,24',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('25.7','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('25.8','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('25.9','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('26.0','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('26.1','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('26.2','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('26.3','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('26.4','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('26.5','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('26.6','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('26.7','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('26.8','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('26.9','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('27.0','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('27.1','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('27.2','25,16,15',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('27.3','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('27.4','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('27.5','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('27.6','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('27.7','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('27.8','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('27.9','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('28.0','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('28.1','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('28.2','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('28.3','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('28.4','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('28.5','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('28.6','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('28.7','17,13,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('28.8','18,13,12',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('28.9','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('29.0','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('29.1','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('29.2','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('29.3','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('29.4','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('29.5','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('29.6','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('29.7','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('29.8','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('29.9','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('30.0','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('30.1','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('30.2','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('30.3','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('30.4','16,11,10',   NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('30.5','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('30.6','15,10,9',    NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('30.7','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('30.8','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('30.9','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('31.0','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('31.1','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('31.2','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('31.3','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('31.4','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('31.5','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('31.6','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('31.7','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('31.8','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('31.9','14,9,8',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('32.0','15,11,8',    NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('32.1','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('32.2','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('32.3','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('32.4','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('32.5','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('32.6','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('32.7','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('32.8','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('32.9','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('33.0','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('33.1','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('33.2','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('33.3','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('33.4','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('33.5','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('33.6','12,9,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('33.7','10,7,7',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('33.8','10,7,5',     NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('33.9','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('34.0','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('34.1','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('34.2','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('34.3','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('34.4','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('34.5','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('34.6','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('34.7','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('34.8','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('34.9','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('35.0','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('35.1','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('35.2','8,7,7',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('35.3','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('35.4','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('35.5','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('35.6','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('35.7','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('35.8','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('35.9','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('36.0','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('36.1','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('36.2','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('36.3','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('36.4','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('36.5','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('36.6','7,6,6',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('36.7','7,7,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('36.8','6,6,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('36.9','6,5,5',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('37.0','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('37.1','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('37.2','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('37.3','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('37.4','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('37.5','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('37.6','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('37.7','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('37.8','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('37.9','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('38.0','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('38.1','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('38.2','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('38.3','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('38.4','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('38.5','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('38.6','4,5,4',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('38.7','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('38.8','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('38.9','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('39.0','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('39.1','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('39.2','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('39.3','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('39.4','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('39.5','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('39.6','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('39.7','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('39.8','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('39.9','3,4,3',      NOW(), NOW());
INSERT INTO srmRgb(srm, rgb, createdDate, modifiedDate) VALUES('40.0','3,4,3',      NOW(), NOW());




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
