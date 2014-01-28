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

INSERT INTO `beers` (`name`, `style`, `notes`, `ogEst`, `fgEst`, `srmEst`, `ibuEst`, `createdDate`, `modifiedDate`) VALUES
('Darth Vader', 'Cascadian Dark Ale', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', '1.066', '1.016', 38.0, 66.0, NOW(), NOW()),
('Strong Scotch', 'Scotch Ale', 'Slightly sweet. Hints of malt and toffee. Finishes with roasted nuts and coffee. Complex and roasty.', '1.074', '1.018', 17.8, 27.0, NOW(), NOW()),
('Cream of Three Crops', 'Cream Ale', 'Neutral, muted start. Highly carbonated with a soapy head. Unremarkably mild finish of noble hops. Dry and crisp with no distinguishable graininess.', '1.040', '1.009', 2.9, 14.3, NOW(), NOW()),
('Darth Vader', 'Cascadian Dark Ale', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', '1.066', '1.016', 38.0, 66.0, NOW(), NOW()),
('Haus Pale Ale', 'American Pale Ale', 'Pale straw-gold color with two fingers of fluffy white head. Bread dough and cracker aromas up front, followed immediately by pine and grapefruit. Clean, crisp and dangerously sessionable.', '1.051', '1.011', 5.0, 39.0, NOW(), NOW()),
('Two Hearted', 'American IPA', 'American malts and enormous hop additions give this beer a crisp finish and an incredibly floral aroma.', '1.055', '1.014', 5.6, 52.6, NOW(), NOW()),
('Reaper''s Mild', 'English Mild', 'A full flavored session beer that is both inexpensive to brew and quick to go from grain to glass. Ready to drink in a couple weeks, if you push it.', '1.035', '1.012', 19.1, 20.4, NOW(), NOW()),
('Skeeter Pee', 'Sweet Lemon Wine', 'The original, easy to drink, naturally fermented lemon drink. Bitter, sweet, and a kick in the teeth. This hot-weather thirst quencher puts commercialized lemon-flavored malt beverages to shame.', '1.070', '1.009', 0, 0, NOW(), NOW()),
('Black Peach', 'Iced Tea', 'Black tea infused with the unmistakable summertime flavor of juicy, orchard-fresh peaches and just the right amount of natural milled cane sugar.', '1.000', '1.000', 0, 0, NOW(), NOW()),
('Aloha Morning', 'Hawaiian Punch', 'Children''s strawberry and citrus punch, thinned to suit an adult pallet using only the highest quality dihydrogen monoxide available.', '1.000', '1.000', 0, 0, NOW(), NOW());

-- --------------------------------------------------------

--
-- Dumping data for table `kegTypes`
--

INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '1', '1', 'Cornelius', 'Super Champion', '016530387', 'Johnstown Production Center', '', 'One hanndle cracked', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '2', '1', 'Spartanburg', 'Challenger VI', '81175979', 'Joyce Bev', 'Washington D.C.', 'Green handles', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '3', '1', 'Cornelius', 'Super Champion', '75162875', 'Pepi Cola Btlg Co', 'Oskaloosa, IA', '', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '4', '1', 'Cornelius', 'Super Champion', '77320513', 'Binghamton Btlg Co', '', '', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '5', '1', 'Cornelius', 'Super Champion', '80224203', 'Pepsi Btlg Co', 'Southern CA', 'Green handles', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '6', '1', 'Spartanburg', 'Challenger VI', '290880483', 'Pepsi Cola Btlg Co', 'San Diego', '', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '7', '1', 'Cornelius', 'Super Champion', '83129068', 'Pepsi Cola Btlg Co', '', '', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '8', '1', 'Cornelius', 'Super Champion', '78143233', 'Pepsi Cola Btlg Co', 'Parkersburg WVA', '', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '9', '1', 'Spantanburg', 'Challenger VI', '112620585', 'Pepsi Cola Btlg Co', 'Aleghany, NY', 'Blue handles', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '10', '1', 'Cornelius', 'Super Champion', '82217553', 'Pepsi Cola Seven Up', 'Mpls St Paul', '', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '11', '1', 'Cornelius', 'Super Champion', '77143229', 'So Conn Seven Up', 'S Norwalk Conn', 'Green handles', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '12', '1', 'Cornelius', 'Super Champion', '86018983', 'Seltzer Rydholm', 'Aub Port Aug', '', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '13', '1', 'Cornelius', 'Super Champion', '84405189', 'Pepsi Cola Btlg Co', 'Williamsport, PA', '', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '14', '1', 'Cornelius', 'Super Champion', '80273216', 'Pepsi Cola Btlg Co', 'Waterloo, IA', '', 'SERVING', NOW(), NOW() );
INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES ( '15', '1', 'Cornelius', 'Super Champion', '78225083', 'Pepsi Cola Btlg Co', 'San Diego', '', 'SERVING', NOW(), NOW() );

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
