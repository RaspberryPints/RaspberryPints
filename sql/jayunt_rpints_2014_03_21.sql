-- MySQL dump 10.13  Distrib 5.5.30, for Win64 (x86)
--
-- Host: localhost    Database: raspberrypints
-- ------------------------------------------------------
-- Server version	5.5.30-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `batches`
--

DROP TABLE IF EXISTS `batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `batches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beerId` int(11) NOT NULL,
  `kegId` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `ogAct` decimal(4,3) DEFAULT NULL,
  `fgAct` decimal(4,3) DEFAULT NULL,
  `srmAct` decimal(3,1) DEFAULT NULL,
  `ibuAct` int(4) DEFAULT NULL,
  `startKg` decimal(6,2) DEFAULT NULL,
  `startLiter` decimal(6,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `beerId` (`beerId`),
  KEY `kegId` (`kegId`),
  CONSTRAINT `batches_ibfk_1` FOREIGN KEY (`beerId`) REFERENCES `beers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `batches_ibfk_2` FOREIGN KEY (`kegId`) REFERENCES `kegs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `batches`
--

LOCK TABLES `batches` WRITE;
/*!40000 ALTER TABLE `batches` DISABLE KEYS */;
INSERT INTO `batches` VALUES (1,1,1,1,1.066,1.016,38.0,66,NULL,18.93,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(2,2,1,1,1.074,1.018,17.8,27,NULL,18.93,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(3,3,1,1,1.040,1.009,2.9,14,NULL,18.93,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(4,4,1,1,1.066,1.016,38.0,66,NULL,18.93,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(5,5,1,1,1.051,1.011,5.0,39,NULL,18.93,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(6,6,1,1,1.055,1.014,5.6,53,NULL,18.93,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(7,7,1,1,1.035,1.012,19.1,20,NULL,18.93,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(8,8,1,1,1.070,1.009,0.0,0,NULL,18.93,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(9,9,1,1,1.000,1.000,0.0,0,NULL,18.93,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(10,10,1,1,1.000,1.000,0.0,0,NULL,18.93,'2014-03-02 20:47:26','2014-03-02 20:47:26');
/*!40000 ALTER TABLE `batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beers`
--

DROP TABLE IF EXISTS `beers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `beerStyleId` int(11) NOT NULL,
  `notes` text NOT NULL,
  `ogEst` decimal(4,3) NOT NULL,
  `fgEst` decimal(4,3) NOT NULL,
  `srmEst` decimal(3,1) NOT NULL,
  `ibuEst` int(4) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `beerStyleId` (`beerStyleId`),
  CONSTRAINT `beers_ibfk_1` FOREIGN KEY (`beerStyleId`) REFERENCES `beerstyles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beers`
--

LOCK TABLES `beers` WRITE;
/*!40000 ALTER TABLE `beers` DISABLE KEYS */;
INSERT INTO `beers` VALUES (1,'Darth Vader',1,'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.',1.066,1.016,38.0,66,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(2,'Strong Scotch',10,'Slightly sweet. Hints of malt and toffee. Finishes with roasted nuts and coffee. Complex and roasty.',1.074,1.018,17.8,27,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(3,'Cream of Three Crops',20,'Neutral, muted start. Highly carbonated with a soapy head. Unremarkably mild finish of noble hops. Dry and crisp with no distinguishable graininess.',1.040,1.009,2.9,14,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(4,'Darth Vader',30,'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.',1.066,1.016,38.0,66,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(5,'Haus Pale Ale',40,'Pale straw-gold color with two fingers of fluffy white head. Bread dough and cracker aromas up front, followed immediately by pine and grapefruit. Clean, crisp and dangerously sessionable.',1.051,1.011,5.0,39,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(6,'Two Hearted',50,'American malts and enormous hop additions give this beer a crisp finish and an incredibly floral aroma.',1.055,1.014,5.6,53,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(7,'Reaper\'s Mild',60,'A full flavored session beer that is both inexpensive to brew and quick to go from grain to glass. Ready to drink in a couple weeks, if you push it.',1.035,1.012,19.1,20,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(8,'Skeeter Pee',70,'The original, easy to drink, naturally fermented lemon drink. Bitter, sweet, and a kick in the teeth. This hot-weather thirst quencher puts commercialized lemon-flavored malt beverages to shame.',1.070,1.009,0.0,0,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(9,'Black Peach',80,'Black tea infused with the unmistakable summertime flavor of juicy, orchard-fresh peaches and just the right amount of natural milled cane sugar.',1.000,1.000,0.0,0,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(10,'Aloha Morning',90,'Children\'s strawberry and citrus punch, thinned to suit an adult pallet using only the highest quality dihydrogen monoxide available.',1.000,1.000,0.0,0,1,'2014-03-18 21:38:12','2014-03-19 01:38:12'),(11,'Test 3',34,'asd',1.000,1.000,1.0,1,0,'2014-03-18 21:46:02','2014-03-19 01:46:02');
/*!40000 ALTER TABLE `beers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beerstyles`
--

DROP TABLE IF EXISTS `beerstyles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beerstyles` (
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
  `ibuMin` decimal(3,0) NOT NULL,
  `ibuMax` decimal(3,0) NOT NULL,
  `srmMin` decimal(2,0) NOT NULL,
  `srmMax` decimal(2,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beerstyles`
--

LOCK TABLES `beerstyles` WRITE;
/*!40000 ALTER TABLE `beerstyles` DISABLE KEYS */;
INSERT INTO `beerstyles` VALUES (1,'Lite American Lager','1A','Light Lager',1.028,1.040,0.998,1.008,2.8,4.2,8,12,2,3,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(2,'Standard American Lager','1B','Light Lager',1.040,1.050,1.004,1.010,4.2,5.1,8,15,2,4,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(3,'Premium American Lager','1C','Light Lager',1.046,1.056,1.008,1.012,4.6,6.0,15,25,2,6,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(4,'Munich Helles','1D','Light Lager',1.045,1.051,1.008,1.012,4.7,5.4,16,22,3,5,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(5,'Dortmunder Export','1E','Light Lager',1.048,1.056,1.010,1.015,4.8,6.0,23,30,4,6,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(6,'German Pilsner (Pils)','2A','Pilsner',1.044,1.050,1.008,1.013,4.4,5.2,25,45,2,5,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(7,'Bohemian Pilsner','2B','Pilsner',1.044,1.056,1.013,1.017,4.2,5.4,35,45,4,6,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(8,'Classic American Pilsner','2C','Pilsner',1.044,1.060,1.010,1.015,4.5,6.0,25,40,3,6,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(9,'Vienna Lager','3A','European Amber Lager',1.046,1.052,1.010,1.014,4.5,5.5,18,30,10,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(10,'Oktoberfest/M&auml;rzen','3B','European Amber Lager',1.050,1.057,1.012,1.016,4.8,5.7,20,28,7,14,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(11,'Dark American Lager','4A','Dark Lager',1.044,1.056,1.008,1.012,4.2,6.0,8,20,14,22,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(12,'Munich Dunkel','4B','Dark Lager',1.048,1.056,1.010,1.016,4.5,5.6,18,28,14,28,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(13,'Schwarzbier (Black Beer)','4C','Dark Lager',1.046,1.052,1.010,1.016,4.4,5.4,22,32,17,30,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(14,'Mailbock/Helles Bock','5A','Bock',1.064,1.072,1.011,1.018,6.3,7.4,23,35,6,11,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(15,'Traditional Bock','5B','Bock',1.064,1.072,1.013,1.019,6.3,7.2,20,27,14,22,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(16,'Doppelbock','5C','Bock',1.072,1.112,1.016,1.024,7.0,10.0,16,26,6,25,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(17,'Eisbock','5D','Bock',1.078,1.120,1.020,1.035,9.0,14.0,25,35,18,30,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(18,'Cream Ale','6A','Light Hybrid Beer',1.042,1.055,1.006,1.012,4.2,5.6,15,20,3,5,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(19,'Blonde Ale','6B','Light Hybrid Beer',1.038,1.054,1.008,1.013,3.8,5.5,15,28,3,6,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(20,'K&ouml;lsch','6C','Light Hybrid Beer',1.044,1.050,1.007,1.011,4.4,5.2,20,30,4,5,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(21,'American Wheat or Rye Beer','6D','Light Hybrid Beer',1.040,1.055,1.008,1.013,4.0,5.5,15,30,3,6,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(22,'Northern German Altbier','7A','Amber Hybrid Beer',1.046,1.054,1.010,1.015,4.5,5.2,25,40,13,19,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(23,'California Common Beer','7B','Amber Hybrid Beer',1.048,1.054,1.011,1.014,4.5,5.5,30,45,10,14,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(24,'D&uuml;sseldorf Altbier','7C','Amber Hybrid Beer',1.046,1.054,1.010,1.015,4.5,5.2,35,50,11,17,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(25,'Standard/Ordinary Bitter','8A','English Pale Ale',1.032,1.040,1.007,1.011,3.2,3.8,25,35,4,14,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(26,'Special/Best/Premium Bitter','8B','English Pale Ale',1.040,1.048,1.008,1.012,3.8,4.6,25,40,5,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(27,'Extra Special/Strong Bitter','8C','English Pale Ale',1.048,1.060,1.010,1.016,4.6,6.2,30,50,6,18,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(28,'Scottish Light 60/-','9A','Scottish and Irish Ale',1.030,1.035,1.010,1.013,2.5,3.2,10,20,9,17,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(29,'Scottish Heavy 70/-','9B','Scottish and Irish Ale',1.035,1.040,1.010,1.015,3.2,3.9,10,25,9,17,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(30,'Scottish Export 80/-','9C','Scottish and Irish Ale',1.040,1.054,1.010,1.016,3.9,5.0,15,30,9,17,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(31,'Irish Red Ale','9D','Scottish and Irish Ale',1.044,1.060,1.010,1.014,4.0,6.0,17,28,9,18,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(32,'Strong Scotch Ale','9E','Scottish and Irish Ale',1.070,1.130,1.018,1.030,6.5,10.0,17,35,14,25,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(33,'American Pale Ale','10A','American Ale',1.045,1.060,1.010,1.015,4.5,6.2,30,45,5,14,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(34,'American Amber Ale','10B','American Ale',1.045,1.060,1.010,1.015,4.5,6.2,25,40,10,17,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(35,'American Brown Ale','10C','American Ale',1.045,1.060,1.010,1.016,4.3,6.2,20,40,18,35,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(36,'Mild','11A','English Brown Ale',1.030,1.038,1.008,1.013,2.8,4.5,10,25,12,25,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(37,'Southern English Brown Ale','11B','English Brown Ale',1.033,1.042,1.011,1.014,2.8,4.1,12,20,19,35,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(38,'Northern English Brown Ale','11C','English Brown Ale',1.040,1.052,1.008,1.013,4.2,5.4,20,30,12,22,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(39,'Brown Porter','12A','Porter',1.040,1.052,1.008,1.014,4.0,5.4,18,35,20,30,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(40,'Robust Porter','12B','Porter',1.048,1.065,1.012,1.016,4.8,6.5,25,50,22,35,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(41,'Baltic Porter','12C','Porter',1.060,1.090,1.016,1.024,5.5,9.5,20,40,17,30,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(42,'Dry Stout','13A','Stout',1.036,1.050,1.007,1.011,4.0,5.0,30,45,25,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(43,'Sweet Stout','13B','Stout',1.044,1.060,1.012,1.024,4.0,6.0,20,40,30,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(44,'Oatmeal Stout','13C','Stout',1.048,1.065,1.010,1.018,4.2,5.9,25,40,22,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(45,'Foreign Extra Stout','13D','Stout',1.056,1.075,1.010,1.018,5.5,8.0,30,70,30,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(46,'American Stout','13E','Stout',1.050,1.075,1.010,1.022,5.0,7.0,35,75,30,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(47,'Imperial Stout','13F','Stout',1.075,1.115,1.018,1.030,8.0,12.0,50,90,30,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(48,'English IPA','14A','India Pale Ale (IPA)',1.050,1.075,1.010,1.018,5.0,7.5,40,60,8,14,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(49,'American IPA','14B','India Pale Ale (IPA)',1.056,1.075,1.010,1.018,5.5,7.5,40,70,6,15,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(50,'Imperial IPA','14C','India Pale Ale (IPA)',1.070,1.090,1.010,1.020,7.5,10.0,60,120,8,15,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(51,'Weizen/Weissbier','15A','German Wheat and Rye Beer',1.044,1.052,1.010,1.014,4.3,5.6,8,15,2,8,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(52,'Dunkelweizen','15B','German Wheat and Rye Beer',1.044,1.056,1.010,1.014,4.3,5.6,10,18,14,23,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(53,'Weizenbock','15C','German Wheat and Rye Beer',1.064,1.090,1.015,1.022,6.5,8.0,15,30,12,25,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(54,'Roggenbier (German Rye Beer)','15D','German Wheat and Rye Beer',1.046,1.056,1.010,1.014,4.5,6.0,10,20,14,19,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(55,'Witbier','16A','Belgian and French Ale',1.044,1.052,1.008,1.012,4.5,5.5,10,20,2,4,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(56,'Belgian Pale Ale','16B','Belgian and French Ale',1.048,1.054,1.010,1.014,4.8,5.5,20,30,8,14,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(57,'Saison','16C','Belgian and French Ale',1.048,1.065,1.002,1.012,5.0,7.0,20,35,5,14,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(58,'Biere de Garde','16D','Belgian and French Ale',1.060,1.080,1.008,1.016,6.0,8.5,18,28,6,19,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(59,'Belgian Specialty Ale','16E','Belgian and French Ale',1.030,1.080,1.006,1.019,3.0,9.0,15,40,3,50,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(60,'Berliner Weiss','17A','Sour Ale',1.028,1.032,1.003,1.006,2.8,3.8,3,8,2,3,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(61,'Flanders Red Ale','17B','Sour Ale',1.048,1.057,1.002,1.012,4.6,6.5,10,25,10,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(62,'Flanders Brown Ale/Oud Bruin','17C','Sour Ale',1.040,1.074,1.008,1.012,4.0,8.0,20,25,15,22,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(63,'Straight (Unblended) Lambic','17D','Sour Ale',1.040,1.054,1.001,1.010,5.0,6.5,0,10,3,7,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(64,'Gueuze','17E','Sour Ale',1.040,1.060,1.000,1.006,5.0,8.0,0,10,3,7,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(65,'Fruit Lambic','17F','Sour Ale',1.040,1.060,1.000,1.010,5.0,7.0,0,10,3,7,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(66,'Belgian Blond Ale','18A','Belgian Strong Ale',1.062,1.075,1.008,1.018,6.0,7.5,15,30,4,7,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(67,'Belgian Dubbel','18B','Belgian Strong Ale',1.062,1.075,1.008,1.018,6.0,7.6,15,25,10,17,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(68,'Belgian Tripel','18C','Belgian Strong Ale',1.075,1.085,1.008,1.014,7.5,9.5,20,40,5,7,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(69,'Belgian Golden Strong Ale','18D','Belgian Strong Ale',1.070,1.095,1.005,1.016,7.5,10.5,22,35,3,6,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(70,'Belgian Dark Strong Ale','18E','Belgian Strong Ale',1.075,1.110,1.010,1.024,8.0,11.0,20,35,12,22,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(71,'Old Ale','19A','Strong Ale',1.060,1.090,1.015,1.022,6.0,9.0,30,60,10,22,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(72,'English Barleywine','19B','Strong Ale',1.080,1.120,1.018,1.030,8.0,12.0,35,70,8,22,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(73,'American Barleywine','19C','Strong Ale',1.080,1.120,1.016,1.030,8.0,12.0,50,120,10,19,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(74,'Fruit Beer','20A','Fruit Beer',1.030,1.110,1.004,1.024,2.5,12.0,5,70,3,50,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(75,'Spice, Herb or Vegetable Beer','21A','Spice/Herb/Vegetable Beer',1.030,1.110,1.005,1.025,2.5,12.0,0,70,5,50,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(76,'Christmas/Winter Specialty Spice Beer','21B','Spice/Herb/Vegetable Beer',1.030,1.110,1.005,1.025,2.5,12.0,0,70,5,50,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(77,'Classic Rauchbier','22A','Smoke-Flavored and Wood-Aged Beer',1.050,1.057,1.012,1.016,4.8,6.0,20,30,12,22,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(78,'Other Smoked Beer','22B','Smoke-Flavored and Wood-Aged Beer',1.030,1.110,1.006,1.024,2.5,12.0,5,70,5,50,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(79,'Wood Aged Beer','22C','Smoke-Flavored and Wood-Aged Beer',1.030,1.110,1.006,1.024,2.5,12.0,5,70,5,50,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(80,'Specialty Beer','23A','Specialty Beer',1.030,1.110,1.006,1.024,2.5,12.0,5,70,5,50,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(81,'Dry Mead','24A','Traditional Mead',1.035,1.170,0.990,1.050,3.5,18.0,0,0,1,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(82,'Semi-Sweet Mead','24B','Traditional Mead',1.035,1.170,0.990,1.050,3.5,18.0,0,0,1,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(83,'Sweet Mead','24C','Traditional Mead',1.035,1.170,0.990,1.050,7.5,15.0,0,0,1,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(84,'Cyser (Apple Melomel)','25A','Melomel (Fruit Mead)',1.035,1.170,0.990,1.050,3.5,18.0,0,0,1,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(85,'Pyment (Grape Melomel)','25B','Melomel (Fruit Mead)',1.035,1.170,0.990,1.050,3.5,18.0,0,0,1,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(86,'Other Fruit Melomel','25C','Melomel (Fruit Mead)',1.035,1.170,0.990,1.050,3.5,18.0,0,0,1,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(87,'Metheglin','26A','Other Mead',1.035,1.170,0.990,1.050,3.5,18.0,0,0,1,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(88,'Braggot','26B','Other Mead',1.035,1.170,1.009,1.050,3.5,18.0,0,50,3,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(89,'Open Category Mead','26C','Other Mead',1.035,1.170,0.990,1.050,3.5,18.0,0,50,1,16,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(90,'Common Cider','27A','Standard Cider and Perry',1.045,1.065,1.000,1.020,5.0,8.0,0,0,1,10,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(91,'English Cider','27B','Standard Cider and Perry',1.050,1.075,0.995,1.010,6.0,9.0,0,0,1,10,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(92,'French Cider','27C','Standard Cider and Perry',1.050,1.065,1.010,1.020,3.0,6.0,0,0,1,10,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(93,'Common Perry','27D','Standard Cider and Perry',1.050,1.060,1.000,1.020,5.0,7.0,0,0,0,6,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(94,'Traditional Perry','27E','Standard Cider and Perry',1.050,1.070,1.000,1.020,5.0,9.0,0,0,0,6,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(95,'New England Cider','28A','Specialty Cider and Perry',1.060,1.100,0.995,1.010,7.0,13.0,0,0,1,10,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(96,'Fruit Cider','28B','Specialty Cider and Perry',1.045,1.070,0.995,1.010,5.0,9.0,0,0,1,10,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(97,'Applewine','28C','Specialty Cider and Perry',1.070,1.100,0.995,1.010,9.0,12.0,0,0,1,10,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(98,'Other Specialty Cider/Perry','28D','Specialty Cider and Perry',1.045,1.100,0.995,1.020,5.0,12.0,0,0,1,10,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(99,'_Non-alcoholic Beer','N/A','Non-alcoholic Beer',1.000,1.000,1.000,1.000,0.0,0.0,0,0,0,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(100,'_Non-beer: Wine','N/A','Wine',1.000,1.000,1.000,1.000,0.0,20.0,0,0,0,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(101,'_Non-beer: Kombucha','N/A','Kombucha',1.000,1.000,1.000,1.000,0.0,0.0,0,0,0,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(102,'_Non-beer: Tea','N/A','Tea',1.000,1.000,1.000,1.000,0.0,0.0,0,0,0,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(103,'_Non-beer: Coffee','N/A','Coffee',1.000,1.000,1.000,1.000,0.0,0.0,0,0,0,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(104,'_Non-beer: Fruit Juice','N/A','Fruit Juice',1.000,1.000,1.000,1.000,0.0,0.0,0,0,0,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(105,'_Non-beer: Fruit Drink','N/A','Fruit Drink',1.000,1.000,1.000,1.000,0.0,0.0,0,0,0,40,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(106,'_Non-beer: Seltzer Water','N/A','Seltzer Water',1.000,1.000,1.000,1.000,0.0,0.0,0,0,0,40,'2014-03-02 20:47:19','2014-03-02 20:47:19');
/*!40000 ALTER TABLE `beerstyles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `configName` varchar(50) NOT NULL,
  `configValue` longtext NOT NULL,
  `displayName` varchar(65) NOT NULL,
  `showOnPanel` tinyint(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `configName_UNIQUE` (`configName`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'showTapNumCol','1','Tap Column',1,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(2,'showSrmCol','1','SRM Column',1,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(3,'showIbuCol','1','IBU Column',1,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(4,'showAbvCol','1','ABV Column',1,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(5,'showAbvImg','1','ABV Images',1,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(6,'showKegCol','0','Keg Column (beta!)',1,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(7,'useHighResolution','0','4k Monitor Support',1,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(8,'logoUrl','img/logo.png','Logo Url',0,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(9,'adminLogoUrl','admin/img/logo.png','Admin Logo Url',0,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(10,'headerText','Currently On Tap','Header Text',0,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(11,'numberOfTaps','10','Number of Taps',0,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(12,'version','1.0.0.279','Version',0,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(13,'headerTextTruncLen','20','Header Text Truncate Length',0,'2014-03-02 20:47:19','2014-03-02 20:47:19'),(14,'useMetric','0','Use Metric',1,'2014-03-02 20:47:38','2014-03-02 20:47:38');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kegs`
--

DROP TABLE IF EXISTS `kegs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kegs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` int(11) NOT NULL,
  `kegTypeId` int(11) NOT NULL,
  `make` text,
  `model` text,
  `serial` text,
  `stampedOwner` text,
  `stampedLoc` text,
  `notes` text,
  `kegStatusCode` varchar(20) NOT NULL,
  `weight` decimal(11,4) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `kegStatusCode` (`kegStatusCode`),
  KEY `kegTypeId` (`kegTypeId`),
  CONSTRAINT `kegs_ibfk_1` FOREIGN KEY (`kegStatusCode`) REFERENCES `kegstatuses` (`code`) ON DELETE CASCADE,
  CONSTRAINT `kegs_ibfk_2` FOREIGN KEY (`kegTypeId`) REFERENCES `kegtypes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegs`
--

LOCK TABLES `kegs` WRITE;
/*!40000 ALTER TABLE `kegs` DISABLE KEYS */;
INSERT INTO `kegs` VALUES (1,1,5,'Cornelius','Super Champion','16530387','Johnstown Production Center','(Unknown)','One hanndle cracked','SERVING',0.0000,1,'2014-03-20 19:12:51','2014-03-20 23:12:51'),(2,2,1,'Spartanburg','Challenger VI','81175979','Joyce Bev','Washington D.C.','Green handles','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(3,3,1,'Cornelius','Super Champion','75162875','Pepi Cola Btlg Co','Oskaloosa, IA','None','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(4,4,1,'Cornelius','Super Champion','77320513','Binghamton Btlg Co','(Unknown)','None','DRY_HOPPING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(5,5,1,'Cornelius','Super Champion','80224203','Pepsi Btlg Co','Southern CA','Green handles','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(6,6,1,'Spartanburg','Challenger VI','290880483','Pepsi Cola Btlg Co','San Diego','None','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(7,7,1,'Cornelius','Super Champion','83129068','Pepsi Cola Btlg Co','(Unknown)','None','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(8,8,1,'Cornelius','Super Champion','78143233','Pepsi Cola Btlg Co','Parkersburg WVA','None','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(9,9,1,'Spantanburg','Challenger VI','112620585','Pepsi Cola Btlg Co','Aleghany, NY','Blue handles','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(10,10,1,'Cornelius','Super Champion','82217553','Pepsi Cola Seven Up','Mpls St Paul','None','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(11,11,1,'Cornelius','Super Champion','77143229','So Conn Seven Up','S Norwalk Conn','Green handles','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(12,12,1,'Cornelius','Super Champion','86018983','Seltzer Rydholm','Aub Port Aug','None','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(13,13,1,'Cornelius','Super Champion','84405189','Pepsi Cola Btlg Co','Williamsport, PA','None','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(14,14,1,'Cornelius','Super Champion','80273216','Pepsi Cola Btlg Co','Waterloo, IA','None','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(15,15,1,'Cornelius','Super Champion','78225083','Pepsi Cola Btlg Co','San Diego','None','SERVING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(16,16,1,'Firestone','Challenger VI','103760380','Pepsi Cola Btlg Co','San Diego','None','NEEDS_CLEANING',0.0000,1,'2014-03-02 20:47:26','2014-03-02 20:47:26'),(17,99,9,'','','','','','','CLEAN',19.0000,0,'2014-03-21 14:58:16','2014-03-21 18:58:16');
/*!40000 ALTER TABLE `kegs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kegstatuses`
--

DROP TABLE IF EXISTS `kegstatuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kegstatuses` (
  `code` varchar(20) NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegstatuses`
--

LOCK TABLES `kegstatuses` WRITE;
/*!40000 ALTER TABLE `kegstatuses` DISABLE KEYS */;
INSERT INTO `kegstatuses` VALUES ('CLEAN','Clean','2014-03-02 20:47:20','2014-03-02 20:47:20'),('CONDITIONING','Conditioning','2014-03-02 20:47:20','2014-03-02 20:47:20'),('DRY_HOPPING','Dry Hopping','2014-03-02 20:47:20','2014-03-02 20:47:20'),('NEEDS_CLEANING','Needs Cleaning','2014-03-02 20:47:20','2014-03-02 20:47:20'),('NEEDS_PARTS','Needs Parts','2014-03-02 20:47:20','2014-03-02 20:47:20'),('NEEDS_REPAIRS','Needs Repairs','2014-03-02 20:47:20','2014-03-02 20:47:20'),('PRIMARY','Primary','2014-03-02 20:47:20','2014-03-02 20:47:20'),('SECONDARY','Secondary','2014-03-02 20:47:20','2014-03-02 20:47:20'),('SERVING','Serving','2014-03-02 20:47:20','2014-03-02 20:47:20');
/*!40000 ALTER TABLE `kegstatuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kegtypes`
--

DROP TABLE IF EXISTS `kegtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kegtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `maxLiters` decimal(6,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegtypes`
--

LOCK TABLES `kegtypes` WRITE;
/*!40000 ALTER TABLE `kegtypes` DISABLE KEYS */;
INSERT INTO `kegtypes` VALUES (1,'Ball Lock (5 gal)',18.93,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(2,'Ball Lock (2.5 gal)',9.46,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(3,'Ball Lock (3 gal)',11.36,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(4,'Ball Lock (10 gal)',37.85,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(5,'Pin Lock (5 gal)',18.93,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(6,'Sanke (1/6 bbl)',19.53,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(7,'Sanke (1/4 bbl)',29.34,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(8,'Sanke (slim 1/4 bbl)',29.34,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(9,'Sanke (1/2 bbl)',58.67,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(10,'Sanke (Euro)',49.97,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(11,'Cask (pin)',40.92,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(12,'Cask (firkin)',40.92,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(13,'Cask (kilderkin)',81.84,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(14,'Cask (barrel)',163.64,'2014-03-02 20:47:20','2014-03-02 20:47:20'),(15,'Cask (hogshead)',245.48,'2014-03-02 20:47:20','2014-03-02 20:47:20');
/*!40000 ALTER TABLE `kegtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pours`
--

DROP TABLE IF EXISTS `pours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tapId` int(11) NOT NULL,
  `amountPoured` decimal(6,1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `batchId` int(11) NOT NULL,
  `pinAddress` varchar(255) NOT NULL,
  `pulseCount` int(11) NOT NULL,
  `pulsesPerLiter` int(11) NOT NULL,
  `liters` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tapId` (`tapId`),
  KEY `FK_pours_batchId` (`batchId`),
  KEY `FK_pours_pinAddress` (`pinAddress`),
  CONSTRAINT `FK_pours_batchId` FOREIGN KEY (`batchId`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_pours_pinAddress` FOREIGN KEY (`pinAddress`) REFERENCES `taps` (`pinAddress`) ON DELETE CASCADE,
  CONSTRAINT `pours_ibfk_1` FOREIGN KEY (`tapId`) REFERENCES `taps` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pours`
--

LOCK TABLES `pours` WRITE;
/*!40000 ALTER TABLE `pours` DISABLE KEYS */;
/*!40000 ALTER TABLE `pours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `srmrgb`
--

DROP TABLE IF EXISTS `srmrgb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `srmrgb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `srm` decimal(3,1) NOT NULL,
  `rgb` varchar(12) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `srm_UNIQUE` (`srm`)
) ENGINE=InnoDB AUTO_INCREMENT=402 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `srmrgb`
--

LOCK TABLES `srmrgb` WRITE;
/*!40000 ALTER TABLE `srmrgb` DISABLE KEYS */;
INSERT INTO `srmrgb` VALUES (1,0.0,'252,252,243','2014-03-02 20:47:20','2014-03-02 20:47:20'),(2,0.1,'248,248,230','2014-03-02 20:47:20','2014-03-02 20:47:20'),(3,0.2,'248,248,220','2014-03-02 20:47:20','2014-03-02 20:47:20'),(4,0.3,'247,247,199','2014-03-02 20:47:20','2014-03-02 20:47:20'),(5,0.4,'244,249,185','2014-03-02 20:47:20','2014-03-02 20:47:20'),(6,0.5,'247,249,180','2014-03-02 20:47:20','2014-03-02 20:47:20'),(7,0.6,'248,249,178','2014-03-02 20:47:20','2014-03-02 20:47:20'),(8,0.7,'244,246,169','2014-03-02 20:47:20','2014-03-02 20:47:20'),(9,0.8,'245,247,166','2014-03-02 20:47:20','2014-03-02 20:47:20'),(10,0.9,'246,247,156','2014-03-02 20:47:20','2014-03-02 20:47:20'),(11,1.0,'243,249,147','2014-03-02 20:47:20','2014-03-02 20:47:20'),(12,1.1,'246,248,141','2014-03-02 20:47:20','2014-03-02 20:47:20'),(13,1.2,'246,249,136','2014-03-02 20:47:20','2014-03-02 20:47:20'),(14,1.3,'245,250,128','2014-03-02 20:47:20','2014-03-02 20:47:20'),(15,1.4,'246,249,121','2014-03-02 20:47:20','2014-03-02 20:47:20'),(16,1.5,'248,249,114','2014-03-02 20:47:20','2014-03-02 20:47:20'),(17,1.6,'243,249,104','2014-03-02 20:47:20','2014-03-02 20:47:20'),(18,1.7,'246,248,107','2014-03-02 20:47:20','2014-03-02 20:47:20'),(19,1.8,'248,247,99','2014-03-02 20:47:20','2014-03-02 20:47:20'),(20,1.9,'245,247,92','2014-03-02 20:47:20','2014-03-02 20:47:20'),(21,2.0,'248,247,83','2014-03-02 20:47:20','2014-03-02 20:47:20'),(22,2.1,'244,248,72','2014-03-02 20:47:20','2014-03-02 20:47:20'),(23,2.2,'248,247,73','2014-03-02 20:47:20','2014-03-02 20:47:20'),(24,2.3,'246,247,62','2014-03-02 20:47:20','2014-03-02 20:47:20'),(25,2.4,'241,248,53','2014-03-02 20:47:20','2014-03-02 20:47:20'),(26,2.5,'244,247,48','2014-03-02 20:47:20','2014-03-02 20:47:20'),(27,2.6,'246,249,40','2014-03-02 20:47:20','2014-03-02 20:47:20'),(28,2.7,'243,249,34','2014-03-02 20:47:20','2014-03-02 20:47:20'),(29,2.8,'245,247,30','2014-03-02 20:47:20','2014-03-02 20:47:20'),(30,2.9,'248,245,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(31,3.0,'246,245,19','2014-03-02 20:47:20','2014-03-02 20:47:20'),(32,3.1,'244,242,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(33,3.2,'244,240,21','2014-03-02 20:47:20','2014-03-02 20:47:20'),(34,3.3,'243,242,19','2014-03-02 20:47:20','2014-03-02 20:47:20'),(35,3.4,'244,238,24','2014-03-02 20:47:20','2014-03-02 20:47:20'),(36,3.5,'244,237,29','2014-03-02 20:47:20','2014-03-02 20:47:20'),(37,3.6,'238,233,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(38,3.7,'240,233,23','2014-03-02 20:47:20','2014-03-02 20:47:20'),(39,3.8,'238,231,25','2014-03-02 20:47:20','2014-03-02 20:47:20'),(40,3.9,'234,230,21','2014-03-02 20:47:20','2014-03-02 20:47:20'),(41,4.0,'236,230,26','2014-03-02 20:47:20','2014-03-02 20:47:20'),(42,4.1,'230,225,24','2014-03-02 20:47:20','2014-03-02 20:47:20'),(43,4.2,'232,225,25','2014-03-02 20:47:20','2014-03-02 20:47:20'),(44,4.3,'230,221,27','2014-03-02 20:47:20','2014-03-02 20:47:20'),(45,4.4,'224,218,23','2014-03-02 20:47:20','2014-03-02 20:47:20'),(46,4.5,'229,216,31','2014-03-02 20:47:20','2014-03-02 20:47:20'),(47,4.6,'229,214,30','2014-03-02 20:47:20','2014-03-02 20:47:20'),(48,4.7,'223,213,26','2014-03-02 20:47:20','2014-03-02 20:47:20'),(49,4.8,'226,213,28','2014-03-02 20:47:20','2014-03-02 20:47:20'),(50,4.9,'223,209,29','2014-03-02 20:47:20','2014-03-02 20:47:20'),(51,5.0,'224,208,27','2014-03-02 20:47:20','2014-03-02 20:47:20'),(52,5.1,'224,204,32','2014-03-02 20:47:20','2014-03-02 20:47:20'),(53,5.2,'221,204,33','2014-03-02 20:47:20','2014-03-02 20:47:20'),(54,5.3,'220,203,29','2014-03-02 20:47:20','2014-03-02 20:47:20'),(55,5.4,'218,200,32','2014-03-02 20:47:20','2014-03-02 20:47:20'),(56,5.5,'220,197,34','2014-03-02 20:47:20','2014-03-02 20:47:20'),(57,5.6,'218,196,41','2014-03-02 20:47:20','2014-03-02 20:47:20'),(58,5.7,'217,194,43','2014-03-02 20:47:20','2014-03-02 20:47:20'),(59,5.8,'216,192,39','2014-03-02 20:47:20','2014-03-02 20:47:20'),(60,5.9,'213,190,37','2014-03-02 20:47:20','2014-03-02 20:47:20'),(61,6.0,'213,188,38','2014-03-02 20:47:20','2014-03-02 20:47:20'),(62,6.1,'212,184,39','2014-03-02 20:47:20','2014-03-02 20:47:20'),(63,6.2,'214,183,43','2014-03-02 20:47:20','2014-03-02 20:47:20'),(64,6.3,'213,180,45','2014-03-02 20:47:20','2014-03-02 20:47:20'),(65,6.4,'210,179,41','2014-03-02 20:47:20','2014-03-02 20:47:20'),(66,6.5,'208,178,42','2014-03-02 20:47:20','2014-03-02 20:47:20'),(67,6.6,'208,176,46','2014-03-02 20:47:20','2014-03-02 20:47:20'),(68,6.7,'204,172,48','2014-03-02 20:47:20','2014-03-02 20:47:20'),(69,6.8,'204,172,52','2014-03-02 20:47:20','2014-03-02 20:47:20'),(70,6.9,'205,170,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(71,7.0,'201,167,50','2014-03-02 20:47:20','2014-03-02 20:47:20'),(72,7.1,'202,167,52','2014-03-02 20:47:20','2014-03-02 20:47:20'),(73,7.2,'201,166,51','2014-03-02 20:47:20','2014-03-02 20:47:20'),(74,7.3,'199,162,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(75,7.4,'198,160,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(76,7.5,'200,158,60','2014-03-02 20:47:20','2014-03-02 20:47:20'),(77,7.6,'194,156,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(78,7.7,'196,155,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(79,7.8,'198,151,60','2014-03-02 20:47:20','2014-03-02 20:47:20'),(80,7.9,'193,150,60','2014-03-02 20:47:20','2014-03-02 20:47:20'),(81,8.0,'191,146,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(82,8.1,'190,147,57','2014-03-02 20:47:20','2014-03-02 20:47:20'),(83,8.2,'190,147,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(84,8.3,'190,145,60','2014-03-02 20:47:20','2014-03-02 20:47:20'),(85,8.4,'186,148,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(86,8.5,'190,145,58','2014-03-02 20:47:20','2014-03-02 20:47:20'),(87,8.6,'193,145,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(88,8.7,'190,145,58','2014-03-02 20:47:20','2014-03-02 20:47:20'),(89,8.8,'191,143,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(90,8.9,'191,141,61','2014-03-02 20:47:20','2014-03-02 20:47:20'),(91,9.0,'190,140,58','2014-03-02 20:47:20','2014-03-02 20:47:20'),(92,9.1,'192,140,61','2014-03-02 20:47:20','2014-03-02 20:47:20'),(93,9.2,'193,138,62','2014-03-02 20:47:20','2014-03-02 20:47:20'),(94,9.3,'192,137,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(95,9.4,'193,136,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(96,9.5,'195,135,63','2014-03-02 20:47:20','2014-03-02 20:47:20'),(97,9.6,'191,136,58','2014-03-02 20:47:20','2014-03-02 20:47:20'),(98,9.7,'191,134,67','2014-03-02 20:47:20','2014-03-02 20:47:20'),(99,9.8,'193,131,67','2014-03-02 20:47:20','2014-03-02 20:47:20'),(100,9.9,'190,130,58','2014-03-02 20:47:20','2014-03-02 20:47:20'),(101,10.0,'191,129,58','2014-03-02 20:47:20','2014-03-02 20:47:20'),(102,10.1,'191,131,57','2014-03-02 20:47:20','2014-03-02 20:47:20'),(103,10.2,'191,129,58','2014-03-02 20:47:20','2014-03-02 20:47:20'),(104,10.3,'191,129,58','2014-03-02 20:47:20','2014-03-02 20:47:20'),(105,10.4,'190,129,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(106,10.5,'191,127,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(107,10.6,'194,126,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(108,10.7,'188,128,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(109,10.8,'190,124,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(110,10.9,'193,122,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(111,11.0,'190,124,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(112,11.1,'194,121,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(113,11.2,'193,120,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(114,11.3,'190,119,52','2014-03-02 20:47:20','2014-03-02 20:47:20'),(115,11.4,'182,117,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(116,11.5,'196,116,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(117,11.6,'191,118,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(118,11.7,'190,116,57','2014-03-02 20:47:20','2014-03-02 20:47:20'),(119,11.8,'191,115,58','2014-03-02 20:47:20','2014-03-02 20:47:20'),(120,11.9,'189,115,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(121,12.0,'191,113,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(122,12.1,'191,113,53','2014-03-02 20:47:20','2014-03-02 20:47:20'),(123,12.2,'188,112,57','2014-03-02 20:47:20','2014-03-02 20:47:20'),(124,12.3,'190,112,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(125,12.4,'184,110,52','2014-03-02 20:47:20','2014-03-02 20:47:20'),(126,12.5,'188,109,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(127,12.6,'189,109,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(128,12.7,'186,106,50','2014-03-02 20:47:20','2014-03-02 20:47:20'),(129,12.8,'190,103,52','2014-03-02 20:47:20','2014-03-02 20:47:20'),(130,12.9,'189,104,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(131,13.0,'188,103,51','2014-03-02 20:47:20','2014-03-02 20:47:20'),(132,13.1,'188,103,51','2014-03-02 20:47:20','2014-03-02 20:47:20'),(133,13.2,'186,101,51','2014-03-02 20:47:20','2014-03-02 20:47:20'),(134,13.3,'186,102,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(135,13.4,'185,100,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(136,13.5,'185,98,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(137,13.6,'183,98,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(138,13.7,'181,100,53','2014-03-02 20:47:20','2014-03-02 20:47:20'),(139,13.8,'182,97,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(140,13.9,'177,97,51','2014-03-02 20:47:20','2014-03-02 20:47:20'),(141,14.0,'178,96,51','2014-03-02 20:47:20','2014-03-02 20:47:20'),(142,14.1,'176,96,49','2014-03-02 20:47:20','2014-03-02 20:47:20'),(143,14.2,'177,96,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(144,14.3,'178,95,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(145,14.4,'171,94,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(146,14.5,'171,92,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(147,14.6,'172,93,59','2014-03-02 20:47:20','2014-03-02 20:47:20'),(148,14.7,'168,92,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(149,14.8,'169,90,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(150,14.9,'168,88,57','2014-03-02 20:47:20','2014-03-02 20:47:20'),(151,15.0,'165,89,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(152,15.1,'166,88,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(153,15.2,'165,88,58','2014-03-02 20:47:20','2014-03-02 20:47:20'),(154,15.3,'161,88,52','2014-03-02 20:47:20','2014-03-02 20:47:20'),(155,15.4,'163,85,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(156,15.5,'160,86,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(157,15.6,'158,85,57','2014-03-02 20:47:20','2014-03-02 20:47:20'),(158,15.7,'158,86,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(159,15.8,'159,84,57','2014-03-02 20:47:20','2014-03-02 20:47:20'),(160,15.9,'156,83,53','2014-03-02 20:47:20','2014-03-02 20:47:20'),(161,16.0,'152,83,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(162,16.1,'150,83,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(163,16.2,'150,81,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(164,16.3,'146,81,56','2014-03-02 20:47:20','2014-03-02 20:47:20'),(165,16.4,'147,79,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(166,16.5,'147,79,55','2014-03-02 20:47:20','2014-03-02 20:47:20'),(167,16.6,'146,78,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(168,16.7,'142,77,51','2014-03-02 20:47:20','2014-03-02 20:47:20'),(169,16.8,'143,79,53','2014-03-02 20:47:20','2014-03-02 20:47:20'),(170,16.9,'142,77,54','2014-03-02 20:47:20','2014-03-02 20:47:20'),(171,17.0,'141,76,50','2014-03-02 20:47:20','2014-03-02 20:47:20'),(172,17.1,'140,75,50','2014-03-02 20:47:20','2014-03-02 20:47:20'),(173,17.2,'138,73,49','2014-03-02 20:47:20','2014-03-02 20:47:20'),(174,17.3,'135,70,45','2014-03-02 20:47:20','2014-03-02 20:47:20'),(175,17.4,'136,71,49','2014-03-02 20:47:20','2014-03-02 20:47:20'),(176,17.5,'140,72,49','2014-03-02 20:47:20','2014-03-02 20:47:20'),(177,17.6,'128,70,45','2014-03-02 20:47:20','2014-03-02 20:47:20'),(178,17.7,'129,71,46','2014-03-02 20:47:20','2014-03-02 20:47:20'),(179,17.8,'130,69,47','2014-03-02 20:47:20','2014-03-02 20:47:20'),(180,17.9,'123,69,45','2014-03-02 20:47:20','2014-03-02 20:47:20'),(181,18.0,'124,69,45','2014-03-02 20:47:20','2014-03-02 20:47:20'),(182,18.1,'121,66,40','2014-03-02 20:47:20','2014-03-02 20:47:20'),(183,18.2,'120,67,40','2014-03-02 20:47:20','2014-03-02 20:47:20'),(184,18.3,'119,64,38','2014-03-02 20:47:20','2014-03-02 20:47:20'),(185,18.4,'116,63,34','2014-03-02 20:47:20','2014-03-02 20:47:20'),(186,18.5,'120,63,35','2014-03-02 20:47:20','2014-03-02 20:47:20'),(187,18.6,'120,62,37','2014-03-02 20:47:20','2014-03-02 20:47:20'),(188,18.7,'112,63,35','2014-03-02 20:47:20','2014-03-02 20:47:20'),(189,18.8,'111,62,36','2014-03-02 20:47:20','2014-03-02 20:47:20'),(190,18.9,'109,60,34','2014-03-02 20:47:20','2014-03-02 20:47:20'),(191,19.0,'107,58,30','2014-03-02 20:47:20','2014-03-02 20:47:20'),(192,19.1,'106,57,31','2014-03-02 20:47:20','2014-03-02 20:47:20'),(193,19.2,'107,56,31','2014-03-02 20:47:20','2014-03-02 20:47:20'),(194,19.3,'105,56,28','2014-03-02 20:47:20','2014-03-02 20:47:20'),(195,19.4,'105,56,28','2014-03-02 20:47:20','2014-03-02 20:47:20'),(196,19.5,'104,52,31','2014-03-02 20:47:20','2014-03-02 20:47:20'),(197,19.6,'102,53,27','2014-03-02 20:47:20','2014-03-02 20:47:20'),(198,19.7,'100,53,26','2014-03-02 20:47:20','2014-03-02 20:47:20'),(199,19.8,'99,52,25','2014-03-02 20:47:20','2014-03-02 20:47:20'),(200,19.9,'93,53,24','2014-03-02 20:47:20','2014-03-02 20:47:20'),(201,20.0,'93,52,26','2014-03-02 20:47:20','2014-03-02 20:47:20'),(202,20.1,'89,49,20','2014-03-02 20:47:20','2014-03-02 20:47:20'),(203,20.2,'90,50,21','2014-03-02 20:47:20','2014-03-02 20:47:20'),(204,20.3,'91,48,20','2014-03-02 20:47:20','2014-03-02 20:47:20'),(205,20.4,'83,48,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(206,20.5,'88,48,17','2014-03-02 20:47:20','2014-03-02 20:47:20'),(207,20.6,'86,46,17','2014-03-02 20:47:20','2014-03-02 20:47:20'),(208,20.7,'81,45,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(209,20.8,'83,44,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(210,20.9,'81,45,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(211,21.0,'78,42,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(212,21.1,'77,43,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(213,21.2,'75,41,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(214,21.3,'74,41,5','2014-03-02 20:47:20','2014-03-02 20:47:20'),(215,21.4,'78,40,23','2014-03-02 20:47:20','2014-03-02 20:47:20'),(216,21.5,'83,43,46','2014-03-02 20:47:20','2014-03-02 20:47:20'),(217,21.6,'78,43,41','2014-03-02 20:47:20','2014-03-02 20:47:20'),(218,21.7,'78,40,41','2014-03-02 20:47:20','2014-03-02 20:47:20'),(219,21.8,'76,41,41','2014-03-02 20:47:20','2014-03-02 20:47:20'),(220,21.9,'74,39,39','2014-03-02 20:47:20','2014-03-02 20:47:20'),(221,22.0,'74,39,39','2014-03-02 20:47:20','2014-03-02 20:47:20'),(222,22.1,'69,39,35','2014-03-02 20:47:20','2014-03-02 20:47:20'),(223,22.2,'70,37,37','2014-03-02 20:47:20','2014-03-02 20:47:20'),(224,22.3,'68,38,36','2014-03-02 20:47:20','2014-03-02 20:47:20'),(225,22.4,'64,35,34','2014-03-02 20:47:20','2014-03-02 20:47:20'),(226,22.5,'64,35,34','2014-03-02 20:47:20','2014-03-02 20:47:20'),(227,22.6,'62,33,32','2014-03-02 20:47:20','2014-03-02 20:47:20'),(228,22.7,'58,33,31','2014-03-02 20:47:20','2014-03-02 20:47:20'),(229,22.8,'61,33,31','2014-03-02 20:47:20','2014-03-02 20:47:20'),(230,22.9,'58,33,33','2014-03-02 20:47:20','2014-03-02 20:47:20'),(231,23.0,'54,31,27','2014-03-02 20:47:20','2014-03-02 20:47:20'),(232,23.1,'52,29,28','2014-03-02 20:47:20','2014-03-02 20:47:20'),(233,23.2,'52,29,28','2014-03-02 20:47:20','2014-03-02 20:47:20'),(234,23.3,'49,28,27','2014-03-02 20:47:20','2014-03-02 20:47:20'),(235,23.4,'48,27,26','2014-03-02 20:47:20','2014-03-02 20:47:20'),(236,23.5,'48,27,26','2014-03-02 20:47:20','2014-03-02 20:47:20'),(237,23.6,'44,25,25','2014-03-02 20:47:20','2014-03-02 20:47:20'),(238,23.7,'44,25,23','2014-03-02 20:47:20','2014-03-02 20:47:20'),(239,23.8,'42,24,26','2014-03-02 20:47:20','2014-03-02 20:47:20'),(240,23.9,'40,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(241,24.0,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(242,24.1,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(243,24.2,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(244,24.3,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(245,24.4,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(246,24.5,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(247,24.6,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(248,24.7,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(249,24.8,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(250,24.9,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(251,25.0,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(252,25.1,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(253,25.2,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(254,25.3,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(255,25.4,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(256,25.5,'38,23,22','2014-03-02 20:47:20','2014-03-02 20:47:20'),(257,25.6,'38,23,24','2014-03-02 20:47:20','2014-03-02 20:47:20'),(258,25.7,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(259,25.8,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(260,25.9,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(261,26.0,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(262,26.1,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(263,26.2,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(264,26.3,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(265,26.4,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(266,26.5,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(267,26.6,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(268,26.7,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(269,26.8,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(270,26.9,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(271,27.0,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(272,27.1,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(273,27.2,'25,16,15','2014-03-02 20:47:20','2014-03-02 20:47:20'),(274,27.3,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(275,27.4,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(276,27.5,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(277,27.6,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(278,27.7,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(279,27.8,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(280,27.9,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(281,28.0,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(282,28.1,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(283,28.2,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(284,28.3,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(285,28.4,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(286,28.5,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(287,28.6,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(288,28.7,'17,13,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(289,28.8,'18,13,12','2014-03-02 20:47:20','2014-03-02 20:47:20'),(290,28.9,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(291,29.0,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(292,29.1,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(293,29.2,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(294,29.3,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(295,29.4,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(296,29.5,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(297,29.6,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(298,29.7,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(299,29.8,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(300,29.9,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(301,30.0,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(302,30.1,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(303,30.2,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(304,30.3,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(305,30.4,'16,11,10','2014-03-02 20:47:20','2014-03-02 20:47:20'),(306,30.5,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(307,30.6,'15,10,9','2014-03-02 20:47:20','2014-03-02 20:47:20'),(308,30.7,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(309,30.8,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(310,30.9,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(311,31.0,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(312,31.1,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(313,31.2,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(314,31.3,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(315,31.4,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(316,31.5,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(317,31.6,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(318,31.7,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(319,31.8,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(320,31.9,'14,9,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(321,32.0,'15,11,8','2014-03-02 20:47:20','2014-03-02 20:47:20'),(322,32.1,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(323,32.2,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(324,32.3,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(325,32.4,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(326,32.5,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(327,32.6,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(328,32.7,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(329,32.8,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(330,32.9,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(331,33.0,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(332,33.1,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(333,33.2,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(334,33.3,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(335,33.4,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(336,33.5,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(337,33.6,'12,9,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(338,33.7,'10,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(339,33.8,'10,7,5','2014-03-02 20:47:20','2014-03-02 20:47:20'),(340,33.9,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(341,34.0,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(342,34.1,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(343,34.2,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(344,34.3,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(345,34.4,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(346,34.5,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(347,34.6,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(348,34.7,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(349,34.8,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(350,34.9,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(351,35.0,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(352,35.1,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(353,35.2,'8,7,7','2014-03-02 20:47:20','2014-03-02 20:47:20'),(354,35.3,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(355,35.4,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(356,35.5,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(357,35.6,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(358,35.7,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(359,35.8,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(360,35.9,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(361,36.0,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(362,36.1,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(363,36.2,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(364,36.3,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(365,36.4,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(366,36.5,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(367,36.6,'7,6,6','2014-03-02 20:47:20','2014-03-02 20:47:20'),(368,36.7,'7,7,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(369,36.8,'6,6,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(370,36.9,'6,5,5','2014-03-02 20:47:20','2014-03-02 20:47:20'),(371,37.0,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(372,37.1,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(373,37.2,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(374,37.3,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(375,37.4,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(376,37.5,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(377,37.6,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(378,37.7,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(379,37.8,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(380,37.9,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(381,38.0,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(382,38.1,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(383,38.2,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(384,38.3,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(385,38.4,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(386,38.5,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(387,38.6,'4,5,4','2014-03-02 20:47:20','2014-03-02 20:47:20'),(388,38.7,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(389,38.8,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(390,38.9,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(391,39.0,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(392,39.1,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(393,39.2,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(394,39.3,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(395,39.4,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(396,39.5,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(397,39.6,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(398,39.7,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(399,39.8,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(400,39.9,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20'),(401,40.0,'3,4,3','2014-03-02 20:47:20','2014-03-02 20:47:20');
/*!40000 ALTER TABLE `srmrgb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taps`
--

DROP TABLE IF EXISTS `taps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tapNumber` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `batchId` int(11) DEFAULT NULL,
  `pinAddress` varchar(255) DEFAULT NULL,
  `pulsesPerLiter` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pinAddress_UNIQUE` (`pinAddress`),
  KEY `FK_taps_batchId` (`batchId`),
  CONSTRAINT `FK_taps_batchId` FOREIGN KEY (`batchId`) REFERENCES `batches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taps`
--

LOCK TABLES `taps` WRITE;
/*!40000 ALTER TABLE `taps` DISABLE KEYS */;
INSERT INTO `taps` VALUES (16,1,1,'2014-03-02 20:47:26','2014-03-02 20:47:26',1,NULL,NULL),(17,2,0,'2014-03-18 20:19:24','2014-03-02 20:47:26',2,NULL,NULL),(18,3,1,'2014-03-02 20:47:26','2014-03-02 20:47:26',3,NULL,NULL),(19,4,1,'2014-03-02 20:47:26','2014-03-02 20:47:26',4,NULL,NULL),(20,5,1,'2014-03-02 20:47:26','2014-03-02 20:47:26',5,NULL,NULL),(21,6,1,'2014-03-02 20:47:26','2014-03-02 20:47:26',6,NULL,NULL),(22,7,1,'2014-03-02 20:47:26','2014-03-02 20:47:26',7,NULL,NULL),(23,8,1,'2014-03-02 20:47:26','2014-03-02 20:47:26',8,NULL,NULL),(24,9,0,'2014-03-14 20:45:09','2014-03-02 20:47:26',9,NULL,NULL),(25,10,1,'2014-03-02 20:47:26','2014-03-02 20:47:26',10,NULL,NULL);
/*!40000 ALTER TABLE `taps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(65) CHARACTER SET utf8 NOT NULL,
  `password` varchar(65) CHARACTER SET utf8 NOT NULL,
  `name` varchar(65) CHARACTER SET utf8 NOT NULL,
  `email` varchar(65) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$aXMUVUCJSBa0CkxVLkJPRu7buMMH32Qxj5MzUGotxMf4b/h3emQqK','jason','jasonunterman@gmail.com','2014-03-14 19:31:05','2014-03-14 23:31:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vwgetactivetaps`
--

DROP TABLE IF EXISTS `vwgetactivetaps`;
/*!50001 DROP VIEW IF EXISTS `vwgetactivetaps`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vwgetactivetaps` (
  `id` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `style` tinyint NOT NULL,
  `notes` tinyint NOT NULL,
  `ogAct` tinyint NOT NULL,
  `fgAct` tinyint NOT NULL,
  `srmAct` tinyint NOT NULL,
  `ibuAct` tinyint NOT NULL,
  `startLiter` tinyint NOT NULL,
  `litersPoured` tinyint NOT NULL,
  `remainAmount` tinyint NOT NULL,
  `tapNumber` tinyint NOT NULL,
  `srmRgb` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vwgettapsamountpoured`
--

DROP TABLE IF EXISTS `vwgettapsamountpoured`;
/*!50001 DROP VIEW IF EXISTS `vwgettapsamountpoured`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vwgettapsamountpoured` (
  `batchId` tinyint NOT NULL,
  `litersPoured` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vwgetactivetaps`
--

/*!50001 DROP TABLE IF EXISTS `vwgetactivetaps`*/;
/*!50001 DROP VIEW IF EXISTS `vwgetactivetaps`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vwgetactivetaps` AS select `t`.`id` AS `id`,`be`.`name` AS `name`,`bs`.`name` AS `style`,`be`.`notes` AS `notes`,`ba`.`ogAct` AS `ogAct`,`ba`.`fgAct` AS `fgAct`,`ba`.`srmAct` AS `srmAct`,`ba`.`ibuAct` AS `ibuAct`,`ba`.`startLiter` AS `startLiter`,ifnull(`p`.`litersPoured`,0) AS `litersPoured`,(`ba`.`startLiter` - ifnull(`p`.`litersPoured`,0)) AS `remainAmount`,`t`.`tapNumber` AS `tapNumber`,`s`.`rgb` AS `srmRgb` from (((((`taps` `t` left join `batches` `ba` on((`ba`.`id` = `t`.`batchId`))) left join `beers` `be` on((`be`.`id` = `ba`.`beerId`))) left join `beerstyles` `bs` on((`bs`.`id` = `be`.`beerStyleId`))) left join `srmrgb` `s` on((`s`.`srm` = `ba`.`srmAct`))) left join `vwgettapsamountpoured` `p` on((`p`.`batchId` = `ba`.`id`))) where (`t`.`active` = 1) order by `t`.`tapNumber` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vwgettapsamountpoured`
--

/*!50001 DROP TABLE IF EXISTS `vwgettapsamountpoured`*/;
/*!50001 DROP VIEW IF EXISTS `vwgettapsamountpoured`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vwgettapsamountpoured` AS select `pours`.`batchId` AS `batchId`,sum(`pours`.`liters`) AS `litersPoured` from `pours` group by `pours`.`batchId` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-21 14:53:41
