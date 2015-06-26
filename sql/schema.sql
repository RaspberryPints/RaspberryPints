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
-- Table structure for table `beerStyles`
--

CREATE TABLE IF NOT EXISTS `beerStyles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`catNum` tinytext NOT NULL,
	`category` tinytext NOT NULL,
	`ogMin` decimal(4,3) NOT NULL,
	`ogMax` decimal(4,3) NOT NULL,
	`fgMin` decimal(4,3) NOT NULL,
	`fgMax` decimal(4,3) NOT NULL,
	`abvMin` decimal(3,1) NOT NULL,
	`abvMax` decimal(3,1) NOT NULL,
	`ibuMin` decimal(3) NOT NULL,
	`ibuMax` decimal(3) NOT NULL,
	`srmMin` decimal(2) NOT NULL,
	`srmMax` decimal(2) NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beerStyles`
--
-- Category 1
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'American Light Lager', '1A', 'Standard American Beer', '1.028', '1.04', '0.998', '1.008', '2.8', '4.2', '8', '12', '2', '3', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'American Lager', '1B', 'Standard American Beer', '1.04', '1.05', '1.004', '1.01', '4.2', '5.3', '8', '18', '2', '4', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Cream Ale', '1C', 'Standard American Beer', '1.046', '1.056', '1.008', '1.012', '4.6', '6', '15', '25', '2', '6', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'American Wheat Beer', '1D', 'Standard American Beer', '1.040', '1.055', '1.008', '1.013', '4.0', '5.5', '15', '30', '3', '6', NOW(), NOW() );
-- Category 2
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'International Pale Lager', '2A', 'International Lager', '1.042', '1.050', '1.08', '1.012', '4.6', '6', '18', '25', '2', '6', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'International Amber Lager', '2B', 'International Lager', '1.042', '1.055', '1.008', '1.014', '4.6', '6', '8', '25', '7', '14', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'International Dark Lager', '2C', 'International Lager', '1.044', '1.056', '1.013', '1.017', '4.2', '5.4', '35', '45', '3.5', '6', NOW(), NOW() );
-- Category 3
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Czech Pale Lager', '3A', 'Czech Lager', '1.028', '1.044', '1.08', '1.014', '3', '4.1', '20', '35', '3', '6', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Czech Premium Pale Lager', '3B', 'Czech Lager', '1.044', '1.060', '1.013', '1.017', '4.2', '5.8', '30', '45', '3.5', '6', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Czech Amber Lager', '3C', 'Czech Lager', '1.044', '1.060', '1.013', '1.017', '4.4', '5.8', '20', '35', '10', '16', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Czech Dark Lager', '3D', 'Czech Lager', '1.044', '1.060', '1.013', '1.017', '4.4', '5.8', '18', '34', '14', '35', NOW(), NOW() );
-- Category 4
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Munich Helles', '4A', 'Pale Malty European Lager', '1.044', '1.048', '1.006', '1.012', '4.7', '5.4', '16', '22', '3', '5', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Festbier', '4B', 'Pale Malty European Lager', '1.054', '1.057', '1.01', '1.012', '5.8', '6.3', '18', '25', '4', '7', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Helles Bock', '4C', 'Pale Malty European Lager', '1.064', '1.072', '1.011', '1.018', '6.3', '7.4', '23', '35', '6', '11', NOW(), NOW() );
-- Category 5
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'German Leichtbier', '5A', 'Pale Bitter European Beer', '1.026', '1.034', '1.006', '1.01', '2.4', '3.6', '15', '28', '2', '5', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Kolsch', '5B', 'Pale Bitter European Beer', '1.044', '1.05', '1.007', '1.011', '4.4', '5.2', '18', '30', '3.5', '5', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'German Helles Exportbier', '5C', 'Pale Bitter European Beer', '1.048', '1.056', '1.01', '1.015', '4.8', '6', '20', '30', '4', '7', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'German Pils', '5D', 'Pale Bitter European Beer', '1.044', '1.05', '1.008', '1.013', '4.4', '5.2', '22', '40', '2', '5', NOW(), NOW() );
-- Category 6
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Marzen', '6A', 'Amber Malty European Lager', '1.054', '1.06', '1.01', '1.014', '5.8', '6.3', '18', '24', '8', '17', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Rachbier', '6B', 'Amber Malty European Lager', '1.050', '1.057', '1.012', '1.016', '4.8', '6', '20', '30', '12', '22', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Dunkles Bock', '6C', 'Amber Malty European Lager', '1.064', '1.072', '1.013', '1.019', '6.3', '7.2', '20', '27', '14', '22', NOW(), NOW() );
-- Category 7
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Vienna Lager', '7A', 'Amber Bitter European Beer', '1.048', '1.055', '1.01', '1.014', '4.7', '5.5', '18', '30', '9', '15', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Altbier', '7B', 'Amber Bitter European Beer', '1.044', '1.052', '1.008', '1.014', '4.3', '5.5', '25', '50', '11', '17', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Kellerbier', '7C', 'Amber Bitter European Beer', '1.045', '1.051', '1.008', '1.012', '4.7', '5.4', '20', '30', '3', '7', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Amber Kellerbier', '7C', 'Amber Bitter European Beer', '1.048', '1.054', '1.012', '1.016', '4.8', '5.4', '25', '40', '7', '17', NOW(), NOW() );
-- Category 8
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Munich Dunkel', '8A', 'Dark European Lager', '1.048', '1.056', '1.01', '1.016', '4.5', '5.6', '18', '28', '14', '28', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Schwarzbier', '8B', 'Dark European Lager', '1.046', '1.052', '1.01', '1.016', '4.4', '5.4', '20', '30', '17', '30', NOW(), NOW() );
-- Category 9
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Doppelbock', '9A', 'Strong European Beer', '1.072', '1.112', '1.016', '1.024', '7', '10', '16', '26', '6', '25', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Eisbock', '9B', 'Strong European Beer', '1.078', '1.12', '1.02', '1.035', '9', '14', '25', '35', '18', '30', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Baltic Porter', '9C', 'Strong European Beer', '1.060', '1.090', '1.016', '1.024', '6.5', '9.5', '20', '40', '17', '30', NOW(), NOW() );
-- Category 10
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Weissbier', '10A', 'German Wheat Beer', '1.044', '1.052', '1.01', '1.014', '4.3', '5.6', '8', '15', '2', '6', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Dunkles Weissbier', '10B', 'German Wheat Beer', '1.044', '1.056', '1.01', '1.014', '4.3', '5.6', '10', '18', '14', '23', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Weizenbock', '10C', 'German Wheat Beer', '1.064', '1.09', '1.015', '1.022', '6.5', '9', '15', '30', '6', '25', NOW(), NOW() );
-- Category 11
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Ordinary Bitter', '11A', 'British Bitter', '1.03', '1.039', '1.007', '1.011', '3.2', '3.8', '25', '35', '8', '14', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Best Bitter', '11B', 'British Bitter', '1.04', '1.048', '1.008', '1.012', '3.8', '4.6', '25', '40', '8', '16', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Strong Bitter', '11C', 'British Bitter', '1.048', '1.06', '1.01', '1.016', '4.6', '6.2', '30', '50', '8', '18', NOW(), NOW() );
-- Category 12
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'British Golden Ale', '12A', 'Pale Commonwealth Beer', '1.038', '1.053', '1.006', '1.012', '3.8', '5', '20', '45', '2', '6', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Australian Sparkiling Ale', '12B', 'Pale Commonwealth Beer', '1.038', '1.05', '1.004', '1.006', '4.5', '6', '20', '35', '4', '7', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'English IPA', '12C', 'Pale Commonwealth Beer', '1.05', '1.075', '1.01', '1.018', '5.0', '7.5', '40', '60', '6', '14', NOW(), NOW() );
-- Category 13
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Dark Mild', '13A', 'Brown British Beer', '1.03', '1.038', '1.008', '1.013', '3.0', '3.8', '10', '25', '12', '25', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'British Brown Ale', '13B', 'Brown British Beer', '1.04', '1.052', '1.008', '1.013', '4.2', '5.4', '20', '30', '12', '22', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'English Porter', '13C', 'Brown British Beer', '1.04', '1.052', '1.008', '1.014', '4.0', '5.4', '18', '35', '20', '30', NOW(), NOW() );
-- Category 14
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Scottish Light', '14A', 'Sottish Ale', '1.03', '1.035', '1.01', '1.013', '2.5', '3.2', '10', '20', '17', '22', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Scottish Heavy', '14B', 'Scottish Ale', '1.035', '1.04', '1.01', '1.015', '3.2', '3.9', '10', '20', '13', '22', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Scottish Export', '14C', 'Scottish Ale', '1.04', '1.06', '1.01', '1.016', '3.9', '6', '15', '30', '13', '22', NOW(), NOW() );
-- Category 15
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Irish Red Ale', '15A', 'Irish Beer', '1.036', '1.046', '1.01', '1.014', '3.8', '5', '18', '28', '9', '14', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Irish Stout', '15B', 'Irish Beer', '1.036', '1.044', '1.007', '1.011', '4.0', '4.5', '25', '45', '25', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Irish Extra Stout', '15C', 'Irish Beer', '1.052', '1.062', '1.01', '1.014', '5.5', '6.5', '35', '50', '25', '40', NOW(), NOW() );
-- Category 16
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Sweet Stout', '16A', 'Dark British Beer', '1.044', '1.06', '1.012', '1.024', '4', '6', '20', '40', '30', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Oatmeal Stout', '16B', 'Dark British Beer', '1.045', '1.065', '1.01', '1.018', '4.2', '5.9', '25', '40', '22', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Tropical Stout', '16C', 'Dark British Beer', '1.056', '1.075', '1.01', '1.018', '5.5', '8', '30', '50', '30', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Foreign Extra Stout', '16D', 'Dark British Beer', '1.056', '1.075', '1.01', '1.018', '6.3', '8', '50', '70', '30', '40', NOW(), NOW() );
-- Category 17
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'British Strong Ale', '17A', 'Strong British Ale', '1.055', '1.08', '1.015', '1.022', '5.5', '8', '30', '60', '8', '22', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Old Ale', '17B', 'Strong British Beer', '1.055', '1.088', '1.015', '1.022', '5.5', '9', '30', '60', '10', '22', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Wee Heavy', '17C', 'Strong British Beer', '1.07', '1.130', '1.018', '1.04', '6.5', '10', '17', '35', '14', '25', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'English Barleywine', '17D', 'Strong British Beer', '1.08', '1.12', '1.018', '1.03', '8', '12', '35', '70', '8', '22', NOW(), NOW() );
-- Category 18
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Blonde Ale', '18A', 'Pale American Ale', '1.038', '1.054', '1.008', '1.013', '3.8', '5.5', '15', '28', '3', '6', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'American Pale Ale', '18B', 'Pale American Ale', '1.045', '1.06', '1.01', '1.015', '4.5', '6.2', '30', '50', '5', '10', NOW(), NOW() );
-- Category 19
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'American Amber Ale', '19A', 'Amber and Brown American Beer', '1.045', '1.06', '1.01', '1.015', '4.5', '6.2', '25', '40', '10', '17', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Californa Common', '19B', 'Amber and Brown American Beer', '1.048', '1.054', '1.011', '1.014', '4.5', '5.5', '30', '45', '10', '14', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Amberican Brown Ale', '19C', 'Amber and Brown American Beer', '1.045', '1.06', '1.01', '1.016', '4.3', '6.2', '20', '30', '18', '35', NOW(), NOW() );
-- Category 20
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'American Porter', '20A', 'American Porter and Stout', '1.05', '1.07', '1.012', '1.018', '4.8', '6.5', '25', '50', '22', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'American Stout', '20B', 'American Porter and Stout', '1.05', '1.075', '1.01', '1.022', '5', '7', '35', '75', '30', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Imperial Stout', '20C', 'American Porter and Stout', '1.075', '1.115', '1.018', '1.030', '8', '12', '50', '90', '30', '40', NOW(), NOW() );
-- Category 21
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'American IPA', '21A', 'India Pale Ale', '1.056', '1.07', '1.008', '1.014', '5.5', '7.5', '40', '70', '6', '14', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Specialty IPA: Belgian IPA', '21B', 'India Pale Ale', '1.058', '1.08', '1.008', '1.016', '6.2', '9.5', '50', '100', '5', '15', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Specialty IPA: Black IPA', '21B', 'India Pale Ale', '1.05', '1.085', '1.01', '1.018', '5.5', '9', '50', '90', '25', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Specialty IPA: Brown IPA', '21B', 'India Pale Ale', '1.056', '1.07', '1.008', '1.016', '5.5', '7.5', '40', '70', '11', '19', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Specialty IPA: Red IPA', '21B', 'India Pale Ale', '1.056', '1.07', '1.008', '1.016', '5.5', '7.5', '40', '70', '11', '19', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Specialty IPA: Rye IPA', '21B', 'India Pale Ale', '1.056', '1.075', '1.008', '1.014', '5.5', '8', '50', '75', '6', '14', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Specialty IPA: White IPA', '21B', 'India Pale Ale', '1.056', '1.065', '1.01', '1.016', '5.5', '7', '40', '70', '5', '8', NOW(), NOW() );
-- Category 22
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Double IPA', '22A', 'Strong American Ale', '1.065', '1.085', '1.008', '1.018', '7.5', '10', '60', '120', '6', '14', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'American Strong Ale', '22B', 'Strong American Ale', '1.062', '1.09', '1.014', '1.024', '6.3', '10', '50', '100', '7', '19', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'American Barleywine', '22C', 'Strong American Ale', '1.08', '1.12', '1.016', '1.03', '8', '12', '50', '100', '10', '19', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Wheatwine', '22D', 'Strong American Ale', '1.08', '1.012', '1.016', '1.03', '8', '12', '30', '60', '8', '15', NOW(), NOW() );
-- Category 23
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Berliner Weisse', '23A', 'European Sour Ale', '1.028', '1.032', '1.003', '1.006', '2.8', '3.8', '3', '8', '2', '3', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Flanders Red Ale', '23B', 'European Sour Ale', '1.048', '1.057', '1.002', '1.012', '4.6', '6.5', '10', '25', '10', '16', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Oud Bruin', '23C', 'European Sour Ale', '1.04', '1.074', '1.008', '1.012', '4', '8', '20', '25', '15', '22', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Lambic', '23D', 'European Sour Ale', '1.04', '1.054', '1.001', '1.01', '5', '6.5', '0', '10', '3', '7', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Gueuze', '23E', 'European Sour Ale', '1.04', '1.06', '1.000', '1.006', '5', '8', '0', '10', '3', '7', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Fruit Lambic', '23F', 'European Sour Ale', '1.04', '1.06', '1.000', '1.010', '5', '7', '0', '10', '3', '7', NOW(), NOW() );
-- Category 24
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Witbier', '24A', 'Belgian Ale', '1.044', '1.052', '1.008', '1.012', '4.5', '5.5', '8', '20', '2', '4', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Belgian Pale Ale', '24B', 'Belgian Ale', '1.048', '1.054', '1.01', '1.014', '4.8', '5.5', '20', '30', '8', '14', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Biere de Garde', '24C', 'Belgian Ale', '1.06', '1.08', '1.008', '1.016', '6', '8.5', '18', '28', '6', '19', NOW(), NOW() );
-- Category 25
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Belgian Blond Ale', '25A', 'Strong Belgian Ale', '1.062', '1.075', '1.008', '1.018', '6', '7.5', '15', '30', '4', '7', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Saison', '25B', 'Strong Belgian Ale', '1.048', '1.065', '1.002', '1.008', '3.5', '9.5', '20', '35', '5', '22', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Belgian Golden Strong Ale', '25C', 'Strong Belgian Ale', '1.07', '1.095', '1.005', '1.016', '7.5', '10.5', '22', '35', '3', '6', NOW(), NOW() );
-- Category 26
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Trappist Single', '26A', 'Trappist Ale', '1.044', '1.054', '1.004', '1.01', '4.8', '6', '25', '45', '3', '5', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Belgian Dubbel', '26B', 'Trappist Ale', '1.062', '1.075', '1.008', '1.018', '6', '7.6', '15', '25', '10', '17', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Belgian Tripel', '26C', 'Trappist Ale', '1.075', '1.085', '1.008', '1.014', '7.5', '9.5', '20', '40', '4.5', '7', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Belgian Dark Strong Ale', '26D', 'Trappist Ale', '1.075', '1.11', '1.01', '1.024', '8', '12', '20', '35', '12', '22', NOW(), NOW() );
-- Category 27
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Gose', '27', 'HIstorical Beer', '1.036', '1.056', '1.006', '1.01', '4.2', '4.8', '5', '12', '3', '4', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Kentuck Common', '27', 'Historical Beer', '1.044', '1.055', '1.01', '1.018', '4', '5', '15', '30', '11', '20', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Lichtenhainer', '27', 'Historical Beer', '1.032', '1.04', '1.004', '1.008', '3.5', '4.7', '5', '12', '3', '6', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'London Brown Ale', '27', 'Historical Beer', '1.033', '1.038', '1.012', '1.015', '2.8', '3.6', '15', '20', '22', '35', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Piwo Grodziskie aka Gratzer', '27', 'Historical Beer', '1.028', '1.032', '1.006', '1.012', '2.5', '3.3', '20', '35', '3', '6', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Pre-Prohibition Lager', '27', 'Historical Beer', '1.044', '1.06', '1.01', '1.015', '4.5', '6', '25', '40', '3', '6', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Pre-Prohibition Porter', '27', 'Historical Beers', '1.046', '1.06', '1.01', '1.016', '4.5', '6', '20', '30', '18', '30', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Roggenbier', '27', 'Historical Beer', '1.046', '1.056', '1.01', '1.014', '4.5', '6', '10', '20', '14', '19', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Sahti', '27', 'Historical Beer', '1.076', '1.120', '1.016', '1.020', '7', '11', '7', '15', '4', '22', NOW(), NOW() );
-- Category 28 
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Brett Beer', '28A', 'American Wild Ale', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Mixed-Fermentation Sour Beer', '28B', 'American Wild Ale', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Wild Specialty Beer', '28C', 'American Wild Ale', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
-- Category 29
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Fruit Beer', '29A', 'Fruit Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Fruit and Spice Beer', '29B', 'Fruit Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Specialty Fruit Beer', '29C', 'Fruit Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
-- Category 30
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Spice Herb or Vegetable Beer', '30A', 'Spiced Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Autumn Seasonal Beer', '30B', 'Spiced Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Winter Seasonal', '30C', 'Spiced Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
-- Category 31
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Alternative Grain Beer', '31A', 'Alternative Fermentables  Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Alternative Sugar Beer', '31B', 'Alternative Fermentables  Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
-- Category 32
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Classic Style Smoked Beer', '32A', 'Smoked Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Specialty Smoked Beer', '32B', 'Smoked Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
-- Category 33 
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Wood Aged Beer', '33A', 'Wood Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Specialty Wood-Aged Beer', '33B', 'Wood Beer', '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
-- Catergory 34
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Clone Beer', '34A', 'Specialty Beer',  '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Mixed Style Beer', '34B', 'Specialty Beer',  '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Experimental Beer', '34C', 'Specialty Beer',  '1.000', '1.120', '1.000', '1.020', '0', '12', '0', '150', '1', '40', NOW(), NOW() );
-- Category Mead 1
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Dry Mead', 'M1A', 'Traditional Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Semi Sweet Mead', 'M1B', 'Traditional Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Sweet Mead', 'M1C', 'Traditional Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
-- Category Mead 2
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Cyser', 'M2A', 'Fruit Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Pyment', 'M2B', 'Fruit Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Berry Mead', 'M2C', 'Fruit Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Stone Fruit Mead', 'M2D', 'Fruit Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Melomel', 'M2E', 'Fruit Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
-- Category Mead 3
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Fruit and Spiced Mead', 'M3A', 'Spiced Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Spice Herb or Vegetable Mead', 'M3B', 'Spiced Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
-- Category Mead 4
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Braggot', 'M4A', 'Specialty Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Historical Mead', 'M4B', 'Specialty Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Experimental Mead', 'M4C', 'Specialty Mead',  '1.035', '1.170', '0.990', '1.050', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() );
-- Category Cider 1
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'New World Cider', 'C1A', 'Standard Cider and Perry',  '1.045', '1.065', '0.995', '1.020', '5', '8', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'English Cider', 'C1B', 'Standard Cider and Perry',  '1.050', '1.075', '0.995', '1.015', '6', '9', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'French Cider', 'C1C', 'Standard Cider and Perry',  '1.050', '1.065', '1.01', '1.020', '3', '6', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'New World Perry', 'C1D', 'Standard Cider and Perry',  '1.050', '1.06', '1.0', '1.020', '5', '7', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Traditional Perry', 'C1E', 'Standard Cider and Perry',  '1.050', '1.070', '1.000', '1.020', '5', '9', '0', '0', '0', '40', NOW(), NOW() );
-- Category Cider 2
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'New England Cider', 'C2A', 'Specialty Cider and Perry',  '1.060', '1.1', '0.995', '1.020', '7', '13', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Cider with Other Fruit', 'C2B', 'Specialty Cider and Perry',  '1.045', '1.07', '0.995', '1.010', '5', '9', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Applewine', 'C2C', 'Specialty Cider and Perry',  '1.070', '1.1', '0.995', '1.020', '9', '12', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Ice Cider', 'C2D', 'Specialty Cider and Perry',  '1.13', '1.18', '1.06', '1.085', '7', '13', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Cider with Herb and Spcies', 'C2E', 'Specialty Cider and Perry',  '1.045', '1.07', '0.995', '1.010', '5', '9', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( 'Specialty Cider and Perry', 'C2F', 'Specialty Cider and Perry',  '1.045', '1.1', '0.995', '1.020', '5', '12', '0', '0', '0', '40', NOW(), NOW() );
-- Category Non Alcoholic
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( '_Non-Alcoholic Beer', 'N/A', 'Non Alcoholic Beer',  '1.00', '1.0', '1.00', '1.00', '0', '0', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( '_Non-Beer: Wine', 'N/A', 'Wine',  '1.00', '1.0', '1.00', '1.00', '0', '0', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( '_Non-Beer: Kombucha', 'N/A', 'Kombucha',  '1.00', '1.0', '1.00', '1.00', '0', '0', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( '_Non-Beer: Tea', 'N/A', 'Tea',  '1.00', '1.0', '1.00', '1.00', '0', '0', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( '_Non-Beer: Coffee', 'N/A', 'Coffee',  '1.00', '1.0', '1.00', '1.00', '0', '0', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( '_Non-Beer: Fruit Juice', 'N/A', 'Fruit Juice',  '1.00', '1.0', '1.00', '1.00', '0', '0', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( '_Non-Beer: Fruit Drink', 'N/A', 'Fruit Drink',  '1.00', '1.0', '1.00', '1.00', '0', '0', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( '_Non-Beer: Seltzer Water', 'N/A', 'WSeltzer Water',  '1.00', '1.0', '1.00', '1.00', '0', '0', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( '_Non-Beer: Fruit Soda', 'N/A', 'Fruit Soda',  '1.00', '1.0', '1.00', '1.00', '0', '0', '0', '0', '0', '40', NOW(), NOW() );
INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES ( '_Non-Beer: Rootbeer', 'N/A', 'Rootbeer',  '1.00', '1.0', '1.00', '1.00', '0', '0', '0', '0', '0', '40', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Table structure for table `beers`
--

CREATE TABLE IF NOT EXISTS `beers` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` text NOT NULL,
	`beerStyleId` int(11) NOT NULL,
	`notes` text NOT NULL,
	`ogEst` decimal(4,3) NOT NULL,
	`fgEst` decimal(4,3) NOT NULL,
	`srmEst` decimal(3,1) NOT NULL,
	`ibuEst` int(4) NOT NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,

PRIMARY KEY (`id`),
FOREIGN KEY (`beerStyleId`) REFERENCES beerStyles(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`configName` varchar(50) NOT NULL,
	`configValue` longtext NOT NULL,
	`displayName` varchar(65) NOT NULL,
	`showOnPanel` tinyint(2) NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,

	PRIMARY KEY (`id`),
	UNIQUE KEY `configName_UNIQUE` (`configName`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'showTapNumCol', '1', 'Tap Column', '1', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'showSrmCol', '1', 'SRM Column', '1', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'showIbuCol', '1', 'IBU Column', '1', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'showAbvCol', '1', 'ABV Column', '1', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'showAbvImg', '1', 'ABV Image', '1', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'showKegCol', '1', 'Keg Column', '1', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'useHighResolution', '0', '4k Monitor Support', '1', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'logoUrl', 'img/logo.png', 'Logo Url', '0', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'adminLogoUrl', 'admin/img/logo.png', 'Admin Logo Url', '0', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'headerText', 'Currently On Tap', 'Header Text', '0', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'numberOfTaps', '0', 'Number of Taps', '0', NOW(), NOW() );
INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES ( 'version', '1.0.0.279', 'Version', '0', NOW(), NOW() );


-- --------------------------------------------------------

--
-- Table structure for table `kegTypes`
--

CREATE TABLE IF NOT EXISTS `kegTypes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`displayName` text NOT NULL,
	`maxAmount` decimal(6,2) NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegTypes`
--

INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Ball Lock (5 gal)', '5', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Ball Lock (2.5 gal)', '2.5', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Ball Lock (3 gal)', '3', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Ball Lock (10 gal)', '10', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Pin Lock (5 gal)', '5', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Sanke (1/6 bbl)', '5.16', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Sanke (1/4 bbl)', '7.75', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Sanke (slim 1/4 bbl)', '7.75', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Sanke (1/2 bbl)', '15.5', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Sanke (Euro)', '13.2', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Cask (pin)', '10.81', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Cask (firkin)', '10.81', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Cask (kilderkin)', '21.62', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Cask (barrel)', '43.23', NOW(), NOW() );
INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES ( 'Cask (hogshead)', '64.85', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Table structure for table `kegStatuses`
--

CREATE TABLE IF NOT EXISTS `kegStatuses` (
	`code` varchar(20) NOT NULL,
	`name` text NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`code`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegStatuses`
--

INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES ( 'SERVING', 'Serving', NOW(), NOW() );
INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES ( 'PRIMARY', 'Primary', NOW(), NOW() );
INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES ( 'SECONDARY', 'Secondary', NOW(), NOW() );
INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES ( 'DRY_HOPPING', 'Dry Hopping', NOW(), NOW() );
INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES ( 'BULK_AGING', 'Bulk Aging', NOW(), NOW() );
INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES ( 'FLOODED', 'Flooded', NOW(), NOW() );
INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES ( 'SANITIZED', 'Sanitized', NOW(), NOW() );
INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES ( 'NEEDS_CLEANING', 'Needs Cleaning', NOW(), NOW() );
INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES ( 'NEEDS_PARTS', 'Needs Parts', NOW(), NOW() );
INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES ( 'NEEDS_REPAIRS', 'Needs Repairs', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Table structure for table `kegs`
--

CREATE TABLE IF NOT EXISTS `kegs` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`label` int(11) NOT NULL,
	`kegTypeId` int(11) NOT NULL,
	`make` text NOT NULL,
	`model` text NOT NULL,
	`serial` text NOT NULL,
	`stampedOwner` text NOT NULL,
	`stampedLoc` text NOT NULL,
	`notes` text NOT NULL,
	`kegStatusCode` varchar(20) NOT NULL,
	`weight` decimal(11,4) NOT NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`kegStatusCode`) REFERENCES kegStatuses(`Code`) ON DELETE CASCADE,
	FOREIGN KEY (`kegTypeId`) REFERENCES kegTypes(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `taps`
--

CREATE TABLE IF NOT EXISTS `taps` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`beerId` int(11) NOT NULL,
	`kegId` int(11) NOT NULL,
	`tapNumber` int(11) NOT NULL,
	`active` tinyint(1) NOT NULL,
	`ogAct` decimal(4,3) NOT NULL,
	`fgAct` decimal(4,3) NOT NULL,
	`srmAct` decimal(3,1) NOT NULL,
	`ibuAct` int(4) NOT NULL,
	`startAmount` decimal(6,1) NOT NULL,
	`currentAmount` decimal(6,1) NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`kegId`) REFERENCES kegs(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pours`
--

CREATE TABLE IF NOT EXISTS `pours` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`tapId` int(11) NOT NULL,
	`amountPoured` decimal(6,1) NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (tapId) REFERENCES taps(id) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

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
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '0.0','252,252,243', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '0.1','248,248,230', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '0.2','248,248,220', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '0.3','247,247,199', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '0.4','244,249,185', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '0.5','247,249,180', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '0.6','248,249,178', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '0.7','244,246,169', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '0.8','245,247,166', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '0.9','246,247,156', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '1.0','243,249,147', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '1.1','246,248,141', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '1.2','246,249,136', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '1.3','245,250,128', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '1.4','246,249,121', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '1.5','248,249,114', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '1.6','243,249,104', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '1.7','246,248,107', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '1.8','248,247,99', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '1.9','245,247,92', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '2.0','248,247,83', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '2.1','244,248,72', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '2.2','248,247,73', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '2.3','246,247,62', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '2.4','241,248,53', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '2.5','244,247,48', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '2.6','246,249,40', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '2.7','243,249,34', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '2.8','245,247,30', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '2.9','248,245,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '3.0','246,245,19', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '3.1','244,242,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '3.2','244,240,21', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '3.3','243,242,19', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '3.4','244,238,24', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '3.5','244,237,29', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '3.6','238,233,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '3.7','240,233,23', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '3.8','238,231,25', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '3.9','234,230,21', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '4.0','236,230,26', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '4.1','230,225,24', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '4.2','232,225,25', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '4.3','230,221,27', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '4.4','224,218,23', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '4.5','229,216,31', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '4.6','229,214,30', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '4.7','223,213,26', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '4.8','226,213,28', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '4.9','223,209,29', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '5.0','224,208,27', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '5.1','224,204,32', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '5.2','221,204,33', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '5.3','220,203,29', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '5.4','218,200,32', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '5.5','220,197,34', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '5.6','218,196,41', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '5.7','217,194,43', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '5.8','216,192,39', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '5.9','213,190,37', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '6.0','213,188,38', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '6.1','212,184,39', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '6.2','214,183,43', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '6.3','213,180,45', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '6.4','210,179,41', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '6.5','208,178,42', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '6.6','208,176,46', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '6.7','204,172,48', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '6.8','204,172,52', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '6.9','205,170,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '7.0','201,167,50', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '7.1','202,167,52', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '7.2','201,166,51', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '7.3','199,162,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '7.4','198,160,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '7.5','200,158,60', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '7.6','194,156,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '7.7','196,155,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '7.8','198,151,60', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '7.9','193,150,60', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '8.0','191,146,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '8.1','190,147,57', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '8.2','190,147,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '8.3','190,145,60', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '8.4','186,148,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '8.5','190,145,58', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '8.6','193,145,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '8.7','190,145,58', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '8.8','191,143,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '8.9','191,141,61', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '9.0','190,140,58', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '9.1','192,140,61', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '9.2','193,138,62', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '9.3','192,137,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '9.4','193,136,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '9.5','195,135,63', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '9.6','191,136,58', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '9.7','191,134,67', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '9.8','193,131,67', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '9.9','190,130,58', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '10.0','191,129,58', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '10.1','191,131,57', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '10.2','191,129,58', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '10.3','191,129,58', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '10.4','190,129,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '10.5','191,127,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '10.6','194,126,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '10.7','188,128,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '10.8','190,124,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '10.9','193,122,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '11.0','190,124,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '11.1','194,121,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '11.2','193,120,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '11.3','190,119,52', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '11.4','182,117,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '11.5','196,116,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '11.6','191,118,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '11.7','190,116,57', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '11.8','191,115,58', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '11.9','189,115,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '12.0','191,113,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '12.1','191,113,53', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '12.2','188,112,57', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '12.3','190,112,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '12.4','184,110,52', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '12.5','188,109,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '12.6','189,109,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '12.7','186,106,50', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '12.8','190,103,52', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '12.9','189,104,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '13.0','188,103,51', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '13.1','188,103,51', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '13.2','186,101,51', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '13.3','186,102,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '13.4','185,100,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '13.5','185,98,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '13.6','183,98,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '13.7','181,100,53', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '13.8','182,97,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '13.9','177,97,51', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '14.0','178,96,51', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '14.1','176,96,49', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '14.2','177,96,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '14.3','178,95,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '14.4','171,94,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '14.5','171,92,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '14.6','172,93,59', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '14.7','168,92,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '14.8','169,90,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '14.9','168,88,57', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '15.0','165,89,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '15.1','166,88,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '15.2','165,88,58', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '15.3','161,88,52', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '15.4','163,85,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '15.5','160,86,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '15.6','158,85,57', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '15.7','158,86,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '15.8','159,84,57', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '15.9','156,83,53', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '16.0','152,83,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '16.1','150,83,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '16.2','150,81,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '16.3','146,81,56', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '16.4','147,79,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '16.5','147,79,55', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '16.6','146,78,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '16.7','142,77,51', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '16.8','143,79,53', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '16.9','142,77,54', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '17.0','141,76,50', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '17.1','140,75,50', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '17.2','138,73,49', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '17.3','135,70,45', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '17.4','136,71,49', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '17.5','140,72,49', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '17.6','128,70,45', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '17.7','129,71,46', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '17.8','130,69,47', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '17.9','123,69,45', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '18.0','124,69,45', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '18.1','121,66,40', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '18.2','120,67,40', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '18.3','119,64,38', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '18.4','116,63,34', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '18.5','120,63,35', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '18.6','120,62,37', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '18.7','112,63,35', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '18.8','111,62,36', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '18.9','109,60,34', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '19.0','107,58,30', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '19.1','106,57,31', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '19.2','107,56,31', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '19.3','105,56,28', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '19.4','105,56,28', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '19.5','104,52,31', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '19.6','102,53,27', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '19.7','100,53,26', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '19.8','99,52,25', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '19.9','93,53,24', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '20.0','93,52,26', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '20.1','89,49,20', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '20.2','90,50,21', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '20.3','91,48,20', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '20.4','83,48,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '20.5','88,48,17', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '20.6','86,46,17', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '20.7','81,45,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '20.8','83,44,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '20.9','81,45,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '21.0','78,42,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '21.1','77,43,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '21.2','75,41,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '21.3','74,41,5', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '21.4','78,40,23', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '21.5','83,43,46', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '21.6','78,43,41', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '21.7','78,40,41', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '21.8','76,41,41', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '21.9','74,39,39', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '22.0','74,39,39', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '22.1','69,39,35', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '22.2','70,37,37', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '22.3','68,38,36', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '22.4','64,35,34', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '22.5','64,35,34', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '22.6','62,33,32', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '22.7','58,33,31', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '22.8','61,33,31', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '22.9','58,33,33', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '23.0','54,31,27', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '23.1','52,29,28', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '23.2','52,29,28', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '23.3','49,28,27', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '23.4','48,27,26', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '23.5','48,27,26', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '23.6','44,25,25', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '23.7','44,25,23', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '23.8','42,24,26', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '23.9','40,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '24.0','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '24.1','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '24.2','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '24.3','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '24.4','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '24.5','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '24.6','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '24.7','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '24.8','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '24.9','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '25.0','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '25.1','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '25.2','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '25.3','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '25.4','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '25.5','38,23,22', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '25.6','38,23,24', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '25.7','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '25.8','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '25.9','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '26.0','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '26.1','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '26.2','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '26.3','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '26.4','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '26.5','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '26.6','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '26.7','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '26.8','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '26.9','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '27.0','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '27.1','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '27.2','25,16,15', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '27.3','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '27.4','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '27.5','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '27.6','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '27.7','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '27.8','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '27.9','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '28.0','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '28.1','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '28.2','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '28.3','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '28.4','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '28.5','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '28.6','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '28.7','17,13,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '28.8','18,13,12', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '28.9','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '29.0','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '29.1','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '29.2','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '29.3','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '29.4','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '29.5','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '29.6','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '29.7','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '29.8','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '29.9','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '30.0','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '30.1','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '30.2','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '30.3','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '30.4','16,11,10', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '30.5','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '30.6','15,10,9', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '30.7','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '30.8','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '30.9','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '31.0','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '31.1','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '31.2','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '31.3','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '31.4','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '31.5','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '31.6','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '31.7','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '31.8','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '31.9','14,9,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '32.0','15,11,8', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '32.1','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '32.2','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '32.3','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '32.4','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '32.5','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '32.6','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '32.7','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '32.8','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '32.9','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '33.0','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '33.1','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '33.2','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '33.3','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '33.4','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '33.5','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '33.6','12,9,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '33.7','10,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '33.8','10,7,5', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '33.9','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '34.0','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '34.1','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '34.2','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '34.3','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '34.4','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '34.5','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '34.6','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '34.7','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '34.8','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '34.9','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '35.0','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '35.1','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '35.2','8,7,7', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '35.3','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '35.4','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '35.5','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '35.6','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '35.7','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '35.8','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '35.9','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '36.0','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '36.1','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '36.2','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '36.3','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '36.4','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '36.5','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '36.6','7,6,6', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '36.7','7,7,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '36.8','6,6,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '36.9','6,5,5', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '37.0','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '37.1','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '37.2','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '37.3','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '37.4','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '37.5','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '37.6','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '37.7','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '37.8','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '37.9','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '38.0','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '38.1','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '38.2','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '38.3','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '38.4','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '38.5','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '38.6','4,5,4', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '38.7','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '38.8','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '38.9','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '39.0','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '39.1','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '39.2','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '39.3','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '39.4','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '39.5','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '39.6','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '39.7','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '39.8','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '39.9','3,4,3', NOW(), NOW() );
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES ( '40.0','3,4,3', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Create View `vwGetTapsAmountPoured`
--

CREATE VIEW vwGetTapsAmountPoured
AS
SELECT tapId, SUM(amountPoured) as amountPoured FROM pours GROUP BY tapId;

-- --------------------------------------------------------

--
-- Create View `vwGetActiveTaps`
--

CREATE VIEW vwGetActiveTaps
AS

SELECT
	t.id,
	b.name,
	bs.name as 'style',
	b.notes,
	t.ogAct,
	t.fgAct,
	t.srmAct,
	t.ibuAct,
	t.startAmount,
	IFNULL(p.amountPoured, 0) as amountPoured,
	t.startAmount - IFNULL(p.amountPoured, 0) as remainAmount,
	t.tapNumber,
	s.rgb as srmRgb
FROM taps t
	LEFT JOIN beers b ON b.id = t.beerId
	LEFT JOIN beerStyles bs ON bs.id = b.beerStyleId
	LEFT JOIN srmRgb s ON s.srm = t.srmAct
	LEFT JOIN vwGetTapsAmountPoured as p ON p.tapId = t.Id
WHERE t.active = true
ORDER BY t.tapNumber;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
