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
              AND (lower(column_name) = lower(columnname))
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


INSERT IGNORE INTO ioPins ( shield, pin, name, col, row, rgb, pinSide, notes, createdDate, modifiedDate ) VALUES
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
UPDATE ioPins SET displayPin=pin;


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

UPDATE `kegTypes` SET emptyWeight =  '8.1571'  WHERE displayName = 'Ball Lock (5 gal)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '4.0786'  WHERE displayName = 'Ball Lock (2.5 gal)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '4.8943'  WHERE displayName = 'Ball Lock (3 gal)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '16.3142' WHERE displayName = 'Ball Lock (10 gal)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '8.1571'  WHERE displayName = 'Pin Lock (5 gal)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '9.9'     WHERE displayName = 'Sanke (1/6 bbl)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '14.85'   WHERE displayName = 'Sanke (1/4 bbl)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '14.85'   WHERE displayName = 'Sanke (slim 1/4 bbl)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '29.7'    WHERE displayName = 'Sanke (1/2 bbl)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE displayName = 'Sanke (Euro)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE displayName = 'Cask (pin)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE displayName = 'Cask (firkin)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE displayName = 'Cask (kilderkin)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE displayName = 'Cask (barrel)' AND emptyWeight IS NULL;
UPDATE `kegTypes` SET emptyWeight =  '0'       WHERE displayName = 'Cask (hogshead)' AND emptyWeight IS NULL;
 
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
        "UPDATE kegs k INNER JOIN taps t ON k.onTapId = t.id SET k.startAmount = t.startAmount, k.currentAmount = t.currentAmount WHERE k.startAmount IS NULl AND k.currentAmount IS NULL"
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
UPDATE pours set amountPouredUnit = 'oz' WHERE amountPouredUnit IS NULL;
CALL addColumnIfNotExist(DATABASE(), 'tempLog', 'tempUnit', 'varchar(1) null' );
UPDATE tempLog set tempUnit = 'F' WHERE tempUnit IS NULL;
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'countUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'tapconfig', 'loadCellUnit', 'tinytext DEFAULT NULL' );
CALL addColumnIfNotExist(DATABASE(), 'bottleTypes', 'volumeUnit', 'tinytext' );
CALL addColumnIfNotExist(DATABASE(), 'tapEvents', 'amountUnit', 'tinytext' );

UPDATE tapconfig set countUnit = 'oz' WHERE countUnit IS NULL;
UPDATE tapconfig set loadCellUnit = 'lb' WHERE loadCellUnit IS NULL;
UPDATE beers set ogUnit = 'sg', fgUnit = 'sg' WHERE ogUnit IS NULL;
UPDATE kegs SET weightUnit ='lb', emptyWeightUnit ='lb', maxVolumeUnit ='oz', 
				startAmountUnit ='oz', currentAmountUnit ='oz', fermentationPSIUnit ='psi', keggingTempUnit = 'F' 
				WHERE weightUnit IS NULL;
UPDATE kegTypes SET maxAmountUnit = 'oz', emptyWeightUnit = 'lb' WHERE emptyWeightUnit IS NULL;
UPDATE pours set amountPouredUnit = 'gal' WHERE amountPouredUnit IS NULL;
UPDATE yeasts set minTempUnit = 'F', maxTempUnit = 'F' WHERE maxTempUnit IS NULL;
UPDATE tempLog set tempUnit = 'F' WHERE tempUnit IS NULL;
UPDATE bottleTypes set volumeUnit = 'oz' WHERE volumeUnit IS NULL;
UPDATE tapEvents set amountUnit = 'gal' WHERE amountUnit IS NULL;

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
CALL addColumnIfNotExist(DATABASE(), 'accolades', 'rank', 'int(11) DEFAULT NULL' );
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
UPDATE accolades SET rank = id WHERE rank IS NULL;

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showAccoladeCol', '0', 'Show Accolades Col', '1', NOW(), NOW() ),
('AccoladeColNum', '7', 'Column number for Accolades', 0, NOW(), NOW() );
INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
('numAccoladeDisplay', '3', 'Number of Accolades to display in a row/column', 0, NOW(), NOW() );


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

UPDATE beerStyles SET ogMinUnit='sg' WHERE ogMinUnit IS NULL;
UPDATE beerStyles SET ogMaxUnit='sg' WHERE ogMaxUnit IS NULL;
UPDATE beerStyles SET fgMinUnit='sg' WHERE fgMinUnit IS NULL;
UPDATE beerStyles SET fgMaxUnit='sg' WHERE fgMaxUnit IS NULL;

ALTER TABLE beerStyles MODIFY srmMin decimal(7,1) NOT NULL ;
ALTER TABLE beerStyles MODIFY srmMax decimal(7,1) NOT NULL ;



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

INSERT IGNORE INTO `fermenterStatuses` (id, code, name, createdDate, modifiedDate ) VALUES
(1, 'PRIMARY', 'Primary', NOW(), NOW() ),
(2, 'SECONDARY', 'Secondary', NOW(), NOW() ),
(3, 'DRY_HOPPING', 'Dry Hopping', NOW(), NOW() ),
(4, 'CONDITIONING', 'Conditioning', NOW(), NOW() ),
(5, 'BULK_AGING', 'Bulk Aging', NOW(), NOW() ),
(6, 'FLOODED', 'Flooded', NOW(), NOW() ),
(7, 'SANITIZED', 'Sanitized', NOW(), NOW() ),
(8, 'CLEAN', 'Clean', NOW(), NOW() ),
(9, 'NEEDS_CLEANING', 'Needs Cleaning', NOW(), NOW() ),
(10, 'NEEDS_PARTS', 'Needs Parts', NOW(), NOW() ),
(22, 'NEEDS_REPAIRS', 'Needs Repairs', NOW(), NOW() );


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

INSERT IGNORE INTO `gasTankStatuses` (id, code, name, createdDate, modifiedDate ) VALUES
(1, 'DISPENSING', 'Dispensing', NOW(), NOW() ),
(2, 'FULL', 'Full', NOW(), NOW() ),
(3, 'PARTIAL', 'Partial', NOW(), NOW() ),
(4, 'EMPTY', 'Empty', NOW(), NOW() ),
(5, 'NEEDS_CERTIFICATION', 'Needs Certification', NOW(), NOW() ),
(6, 'NEEDS_PARTS', 'Needs Parts', NOW(), NOW() ),
(7, 'NEEDS_REPAIRS', 'Needs Repairs', NOW(), NOW() );



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

#remove the show column parameters as those are no longer used
UPDATE config c1 left join config c2 on trim(c2.configName) = concat('show',substring(c1.configName,1,length(c1.configName)-3)) OR (c1.configName = 'BeerInfoColNum' AND c2.configName = 'showBeerName')
 SET c1.configValue=c1.configValue*(CASE WHEN c2.configValue = '0' THEN -1 ELSE 1 END)
WHERE c1.configName like '%ColNum' and c2.configName IS NOT NULL and c2.showOnPanel = '1';
UPDATE config SET showOnPanel='0', configValue='0' where configName like 'show%Col';

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showDigitalClock', '0', 'Show digital Clock in upper Right', '0', NOW(), NOW() ),
( 'showDigitalClock24', '0', 'Show 24hr digital Clock in upper Right', '0', NOW(), NOW() ),
( 'showAnalogClock', '0', 'Show analog Clock in upper Right', '0', NOW(), NOW() );

ALTER TABLE pours CHANGE COLUMN `beerBatchId` `beerBatchId` int(11) NULL ;
ALTER TABLE tapEvents CHANGE COLUMN `beerBatchId` `beerBatchId` int(11) NULL ;
ALTER TABLE bottles CHANGE COLUMN `beerBatchId` `beerBatchId` int(11) NULL ;

UPDATE `config` SET `configValue` = '3.1.0.0' WHERE `configName` = 'version';