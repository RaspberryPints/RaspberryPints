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

INSERT INTO `beers` (`name`, `style`, `notes`, `ogEst`, `fgEst`, `srmEst`, `ibuEst`) VALUES
('Darth Vader', 'Cascadian Dark Ale', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', '1.066', '1.016', 38.0, 66.0),
('Strong Scotch', 'Scotch Ale', 'Slightly sweet. Hints of malt and toffee. Finishes with roasted nuts and coffee. Complex and roasty.', '1.074', '1.018', 17.8, 27.0),
('Cream of Three Crops', 'Cream Ale', 'Neutral, muted start. Highly carbonated with a soapy head. Unremarkably mild finish of noble hops. Dry and crisp with no distinguishable graininess.', '1.040', '1.009', 2.9, 14.3),
('Darth Vader', 'Cascadian Dark Ale', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', '1.066', '1.016', 38.0, 66.0),
('Haus Pale Ale', 'American Pale Ale', 'Pale straw-gold color with two fingers of fluffy white head. Bread dough and cracker aromas up front, followed immediately by pine and grapefruit. Clean, crisp and dangerously sessionable.', '1.051', '1.011', 5.0, 39.0),
('Two Hearted', 'American IPA', 'American malts and enormous hop additions give this beer a crisp finish and an incredibly floral aroma.', '1.055', '1.014', 5.6, 52.6),
('Reaper''s Mild', 'English Mild', 'A full flavored session beer that is both inexpensive to brew and quick to go from grain to glass. Ready to drink in a couple weeks, if you push it.', '1.035', '1.012', 19.1, 20.4),
('Skeeter Pee', 'Sweet Lemon Wine', 'The original, easy to drink, naturally fermented lemon drink. Bitter, sweet, and a kick in the teeth. This hot-weather thirst quencher puts commercialized lemon-flavored malt beverages to shame.', '1.070', '1.009', 0, 0),
('Black Peach', 'Iced Tea', 'Black tea infused with the unmistakable summertime flavor of juicy, orchard-fresh peaches and just the right amount of natural milled cane sugar.', '1.000', '1.000', 0, 0),
('Aloha Morning', 'Hawaiian Punch', 'Children''s strawberry and citrus punch, thinned to suit an adult pallet using only the highest quality dihydrogen monoxide available.', '1.000', '1.000', 0, 0);



-- --------------------------------------------------------

--
-- Put all beers into the `taps` table
--

INSERT INTO taps(`beerId`, `kegTypeId`, `tapNumber`, `active`, `ogAct`, `fgAct`, `srmAct`, `ibuAct`, `startAmount`, `createdDate`, `modifiedDate`)
SELECT b.id, kegType.id as kegTypeId, b.id as tapNumber, 1 as active, b.ogEst as ogAct, b.fgEst as fgAct, b.srmEst as srmAct, b.ibuEst as ibuAct, kegType.maxAmount as startAmount, NOW() as createdDate, NOW() as modifiedDate
FROM `beers` as b, (SELECT * FROM kegTypes ORDER BY Id LIMIT 1) as kegType;

-- --------------------------------------------------------

--
-- Add number of taps to `config`
--

UPDATE `config` SET configValue='10' WHERE configname='numberOfTaps';


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
