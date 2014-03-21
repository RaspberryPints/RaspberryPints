-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 21, 2014 at 10:56 AM
-- Server version: 5.5.35
-- PHP Version: 5.4.4-14+deb7u8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `devpints`
--

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `created_at`, `updated_at`) VALUES
('ClientID', 'F991DC82D5A3CD53E49DBE4B8AB36DD4052A881D', 'Client ID', 0, '2014-02-24 19:30:10', '2014-02-24 19:30:10'),
('ClientSecret', '0B632BB937A7D1D809CE06005318112BE4257916', 'Client Secret', 0, '2014-02-24 19:30:10', '2014-02-24 19:30:10'),
('BreweryID', '51594', 'Brewery ID', 0, '2014-02-24 19:30:10', '2014-02-24 19:30:10');

--
-- Update Beers
-- 
ALTER TABLE  `beers` ADD  `untID` INT( 10 ) NOT NULL DEFAULT  '0' AFTER  `active`

--
-- Update vwGetActiveTaps
--
CREATE OR REPLACE 
ALGORITHM = UNDEFINED
VIEW  `vwGetActiveTaps` AS 
SELECT  `t`.`id` AS  `id` ,  `be`.`name` AS  `name` ,  `bs`.`name` AS  `style` ,  `be`.`notes` AS  `notes` ,  `ba`.`ogAct` AS  `ogAct` ,  `ba`.`fgAct` AS  `fgAct` ,  `ba`.`srmAct` AS  `srmAct` ,  `ba`.`ibuAct` AS  `ibuAct` ,  `ba`.`startLiter` AS `startLiter` , IFNULL(  `p`.`litersPoured` , 0 ) AS  `litersPoured` , (
`ba`.`startLiter` - IFNULL(  `p`.`litersPoured` , 0 )
) AS  `remainAmount` ,  `t`.`tapNumber` AS  `tapNumber` ,  `s`.`rgb` AS  `srmRgb` ,  `be`.`untID` AS  `untID` 
FROM (((((`taps`  `t` LEFT JOIN  `batches`  `ba` ON ( (`ba`.`id` =  `t`.`batchId`) ))LEFT JOIN  `beers`  `be` ON ( (`be`.`id` =  `ba`.`beerId`) ))
LEFT JOIN  `beerStyles`  `bs` ON ( (`bs`.`id` =  `be`.`beerStyleId`) ))
LEFT JOIN  `srmRgb`  `s` ON ( (`s`.`srm` =  `ba`.`srmAct`) )
)LEFT JOIN  `vwGetTapsAmountPoured`  `p` ON ( (`p`.`batchId` =  `ba`.`id`) ))
WHERE (`t`.`active` =1) ORDER BY  `t`.`tapNumber`;