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

INSERT INTO `beerStyles`( name, catNum, category, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES
( 'American Light Lager', '1A', 'Standard American Beer', '1.028', '1.04', '0.998', '1.008', '2.8', '4.2', '8', '12', '2', '3', NOW(), NOW() ),
( 'American Lager', '1B', 'Standard American Beer', '1.04', '1.05', '1.004', '1.01', '4.2', '5.3', '8', '18', '2', '4', NOW(), NOW() ),
( 'Cream Ale', '1C', 'Standard American Beer', '1.042', '1.055', '1.006', '1.012', '4.2', '5.6', '8', '20', '2.5', '5', NOW(), NOW() ),
( 'American Wheat Beer', '1D', 'Standard American Beer', '1.04', '1.055', '1.008', '1.013', '4', '5.5', '15', '30', '3', '6', NOW(), NOW() ),
( 'International Pale Lager', '2A', 'International Lager', '1.042', '1.050', '1.008', '1.012', '4.6', '6.0', '18', '25', '2', '6', NOW(), NOW() ),
( 'International Amber Lager', '2B', 'International Lager', '1.042', '1.055', '1.008', '1.014', '4.6', '6.0', '8', '25', '7', '14', NOW(), NOW() ),
( 'International Dark Lager', '2C', 'International Lager', '1.044', '1.056', '1.008', '1.012', '4.2', '6.0', '8', '20', '14', '22', NOW(), NOW() ),
( 'Czech Pale Lager', '3A', 'Czech Lager', '1.028', '1.044', '1.008', '1.014', '3.0', '4.1', '20', '35', '3', '6', NOW(), NOW() ),
( 'Czech Premium Pale Lager', '3B', 'Czech Lager', '1.044', '1.060', '1.013', '1.017', '4.2', '5.8', '30', '45', '3.5', '6', NOW(), NOW() ),
( 'Czech Amber Lager', '3C', 'Czech Lager', '1.044', '1.060', '1.013', '1.017', '4.4', '5.8', '20', '35', '10', '16', NOW(), NOW() ),
( 'Czech Dark Lager', '3D', 'Czech Lager', '1.044', '1.060', '1.013', '1.017', '4.4', '5.8', '18', '34', '14', '35', NOW(), NOW() ),
( 'Munich Helles', '4A', 'Pale Malty European Lager', '1.044', '1.048', '1.006', '1.012', '4.7', '5.4', '16', '22', '3', '5', NOW(), NOW() ),
( 'Festbier', '4B', 'Pale Malty European Lager', '1.054', '1.057', '1.010', '1.012', '5.8', '6.3', '18', '25', '4', '7', NOW(), NOW() ),
( 'Helles Bock', '4C', 'Pale Malty European Lager', '1.064', '1.072', '1.011', '1.018', '6.3', '7.4', '23', '35', '6', '11', NOW(), NOW() ),
( 'German Leichtbier', '5A', 'Pale Bitter European Beer', '1.026', '1.034', '1.006', '1.010', '2.4', '3.6', '15', '28', '2', '5', NOW(), NOW() ),
( 'K&ouml;lsch', '5B', 'Pale Bitter European Beer', '1.044', '1.05', '1.007', '1.011', '4.4', '5.2', '18', '30', '3.5', '5', NOW(), NOW() ),
( 'German Helles Exportbier', '5C', 'Pale Bitter European Beer', '1.048', '1.056', '1.010', '1.015', '4.8', '6.0', '20', '30', '4', '7', NOW(), NOW() ),
( 'German Pils', '5D', 'Pale Bitter European Beer', '1.044', '1.05', '1.008', '1.013', '4.4', '5.2', '22', '40', '2', '5', NOW(), NOW() ),
( 'M&auml;rzen', '6A', 'Amber Malty European Lager', '1.054', '1.06', '1.010', '1.014', '5.8', '6.3', '18', '24', '8', '17', NOW(), NOW() ),
( 'Rauchbier', '6B', 'Amber Malty European Lager', '1.05', '1.057', '1.012', '1.016', '4.8', '6', '20', '30', '12', '22', NOW(), NOW() ),
( 'Dunkles Bock', '6C', 'Amber Malty European Lager', '1.064', '1.072', '1.013', '1.019', '6.3', '7.2', '20', '27', '14', '22', NOW(), NOW() ),
( 'Vienna Lager', '7A', 'Amber Bitter European Beer', '1.048', '1.055', '1.01', '1.014', '4.7', '5.5', '18', '30', '9', '15', NOW(), NOW() ),
( 'Altbier', '7B', 'Amber Bitter European Beer', '1.044', '1.052', '1.008', '1.014', '4.3', '5.5', '25', '50', '11', '17', NOW(), NOW() ),
( 'Kellerbier: Pale Kellerbier', '7C', 'Amber Bitter European Beer', '1.045', '1.051', '1.008', '1.012', '4.7', '5.4', '20', '35', '3', '7', NOW(), NOW() ),
( 'Kellerbier: Amber Kellerbier', '7C', 'Amber Bitter European Beer', '1.048', '1.054', '1.012', '1.016', '4.8', '5.4', '25', '40', '7', '17', NOW(), NOW() ),
( 'Munich Dunkel', '8A', 'Dark European Lager', '1.048', '1.056', '1.01', '1.016', '4.5', '5.6', '18', '28', '14', '28', NOW(), NOW() ),
( 'Schwarzbier', '8B', 'Dark European Lager', '1.046', '1.052', '1.01', '1.016', '4.4', '5.4', '20', '30', '17', '30', NOW(), NOW() ),
( 'Doppelbock', '9A', 'Strong European Beer', '1.072', '1.112', '1.016', '1.024', '7', '10', '16', '26', '6', '25', NOW(), NOW() ),
( 'Eisbock', '9B', 'Strong European Beer', '1.078', '1.12', '1.02', '1.035', '9', '14', '25', '35', '18', '30', NOW(), NOW() ),
( 'Baltic Porter', '9C', 'Strong European Beer', '1.06', '1.09', '1.016', '1.024', '6.5', '9.5', '20', '40', '17', '30', NOW(), NOW() ),
( 'Weissbier', '10A', 'German Wheat Beer', '1.044', '1.052', '1.01', '1.014', '4.3', '5.6', '8', '15', '2', '6', NOW(), NOW() ),
( 'Dunkles Weissbier', '10B', 'German Wheat Beer', '1.044', '1.056', '1.01', '1.014', '4.3', '5.6', '10', '18', '14', '23', NOW(), NOW() ),
( 'Weizenbock', '10C', 'German Wheat Beer', '1.064', '1.09', '1.015', '1.022', '6.5', '9', '15', '30', '6', '25', NOW(), NOW() ),
( 'Ordinary Bitter', '11A', 'British Bitter', '1.030', '1.039', '1.007', '1.011', '3.2', '3.8', '25', '35', '8', '14', NOW(), NOW() ),
( 'Best Bitter', '11B', 'British Bitter', '1.04', '1.048', '1.008', '1.012', '3.8', '4.6', '25', '40', '8', '16', NOW(), NOW() ),
( 'Strong Bitter', '11C', 'British Bitter', '1.048', '1.06', '1.01', '1.016', '4.6', '6.2', '30', '50', '8', '18', NOW(), NOW() ),
( 'British Golden Ale', '12A', 'Pale Commonwealth Beer', '1.038', '1.053', '1.006', '1.012', '3.8', '5.0', '20', '45', '2', '6', NOW(), NOW() ),
( 'Australian Sparkling Ale', '12B', 'Pale Commonwealth Beer', '1.038', '1.050', '1.004', '1.006', '4.5', '6.0', '20', '35', '4', '7', NOW(), NOW() ),
( 'English IPA', '12C', 'Pale Commonwealth Beer', '1.050', '1.075', '1.010', '1.018', '5.0', '7.5', '40', '60', '6', '14', NOW(), NOW() ),
( 'Dark Mild', '13A', 'Brown British Beer', '1.03', '1.038', '1.008', '1.013', '3.0', '3.8', '10', '25', '12', '25', NOW(), NOW() ),
( 'British Brown Ale', '13B', 'Brown British Beer', '1.04', '1.052', '1.008', '1.013', '4.2', '5.4', '20', '30', '12', '22', NOW(), NOW() ),
( 'English Porter', '13C', 'Brown British Beer', '1.04', '1.052', '1.008', '1.014', '4', '5.4', '18', '35', '20', '30', NOW(), NOW() ),
( 'Scottish Light', '14A', 'Scottish Ale', '1.03', '1.035', '1.01', '1.013', '2.5', '3.2', '10', '20', '17', '22', NOW(), NOW() ),
( 'Scottish Heavy', '14B', 'Scottish Ale', '1.035', '1.04', '1.01', '1.015', '3.2', '3.9', '10', '20', '13', '22', NOW(), NOW() ),
( 'Scottish Export', '14C', 'Scottish Ale', '1.04', '1.06', '1.01', '1.016', '3.9', '6', '15', '30', '13', '22', NOW(), NOW() ),
( 'Irish Red Ale', '15A', 'Irish Beer', '1.036', '1.046', '1.01', '1.014', '3.8', '5', '18', '28', '9', '14', NOW(), NOW() ),
( 'Irish Stout', '15B', 'Irish Beer', '1.036', '1.044', '1.007', '1.011', '4.0', '4.5', '25', '45', '25', '40', NOW(), NOW() ),
( 'Irish Extra Stout', '15C', 'Irish Beer', '1.052', '1.062', '1.010', '1.014', '5.5', '6.5', '35', '50', '25', '40', NOW(), NOW() ),
( 'Sweet Stout', '16A', 'Dark British Beer', '1.044', '1.06', '1.012', '1.024', '4', '6', '20', '40', '30', '40', NOW(), NOW() ),
( 'Oatmeal Stout', '16B', 'Dark British Beer', '1.045', '1.065', '1.01', '1.018', '4.2', '5.9', '25', '40', '22', '40', NOW(), NOW() ),
( 'Tropical Stout', '16C', 'Dark British Beer', '1.056', '1.075', '1.01', '1.018', '5.5', '8.0', '30', '50', '30', '40', NOW(), NOW() ),
( 'Foreign Extra Stout', '16D', 'Dark British Beer', '1.056', '1.075', '1.01', '1.018', '6.3', '8', '50', '70', '30', '40', NOW(), NOW() ),
( 'British Strong Ale', '17A', 'Strong British Ale', '1.055', '1.080', '1.015', '1.022', '5.5', '8', '30', '60', '8', '22', NOW(), NOW() ),
( 'Old Ale', '17B', 'Strong British Ale', '1.055', '1.088', '1.015', '1.022', '5.5', '9', '30', '60', '10', '22', NOW(), NOW() ),
( 'Wee Heavy', '17C', 'Strong British Ale', '1.070', '1.130', '1.018', '1.040', '6.5', '10', '17', '35', '14', '25', NOW(), NOW() ),
( 'English Barleywine', '17D', 'Strong British Ale', '1.08', '1.12', '1.018', '1.03', '8', '12', '35', '70', '8', '22', NOW(), NOW() ),
( 'Blonde Ale', '18A', 'Pale American Ale', '1.038', '1.054', '1.008', '1.013', '3.8', '5.5', '15', '28', '3', '6', NOW(), NOW() ),
( 'American Pale Ale', '18B', 'Pale American Ale', '1.045', '1.06', '1.01', '1.015', '4.5', '6.2', '30', '50', '5', '10', NOW(), NOW() ),
( 'American Amber Ale', '19A', 'Amber and Brown American Beer', '1.045', '1.06', '1.01', '1.015', '4.5', '6.2', '25', '40', '10', '17', NOW(), NOW() ),
( 'California Common', '19B', 'Amber and Brown American Beer', '1.048', '1.054', '1.011', '1.014', '4.5', '5.5', '30', '45', '10', '14', NOW(), NOW() ),
( 'American Brown Ale', '19C', 'Amber and Bron American Beer', '1.045', '1.06', '1.01', '1.016', '4.3', '6.2', '20', '30', '18', '35', NOW(), NOW() ),
( 'American Porter', '20A', 'American Porter and Stout', '1.05', '1.070', '1.012', '1.018', '4.8', '6.5', '25', '50', '22', '40', NOW(), NOW() ),
( 'American Stout', '20B', 'American Porter and Stout', '1.05', '1.075', '1.01', '1.022', '5', '7', '35', '75', '30', '40', NOW(), NOW() ),
( 'Imperial Stout', '20C', 'American Porter and Stout', '1.075', '1.115', '1.018', '1.03', '8', '12', '50', '90', '30', '40', NOW(), NOW() ),
( 'American IPA', '21A', 'IPA', '1.056', '1.070', '1.008', '1.014', '5.5', '7.5', '40', '70', '6', '14', NOW(), NOW() ),
( 'Specialty IPA: Belgian IPA', '21B', 'IPA', '1.058', '1.080', '1.008', '1.016', '6.2', '9.5', '50', '100', '5', '15', NOW(), NOW() ),
( 'Specialty IPA: Black IPA', '21B', 'IPA', '1.050', '1.085', '1.010', '1.018', '5.5', '9.0', '50', '90', '25', '40', NOW(), NOW() ),
( 'Specialty IPA: Brown IPA', '21B', 'IPA', '1.056', '1.070', '1.008', '1.016', '5.5', '7.5', '40', '70', '11', '19', NOW(), NOW() ),
( 'Specialty IPA: Red IPA', '21B', 'IPA', '1.056', '1.070', '1.008', '1.016', '5.5', '7.5', '40', '70', '11', '19', NOW(), NOW() ),
( 'Specialty IPA: Rye IPA', '21B', 'IPA', '1.056', '1.075', '1.008', '1.014', '5.5', '8.0', '50', '75', '6', '14', NOW(), NOW() ),
( 'Specialty IPA: White IPA', '21B', 'IPA', '1.056', '1.065', '1.010', '1.016', '5.5', '7.0', '40', '70', '5', '8', NOW(), NOW() ),
( 'Double IPA', '22A', 'Strong American Ale', '1.065', '1.085', '1.008', '1.018', '7.5', '10', '60', '120', '6', '14', NOW(), NOW() ),
( 'American Strong Ale', '22B', 'Strong American Ale', '1.062', '1.090', '1.014', '1.024', '6.3', '10', '50', '100', '7', '19', NOW(), NOW() ),
( 'American Barleywine', '22C', 'Strong American Ale', '1.08', '1.12', '1.016', '1.03', '8', '12', '50', '100', '10', '19', NOW(), NOW() ),
( 'Wheatwine', '22D', 'Strong American Ale', '1.08', '1.12', '1.016', '1.03', '8', '12', '30', '60', '8', '15', NOW(), NOW() ),
( 'Berliner Weiss', '23A', 'European Sour Ale', '1.028', '1.032', '1.003', '1.006', '2.8', '3.8', '3', '8', '2', '3', NOW(), NOW() ),
( 'Flanders Red Ale', '23B', 'European Sour Ale', '1.048', '1.057', '1.002', '1.012', '4.6', '6.5', '10', '25', '10', '16', NOW(), NOW() ),
( 'Oud Bruin', '23C', 'European Sour Ale', '1.04', '1.074', '1.008', '1.012', '4', '8', '20', '25', '15', '22', NOW(), NOW() ),
( 'Lambic', '23D', 'European Sour Ale', '1.04', '1.054', '1.001', '1.01', '5', '6.5', '0', '10', '3', '7', NOW(), NOW() ),
( 'Gueuze', '23E', 'European Sour Ale', '1.04', '1.06', '1', '1.006', '5', '8', '0', '10', '3', '7', NOW(), NOW() ),
( 'Fruit Lambic', '23F', 'European Sour Ale', '1.04', '1.06', '1', '1.01', '5', '7', '0', '10', '3', '7', NOW(), NOW() ),
( 'Witbier', '24A', 'Belgian Ale', '1.044', '1.052', '1.008', '1.012', '4.5', '5.5', '8', '20', '2', '4', NOW(), NOW() ),
( 'Belgian Pale Ale', '24B', 'Belgian Ale', '1.048', '1.054', '1.01', '1.014', '4.8', '5.5', '20', '30', '8', '14', NOW(), NOW() ),
( 'Bi&egrave;re de Garde', '24C', 'Belgian Ale', '1.06', '1.08', '1.008', '1.016', '6', '8.5', '18', '28', '6', '19', NOW(), NOW() ),
( 'Belgian Blond Ale', '25A', 'Strong Belgian Ale', '1.062', '1.075', '1.008', '1.018', '6', '7.5', '15', '30', '4', '7', NOW(), NOW() ),
( 'Saison', '25B', 'Strong Belgian Ale', '1.048', '1.065', '1.002', '1.008', '3.5', '9.5', '20', '35', '5', '22', NOW(), NOW() ),
( 'Belgian Golden Strong Ale', '25C', 'Strong Belgian Ale', '1.07', '1.095', '1.005', '1.016', '7.5', '10.5', '22', '35', '3', '6', NOW(), NOW() ),
( 'Trappist Single', '26A', 'Trappist Ale', '1.044', '1.054', '1.004', '1.010', '4.8', '6.0', '25', '45', '3', '5', NOW(), NOW() ),
( 'Belgian Dubbel', '26B', 'Trappist Ale', '1.062', '1.075', '1.008', '1.018', '6', '7.6', '15', '25', '10', '17', NOW(), NOW() ),
( 'Belgian Tripel', '26C', 'Trappist Ale', '1.075', '1.085', '1.008', '1.014', '7.5', '9.5', '20', '40', '4.5', '7', NOW(), NOW() ),
( 'Belgian Dark Strong Ale', '26D', 'Trappist Ale', '1.075', '1.11', '1.01', '1.024', '8', '12', '20', '35', '12', '22', NOW(), NOW() ),
( 'Historical Beer: Gose', '27A', 'Historical Beer', '1.036', '1.056', '1.006', '1.010', '4.2', '4.8', '5', '12', '3', '4', NOW(), NOW() ),
( 'Historical Beer: Kentucky Common', '27A', 'Historical Beer', '1.044', '1.055', '1.010', '1.018', '4.0', '5.5', '15', '30', '11', '20', NOW(), NOW() ),
( 'Historical Beer: Lichtenhainer', '27A', 'Historical Beer', '1.032', '1.040', '1.004', '1.008', '3.5', '4.7', '5', '12', '3', '6', NOW(), NOW() ),
( 'Historical Beer: London Brown Ale', '27A', 'Historical Beer', '1.033', '1.038', '1.012', '1.015', '2.8', '3.6', '15', '20', '22', '35', NOW(), NOW() ),
( 'Historical Beer: Piwo Grodziskie', '27A', 'Historical Beer', '1.028', '1.032', '1.006', '1.012', '2.5', '3.3', '20', '35', '3', '6', NOW(), NOW() ),
( 'Historical Beer: Pre-Prohibition Lager', '27A', 'Historical Beer', '1.044', '1.060', '1.010', '1.015', '4.5', '6.0', '25', '40', '3', '6', NOW(), NOW() ),
( 'Historical Beer: Pre-Prohibition Porter', '27A', 'Historical Beer', '1.046', '1.060', '1.010', '1.016', '4.5', '6.0', '20', '30', '18', '30', NOW(), NOW() ),
( 'Historical Beer: Roggenbier', '27A', 'Historical Beer', '1.046', '1.056', '1.010', '1.014', '4.5', '6.0', '10', '20', '14', '19', NOW(), NOW() ),
( 'Historical Beer: Sahti', '27A', 'Historical Beer', '1.076', '1.120', '1.016', '1.020', '7.0', '11', '7', '15', '4', '22', NOW(), NOW() ),
( 'Brett Beer', '28A', 'American Wild Ale', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Mixed-Fermentation Sour Beer', '28B', 'American Wild Ale', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Wild Specialty Beer', '28C', 'American Wild Ale', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Fruit Beer', '29A', 'Fruit Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Fruit and Spice Beer', '29B', 'Fruit Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Fruit Beer', '29C', 'Fruit Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Spice, Herb or Vegetable Beer', '30A', 'Spiced Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Autumn Seasonal Beer', '30B', 'Spiced Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Winter Seasonal Beer', '30C', 'Spiced Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Alternative Grain Beer', '31A', 'Alternative Fermentables Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Alternative Sugar Beer', '31B', 'Alternative Fermentables Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Classic Style Smoked Beer', '32A', 'Smoked Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Smoked Beer', '32B', 'Smoked Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Wood-Aged Beer', '33A', 'Wood Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Wood-Aged Beer', '33B', 'Wood Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Clone Beer', '34A', 'Specialty Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Mixed-Style Beer', '34A', 'Specialty Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Experimental Beer', '34A', 'Specialty Beer', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Dry Mead', 'M1A', 'Traditional Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Semi-Sweet Mead', 'M1B', 'Traditional Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Sweet Mead', 'M1C', 'Traditional Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Cyser', 'M2A', 'Fruit Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Pyment', 'M2B', 'Fruit Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Berry Mead', 'M2C', 'Fruit Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Stone Fruit Mead', 'M2D', 'Fruit Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Melomel', 'M2E', 'Fruit Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Fruit and Spice Mead', 'M3A', 'Spiced Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Spice, Herb or Vegetable Mead', 'M3B', 'Spiced Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Braggot', 'M4A', 'Specialty Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Historical Mead', 'M4B', 'Specialty Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Experimental Mead', 'M4C', 'Specialty Mead', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'New World Cider', 'C1A', 'Standard Cider and Perry', '1.045', '1.065', '0.995', '1.020', '5', '8', '0', '0', '0', '0', NOW(), NOW() ),
( 'English Cider', 'C1B', 'Standard Cider and Perry', '1.050', '1.075', '0.995', '1.015', '6', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'French Cider', 'C1C', 'Standard Cider and Perry', '1.050', '1.065', '1.010', '1.020', '3', '6', '0', '0', '0', '0', NOW(), NOW() ),
( 'New World Perry', 'C1D', 'Standard Cider and Perry', '1.050', '1.060', '1.000', '1.020', '5', '7', '0', '0', '0', '0', NOW(), NOW() ),
( 'Traditional Perry', 'C1E', 'Standard Cider and Perry', '1.050', '1.070', '1.000', '1.020', '5', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'New England Cider', 'C2A', 'Specialty Cider and Perry', '1.060', '1.100', '0.995', '1.020', '7', '13', '0', '0', '0', '0', NOW(), NOW() ),
( 'Cider with Other Fruit', 'C2B', 'Specialty Cider and Perry', '1.045', '1.070', '0.995', '1.010', '5', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'Applewine', 'C2C', 'Specialty Cider and Perry', '1.070', '1.100', '0.995', '1.020', '9', '12', '0', '0', '0', '0', NOW(), NOW() ),
( 'Ice Cider', 'C2D', 'Specialty Cider and Perry', '1.130', '1.180', '1.060', '1.085', '7', '13', '0', '0', '0', '0', NOW(), NOW() ),
( 'Cider with Herbs/Spices', 'C2E', 'Specialty Cider and Perry', '1.045', '1.070', '0.995', '1.010', '5', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Cider/Perry', 'C2F', 'Specialty Cider and Perry', '1.045', '1.100', '0.995', '1.020', '5', '12', '0', '0', '0', '0', NOW(), NOW() ),
( '_Non-alcoholic Beer', 'N/A', 'Non-alcoholic Beer', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Wine', 'N/A', 'Wine', '1', '1', '1', '1', '0', '20', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Kombucha', 'N/A', 'Kombucha', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Tea', 'N/A', 'Tea', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Coffee', 'N/A', 'Coffee', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Fruit Juice', 'N/A', 'Fruit Juice', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Fruit Drink', 'N/A', 'Fruit Drink', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Seltzer Water', 'N/A', 'Seltzer Water', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() );

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

INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showTapNumCol', '1', 'Tap Column', '1', NOW(), NOW() ),
( 'showSrmCol', '1', 'SRM Column', '1', NOW(), NOW() ),
( 'showIbuCol', '1', 'IBU Column', '1', NOW(), NOW() ),
( 'showAbvCol', '1', 'ABV Column', '1', NOW(), NOW() ),
( 'showAbvImg', '1', 'ABV Images', '1', NOW(), NOW() ),
( 'showKegCol', '0', 'Keg Column', '1', NOW(), NOW() ),
( 'useHighResolution', '0', '4k Monitor Support', '1', NOW(), NOW() ),
( 'logoUrl', 'img/logo.png', 'Logo Url', '0', NOW(), NOW() ),
( 'adminLogoUrl', 'admin/img/logo.png', 'Admin Logo Url', '0', NOW(), NOW() ),
( 'headerText', 'Currently On Tap', 'Header Text', '0', NOW(), NOW() ),
( 'numberOfTaps', '0', 'Number of Taps', '0', NOW(), NOW() ),
( 'version', '1.0.3.395', 'Version', '0', NOW(), NOW() ),
( 'headerTextTruncLen' ,'20', 'Header Text Truncate Length', '0', NOW(), NOW() ),
( 'useFlowMeter','0','Use Flow Monitoring', '1', NOW(),NOW() );


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

INSERT INTO `kegTypes` ( displayName, maxAmount, createdDate, modifiedDate ) VALUES
( 'Ball Lock (5 gal)', '5', NOW(), NOW() ),
( 'Ball Lock (2.5 gal)', '2.5', NOW(), NOW() ),
( 'Ball Lock (3 gal)', '3', NOW(), NOW() ),
( 'Ball Lock (10 gal)', '10', NOW(), NOW() ),
( 'Pin Lock (5 gal)', '5', NOW(), NOW() ),
( 'Sanke (1/6 bbl)', '5.16', NOW(), NOW() ),
( 'Sanke (1/4 bbl)', '7.75', NOW(), NOW() ),
( 'Sanke (slim 1/4 bbl)', '7.75', NOW(), NOW() ),
( 'Sanke (1/2 bbl)', '15.5', NOW(), NOW() ),
( 'Sanke (Euro)', '13.2', NOW(), NOW() ),
( 'Cask (pin)', '10.81', NOW(), NOW() ),
( 'Cask (firkin)', '10.81', NOW(), NOW() ),
( 'Cask (kilderkin)', '21.62', NOW(), NOW() ),
( 'Cask (barrel)', '43.23', NOW(), NOW() ),
( 'Cask (hogshead)', '64.85', NOW(), NOW() );

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

INSERT INTO `kegStatuses` ( code, name, createdDate, modifiedDate ) VALUES
( 'SERVING', 'Serving', NOW(), NOW() ),
( 'PRIMARY', 'Primary', NOW(), NOW() ),
( 'SECONDARY', 'Secondary', NOW(), NOW() ),
( 'DRY_HOPPING', 'Dry Hopping', NOW(), NOW() ),
( 'CONDITIONING', 'Conditioning', NOW(), NOW() ),
( 'CLEAN', 'Clean', NOW(), NOW() ),
( 'NEEDS_CLEANING', 'Needs Cleaning', NOW(), NOW() ),
( 'NEEDS_PARTS', 'Needs Parts', NOW(), NOW() ),
( 'NEEDS_REPAIRS', 'Needs Repairs', NOW(), NOW() );

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
	`pinId` int(2) DEFAULT NULL,
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
	`pinId` int(11) DEFAULT NULL,
  `amountPoured` float(6,3) NOT NULL,
  `pulses` int(6) NOT NULL,
 
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
INSERT INTO srmRgb ( srm, rgb, createdDate, modifiedDate ) VALUES
( '0.0','252,252,243', NOW(), NOW() ),
( '0.1','248,248,230', NOW(), NOW() ),
( '0.2','248,248,220', NOW(), NOW() ),
( '0.3','247,247,199', NOW(), NOW() ),
( '0.4','244,249,185', NOW(), NOW() ),
( '0.5','247,249,180', NOW(), NOW() ),
( '0.6','248,249,178', NOW(), NOW() ),
( '0.7','244,246,169', NOW(), NOW() ),
( '0.8','245,247,166', NOW(), NOW() ),
( '0.9','246,247,156', NOW(), NOW() ),
( '1.0','243,249,147', NOW(), NOW() ),
( '1.1','246,248,141', NOW(), NOW() ),
( '1.2','246,249,136', NOW(), NOW() ),
( '1.3','245,250,128', NOW(), NOW() ),
( '1.4','246,249,121', NOW(), NOW() ),
( '1.5','248,249,114', NOW(), NOW() ),
( '1.6','243,249,104', NOW(), NOW() ),
( '1.7','246,248,107', NOW(), NOW() ),
( '1.8','248,247,99', NOW(), NOW() ),
( '1.9','245,247,92', NOW(), NOW() ),
( '2.0','248,247,83', NOW(), NOW() ),
( '2.1','244,248,72', NOW(), NOW() ),
( '2.2','248,247,73', NOW(), NOW() ),
( '2.3','246,247,62', NOW(), NOW() ),
( '2.4','241,248,53', NOW(), NOW() ),
( '2.5','244,247,48', NOW(), NOW() ),
( '2.6','246,249,40', NOW(), NOW() ),
( '2.7','243,249,34', NOW(), NOW() ),
( '2.8','245,247,30', NOW(), NOW() ),
( '2.9','248,245,22', NOW(), NOW() ),
( '3.0','246,245,19', NOW(), NOW() ),
( '3.1','244,242,22', NOW(), NOW() ),
( '3.2','244,240,21', NOW(), NOW() ),
( '3.3','243,242,19', NOW(), NOW() ),
( '3.4','244,238,24', NOW(), NOW() ),
( '3.5','244,237,29', NOW(), NOW() ),
( '3.6','238,233,22', NOW(), NOW() ),
( '3.7','240,233,23', NOW(), NOW() ),
( '3.8','238,231,25', NOW(), NOW() ),
( '3.9','234,230,21', NOW(), NOW() ),
( '4.0','236,230,26', NOW(), NOW() ),
( '4.1','230,225,24', NOW(), NOW() ),
( '4.2','232,225,25', NOW(), NOW() ),
( '4.3','230,221,27', NOW(), NOW() ),
( '4.4','224,218,23', NOW(), NOW() ),
( '4.5','229,216,31', NOW(), NOW() ),
( '4.6','229,214,30', NOW(), NOW() ),
( '4.7','223,213,26', NOW(), NOW() ),
( '4.8','226,213,28', NOW(), NOW() ),
( '4.9','223,209,29', NOW(), NOW() ),
( '5.0','224,208,27', NOW(), NOW() ),
( '5.1','224,204,32', NOW(), NOW() ),
( '5.2','221,204,33', NOW(), NOW() ),
( '5.3','220,203,29', NOW(), NOW() ),
( '5.4','218,200,32', NOW(), NOW() ),
( '5.5','220,197,34', NOW(), NOW() ),
( '5.6','218,196,41', NOW(), NOW() ),
( '5.7','217,194,43', NOW(), NOW() ),
( '5.8','216,192,39', NOW(), NOW() ),
( '5.9','213,190,37', NOW(), NOW() ),
( '6.0','213,188,38', NOW(), NOW() ),
( '6.1','212,184,39', NOW(), NOW() ),
( '6.2','214,183,43', NOW(), NOW() ),
( '6.3','213,180,45', NOW(), NOW() ),
( '6.4','210,179,41', NOW(), NOW() ),
( '6.5','208,178,42', NOW(), NOW() ),
( '6.6','208,176,46', NOW(), NOW() ),
( '6.7','204,172,48', NOW(), NOW() ),
( '6.8','204,172,52', NOW(), NOW() ),
( '6.9','205,170,55', NOW(), NOW() ),
( '7.0','201,167,50', NOW(), NOW() ),
( '7.1','202,167,52', NOW(), NOW() ),
( '7.2','201,166,51', NOW(), NOW() ),
( '7.3','199,162,54', NOW(), NOW() ),
( '7.4','198,160,56', NOW(), NOW() ),
( '7.5','200,158,60', NOW(), NOW() ),
( '7.6','194,156,54', NOW(), NOW() ),
( '7.7','196,155,54', NOW(), NOW() ),
( '7.8','198,151,60', NOW(), NOW() ),
( '7.9','193,150,60', NOW(), NOW() ),
( '8.0','191,146,59', NOW(), NOW() ),
( '8.1','190,147,57', NOW(), NOW() ),
( '8.2','190,147,59', NOW(), NOW() ),
( '8.3','190,145,60', NOW(), NOW() ),
( '8.4','186,148,56', NOW(), NOW() ),
( '8.5','190,145,58', NOW(), NOW() ),
( '8.6','193,145,59', NOW(), NOW() ),
( '8.7','190,145,58', NOW(), NOW() ),
( '8.8','191,143,59', NOW(), NOW() ),
( '8.9','191,141,61', NOW(), NOW() ),
( '9.0','190,140,58', NOW(), NOW() ),
( '9.1','192,140,61', NOW(), NOW() ),
( '9.2','193,138,62', NOW(), NOW() ),
( '9.3','192,137,59', NOW(), NOW() ),
( '9.4','193,136,59', NOW(), NOW() ),
( '9.5','195,135,63', NOW(), NOW() ),
( '9.6','191,136,58', NOW(), NOW() ),
( '9.7','191,134,67', NOW(), NOW() ),
( '9.8','193,131,67', NOW(), NOW() ),
( '9.9','190,130,58', NOW(), NOW() ),
( '10.0','191,129,58', NOW(), NOW() ),
( '10.1','191,131,57', NOW(), NOW() ),
( '10.2','191,129,58', NOW(), NOW() ),
( '10.3','191,129,58', NOW(), NOW() ),
( '10.4','190,129,55', NOW(), NOW() ),
( '10.5','191,127,59', NOW(), NOW() ),
( '10.6','194,126,59', NOW(), NOW() ),
( '10.7','188,128,54', NOW(), NOW() ),
( '10.8','190,124,55', NOW(), NOW() ),
( '10.9','193,122,55', NOW(), NOW() ),
( '11.0','190,124,55', NOW(), NOW() ),
( '11.1','194,121,59', NOW(), NOW() ),
( '11.2','193,120,56', NOW(), NOW() ),
( '11.3','190,119,52', NOW(), NOW() ),
( '11.4','182,117,54', NOW(), NOW() ),
( '11.5','196,116,59', NOW(), NOW() ),
( '11.6','191,118,56', NOW(), NOW() ),
( '11.7','190,116,57', NOW(), NOW() ),
( '11.8','191,115,58', NOW(), NOW() ),
( '11.9','189,115,56', NOW(), NOW() ),
( '12.0','191,113,56', NOW(), NOW() ),
( '12.1','191,113,53', NOW(), NOW() ),
( '12.2','188,112,57', NOW(), NOW() ),
( '12.3','190,112,55', NOW(), NOW() ),
( '12.4','184,110,52', NOW(), NOW() ),
( '12.5','188,109,55', NOW(), NOW() ),
( '12.6','189,109,55', NOW(), NOW() ),
( '12.7','186,106,50', NOW(), NOW() ),
( '12.8','190,103,52', NOW(), NOW() ),
( '12.9','189,104,54', NOW(), NOW() ),
( '13.0','188,103,51', NOW(), NOW() ),
( '13.1','188,103,51', NOW(), NOW() ),
( '13.2','186,101,51', NOW(), NOW() ),
( '13.3','186,102,56', NOW(), NOW() ),
( '13.4','185,100,56', NOW(), NOW() ),
( '13.5','185,98,59', NOW(), NOW() ),
( '13.6','183,98,54', NOW(), NOW() ),
( '13.7','181,100,53', NOW(), NOW() ),
( '13.8','182,97,55', NOW(), NOW() ),
( '13.9','177,97,51', NOW(), NOW() ),
( '14.0','178,96,51', NOW(), NOW() ),
( '14.1','176,96,49', NOW(), NOW() ),
( '14.2','177,96,55', NOW(), NOW() ),
( '14.3','178,95,55', NOW(), NOW() ),
( '14.4','171,94,55', NOW(), NOW() ),
( '14.5','171,92,56', NOW(), NOW() ),
( '14.6','172,93,59', NOW(), NOW() ),
( '14.7','168,92,55', NOW(), NOW() ),
( '14.8','169,90,54', NOW(), NOW() ),
( '14.9','168,88,57', NOW(), NOW() ),
( '15.0','165,89,54', NOW(), NOW() ),
( '15.1','166,88,54', NOW(), NOW() ),
( '15.2','165,88,58', NOW(), NOW() ),
( '15.3','161,88,52', NOW(), NOW() ),
( '15.4','163,85,55', NOW(), NOW() ),
( '15.5','160,86,56', NOW(), NOW() ),
( '15.6','158,85,57', NOW(), NOW() ),
( '15.7','158,86,54', NOW(), NOW() ),
( '15.8','159,84,57', NOW(), NOW() ),
( '15.9','156,83,53', NOW(), NOW() ),
( '16.0','152,83,54', NOW(), NOW() ),
( '16.1','150,83,55', NOW(), NOW() ),
( '16.2','150,81,56', NOW(), NOW() ),
( '16.3','146,81,56', NOW(), NOW() ),
( '16.4','147,79,54', NOW(), NOW() ),
( '16.5','147,79,55', NOW(), NOW() ),
( '16.6','146,78,54', NOW(), NOW() ),
( '16.7','142,77,51', NOW(), NOW() ),
( '16.8','143,79,53', NOW(), NOW() ),
( '16.9','142,77,54', NOW(), NOW() ),
( '17.0','141,76,50', NOW(), NOW() ),
( '17.1','140,75,50', NOW(), NOW() ),
( '17.2','138,73,49', NOW(), NOW() ),
( '17.3','135,70,45', NOW(), NOW() ),
( '17.4','136,71,49', NOW(), NOW() ),
( '17.5','140,72,49', NOW(), NOW() ),
( '17.6','128,70,45', NOW(), NOW() ),
( '17.7','129,71,46', NOW(), NOW() ),
( '17.8','130,69,47', NOW(), NOW() ),
( '17.9','123,69,45', NOW(), NOW() ),
( '18.0','124,69,45', NOW(), NOW() ),
( '18.1','121,66,40', NOW(), NOW() ),
( '18.2','120,67,40', NOW(), NOW() ),
( '18.3','119,64,38', NOW(), NOW() ),
( '18.4','116,63,34', NOW(), NOW() ),
( '18.5','120,63,35', NOW(), NOW() ),
( '18.6','120,62,37', NOW(), NOW() ),
( '18.7','112,63,35', NOW(), NOW() ),
( '18.8','111,62,36', NOW(), NOW() ),
( '18.9','109,60,34', NOW(), NOW() ),
( '19.0','107,58,30', NOW(), NOW() ),
( '19.1','106,57,31', NOW(), NOW() ),
( '19.2','107,56,31', NOW(), NOW() ),
( '19.3','105,56,28', NOW(), NOW() ),
( '19.4','105,56,28', NOW(), NOW() ),
( '19.5','104,52,31', NOW(), NOW() ),
( '19.6','102,53,27', NOW(), NOW() ),
( '19.7','100,53,26', NOW(), NOW() ),
( '19.8','99,52,25', NOW(), NOW() ),
( '19.9','93,53,24', NOW(), NOW() ),
( '20.0','93,52,26', NOW(), NOW() ),
( '20.1','89,49,20', NOW(), NOW() ),
( '20.2','90,50,21', NOW(), NOW() ),
( '20.3','91,48,20', NOW(), NOW() ),
( '20.4','83,48,15', NOW(), NOW() ),
( '20.5','88,48,17', NOW(), NOW() ),
( '20.6','86,46,17', NOW(), NOW() ),
( '20.7','81,45,15', NOW(), NOW() ),
( '20.8','83,44,15', NOW(), NOW() ),
( '20.9','81,45,15', NOW(), NOW() ),
( '21.0','78,42,12', NOW(), NOW() ),
( '21.1','77,43,12', NOW(), NOW() ),
( '21.2','75,41,12', NOW(), NOW() ),
( '21.3','74,41,5', NOW(), NOW() ),
( '21.4','78,40,23', NOW(), NOW() ),
( '21.5','83,43,46', NOW(), NOW() ),
( '21.6','78,43,41', NOW(), NOW() ),
( '21.7','78,40,41', NOW(), NOW() ),
( '21.8','76,41,41', NOW(), NOW() ),
( '21.9','74,39,39', NOW(), NOW() ),
( '22.0','74,39,39', NOW(), NOW() ),
( '22.1','69,39,35', NOW(), NOW() ),
( '22.2','70,37,37', NOW(), NOW() ),
( '22.3','68,38,36', NOW(), NOW() ),
( '22.4','64,35,34', NOW(), NOW() ),
( '22.5','64,35,34', NOW(), NOW() ),
( '22.6','62,33,32', NOW(), NOW() ),
( '22.7','58,33,31', NOW(), NOW() ),
( '22.8','61,33,31', NOW(), NOW() ),
( '22.9','58,33,33', NOW(), NOW() ),
( '23.0','54,31,27', NOW(), NOW() ),
( '23.1','52,29,28', NOW(), NOW() ),
( '23.2','52,29,28', NOW(), NOW() ),
( '23.3','49,28,27', NOW(), NOW() ),
( '23.4','48,27,26', NOW(), NOW() ),
( '23.5','48,27,26', NOW(), NOW() ),
( '23.6','44,25,25', NOW(), NOW() ),
( '23.7','44,25,23', NOW(), NOW() ),
( '23.8','42,24,26', NOW(), NOW() ),
( '23.9','40,23,22', NOW(), NOW() ),
( '24.0','38,23,22', NOW(), NOW() ),
( '24.1','38,23,22', NOW(), NOW() ),
( '24.2','38,23,22', NOW(), NOW() ),
( '24.3','38,23,22', NOW(), NOW() ),
( '24.4','38,23,22', NOW(), NOW() ),
( '24.5','38,23,22', NOW(), NOW() ),
( '24.6','38,23,22', NOW(), NOW() ),
( '24.7','38,23,22', NOW(), NOW() ),
( '24.8','38,23,22', NOW(), NOW() ),
( '24.9','38,23,22', NOW(), NOW() ),
( '25.0','38,23,22', NOW(), NOW() ),
( '25.1','38,23,22', NOW(), NOW() ),
( '25.2','38,23,22', NOW(), NOW() ),
( '25.3','38,23,22', NOW(), NOW() ),
( '25.4','38,23,22', NOW(), NOW() ),
( '25.5','38,23,22', NOW(), NOW() ),
( '25.6','38,23,24', NOW(), NOW() ),
( '25.7','25,16,15', NOW(), NOW() ),
( '25.8','25,16,15', NOW(), NOW() ),
( '25.9','25,16,15', NOW(), NOW() ),
( '26.0','25,16,15', NOW(), NOW() ),
( '26.1','25,16,15', NOW(), NOW() ),
( '26.2','25,16,15', NOW(), NOW() ),
( '26.3','25,16,15', NOW(), NOW() ),
( '26.4','25,16,15', NOW(), NOW() ),
( '26.5','25,16,15', NOW(), NOW() ),
( '26.6','25,16,15', NOW(), NOW() ),
( '26.7','25,16,15', NOW(), NOW() ),
( '26.8','25,16,15', NOW(), NOW() ),
( '26.9','25,16,15', NOW(), NOW() ),
( '27.0','25,16,15', NOW(), NOW() ),
( '27.1','25,16,15', NOW(), NOW() ),
( '27.2','25,16,15', NOW(), NOW() ),
( '27.3','18,13,12', NOW(), NOW() ),
( '27.4','18,13,12', NOW(), NOW() ),
( '27.5','18,13,12', NOW(), NOW() ),
( '27.6','18,13,12', NOW(), NOW() ),
( '27.7','18,13,12', NOW(), NOW() ),
( '27.8','18,13,12', NOW(), NOW() ),
( '27.9','18,13,12', NOW(), NOW() ),
( '28.0','18,13,12', NOW(), NOW() ),
( '28.1','18,13,12', NOW(), NOW() ),
( '28.2','18,13,12', NOW(), NOW() ),
( '28.3','18,13,12', NOW(), NOW() ),
( '28.4','18,13,12', NOW(), NOW() ),
( '28.5','18,13,12', NOW(), NOW() ),
( '28.6','18,13,12', NOW(), NOW() ),
( '28.7','17,13,10', NOW(), NOW() ),
( '28.8','18,13,12', NOW(), NOW() ),
( '28.9','16,11,10', NOW(), NOW() ),
( '29.0','16,11,10', NOW(), NOW() ),
( '29.1','16,11,10', NOW(), NOW() ),
( '29.2','16,11,10', NOW(), NOW() ),
( '29.3','16,11,10', NOW(), NOW() ),
( '29.4','16,11,10', NOW(), NOW() ),
( '29.5','16,11,10', NOW(), NOW() ),
( '29.6','16,11,10', NOW(), NOW() ),
( '29.7','16,11,10', NOW(), NOW() ),
( '29.8','16,11,10', NOW(), NOW() ),
( '29.9','16,11,10', NOW(), NOW() ),
( '30.0','16,11,10', NOW(), NOW() ),
( '30.1','16,11,10', NOW(), NOW() ),
( '30.2','16,11,10', NOW(), NOW() ),
( '30.3','16,11,10', NOW(), NOW() ),
( '30.4','16,11,10', NOW(), NOW() ),
( '30.5','14,9,8', NOW(), NOW() ),
( '30.6','15,10,9', NOW(), NOW() ),
( '30.7','14,9,8', NOW(), NOW() ),
( '30.8','14,9,8', NOW(), NOW() ),
( '30.9','14,9,8', NOW(), NOW() ),
( '31.0','14,9,8', NOW(), NOW() ),
( '31.1','14,9,8', NOW(), NOW() ),
( '31.2','14,9,8', NOW(), NOW() ),
( '31.3','14,9,8', NOW(), NOW() ),
( '31.4','14,9,8', NOW(), NOW() ),
( '31.5','14,9,8', NOW(), NOW() ),
( '31.6','14,9,8', NOW(), NOW() ),
( '31.7','14,9,8', NOW(), NOW() ),
( '31.8','14,9,8', NOW(), NOW() ),
( '31.9','14,9,8', NOW(), NOW() ),
( '32.0','15,11,8', NOW(), NOW() ),
( '32.1','12,9,7', NOW(), NOW() ),
( '32.2','12,9,7', NOW(), NOW() ),
( '32.3','12,9,7', NOW(), NOW() ),
( '32.4','12,9,7', NOW(), NOW() ),
( '32.5','12,9,7', NOW(), NOW() ),
( '32.6','12,9,7', NOW(), NOW() ),
( '32.7','12,9,7', NOW(), NOW() ),
( '32.8','12,9,7', NOW(), NOW() ),
( '32.9','12,9,7', NOW(), NOW() ),
( '33.0','12,9,7', NOW(), NOW() ),
( '33.1','12,9,7', NOW(), NOW() ),
( '33.2','12,9,7', NOW(), NOW() ),
( '33.3','12,9,7', NOW(), NOW() ),
( '33.4','12,9,7', NOW(), NOW() ),
( '33.5','12,9,7', NOW(), NOW() ),
( '33.6','12,9,7', NOW(), NOW() ),
( '33.7','10,7,7', NOW(), NOW() ),
( '33.8','10,7,5', NOW(), NOW() ),
( '33.9','8,7,7', NOW(), NOW() ),
( '34.0','8,7,7', NOW(), NOW() ),
( '34.1','8,7,7', NOW(), NOW() ),
( '34.2','8,7,7', NOW(), NOW() ),
( '34.3','8,7,7', NOW(), NOW() ),
( '34.4','8,7,7', NOW(), NOW() ),
( '34.5','8,7,7', NOW(), NOW() ),
( '34.6','8,7,7', NOW(), NOW() ),
( '34.7','8,7,7', NOW(), NOW() ),
( '34.8','8,7,7', NOW(), NOW() ),
( '34.9','8,7,7', NOW(), NOW() ),
( '35.0','8,7,7', NOW(), NOW() ),
( '35.1','8,7,7', NOW(), NOW() ),
( '35.2','8,7,7', NOW(), NOW() ),
( '35.3','7,6,6', NOW(), NOW() ),
( '35.4','7,6,6', NOW(), NOW() ),
( '35.5','7,6,6', NOW(), NOW() ),
( '35.6','7,6,6', NOW(), NOW() ),
( '35.7','7,6,6', NOW(), NOW() ),
( '35.8','7,6,6', NOW(), NOW() ),
( '35.9','7,6,6', NOW(), NOW() ),
( '36.0','7,6,6', NOW(), NOW() ),
( '36.1','7,6,6', NOW(), NOW() ),
( '36.2','7,6,6', NOW(), NOW() ),
( '36.3','7,6,6', NOW(), NOW() ),
( '36.4','7,6,6', NOW(), NOW() ),
( '36.5','7,6,6', NOW(), NOW() ),
( '36.6','7,6,6', NOW(), NOW() ),
( '36.7','7,7,4', NOW(), NOW() ),
( '36.8','6,6,3', NOW(), NOW() ),
( '36.9','6,5,5', NOW(), NOW() ),
( '37.0','4,5,4', NOW(), NOW() ),
( '37.1','4,5,4', NOW(), NOW() ),
( '37.2','4,5,4', NOW(), NOW() ),
( '37.3','4,5,4', NOW(), NOW() ),
( '37.4','4,5,4', NOW(), NOW() ),
( '37.5','4,5,4', NOW(), NOW() ),
( '37.6','4,5,4', NOW(), NOW() ),
( '37.7','4,5,4', NOW(), NOW() ),
( '37.8','4,5,4', NOW(), NOW() ),
( '37.9','4,5,4', NOW(), NOW() ),
( '38.0','4,5,4', NOW(), NOW() ),
( '38.1','4,5,4', NOW(), NOW() ),
( '38.2','4,5,4', NOW(), NOW() ),
( '38.3','4,5,4', NOW(), NOW() ),
( '38.4','4,5,4', NOW(), NOW() ),
( '38.5','3,4,3', NOW(), NOW() ),
( '38.6','4,5,4', NOW(), NOW() ),
( '38.7','3,4,3', NOW(), NOW() ),
( '38.8','3,4,3', NOW(), NOW() ),
( '38.9','3,4,3', NOW(), NOW() ),
( '39.0','3,4,3', NOW(), NOW() ),
( '39.1','3,4,3', NOW(), NOW() ),
( '39.2','3,4,3', NOW(), NOW() ),
( '39.3','3,4,3', NOW(), NOW() ),
( '39.4','3,4,3', NOW(), NOW() ),
( '39.5','3,4,3', NOW(), NOW() ),
( '39.6','3,4,3', NOW(), NOW() ),
( '39.7','3,4,3', NOW(), NOW() ),
( '39.8','3,4,3', NOW(), NOW() ),
( '39.9','3,4,3', NOW(), NOW() ),
( '40.0','3,4,3', NOW(), NOW() );

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
