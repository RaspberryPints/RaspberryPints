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
  `srm` decimal(3,1) NOT NULL,
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

CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(50) NOT NULL,
  `config_value` longtext NOT NULL,
  `display_name` varchar(65) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_name_UNIQUE` (`config_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `config`
--

INSERT INTO `config` VALUES(9, 'showTapNumCol', '1', 'Tap Column');
INSERT INTO `config` VALUES(10, 'showSrmCol', '1', 'SRM Column');
INSERT INTO `config` VALUES(11, 'showIbuCol', '1', 'IBU Column');
INSERT INTO `config` VALUES(12, 'showAbvCol', '1', 'ABV Column');
INSERT INTO `config` VALUES(13, 'showKegCol', '0', 'Keg Column');
INSERT INTO `config` VALUES(14, 'useHighResolution', '0', '4k Monitor Support');



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

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `logo_url` varchar(255) NOT NULL,
  `header_text` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` VALUES('admin/img/logo.png', 'Beers On Tap');



-- --------------------------------------------------------

--
-- Table structure for table `srmRgb`
--

CREATE TABLE IF NOT EXISTS `srmRgb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `srm` decimal(3,1) NOT NULL,
  `rgb` varchar(12) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `srm_UNIQUE` (`srm`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Data for table `srmRgb`
INSERT INTO srmRgb(srm, rgb) VALUES('0.1','248,248,230');
INSERT INTO srmRgb(srm, rgb) VALUES('0.2','248,248,220');
INSERT INTO srmRgb(srm, rgb) VALUES('0.3','247,247,199');
INSERT INTO srmRgb(srm, rgb) VALUES('0.4','244,249,185');
INSERT INTO srmRgb(srm, rgb) VALUES('0.5','247,249,180');
INSERT INTO srmRgb(srm, rgb) VALUES('0.6','248,249,178');
INSERT INTO srmRgb(srm, rgb) VALUES('0.7','244,246,169');
INSERT INTO srmRgb(srm, rgb) VALUES('0.8','245,247,166');
INSERT INTO srmRgb(srm, rgb) VALUES('0.9','246,247,156');
INSERT INTO srmRgb(srm, rgb) VALUES('1','243,249,147');
INSERT INTO srmRgb(srm, rgb) VALUES('1.1','246,248,141');
INSERT INTO srmRgb(srm, rgb) VALUES('1.2','246,249,136');
INSERT INTO srmRgb(srm, rgb) VALUES('1.3','245,250,128');
INSERT INTO srmRgb(srm, rgb) VALUES('1.4','246,249,121');
INSERT INTO srmRgb(srm, rgb) VALUES('1.5','248,249,114');
INSERT INTO srmRgb(srm, rgb) VALUES('1.6','243,249,104');
INSERT INTO srmRgb(srm, rgb) VALUES('1.7','246,248,107');
INSERT INTO srmRgb(srm, rgb) VALUES('1.8','248,247,99');
INSERT INTO srmRgb(srm, rgb) VALUES('1.9','245,247,92');
INSERT INTO srmRgb(srm, rgb) VALUES('2','248,247,83');
INSERT INTO srmRgb(srm, rgb) VALUES('2.1','244,248,72');
INSERT INTO srmRgb(srm, rgb) VALUES('2.2','248,247,73');
INSERT INTO srmRgb(srm, rgb) VALUES('2.3','246,247,62');
INSERT INTO srmRgb(srm, rgb) VALUES('2.4','241,248,53');
INSERT INTO srmRgb(srm, rgb) VALUES('2.5','244,247,48');
INSERT INTO srmRgb(srm, rgb) VALUES('2.6','246,249,40');
INSERT INTO srmRgb(srm, rgb) VALUES('2.7','243,249,34');
INSERT INTO srmRgb(srm, rgb) VALUES('2.8','245,247,30');
INSERT INTO srmRgb(srm, rgb) VALUES('2.9','248,245,22');
INSERT INTO srmRgb(srm, rgb) VALUES('3','246,245,19');
INSERT INTO srmRgb(srm, rgb) VALUES('3.1','244,242,22');
INSERT INTO srmRgb(srm, rgb) VALUES('3.2','244,240,21');
INSERT INTO srmRgb(srm, rgb) VALUES('3.3','243,242,19');
INSERT INTO srmRgb(srm, rgb) VALUES('3.4','244,238,24');
INSERT INTO srmRgb(srm, rgb) VALUES('3.5','244,237,29');
INSERT INTO srmRgb(srm, rgb) VALUES('3.6','238,233,22');
INSERT INTO srmRgb(srm, rgb) VALUES('3.7','240,233,23');
INSERT INTO srmRgb(srm, rgb) VALUES('3.8','238,231,25');
INSERT INTO srmRgb(srm, rgb) VALUES('3.9','234,230,21');
INSERT INTO srmRgb(srm, rgb) VALUES('4','236,230,26');
INSERT INTO srmRgb(srm, rgb) VALUES('4.1','230,225,24');
INSERT INTO srmRgb(srm, rgb) VALUES('4.2','232,225,25');
INSERT INTO srmRgb(srm, rgb) VALUES('4.3','230,221,27');
INSERT INTO srmRgb(srm, rgb) VALUES('4.4','224,218,23');
INSERT INTO srmRgb(srm, rgb) VALUES('4.5','229,216,31');
INSERT INTO srmRgb(srm, rgb) VALUES('4.6','229,214,30');
INSERT INTO srmRgb(srm, rgb) VALUES('4.7','223,213,26');
INSERT INTO srmRgb(srm, rgb) VALUES('4.8','226,213,28');
INSERT INTO srmRgb(srm, rgb) VALUES('4.9','223,209,29');
INSERT INTO srmRgb(srm, rgb) VALUES('5','224,208,27');
INSERT INTO srmRgb(srm, rgb) VALUES('5.1','224,204,32');
INSERT INTO srmRgb(srm, rgb) VALUES('5.2','221,204,33');
INSERT INTO srmRgb(srm, rgb) VALUES('5.3','220,203,29');
INSERT INTO srmRgb(srm, rgb) VALUES('5.4','218,200,32');
INSERT INTO srmRgb(srm, rgb) VALUES('5.5','220,197,34');
INSERT INTO srmRgb(srm, rgb) VALUES('5.6','218,196,41');
INSERT INTO srmRgb(srm, rgb) VALUES('5.7','217,194,43');
INSERT INTO srmRgb(srm, rgb) VALUES('5.8','216,192,39');
INSERT INTO srmRgb(srm, rgb) VALUES('5.9','213,190,37');
INSERT INTO srmRgb(srm, rgb) VALUES('6','213,188,38');
INSERT INTO srmRgb(srm, rgb) VALUES('6.1','212,184,39');
INSERT INTO srmRgb(srm, rgb) VALUES('6.2','214,183,43');
INSERT INTO srmRgb(srm, rgb) VALUES('6.3','213,180,45');
INSERT INTO srmRgb(srm, rgb) VALUES('6.4','210,179,41');
INSERT INTO srmRgb(srm, rgb) VALUES('6.5','208,178,42');
INSERT INTO srmRgb(srm, rgb) VALUES('6.6','208,176,46');
INSERT INTO srmRgb(srm, rgb) VALUES('6.7','204,172,48');
INSERT INTO srmRgb(srm, rgb) VALUES('6.8','204,172,52');
INSERT INTO srmRgb(srm, rgb) VALUES('6.9','205,170,55');
INSERT INTO srmRgb(srm, rgb) VALUES('7','201,167,50');
INSERT INTO srmRgb(srm, rgb) VALUES('7.1','202,167,52');
INSERT INTO srmRgb(srm, rgb) VALUES('7.2','201,166,51');
INSERT INTO srmRgb(srm, rgb) VALUES('7.3','199,162,54');
INSERT INTO srmRgb(srm, rgb) VALUES('7.4','198,160,56');
INSERT INTO srmRgb(srm, rgb) VALUES('7.5','200,158,60');
INSERT INTO srmRgb(srm, rgb) VALUES('7.6','194,156,54');
INSERT INTO srmRgb(srm, rgb) VALUES('7.7','196,155,54');
INSERT INTO srmRgb(srm, rgb) VALUES('7.8','198,151,60');
INSERT INTO srmRgb(srm, rgb) VALUES('7.9','193,150,60');
INSERT INTO srmRgb(srm, rgb) VALUES('8','191,146,59');
INSERT INTO srmRgb(srm, rgb) VALUES('8.1','190,147,57');
INSERT INTO srmRgb(srm, rgb) VALUES('8.2','190,147,59');
INSERT INTO srmRgb(srm, rgb) VALUES('8.3','190,145,60');
INSERT INTO srmRgb(srm, rgb) VALUES('8.4','186,148,56');
INSERT INTO srmRgb(srm, rgb) VALUES('8.5','190,145,58');
INSERT INTO srmRgb(srm, rgb) VALUES('8.6','193,145,59');
INSERT INTO srmRgb(srm, rgb) VALUES('8.7','190,145,58');
INSERT INTO srmRgb(srm, rgb) VALUES('8.8','191,143,59');
INSERT INTO srmRgb(srm, rgb) VALUES('8.9','191,141,61');
INSERT INTO srmRgb(srm, rgb) VALUES('9','190,140,58');
INSERT INTO srmRgb(srm, rgb) VALUES('9.1','192,140,61');
INSERT INTO srmRgb(srm, rgb) VALUES('9.2','193,138,62');
INSERT INTO srmRgb(srm, rgb) VALUES('9.3','192,137,59');
INSERT INTO srmRgb(srm, rgb) VALUES('9.4','193,136,59');
INSERT INTO srmRgb(srm, rgb) VALUES('9.5','195,135,63');
INSERT INTO srmRgb(srm, rgb) VALUES('9.6','191,136,58');
INSERT INTO srmRgb(srm, rgb) VALUES('9.7','191,134,67');
INSERT INTO srmRgb(srm, rgb) VALUES('9.8','193,131,67');
INSERT INTO srmRgb(srm, rgb) VALUES('9.9','190,130,58');
INSERT INTO srmRgb(srm, rgb) VALUES('10','191,129,58');
INSERT INTO srmRgb(srm, rgb) VALUES('10.1','191,131,57');
INSERT INTO srmRgb(srm, rgb) VALUES('10.2','191,129,58');
INSERT INTO srmRgb(srm, rgb) VALUES('10.3','191,129,58');
INSERT INTO srmRgb(srm, rgb) VALUES('10.4','190,129,55');
INSERT INTO srmRgb(srm, rgb) VALUES('10.5','191,127,59');
INSERT INTO srmRgb(srm, rgb) VALUES('10.6','194,126,59');
INSERT INTO srmRgb(srm, rgb) VALUES('10.7','188,128,54');
INSERT INTO srmRgb(srm, rgb) VALUES('10.8','190,124,55');
INSERT INTO srmRgb(srm, rgb) VALUES('10.9','193,122,55');
INSERT INTO srmRgb(srm, rgb) VALUES('11','190,124,55');
INSERT INTO srmRgb(srm, rgb) VALUES('11.1','194,121,59');
INSERT INTO srmRgb(srm, rgb) VALUES('11.2','193,120,56');
INSERT INTO srmRgb(srm, rgb) VALUES('11.3','190,119,52');
INSERT INTO srmRgb(srm, rgb) VALUES('11.4','182,117,54');
INSERT INTO srmRgb(srm, rgb) VALUES('11.5','196,116,59');
INSERT INTO srmRgb(srm, rgb) VALUES('11.6','191,118,56');
INSERT INTO srmRgb(srm, rgb) VALUES('11.7','190,116,57');
INSERT INTO srmRgb(srm, rgb) VALUES('11.8','191,115,58');
INSERT INTO srmRgb(srm, rgb) VALUES('11.9','189,115,56');
INSERT INTO srmRgb(srm, rgb) VALUES('12','191,113,56');
INSERT INTO srmRgb(srm, rgb) VALUES('12.1','191,113,53');
INSERT INTO srmRgb(srm, rgb) VALUES('12.2','188,112,57');
INSERT INTO srmRgb(srm, rgb) VALUES('12.3','190,112,55');
INSERT INTO srmRgb(srm, rgb) VALUES('12.4','184,110,52');
INSERT INTO srmRgb(srm, rgb) VALUES('12.5','188,109,55');
INSERT INTO srmRgb(srm, rgb) VALUES('12.6','189,109,55');
INSERT INTO srmRgb(srm, rgb) VALUES('12.7','186,106,50');
INSERT INTO srmRgb(srm, rgb) VALUES('12.8','190,103,52');
INSERT INTO srmRgb(srm, rgb) VALUES('12.9','189,104,54');
INSERT INTO srmRgb(srm, rgb) VALUES('13','188,103,51');
INSERT INTO srmRgb(srm, rgb) VALUES('13.1','188,103,51');
INSERT INTO srmRgb(srm, rgb) VALUES('13.2','186,101,51');
INSERT INTO srmRgb(srm, rgb) VALUES('13.3','186,102,56');
INSERT INTO srmRgb(srm, rgb) VALUES('13.4','185,100,56');
INSERT INTO srmRgb(srm, rgb) VALUES('13.5','185,98,59');
INSERT INTO srmRgb(srm, rgb) VALUES('13.6','183,98,54');
INSERT INTO srmRgb(srm, rgb) VALUES('13.7','181,100,53');
INSERT INTO srmRgb(srm, rgb) VALUES('13.8','182,97,55');
INSERT INTO srmRgb(srm, rgb) VALUES('13.9','177,97,51');
INSERT INTO srmRgb(srm, rgb) VALUES('14','178,96,51');
INSERT INTO srmRgb(srm, rgb) VALUES('14.1','176,96,49');
INSERT INTO srmRgb(srm, rgb) VALUES('14.2','177,96,55');
INSERT INTO srmRgb(srm, rgb) VALUES('14.3','178,95,55');
INSERT INTO srmRgb(srm, rgb) VALUES('14.4','171,94,55');
INSERT INTO srmRgb(srm, rgb) VALUES('14.5','171,92,56');
INSERT INTO srmRgb(srm, rgb) VALUES('14.6','172,93,59');
INSERT INTO srmRgb(srm, rgb) VALUES('14.7','168,92,55');
INSERT INTO srmRgb(srm, rgb) VALUES('14.8','169,90,54');
INSERT INTO srmRgb(srm, rgb) VALUES('14.9','168,88,57');
INSERT INTO srmRgb(srm, rgb) VALUES('15','165,89,54');
INSERT INTO srmRgb(srm, rgb) VALUES('15.1','166,88,54');
INSERT INTO srmRgb(srm, rgb) VALUES('15.2','165,88,58');
INSERT INTO srmRgb(srm, rgb) VALUES('15.3','161,88,52');
INSERT INTO srmRgb(srm, rgb) VALUES('15.4','163,85,55');
INSERT INTO srmRgb(srm, rgb) VALUES('15.5','160,86,56');
INSERT INTO srmRgb(srm, rgb) VALUES('15.6','158,85,57');
INSERT INTO srmRgb(srm, rgb) VALUES('15.7','158,86,54');
INSERT INTO srmRgb(srm, rgb) VALUES('15.8','159,84,57');
INSERT INTO srmRgb(srm, rgb) VALUES('15.9','156,83,53');
INSERT INTO srmRgb(srm, rgb) VALUES('16','152,83,54');
INSERT INTO srmRgb(srm, rgb) VALUES('16.1','150,83,55');
INSERT INTO srmRgb(srm, rgb) VALUES('16.2','150,81,56');
INSERT INTO srmRgb(srm, rgb) VALUES('16.3','146,81,56');
INSERT INTO srmRgb(srm, rgb) VALUES('16.4','147,79,54');
INSERT INTO srmRgb(srm, rgb) VALUES('16.5','147,79,55');
INSERT INTO srmRgb(srm, rgb) VALUES('16.6','146,78,54');
INSERT INTO srmRgb(srm, rgb) VALUES('16.7','142,77,51');
INSERT INTO srmRgb(srm, rgb) VALUES('16.8','143,79,53');
INSERT INTO srmRgb(srm, rgb) VALUES('16.9','142,77,54');
INSERT INTO srmRgb(srm, rgb) VALUES('17','141,76,50');
INSERT INTO srmRgb(srm, rgb) VALUES('17.1','140,75,50');
INSERT INTO srmRgb(srm, rgb) VALUES('17.2','138,73,49');
INSERT INTO srmRgb(srm, rgb) VALUES('17.3','135,70,45');
INSERT INTO srmRgb(srm, rgb) VALUES('17.4','136,71,49');
INSERT INTO srmRgb(srm, rgb) VALUES('17.5','140,72,49');
INSERT INTO srmRgb(srm, rgb) VALUES('17.6','128,70,45');
INSERT INTO srmRgb(srm, rgb) VALUES('17.7','129,71,46');
INSERT INTO srmRgb(srm, rgb) VALUES('17.8','130,69,47');
INSERT INTO srmRgb(srm, rgb) VALUES('17.9','123,69,45');
INSERT INTO srmRgb(srm, rgb) VALUES('18','124,69,45');
INSERT INTO srmRgb(srm, rgb) VALUES('18.1','121,66,40');
INSERT INTO srmRgb(srm, rgb) VALUES('18.2','120,67,40');
INSERT INTO srmRgb(srm, rgb) VALUES('18.3','119,64,38');
INSERT INTO srmRgb(srm, rgb) VALUES('18.4','116,63,34');
INSERT INTO srmRgb(srm, rgb) VALUES('18.5','120,63,35');
INSERT INTO srmRgb(srm, rgb) VALUES('18.6','120,62,37');
INSERT INTO srmRgb(srm, rgb) VALUES('18.7','112,63,35');
INSERT INTO srmRgb(srm, rgb) VALUES('18.8','111,62,36');
INSERT INTO srmRgb(srm, rgb) VALUES('18.9','109,60,34');
INSERT INTO srmRgb(srm, rgb) VALUES('19','107,58,30');
INSERT INTO srmRgb(srm, rgb) VALUES('19.1','106,57,31');
INSERT INTO srmRgb(srm, rgb) VALUES('19.2','107,56,31');
INSERT INTO srmRgb(srm, rgb) VALUES('19.3','105,56,28');
INSERT INTO srmRgb(srm, rgb) VALUES('19.4','105,56,28');
INSERT INTO srmRgb(srm, rgb) VALUES('19.5','104,52,31');
INSERT INTO srmRgb(srm, rgb) VALUES('19.6','102,53,27');
INSERT INTO srmRgb(srm, rgb) VALUES('19.7','100,53,26');
INSERT INTO srmRgb(srm, rgb) VALUES('19.8','99,52,25');
INSERT INTO srmRgb(srm, rgb) VALUES('19.9','93,53,24');
INSERT INTO srmRgb(srm, rgb) VALUES('20','93,52,26');
INSERT INTO srmRgb(srm, rgb) VALUES('20.1','89,49,20');
INSERT INTO srmRgb(srm, rgb) VALUES('20.2','90,50,21');
INSERT INTO srmRgb(srm, rgb) VALUES('20.3','91,48,20');
INSERT INTO srmRgb(srm, rgb) VALUES('20.4','83,48,15');
INSERT INTO srmRgb(srm, rgb) VALUES('20.5','88,48,17');
INSERT INTO srmRgb(srm, rgb) VALUES('20.6','86,46,17');
INSERT INTO srmRgb(srm, rgb) VALUES('20.7','81,45,15');
INSERT INTO srmRgb(srm, rgb) VALUES('20.8','83,44,15');
INSERT INTO srmRgb(srm, rgb) VALUES('20.9','81,45,15');
INSERT INTO srmRgb(srm, rgb) VALUES('21','78,42,12');
INSERT INTO srmRgb(srm, rgb) VALUES('21.1','77,43,12');
INSERT INTO srmRgb(srm, rgb) VALUES('21.2','75,41,12');
INSERT INTO srmRgb(srm, rgb) VALUES('21.3','74,41,5');
INSERT INTO srmRgb(srm, rgb) VALUES('21.4','78,40,23');
INSERT INTO srmRgb(srm, rgb) VALUES('21.5','83,43,46');
INSERT INTO srmRgb(srm, rgb) VALUES('21.6','78,43,41');
INSERT INTO srmRgb(srm, rgb) VALUES('21.7','78,40,41');
INSERT INTO srmRgb(srm, rgb) VALUES('21.8','76,41,41');
INSERT INTO srmRgb(srm, rgb) VALUES('21.9','74,39,39');
INSERT INTO srmRgb(srm, rgb) VALUES('22','74,39,39');
INSERT INTO srmRgb(srm, rgb) VALUES('22.1','69,39,35');
INSERT INTO srmRgb(srm, rgb) VALUES('22.2','70,37,37');
INSERT INTO srmRgb(srm, rgb) VALUES('22.3','68,38,36');
INSERT INTO srmRgb(srm, rgb) VALUES('22.4','64,35,34');
INSERT INTO srmRgb(srm, rgb) VALUES('22.5','64,35,34');
INSERT INTO srmRgb(srm, rgb) VALUES('22.6','62,33,32');
INSERT INTO srmRgb(srm, rgb) VALUES('22.7','58,33,31');
INSERT INTO srmRgb(srm, rgb) VALUES('22.8','61,33,31');
INSERT INTO srmRgb(srm, rgb) VALUES('22.9','58,33,33');
INSERT INTO srmRgb(srm, rgb) VALUES('23','54,31,27');
INSERT INTO srmRgb(srm, rgb) VALUES('23.1','52,29,28');
INSERT INTO srmRgb(srm, rgb) VALUES('23.2','52,29,28');
INSERT INTO srmRgb(srm, rgb) VALUES('23.3','49,28,27');
INSERT INTO srmRgb(srm, rgb) VALUES('23.4','48,27,26');
INSERT INTO srmRgb(srm, rgb) VALUES('23.5','48,27,26');
INSERT INTO srmRgb(srm, rgb) VALUES('23.6','44,25,25');
INSERT INTO srmRgb(srm, rgb) VALUES('23.7','44,25,23');
INSERT INTO srmRgb(srm, rgb) VALUES('23.8','42,24,26');
INSERT INTO srmRgb(srm, rgb) VALUES('23.9','40,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('24','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('24.1','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('24.2','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('24.3','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('24.4','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('24.5','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('24.6','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('24.7','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('24.8','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('24.9','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('25','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('25.1','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('25.2','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('25.3','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('25.4','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('25.5','38,23,22');
INSERT INTO srmRgb(srm, rgb) VALUES('25.6','38,23,24');
INSERT INTO srmRgb(srm, rgb) VALUES('25.7','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('25.8','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('25.9','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('26','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('26.1','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('26.2','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('26.3','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('26.4','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('26.5','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('26.6','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('26.7','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('26.8','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('26.9','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('27','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('27.1','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('27.2','25,16,15');
INSERT INTO srmRgb(srm, rgb) VALUES('27.3','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('27.4','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('27.5','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('27.6','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('27.7','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('27.8','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('27.9','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('28','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('28.1','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('28.2','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('28.3','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('28.4','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('28.5','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('28.6','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('28.7','17,13,10');
INSERT INTO srmRgb(srm, rgb) VALUES('28.8','18,13,12');
INSERT INTO srmRgb(srm, rgb) VALUES('28.9','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('29','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('29.1','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('29.2','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('29.3','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('29.4','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('29.5','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('29.6','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('29.7','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('29.8','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('29.9','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('30','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('30.1','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('30.2','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('30.3','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('30.4','16,11,10');
INSERT INTO srmRgb(srm, rgb) VALUES('30.5','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('30.6','15,10,9');
INSERT INTO srmRgb(srm, rgb) VALUES('30.7','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('30.8','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('30.9','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('31','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('31.1','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('31.2','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('31.3','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('31.4','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('31.5','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('31.6','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('31.7','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('31.8','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('31.9','14,9,8');
INSERT INTO srmRgb(srm, rgb) VALUES('32','15,11,8');
INSERT INTO srmRgb(srm, rgb) VALUES('32.1','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('32.2','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('32.3','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('32.4','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('32.5','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('32.6','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('32.7','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('32.8','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('32.9','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('33','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('33.1','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('33.2','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('33.3','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('33.4','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('33.5','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('33.6','12,9,7');
INSERT INTO srmRgb(srm, rgb) VALUES('33.7','10,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('33.8','10,7,5');
INSERT INTO srmRgb(srm, rgb) VALUES('33.9','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('34','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('34.1','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('34.2','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('34.3','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('34.4','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('34.5','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('34.6','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('34.7','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('34.8','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('34.9','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('35','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('35.1','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('35.2','8,7,7');
INSERT INTO srmRgb(srm, rgb) VALUES('35.3','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('35.4','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('35.5','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('35.6','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('35.7','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('35.8','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('35.9','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('36','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('36.1','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('36.2','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('36.3','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('36.4','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('36.5','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('36.6','7,6,6');
INSERT INTO srmRgb(srm, rgb) VALUES('36.7','7,7,4');
INSERT INTO srmRgb(srm, rgb) VALUES('36.8','6,6,3');
INSERT INTO srmRgb(srm, rgb) VALUES('36.9','6,5,5');
INSERT INTO srmRgb(srm, rgb) VALUES('37','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('37.1','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('37.2','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('37.3','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('37.4','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('37.5','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('37.6','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('37.7','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('37.8','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('37.9','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('38','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('38.1','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('38.2','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('38.3','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('38.4','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('38.5','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('38.6','4,5,4');
INSERT INTO srmRgb(srm, rgb) VALUES('38.7','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('38.8','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('38.9','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('39','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('39.1','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('39.2','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('39.3','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('39.4','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('39.5','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('39.6','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('39.7','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('39.8','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('39.9','3,4,3');
INSERT INTO srmRgb(srm, rgb) VALUES('40','3,4,3');




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
