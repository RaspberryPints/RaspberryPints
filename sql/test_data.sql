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
-- Dumping data for table `breweries`
--

INSERT INTO `breweries` (`name`, `imageUrl`) VALUES
('Fair Winds Brewing Company', 'https://fairwindsbrewing.com/images/fairwindslogo.png' ),
('SweetWater Brewing Company', 'http://sweetwaterbrew.com/wp-content/themes/SWB_2015/images/b61381bdc3dd915d2cdc2f48ba67d56b_SweetWater_logo_200px.png');

-- --------------------------------------------------------

--
-- Dumping data for table `beers`
--

INSERT INTO `beers` (`name`, `beerStyleId`, `abv`, `srmEst`, `ibuEst`, `notes`, `createdDate`, `modifiedDate`) VALUES
('Darth Vader', '80', '6.6', '38.0', '66.0', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', NOW(), NOW() ),
('Row 2 Hill 56', '33', '5.9', '5.1', '40', '100% Simcoe hops make up this beer from start to finish! It is named for the location in the experimental hop yard in Yakima, WA, where it was first created.', NOW(), NOW() ),
('Loon Lake Porter', '78', '5.0', '24', '24.6', 'With a low IBU and a mellow base recipe, this is a beer that can be turned from grain to glass quickly. The smoke aroma is prominent, but not at all overpowering. The sweetness of the malt really balances this beer well.', NOW(), NOW() ),
('Reaper''s Mild', '36', '3.0', '19.1', '20.4', 'A full flavored session beer that is both inexpensive to brew and quick to go from grain to glass. Ready to drink in a couple weeks, if you push it.', NOW(), NOW() ),
('Deception Cream Stout', '43', '5.0', '36', '27', 'Coffee and chocolate hit you up front intermingled with smooth caramel flavors that become noticeable mid-palate. Nice roasty finish rounds it out. Balanced and not cloying at all, but obviously leaning slightly to the sweeter side. Very smooth and creamy.', NOW(), NOW() ),
('Haus Pale Ale', '33', '5.25', '5.0', '39.0', 'Pale straw-gold color with two fingers of fluffy white head. Bread dough and cracker aromas up front, followed immediately by pine and grapefruit. Clean, crisp and dangerously sessionable.', NOW(), NOW() ),
('Two Hearted Ale', '49', '5.4', '5.6', '52.6', 'American malts and enormous hop additions give this beer a crisp finish and an incredibly floral aroma.', NOW(), NOW() ),
('Skeeter Pee', '100', '8.0', '0', '0', 'The original, easy to drink, naturally fermented lemon drink. Bitter, sweet, and a kick in the teeth. This hot-weather thirst quencher puts commercialized lemon-flavored malt beverages to shame.', NOW(), NOW() ),
('Black Peach Tea', '102', '0.0', '0', '0', 'Black tea infused with the unmistakable summertime flavor of juicy, orchard-fresh peaches and just the right amount of natural milled cane sugar.', NOW(), NOW() ),
('Aloha Morning', '105', '0.0', '0', '0', 'Children''s strawberry and citrus punch, thinned to suit an adult pallet using only the highest quality dihydrogen monoxide available.', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Dumping data for table `kegTypes`
--

INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, createdDate, modifiedDate ) VALUES
( '1', '1', 'Cornelius', 'Super Champion', '16530387', 'Johnstown Production Center', '(Unknown)', 'One hanndle cracked', 'SERVING', NOW(), NOW() ),
( '2', '1', 'Spartanburg', 'Challenger VI', '81175979', 'Joyce Bev', 'Washington D.C.', 'Green handles', 'SERVING', NOW(), NOW() ),
( '3', '1', 'Cornelius', 'Super Champion', '75162875', 'Pepi Cola Btlg Co', 'Oskaloosa, IA', '', 'SERVING', NOW(), NOW() ),
( '4', '1', 'Cornelius', 'Super Champion', '77320513', 'Binghamton Btlg Co', '(Unknown)', '', 'SERVING', NOW(), NOW() ),
( '5', '1', 'Cornelius', 'Super Champion', '80224203', 'Pepsi Btlg Co', 'Southern CA', 'Green handles', 'SERVING', NOW(), NOW() ),
( '6', '1', 'Spartanburg', 'Challenger VI', '290880483', 'Pepsi Cola Btlg Co', 'San Diego', '', 'SERVING', NOW(), NOW() ),
( '7', '1', 'Cornelius', 'Super Champion', '83129068', 'Pepsi Cola Btlg Co', '(Unknown)', '', 'SERVING', NOW(), NOW() ),
( '8', '1', 'Cornelius', 'Super Champion', '78143233', 'Pepsi Cola Btlg Co', 'Parkersburg WVA', '', 'SERVING', NOW(), NOW() ),
( '9', '1', 'Spantanburg', 'Challenger VI', '112620585', 'Pepsi Cola Btlg Co', 'Aleghany, NY', 'Blue handles', 'SERVING', NOW(), NOW() ),
( '10', '1', 'Cornelius', 'Super Champion', '82217553', 'Pepsi Cola Seven Up', 'Mpls St Paul', '', 'SERVING', NOW(), NOW() ),
( '11', '1', 'Cornelius', 'Super Champion', '77143229', 'So Conn Seven Up', 'S Norwalk Conn', 'Green handles', 'SECONDARY', NOW(), NOW() ),
( '12', '1', 'Cornelius', 'Super Champion', '86018983', 'Seltzer Rydholm', 'Aub Port Aug', '', 'SECONDARY', NOW(), NOW() ),
( '13', '1', 'Cornelius', 'Super Champion', '84405189', 'Pepsi Cola Btlg Co', 'Williamsport, PA', '', 'DRY_HOPPING', NOW(), NOW() ),
( '14', '1', 'Cornelius', 'Super Champion', '80273216', 'Pepsi Cola Btlg Co', 'Waterloo, IA', '', 'DRY_HOPPING', NOW(), NOW() ),
( '15', '1', 'Cornelius', 'Super Champion', '78225083', 'Pepsi Cola Btlg Co', 'San Diego', '', 'CONDITIONING', NOW(), NOW() ),
( '16', '1', 'Firestone', 'Challenger VI', '103760380', 'Pepsi Cola Btlg Co', 'San Diego', '', 'CONDITIONING', NOW(), NOW() ),
( '17', '1', 'Cornelius', 'Super Champion', '85017588', 'Pepsi Cola Btlg Co', 'Fresno, CA', '', 'CLEAN', NOW(), NOW() ),
( '18', '1', 'Firestone', 'Challenger VI', '214311080', 'Dr Pepper Company', 'Dallas Texas 75265', '', 'CLEAN', NOW(), NOW() ),
( '19', '1', 'Cornelius', 'Super Champion', '79282429', 'Pepsi Cola Btlg Co', 'San Francisco CA 2 79', '', 'CLEAN', NOW(), NOW() ),
( '20', '1', 'Cornelius', 'Super Champion', '79629286', 'Pepsi Cola Btlg Co', 'Vickers Rock PA', '', 'CLEAN', NOW(), NOW() ),
( '21', '1', 'Cornelius', 'Super Champion', '83127465', 'Pepsi Cola Btlg Co', 'Mpls and St Paul', '', 'CLEAN', NOW(), NOW() ),
( '22', '1', 'Firestone', 'Challenger VI', '071410882', 'Pepsi PBG', '(Unknown)', '', 'NEEDS_CLEANING', NOW(), NOW() ),
( '23', '1', 'Cornelius', 'Super Champion', '83114663', 'Pepsi Cola Seven Up', 'Mpls and St Paul', 'Leaks at pressure relief valve', 'NEEDS_PARTS', NOW(), NOW() ),
( '24', '1', 'Cornelius', 'Super Champion', '83295909', 'PBG', '(Unknown)', 'Leaks at lid/body interface when < 15 PSI', 'NEEDS_REPAIRS', NOW(), NOW() );


-- --------------------------------------------------------

--
-- Put all beers into the `taps` table
--

INSERT INTO taps(`beerId`, `kegId`, `tapNumber`, `active`, `abv`, `srmAct`, `ibuAct`, `startAmount`, `currentAmount`, `createdDate`, `modifiedDate`)
SELECT b.id, keg.id as kegId, b.id as tapNumber, 1 as active, b.abv as abv, b.srmEst as srmAct, b.ibuEst as ibuAct, keg.startAmount as startAmount, keg.startAmount as currentAmount, NOW() as createdDate, NOW() as modifiedDate
FROM `beers` as b, (SELECT k.*, kt.maxAmount as startAmount FROM kegs k LEFT JOIN kegTypes kt ON kt.id = k.kegTypeId ORDER BY Id LIMIT 1) as keg;

-- --------------------------------------------------------

--
-- Add number of taps to `config`
--

UPDATE `config` SET configValue='10' WHERE configname='numberOfTaps';


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
