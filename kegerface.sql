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
-- Database: `kegerface`
--
CREATE DATABASE IF NOT EXISTS `kegerface` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `kegerface`;

-- --------------------------------------------------------

--
-- Table structure for table `beer`
--

CREATE TABLE IF NOT EXISTS `beer` (
  `name` text NOT NULL,
  `style` text NOT NULL,
  `notes` text NOT NULL,
  `gravity` decimal(4,3) NOT NULL,
  `srm` int(3) NOT NULL,
  `balance` decimal(6,2) NOT NULL,
  `ibu` int(4) NOT NULL,
  `calories` int(10) NOT NULL,
  `abv` decimal(2,1) NOT NULL,
  `poured` decimal(6,1) NOT NULL,
  `remaining` decimal(6,1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `tapnumber` int(11) NOT NULL,
  `beerid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`beerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `beer`
--

INSERT INTO `beer` (`name`, `style`, `notes`, `gravity`, `srm`, `balance`, `ibu`, `calories`, `abv`, `poured`, `remaining`, `active`, `tapnumber`, `beerid`) VALUES
('Darth Vader', 'Cadcadian Dark Ale', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', '1.066', 38, '1.00', 66, 222, '7.0', '5.3', '48.0', 1, 1, 1),
('OktoberFAST', 'Marzen', 'Dark copper body. Thick, chewy, off-white head. Toasty and earthy aromas. Mid-bodied with a semi-bitter, highly-attenuated finish.', '1.051', 13, '0.39', 20, 172, '5.0', '16.0', '37.7', 1, 2, 2),
('Strong Scotch', 'Scotch Ale', 'Slightly sweet. Hints of malt and toffee. Finishes with roasted nuts and coffee. Complex and roasty.', '1.074', 18, '0.36', 27, 253, '7.4', '26.7', '26.7', 1, 3, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
