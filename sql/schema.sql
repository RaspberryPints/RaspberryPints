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


-- --------------------------------------------------------

--
-- Table structure for table `breweries`
-- 

CREATE TABLE IF NOT EXISTS `breweries` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`imageUrl` varchar(2000),
	`active` tinyint(1) NOT NULL DEFAULT 1,

	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `beerStyles`
--

CREATE TABLE IF NOT EXISTS `beerStyles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`catNum` tinytext NOT NULL,
	`category` tinytext NOT NULL,
	`beerStyleList` tinytext NOT NULL,
	`ogMin` decimal(7,3) NULL,
	`ogMinUnit` tinytext NULL,
	`ogMax` decimal(7,3) NULL,
	`ogMaxUnit` tinytext NULL,
	`fgMin` decimal(7,3) NULL,
	`fgminUnit` tinytext NULL,
	`fgMax` decimal(7,3) NULL,
	`fgMaxUnit` tinytext NULL,
	`abvMin` decimal(3,1) NULL,
	`abvMax` decimal(3,1) NULL,
	`ibuMin` decimal(3) NULL,
	`ibuMax` decimal(3) NULL,
	`srmMin` decimal(7,1) NULL,
	`srmMax` decimal(7,1) NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beerStyles`
--

INSERT INTO `beerStyles`( name, catNum, category, beerStyleList, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES
-- BJCP pre 2015 styles
( 'Lite American Lager', '1A', 'Light Lager', 'BJCP pre 2015', '1.028', '1.04', '0.998', '1.008', '2.8', '4.2', '8', '12', '2', '3', NOW(), NOW() ),
( 'Standard American Lager', '1B', 'Light Lager', 'BJCP pre 2015', '1.04', '1.05', '1.004', '1.01', '4.2', '5.1', '8', '15', '2', '4', NOW(), NOW() ),
( 'Premium American Lager', '1C', 'Light Lager', 'BJCP pre 2015', '1.046', '1.056', '1.008', '1.012', '4.6', '6', '15', '25', '2', '6', NOW(), NOW() ),
( 'Munich Helles', '1D', 'Light Lager', 'BJCP pre 2015', '1.045', '1.051', '1.008', '1.012', '4.7', '5.4', '16', '22', '3', '5', NOW(), NOW() ),
( 'Dortmunder Export', '1E', 'Light Lager', 'BJCP pre 2015', '1.048', '1.056', '1.01', '1.015', '4.8', '6', '23', '30', '4', '6', NOW(), NOW() ),
( 'German Pilsner (Pils)', '2A', 'Pilsner', 'BJCP pre 2015', '1.044', '1.05', '1.008', '1.013', '4.4', '5.2', '25', '45', '2', '5', NOW(), NOW() ),
( 'Bohemian Pilsner', '2B', 'Pilsner', 'BJCP pre 2015', '1.044', '1.056', '1.013', '1.017', '4.2', '5.4', '35', '45', '3.5', '6', NOW(), NOW() ),
( 'Classic American Pilsner', '2C', 'Pilsner', 'BJCP pre 2015', '1.044', '1.06', '1.01', '1.015', '4.5', '6', '25', '40', '3', '6', NOW(), NOW() ),
( 'Vienna Lager', '3A', 'European Amber Lager', 'BJCP pre 2015', '1.046', '1.052', '1.01', '1.014', '4.5', '5.5', '18', '30', '10', '16', NOW(), NOW() ),
( 'Oktoberfest/M&auml;rzen', '3B', 'European Amber Lager', 'BJCP pre 2015', '1.05', '1.057', '1.012', '1.016', '4.8', '5.7', '20', '28', '7', '14', NOW(), NOW() ),
( 'Dark American Lager', '4A', 'Dark Lager', 'BJCP pre 2015', '1.044', '1.056', '1.008', '1.012', '4.2', '6', '8', '20', '14', '22', NOW(), NOW() ),
( 'Munich Dunkel', '4B', 'Dark Lager', 'BJCP pre 2015', '1.048', '1.056', '1.01', '1.016', '4.5', '5.6', '18', '28', '14', '28', NOW(), NOW() ),
( 'Schwarzbier (Black Beer)', '4C', 'Dark Lager', 'BJCP pre 2015', '1.046', '1.052', '1.01', '1.016', '4.4', '5.4', '22', '32', '17', '30', NOW(), NOW() ),
( 'Maibock/Helles Bock', '5A', 'Bock', 'BJCP pre 2015', '1.064', '1.072', '1.011', '1.018', '6.3', '7.4', '23', '35', '6', '11', NOW(), NOW() ),
( 'Traditional Bock', '5B', 'Bock', 'BJCP pre 2015', '1.064', '1.072', '1.013', '1.019', '6.3', '7.2', '20', '27', '14', '22', NOW(), NOW() ),
( 'Doppelbock', '5C', 'Bock', 'BJCP pre 2015', '1.072', '1.112', '1.016', '1.024', '7', '10', '16', '26', '6', '25', NOW(), NOW() ),
( 'Eisbock', '5D', 'Bock', 'BJCP pre 2015', '1.078', '1.12', '1.02', '1.035', '9', '14', '25', '35', '18', '30', NOW(), NOW() ),
( 'Cream Ale', '6A', 'Light Hybrid Beer', 'BJCP pre 2015', '1.042', '1.055', '1.006', '1.012', '4.2', '5.6', '15', '20', '2.5', '5', NOW(), NOW() ),
( 'Blonde Ale', '6B', 'Light Hybrid Beer', 'BJCP pre 2015', '1.038', '1.054', '1.008', '1.013', '3.8', '5.5', '15', '28', '3', '6', NOW(), NOW() ),
( 'K&ouml;lsch', '6C', 'Light Hybrid Beer', 'BJCP pre 2015', '1.044', '1.05', '1.007', '1.011', '4.4', '5.2', '20', '30', '3.5', '5', NOW(), NOW() ),
( 'American Wheat or Rye Beer', '6D', 'Light Hybrid Beer', 'BJCP pre 2015', '1.04', '1.055', '1.008', '1.013', '4', '5.5', '15', '30', '3', '6', NOW(), NOW() ),
( 'Northern German Altbier', '7A', 'Amber Hybrid Beer', 'BJCP pre 2015', '1.046', '1.054', '1.01', '1.015', '4.5', '5.2', '25', '40', '13', '19', NOW(), NOW() ),
( 'California Common Beer', '7B', 'Amber Hybrid Beer', 'BJCP pre 2015', '1.048', '1.054', '1.011', '1.014', '4.5', '5.5', '30', '45', '10', '14', NOW(), NOW() ),
( 'D&uuml;sseldorf Altbier', '7C', 'Amber Hybrid Beer', 'BJCP pre 2015', '1.046', '1.054', '1.01', '1.015', '4.5', '5.2', '35', '50', '11', '17', NOW(), NOW() ),
( 'Standard/Ordinary Bitter', '8A', 'English Pale Ale', 'BJCP pre 2015', '1.032', '1.04', '1.007', '1.011', '3.2', '3.8', '25', '35', '4', '14', NOW(), NOW() ),
( 'Special/Best/Premium Bitter', '8B', 'English Pale Ale', 'BJCP pre 2015', '1.04', '1.048', '1.008', '1.012', '3.8', '4.6', '25', '40', '5', '16', NOW(), NOW() ),
( 'Extra Special/Strong Bitter', '8C', 'English Pale Ale', 'BJCP pre 2015', '1.048', '1.06', '1.01', '1.016', '4.6', '6.2', '30', '50', '6', '18', NOW(), NOW() ),
( 'Scottish Light 60/-', '9A', 'Scottish and Irish Ale', 'BJCP pre 2015', '1.03', '1.035', '1.01', '1.013', '2.5', '3.2', '10', '20', '9', '17', NOW(), NOW() ),
( 'Scottish Heavy 70/-', '9B', 'Scottish and Irish Ale', 'BJCP pre 2015', '1.035', '1.04', '1.01', '1.015', '3.2', '3.9', '10', '25', '9', '17', NOW(), NOW() ),
( 'Scottish Export 80/-', '9C', 'Scottish and Irish Ale', 'BJCP pre 2015', '1.04', '1.054', '1.01', '1.016', '3.9', '5', '15', '30', '9', '17', NOW(), NOW() ),
( 'Irish Red Ale', '9D', 'Scottish and Irish Ale', 'BJCP pre 2015', '1.044', '1.06', '1.01', '1.014', '4', '6', '17', '28', '9', '18', NOW(), NOW() ),
( 'Strong Scotch Ale', '9E', 'Scottish and Irish Ale', 'BJCP pre 2015', '1.07', '1.13', '1.018', '1.03', '6.5', '10', '17', '35', '14', '25', NOW(), NOW() ),
( 'American Pale Ale', '10A', 'American Ale', 'BJCP pre 2015', '1.045', '1.06', '1.01', '1.015', '4.5', '6.2', '30', '45', '5', '14', NOW(), NOW() ),
( 'American Amber Ale', '10B', 'American Ale', 'BJCP pre 2015', '1.045', '1.06', '1.01', '1.015', '4.5', '6.2', '25', '40', '10', '17', NOW(), NOW() ),
( 'American Brown Ale', '10C', 'American Ale', 'BJCP pre 2015', '1.045', '1.06', '1.01', '1.016', '4.3', '6.2', '20', '40', '18', '35', NOW(), NOW() ),
( 'Mild', '11A', 'English Brown Ale', 'BJCP pre 2015', '1.03', '1.038', '1.008', '1.013', '2.8', '4.5', '10', '25', '12', '25', NOW(), NOW() ),
( 'Southern English Brown Ale', '11B', 'English Brown Ale', 'BJCP pre 2015', '1.033', '1.042', '1.011', '1.014', '2.8', '4.1', '12', '20', '19', '35', NOW(), NOW() ),
( 'Northern English Brown Ale', '11C', 'English Brown Ale', 'BJCP pre 2015', '1.04', '1.052', '1.008', '1.013', '4.2', '5.4', '20', '30', '12', '22', NOW(), NOW() ),
( 'Brown Porter', '12A', 'Porter', 'BJCP pre 2015', '1.04', '1.052', '1.008', '1.014', '4', '5.4', '18', '35', '20', '30', NOW(), NOW() ),
( 'Robust Porter', '12B', 'Porter', 'BJCP pre 2015', '1.048', '1.065', '1.012', '1.016', '4.8', '6.5', '25', '50', '22', '35', NOW(), NOW() ),
( 'Baltic Porter', '12C', 'Porter', 'BJCP pre 2015', '1.06', '1.09', '1.016', '1.024', '5.5', '9.5', '20', '40', '17', '30', NOW(), NOW() ),
( 'Dry Stout', '13A', 'Stout', 'BJCP pre 2015', '1.036', '1.05', '1.007', '1.011', '4', '5', '30', '45', '25', '40', NOW(), NOW() ),
( 'Sweet Stout', '13B', 'Stout', 'BJCP pre 2015', '1.044', '1.06', '1.012', '1.024', '4', '6', '20', '40', '30', '40', NOW(), NOW() ),
( 'Oatmeal Stout', '13C', 'Stout', 'BJCP pre 2015', '1.048', '1.065', '1.01', '1.018', '4.2', '5.9', '25', '40', '22', '40', NOW(), NOW() ),
( 'Foreign Extra Stout', '13D', 'Stout', 'BJCP pre 2015', '1.056', '1.075', '1.01', '1.018', '5.5', '8', '30', '70', '30', '40', NOW(), NOW() ),
( 'American Stout', '13E', 'Stout', 'BJCP pre 2015', '1.05', '1.075', '1.01', '1.022', '5', '7', '35', '75', '30', '40', NOW(), NOW() ),
( 'Imperial Stout', '13F', 'Stout', 'BJCP pre 2015', '1.075', '1.115', '1.018', '1.03', '8', '12', '50', '90', '30', '40', NOW(), NOW() ),
( 'English IPA', '14A', 'India Pale Ale (IPA)', 'BJCP pre 2015', '1.05', '1.075', '1.01', '1.018', '5', '7.5', '40', '60', '8', '14', NOW(), NOW() ),
( 'American IPA', '14B', 'India Pale Ale (IPA)', 'BJCP pre 2015', '1.056', '1.075', '1.01', '1.018', '5.5', '7.5', '40', '70', '6', '15', NOW(), NOW() ),
( 'Imperial IPA', '14C', 'India Pale Ale (IPA)', 'BJCP pre 2015', '1.07', '1.09', '1.01', '1.02', '7.5', '10', '60', '120', '8', '15', NOW(), NOW() ),
( 'Weizen/Weissbier', '15A', 'German Wheat and Rye Beer', 'BJCP pre 2015', '1.044', '1.052', '1.01', '1.014', '4.3', '5.6', '8', '15', '2', '8', NOW(), NOW() ),
( 'Dunkelweizen', '15B', 'German Wheat and Rye Beer', 'BJCP pre 2015', '1.044', '1.056', '1.01', '1.014', '4.3', '5.6', '10', '18', '14', '23', NOW(), NOW() ),
( 'Weizenbock', '15C', 'German Wheat and Rye Beer', 'BJCP pre 2015', '1.064', '1.09', '1.015', '1.022', '6.5', '8', '15', '30', '12', '25', NOW(), NOW() ),
( 'Roggenbier (German Rye Beer)', '15D', 'German Wheat and Rye Beer', 'BJCP pre 2015', '1.046', '1.056', '1.01', '1.014', '4.5', '6', '10', '20', '14', '19', NOW(), NOW() ),
( 'Witbier', '16A', 'Belgian and French Ale', 'BJCP pre 2015', '1.044', '1.052', '1.008', '1.012', '4.5', '5.5', '10', '20', '2', '4', NOW(), NOW() ),
( 'Belgian Pale Ale', '16B', 'Belgian and French Ale', 'BJCP pre 2015', '1.048', '1.054', '1.01', '1.014', '4.8', '5.5', '20', '30', '8', '14', NOW(), NOW() ),
( 'Saison', '16C', 'Belgian and French Ale', 'BJCP pre 2015', '1.048', '1.065', '1.002', '1.012', '5', '7', '20', '35', '5', '14', NOW(), NOW() ),
( 'Biere de Garde', '16D', 'Belgian and French Ale', 'BJCP pre 2015', '1.06', '1.08', '1.008', '1.016', '6', '8.5', '18', '28', '6', '19', NOW(), NOW() ),
( 'Belgian Specialty Ale', '16E', 'Belgian and French Ale', 'BJCP pre 2015', '1.03', '1.08', '1.006', '1.019', '3', '9', '15', '40', '3', '50', NOW(), NOW() ),
( 'Berliner Weiss', '17A', 'Sour Ale', 'BJCP pre 2015', '1.028', '1.032', '1.003', '1.006', '2.8', '3.8', '3', '8', '2', '3', NOW(), NOW() ),
( 'Flanders Red Ale', '17B', 'Sour Ale', 'BJCP pre 2015', '1.048', '1.057', '1.002', '1.012', '4.6', '6.5', '10', '25', '10', '16', NOW(), NOW() ),
( 'Flanders Brown Ale/Oud Bruin', '17C', 'Sour Ale', 'BJCP pre 2015', '1.04', '1.074', '1.008', '1.012', '4', '8', '20', '25', '15', '22', NOW(), NOW() ),
( 'Straight (Unblended) Lambic', '17D', 'Sour Ale', 'BJCP pre 2015', '1.04', '1.054', '1.001', '1.01', '5', '6.5', '0', '10', '3', '7', NOW(), NOW() ),
( 'Gueuze', '17E', 'Sour Ale', 'BJCP pre 2015', '1.04', '1.06', '1', '1.006', '5', '8', '0', '10', '3', '7', NOW(), NOW() ),
( 'Fruit Lambic', '17F', 'Sour Ale', 'BJCP pre 2015', '1.04', '1.06', '1', '1.01', '5', '7', '0', '10', '3', '7', NOW(), NOW() ),
( 'Belgian Blond Ale', '18A', 'Belgian Strong Ale', 'BJCP pre 2015', '1.062', '1.075', '1.008', '1.018', '6', '7.5', '15', '30', '4', '7', NOW(), NOW() ),
( 'Belgian Dubbel', '18B', 'Belgian Strong Ale', 'BJCP pre 2015', '1.062', '1.075', '1.008', '1.018', '6', '7.6', '15', '25', '10', '17', NOW(), NOW() ),
( 'Belgian Tripel', '18C', 'Belgian Strong Ale', 'BJCP pre 2015', '1.075', '1.085', '1.008', '1.014', '7.5', '9.5', '20', '40', '4.5', '7', NOW(), NOW() ),
( 'Belgian Golden Strong Ale', '18D', 'Belgian Strong Ale', 'BJCP pre 2015', '1.07', '1.095', '1.005', '1.016', '7.5', '10.5', '22', '35', '3', '6', NOW(), NOW() ),
( 'Belgian Dark Strong Ale', '18E', 'Belgian Strong Ale', 'BJCP pre 2015', '1.075', '1.11', '1.01', '1.024', '8', '11', '20', '35', '12', '22', NOW(), NOW() ),
( 'Old Ale', '19A', 'Strong Ale', 'BJCP pre 2015', '1.06', '1.09', '1.015', '1.022', '6', '9', '30', '60', '10', '22', NOW(), NOW() ),
( 'English Barleywine', '19B', 'Strong Ale', 'BJCP pre 2015', '1.08', '1.12', '1.018', '1.03', '8', '12', '35', '70', '8', '22', NOW(), NOW() ),
( 'American Barleywine', '19C', 'Strong Ale', 'BJCP pre 2015', '1.08', '1.12', '1.016', '1.03', '8', '12', '50', '120', '10', '19', NOW(), NOW() ),
( 'Fruit Beer', '20A', 'Fruit Beer', 'BJCP pre 2015', '1.03', '1.11', '1.004', '1.024', '2.5', '12', '5', '70', '3', '50', NOW(), NOW() ),
( 'Spice, Herb or Vegetable Beer', '21A', 'Spice/Herb/Vegetable Beer', 'BJCP pre 2015', '1.03', '1.11', '1.005', '1.025', '2.5', '12', '0', '70', '5', '50', NOW(), NOW() ),
( 'Christmas/Winter Specialty Spiced Beer', '21B', 'Spice/Herb/Vegetable Beer', 'BJCP pre 2015', '1.03', '1.11', '1.005', '1.025', '2.5', '12', '0', '70', '5', '50', NOW(), NOW() ),
( 'Classic Rauchbier', '22A', 'Smoke-Flavored and Wood-Aged Beer', 'BJCP pre 2015', '1.05', '1.057', '1.012', '1.016', '4.8', '6', '20', '30', '12', '22', NOW(), NOW() ),
( 'Other Smoked Beer', '22B', 'Smoke-Flavored and Wood-Aged Beer', 'BJCP pre 2015', '1.03', '1.11', '1.006', '1.024', '2.5', '12', '5', '70', '5', '50', NOW(), NOW() ),
( 'Wood Aged Beer', '22C', 'Smoke-Flavored and Wood-Aged Beer', 'BJCP pre 2015', '1.03', '1.11', '1.006', '1.024', '2.5', '12', '5', '70', '5', '50', NOW(), NOW() ),
( 'Specialty Beer', '23A', 'Specialty Beer', 'BJCP pre 2015', '1.03', '1.11', '1.006', '1.024', '2.5', '12', '5', '70', '5', '50', NOW(), NOW() ),
( 'Dry Mead', '24A', 'Traditional Mead', 'BJCP pre 2015', '1.035', '1.17', '0.99', '1.05', '3.5', '18', '0', '0', '1', '16', NOW(), NOW() ),
( 'Semi-Sweet Mead', '24B', 'Traditional Mead', 'BJCP pre 2015', '1.035', '1.17', '0.99', '1.05', '3.5', '18', '0', '0', '1', '16', NOW(), NOW() ),
( 'Sweet Mead', '24C', 'Traditional Mead', 'BJCP pre 2015', '1.035', '1.17', '0.99', '1.05', '7.5', '15', '0', '0', '1', '16', NOW(), NOW() ),
( 'Cyser (Apple Melomel)', '25A', 'Melomel (Fruit Mead)', 'BJCP pre 2015', '1.035', '1.17', '0.99', '1.05', '3.5', '18', '0', '0', '1', '16', NOW(), NOW() ),
( 'Pyment (Grape Melomel)', '25B', 'Melomel (Fruit Mead)', 'BJCP pre 2015', '1.035', '1.17', '0.99', '1.05', '3.5', '18', '0', '0', '1', '16', NOW(), NOW() ),
( 'Other Fruit Melomel', '25C', 'Melomel (Fruit Mead)', 'BJCP pre 2015', '1.035', '1.17', '0.99', '1.05', '3.5', '18', '0', '0', '1', '16', NOW(), NOW() ),
( 'Metheglin', '26A', 'Other Mead', 'BJCP pre 2015', '1.035', '1.17', '0.99', '1.05', '3.5', '18', '0', '0', '1', '16', NOW(), NOW() ),
( 'Braggot', '26B', 'Other Mead', 'BJCP pre 2015', '1.035', '1.17', '1.009', '1.05', '3.5', '18', '0', '50', '3', '16', NOW(), NOW() ),
( 'Open Category Mead', '26C', 'Other Mead', 'BJCP pre 2015', '1.035', '1.17', '0.99', '1.05', '3.5', '18', '0', '50', '1', '16', NOW(), NOW() ),
( 'Common Cider', '27A', 'Standard Cider and Perry', 'BJCP pre 2015', '1.045', '1.065', '1', '1.02', '5', '8', '0', '0', '1', '10', NOW(), NOW() ),
( 'English Cider', '27B', 'Standard Cider and Perry', 'BJCP pre 2015', '1.05', '1.075', '0.995', '1.01', '6', '9', '0', '0', '1', '10', NOW(), NOW() ),
( 'French Cider', '27C', 'Standard Cider and Perry', 'BJCP pre 2015', '1.05', '1.065', '1.01', '1.02', '3', '6', '0', '0', '1', '10', NOW(), NOW() ),
( 'Common Perry', '27D', 'Standard Cider and Perry', 'BJCP pre 2015', '1.05', '1.06', '1', '1.02', '5', '7', '0', '0', '0', '6', NOW(), NOW() ),
( 'Traditional Perry', '27E', 'Standard Cider and Perry', 'BJCP pre 2015', '1.05', '1.07', '1', '1.02', '5', '9', '0', '0', '0', '6', NOW(), NOW() ),
( 'New England Cider', '28A', 'Specialty Cider and Perry', 'BJCP pre 2015', '1.06', '1.1', '0.995', '1.01', '7', '13', '0', '0', '1', '10', NOW(), NOW() ),
( 'Fruit Cider', '28B', 'Specialty Cider and Perry', 'BJCP pre 2015', '1.045', '1.07', '0.995', '1.01', '5', '9', '0', '0', '1', '10', NOW(), NOW() ),
( 'Applewine', '28C', 'Specialty Cider and Perry', 'BJCP pre 2015', '1.07', '1.1', '0.995', '1.01', '9', '12', '0', '0', '1', '10', NOW(), NOW() ),
( 'Other Specialty Cider/Perry', '28D', 'Specialty Cider and Perry', 'BJCP pre 2015', '1.045', '1.1', '0.995', '1.02', '5', '12', '0', '0', '1', '10', NOW(), NOW() ),
-- Other drinks
( '_Non-alcoholic Beer', 'N/A', 'Non-alcoholic Beer', 'Other', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Wine', 'N/A', 'Wine', 'Other', '1', '1', '1', '1', '0', '20', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Kombucha', 'N/A', 'Kombucha', 'Other', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Tea', 'N/A', 'Tea', 'Other', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Coffee', 'N/A', 'Coffee', 'Other', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Fruit Juice', 'N/A', 'Fruit Juice', 'Other', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Fruit Drink', 'N/A', 'Fruit Drink', 'Other', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
( '_Non-beer: Seltzer Water', 'N/A', 'Seltzer Water', 'Other', '1', '1', '1', '1', '0', '0', '0', '0', '0', '40', NOW(), NOW() ),
-- BJCP 2015 styles
( 'American Light Lager', '1A', 'Standard American Beer', 'BJCP 2015', '1.028', '1.04', '0.998', '1.008', '2.8', '4.2', '8', '12', '2', '3', NOW(), NOW() ),
( 'American Lager', '1B', 'Standard American Beer', 'BJCP 2015', '1.04', '1.05', '1.004', '1.01', '4.2', '5.3', '8', '18', '2', '4', NOW(), NOW() ),
( 'Cream Ale', '1C', 'Standard American Beer', 'BJCP 2015', '1.042', '1.055', '1.006', '1.012', '4.2', '5.6', '8', '20', '2.5', '5', NOW(), NOW() ),
( 'American Wheat Beer', '1D', 'Standard American Beer', 'BJCP 2015', '1.04', '1.055', '1.008', '1.013', '4', '5.5', '15', '30', '3', '6', NOW(), NOW() ),
( 'International Pale Lager', '2A', 'International Lager', 'BJCP 2015', '1.042', '1.050', '1.008', '1.012', '4.6', '6.0', '18', '25', '2', '6', NOW(), NOW() ),
( 'International Amber Lager', '2B', 'International Lager', 'BJCP 2015', '1.042', '1.055', '1.008', '1.014', '4.6', '6.0', '8', '25', '7', '14', NOW(), NOW() ),
( 'International Dark Lager', '2C', 'International Lager', 'BJCP 2015', '1.044', '1.056', '1.008', '1.012', '4.2', '6.0', '8', '20', '14', '22', NOW(), NOW() ),
( 'Czech Pale Lager', '3A', 'Czech Lager', 'BJCP 2015', '1.028', '1.044', '1.008', '1.014', '3.0', '4.1', '20', '35', '3', '6', NOW(), NOW() ),
( 'Czech Premium Pale Lager', '3B', 'Czech Lager', 'BJCP 2015', '1.044', '1.060', '1.013', '1.017', '4.2', '5.8', '30', '45', '3.5', '6', NOW(), NOW() ),
( 'Czech Amber Lager', '3C', 'Czech Lager', 'BJCP 2015', '1.044', '1.060', '1.013', '1.017', '4.4', '5.8', '20', '35', '10', '16', NOW(), NOW() ),
( 'Czech Dark Lager', '3D', 'Czech Lager', 'BJCP 2015', '1.044', '1.060', '1.013', '1.017', '4.4', '5.8', '18', '34', '14', '35', NOW(), NOW() ),
( 'Munich Helles', '4A', 'Pale Malty European Lager', 'BJCP 2015', '1.044', '1.048', '1.006', '1.012', '4.7', '5.4', '16', '22', '3', '5', NOW(), NOW() ),
( 'Festbier', '4B', 'Pale Malty European Lager', 'BJCP 2015', '1.054', '1.057', '1.010', '1.012', '5.8', '6.3', '18', '25', '4', '7', NOW(), NOW() ),
( 'Helles Bock', '4C', 'Pale Malty European Lager', 'BJCP 2015', '1.064', '1.072', '1.011', '1.018', '6.3', '7.4', '23', '35', '6', '11', NOW(), NOW() ),
( 'German Leichtbier', '5A', 'Pale Bitter European Beer', 'BJCP 2015', '1.026', '1.034', '1.006', '1.010', '2.4', '3.6', '15', '28', '2', '5', NOW(), NOW() ),
( 'K&ouml;lsch', '5B', 'Pale Bitter European Beer', 'BJCP 2015', '1.044', '1.05', '1.007', '1.011', '4.4', '5.2', '18', '30', '3.5', '5', NOW(), NOW() ),
( 'German Helles Exportbier', '5C', 'Pale Bitter European Beer', 'BJCP 2015', '1.048', '1.056', '1.010', '1.015', '4.8', '6.0', '20', '30', '4', '7', NOW(), NOW() ),
( 'German Pils', '5D', 'Pale Bitter European Beer', 'BJCP 2015', '1.044', '1.05', '1.008', '1.013', '4.4', '5.2', '22', '40', '2', '5', NOW(), NOW() ),
( 'M&auml;rzen', '6A', 'Amber Malty European Lager', 'BJCP 2015', '1.054', '1.06', '1.010', '1.014', '5.8', '6.3', '18', '24', '8', '17', NOW(), NOW() ),
( 'Rauchbier', '6B', 'Amber Malty European Lager', 'BJCP 2015', '1.05', '1.057', '1.012', '1.016', '4.8', '6', '20', '30', '12', '22', NOW(), NOW() ),
( 'Dunkles Bock', '6C', 'Amber Malty European Lager', 'BJCP 2015', '1.064', '1.072', '1.013', '1.019', '6.3', '7.2', '20', '27', '14', '22', NOW(), NOW() ),
( 'Vienna Lager', '7A', 'Amber Bitter European Beer', 'BJCP 2015', '1.048', '1.055', '1.01', '1.014', '4.7', '5.5', '18', '30', '9', '15', NOW(), NOW() ),
( 'Altbier', '7B', 'Amber Bitter European Beer', 'BJCP 2015', '1.044', '1.052', '1.008', '1.014', '4.3', '5.5', '25', '50', '11', '17', NOW(), NOW() ),
( 'Kellerbier: Pale Kellerbier', '7C', 'Amber Bitter European Beer', 'BJCP 2015', '1.045', '1.051', '1.008', '1.012', '4.7', '5.4', '20', '35', '3', '7', NOW(), NOW() ),
( 'Kellerbier: Amber Kellerbier', '7C', 'Amber Bitter European Beer', 'BJCP 2015', '1.048', '1.054', '1.012', '1.016', '4.8', '5.4', '25', '40', '7', '17', NOW(), NOW() ),
( 'Munich Dunkel', '8A', 'Dark European Lager', 'BJCP 2015', '1.048', '1.056', '1.01', '1.016', '4.5', '5.6', '18', '28', '14', '28', NOW(), NOW() ),
( 'Schwarzbier', '8B', 'Dark European Lager', 'BJCP 2015', '1.046', '1.052', '1.01', '1.016', '4.4', '5.4', '20', '30', '17', '30', NOW(), NOW() ),
( 'Doppelbock', '9A', 'Strong European Beer', 'BJCP 2015', '1.072', '1.112', '1.016', '1.024', '7', '10', '16', '26', '6', '25', NOW(), NOW() ),
( 'Eisbock', '9B', 'Strong European Beer', 'BJCP 2015', '1.078', '1.12', '1.02', '1.035', '9', '14', '25', '35', '18', '30', NOW(), NOW() ),
( 'Baltic Porter', '9C', 'Strong European Beer', 'BJCP 2015', '1.06', '1.09', '1.016', '1.024', '6.5', '9.5', '20', '40', '17', '30', NOW(), NOW() ),
( 'Weissbier', '10A', 'German Wheat Beer', 'BJCP 2015', '1.044', '1.052', '1.01', '1.014', '4.3', '5.6', '8', '15', '2', '6', NOW(), NOW() ),
( 'Dunkles Weissbier', '10B', 'German Wheat Beer', 'BJCP 2015', '1.044', '1.056', '1.01', '1.014', '4.3', '5.6', '10', '18', '14', '23', NOW(), NOW() ),
( 'Weizenbock', '10C', 'German Wheat Beer', 'BJCP 2015', '1.064', '1.09', '1.015', '1.022', '6.5', '9', '15', '30', '6', '25', NOW(), NOW() ),
( 'Ordinary Bitter', '11A', 'British Bitter', 'BJCP 2015', '1.030', '1.039', '1.007', '1.011', '3.2', '3.8', '25', '35', '8', '14', NOW(), NOW() ),
( 'Best Bitter', '11B', 'British Bitter', 'BJCP 2015', '1.04', '1.048', '1.008', '1.012', '3.8', '4.6', '25', '40', '8', '16', NOW(), NOW() ),
( 'Strong Bitter', '11C', 'British Bitter', 'BJCP 2015', '1.048', '1.06', '1.01', '1.016', '4.6', '6.2', '30', '50', '8', '18', NOW(), NOW() ),
( 'British Golden Ale', '12A', 'Pale Commonwealth Beer', 'BJCP 2015', '1.038', '1.053', '1.006', '1.012', '3.8', '5.0', '20', '45', '2', '6', NOW(), NOW() ),
( 'Australian Sparkling Ale', '12B', 'Pale Commonwealth Beer', 'BJCP 2015', '1.038', '1.050', '1.004', '1.006', '4.5', '6.0', '20', '35', '4', '7', NOW(), NOW() ),
( 'English IPA', '12C', 'Pale Commonwealth Beer', 'BJCP 2015', '1.050', '1.075', '1.010', '1.018', '5.0', '7.5', '40', '60', '6', '14', NOW(), NOW() ),
( 'Dark Mild', '13A', 'Brown British Beer', 'BJCP 2015', '1.03', '1.038', '1.008', '1.013', '3.0', '3.8', '10', '25', '12', '25', NOW(), NOW() ),
( 'British Brown Ale', '13B', 'Brown British Beer', 'BJCP 2015', '1.04', '1.052', '1.008', '1.013', '4.2', '5.4', '20', '30', '12', '22', NOW(), NOW() ),
( 'English Porter', '13C', 'Brown British Beer', 'BJCP 2015', '1.04', '1.052', '1.008', '1.014', '4', '5.4', '18', '35', '20', '30', NOW(), NOW() ),
( 'Scottish Light', '14A', 'Scottish Ale', 'BJCP 2015', '1.03', '1.035', '1.01', '1.013', '2.5', '3.2', '10', '20', '17', '22', NOW(), NOW() ),
( 'Scottish Heavy', '14B', 'Scottish Ale', 'BJCP 2015', '1.035', '1.04', '1.01', '1.015', '3.2', '3.9', '10', '20', '13', '22', NOW(), NOW() ),
( 'Scottish Export', '14C', 'Scottish Ale', 'BJCP 2015', '1.04', '1.06', '1.01', '1.016', '3.9', '6', '15', '30', '13', '22', NOW(), NOW() ),
( 'Irish Red Ale', '15A', 'Irish Beer', 'BJCP 2015', '1.036', '1.046', '1.01', '1.014', '3.8', '5', '18', '28', '9', '14', NOW(), NOW() ),
( 'Irish Stout', '15B', 'Irish Beer', 'BJCP 2015', '1.036', '1.044', '1.007', '1.011', '4.0', '4.5', '25', '45', '25', '40', NOW(), NOW() ),
( 'Irish Extra Stout', '15C', 'Irish Beer', 'BJCP 2015', '1.052', '1.062', '1.010', '1.014', '5.5', '6.5', '35', '50', '25', '40', NOW(), NOW() ),
( 'Sweet Stout', '16A', 'Dark British Beer', 'BJCP 2015', '1.044', '1.06', '1.012', '1.024', '4', '6', '20', '40', '30', '40', NOW(), NOW() ),
( 'Oatmeal Stout', '16B', 'Dark British Beer', 'BJCP 2015', '1.045', '1.065', '1.01', '1.018', '4.2', '5.9', '25', '40', '22', '40', NOW(), NOW() ),
( 'Tropical Stout', '16C', 'Dark British Beer', 'BJCP 2015', '1.056', '1.075', '1.01', '1.018', '5.5', '8.0', '30', '50', '30', '40', NOW(), NOW() ),
( 'Foreign Extra Stout', '16D', 'Dark British Beer', 'BJCP 2015', '1.056', '1.075', '1.01', '1.018', '6.3', '8', '50', '70', '30', '40', NOW(), NOW() ),
( 'British Strong Ale', '17A', 'Strong British Ale', 'BJCP 2015', '1.055', '1.080', '1.015', '1.022', '5.5', '8', '30', '60', '8', '22', NOW(), NOW() ),
( 'Old Ale', '17B', 'Strong British Ale', 'BJCP 2015', '1.055', '1.088', '1.015', '1.022', '5.5', '9', '30', '60', '10', '22', NOW(), NOW() ),
( 'Wee Heavy', '17C', 'Strong British Ale', 'BJCP 2015', '1.070', '1.130', '1.018', '1.040', '6.5', '10', '17', '35', '14', '25', NOW(), NOW() ),
( 'English Barleywine', '17D', 'Strong British Ale', 'BJCP 2015', '1.08', '1.12', '1.018', '1.03', '8', '12', '35', '70', '8', '22', NOW(), NOW() ),
( 'Blonde Ale', '18A', 'Pale American Ale', 'BJCP 2015', '1.038', '1.054', '1.008', '1.013', '3.8', '5.5', '15', '28', '3', '6', NOW(), NOW() ),
( 'American Pale Ale', '18B', 'Pale American Ale', 'BJCP 2015', '1.045', '1.06', '1.01', '1.015', '4.5', '6.2', '30', '50', '5', '10', NOW(), NOW() ),
( 'American Amber Ale', '19A', 'Amber and Brown American Beer', 'BJCP 2015', '1.045', '1.06', '1.01', '1.015', '4.5', '6.2', '25', '40', '10', '17', NOW(), NOW() ),
( 'California Common', '19B', 'Amber and Brown American Beer', 'BJCP 2015', '1.048', '1.054', '1.011', '1.014', '4.5', '5.5', '30', '45', '10', '14', NOW(), NOW() ),
( 'American Brown Ale', '19C', 'Amber and Bron American Beer', 'BJCP 2015', '1.045', '1.06', '1.01', '1.016', '4.3', '6.2', '20', '30', '18', '35', NOW(), NOW() ),
( 'American Porter', '20A', 'American Porter and Stout', 'BJCP 2015', '1.05', '1.070', '1.012', '1.018', '4.8', '6.5', '25', '50', '22', '40', NOW(), NOW() ),
( 'American Stout', '20B', 'American Porter and Stout', 'BJCP 2015', '1.05', '1.075', '1.01', '1.022', '5', '7', '35', '75', '30', '40', NOW(), NOW() ),
( 'Imperial Stout', '20C', 'American Porter and Stout', 'BJCP 2015', '1.075', '1.115', '1.018', '1.03', '8', '12', '50', '90', '30', '40', NOW(), NOW() ),
( 'American IPA', '21A', 'IPA', 'BJCP 2015', '1.056', '1.070', '1.008', '1.014', '5.5', '7.5', '40', '70', '6', '14', NOW(), NOW() ),
( 'Specialty IPA: Belgian IPA', '21B', 'IPA', 'BJCP 2015', '1.058', '1.080', '1.008', '1.016', '6.2', '9.5', '50', '100', '5', '15', NOW(), NOW() ),
( 'Specialty IPA: Black IPA', '21B', 'IPA', 'BJCP 2015', '1.050', '1.085', '1.010', '1.018', '5.5', '9.0', '50', '90', '25', '40', NOW(), NOW() ),
( 'Specialty IPA: Brown IPA', '21B', 'IPA', 'BJCP 2015', '1.056', '1.070', '1.008', '1.016', '5.5', '7.5', '40', '70', '11', '19', NOW(), NOW() ),
( 'Specialty IPA: Red IPA', '21B', 'IPA', 'BJCP 2015', '1.056', '1.070', '1.008', '1.016', '5.5', '7.5', '40', '70', '11', '19', NOW(), NOW() ),
( 'Specialty IPA: Rye IPA', '21B', 'IPA', 'BJCP 2015', '1.056', '1.075', '1.008', '1.014', '5.5', '8.0', '50', '75', '6', '14', NOW(), NOW() ),
( 'Specialty IPA: White IPA', '21B', 'IPA', 'BJCP 2015', '1.056', '1.065', '1.010', '1.016', '5.5', '7.0', '40', '70', '5', '8', NOW(), NOW() ),
( 'Double IPA', '22A', 'Strong American Ale', 'BJCP 2015', '1.065', '1.085', '1.008', '1.018', '7.5', '10', '60', '120', '6', '14', NOW(), NOW() ),
( 'American Strong Ale', '22B', 'Strong American Ale', 'BJCP 2015', '1.062', '1.090', '1.014', '1.024', '6.3', '10', '50', '100', '7', '19', NOW(), NOW() ),
( 'American Barleywine', '22C', 'Strong American Ale', 'BJCP 2015', '1.08', '1.12', '1.016', '1.03', '8', '12', '50', '100', '10', '19', NOW(), NOW() ),
( 'Wheatwine', '22D', 'Strong American Ale', 'BJCP 2015', '1.08', '1.12', '1.016', '1.03', '8', '12', '30', '60', '8', '15', NOW(), NOW() ),
( 'Berliner Weiss', '23A', 'European Sour Ale', 'BJCP 2015', '1.028', '1.032', '1.003', '1.006', '2.8', '3.8', '3', '8', '2', '3', NOW(), NOW() ),
( 'Flanders Red Ale', '23B', 'European Sour Ale', 'BJCP 2015', '1.048', '1.057', '1.002', '1.012', '4.6', '6.5', '10', '25', '10', '16', NOW(), NOW() ),
( 'Oud Bruin', '23C', 'European Sour Ale', 'BJCP 2015', '1.04', '1.074', '1.008', '1.012', '4', '8', '20', '25', '15', '22', NOW(), NOW() ),
( 'Lambic', '23D', 'European Sour Ale', 'BJCP 2015', '1.04', '1.054', '1.001', '1.01', '5', '6.5', '0', '10', '3', '7', NOW(), NOW() ),
( 'Gueuze', '23E', 'European Sour Ale', 'BJCP 2015', '1.04', '1.06', '1', '1.006', '5', '8', '0', '10', '3', '7', NOW(), NOW() ),
( 'Fruit Lambic', '23F', 'European Sour Ale', 'BJCP 2015', '1.04', '1.06', '1', '1.01', '5', '7', '0', '10', '3', '7', NOW(), NOW() ),
( 'Witbier', '24A', 'Belgian Ale', 'BJCP 2015', '1.044', '1.052', '1.008', '1.012', '4.5', '5.5', '8', '20', '2', '4', NOW(), NOW() ),
( 'Belgian Pale Ale', '24B', 'Belgian Ale', 'BJCP 2015', '1.048', '1.054', '1.01', '1.014', '4.8', '5.5', '20', '30', '8', '14', NOW(), NOW() ),
( 'Bi&egrave;re de Garde', '24C', 'Belgian Ale', 'BJCP 2015', '1.06', '1.08', '1.008', '1.016', '6', '8.5', '18', '28', '6', '19', NOW(), NOW() ),
( 'Belgian Blond Ale', '25A', 'Strong Belgian Ale', 'BJCP 2015', '1.062', '1.075', '1.008', '1.018', '6', '7.5', '15', '30', '4', '7', NOW(), NOW() ),
( 'Saison', '25B', 'Strong Belgian Ale', 'BJCP 2015', '1.048', '1.065', '1.002', '1.008', '3.5', '9.5', '20', '35', '5', '22', NOW(), NOW() ),
( 'Belgian Golden Strong Ale', '25C', 'Strong Belgian Ale', 'BJCP 2015', '1.07', '1.095', '1.005', '1.016', '7.5', '10.5', '22', '35', '3', '6', NOW(), NOW() ),
( 'Trappist Single', '26A', 'Trappist Ale', 'BJCP 2015', '1.044', '1.054', '1.004', '1.010', '4.8', '6.0', '25', '45', '3', '5', NOW(), NOW() ),
( 'Belgian Dubbel', '26B', 'Trappist Ale', 'BJCP 2015', '1.062', '1.075', '1.008', '1.018', '6', '7.6', '15', '25', '10', '17', NOW(), NOW() ),
( 'Belgian Tripel', '26C', 'Trappist Ale', 'BJCP 2015', '1.075', '1.085', '1.008', '1.014', '7.5', '9.5', '20', '40', '4.5', '7', NOW(), NOW() ),
( 'Belgian Dark Strong Ale', '26D', 'Trappist Ale', 'BJCP 2015', '1.075', '1.11', '1.01', '1.024', '8', '12', '20', '35', '12', '22', NOW(), NOW() ),
( 'Historical Beer: Gose', '27A', 'Historical Beer', 'BJCP 2015', '1.036', '1.056', '1.006', '1.010', '4.2', '4.8', '5', '12', '3', '4', NOW(), NOW() ),
( 'Historical Beer: Kentucky Common', '27A', 'Historical Beer', 'BJCP 2015', '1.044', '1.055', '1.010', '1.018', '4.0', '5.5', '15', '30', '11', '20', NOW(), NOW() ),
( 'Historical Beer: Lichtenhainer', '27A', 'Historical Beer', 'BJCP 2015', '1.032', '1.040', '1.004', '1.008', '3.5', '4.7', '5', '12', '3', '6', NOW(), NOW() ),
( 'Historical Beer: London Brown Ale', '27A', 'Historical Beer', 'BJCP 2015', '1.033', '1.038', '1.012', '1.015', '2.8', '3.6', '15', '20', '22', '35', NOW(), NOW() ),
( 'Historical Beer: Piwo Grodziskie', '27A', 'Historical Beer', 'BJCP 2015', '1.028', '1.032', '1.006', '1.012', '2.5', '3.3', '20', '35', '3', '6', NOW(), NOW() ),
( 'Historical Beer: Pre-Prohibition Lager', '27A', 'Historical Beer', 'BJCP 2015', '1.044', '1.060', '1.010', '1.015', '4.5', '6.0', '25', '40', '3', '6', NOW(), NOW() ),
( 'Historical Beer: Pre-Prohibition Porter', '27A', 'Historical Beer', 'BJCP 2015', '1.046', '1.060', '1.010', '1.016', '4.5', '6.0', '20', '30', '18', '30', NOW(), NOW() ),
( 'Historical Beer: Roggenbier', '27A', 'Historical Beer', 'BJCP 2015', '1.046', '1.056', '1.010', '1.014', '4.5', '6.0', '10', '20', '14', '19', NOW(), NOW() ),
( 'Historical Beer: Sahti', '27A', 'Historical Beer', 'BJCP 2015', '1.076', '1.120', '1.016', '1.020', '7.0', '11', '7', '15', '4', '22', NOW(), NOW() ),
( 'Brett Beer', '28A', 'American Wild Ale', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Mixed-Fermentation Sour Beer', '28B', 'American Wild Ale', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Wild Specialty Beer', '28C', 'American Wild Ale', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Fruit Beer', '29A', 'Fruit Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Fruit and Spice Beer', '29B', 'Fruit Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Fruit Beer', '29C', 'Fruit Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Spice, Herb or Vegetable Beer', '30A', 'Spiced Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Autumn Seasonal Beer', '30B', 'Spiced Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Winter Seasonal Beer', '30C', 'Spiced Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Alternative Grain Beer', '31A', 'Alternative Fermentables Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Alternative Sugar Beer', '31B', 'Alternative Fermentables Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Classic Style Smoked Beer', '32A', 'Smoked Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Smoked Beer', '32B', 'Smoked Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Wood-Aged Beer', '33A', 'Wood Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Wood-Aged Beer', '33B', 'Wood Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Clone Beer', '34A', 'Specialty Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Mixed-Style Beer', '34A', 'Specialty Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Experimental Beer', '34A', 'Specialty Beer', 'BJCP 2015', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Dry Mead', 'M1A', 'Traditional Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Semi-Sweet Mead', 'M1B', 'Traditional Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Sweet Mead', 'M1C', 'Traditional Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Cyser', 'M2A', 'Fruit Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Pyment', 'M2B', 'Fruit Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Berry Mead', 'M2C', 'Fruit Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Stone Fruit Mead', 'M2D', 'Fruit Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Melomel', 'M2E', 'Fruit Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Fruit and Spice Mead', 'M3A', 'Spiced Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Spice, Herb or Vegetable Mead', 'M3B', 'Spiced Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Braggot', 'M4A', 'Specialty Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Historical Mead', 'M4B', 'Specialty Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Experimental Mead', 'M4C', 'Specialty Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'New World Cider', 'C1A', 'Standard Cider and Perry', 'BJCP 2015', '1.045', '1.065', '0.995', '1.020', '5', '8', '0', '0', '0', '0', NOW(), NOW() ),
( 'English Cider', 'C1B', 'Standard Cider and Perry', 'BJCP 2015', '1.050', '1.075', '0.995', '1.015', '6', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'French Cider', 'C1C', 'Standard Cider and Perry', 'BJCP 2015', '1.050', '1.065', '1.010', '1.020', '3', '6', '0', '0', '0', '0', NOW(), NOW() ),
( 'New World Perry', 'C1D', 'Standard Cider and Perry', 'BJCP 2015', '1.050', '1.060', '1.000', '1.020', '5', '7', '0', '0', '0', '0', NOW(), NOW() ),
( 'Traditional Perry', 'C1E', 'Standard Cider and Perry', 'BJCP 2015', '1.050', '1.070', '1.000', '1.020', '5', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'New England Cider', 'C2A', 'Specialty Cider and Perry', 'BJCP 2015', '1.060', '1.100', '0.995', '1.020', '7', '13', '0', '0', '0', '0', NOW(), NOW() ),
( 'Cider with Other Fruit', 'C2B', 'Specialty Cider and Perry', 'BJCP 2015', '1.045', '1.070', '0.995', '1.010', '5', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'Applewine', 'C2C', 'Specialty Cider and Perry', 'BJCP 2015', '1.070', '1.100', '0.995', '1.020', '9', '12', '0', '0', '0', '0', NOW(), NOW() ),
( 'Ice Cider', 'C2D', 'Specialty Cider and Perry', 'BJCP 2015', '1.130', '1.180', '1.060', '1.085', '7', '13', '0', '0', '0', '0', NOW(), NOW() ),
( 'Cider with Herbs/Spices', 'C2E', 'Specialty Cider and Perry', 'BJCP 2015', '1.045', '1.070', '0.995', '1.010', '5', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Cider/Perry', 'C2F', 'Specialty Cider and Perry', 'BJCP 2015', '1.045', '1.100', '0.995', '1.020', '5', '12', '0', '0', '0', '0', NOW(), NOW() ),
-- BJCP 2021 styles
( 'American Light Lager', '1A', 'Standard American Beer', 'BJCP 2021', '1.028', '1.04', '0.998', '1.008', '2.8', '4.2', '8', '12', '2', '3', NOW(), NOW() ),
( 'American Lager', '1B', 'Standard American Beer', 'BJCP 2021', '1.04', '1.05', '1.004', '1.01', '4.2', '5.3', '8', '18', '2', '3.5', NOW(), NOW() ),
( 'Cream Ale', '1C', 'Standard American Beer', 'BJCP 2021', '1.042', '1.055', '1.006', '1.012', '4.2', '5.6', '8', '20', '2', '5', NOW(), NOW() ),
( 'American Wheat Beer', '1D', 'Standard American Beer', 'BJCP 2021', '1.04', '1.055', '1.008', '1.013', '4', '5.5', '15', '30', '3', '6', NOW(), NOW() ),
( 'International Pale Lager', '2A', 'International Lager', 'BJCP 2021', '1.042', '1.050', '1.008', '1.012', '4.5', '6.0', '18', '25', '2', '6', NOW(), NOW() ),
( 'International Amber Lager', '2B', 'International Lager', 'BJCP 2021', '1.042', '1.055', '1.008', '1.014', '4.5', '6.0', '8', '25', '6', '14', NOW(), NOW() ),
( 'International Dark Lager', '2C', 'International Lager', 'BJCP 2021', '1.044', '1.056', '1.008', '1.012', '4.2', '6.0', '8', '20', '14', '30', NOW(), NOW() ),
( 'Czech Pale Lager', '3A', 'Czech Lager', 'BJCP 2021', '1.028', '1.044', '1.008', '1.014', '3.0', '4.1', '20', '35', '3', '6', NOW(), NOW() ),
( 'Czech Premium Pale Lager', '3B', 'Czech Lager', 'BJCP 2021', '1.044', '1.060', '1.013', '1.017', '4.2', '5.8', '30', '45', '3.5', '6', NOW(), NOW() ),
( 'Czech Amber Lager', '3C', 'Czech Lager', 'BJCP 2021', '1.044', '1.060', '1.013', '1.017', '4.4', '5.8', '20', '35', '10', '16', NOW(), NOW() ),
( 'Czech Dark Lager', '3D', 'Czech Lager', 'BJCP 2021', '1.044', '1.060', '1.013', '1.017', '4.4', '5.8', '18', '34', '17', '35', NOW(), NOW() ),
( 'Munich Helles', '4A', 'Pale Malty European Lager', 'BJCP 2021', '1.044', '1.048', '1.006', '1.012', '4.7', '5.4', '16', '22', '3', '5', NOW(), NOW() ),
( 'Festbier', '4B', 'Pale Malty European Lager', 'BJCP 2021', '1.054', '1.057', '1.010', '1.012', '5.8', '6.3', '18', '25', '4', '6', NOW(), NOW() ),
( 'Helles Bock', '4C', 'Pale Malty European Lager', 'BJCP 2021', '1.064', '1.072', '1.011', '1.018', '6.3', '7.4', '23', '35', '6', '9', NOW(), NOW() ),
( 'German Leichtbier', '5A', 'Pale Bitter European Beer', 'BJCP 2021', '1.026', '1.034', '1.006', '1.010', '2.4', '3.6', '15', '28', '1.5', '4', NOW(), NOW() ),
( 'K&ouml;lsch', '5B', 'Pale Bitter European Beer', 'BJCP 2021', '1.044', '1.05', '1.007', '1.011', '4.4', '5.2', '18', '30', '3.5', '5', NOW(), NOW() ),
( 'German Helles Exportbier', '5C', 'Pale Bitter European Beer', 'BJCP 2021', '1.050', '1.058', '1.008', '1.015', '5.0', '6.0', '20', '30', '4', '6', NOW(), NOW() ),
( 'German Pils', '5D', 'Pale Bitter European Beer', 'BJCP 2021', '1.044', '1.05', '1.008', '1.013', '4.4', '5.2', '22', '40', '2', '4', NOW(), NOW() ),
( 'M&auml;rzen', '6A', 'Amber Malty European Lager', 'BJCP 2021', '1.054', '1.06', '1.010', '1.014', '5.6', '6.3', '18', '24', '8', '17', NOW(), NOW() ),
( 'Rauchbier', '6B', 'Amber Malty European Lager', 'BJCP 2021', '1.05', '1.057', '1.012', '1.016', '4.8', '6', '20', '30', '12', '22', NOW(), NOW() ),
( 'Dunkles Bock', '6C', 'Amber Malty European Lager', 'BJCP 2021', '1.064', '1.072', '1.013', '1.019', '6.3', '7.2', '20', '27', '14', '22', NOW(), NOW() ),
( 'Vienna Lager', '7A', 'Amber Bitter European Beer', 'BJCP 2021', '1.048', '1.055', '1.01', '1.014', '4.7', '5.5', '18', '30', '9', '15', NOW(), NOW() ),
( 'Altbier', '7B', 'Amber Bitter European Beer', 'BJCP 2021', '1.044', '1.052', '1.008', '1.014', '4.3', '5.5', '25', '50', '9', '17', NOW(), NOW() ),
( 'Munich Dunkel', '8A', 'Dark European Lager', 'BJCP 2021', '1.048', '1.056', '1.01', '1.016', '4.5', '5.6', '18', '28', '17', '28', NOW(), NOW() ),
( 'Schwarzbier', '8B', 'Dark European Lager', 'BJCP 2021', '1.046', '1.052', '1.01', '1.016', '4.4', '5.4', '20', '35', '19', '30', NOW(), NOW() ),
( 'Doppelbock', '9A', 'Strong European Beer', 'BJCP 2021', '1.072', '1.112', '1.016', '1.024', '7', '10', '16', '26', '6', '25', NOW(), NOW() ),
( 'Eisbock', '9B', 'Strong European Beer', 'BJCP 2021', '1.078', '1.12', '1.02', '1.035', '9', '14', '25', '35', '17', '30', NOW(), NOW() ),
( 'Baltic Porter', '9C', 'Strong European Beer', 'BJCP 2021', '1.06', '1.09', '1.016', '1.024', '6.5', '9.5', '20', '40', '17', '30', NOW(), NOW() ),
( 'Weissbier', '10A', 'German Wheat Beer', 'BJCP 2021', '1.044', '1.053', '1.008', '1.014', '4.3', '5.6', '8', '15', '2', '6', NOW(), NOW() ),
( 'Dunkles Weissbier', '10B', 'German Wheat Beer', 'BJCP 2021', '1.044', '1.057', '1.008', '1.014', '4.3', '5.6', '10', '18', '14', '23', NOW(), NOW() ),
( 'Weizenbock', '10C', 'German Wheat Beer', 'BJCP 2021', '1.064', '1.09', '1.015', '1.022', '6.5', '9', '15', '30', '6', '25', NOW(), NOW() ),
( 'Ordinary Bitter', '11A', 'British Bitter', 'BJCP 2021', '1.030', '1.039', '1.007', '1.011', '3.2', '3.8', '25', '35', '8', '14', NOW(), NOW() ),
( 'Best Bitter', '11B', 'British Bitter', 'BJCP 2021', '1.04', '1.048', '1.008', '1.012', '3.8', '4.6', '25', '40', '8', '16', NOW(), NOW() ),
( 'Strong Bitter', '11C', 'British Bitter', 'BJCP 2021', '1.048', '1.06', '1.01', '1.016', '4.6', '6.2', '30', '50', '8', '18', NOW(), NOW() ),
( 'British Golden Ale', '12A', 'Pale Commonwealth Beer', 'BJCP 2021', '1.038', '1.053', '1.006', '1.012', '3.8', '5.0', '20', '45', '2', '5', NOW(), NOW() ),
( 'Australian Sparkling Ale', '12B', 'Pale Commonwealth Beer', 'BJCP 2021', '1.038', '1.050', '1.004', '1.006', '4.5', '6.0', '20', '35', '4', '7', NOW(), NOW() ),
( 'English IPA', '12C', 'Pale Commonwealth Beer', 'BJCP 2021', '1.050', '1.070', '1.010', '1.015', '5.0', '7.5', '40', '60', '6', '14', NOW(), NOW() ),
( 'Dark Mild', '13A', 'Brown British Beer', 'BJCP 2021', '1.03', '1.038', '1.008', '1.013', '3.0', '3.8', '10', '25', '14', '25', NOW(), NOW() ),
( 'British Brown Ale', '13B', 'Brown British Beer', 'BJCP 2021', '1.04', '1.052', '1.008', '1.013', '4.2', '5.9', '20', '30', '12', '22', NOW(), NOW() ),
( 'English Porter', '13C', 'Brown British Beer', 'BJCP 2021', '1.04', '1.052', '1.008', '1.014', '4', '5.4', '18', '35', '20', '30', NOW(), NOW() ),
( 'Scottish Light', '14A', 'Scottish Ale', 'BJCP 2021', '1.03', '1.035', '1.01', '1.013', '2.5', '3.3', '10', '20', '17', '25', NOW(), NOW() ),
( 'Scottish Heavy', '14B', 'Scottish Ale', 'BJCP 2021', '1.035', '1.04', '1.01', '1.015', '3.3', '3.9', '10', '20', '12', '20', NOW(), NOW() ),
( 'Scottish Export', '14C', 'Scottish Ale', 'BJCP 2021', '1.04', '1.06', '1.01', '1.016', '3.9', '6', '15', '30', '12', '20', NOW(), NOW() ),
( 'Irish Red Ale', '15A', 'Irish Beer', 'BJCP 2021', '1.036', '1.046', '1.01', '1.014', '3.8', '5', '18', '28', '9', '14', NOW(), NOW() ),
( 'Irish Stout', '15B', 'Irish Beer', 'BJCP 2021', '1.036', '1.044', '1.007', '1.011', '3.8', '5', '25', '45', '25', '40', NOW(), NOW() ),
( 'Irish Extra Stout', '15C', 'Irish Beer', 'BJCP 2021', '1.052', '1.062', '1.010', '1.014', '5', '6.5', '35', '50', '30', '40', NOW(), NOW() ),
( 'Sweet Stout', '16A', 'Dark British Beer', 'BJCP 2021', '1.044', '1.06', '1.012', '1.024', '4', '6', '20', '40', '30', '40', NOW(), NOW() ),
( 'Oatmeal Stout', '16B', 'Dark British Beer', 'BJCP 2021', '1.045', '1.065', '1.01', '1.018', '4.2', '5.9', '25', '40', '22', '40', NOW(), NOW() ),
( 'Tropical Stout', '16C', 'Dark British Beer', 'BJCP 2021', '1.056', '1.075', '1.01', '1.018', '5.5', '8.0', '30', '50', '30', '40', NOW(), NOW() ),
( 'Foreign Extra Stout', '16D', 'Dark British Beer', 'BJCP 2021', '1.056', '1.075', '1.01', '1.018', '6.3', '8', '50', '70', '30', '40', NOW(), NOW() ),
( 'British Strong Ale', '17A', 'Strong British Ale', 'BJCP 2021', '1.055', '1.080', '1.015', '1.022', '5.5', '8', '30', '60', '8', '22', NOW(), NOW() ),
( 'Old Ale', '17B', 'Strong British Ale', 'BJCP 2021', '1.055', '1.088', '1.015', '1.022', '5.5', '9', '30', '60', '10', '22', NOW(), NOW() ),
( 'Wee Heavy', '17C', 'Strong British Ale', 'BJCP 2021', '1.070', '1.130', '1.018', '1.040', '6.5', '10', '17', '35', '14', '25', NOW(), NOW() ),
( 'English Barleywine', '17D', 'Strong British Ale', 'BJCP 2021', '1.08', '1.12', '1.018', '1.03', '8', '12', '35', '70', '8', '22', NOW(), NOW() ),
( 'Blonde Ale', '18A', 'Pale American Ale', 'BJCP 2021', '1.038', '1.054', '1.008', '1.013', '3.8', '5.5', '15', '28', '3', '6', NOW(), NOW() ),
( 'American Pale Ale', '18B', 'Pale American Ale', 'BJCP 2021', '1.045', '1.06', '1.01', '1.015', '4.5', '6.2', '30', '50', '5', '10', NOW(), NOW() ),
( 'American Amber Ale', '19A', 'Amber and Brown American Beer', 'BJCP 2021', '1.045', '1.06', '1.01', '1.015', '4.5', '6.2', '25', '40', '10', '17', NOW(), NOW() ),
( 'California Common', '19B', 'Amber and Brown American Beer', 'BJCP 2021', '1.048', '1.054', '1.011', '1.014', '4.5', '5.5', '30', '45', '9', '14', NOW(), NOW() ),
( 'American Brown Ale', '19C', 'Amber and Bron American Beer', 'BJCP 2021', '1.045', '1.06', '1.01', '1.016', '4.3', '6.2', '20', '30', '18', '35', NOW(), NOW() ),
( 'American Porter', '20A', 'American Porter and Stout', 'BJCP 2021', '1.05', '1.070', '1.012', '1.018', '4.8', '6.5', '25', '50', '22', '40', NOW(), NOW() ),
( 'American Stout', '20B', 'American Porter and Stout', 'BJCP 2021', '1.05', '1.075', '1.01', '1.022', '5', '7', '35', '75', '30', '40', NOW(), NOW() ),
( 'Imperial Stout', '20C', 'American Porter and Stout', 'BJCP 2021', '1.075', '1.115', '1.018', '1.03', '8', '12', '50', '90', '30', '40', NOW(), NOW() ),
( 'American IPA', '21A', 'IPA', 'BJCP 2021', '1.056', '1.070', '1.008', '1.014', '5.5', '7.5', '40', '70', '6', '14', NOW(), NOW() ),
( 'Specialty IPA: Belgian IPA', '21B', 'IPA', 'BJCP 2021', '1.058', '1.080', '1.008', '1.016', '6.2', '9.5', '50', '100', '5', '8', NOW(), NOW() ),
( 'Specialty IPA: Black IPA', '21B', 'IPA', 'BJCP 2021', '1.050', '1.085', '1.010', '1.018', '5.5', '9.0', '50', '90', '25', '40', NOW(), NOW() ),
( 'Specialty IPA: Brown IPA', '21B', 'IPA', 'BJCP 2021', '1.056', '1.070', '1.008', '1.016', '5.5', '7.5', '40', '70', '18', '35', NOW(), NOW() ),
( 'Specialty IPA: Red IPA', '21B', 'IPA', 'BJCP 2021', '1.056', '1.070', '1.008', '1.016', '5.5', '7.5', '40', '70', '11', '17', NOW(), NOW() ),
( 'Specialty IPA: Rye IPA', '21B', 'IPA', 'BJCP 2021', '1.056', '1.075', '1.008', '1.014', '5.5', '8.0', '50', '75', '6', '14', NOW(), NOW() ),
( 'Specialty IPA: White IPA', '21B', 'IPA', 'BJCP 2021', '1.056', '1.065', '1.010', '1.016', '5.5', '7.0', '40', '70', '5', '6', NOW(), NOW() ),
( 'Specialty IPA: Brut IPA', '21B', 'IPA', 'BJCP 2021', '1.046', '1.057', '0.990', '1.004', '6.0', '7.5', '20', '30', '2', '4', NOW(), NOW() ),
( 'Hazy IPA', '21C', 'IPA', 'BJCP 2021', '1.060', '1.085', '1.010', '1.015', '6.0', '9.0', '25', '60', '3', '7', NOW(), NOW() ),
( 'Double IPA', '22A', 'Strong American Ale', 'BJCP 2021', '1.065', '1.085', '1.008', '1.018', '7.5', '10', '60', '100', '6', '14', NOW(), NOW() ),
( 'American Strong Ale', '22B', 'Strong American Ale', 'BJCP 2021', '1.062', '1.090', '1.014', '1.024', '6.3', '10', '50', '100', '7', '18', NOW(), NOW() ),
( 'American Barleywine', '22C', 'Strong American Ale', 'BJCP 2021', '1.08', '1.12', '1.016', '1.03', '8', '12', '50', '100', '9', '18', NOW(), NOW() ),
( 'Wheatwine', '22D', 'Strong American Ale', 'BJCP 2021', '1.08', '1.12', '1.016', '1.03', '8', '12', '30', '60', '6', '14', NOW(), NOW() ),
( 'Berliner Weiss', '23A', 'European Sour Ale', 'BJCP 2021', '1.028', '1.032', '1.003', '1.006', '2.8', '3.8', '3', '8', '2', '3', NOW(), NOW() ),
( 'Flanders Red Ale', '23B', 'European Sour Ale', 'BJCP 2021', '1.048', '1.057', '1.002', '1.012', '4.6', '6.5', '10', '25', '10', '17', NOW(), NOW() ),
( 'Oud Bruin', '23C', 'European Sour Ale', 'BJCP 2021', '1.04', '1.074', '1.008', '1.012', '4', '8', '20', '25', '17', '22', NOW(), NOW() ),
( 'Lambic', '23D', 'European Sour Ale', 'BJCP 2021', '1.04', '1.054', '1.001', '1.01', '5', '6.5', '0', '10', '3', '6', NOW(), NOW() ),
( 'Gueuze', '23E', 'European Sour Ale', 'BJCP 2021', '1.04', '1.054', '1', '1.006', '5', '8', '0', '10', '5', '6', NOW(), NOW() ),
( 'Fruit Lambic', '23F', 'European Sour Ale', 'BJCP 2021', '1.04', '1.06', '1', '1.01', '5', '7', '0', '10', '3', '7', NOW(), NOW() ),
( 'Gose', '23G', 'European Sour Ale', 'BJCP 2021', '1.036', '1.056', '1.006', '1.010', '4.2', '4.8', '5', '12', '3', '4', NOW(), NOW() ),
( 'Witbier', '24A', 'Belgian Ale', 'BJCP 2021', '1.044', '1.052', '1.008', '1.012', '4.5', '5.5', '8', '20', '2', '4', NOW(), NOW() ),
( 'Belgian Pale Ale', '24B', 'Belgian Ale', 'BJCP 2021', '1.048', '1.054', '1.01', '1.014', '4.8', '5.5', '20', '30', '8', '14', NOW(), NOW() ),
( 'Bi&egrave;re de Garde', '24C', 'Belgian Ale', 'BJCP 2021', '1.06', '1.08', '1.008', '1.016', '6', '8.5', '18', '28', '6', '19', NOW(), NOW() ),
( 'Belgian Blond Ale', '25A', 'Strong Belgian Ale', 'BJCP 2021', '1.062', '1.075', '1.008', '1.018', '6', '7.5', '15', '30', '4', '6', NOW(), NOW() ),
( 'Saison: Standard', '25B', 'Strong Belgian Ale', 'BJCP 2021', '1.048', '1.065', '1.002', '1.008', '5', '7', '20', '35', '5', '14', NOW(), NOW() ),
( 'Belgian Golden Strong Ale', '25C', 'Strong Belgian Ale', 'BJCP 2021', '1.07', '1.095', '1.005', '1.016', '7.5', '10.5', '22', '35', '3', '6', NOW(), NOW() ),
( 'Belgian Single', '26A', 'Monastic Ale', 'BJCP 2021', '1.044', '1.054', '1.004', '1.010', '4.8', '6.0', '25', '45', '3', '5', NOW(), NOW() ),
( 'Belgian Dubbel', '26B', 'Monastic Ale', 'BJCP 2021', '1.062', '1.075', '1.008', '1.018', '6', '7.6', '15', '25', '10', '17', NOW(), NOW() ),
( 'Belgian Tripel', '26C', 'Monastic Ale', 'BJCP 2021', '1.075', '1.085', '1.008', '1.014', '7.5', '9.5', '20', '40', '4.5', '7', NOW(), NOW() ),
( 'Belgian Dark Strong Ale', '26D', 'Monastic Ale', 'BJCP 2021', '1.075', '1.11', '1.01', '1.024', '8', '12', '20', '35', '12', '22', NOW(), NOW() ),
( 'Historical Beer: Pale Kellerbier', '27A', 'Historical Beer', 'BJCP 2021', '1.045', '1.051', '1.008', '1.012', '4.7', '5.4', '20', '35', '3', '7', NOW(), NOW() ),
( 'Historical Beer: Amber Kellerbier', '27A', 'Historical Beer', 'BJCP 2021', '1.048', '1.054', '1.012', '1.016', '4.8', '5.4', '25', '40', '7', '17', NOW(), NOW() ),
( 'Historical Beer: Kentucky Common', '27A', 'Historical Beer', 'BJCP 2021', '1.044', '1.055', '1.010', '1.018', '4.0', '5.5', '15', '30', '11', '20', NOW(), NOW() ),
( 'Historical Beer: Lichtenhainer', '27A', 'Historical Beer', 'BJCP 2021', '1.032', '1.040', '1.004', '1.008', '3.5', '4.7', '5', '12', '3', '6', NOW(), NOW() ),
( 'Historical Beer: London Brown Ale', '27A', 'Historical Beer', 'BJCP 2021', '1.033', '1.038', '1.012', '1.015', '2.8', '3.6', '15', '20', '22', '35', NOW(), NOW() ),
( 'Historical Beer: Piwo Grodziskie', '27A', 'Historical Beer', 'BJCP 2021', '1.028', '1.032', '1.006', '1.012', '2.5', '3.3', '20', '35', '3', '6', NOW(), NOW() ),
( 'Historical Beer: Pre-Prohibition Lager', '27A', 'Historical Beer', 'BJCP 2021', '1.044', '1.060', '1.010', '1.015', '4.5', '6.0', '25', '40', '3', '6', NOW(), NOW() ),
( 'Historical Beer: Pre-Prohibition Porter', '27A', 'Historical Beer', 'BJCP 2021', '1.046', '1.060', '1.010', '1.016', '4.5', '6.0', '20', '30', '20', '30', NOW(), NOW() ),
( 'Historical Beer: Roggenbier', '27A', 'Historical Beer', 'BJCP 2021', '1.046', '1.056', '1.010', '1.014', '4.5', '6.0', '10', '20', '14', '19', NOW(), NOW() ),
( 'Historical Beer: Sahti', '27A', 'Historical Beer', 'BJCP 2021', '1.076', '1.120', '1.016', '1.020', '7.0', '11', '0', '15', '4', '22', NOW(), NOW() ),
( 'Brett Beer', '28A', 'American Wild Ale', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Mixed-Fermentation Sour Beer', '28B', 'American Wild Ale', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Wild Specialty Beer', '28C', 'American Wild Ale', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Straight Sour Beer', '28D', 'American Wild Ale', 'BJCP 2021', '1.048', '1.065', '1.006', '1.013', '4.5', '7.0', '3', '8', '2', '3', NOW(), NOW() ),
( 'Fruit Beer', '29A', 'Fruit Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Fruit and Spice Beer', '29B', 'Fruit Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Fruit Beer', '29C', 'Fruit Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Grape Ale', '29D', 'Fruit Beer', 'BJCP 2021', '1.059', '1.075', '1.004', '1.013', '6.0', '8.5', '10', '30', '4', '8', NOW(), NOW() ),
( 'Spice, Herb or Vegetable Beer', '30A', 'Spiced Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Autumn Seasonal Beer', '30B', 'Spiced Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Winter Seasonal Beer', '30C', 'Spiced Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Spice Beer', '30D', 'Spiced Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Alternative Grain Beer', '31A', 'Alternative Fermentables Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Alternative Sugar Beer', '31B', 'Alternative Fermentables Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Classic Style Smoked Beer', '32A', 'Smoked Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Smoked Beer', '32B', 'Smoked Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Wood-Aged Beer', '33A', 'Wood Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Wood-Aged Beer', '33B', 'Wood Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Commercial Spevialty Beer', '34A', 'Specialty Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Mixed-Style Beer', '34B', 'Specialty Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Experimental Beer', '34C', 'Specialty Beer', 'BJCP 2021', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NOW(), NOW() ),
( 'Dry Mead', 'M1A', 'Traditional Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Semi-Sweet Mead', 'M1B', 'Traditional Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Sweet Mead', 'M1C', 'Traditional Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Cyser', 'M2A', 'Fruit Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Pyment', 'M2B', 'Fruit Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Berry Mead', 'M2C', 'Fruit Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Stone Fruit Mead', 'M2D', 'Fruit Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Melomel', 'M2E', 'Fruit Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Fruit and Spice Mead', 'M3A', 'Spiced Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Spice, Herb or Vegetable Mead', 'M3B', 'Spiced Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Braggot', 'M4A', 'Specialty Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Historical Mead', 'M4B', 'Specialty Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'Experimental Mead', 'M4C', 'Specialty Mead', 'BJCP 2015', '1.035', '1.17', '0.99', '1.01', '3.5', '18', '0', '0', '0', '0', NOW(), NOW() ),
( 'New World Cider', 'C1A', 'Standard Cider and Perry', 'BJCP 2015', '1.045', '1.065', '0.995', '1.020', '5', '8', '0', '0', '0', '0', NOW(), NOW() ),
( 'English Cider', 'C1B', 'Standard Cider and Perry', 'BJCP 2015', '1.050', '1.075', '0.995', '1.015', '6', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'French Cider', 'C1C', 'Standard Cider and Perry', 'BJCP 2015', '1.050', '1.065', '1.010', '1.020', '3', '6', '0', '0', '0', '0', NOW(), NOW() ),
( 'New World Perry', 'C1D', 'Standard Cider and Perry', 'BJCP 2015', '1.050', '1.060', '1.000', '1.020', '5', '7', '0', '0', '0', '0', NOW(), NOW() ),
( 'Traditional Perry', 'C1E', 'Standard Cider and Perry', 'BJCP 2015', '1.050', '1.070', '1.000', '1.020', '5', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'New England Cider', 'C2A', 'Specialty Cider and Perry', 'BJCP 2015', '1.060', '1.100', '0.995', '1.020', '7', '13', '0', '0', '0', '0', NOW(), NOW() ),
( 'Cider with Other Fruit', 'C2B', 'Specialty Cider and Perry', 'BJCP 2015', '1.045', '1.070', '0.995', '1.010', '5', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'Applewine', 'C2C', 'Specialty Cider and Perry', 'BJCP 2015', '1.070', '1.100', '0.995', '1.020', '9', '12', '0', '0', '0', '0', NOW(), NOW() ),
( 'Ice Cider', 'C2D', 'Specialty Cider and Perry', 'BJCP 2015', '1.130', '1.180', '1.060', '1.085', '7', '13', '0', '0', '0', '0', NOW(), NOW() ),
( 'Cider with Herbs/Spices', 'C2E', 'Specialty Cider and Perry', 'BJCP 2015', '1.045', '1.070', '0.995', '1.010', '5', '9', '0', '0', '0', '0', NOW(), NOW() ),
( 'Specialty Cider/Perry', 'C2F', 'Specialty Cider and Perry', 'BJCP 2015', '1.045', '1.100', '0.995', '1.020', '5', '12', '0', '0', '0', '0', NOW(), NOW() );



-- --------------------------------------------------------

--
-- Table structure for table `beers`
--

CREATE TABLE IF NOT EXISTS `beers` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` text NOT NULL,
	`untID` int(10) NULL,
	`beerStyleId` int(11) NULL,
	`breweryId` int(11),
	`notes` text NULL,
	`abv` decimal(3,1) NULL,
	`og` decimal(7,3) NULL,
	`ogUnit` tinytext NULL,
	`fg` decimal(7,3) NULL,
	`fgUnit` tinytext NULL,
	`srm` decimal(7,1) NULL,
	`ibu` int(4) NULL,
	`rating` decimal(3,1) NULL,
	`containerId` int(11) NULL DEFAULT 1,
	`active` tinyint(1) NULL DEFAULT 1,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,

PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `beerBatches` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`beerId` int(11) NULL,
	`batchNumber` int(11) NULL,
	`name` varchar(40) NULL,
	`notes` text NULL,
	`startAmount` decimal(10,5) NULL,
	`startAmountUnit` tinytext NULL,
	`currentAmount` decimal(10,5) NULL,
	`currentAmountUnit` tinytext NULL,
	`fermentationTempMin` decimal(14,2) DEFAULT NULL,
	`fermentationTempMinUnit` tinytext,
	`fermentationTempSet` decimal(14,2) DEFAULT NULL,
	`fermentationTempSetUnit` tinytext,
	`fermentationTempMax` decimal(14,2) DEFAULT NULL,
	`fermentationTempMaxUnit` tinytext,
	`abv` decimal(3,1) NULL,
	`og` decimal(7,3) NULL,
	`ogUnit` tinytext NULL,
	`fg` decimal(7,3) NULL,
	`fgUnit` tinytext NULL,
	`srm` decimal(7,1) NULL,
	`ibu` int(4) NULL,
	`rating` decimal(3,1) NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `beerBatchDateTypes` (
  `type` int(11) NOT NULL AUTO_INCREMENT,
  `displayName` text NOT NULL,
  `createdDate` timestamp NULL DEFAULT NULL,
  `modifiedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO beerBatchDateTypes VALUES('1','Brewed','2021-01-21 09:56:22','2021-01-21 09:56:22');
INSERT INTO beerBatchDateTypes VALUES('2','Primary','2021-01-21 09:56:22','2021-01-21 09:56:22');
INSERT INTO beerBatchDateTypes VALUES('3','Secondary','2021-01-21 09:56:22','2021-01-21 09:56:22');
INSERT INTO beerBatchDateTypes VALUES('4','Kegged','2021-01-21 09:56:22','2021-01-21 09:56:22');
INSERT INTO beerBatchDateTypes VALUES('5','Bottle','2021-01-21 09:56:22','2021-01-21 09:56:22');
INSERT INTO beerBatchDateTypes VALUES('6','Gone','2021-01-21 09:56:22','2021-01-21 09:56:22');
        
CREATE TABLE IF NOT EXISTS `beerBatchDates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beerBatchId` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `createdDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `beerBatchId` (`beerBatchId`),
  KEY `type` (`type`),
  CONSTRAINT `beerBatchDates_ibfk_1` FOREIGN KEY (`beerBatchId`) REFERENCES `beerBatches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `beerBatchDates_ibfk_2` FOREIGN KEY (`type`) REFERENCES `beerBatchDateTypes` (`type`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`configName` varchar(50) NOT NULL,
	`configValue` longtext NOT NULL,
	`displayName` varchar(65) NOT NULL,
	`showOnPanel` tinyint(2) NOT NULL,
	`validation` varchar(65) NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,

	PRIMARY KEY (`id`),
	UNIQUE KEY `configName_UNIQUE` (`configName`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showTapNumCol', '1', 'Show Tap Column', '1', NOW(), NOW() ),
( 'showBeerImages', '0', 'Show Beer Images', '1', NOW(), NOW() ),
( 'showBreweryImages', '0', 'Show Brewery Images', '1', NOW(), NOW() ),
( 'showSrmCol', '1', 'Show SRM Column', '1', NOW(), NOW() ),
( 'showIbuCol', '1', 'Show IBU Column', '1', NOW(), NOW() ),
( 'showAbvCol', '1', 'Show ABV Column', '1', NOW(), NOW() ),
( 'showKegCol', '0', 'Show Keg Column', '1', NOW(), NOW() ),
( 'showAbvImg', '1', 'Show ABV Images', '1', NOW(), NOW() ),
( 'showAbvTxtWImg', '1', 'Show ABV Text If Image is shown', '1', NOW(), NOW() ),
( 'showCalCol', '1', 'Show Cal Information', '1', NOW(), NOW() ),
( 'showSrmImg', '1', 'Show SRM Image Instead of Calculated Color', '1', NOW(), NOW() ),
( 'showIbuImg', '1', 'Show IBU Image', '1', NOW(), NOW() ),
( 'showKegImg', '1', 'Show Keg Image', '1', NOW(), NOW() ),
( 'showOgValue', '1', 'Show OG Value', '1', NOW(), NOW() ),
( 'showSrmValue', '1', 'Show SRM Value', '1', NOW(), NOW() ),
( 'showBuGuValue', '1', 'Show BU:GU Value', '1', NOW(), NOW() ),
( 'showIbuValue', '1', 'Show IBU Value', '1', NOW(), NOW() ),
( 'showBeerName', '1', 'Show Beer Name', '1', NOW(), NOW() ),
( 'showBeerRating', '1', 'Show Beer Rating', '1', NOW(), NOW() ),
( 'showBeerStyle', '1', 'Show Beer Style', '1', NOW(), NOW() ),
( 'showTastingNotes', '1', 'Show Tasting Notes', '1', NOW(), NOW() ),
( 'showAbvValue', '1', 'Show ABV Value', '1', NOW(), NOW() ),
( 'showPouredValue', '1', 'Show Poured Value', '1', NOW(), NOW() ),
( 'showLastPouredValue', '1', 'Show Last Poured Value', '1', NOW(), NOW() ),
( 'showRemainValue', '1', 'Show Remaining Value', '1', NOW(), NOW() ),
( 'showRPLogo', '0', 'Show the RaspberryPints Logo', '1', NOW(), NOW() ),
( 'showDigitalClock', '0', 'Show digital Clock in upper Right', '0', NOW(), NOW() ),
( 'showDigitalClock24', '0', 'Show 24hr digital Clock in upper Right', '0', NOW(), NOW() ),
( 'showAnalogClock', '0', 'Show analog Clock in upper Right', '0', NOW(), NOW() ),
( 'showLastPour', '0', 'Show the Last Pour in Upper Right Corner', '1', NOW(), NOW() ),
( 'showCalories', '0', 'Show the calories', '1', NOW(), NOW() ),
( 'showGravity', '1', 'Show the Gravity numbers', '1', NOW(), NOW() ),
( 'showBalance', '0', 'Show the Balance', '1', NOW(), NOW() ),
( 'showBeerTableHead', '1', 'Show the Title Bar on Beer List', '1', NOW(), NOW() ),
( 'logoUrl', 'img/logo.png', 'Logo Url', '0', NOW(), NOW() ),
( 'adminLogoUrl', 'admin/img/logo.png', 'Admin Logo Url', '0', NOW(), NOW() ),
( 'headerText', 'Currently On Tap', 'Header Text', '0', NOW(), NOW() ),
( 'showUntappdBreweryFeed', '0 ', 'Show brewery Untappd feed above header', '0', NOW(), NOW() ),
( 'numberOfTaps', '0', 'Number of Taps', '0', NOW(), NOW() ),
( 'version', '3.0.9.0', 'Version', '0', NOW(), NOW() ),
( 'headerTextTruncLen' ,'20', 'Header Text Truncate Length', '0', NOW(), NOW() ),
( 'useFlowMeter','0','Use Flow Monitoring', '1', NOW(),NOW() ),
( 'usePlaato', '0', 'Use Plaato Values', '1', NOW(), NOW() ),
( 'usePlaatoTemp', '0', 'Use Plaato Temp', '1', NOW(), NOW() ),
( 'allowManualPours', '0', 'Allow Enter Of Manual Pours', '0', NOW(), NOW() ),
( 'ClientID', '','Client ID', '0', NOW(), NOW() ),
( 'ClientSecret','','Client Secret','0',NOW(),NOW() ),
( 'RedirectUri','','Redirect URI','0',NOW(),NOW() ),
( 'BreweryID', '','Brewery ID','0',NOW(),NOW() ),
( 'adminThemeColor', 'styles.css', 'Admin Color', '0', NOW(), NOW() ),
( 'useHighResolution', '0', '4k Monitor Support', '1', NOW(), NOW() ),
( 'autoRefreshLocal', '1', 'refresh listeners automatically', '1', NOW(), NOW() ),
( 'displayRowsSameHeight', '1', 'Display all tap rows as the same height', '1', NOW(), NOW() ),
( 'useKegWeightCalc', '1', 'Show weight calc columns', '1', NOW(), NOW() ),
( 'useDefWeightSettings', '0', 'Do not allow individual tap configurations', '1', NOW(), NOW() ),
( 'breweryAltitude', '0', 'Feet Above Sea Level', '0', NOW(), NOW() ),
( 'breweryAltitudeUnit', 'ft', '', '0', NOW(), NOW() ),
( 'defaultFermPSI', '0', 'Default pressure of fermentation (0 if not pressure ferment)', '0', NOW(), NOW() ),
( 'defaultFermPSIUnit', 'psi', 'Default pressure of fermentation Unit', '0', NOW(), NOW() ),
( 'defaultKeggingTemp', '56', 'Default Temperature of beer when kegging', '0', NOW(), NOW() ),
( 'defaultKeggingTempUnit', 'F', 'Default Temperature Unit of beer when kegging', '0', NOW(), NOW() ),
( 'allowSamplePour', '1', 'Allow Sample Pour from List', '1', NOW(), NOW() ),
( 'samplePourSize', '0', 'Size of sample Pour', '0', NOW(), NOW() ),
( 'saveNonUserRfids', '1', 'If unknown RFID tags should be saved into the database', '1', NOW(), NOW() ),
( 'showPourListOnHome', '1', 'Show list of pours on home screen', '1', NOW(), NOW() ),
( 'ABVColorSRM', '1', 'Use beers SRM color to fill in the ABV indicator', '1', NOW(), NOW() ),
( 'ignorePours', '0', 'Do not save pours to the database', '1', NOW(), NOW() );

INSERT INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES
('autoKickKegs', '1', 'Kick Kegs from Tap when kill is detected', 1, NOW(), NOW() ),
('useTapValves', '0', 'Use Tap Valves', 1, NOW(), NOW() ),
('use3WireValves', '0', 'Use Three Wire Valves', 1, NOW(), NOW() ),
('valvesOnTime', '8', 'Time to keep Valves on', 0, NOW(), NOW() ),
('useFanControl', '0', 'Use Fan Control', 1, NOW(), NOW() ),
('useFanPin', '17', 'Fan I/O Pin', 0, NOW(), NOW() ),
('fanInterval', '120', 'Fan Interval', 0, NOW(), NOW() ),
('fanOnTime', '1', 'Fan On time', 0, NOW(), NOW() ),
('restartFanAfterPour', '1', 'Restart Fan After pour', 0, NOW(), NOW() ),
('useTempProbes', '0', 'Use Temperature Probes', 0, NOW(), NOW() ),
('tempProbeDelay', '1', 'Seconds between checking temp Probes', 0, NOW(), NOW() ),
('tempProbeBoundLow', '0', 'Lower bound of valid Temperature', 0, NOW(), NOW() ),
('tempProbeBoundHigh', '212', 'High bound of valid Temperature', 0, NOW(), NOW() ),
('showTempOnMainPage', '0', 'Show Avg Temperature on home page', 1, NOW(), NOW() ),
('pourShutOffCount', '0', 'pour shutoff amount in counts', 0, NOW(), NOW() ),
('pourCountConversion', '1500', 'pour count conversion to gallons', 0, NOW(), NOW() ),
('alamodePourMessageDelay', '300', 'Arduino Pour Message Delay', 0, NOW(), NOW() ),
('alamodePourTriggerCount', '200', 'Alamode Pour Trigger Count', 0, NOW(), NOW() ),
('alamodeKickTriggerCount', '30', 'Alamode Kick Trigger Count', 0, NOW(), NOW() ),
('alamodeUpdateTriggerCount', '250', 'Alamode Update Trigger Count', 0, NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, validation, createdDate, modifiedDate ) VALUES
( 'relayTrigger', '0', 'Show list of pours on home screen', '0', 'High|Low', NOW(), NOW() ),
( 'hozTapListCol', '0', 'Number Of horizontal tap List Beer Column', '1', '2|1', NOW(), NOW() );


INSERT INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES
( 'numberOfDisplayPours', '10', 'Pours to display at one time (0 dont show pours)', 0, NOW(), NOW() ),
( 'showPourTapNumCol', '1', 'Pours Show Tap Column', '1', NOW(), NOW() ),
( 'showPourBeerImages', '0', 'Pours Show Beer Images', '1', NOW(), NOW() ),
( 'showPourBreweryImages', '0', 'Pours Show Brewery Images', '1', NOW(), NOW() ),
( 'showPourBeerName', '1', 'Pours Show Beer Name', '1', NOW(), NOW() ),
( 'showPourAmount', '1', 'Pours Show Amount Poured', '1', NOW(), NOW() ),
( 'showPourUserName', '1', 'Pours Show User Name', '1', NOW(), NOW() ),
( 'showPourDate', '1', 'Pours Show Date', '1', NOW(), NOW() );

INSERT INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `validation`, `createdDate`, `modifiedDate`) VALUES
( 'displayUnitVolume', 'oz', 'Volume Units', '0', 'Imperial;oz|Metric;ml', NOW(), NOW() ),
( 'displayUnitPressure', 'psi', 'Pressure Units', '0', 'psi|Pa', NOW(), NOW() ),
( 'displayUnitDistance', 'ft', 'Distance Units', '0', 'ft|m', NOW(), NOW() ),
( 'displayUnitGravity', 'sg', 'Gravity Units', '0', 'sg|bx|p', NOW(), NOW() ),
( 'displayUnitTemperature', 'F', 'Temperature Units', '0', 'F|C', NOW(), NOW() ),
( 'displayUnitWeight', 'lb', 'Weight Units', '0', 'lb|kg', NOW(), NOW() );

INSERT INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `validation`, `createdDate`, `modifiedDate`) VALUES
( 'showVerticleTapList', '0', 'Show Tap List Direction', '1', 'Vertical|Horizontal', NOW(), NOW() );

INSERT INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES
('TapNumColNum', '1', 'Column number for Tap Number', 0, NOW(), NOW() ),
('SrmColNum', '2', 'Column number for SRM', 0, NOW(), NOW() ),
('IbuColNum', '3', 'Column number for IBU', 0, NOW(), NOW() ),
('BeerInfoColNum', '4', 'Column number for Beer Info', 0, NOW(), NOW() ),
('AbvColNum', '5', 'Column number for ABV', 0, NOW(), NOW() ),
('KegColNum', '6', 'Column number for Keg', 0, NOW(), NOW() ),
('AccoladeColNum', '7', 'Column number for Accolades', 0, NOW(), NOW() );

INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
('numAccoladeDisplay', '3', 'Number of Accolades to display in a row/column', 0, NOW(), NOW() );


INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES

( 'amountPerPint', '0', 'Amount per pint. > 0 then display pints remaining', '0', NOW(), NOW() );


INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, validation, createdDate, modifiedDate ) VALUES
( 'RefreshTapList', '0', 'Refresh the tap list every 60 seconds', '1', NULL, NOW(), NOW() ),
( 'InfoTime', '60', 'Number Of seconds beween changing upper right tap List', '0', NULL, NOW(), NOW() ),
( 'showFermOnMainPage', '1', 'Show Fermenters in upper right tap List', '1', NULL, NOW(), NOW() ),
( 'showGTOnMainPage', '1', 'Show Gas Tanks in upper right tap List', '1', NULL, NOW(), NOW() ),
( 'showAllGTOnMainPage', '0', 'When showing gas Tanks, Show all Gas Tanks', '1', NULL, NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, validation, createdDate, modifiedDate ) VALUES
( 'iSUpdateMinTemp', '1', 'iSpindel should update beer batch min temp', '0', NULL, NOW(), NOW() ),
( 'iSUpdateMaxTemp', '1', 'iSpindel should update beer batch max temp', '0', NULL, NOW(), NOW() ),
( 'iSUpdateOG', '1', 'iSpindel should update beer og', '0', NULL, NOW(), NOW() ),
( 'iSUpdateFG', '1', 'iSpindel should update beer fg', '0', NULL, NOW(), NOW() );

INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `validation`, `createdDate`, `modifiedDate`) VALUES
( 'maxPourAmount', '100', 'Maximum Amount allowed to be poured', '0', 'number:1-999', NOW(), NOW() );
-- --------------------------------------------------------

--
-- Table structure for table `kegTypes`
--

CREATE TABLE IF NOT EXISTS `kegTypes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`displayName` text NOT NULL,
	`maxAmount` decimal(6,2) NOT NULL,
	`maxAmountUnit`  tinytext NULL,
	`emptyWeight` decimal(11, 4) NOT NULL,
	`emptyWeightUnit` tinytext NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegTypes`
--

INSERT INTO `kegTypes` ( displayName, maxAmount, maxAmountUnit, emptyWeight, emptyWeightUnit, createdDate, modifiedDate ) VALUES
( 'Ball Lock (5 gal)', '5', 'gal', '8.1571', 'lb', NOW(), NOW() ),
( 'Ball Lock (2.5 gal)', '2.5', 'gal', '4.0786', 'lb', NOW(), NOW() ),
( 'Ball Lock (3 gal)', '3', 'gal', '4.8943', 'lb', NOW(), NOW() ),
( 'Ball Lock (10 gal)', '10', 'gal', '16.3142', 'lb', NOW(), NOW() ),
( 'Pin Lock (5 gal)', '5', 'gal', '8.1571', 'lb', NOW(), NOW() ),
( 'Sanke (1/6 bbl)', '5.16', 'gal', '9.9', 'lb', NOW(), NOW() ),
( 'Sanke (1/4 bbl)', '7.75', 'gal', '14.85', 'lb', NOW(), NOW() ),
( 'Sanke (slim 1/4 bbl)', 'gal', '7.75', '14.85', 'lb', NOW(), NOW() ),
( 'Sanke (1/2 bbl)', '15.5', 'gal', '29.7', 'lb', NOW(), NOW() ),
( 'Sanke (Euro)', '13.2', 'gal', '0', 'lb', NOW(), NOW() ),
( 'Cask (pin)', '10.81', 'gal', '0', 'lb', NOW(), NOW() ),
( 'Cask (firkin)', '10.81', 'gal', '0', 'lb', NOW(), NOW() ),
( 'Cask (kilderkin)', '21.62', 'gal', '0', 'lb', NOW(), NOW() ),
( 'Cask (barrel)', '43.23', 'gal', '0', 'lb', NOW(), NOW() ),
( 'Cask (hogshead)', '64.85', 'gal', '0', 'lb', NOW(), NOW() );

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
( 'BULK_AGING', 'Bulk Aging', NOW(), NOW() ),
( 'FLOODED', 'Flooded', NOW(), NOW() ),
( 'SANITIZED', 'Sanitized', NOW(), NOW() ),
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
	`label` varchar(40) NOT NULL,
	`kegTypeId` int(11) NOT NULL,
	`make` text NULL,
	`model` text NULL,
	`serial` text NULL,
	`stampedOwner` text NULL,
	`stampedLoc` text NULL,
	`notes` text NULL,
	`kegStatusCode` varchar(20) NULL,
	`weight` decimal(11,4) NULL,
	`weightUnit` tinytext NULL,
	`emptyWeight` decimal(11,4) NULL,
	`emptyWeightUnit` tinytext NULL,
	`maxVolume` decimal(11,4) NULL,
	`maxVolumeUnit` tinytext NULL,
	`startAmount` decimal(10,5) NULL,
	`startAmountUnit` tinytext NULL,
	`currentAmount` decimal(10,5) NULL,
	`currentAmountUnit` tinytext NULL,
	`fermentationPSI` decimal(14,2) DEFAULT NULL,
	`fermentationPSIUnit` tinytext NULL,
	`keggingTemp` decimal(6,2) DEFAULT NULL,
	`keggingTempUnit` tinytext DEFAULT NULL,
	`onTapId` int(11) NULL,
	`beerId` int(11) NULL,
    `beerBatchId` int(11) DEFAULT NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
    `hasContinuousLid` int(11) DEFAULT 0,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`kegStatusCode`) REFERENCES kegStatuses(`Code`) ON DELETE CASCADE,
	FOREIGN KEY (`kegTypeId`) REFERENCES kegTypes(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tapconfig`
--

CREATE TABLE IF NOT EXISTS `tapconfig` (
  `tapId` int(11) DEFAULT NULL,
  `flowPin` int(11) DEFAULT NULL,
  `valvePin` int(11) DEFAULT NULL,
  `valveOn` int(11) DEFAULT NULL,
  `valvePinState` int(11) DEFAULT NULL,
  `count` float NOT NULL DEFAULT '1500',
  `countUnit` tinytext NULL,
  `loadCellCmdPin` int(11) DEFAULT NULL,
  `loadCellRspPin` int(11) DEFAULT NULL,
  `loadCellTareReq` int(11) DEFAULT NULL,
  `loadCellScaleRatio` float DEFAULT NULL,
  `loadCellTareOffset` float DEFAULT NULL,
  `loadCellUnit` tinytext DEFAULT NULL,
  `loadCellTareDate` TIMESTAMP NULL,
  `plaatoAuthToken` tinytext NULL,
	PRIMARY KEY (`tapId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `taps`
--

CREATE TABLE IF NOT EXISTS `taps` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`kegId` int(11) NULL,
	`tapNumber` int(11) NULL,
	`tapRgba` varchar(16) NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pours`
--

CREATE TABLE IF NOT EXISTS `pours` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`tapId` int(11) NOT NULL,
	`beerId` int(11) NOT NULL,
	`beerBatchId` int(11) NULL,
	`pinId` int(11) NOT NULL,
	`amountPoured` decimal(9,7) NOT NULL,
	`amountPouredUnit` tinytext NULL,
	`pulses` int(11) NOT NULL,
	`conversion` int(11) NOT NULL,    
	`userId` int(11) NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (tapId) REFERENCES taps(id) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fermentables`
--

CREATE TABLE IF NOT EXISTS `fermentables` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`type` tinytext NULL,
	`srm` decimal(7,1) NULL,
	`notes` text NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `beerFermentables` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`beerId` int(11) NOT NULL,
  `fermentablesId`int(11) NOT NULL,
	`amount` tinytext NULL,
	`time` tinytext NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`fermentablesId`) REFERENCES fermentables(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Table structure for table `hops`
--

CREATE TABLE IF NOT EXISTS `hops` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`alpha` decimal(6,2),
	`beta` decimal(6,2),
	`notes` text NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `beerHops` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`beerId` int(11) NOT NULL,
  `hopsId`  int(11) NOT NULL,
	`amount` tinytext NULL,
	`time` tinytext NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`hopsId`) REFERENCES hops(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;
--
-- Table structure for table `yeasts`
--
 
CREATE TABLE IF NOT EXISTS `yeasts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`strand` tinytext NULL,
	`format` tinytext NULL,
	`minTemp` int(6) ,
	`minTempUnit` tinytext ,
	`maxTemp` int(6) ,
	`maxTempUnit` tinytext ,
	`minAttenuation` decimal(6,2) ,
	`maxAttenuation` decimal(6,2) ,
	`flocculation` decimal(6,2) ,
	`notes` text NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `beerYeasts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`beerId` int(11) NOT NULL,
  `yeastsId`int(11) NOT NULL,
	`amount` tinytext NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`yeastsId`) REFERENCES yeasts(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

CREATE TABLE `beerBatchYeasts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beerBatchId` int(11) NOT NULL,
  `yeastsId` int(11) NOT NULL,
  `amount` tinytext,
  PRIMARY KEY (`id`),
  KEY `beerBatchId` (`beerBatchId`),
  KEY `yeastsId` (`yeastsId`),
  CONSTRAINT `beerBatchYeasts_ibfk_1` FOREIGN KEY (`beerBatchId`) REFERENCES `beerBatches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `beerBatchYeasts_ibfk_2` FOREIGN KEY (`yeastsId`) REFERENCES `yeasts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `bottleTypes`
--

--
-- Table structure for table `Accolades`
--

CREATE TABLE IF NOT EXISTS `accolades` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`rank` int(11) NULL,
	`type` tinytext NULL,
	`srm` decimal(7,1) NULL,
	`notes` text NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `beerAccolades` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`beerId` int(11) NOT NULL,
    `accoladeId`int(11) NOT NULL,
	`amount` tinytext NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`accoladeId`) REFERENCES accolades(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

INSERT INTO accolades (id, name, rank, type, srm, notes, createdDate, modifiedDate) VALUES('1','Gold',1,'Medal','3.0','','2020-08-04 14:13:55','2020-08-04 14:14:34');
INSERT INTO accolades (id, name, rank, type, srm, notes, createdDate, modifiedDate) VALUES('2','Silver',2,'Medal','4.2','','2020-08-04 14:14:34','2020-08-04 14:14:34');
INSERT INTO accolades (id, name, rank, type, srm, notes, createdDate, modifiedDate) VALUES('3','Bronze',3,'Medal','9.6','','2020-08-04 14:14:34','2020-08-04 14:14:34');
INSERT INTO accolades (id, name, rank, type, srm, notes, createdDate, modifiedDate) VALUES('4','BOS',4,'Medal','9.6','','2020-08-04 14:14:34','2020-08-04 14:14:34');

CREATE TABLE IF NOT EXISTS `bottleTypes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`displayName` text NOT NULL,
	`volume` decimal(6,2) NOT NULL,
	`volumeUnit` tinytext,
	`total` int(11) NOT NULL,
	`used` int(11) NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bottleTypes`
--

INSERT INTO `bottleTypes` ( displayName, volume, total, used, createdDate, modifiedDate ) VALUES
( 'standard (12oz)', '12.0', '40', '0', NOW(), NOW() ),
( 'flip top (16oz)', '16.0', '5', '0', NOW(), NOW() );

CREATE TABLE IF NOT EXISTS `containerTypes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`displayName` text NOT NULL,
	`volume` decimal(6,2) NOT NULL,
	`volumeUnit` tinytext,
	`total` int(11) NOT NULL,
	`used` int(11) NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;


--
-- Dumping data for table `bottleTypes`
--

INSERT INTO `containerTypes` ( id, displayName, volume, total, used, createdDate, modifiedDate ) VALUES
( 1,'standardpint', '16.0', '0', '0', NOW(), NOW() ),
( 2,'chalice', '16.0', '0', '0', NOW(), NOW() ),
( 3,'nonic', '16.0', '0', '0', NOW(), NOW() ),
( 4,'pilsner', '16.0', '0', '0', NOW(), NOW() ),
( 5,'spiegelau', '16.0', '0', '0', NOW(), NOW() ),
( 6,'goblet', '16.0', '0', '0', NOW(), NOW() ),
( 7,'snifter', '16.0', '0', '0', NOW(), NOW() ),
( 8,'stange', '16.0', '0', '0', NOW(), NOW() ),
( 9,'stein', '16.0', '0', '0', NOW(), NOW() ),
( 10,'tulip', '16.0', '0', '0', NOW(), NOW() ),
( 11,'weizenglass', '16.0', '0', '0', NOW(), NOW() ),
( 12,'willibecher', '16.0', '0', '0', NOW(), NOW() ),
( 13,'wineglass', '16.0', '0', '0', NOW(), NOW() ),

( 14,'flute', '16.0', '0', '0', NOW(), NOW() ),

( 15,'teku', '16.0', '0', '0', NOW(), NOW() ),

( 16,'thistle', '16.0', '0', '0', NOW(), NOW() );

CREATE TABLE IF NOT EXISTS `rfidReaders` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NULL,
	`type` int(11) NOT NULL,
	`pin` int(11) NULL,
	`priority` int(11) NULL DEFAULT 0,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `motionDetectors` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NULL,
	`type` int(11) NOT NULL DEFAULT 0,
	`pin` int(11) NULL,
	`priority` int(11) NULL DEFAULT 0,
	`ledPin` int(11) NULL DEFAULT 0,
	`soundFile` tinytext,
	`mqttCommand` tinytext,
	`mqttEvent` tinytext,
	`mqttUser` tinytext,
	`mqttPass` tinytext,
	`mqttHost` tinytext,
	`mqttPort` tinytext,
	`mqttInterval` int(11) NOT NULL DEFAULT 100,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `tapEvents` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `tapId` int(11) NOT NULL,
  `kegId` int(11) NOT NULL,
  `beerId` int(11) NOT NULL,
  `beerBatchId` int(11) NULL,
  `amount` decimal(7,5) DEFAULT NULL,
  `amountUnit` tinytext NULL,
  `beerBatchAmount` decimal(7,5) DEFAULT NULL,
  `beerBatchAmountUnit` tinytext NULL,
  `userId` int(11) NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bottles`
--

CREATE TABLE IF NOT EXISTS `bottles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`bottleTypeId` int(11) NOT NULL,
	`beerId` int(11) NOT NULL,
	`beerBatchId` int(11) NULL,
	`capRgba` varchar(16) NULL,
	`capNumber` int(11) NULL,
	`startAmount` int(11) NULL DEFAULT 0,
	`currentAmount` int(11) NULL DEFAULT 0,
	`active` tinyint(1) NULL DEFAULT 1,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`bottleTypeId`) REFERENCES bottleTypes(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS`users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`username` varchar(65) CHARACTER SET utf8 NOT NULL,
	`password` varchar(65) CHARACTER SET utf8 NOT NULL DEFAULT '',
	`active` tinyint(1) NOT NULL,
	`nameFirst` varchar(65) CHARACTER SET utf8 NULL,
	`nameLast` varchar(65) CHARACTER SET utf8 NULL,
	`mugId` text NULL,
	`email` varchar(65) CHARACTER SET utf8 NULL,
	`unTapAccessToken` text NULL,
	`isAdmin` tinyint(1) NOT NULL DEFAULT 0,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,

	PRIMARY KEY (`id`),
	UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `userRfids` (
	`userId` int(11) NOT NULL,
	`RFID` varchar(128) CHARACTER SET utf8 NOT NULL,
	`description` varchar(65) CHARACTER SET utf8 NULL,
	PRIMARY KEY (`userId`, `RFID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `srmRgb` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`srm` decimal(7,1) NOT NULL,
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

CREATE TABLE IF NOT EXISTS `ioPins` (
	`shield` varchar(30) NOT NULL,
  `pin` int(11) DEFAULT NULL,
  `displayPin` text DEFAULT NULL,
	`name` tinytext NULL,
  `col` int(11) DEFAULT NULL,
  `row` int(11) DEFAULT NULL,
	`rgb` varchar(12) NULL,
	`notes` text NULL,
	`pinSide` tinytext NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,	
	PRIMARY KEY (`shield`, `pin`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

INSERT INTO ioPins ( shield, pin, name, col, row, rgb, pinSide, notes, createdDate, modifiedDate ) VALUES

('Pi', 1, 'PWR/3.3V', 1, 1, '255,200,126', 'right', '', NOW(), NOW()),

('Pi', 2, 'PWR/5v', 2, 1, '255,200,200', 'left', '', NOW(), NOW()),

('Pi', 3, 'SDA.1/2', 1, 2, '255,200,255', 'right', '', NOW(), NOW()),

('Pi', 4, 'PWR/5v', 2, 2, '255,200,200', 'left', '', NOW(), NOW()),

('Pi', 5, 'SCL.1/3', 1, 3, '255,200,255', 'right', '', NOW(), NOW()),

('Pi', 6, 'GND/0v', 2, 3, '126,126,126', 'left', '', NOW(), NOW()),

('Pi', 7, 'GPIO.7/4', 1, 4, '226,255,200', 'right', '', NOW(), NOW()),

('Pi', 8, 'TxD/14', 2, 4, '200,255,255', 'left', '', NOW(), NOW()),

('Pi', 9, 'GND/0v', 1, 5, '126,126,126', 'right', '', NOW(), NOW()),

('Pi', 10, 'RxD/15', 2, 5, '200,255,255', 'left', '', NOW(), NOW()),

('Pi', 11, 'GPIO.0/17', 1, 6, '226,255,200', 'right', '', NOW(), NOW()),

('Pi', 12, 'GPIO.1/18', 2, 6, '226,255,200', 'left', '', NOW(), NOW()),

('Pi', 13, 'GPIO.2/27', 1, 7, '226,255,200', 'right', '', NOW(), NOW()),

('Pi', 14, 'GND/0v', 2, 7, '126,126,126', 'left', '', NOW(), NOW()),

('Pi', 15, 'GPIO.3/22', 1, 8, '226,255,200', 'right', '', NOW(), NOW()),

('Pi', 16, 'GPIO.4/23', 2, 8, '226,255,200', 'left', '', NOW(), NOW()),

('Pi', 17, 'PWR/3.3v', 1, 9, '255,200,126', 'right', '', NOW(), NOW()),

('Pi', 18, 'GPIO.5/24', 2, 9, '226,255,200', 'left', '', NOW(), NOW()),

('Pi', 19, 'MOSI/10', 1, 10, '200,255,255', 'right', '', NOW(), NOW()),

('Pi', 20, 'GND/0v', 2, 10, '126,126,126', 'left', '', NOW(), NOW()),

('Pi', 21, 'MISO/9', 1, 11, '200,255,255', 'right', '', NOW(), NOW()),

('Pi', 22, 'GPIO.6/25', 2, 11, '226,255,200', 'left', '', NOW(), NOW()),

('Pi', 23, 'SCLK/11', 1, 12, '200,255,255', 'right', '', NOW(), NOW()),

('Pi', 24, 'CE0/8', 2, 12, '200,255,255', 'left', '', NOW(), NOW()),

('Pi', 25, 'GND/0v', 1, 13, '126,126,126', 'right', '', NOW(), NOW()),

('Pi', 26, 'CE1/7', 2, 13, '200,255,255', 'left', '', NOW(), NOW()),

('Pi', 27, 'SDA.0/0', 1, 14, '255,255,200', 'right', '', NOW(), NOW()),

('Pi', 28, 'SCL.0/1', 2, 14, '255,255,200', 'left', '', NOW(), NOW()),

('Pi', 29, 'GPIO.21/5', 1, 15, '226,255,200', 'right', '', NOW(), NOW()),

('Pi', 30, 'GND/0v', 2, 15, '126,126,126', 'left', '', NOW(), NOW()),

('Pi', 31, 'GPIO.22/6', 1, 16, '226,255,200', 'right', '', NOW(), NOW()),

('Pi', 32, 'GPIO.26/12', 2, 16, '226,255,200', 'left', '', NOW(), NOW()),

('Pi', 33, 'GPIO.23/13', 1, 17, '226,255,200', 'right', '', NOW(), NOW()),

('Pi', 34, 'GND/0v', 2, 17, '126,126,126', 'left', '', NOW(), NOW()),

('Pi', 35, 'GPIO.24/19', 1, 18, '226,255,200', 'right', '', NOW(), NOW()),

('Pi', 36, 'GPIO.27/16', 2, 18, '226,255,200', 'left', '', NOW(), NOW()),

('Pi', 37, 'GPIO.25/26', 1, 19, '226,255,200', 'right', '', NOW(), NOW()),

('Pi', 38, 'GPIO.28/20', 2, 19, '226,255,200', 'left', '', NOW(), NOW()),

('Pi', 39, 'GND/0v', 1, 20, '126,126,126', 'right', '', NOW(), NOW()),

('Pi', 40, 'GPIO.29/21', 2, 20, '226,255,200', 'left', '', NOW(), NOW()),

('Alamode', 0, 'RxD', 2, 17, '', 'left', '', NOW(), NOW()),

('Alamode', 1, 'TxD', 2, 16, '', 'left', '', NOW(), NOW()),

('Alamode', 2, '1pps', 2, 15, '', 'left', '', NOW(), NOW()),

('Alamode', 3, 'SQW', 2, 14, '', 'left', '', NOW(), NOW()),

('Alamode', 4, 'GPS_Rx', 2, 13, '', 'left', '', NOW(), NOW()),

('Alamode', 5, 'Pin5', 2, 12, '', 'left', '', NOW(), NOW()),

('Alamode', 6, 'GTP_Tx', 2, 11, '', 'left', '', NOW(), NOW()),

('Alamode', 7, 'Pin7', 2, 10, '', 'left', '', NOW(), NOW()),

('Alamode', 8, 'Pin8', 2, 9, '', 'left', '', NOW(), NOW()),

('Alamode', 9, 'Pin9', 2, 8, '', 'left', '', NOW(), NOW()),

('Alamode', 10, 'SS', 2, 7, '', 'left', '', NOW(), NOW()),

('Alamode', 11, 'MOSI', 2, 6, '', 'left', '', NOW(), NOW()),

('Alamode', 12, 'MISO', 2, 5, '', 'left', '', NOW(), NOW()),

('Alamode', 13, 'SCK/LED', 2, 4, '', 'left', 'Triggering LED will interfere with SPI', NOW(),NOW()),

('Alamode', 14, 'GND/0v', 2, 3, '126,126,126', 'left', '', NOW(), NOW()),

('Alamode', 15, 'AREF', 2, 2, '', 'left', '', NOW(), NOW()),

('Alamode', 16, 'AD4/SDA', 2, 1, '', 'left', '', NOW(), NOW()),

('Alamode', 17, 'AD5/SCL', 2, 0, '', 'left', '', NOW(), NOW()),

('Alamode', 18, 'AD5/SCL', 1, 12, '', 'right', '', NOW(), NOW()),

('Alamode', 19, 'AD4/SDA', 1, 11, '', 'right', '', NOW(), NOW()),

('Alamode', 20, 'AD3/PC3', 1, 10, '', 'right', '', NOW(), NOW()),

('Alamode', 21, 'AD2/PC2', 1, 9, '', 'right', '', NOW(), NOW()),

('Alamode', 22, 'AD1/PC1', 1, 8, '', 'right', '', NOW(), NOW()),

('Alamode', 23, 'AD0/PC0', 1, 7, '', 'right', '', NOW(), NOW()),

('Alamode', 24, 'V in', 1, 6, '', 'right', '', NOW(), NOW()),

('Alamode', 25, 'GND2', 1, 5, '126,126,126', 'right', '', NOW(), NOW()),

('Alamode', 26, 'GND1', 1, 4, '126,126,126', 'right', '', NOW(), NOW()),

('Alamode', 27, 'PWR/5v', 1, 3, '255,200,200', 'right', '', NOW(), NOW()),

('Alamode', 28, 'PWR/3.3V', 1, 2, '255,200,126', 'right', '', NOW(), NOW()),

('Alamode', 29, 'RST', 1, 1, '', 'right', '', NOW(), NOW()),

('Alamode', 30, 'PWR/5v', 1, 0, '', 'right', '', NOW(), NOW()),

('Alamode', 31, '', 1, 13, '', '', '', NOW(), NOW()),

('Alamode', 32, '', 1, 14, '', '', '', NOW(), NOW()),

('Alamode', 33, '', 1, 15, '', '', '', NOW(), NOW()),

('Alamode', 34, '', 1, 16, '', '', '', NOW(), NOW()),

('Alamode', 35, '', 1, 17, '', '', '', NOW(), NOW());

UPDATE ioPins SET displayPin=pin;






CREATE TABLE IF NOT EXISTS `tempProbes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`type` int(11) NOT NULL,
	`pin` int(11),
	`notes` text NULL,
	`manualAdj` decimal(4,2) NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	`statePin` int(11) DEFAULT 0,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tempLog` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
    `probe` text NULL,
	`temp` decimal(6,2) NOT NULL,
	`tempUnit` varchar(1) DEFAULT  'C',
	`humidity` decimal(6,2) NULL,
	`statePinState` int(11) NULL DEFAULT 0,
	`takenDate` TIMESTAMP NOT NULL,	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `log` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`process` tinytext NOT NULL,
	`category` tinytext NOT NULL,
	`text` text NOT NULL,
        `occurances` decimal(10,0) NOT NULL DEFAULT 1,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;


--
-- Create View `vwGetActiveTaps`
--

CREATE OR REPLACE VIEW vwGetActiveTaps
AS

SELECT
	t.id,

	b.id as 'beerId',
	bb.id as 'beerBatchId',
	b.name,
	b.untID,
	bs.name as 'style',
	br.name as 'breweryName',
	br.imageUrl as 'breweryImageUrl',
	COALESCE(bb.rating, b.rating) AS rating,
	COALESCE(bb.notes, b.notes) AS notes,
	COALESCE(bb.abv, b.abv) AS abv,
	COALESCE(bb.og, b.og) as og,
	COALESCE(CASE WHEN bb.og IS NULL THEN NULL ELSE bb.ogUnit END, b.ogUnit) as ogUnit,
	COALESCE(bb.fg, b.fg) as fg,
	COALESCE(CASE WHEN bb.fg IS NULL THEN NULL ELSE bb.fgUnit END, b.fgUnit) as fgUnit,
	COALESCE(bb.srm, b.srm) as srm,
	COALESCE(bb.ibu, b.ibu) as ibu,
	IFNULL(k.startAmount, 0)        as startAmount,
	IFNULL(k.startAmountUnit, '')   as startAmountUnit,
    CASE WHEN k.hasContinuousLid = 0 THEN IFNULL(k.currentAmount, 0) ELSE IFNULL(k.startAmount, 0)  END      as remainAmount,
    IFNULL(k.currentAmountUnit, '') as remainAmountUnit,
	t.tapNumber,
	t.tapRgba,
    tc.flowPin as pinId,
	s.rgb as srmRgb,
	tc.valveOn,
	tc.valvePinState,
    tc.plaatoAuthToken,
    ct.displayName as containerType,
    CASE WHEN lower(k.make) LIKE 'corn%' THEN 'corny' WHEN lower(k.make) LIKE '%firestone%' THEN 'corny' ELSE 'keg' END as kegType,
    GROUP_CONCAT(CONCAT(a.id,'~',a.name,'~',ba.amount) ORDER BY a.rank) as accolades
FROM taps t
	LEFT JOIN tapconfig tc ON t.id = tc.tapId
	LEFT JOIN kegs k ON k.id = t.kegId
	LEFT JOIN beers b ON b.id = k.beerId
	LEFT JOIN beerBatches bb ON bb.id = k.beerBatchId
	LEFT JOIN beerStyles bs ON bs.id = b.beerStyleId
	LEFT JOIN breweries br ON br.id = b.breweryId
	LEFT JOIN srmRgb s ON s.srm = b.srm
	LEFT JOIN beerAccolades ba ON b.id = ba.beerId
    LEFT JOIN accolades a on ba.accoladeId = a.id
    LEFT JOIN containerTypes ct on ct.id = b.containerId
WHERE t.active = true
GROUP BY t.id
ORDER BY t.id;

-- --------------------------------------------------------

--
-- Create View `vwGetFilledBottles`
--

CREATE OR REPLACE VIEW vwGetFilledBottles
AS

SELECT
	t.id,

	b.id as 'beerId',
	bb.id as 'beerBatchId',
	b.name,
	b.untID,
	bs.name as 'style',
	br.name as 'breweryName',
	br.imageUrl as 'breweryImageUrl',
	COALESCE(bb.rating, b.rating) AS rating,
	COALESCE(bb.notes, b.notes) AS notes,
	COALESCE(bb.abv, b.abv) AS abv,
	COALESCE(bb.og, b.og) as og,
	COALESCE(CASE WHEN bb.og IS NULL THEN NULL ELSE bb.ogUnit END, b.ogUnit) as ogUnit,
	COALESCE(bb.fg, b.fg) as fg,
	COALESCE(CASE WHEN bb.fg IS NULL THEN NULL ELSE bb.fgUnit END, b.fgUnit) as fgUnit,
	COALESCE(bb.srm, b.srm) as srm,
	COALESCE(bb.ibu, b.ibu) as ibu,
	bt.volume,
	bt.volumeUnit,
	t.startAmount,
	IFNULL(null, 0) as amountPoured,
	t.currentAmount as remainAmount,
	t.capNumber,
	t.capRgba,
    NULL as pinId,
	s.rgb as srmRgb,
	1 as valveOn,
	1 as valvePinState,
    NULL,
    'bottle' as containerType,
    NULL as kegType,
    GROUP_CONCAT(CONCAT(a.id,'~',a.name,'~',ba.amount) ORDER BY a.rank) as accolades
FROM bottles t
	LEFT JOIN beers b ON b.id = t.beerId
	LEFT JOIN beerBatches bb ON b.id = t.beerBatchId
	LEFT JOIN bottleTypes bt ON bt.id = t.bottleTypeId
	LEFT JOIN beerStyles bs ON bs.id = b.beerStyleId
	LEFT JOIN breweries br ON br.id = b.breweryId
	LEFT JOIN srmRgb s ON s.srm = b.srm
	LEFT JOIN beerAccolades ba ON b.id = ba.beerId
    LEFT JOIN accolades a on ba.accoladeId = a.id
WHERE t.active = true
GROUP BY t.id
ORDER BY t.id;

CREATE OR REPLACE VIEW `vwTaps` 
AS
 SELECT 
	t.*, 
	tc.*, 
	k.beerId, 
	k.beerBatchId 
 FROM taps t 
 LEFT JOIN tapconfig tc ON (t.id = tc.tapId) 
 LEFT JOIN kegs k ON (t.kegId = k.id);
 
CREATE OR REPLACE VIEW `vwKegs` 
AS
 SELECT 
    k.id,
    k.label,
    k.kegTypeId,
    k.make,
    k.model,
    k.serial,
    k.stampedOwner,
    k.stampedLoc,
    k.notes,
    k.kegStatusCode,
    k.weight,
    k.weightUnit,
    k.beerId,
    k.beerBatchId,
    k.onTapId,
    t.tapNumber,
    k.active,
    CASE WHEN (k.emptyWeight IS NULL OR k.emptyWeight = '' OR k.emptyWeight = 0) AND kt.emptyWeight IS NOT NULL THEN kt.emptyWeight ELSE k.emptyWeight END AS emptyWeight,
    CASE WHEN (k.emptyWeight IS NULL OR k.emptyWeight = '' OR k.emptyWeight = 0) AND kt.emptyWeight IS NOT NULL THEN kt.emptyWeightUnit ELSE k.emptyWeightUnit END AS emptyWeightUnit,
    CASE WHEN (k.maxVolume IS NULL OR k.maxVolume = '' OR k.maxVolume = 0) AND kt.maxAmount IS NOT NULL THEN kt.maxAmount ELSE k.maxVolume END AS maxVolume,
    CASE WHEN (k.maxVolume IS NULL OR k.maxVolume = '' OR k.maxVolume = 0) AND kt.maxAmount IS NOT NULL THEN kt.maxAmountUnit ELSE k.maxVolumeUnit END AS maxVolumeUnit,
    k.startAmount,
    k.startAmountUnit,
    k.currentAmount,
    k.currentAmountUnit,
    k.fermentationPSI,
    k.fermentationPSIUnit,
    k.keggingTemp,
    k.keggingTempUnit,
    k.hasContinuousLid,
    k.modifiedDate,
    k.createdDate
 FROM kegs k LEFT JOIN kegTypes kt 
        ON k.kegTypeId = kt.id
      LEFT JOIN taps t 
        ON k.onTapId = t.id;

CREATE OR REPLACE VIEW `vwFermentables` 
AS
 SELECT 
    f.*,
    srm.rgb
 FROM fermentables f LEFT JOIN srmRgb srm
        ON f.srm = srm.srm;
        
CREATE OR REPLACE VIEW vwTapEvents
AS
SELECT
  te.id,
  te.type as type,
  CASE te.type 
    WHEN 1 THEN 'Tapped'
    WHEN 2 THEN 'Removed'
    ELSE 'N/A'
  END as 'typeDesc',
  te.tapId,
  te.kegId,
  te.beerId,
  te.beerBatchId,
  te.amount,
  te.amountUnit,
  te.beerBatchAmount,
  te.beerBatchAmountUnit,
  CASE WHEN te.type = 2 THEN (SELECT amount FROM tapEvents WHERE id = (SELECT MAX(id) FROM tapEvents WHERE id < te.id AND type = 1 AND tapId = te.tapId AND kegId = te.kegId AND beerId = te.beerId)) ELSE NULL END AS newAmount,
  CASE WHEN te.type = 2 THEN (SELECT amountUnit FROM tapEvents WHERE id = (SELECT MAX(id) FROM tapEvents WHERE id < te.id AND type = 1 AND tapId = te.tapId AND kegId = te.kegId AND beerId = te.beerId)) ELSE NULL END AS newAmountUnit,
  te.userId,
	t.tapNumber as 'tapNumber',
  t.tapRgba   as 'tapRgba',
  k.label as 'kegName',
	b.name  as 'beerName',
	bs.name as 'beerStyle',
	CASE WHEN u.username IS NULL THEN 'System' ELSE u.userName END  as 'userName',
  te.createdDate
FROM tapEvents te
  LEFT JOIN taps t ON t.id = te.tapId
	LEFT JOIN kegs k ON k.id = te.kegId
	LEFT JOIN beers b ON b.id = te.beerId
	LEFT JOIN beerStyles bs ON bs.id = b.beerStyleId
	LEFT JOIN users u ON u.id = te.userId
WHERE t.active = true
ORDER BY te.id;
  
CREATE OR REPLACE VIEW vwTempLog
AS
SELECT
    tl.id,
	IFNULL(tp.notes, tl.probe) AS probe,
    temp,
    tempUnit,
    humidity,
    statePinState,
    takenDate
FROM tempLog tl 
LEFT JOIN tempProbes tp ON tl.probe = tp.name;
-- --------------------------------------------------------


CREATE OR REPLACE VIEW `vwAccolades` 
AS
 SELECT 
    a.*,
    srm.rgb
 FROM accolades a LEFT JOIN srmRgb srm
        ON a.srm = srm.srm;
        
CREATE TABLE IF NOT EXISTS `iSpindel_Data` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`createdDate` TIMESTAMP NOT NULL,
	`name` varchar(64) COLLATE ascii_bin NOT NULL,
	`iSpindelId` INT UNSIGNED NOT NULL,
	`angle` double NOT NULL,
	`temperature` double NOT NULL,
	`temperatureUnit` tinytext DEFAULT NULL,
	`battery` double NOT NULL,
	`resetFlag` boolean,
	`gravity` double NOT NULL DEFAULT 0,
	`userToken` varchar(64) COLLATE ascii_bin,
	`interval` int,
	`RSSI` int,
	`beerId` int(11) NULL,
	`beerBatchId` int(11) NULL,
	`beerName` text NULL,
	`gravityUnit` tinytext NULL,
	PRIMARY KEY (`id`)
	) 
ENGINE=InnoDB DEFAULT CHARSET=ascii 
COLLATE=ascii_bin COMMENT='iSpindel Data';

CREATE TABLE IF NOT EXISTS `iSpindel_Device` (
	`iSpindelId` int NOT NULL,
	`name` varchar(64) NULL,
	`active` int NOT NULL DEFAULT 1,
	`beerId` int(11) NULL,
	`beerBatchId` int(11) NULL,
	`gravityUnit` tinytext NULL,
    `const1` double NULL,
    `const2` double NULL,
    `const3` double NULL,
    `interval` int NULL,
    `token` varchar(64) NULL,
    `polynomial` varchar(64) NULL,
    `sent` boolean NOT NULL DEFAULT FALSE,
	`remoteConfigEnabled` int NOT NULL DEFAULT 0,
	`sqlEnabled` int NOT NULL DEFAULT 1,
	`csvEnabled` int NOT NULL DEFAULT 0,
	`csvOutpath` varchar(256) NULL,
	`csvDelimiter` varchar(1) NOT NULL DEFAULT ',',
	`csvNewLine` int NOT NULL DEFAULT 0,
	`csvIncludeDateTime` int NOT NULL DEFAULT 1,
    `unidotsEnabled` int NOT NULL DEFAULT 0,
    `unidotsUseiSpindelToken` int NOT NULL DEFAULT 0,
    `unidotsToken` varchar(256) NULL,
	`forwardEnabled` int NOT NULL DEFAULT 0,
    `forwardAddress` varchar(256) NULL,
    `forwardPort` varchar(256) NULL,
	`fermentTrackEnabled` int NOT NULL DEFAULT 0,
    `fermentTrackAddress` varchar(256) NULL,
    `fermentTrackPort` varchar(256) NULL,
    `fermentTrackUseiSpindelToken` int NOT NULL DEFAULT 0,
    `fermentTrackToken` varchar(256) NULL,
	`brewPiLessEnabled` int NOT NULL DEFAULT 0,
    `brewPiLessAddress` varchar(256) NULL,
	`craftBeerPiEnabled` int NOT NULL DEFAULT 0,
    `craftBeerPiAddress` varchar(256) NULL,
	`craftBeerPiSendAngle` int NOT NULL DEFAULT 0,
	`brewSpyEnabled` int NOT NULL DEFAULT 0,
    `brewSpyAddress` varchar(256) NULL,
    `brewSpyPort` varchar(256) NULL,
    `brewSpyUseiSpindelToken` int NOT NULL DEFAULT 0,
    `brewSpyToken` varchar(256) NULL,
	`brewFatherEnabled` int NOT NULL DEFAULT 0,
    `brewFatherAddress` varchar(256) NULL,
    `brewFatherPort` varchar(256) NULL,
    `brewFatherUseiSpindelToken` int NOT NULL DEFAULT 0,
    `brewFatherToken` varchar(256) NULL,
    `brewFatherSuffix` varchar(256) NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	PRIMARY KEY (`iSpindelId`),
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin COMMENT='iSpindel Devices Data';



CREATE TABLE IF NOT EXISTS `iSpindel_Connector` (
	`id` int NOT NULL AUTO_INCREMENT,
    `address` varchar(256) NULL,
    `port` varchar(256) NULL,
    `allowedConnections` int(11) NOT NULL DEFAULT 5,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin COMMENT='iSpindel Connectors Data';

CREATE TABLE IF NOT EXISTS `fermenterTypes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`displayName` text NOT NULL,
	`maxAmount` decimal(6,2) NOT NULL,
	`maxAmountUnit`  tinytext NULL,
	`emptyWeight` decimal(11, 4) NULL,
	`emptyWeightUnit` tinytext NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fermenterTypes`
--

INSERT INTO `fermenterTypes` ( displayName, maxAmount, maxAmountUnit, emptyWeight, emptyWeightUnit, createdDate, modifiedDate ) VALUES
( 'Conical (5 gal)', '5', 'gal', '8.1571', 'lb', NOW(), NOW() ),
( 'Conical (10 gal)', '10', 'gal', '16.3142', 'lb', NOW(), NOW() ),
( 'Conical (15 gal)', '15', 'gal', '16.3142', 'lb', NOW(), NOW() ),
( 'Conical (30 gal)', '30', 'gal', '16.3142', 'lb', NOW(), NOW() ),
( 'Carboy (5 gal)', '5', 'gal', '8.1571', 'lb', NOW(), NOW() ),
( 'Carboy (6 gal)', '6', 'gal', '8.1571', 'lb', NOW(), NOW() ),
( 'Barrel (30 gal)', '30', 'gal', '8.1571', 'lb', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Table structure for table `fermenterStatuses`
--

CREATE TABLE IF NOT EXISTS `fermenterStatuses` (
	`code` varchar(20) NOT NULL,
	`name` text NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`code`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegStatuses`
--

INSERT INTO `fermenterStatuses` ( code, name, createdDate, modifiedDate ) VALUES
( 'PRIMARY', 'Primary', NOW(), NOW() ),
( 'SECONDARY', 'Secondary', NOW(), NOW() ),
( 'DRY_HOPPING', 'Dry Hopping', NOW(), NOW() ),
( 'CONDITIONING', 'Conditioning', NOW(), NOW() ),
( 'BULK_AGING', 'Bulk Aging', NOW(), NOW() ),
( 'FLOODED', 'Flooded', NOW(), NOW() ),
( 'SANITIZED', 'Sanitized', NOW(), NOW() ),
( 'CLEAN', 'Clean', NOW(), NOW() ),
( 'NEEDS_CLEANING', 'Needs Cleaning', NOW(), NOW() ),
( 'NEEDS_PARTS', 'Needs Parts', NOW(), NOW() ),
( 'NEEDS_REPAIRS', 'Needs Repairs', NOW(), NOW() );


CREATE TABLE IF NOT EXISTS `fermenters` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`label` varchar(40) NOT NULL,
	`fermenterTypeId` int(11) NOT NULL,
	`make` text NULL,
	`model` text NULL,
	`serial` text NULL,
	`notes` text NULL,
	`fermenterStatusCode` varchar(20) NULL,
	`weight` decimal(11,4) NULL,
	`weightUnit` tinytext NULL,
	`emptyWeight` decimal(11,4) NULL,
	`emptyWeightUnit` tinytext NULL,
	`maxVolume` decimal(11,4) NULL,
	`maxVolumeUnit` tinytext NULL,
	`startAmount` decimal(10,5) NULL,
	`startAmountUnit` tinytext NULL,
	`currentAmount` decimal(10,5) NULL,
	`currentAmountUnit` tinytext NULL,
	`fermentationPSI` decimal(14,2) DEFAULT NULL,
	`fermentationPSIUnit` tinytext NULL,
	`beerId` int(11) NULL,
	`beerBatchId` int(11) NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	`startDate` TIMESTAMP NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`fermenterStatusCode`) REFERENCES fermenterStatuses(`Code`) ON DELETE CASCADE,
	FOREIGN KEY (`fermenterTypeId`) REFERENCES fermenterTypes(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `gasTankTypes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`displayName` text NOT NULL,
	`maxAmount` decimal(6,2) NOT NULL,
	`maxAmountUnit`  tinytext NULL,
	`emptyWeight` decimal(11, 4) NULL,
	`emptyWeightUnit` tinytext NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegTypes`
--

INSERT INTO `gasTankTypes` ( displayName, maxAmount, maxAmountUnit, emptyWeight, emptyWeightUnit, createdDate, modifiedDate ) VALUES
( 'CO2 (5 lb)', '5', 'lb', '8.1571', 'lb', NOW(), NOW() ),
( 'CO2 (10 lb)', '10', 'lb', '16.3142', 'lb', NOW(), NOW() ),
( 'CO2 (20 lb)', '20', 'lb', '16.3142', 'lb', NOW(), NOW() ),
( 'Nitro (5 lb)', '5', 'lb', '8.1571', 'lb', NOW(), NOW() ),
( 'Nitro (10 lb)', '10', 'lb', '16.3142', 'lb', NOW(), NOW() ),
( 'Nitro (20 lb)', '20', 'lb', '16.3142', 'lb', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Table structure for table `kegStatuses`
--

CREATE TABLE IF NOT EXISTS `gasTankStatuses` (
	`code` varchar(20) NOT NULL,
	`name` text NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`code`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegStatuses`
--

INSERT INTO `gasTankStatuses` ( code, name, createdDate, modifiedDate ) VALUES
( 'DISPENSING', 'Dispensing', NOW(), NOW() ),
( 'FULL', 'Full', NOW(), NOW() ),
( 'PARTIAL', 'Partial', NOW(), NOW() ),
( 'EMPTY', 'Empty', NOW(), NOW() ),
( 'NEEDS_CERTIFICATION', 'Needs Certification', NOW(), NOW() ),
( 'NEEDS_PARTS', 'Needs Parts', NOW(), NOW() ),
( 'NEEDS_REPAIRS', 'Needs Repairs', NOW(), NOW() );


CREATE TABLE IF NOT EXISTS `gasTanks` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`label` varchar(40) NOT NULL,
	`gasTankTypeId` int(11) NOT NULL,
	`make` text NULL,
	`model` text NULL,
	`serial` text NULL,
	`notes` text NULL,
	`gasTankStatusCode` varchar(20) NULL,
	`weight` decimal(11,4) NULL,
	`weightUnit` tinytext NULL,
	`maxWeight` decimal(11,4) NULL,
	`maxWeightUnit` tinytext NULL,
	`emptyWeight` decimal(11,4) NULL,
	`emptyWeightUnit` tinytext NULL,
	`maxVolume` decimal(11,4) NULL,
	`maxVolumeUnit` tinytext NULL,
	`startAmount` decimal(10,5) NULL,
	`startAmountUnit` tinytext NULL,
	`currentAmount` decimal(10,5) NULL,
	`currentAmountUnit` tinytext NULL,
        `loadCellCmdPin` int(11) DEFAULT NULL,
        `loadCellRspPin` int(11) DEFAULT NULL,
        `loadCellTareReq` int(11) DEFAULT NULL,
        `loadCellScaleRatio` float DEFAULT NULL,
        `loadCellTareOffset` float DEFAULT NULL,
        `loadCellUnit` tinytext DEFAULT NULL,
        `loadCellTareDate` TIMESTAMP NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`gasTankStatusCode`) REFERENCES gasTankStatuses(`Code`) ON DELETE CASCADE,
	FOREIGN KEY (`gasTankTypeId`) REFERENCES gasTankTypes(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;
 

CREATE OR REPLACE VIEW vwGasTanks 
AS
select 
	g.id AS id,
	g.label AS label,
	g.gasTankTypeId AS gasTankTypeId,
	g.make AS make,
	g.model AS model,
	g.serial AS serial,
	g.notes AS notes,
	g.gasTankStatusCode AS gasTankStatusCode,
	g.weight AS weight,
	g.weightUnit AS weightUnit,
	g.maxWeight AS maxWeight,
	g.maxWeightUnit AS maxWeightUnit,
	g.active AS active,
	(case when ((isnull(g.emptyWeight) or (g.emptyWeight = '') or (g.emptyWeight = 0)) and (gt.emptyWeight is not null)) then gt.emptyWeight else g.emptyWeight end) AS emptyWeight,
	(case when ((isnull(g.emptyWeight) or (g.emptyWeight = '') or (g.emptyWeight = 0)) and (gt.emptyWeight is not null)) then gt.emptyWeightUnit else g.emptyWeightUnit end) AS emptyWeightUnit,
	(case when ((isnull(g.maxVolume) or (g.maxVolume = '') or (g.maxVolume = 0)) and (gt.maxAmount is not null)) then gt.maxAmount else g.maxVolume end) AS maxVolume,
	(case when ((isnull(g.maxVolume) or (g.maxVolume = '') or (g.maxVolume = 0)) and (gt.maxAmount is not null)) then gt.maxAmountUnit else g.maxVolumeUnit end) AS maxVolumeUnit,
	g.startAmount AS startAmount,
	g.startAmountUnit AS startAmountUnit,
	g.currentAmount AS currentAmount,
	g.currentAmountUnit AS currentAmountUnit,
        g.loadCellCmdPin AS loadCellCmdPin,
        g.loadCellRspPin AS loadCellRspPin,
        g.loadCellTareReq AS loadCellTareReq,
        g.loadCellScaleRatio AS loadCellScaleRatio,
        g.loadCellTareOffset AS loadCellTareOffset,
        g.loadCellUnit AS loadCellUnit,
        g.loadCellTareDate AS loadCellTareDate,
	g.modifiedDate AS modifiedDate,
	g.createdDate AS createdDate 
from (gasTanks g 
		left join gasTankTypes gt on((g.GasTankTypeId = gt.id)));


CREATE OR REPLACE VIEW vwbeerBatches 
AS 
select 
	bb.id AS id,
	bb.beerId AS beerId,
	bb.batchNumber AS batchNumber,
	bb.name AS name,
	bb.notes AS notes,
	bb.startAmount AS startAmount,
	bb.startAmountUnit AS startAmountUnit,
	bb.currentAmount AS currentAmount,
	bb.currentAmountUnit AS currentAmountUnit,
	bb.fermentationTempMin AS fermentationTempMin,
	bb.fermentationTempMinUnit AS fermentationTempMinUnit,
	bb.fermentationTempSet AS fermentationTempSet,
	bb.fermentationTempSetUnit AS fermentationTempSetUnit,
	bb.fermentationTempMax AS fermentationTempMax,
	bb.fermentationTempMaxUnit AS fermentationTempMaxUnit,
	bb.abv AS abv,
	bb.og AS og,
	bb.ogUnit AS ogUnit,
	bb.fg AS fg,
	bb.fgUnit AS fgUnit,
	bb.srm AS srm,
	bb.ibu AS ibu,
	bb.rating AS rating,
	bb.createdDate AS createdDate,
	bb.modifiedDate AS modifiedDate,
	b.name AS beerName 
from (beerBatches bb left join beers b on((b.id = bb.beerId)));


CREATE OR REPLACE VIEW vwiSpindel_Device 
AS 
select 
	idev.iSpindelId AS iSpindelId,
	idev.active AS active,
	idev.beerId AS beerId,
	idev.const1 AS const1,
	idev.const2 AS const2,
	idev.const3 AS const3,
	idev.interval AS `interval`,
	idev.token AS token,
	idev.polynomial AS polynomial,
	idev.sent AS sent,
	idev.remoteConfigEnabled AS remoteConfigEnabled,
	idev.sqlEnabled AS sqlEnabled,
	idev.csvEnabled AS csvEnabled,
	idev.csvOutpath AS csvOutpath,
	idev.csvDelimiter AS csvDelimiter,
	idev.csvNewLine AS csvNewLine,
	idev.csvIncludeDateTime AS csvIncludeDateTime,
	idev.unidotsEnabled AS unidotsEnabled,
	idev.unidotsUseiSpindelToken AS unidotsUseiSpindelToken,
	idev.unidotsToken AS unidotsToken,
	idev.forwardEnabled AS forwardEnabled,
	idev.forwardAddress AS forwardAddress,
	idev.forwardPort AS forwardPort,
	idev.fermentTrackEnabled AS fermentTrackEnabled,
	idev.fermentTrackAddress AS fermentTrackAddress,
	idev.fermentTrackPort AS fermentTrackPort,
	idev.fermentTrackUseiSpindelToken AS fermentTrackUseiSpindelToken,
	idev.fermentTrackToken AS fermentTrackToken,
	idev.brewPiLessEnabled AS brewPiLessEnabled,
	idev.brewPiLessAddress AS brewPiLessAddress,
	idev.craftBeerPiEnabled AS craftBeerPiEnabled,
	idev.craftBeerPiAddress AS craftBeerPiAddress,
	idev.craftBeerPiSendAngle AS craftBeerPiSendAngle,
	idev.brewSpyEnabled AS brewSpyEnabled,
	idev.brewSpyAddress AS brewSpyAddress,
	idev.brewSpyPort AS brewSpyPort,
	idev.brewSpyUseiSpindelToken AS brewSpyUseiSpindelToken,
	idev.brewSpyToken AS brewSpyToken,
	idev.brewFatherEnabled AS brewFatherEnabled,
	idev.brewFatherAddress AS brewFatherAddress,
	idev.brewFatherPort AS brewFatherPort,
	idev.brewFatherUseiSpindelToken AS brewFatherUseiSpindelToken,
	idev.brewFatherToken AS brewFatherToken,
	idev.brewFatherSuffix AS brewFatherSuffix,
	idev.createdDate AS createdDate,
	idev.modifiedDate AS modifiedDate,
	idev.name AS name,
	idev.beerBatchId AS beerBatchId,
	idev.gravityUnit AS gravityUnit,
	max(idat.temperature) AS currentTemperature,
	max(idat.temperatureUnit) AS currentTemperatureUnit,
	min(idat.gravity) AS currentGravity,
	min(idat.gravityUnit) AS currentGravityUnit
from (iSpindel_Device idev 
		left join iSpindel_Data idat on((idev.iSpindelId = idat.iSpindelId))) 
		where (isnull(idat.iSpindelId) 
		or (idat.createdDate = (select max(idat2.createdDate) from iSpindel_Data idat2 where (idat2.iSpindelId = idat.iSpindelId)))) group by idev.iSpindelId;

                
CREATE OR REPLACE VIEW vwFermenters 
AS 
select  
    f.id AS id,
    f.label AS label,
    f.fermenterTypeId AS fermenterTypeId,
    f.make AS make,
    f.model AS model,
    f.serial AS serial,
    f.notes AS notes,
    f.fermenterStatusCode AS fermenterStatusCode,
    f.weight AS weight,
    f.weightUnit AS weightUnit,
    f.beerId AS beerId,
    f.beerBatchId AS beerBatchId,
    f.active AS active,
    (case when ((isnull(f.emptyWeight) or (f.emptyWeight = '') or (f.emptyWeight = 0)) and (ft.emptyWeight is not null)) then ft.emptyWeight else f.emptyWeight end) AS emptyWeight,
    (case when ((isnull(f.emptyWeight) or (f.emptyWeight = '') or (f.emptyWeight = 0)) and (ft.emptyWeight is not null)) then ft.emptyWeightUnit else f.emptyWeightUnit end) AS emptyWeightUnit,
    (case when ((isnull(f.maxVolume) or (f.maxVolume = '') or (f.maxVolume = 0)) and (ft.maxAmount is not null)) then ft.maxAmount else f.maxVolume end) AS maxVolume,
    (case when ((isnull(f.maxVolume) or (f.maxVolume = '') or (f.maxVolume = 0)) and (ft.maxAmount is not null)) then ft.maxAmountUnit else f.maxVolumeUnit end) AS maxVolumeUnit,
    f.startAmount AS startAmount,
    f.startAmountUnit AS startAmountUnit,
    f.currentAmount AS currentAmount,
    f.currentAmountUnit AS currentAmountUnit,
    f.fermentationPSI AS fermentationPSI,
    f.fermentationPSIUnit AS fermentationPSIUnit,
    b.name as beerName,
    COALESCE(bb.name, bb.batchNumber) AS beerBatchName,
    s.rgb as beerRgb,
    f.startDate AS startDate,
    f.modifiedDate AS modifiedDate,
    f.createdDate AS createdDate 
    from (fermenters f 
            left join fermenterTypes ft 
            on((f.fermenterTypeId = ft.id)))
	LEFT JOIN beers b ON b.id = f.beerId
	LEFT JOIN beerBatches bb ON bb.id = f.beerBatchId
	LEFT JOIN srmRgb s ON (bb.srm IS NULL AND s.srm = b.srm) OR (bb.srm IS NOT NULL AND s.srm = bb.srm);
       
        
CREATE OR REPLACE VIEW `vwPours`
AS
SELECT 
	p.*, 
	t.tapNumber, 
	t.tapRgba,
	b.name AS beerName, 
	b.untID AS beerUntID, 
        bs.name as beerStyle,
	br.imageUrl AS breweryImageUrl, 
	COALESCE(u.userName, '') as userName
FROM pours p 
	LEFT JOIN taps t ON (p.tapId = t.id) 
	LEFT JOIN beers b ON (p.beerId = b.id) 
	LEFT JOIN breweries br ON (b.breweryId = br.id) 
	LEFT JOIN users u ON (p.userId = u.id)
	LEFT JOIN beerStyles bs ON bs.id = b.beerStyleId;
  
CREATE OR REPLACE VIEW vwIoHardwarePins
AS
  (SELECT CASE WHEN tc.flowPin  < 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('Tap ', t.tapNumber, ' Flow Meter') AS Hardware, ABS(tc.flowPin) AS pin FROM tapconfig tc LEFT JOIN taps t ON (tc.tapId = t.id))
  UNION
  (SELECT CASE WHEN tc.valvePin < 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('Tap ', t.tapNumber, ' Valve')      AS Hardware, ABS(tc.valvePin) AS pin FROM tapconfig tc LEFT JOIN taps t ON (tc.tapId = t.id))
  UNION
  (SELECT CASE WHEN tc.loadCellCmdPin < 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('Tap ', t.tapNumber, ' Load Cell Command')      AS Hardware, ABS(tc.loadCellCmdPin) AS pin FROM tapconfig tc LEFT JOIN taps t ON (tc.tapId = t.id))
  UNION
  (SELECT CASE WHEN tc.loadCellRspPin < 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('Tap ', t.tapNumber, ' Load Cell Response')      AS Hardware, ABS(tc.loadCellRspPin) AS pin FROM tapconfig tc LEFT JOIN taps t ON (tc.tapId = t.id))
  UNION
  (SELECT CASE WHEN pin        <> 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('RFID ', name, ' Trigger')          AS Hardware, ABS(pin) AS pin FROM rfidReaders)
  UNION
  (SELECT CASE WHEN pin        <> 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('PIR ', name, ' Trigger')           AS Hardware, ABS(pin) AS pin FROM motionDetectors)
  UNION
  (SELECT CASE WHEN pin        <> 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('PIR ', name, ' LED')               AS Hardware, ABS(ledPin) AS pin FROM motionDetectors)
  UNION
  (SELECT CASE WHEN pin        <> 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('Temp Probe ', name, ' State')               AS Hardware, ABS(statePin) AS pin FROM tempProbes)
  UNION
  (SELECT CASE WHEN configValue<> 0 THEN 'Pi' ELSE '' END AS shield, displayName                                AS Hardware, ABS(configValue) AS pin FROM config WHERE configName IN ('valvesPowerPin', 'useFanPin'))
  UNION
  (SELECT CASE WHEN gt.loadCellCmdPin < 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('Gas Tank ', COALESCE(gt.label, gt.id), ' Load Cell Command')      AS Hardware, ABS(gt.loadCellCmdPin) AS pin FROM gasTanks gt)
  UNION
  (SELECT CASE WHEN gt.loadCellRspPin < 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('Gas Tank ', COALESCE(gt.label, gt.id), ' Load Cell Response')      AS Hardware, ABS(gt.loadCellRspPin) AS pin FROM gasTanks gt);
  
CREATE OR REPLACE VIEW vwIoPins
AS
SELECT
	io.shield,
  io.pin,
  io.displayPin,
	io.name,
  io.col,
  io.row,
  io.rgb,
	io.notes,
  io.pinSide,
  GROUP_CONCAT(hard.Hardware ORDER BY hardware, ',') AS hardware
FROM ioPins io
LEFT JOIN vwIoHardwarePins hard
ON ((CONVERT(io.shield USING utf8) = hard.shield OR (LOWER(io.shield) != 'pi' AND hard.shield = '')) and io.pin = hard.pin)
WHERE (io.shield = 'Pi' OR '1' = (SELECT DISTINCT '1' FROM vwIoHardwarePins WHERE shield = ''))
GROUP BY shield, pin;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
