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
-- Dumping data for table `breweries`
--

INSERT INTO `breweries` (`name`, `imageUrl`) VALUES
('Fair Winds Brewing Company', 'https://fairwindsbrewing.com/images/fairwindslogo.png' ),
('SweetWater Brewing Company', 'http://sweetwaterbrew.com/wp-content/themes/SWB_2015/images/b61381bdc3dd915d2cdc2f48ba67d56b_SweetWater_logo_200px.png');

-- --------------------------------------------------------

--
-- Dumping data for table `beers`
--

INSERT INTO `beers` (`name`, `beerStyleId`, `abv`, `og`, `fg`, `srm`, `ibu`, `notes`, `createdDate`, `modifiedDate`) VALUES
('Darth Vader', '80', '6.6', '1.066', '1.016', '38.0', '66.0', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', NOW(), NOW() ),
('Row 2 Hill 56', '33', '5.9', '1.055', '1.010', '5.1', '40', '100% Simcoe hops make up this beer from start to finish! It is named for the location in the experimental hop yard in Yakima, WA, where it was first created.', NOW(), NOW() ),
('Loon Lake Porter', '78', '5.0', '1.050', '1.012', '24', '24.6', 'With a low IBU and a mellow base recipe, this is a beer that can be turned from grain to glass quickly. The smoke aroma is prominent, but not at all overpowering. The sweetness of the malt really balances this beer well.', NOW(), NOW() ),
('Reaper''s Mild', '36', '3.0', '1.035', '1.012', '19.1', '20.4', 'A full flavored session beer that is both inexpensive to brew and quick to go from grain to glass. Ready to drink in a couple weeks, if you push it.', NOW(), NOW() ),
('Deception Cream Stout', '43', '5.0', '1.058', '1.020', '36', '27', 'Coffee and chocolate hit you up front intermingled with smooth caramel flavors that become noticeable mid-palate. Nice roasty finish rounds it out. Balanced and not cloying at all, but obviously leaning slightly to the sweeter side. Very smooth and creamy.', NOW(), NOW() ),
('Haus Pale Ale', '33', '5.25', '1.051', '1.011', '5.0', '39.0', 'Pale straw-gold color with two fingers of fluffy white head. Bread dough and cracker aromas up front, followed immediately by pine and grapefruit. Clean, crisp and dangerously sessionable.', NOW(), NOW() ),
('Two Hearted Ale', '49', '5.4', '1.055', '1.014', '5.6', '52.6', 'American malts and enormous hop additions give this beer a crisp finish and an incredibly floral aroma.', NOW(), NOW() ),
('Skeeter Pee', '100', '8.0', '1.070', '1.009', '0', '0', 'The original, easy to drink, naturally fermented lemon drink. Bitter, sweet, and a kick in the teeth. This hot-weather thirst quencher puts commercialized lemon-flavored malt beverages to shame.', NOW(), NOW() ),
('Black Peach Tea', '102', '0.0', '1.000', '1.000', '0', '0', 'Black tea infused with the unmistakable summertime flavor of juicy, orchard-fresh peaches and just the right amount of natural milled cane sugar.', NOW(), NOW() ),
('Aloha Morning', '105', '0.0', '1.000', '1.000', '0', '0', 'Children''s strawberry and citrus punch, thinned to suit an adult pallet using only the highest quality dihydrogen monoxide available.', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Dumping data for table `kegTypes`
--

INSERT INTO `kegs` ( label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, notes, kegStatusCode, onTapId, beerId, createdDate, modifiedDate ) VALUES
( '1', '1', 'Cornelius', 'Super Champion', '16530387', 'Johnstown Production Center', '(Unknown)', 'One hanndle cracked', 'SERVING', 1, '1', NOW(), NOW() ),
( '2', '1', 'Spartanburg', 'Challenger VI', '81175979', 'Joyce Bev', 'Washington D.C.', 'Green handles', 'SERVING', 2, '2', NOW(), NOW() ),
( '3', '1', 'Cornelius', 'Super Champion', '75162875', 'Pepi Cola Btlg Co', 'Oskaloosa, IA', '', 'SERVING', 3, '3', NOW(), NOW() ),
( '4', '1', 'Cornelius', 'Super Champion', '77320513', 'Binghamton Btlg Co', '(Unknown)', '', 'SERVING', 4, '4', NOW(), NOW() ),
( '5', '1', 'Cornelius', 'Super Champion', '80224203', 'Pepsi Btlg Co', 'Southern CA', 'Green handles', 'SERVING', 5, '5', NOW(), NOW() ),
( '6', '1', 'Spartanburg', 'Challenger VI', '290880483', 'Pepsi Cola Btlg Co', 'San Diego', '', 'SERVING', 6, '6', NOW(), NOW() ),
( '7', '1', 'Cornelius', 'Super Champion', '83129068', 'Pepsi Cola Btlg Co', '(Unknown)', '', 'SERVING', 7, '7', NOW(), NOW() ),
( '8', '1', 'Cornelius', 'Super Champion', '78143233', 'Pepsi Cola Btlg Co', 'Parkersburg WVA', '', 'SERVING', 8, '8', NOW(), NOW() ),
( '9', '1', 'Spantanburg', 'Challenger VI', '112620585', 'Pepsi Cola Btlg Co', 'Aleghany, NY', 'Blue handles', 'SERVING', 9, '9', NOW(), NOW() ),
( '10', '1', 'Cornelius', 'Super Champion', '82217553', 'Pepsi Cola Seven Up', 'Mpls St Paul', '', 'SERVING', 10, '10', NOW(), NOW() ),
( '11', '1', 'Cornelius', 'Super Champion', '77143229', 'So Conn Seven Up', 'S Norwalk Conn', 'Green handles', 'SECONDARY', NULL,  '1', NOW(), NOW() ),
( '12', '1', 'Cornelius', 'Super Champion', '86018983', 'Seltzer Rydholm', 'Aub Port Aug', '', 'SECONDARY', NULL, '2', NOW(), NOW() ),
( '13', '1', 'Cornelius', 'Super Champion', '84405189', 'Pepsi Cola Btlg Co', 'Williamsport, PA', '', 'DRY_HOPPING', NULL, '3', NOW(), NOW() ),
( '14', '1', 'Cornelius', 'Super Champion', '80273216', 'Pepsi Cola Btlg Co', 'Waterloo, IA', '', 'DRY_HOPPING', NULL, '4', NOW(), NOW() ),
( '15', '1', 'Cornelius', 'Super Champion', '78225083', 'Pepsi Cola Btlg Co', 'San Diego', '', 'CONDITIONING', NULL, '5', NOW(), NOW() ),
( '16', '1', 'Firestone', 'Challenger VI', '103760380', 'Pepsi Cola Btlg Co', 'San Diego', '', 'CONDITIONING', NULL, '6', NOW(), NOW() ),
( '17', '1', 'Cornelius', 'Super Champion', '85017588', 'Pepsi Cola Btlg Co', 'Fresno, CA', '', 'CLEAN', NULL, NULL, NOW(), NOW() ),
( '18', '1', 'Firestone', 'Challenger VI', '214311080', 'Dr Pepper Company', 'Dallas Texas 75265', '', 'CLEAN', NULL, NULL, NOW(), NOW() ),
( '19', '1', 'Cornelius', 'Super Champion', '79282429', 'Pepsi Cola Btlg Co', 'San Francisco CA 2 79', '', 'CLEAN', NULL, NULL, NOW(), NOW() ),
( '20', '1', 'Cornelius', 'Super Champion', '79629286', 'Pepsi Cola Btlg Co', 'Vickers Rock PA', '', 'CLEAN', NULL, NULL, NOW(), NOW() ),
( '21', '1', 'Cornelius', 'Super Champion', '83127465', 'Pepsi Cola Btlg Co', 'Mpls and St Paul', '', 'CLEAN', NULL, NULL, NOW(), NOW() ),
( '22', '1', 'Firestone', 'Challenger VI', '071410882', 'Pepsi PBG', '(Unknown)', '', 'NEEDS_CLEANING', NULL, NULL, NOW(), NOW() ),
( '23', '1', 'Cornelius', 'Super Champion', '83114663', 'Pepsi Cola Seven Up', 'Mpls and St Paul', 'Leaks at pressure relief valve', 'NEEDS_PARTS', NULL, NULL, NOW(), NOW() ),
( '24', '1', 'Cornelius', 'Super Champion', '83295909', 'PBG', '(Unknown)', 'Leaks at lid/body interface when < 15 PSI', 'NEEDS_REPAIRS', NULL, NULL, NOW(), NOW() );


-- --------------------------------------------------------

--
-- Put all beers into the `taps` table
--

INSERT INTO taps(`kegId`, `tapNumber`, `active`, `createdDate`, `modifiedDate`)
SELECT kegs.id as kegId, kegs.onTapId as tapNumber, 1 as active, NOW() as createdDate, NOW() as modifiedDate
FROM (SELECT k.* FROM kegs k LEFT JOIN kegTypes kt ON kt.id = k.kegTypeId WHERE k.beerId IS NOT NULL AND k.onTapId IS NOT NULL ORDER BY Id) as kegs;

UPDATE kegs k INNER JOIN kegTypes kt ON kt.id = k.kegTypeId SET startAmount=kt.maxAmount, maxAmount=kt.maxAmount, currentAmount=kt.maxAmount
WHERE k.beerId IS NOT NULL AND k.onTapId IS NOT NULL;
-- --------------------------------------------------------

--
-- Add some bottles to `bottles` table
--

INSERT INTO `bottles` ( bottleTypeId, beerId, capRgba, capNumber, startAmount, currentAmount, active, createdDate, modifiedDate ) VALUES
( '1', '1', '200,000,000,0.5', '1', '16', '16', '1', NOW(), NOW() ),
( '2', '2', '000,200,000,0.5', NULL, '8', '6', '1', NOW(), NOW() ),
( '1', '3', '000,000,200,0.5', NULL, '32', '12', '1', NOW(), NOW() ),
( '2', '4', '200,200,200,0.5', NULL, '4', '1', '1', NOW(), NOW() );

-- --------------------------------------------------------

--
-- Add number of taps to `config`
--

UPDATE `config` SET configValue='10' WHERE configname='numberOfTaps';


UPDATE tapconfig set countUnit = 'oz' WHERE countUnit IS NULL;
UPDATE tapconfig set count = '3000' WHERE count IS NULL;
UPDATE tapconfig set loadCellUnit = 'lb' WHERE loadCellUnit IS NULL;
UPDATE beers set ogUnit = 'sg', fgUnit = 'sg' WHERE ogUnit IS NULL;
UPDATE kegs SET weightUnit ='lb', emptyWeightUnit ='lb', maxVolumeUnit ='oz', 
				startAmountUnit ='oz', currentAmountUnit ='oz', fermentationPSIUnit ='psi', keggingTempUnit = 'F' 
				WHERE weightUnit IS NULL;
UPDATE kegTypes SET maxAmountUnit = 'oz', emptyWeightUnit = 'lb' WHERE emptyWeightUnit IS NULL;
UPDATE pours set amountPouredUnit = 'oz' WHERE amountPouredUnit IS NULL;
UPDATE yeasts set minTempUnit = 'F', maxTempUnit = 'F' WHERE maxTempUnit IS NULL;
UPDATE tempLog set tempUnit = 'F' WHERE tempUnit IS NULL;
UPDATE bottleTypes set volumeUnit = 'oz' WHERE volumeUnit IS NULL;
UPDATE tapEvents set amountUnit = 'gal' WHERE amountUnit IS NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
