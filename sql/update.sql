CREATE TABLE IF NOT EXISTS `tapconfig` (
  `tapId` int(11) NOT NULL,
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

INSERT IGNORE INTO tapconfig (tapId)
(SELECT id from taps);

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

INSERT IGNORE INTO `bottleTypes` ( displayName, volume, total, used, createdDate, modifiedDate ) VALUES
( 'standard (12oz)', '12.0', '40', '0', NOW(), NOW() ),
( 'flip top (16oz)', '16.0', '5', '0', NOW(), NOW() );


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


CREATE TABLE IF NOT EXISTS `breweries` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`imageUrl` varchar(2000),
	`active` tinyint(1) NOT NULL DEFAULT 1,

	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `userRfids` (
	`userId` int(11) NOT NULL,
	`RFID` varchar(128) CHARACTER SET utf8 NOT NULL,
	`description` varchar(65) CHARACTER SET utf8 NULL,
	PRIMARY KEY (`userId`, `RFID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`)  
SELECT 'showVerticleTapList', '0', 'Show the Tap List Vertically (ON = YES)', '1', NOW(), NOW() FROM DUAL 
    WHERE NOT EXISTS (SELECT configName from `config` WHERE configName = 'showVerticleTapList');
 
CREATE TABLE IF NOT EXISTS `rfidReaders` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NULL,
	`type` int(11) NOT NULL,
	`pin` int(11) NULL,
	`priority` int(11) NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

INSERT IGNORE INTO rfidReaders(`name`, `type`, `pin`, `priority`)
(SELECT 'Default', 0, configValue, 1 FROM `config` WHERE `configName` = 'rfidSSPin');
DELETE FROM `config` WHERE `configName` = 'rfidSSPin';
DELETE FROM `config` WHERE `configName` = 'useRFID';

DROP PROCEDURE IF EXISTS addColumnIfNotExist;
DELIMITER //
CREATE PROCEDURE `addColumnIfNotExist` (dbname tinytext, tableName tinytext, columnName tinytext, columnType tinytext)
BEGIN
	SET @preparedStatement = (
        SELECT IF(
          (
            SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
            WHERE
              (lower(table_name) = lower(tablename))
              AND (table_schema = dbname)
              AND (lower(column_name) = lower(replace(columnname,'`','')))
          ) > 0,
          CONCAT("select '",dbname,"','",tableName,"','",columnName,"','",columnType,"','exists'"),
          CONCAT("ALTER TABLE ", tablename, " ADD ", columnname, " ", columnType)
        )
    );
	PREPARE alterIfNotExists FROM @preparedStatement;
	EXECUTE alterIfNotExists;
	DEALLOCATE PREPARE alterIfNotExists;
END//
DELIMITER ;

CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'valvePinState', 'INT(11)' );
CALL addColumnIfNotExist(DATABASE(), 'users', 'nameFirst', 'varchar(65) CHARACTER SET utf8 NULL' );
CALL addColumnIfNotExist(DATABASE(), 'users', 'nameLast', 'varchar(65) CHARACTER SET utf8 NULL' );
CALL addColumnIfNotExist(DATABASE(), 'users', 'mugId', 'text NULL' );
CALL addColumnIfNotExist(DATABASE(), 'users', 'unTapAccessToken', 'text NULL' );
CALL addColumnIfNotExist(DATABASE(), 'users', 'isAdmin', 'tinyint(1) NOT NULL DEFAULT 0' );
-- --------------------------------------------------------


INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES
('use3WireValves', '0', 'Use Three Wire Valves', 1, NOW(), NOW()),
('displayRowsSameHeight', '0', 'Display all tap rows as the same height', '1', NOW(), NOW());

CREATE TABLE IF NOT EXISTS `motionDetectors` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NULL,
	`type` int(11) NOT NULL DEFAULT 0,
	`pin` int(11) NULL,
	`priority` int(11) NULL DEFAULT 0,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

UPDATE `config` SET `configValue` = '3.0.0.0' WHERE `configName` = 'version';

CREATE TABLE IF NOT EXISTS `ioPins` (
	`shield` varchar(30) NOT NULL,
  `pin` int(11) NOT NULL,
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


INSERT IGNORE INTO ioPins ( shield, pin, name, col, `row`, rgb, pinSide, notes, createdDate, modifiedDate ) VALUES
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
('Alamode', 13, 'SCK/LED', 2, 4, '', 'left', 'Triggering LED will interfer with SPI', NOW(),NOW()),
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
UPDATE ioPins SET displayPin=pin WHERE shield <> '' AND pin > 0;


set @var=if((SELECT TRUE FROM information_schema.TABLE_CONSTRAINTS WHERE
            CONSTRAINT_SCHEMA = DATABASE() AND
            TABLE_NAME        = 'taps' AND
            CONSTRAINT_NAME   = 'taps_ibfk_1' AND
            CONSTRAINT_TYPE   = 'FOREIGN KEY') = true,'ALTER TABLE taps
            DROP FOREIGN KEY taps_ibfk_1','select 1');

prepare stmt from @var;
execute stmt;
deallocate prepare stmt;


SET @preparedStatement = (
      SELECT IF(
        (
          SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
          WHERE
            (lower(table_name) = lower("taps"))
            AND (lower(table_schema) = lower(DATABASE()))
            AND (lower(column_name) = lower("beerId"))
        ) = 0,
        "SELECT 1",
        "ALTER TABLE `taps` DROP COLUMN `beerId`, DROP INDEX `beerId`"
      )
  );
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

CALL addColumnIfNotExist(DATABASE(), 'taps', 'tapRgba', 'varchar(16) NULL' );

CALL addColumnIfNotExist(DATABASE(), 'kegs', 'onTapId', 'int(11) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'beerId', 'int(11) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'fermentationPSI', 'decimal(6, 2)' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'keggingTemp', 'decimal(6, 2)' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellCmdPin', 'int(11)' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellRspPin', 'int(11)' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellTareReq', 'int(11)' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellScaleRatio', 'int(11)' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellTareOffset', 'int(11)' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellTareDate', 'TIMESTAMP NULL' );
CALL addColumnIfNotExist(DATABASE(), 'kegTypes', 'emptyWeight', 'decimal(11, 4)' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'emptyWeight', 'decimal(11, 4)' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'maxVolume', 'decimal(11, 4)' );

CALL addColumnIfNotExist(DATABASE(), 'beers', 'untID', 'int(10) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'breweryId', 'int(11)' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'abv', 'decimal(3,1) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'og', 'decimal(7,3) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'fg', 'decimal(7,3) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'srm', 'decimal(7,1) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'ibu', 'int(4) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'rating', 'decimal(3,1) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'active', 'tinyint(1) NULL DEFAULT 1' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'createdDate', 'TIMESTAMP NULL' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'modifiedDate', 'TIMESTAMP NULL' );

CALL addColumnIfNotExist(DATABASE(), 'beerStyles', 'beerStyleList', 'tinytext NOT NULL' );

CALL addColumnIfNotExist(DATABASE(), 'pours', 'userId', 'int(11) NOT NULL' );
CALL addColumnIfNotExist(DATABASE(), 'pours', 'beerId', 'int(11) NOT NULL' );
CALL addColumnIfNotExist(DATABASE(), 'pours', 'pinId', 'int(11) NOT NULL' );
CALL addColumnIfNotExist(DATABASE(), 'pours', 'pulses', 'int(11) NOT NULL' );
CALL addColumnIfNotExist(DATABASE(), 'pours', 'conversion', 'int(11) NOT NULL' );

UPDATE `kegTypes` SET emptyWeight =  '8.1571'  WHERE id > 0 AND displayName = 'Ball Lock (5 gal)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '4.0786'  WHERE id > 0 AND displayName = 'Ball Lock (2.5 gal)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '4.8943'  WHERE id > 0 AND displayName = 'Ball Lock (3 gal)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '16.3142' WHERE id > 0 AND displayName = 'Ball Lock (10 gal)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '8.1571'  WHERE id > 0 AND displayName = 'Pin Lock (5 gal)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '9.9'     WHERE id > 0 AND displayName = 'Sanke (1/6 bbl)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '14.85'   WHERE id > 0 AND displayName = 'Sanke (1/4 bbl)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '14.85'   WHERE id > 0 AND displayName = 'Sanke (slim 1/4 bbl)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '29.7'    WHERE id > 0 AND displayName = 'Sanke (1/2 bbl)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE id > 0 AND displayName = 'Sanke (Euro)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE id > 0 AND displayName = 'Cask (pin)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE id > 0 AND displayName = 'Cask (firkin)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE id > 0 AND displayName = 'Cask (kilderkin)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE id > 0 AND displayName = 'Cask (barrel)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE id > 0 AND displayName = 'Cask (hogshead)' AND emptyWeight IS NULL;
 
INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES
( 'useKegWeightCalc', '1', 'Show weight calc columns', '1', NOW(), NOW() ),
( 'useDefWeightSettings', '0', 'Do not allow individual tap configurations', '1', NOW(), NOW() ),
( 'breweryAltitude', '0', 'Feet Above Sea Level', '0', NOW(), NOW() ),
( 'breweryAltitudeUnit', 'ft', '', '0', NOW(), NOW() ),
( 'defaultFermPSI', '0', 'Default pressure of fermentation (0 if not pressure ferment)', '0', NOW(), NOW() ),
( 'defaultKeggingTemp', '56', 'Default Temperature of beer when kegging', '0', NOW(), NOW() ),
( 'defaultKeggingTempUnit', 'F', 'Default Temperature Unit of beer when kegging', '0', NOW(), NOW() );

CREATE TABLE IF NOT EXISTS `tempProbes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`type` int(11) NOT NULL,
	`pin` int(11),
	`notes` text NULL,
	`manualAdj` decimal(4,2) NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tempLog` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
    `probe` text NULL,
	`temp` decimal(4,2) NOT NULL,
	`humidity` decimal(4,2) NULL,
	`takenDate` TIMESTAMP NOT NULL,	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;


INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES
('useTempProbes', '0', 'Use Temperature Probes', 0, NOW(), NOW() ),
('tempProbeDelay', '1', 'Seconds between checking temp Probes', 0, NOW(), NOW() ),
('tempProbeBoundLow', '0', 'Lower bound of valid Temperature', 0, NOW(), NOW() ),
('tempProbeBoundHigh', '212', 'High bound of valid Temperature', 0, NOW(), NOW() ),
('showTempOnMainPage', '1', 'Show Avg Temperature on home page', 1, NOW(), NOW() );

ALTER TABLE taps CHANGE COLUMN `tapNumber` `tapNumber` INT(11) NULL ;
ALTER TABLE taps CHANGE COLUMN `kegId` `kegId` INT(11) NULL ;

CALL addColumnIfNotExist(DATABASE(), 'kegs', 'startAmount', 'decimal(7, 5)' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'currentAmount', 'decimal(7, 5)' );

SET @preparedStatement = (
      SELECT IF(
        (
          SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
          WHERE
            (lower(table_name) = lower("taps"))
            AND (lower(table_schema) = lower(DATABASE()))
            AND (lower(column_name) = lower("startAmount"))
        ) = 0,
        "SELECT 1",
        "UPDATE kegs k INNER JOIN taps t ON k.onTapId = t.id SET k.startAmount = t.startAmount, k.currentAmount = t.currentAmount WHERE k.id > 0 AND k.startAmount IS NULl AND k.currentAmount IS NULL"
      )
  );
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;
SET @preparedStatement = (
      SELECT IF(
        (
          SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
          WHERE
            (lower(table_name) = lower("taps"))
            AND (lower(table_schema) = lower(DATABASE()))
            AND (lower(column_name) = lower("fermentationPSI"))
        ) = 0,
        "SELECT 1",
        "UPDATE kegs k INNER JOIN tapconfig t ON k.onTapId = t.tapId SET k.fermentationPSI = t.fermentationPSI WHERE k.fermentationPSI IS NULL"
      )
  );
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;



INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES
( 'allowSamplePour', '1', 'Allow Sample Pour from List', '1', NOW(), NOW() );

INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES
('restartFanAfterPour', '1', 'Restart Fan After pour', 0, NOW(), NOW() );

  update config set showOnPanel = '1' WHERE configName = 'showPourDate';

CREATE TABLE IF NOT EXISTS `tapEvents` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `tapId` int(11) NOT NULL,
  `kegId` int(11) NOT NULL,
  `beerId` int(11) NOT NULL,
  `amount` decimal(7,5) DEFAULT NULL,
  `userId` int(11) NOT NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;

ALTER TABLE tempLog CHANGE COLUMN `temp` `temp` decimal(6,2) NULL ;
ALTER TABLE tempLog CHANGE COLUMN `humidity` `humidity` decimal(6,2) NULL ;


CALL addColumnIfNotExist(DATABASE(), 'config', 'validation', 'varchar(65)' );


INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `validation`, `createdDate`, `modifiedDate`) VALUES
( 'displayUnitVolume', 'oz', 'Volume Units', '0', 'Imperial;oz|Metric;ml', NOW(), NOW() ),
( 'displayUnitPressure', 'psi', 'Pressure Units', '0', 'psi|Pa', NOW(), NOW() ),
( 'displayUnitDistance', 'ft', 'Distance Units', '0', 'ft|m', NOW(), NOW() ),
( 'displayUnitGravity', 'sg', 'Gravity Units', '0', 'sg|b|p', NOW(), NOW() ),
( 'displayUnitTemperature', 'F', 'Temperature Units', '0', 'F|C', NOW(), NOW() ),
( 'displayUnitWeight', 'lb', 'Weight Units', '0', 'lb|kg', NOW(), NOW() ),
( 'defaultFermPSIUnit', 'psi', 'Default pressure of fermentation Unit', '0', NULL, NOW(), NOW() ),
( 'defaultKeggingTempUnit', 'F', 'Default Temperature Unit of beer when kegging', '0', NULL, NOW(), NOW() );


CALL addColumnIfNotExist(DATABASE(), 'beers', 'ogUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'beers', 'fgUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'weightUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'emptyWeightUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'maxVolumeUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'startAmountUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'currentAmountUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'fermentationPSIUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'keggingTempUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'kegTypes', 'maxAmountUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'kegTypes', 'emptyWeightUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'pours', 'amountPouredUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'yeasts', 'minTempUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'yeasts', 'maxTempUnit', 'tinytext' );
UPDATE pours set amountPouredUnit = 'oz' WHERE id > 0 AND amountPouredUnit IS NULL;
CALL addColumnIfNotExist(DATABASE(), 'tempLog', 'tempUnit', 'varchar(1) null' );
UPDATE tempLog set tempUnit = 'F' WHERE id > 0 AND tempUnit IS NULL;
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'countUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellUnit', 'tinytext DEFAULT NULL' );
CALL addColumnIfNotExist(DATABASE(), 'bottleTypes', 'volumeUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'tapEvents', 'amountUnit', 'tinytext' );

UPDATE tapconfig set countUnit = 'oz' WHERE tapid > 0 AND countUnit IS NULL;
UPDATE tapconfig set loadCellUnit = 'lb' WHERE tapid > 0 AND loadCellUnit IS NULL;
UPDATE beers set ogUnit = 'sg', fgUnit = 'sg' WHERE id > 0 AND ogUnit IS NULL;
UPDATE kegs SET weightUnit ='lb' WHERE id > 0 AND weightUnit IS NULL;
UPDATE kegs SET emptyWeightUnit ='lb' WHERE id > 0 AND emptyWeightUnit IS NULL;
UPDATE kegs SET maxVolumeUnit ='oz' WHERE id > 0 AND maxVolumeUnit IS NULL;
UPDATE kegs SET startAmountUnit ='oz' WHERE id > 0 AND startAmountUnit IS NULL;
UPDATE kegs SET currentAmountUnit ='oz' WHERE id > 0 AND currentAmountUnit IS NULL;
UPDATE kegs SET fermentationPSIUnit ='psi' WHERE id > 0 AND fermentationPSIUnit IS NULL;
UPDATE kegs SET keggingTempUnit = 'F' WHERE id > 0 AND keggingTempUnit IS NULL;
				
UPDATE kegTypes SET maxAmountUnit = 'oz', emptyWeightUnit = 'lb' WHERE id > 0 AND emptyWeightUnit IS NULL;
UPDATE pours set amountPouredUnit = 'gal' WHERE id > 0 AND amountPouredUnit IS NULL;
UPDATE yeasts set minTempUnit = 'F', maxTempUnit = 'F' WHERE id > 0 AND maxTempUnit IS NULL;
UPDATE tempLog set tempUnit = 'F' WHERE id > 0 AND tempUnit IS NULL;
UPDATE bottleTypes set volumeUnit = 'oz' WHERE id > 0 AND volumeUnit IS NULL;
UPDATE tapEvents set amountUnit = 'gal' WHERE id > 0 AND amountUnit IS NULL;

ALTER TABLE beers CHANGE COLUMN `og` `og` decimal(7,3) NULL ;
ALTER TABLE beers CHANGE COLUMN `fg` `fg` decimal(7,3) NULL ;
ALTER TABLE kegs CHANGE COLUMN `startAmount` `startAmount` decimal(10,5) NULL ;
ALTER TABLE kegs CHANGE COLUMN `currentAmount` `currentAmount` decimal(10,5) NULL ;
ALTER TABLE kegs CHANGE COLUMN `fermentationPSI` `fermentationPSI` decimal(14,2) NULL ;
ALTER TABLE pours CHANGE COLUMN `amountPoured` `amountPoured` decimal(9,7) NULL ;



	
UPDATE `config` SET `configValue` = '3.0.9.0' WHERE `configName` = 'version';


INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
							( 'repo', '1', 'The Repo Option from install', '0', NOW(), NOW() );
												
INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
							( 'showLastPour', '0', 'Show the Last Pour in Upper Right Corner instead of temp', '1', NOW(), NOW() );
UPDATE config SET displayName = 'Show the Last Pour in Upper Right Corner' WHERE configName = 'showLastPour';
							
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

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'saveNonUserRfids', '1', 'If unknown RFID tags should be saved into the database', '1', NOW(), NOW() );

INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES
('TapNumColNum', '1', 'Column number for Tap Number', 1, NOW(), NOW() ),
('SrmColNum', '2', 'Column number for SRM', 1, NOW(), NOW() ),
('IbuColNum', '3', 'Column number for IBU', 1, NOW(), NOW() ),
('BeerInfoColNum', '4', 'Column number for Beer Info', 1, NOW(), NOW() ),
('AbvColNum', '5', 'Column number for ABV', 1, NOW(), NOW() ),
('KegColNum', '6', 'Column number for Keg', 1, NOW(), NOW() );

UPDATE config  SET displayName='Show Tap List Direction', validation='Vertical|Horizontal' WHERE configName = 'showVerticleTapList';

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showAbvTxtWImg', '1', 'Show ABV Text If Image is shown', '1', NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showBeerTableHead', '1', 'Show the Title Bar on Beer List', '1', NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showPourListOnHome', '1', 'Show list of pours on home screen', '1', NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, validation, createdDate, modifiedDate ) VALUES
( 'relayTrigger', '0', 'Show list of pours on home screen', '0', 'High|Low', NOW(), NOW() ),
( 'hozTapListCol', '0', 'Number Of horizontal tap List Beer Column', '1', '2|1', NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'usePlaato', '0', 'Use Plaato Values', '1', NOW(), NOW() ),
( 'usePlaatoTemp', '0', 'Use Plaato Temp', '1', NOW(), NOW() );


CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'plaatoAuthToken', 'tinytext NULL' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellScaleRatio', 'int(11) DEFAULT NULL' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellTareOffset', 'int(11) DEFAULT NULL' );

CALL addColumnIfNotExist(DATABASE(), 'kegs', 'hasContinuousLid', 'int(11) DEFAULT 0' );


INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showPouredValue', '1', 'Show Poured Value', '1', NOW(), NOW() );
INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showLastPouredValue', '1', 'Show Last Poured Value', '1', NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'amountPerPint', '0', 'Amount per pint. > 0 then display pints remaining', '0', NOW(), NOW() );



CREATE TABLE IF NOT EXISTS `accolades` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` tinytext NOT NULL,
	`type` tinytext NULL,
	`srm` decimal(3,1) NULL,
	`notes` text NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;
CALL addColumnIfNotExist(DATABASE(), 'accolades', '`rank`', 'int(11) DEFAULT NULL' );
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

INSERT IGNORE INTO accolades (id, name, type, srm, notes, createdDate, modifiedDate) VALUES('1','Gold','Medal','3.0','','2020-08-04 14:13:55','2020-08-04 14:14:34');
INSERT IGNORE INTO accolades (id, name, type, srm, notes, createdDate, modifiedDate) VALUES('2','Silver','Medal','4.2','','2020-08-04 14:14:34','2020-08-04 14:14:34');
INSERT IGNORE INTO accolades (id, name, type, srm, notes, createdDate, modifiedDate) VALUES('3','Bronze','Medal','9.6','','2020-08-04 14:14:34','2020-08-04 14:14:34');
INSERT IGNORE INTO accolades (id, name, type, srm, notes, createdDate, modifiedDate) VALUES('4','BOS','Medal','9.6','','2020-08-04 14:14:34','2020-08-04 14:14:34');
UPDATE accolades SET `rank` = id WHERE id > 0 AND `rank` IS NULL;

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
('AccoladeColNum', '7', 'Column number for Accolades', 0, NOW(), NOW() );
INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
('numAccoladeDisplay', '3', 'Number of Accolades to display in a row/column', 0, NOW(), NOW() );
DELETE FROM `config` WHERE configName = 'showAccoladeCol';

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

INSERT IGNORE INTO `containerTypes` ( id,displayName, volume, total, used, createdDate, modifiedDate ) VALUES
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
( 13,'wineglass', '16.0', '0', '0', NOW(), NOW() );

INSERT IGNORE INTO `containerTypes` ( id,displayName, volume, total, used, createdDate, modifiedDate ) VALUES
( 14,'flute', '16.0', '0', '0', NOW(), NOW() ),
( 15,'teku', '16.0', '0', '0', NOW(), NOW() ),
( 16,'thistle', '16.0', '0', '0', NOW(), NOW() );


CALL addColumnIfNotExist(DATABASE(), 'beers', 'containerId', 'int(11) NULL DEFAULT 1' );
CALL addColumnIfNotExist(DATABASE(), 'beerStyles', 'active', 'tinyint(1) NOT NULL DEFAULT 1' );
CALL addColumnIfNotExist(DATABASE(), 'beerStyles', 'ogMinUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'beerStyles', 'ogMaxUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'beerStyles', 'fgMinUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'beerStyles', 'fgMaxUnit', 'tinytext' );

UPDATE beerStyles SET ogMinUnit='sg' WHERE id > 0 AND ogMinUnit IS NULL;
UPDATE beerStyles SET ogMaxUnit='sg' WHERE id > 0 AND ogMaxUnit IS NULL;
UPDATE beerStyles SET fgMinUnit='sg' WHERE id > 0 AND fgMinUnit IS NULL;
UPDATE beerStyles SET fgMaxUnit='sg' WHERE id > 0 AND fgMaxUnit IS NULL;

ALTER TABLE beerStyles MODIFY srmMin decimal(7,1) NOT NULL ;
ALTER TABLE beerStyles MODIFY srmMax decimal(7,1) NOT NULL ;
ALTER TABLE fermentables MODIFY srm DECIMAL(7,1) NOT NULL ;
ALTER TABLE srmRgb MODIFY srm DECIMAL(7,1) NOT NULL ;
ALTER TABLE accolades MODIFY srm DECIMAL(7,1) NOT NULL ;



INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'ABVColorSRM', '1', 'Use beers SRM color to fill in the ABV indicator', '1', NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'allowManualPours', '0', 'Allow Enter Of Manual Pours', '0', NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'updateDate', '', '', '0', NOW(), NOW() );
UPDATE `config` SET `configValue` = NOW(), showOnPanel=0 WHERE `configName` = 'updateDate';

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'ClientID', '','Client ID', '0', NOW(), NOW() ),
( 'ClientSecret','','Client Secret','0',NOW(),NOW() ),
( 'RedirectUri','','Redirect URI','0',NOW(),NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showUntappdBreweryFeed', '0', 'Show brewery Untappd feed above header', '0', NOW(), NOW() );

#CALL addColumnIfNotExist(DATABASE(), 'beerStyles', 'boardNumber', 'int(11) DEFAULT 0' );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'UpdateBatchWithKeg', '0', 'Update Batch amount when setting Keg', '1', NOW(), NOW() );


ALTER TABLE tapconfig CHANGE COLUMN `loadCellScaleRatio` `loadCellScaleRatio` float DEFAULT NULL ;
ALTER TABLE tapconfig CHANGE COLUMN `loadCellTareOffset` `loadCellTareOffset` float DEFAULT NULL ;

CALL addColumnIfNotExist(DATABASE(), 'tempProbes', 'statePin', 'int(11) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'tempLog', 'statePinState', 'int(11) NULL' );

CALL addColumnIfNotExist(DATABASE(), 'tapEvents', 'beerBatchId', 'int(11) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'tapEvents', 'beerBatchAmount', 'decimal(7,5) DEFAULT NULL' );
CALL addColumnIfNotExist(DATABASE(), 'tapEvents', 'beerBatchAmountUnit', 'tinytext NULL' );

CALL addColumnIfNotExist(DATABASE(), 'pours', 'beerBatchId', 'int(11) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'kegs', 'beerBatchId', 'int(11) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'bottles', 'beerBatchId', 'int(11) NULL' );

CALL addColumnIfNotExist(DATABASE(), 'motionDetectors', 'ledPin', 'INT(11)' );
CALL addColumnIfNotExist(DATABASE(), 'motionDetectors', 'soundFile', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'motionDetectors', 'mqttCommand', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'motionDetectors', 'mqttEvent', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'motionDetectors', 'mqttUser', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'motionDetectors', 'mqttPass', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'motionDetectors', 'mqttHost', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'motionDetectors', 'mqttPort', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'motionDetectors', 'mqttInterval', 'int(11) NOT NULL DEFAULT 100' );


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
	`og` decimal(4,3) NULL,
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

CREATE TABLE IF NOT EXISTS `beerBatchYeasts` (
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

CREATE TABLE IF NOT EXISTS `beerBatchDateTypes` (
  `type` int(11) NOT NULL AUTO_INCREMENT,
  `displayName` text NOT NULL,
  `createdDate` timestamp NULL DEFAULT NULL,
  `modifiedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT IGNORE INTO beerBatchDateTypes VALUES('1','Brewed','2021-01-21 09:56:22','2021-01-21 09:56:22');
INSERT IGNORE INTO beerBatchDateTypes VALUES('2','Primary','2021-01-21 09:56:22','2021-01-21 09:56:22');
INSERT IGNORE INTO beerBatchDateTypes VALUES('3','Secondary','2021-01-21 09:56:22','2021-01-21 09:56:22');
INSERT IGNORE INTO beerBatchDateTypes VALUES('4','Kegged','2021-01-21 09:56:22','2021-01-21 09:56:22');
INSERT IGNORE INTO beerBatchDateTypes VALUES('5','Bottle','2021-01-21 09:56:22','2021-01-21 09:56:22');
INSERT IGNORE INTO beerBatchDateTypes VALUES('6','Gone','2021-01-21 09:56:22','2021-01-21 09:56:22');
        
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


        
CREATE TABLE IF NOT EXISTS `iSpindel_Data` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`createdDate` datetime NOT NULL,
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
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`beerBatchId`) REFERENCES beerBatches(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin COMMENT='iSpindel Devices Data';

CALL addColumnIfNotExist(DATABASE(), 'iSpindel_Device', 'beerBatchId', 'INT(11)' );
set @var=if((SELECT TRUE FROM information_schema.TABLE_CONSTRAINTS WHERE
            CONSTRAINT_SCHEMA = DATABASE() AND
            TABLE_NAME        = 'iSpindel_Device' AND
            CONSTRAINT_NAME   = 'iSpindel_Device_ibfk_1' AND
            CONSTRAINT_TYPE   = 'FOREIGN KEY') = true,'ALTER TABLE iSpindel_Device
            drop foreign key iSpindel_Device_ibfk_1','select 1');

prepare stmt from @var;
execute stmt;
deallocate prepare stmt;


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

INSERT IGNORE INTO `fermenterTypes` (id, displayName, maxAmount, maxAmountUnit, emptyWeight, emptyWeightUnit, createdDate, modifiedDate ) VALUES
(1, 'Conical (5 gal)', '5', 'gal', '8.1571', 'lb', NOW(), NOW() ),
(2, 'Conical (10 gal)', '10', 'gal', '16.3142', 'lb', NOW(), NOW() ),
(3, 'Conical (15 gal)', '15', 'gal', '16.3142', 'lb', NOW(), NOW() ),
(4, 'Conical (30 gal)', '30', 'gal', '16.3142', 'lb', NOW(), NOW() ),
(5, 'Carboy (5 gal)', '5', 'gal', '8.1571', 'lb', NOW(), NOW() ),
(6, 'Carboy (6 gal)', '6', 'gal', '8.1571', 'lb', NOW(), NOW() ),
(7, 'Barrel (30 gal)', '30', 'gal', '8.1571', 'lb', NOW(), NOW() );

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

INSERT IGNORE INTO `fermenterStatuses` (code, name, createdDate, modifiedDate ) VALUES
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
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`fermenterStatusCode`) REFERENCES fermenterStatuses(`Code`) ON DELETE CASCADE,
	FOREIGN KEY (`fermenterTypeId`) REFERENCES fermenterTypes(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;
set @var=if((SELECT TRUE FROM information_schema.TABLE_CONSTRAINTS WHERE
            CONSTRAINT_SCHEMA = DATABASE() AND
            TABLE_NAME        = 'fermenters' AND
            CONSTRAINT_NAME   = 'fermenters_ibfk_4' AND
            CONSTRAINT_TYPE   = 'FOREIGN KEY') = true,'ALTER TABLE fermenters
            drop foreign key fermenters_ibfk_4','select 1');

prepare stmt from @var;
execute stmt;
deallocate prepare stmt;

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

INSERT IGNORE INTO `gasTankTypes` (id, displayName, maxAmount, maxAmountUnit, emptyWeight, emptyWeightUnit, createdDate, modifiedDate ) VALUES
(1, 'CO2 (5 lb)', '5', 'lb', '8.1571', 'lb', NOW(), NOW() ),
(2, 'CO2 (10 lb)', '10', 'lb', '16.3142', 'lb', NOW(), NOW() ),
(3, 'CO2 (20 lb)', '20', 'lb', '16.3142', 'lb', NOW(), NOW() ),
(4, 'Nitro (5 lb)', '5', 'lb', '8.1571', 'lb', NOW(), NOW() ),
(5, 'Nitro (10 lb)', '10', 'lb', '16.3142', 'lb', NOW(), NOW() ),
(6, 'Nitro (20 lb)', '20', 'lb', '16.3142', 'lb', NOW(), NOW() );

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

INSERT IGNORE INTO `gasTankStatuses` ( code, name, createdDate, modifiedDate ) VALUES
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
        g.loadCellUpdateVariance AS loadCellUpdateVariance,
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

                
CALL addColumnIfNotExist(DATABASE(), 'fermenters', 'startDate', 'TIMESTAMP' );
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
	COALESCE(CASE when bb.og IS NULL THEN NULL ELSE bb.ogUnit END, b.ogUnit) as ogUnit,
	COALESCE(bb.fg, b.fg) as fg,
	COALESCE(CASE when bb.fg IS NULL THEN NULL ELSE bb.fgUnit END, b.fgUnit) as fgUnit,
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


INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, validation, createdDate, modifiedDate ) VALUES
( 'RefreshTapList', '0', 'Refresh the tap list every 60 seconds', '1', NULL, NOW(), NOW() ),
( 'InfoTime', '60', 'Number Of seconds beween changing upper right tap List', '0', NULL, NOW(), NOW() ),
( 'showFermOnMainPage', '1', 'Show Fermenters in upper right tap List', '1', NULL, NOW(), NOW() ),
( 'showGTOnMainPage', '1', 'Show Gas Tanks in upper right tap List', '1', NULL, NOW(), NOW() ),
( 'showAllGTOnMainPage', '0', 'When showing gas Tanks, Show all Gas Tanks', '1', NULL, NOW(), NOW() );

ALTER TABLE beers CHANGE COLUMN `og` `og` DECIMAL(7,3) NULL DEFAULT NULL ;
ALTER TABLE beerBatches CHANGE COLUMN `og` `og` DECIMAL(7,3) NULL DEFAULT NULL ;
ALTER TABLE beerStyles CHANGE COLUMN `ogMin` `ogMin` DECIMAL(7,3) NULL DEFAULT NULL ;
ALTER TABLE beerStyles CHANGE COLUMN `ogMax` `ogMax` DECIMAL(7,3) NULL DEFAULT NULL ;
ALTER TABLE beerStyles CHANGE COLUMN `fgMin` `fgMin` DECIMAL(7,3) NULL DEFAULT NULL ;
ALTER TABLE beerStyles CHANGE COLUMN `fgMax` `fgMax` DECIMAL(7,3) NULL DEFAULT NULL ;

ALTER TABLE beerStyles CHANGE COLUMN `abvMin` `abvMin` DECIMAL(3,1) NULL ;
ALTER TABLE beerStyles CHANGE COLUMN `abvMax` `abvMax` DECIMAL(3,1) NULL ;
ALTER TABLE beerStyles CHANGE COLUMN `ibuMin` `ibuMin` DECIMAL(3,0) NULL ;
ALTER TABLE beerStyles CHANGE COLUMN `ibuMax` `ibuMax` DECIMAL(3,0) NULL ;
ALTER TABLE beerStyles CHANGE COLUMN `srmMin` `srmMin` DECIMAL(7,1) NULL ;
ALTER TABLE beerStyles CHANGE COLUMN `srmMax` `srmMax` DECIMAL(7,1) NULL ;


#remove the show column parameters as those are no longer used
UPDATE config c1 left join config c2 on trim(c2.configName) = concat('show',substring(c1.configName,1,length(c1.configName)-3)) OR (c1.configName = 'BeerInfoColNum' AND c2.configName = 'showBeerName')
 SET c1.configValue=c1.configValue*(CASE WHEN c2.configValue = '0' THEN -1 ELSE 1 END)
WHERE c1.id > 0 AND c1.configName like '%ColNum' and c2.configName IS NOT NULL and c2.showOnPanel = '1';
UPDATE config SET showOnPanel='0', configValue='0' where id > 0 AND configName like 'show%Col';

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showDigitalClock', '0', 'Show digital Clock in upper Right', '0', NOW(), NOW() ),
( 'showDigitalClock24', '0', 'Show 24hr digital Clock in upper Right', '0', NOW(), NOW() ),
( 'showAnalogClock', '0', 'Show analog Clock in upper Right', '0', NOW(), NOW() );

ALTER TABLE pours CHANGE COLUMN `beerBatchId` `beerBatchId` int(11) NULL ;
ALTER TABLE tapEvents CHANGE COLUMN `beerBatchId` `beerBatchId` int(11) NULL ;
ALTER TABLE bottles CHANGE COLUMN `beerBatchId` `beerBatchId` int(11) NULL ;

CREATE OR REPLACE VIEW `vwAccolades` 
AS
 SELECT 
    a.*,
    srm.rgb
 FROM accolades a LEFT JOIN srmRgb srm
        ON a.srm = srm.srm;
        
INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `validation`, `createdDate`, `modifiedDate`) VALUES
( 'maxPourAmount', '100', 'Maximum Amount allowed to be poured', '0', 'number:1-999', NOW(), NOW() );

INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `validation`, `createdDate`, `modifiedDate`) VALUES
( 'ignorePours', '0', 'Do not save pours to the database', '1', NULL, NOW(), NOW() );

INSERT IGNORE INTO `beerStyles`( name, catNum, category, beerStyleList, ogMin, ogMax, fgMin, fgMax, abvMin, abvMax, ibuMin, ibuMax, srmMin, srmMax, createdDate, modifiedDate ) VALUES
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

CALL addColumnIfNotExist(DATABASE(), 'gasTanks', 'loadCellUpdateVariance', 'decimal(10,5) NULL' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellUpdateVariance', 'decimal(10,5) NULL' );

INSERT IGNORE INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES
( 'samplePourSize', '0', 'Size of sample Pour', '0', NOW(), NOW() );

UPDATE `config` SET `configValue` = '3.1.0.0' WHERE `configName` = 'version';