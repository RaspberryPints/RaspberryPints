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
USE `raspberrypints`;

-- --------------------------------------------------------

--
-- Dumping data for table `beers`
--

INSERT INTO `beers` (`name`, `beerStyleId`, `ogEst`, `fgEst`, `srmEst`, `ibuEst`, `notes`, `createdDate`, `modifiedDate`) VALUES
('Darth Vader', '1', '1.066', '1.016', '38.0', '66.0', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', NOW(), NOW() ),
('Strong Scotch', '10', '1.074', '1.018', '17.8', '27.0', 'Slightly sweet. Hints of malt and toffee. Finishes with roasted nuts and coffee. Complex and roasty.', NOW(), NOW() ),
('Cream of Three Crops', '20', '1.040', '1.009', '2.9', '14.3', 'Neutral, muted start. Highly carbonated with a soapy head. Unremarkably mild finish of noble hops. Dry and crisp with no distinguishable graininess.', NOW(), NOW() ),
('Darth Vader', '30', '1.066', '1.016', '38.0', '66.0', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', NOW(), NOW() ),
('Haus Pale Ale', '40', '1.051', '1.011', '5.0', '39.0', 'Pale straw-gold color with two fingers of fluffy white head. Bread dough and cracker aromas up front, followed immediately by pine and grapefruit. Clean, crisp and dangerously sessionable.', NOW(), NOW() ),
('Two Hearted', '50', '1.055', '1.014', '5.6', '52.6', 'American malts and enormous hop additions give this beer a crisp finish and an incredibly floral aroma.', NOW(), NOW() ),
('Reaper''s Mild', '60', '1.035', '1.012', '19.1', '20.4', 'A full flavored session beer that is both inexpensive to brew and quick to go from grain to glass. Ready to drink in a couple weeks, if you push it.', NOW(), NOW() ),
('Skeeter Pee', '70', '1.070', '1.009', '0', '0', 'The original, easy to drink, naturally fermented lemon drink. Bitter, sweet, and a kick in the teeth. This hot-weather thirst quencher puts commercialized lemon-flavored malt beverages to shame.', NOW(), NOW() ),
('Black Peach', '80', '1.000', '1.000', '0', '0', 'Black tea infused with the unmistakable summertime flavor of juicy, orchard-fresh peaches and just the right amount of natural milled cane sugar.', NOW(), NOW() ),
('Aloha Morning', '90', '1.000', '1.000', '0', '0', 'Children''s strawberry and citrus punch, thinned to suit an adult pallet using only the highest quality dihydrogen monoxide available.', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Dumping data for table `kegTypes`
--

INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES
( '1', '1', 'Cornelius', 'Super Champion', '16530387', 'Johnstown Production Center', '(Unknown)', 'One hanndle cracked', 'SERVING', NOW(), NOW() ),
( '2', '1', 'Spartanburg', 'Challenger VI', '81175979', 'Joyce Bev', 'Washington D.C.', 'Green handles', 'SERVING', NOW(), NOW() ),
( '3', '1', 'Cornelius', 'Super Champion', '75162875', 'Pepi Cola Btlg Co', 'Oskaloosa, IA', 'None', 'SERVING', NOW(), NOW() ),
( '4', '1', 'Cornelius', 'Super Champion', '77320513', 'Binghamton Btlg Co', '(Unknown)', 'None', 'DRY_HOPPING', NOW(), NOW() ),
( '5', '1', 'Cornelius', 'Super Champion', '80224203', 'Pepsi Btlg Co', 'Southern CA', 'Green handles', 'SERVING', NOW(), NOW() ),
( '6', '1', 'Spartanburg', 'Challenger VI', '290880483', 'Pepsi Cola Btlg Co', 'San Diego', 'None', 'SERVING', NOW(), NOW() ),
( '7', '1', 'Cornelius', 'Super Champion', '83129068', 'Pepsi Cola Btlg Co', '(Unknown)', 'None', 'SERVING', NOW(), NOW() ),
( '8', '1', 'Cornelius', 'Super Champion', '78143233', 'Pepsi Cola Btlg Co', 'Parkersburg WVA', 'None', 'SERVING', NOW(), NOW() ),
( '9', '1', 'Spantanburg', 'Challenger VI', '112620585', 'Pepsi Cola Btlg Co', 'Aleghany, NY', 'Blue handles', 'SERVING', NOW(), NOW() ),
( '10', '1', 'Cornelius', 'Super Champion', '82217553', 'Pepsi Cola Seven Up', 'Mpls St Paul', 'None', 'SERVING', NOW(), NOW() ),
( '11', '1', 'Cornelius', 'Super Champion', '77143229', 'So Conn Seven Up', 'S Norwalk Conn', 'Green handles', 'SERVING', NOW(), NOW() ),
( '12', '1', 'Cornelius', 'Super Champion', '86018983', 'Seltzer Rydholm', 'Aub Port Aug', 'None', 'SERVING', NOW(), NOW() ),
( '13', '1', 'Cornelius', 'Super Champion', '84405189', 'Pepsi Cola Btlg Co', 'Williamsport, PA', 'None', 'SERVING', NOW(), NOW() ),
( '14', '1', 'Cornelius', 'Super Champion', '80273216', 'Pepsi Cola Btlg Co', 'Waterloo, IA', 'None', 'SERVING', NOW(), NOW() ),
( '15', '1', 'Cornelius', 'Super Champion', '78225083', 'Pepsi Cola Btlg Co', 'San Diego', 'None', 'SERVING', NOW(), NOW() ),
( '16', '1', 'Firestone', 'Challenger VI', '103760380', 'Pepsi Cola Btlg Co', 'San Diego', 'None', 'NEEDS_CLEANING', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Put all beers into the `taps` table
--

INSERT INTO taps(`beerId`, `kegId`, `tapNumber`, `active`, `ogAct`, `fgAct`, `srmAct`, `ibuAct`, `startAmount`, `currentAmount`, `createdDate`, `modifiedDate`)
SELECT b.id, keg.id as kegId, b.id as tapNumber, 1 as active, b.ogEst as ogAct, b.fgEst as fgAct, b.srmEst as srmAct, b.ibuEst as ibuAct, keg.startAmount as startAmount, keg.startAmount as currentAmount, NOW() as createdDate, NOW() as modifiedDate
FROM `beers` as b, (SELECT k.*, kt.maxAmount as startAmount FROM kegs k LEFT JOIN kegTypes kt ON kt.id = k.kegTypeId ORDER BY Id LIMIT 1) as keg;

-- --------------------------------------------------------

--
-- Add number of taps to `config`
--

UPDATE `config` SET configValue='10' WHERE configname='numberOfTaps';


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
