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

INSERT INTO rfidReaders(`name`, `type`, `pin`, `priority`)
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

CREATE OR REPLACE VIEW vwIoHardwarePins
AS
  (SELECT CASE WHEN tc.flowPin  < 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('Tap ', t.tapNumber, ' Flow Meter') AS Hardware, ABS(tc.flowPin) AS pin FROM tapconfig tc LEFT JOIN taps t ON (tc.tapId = t.id))
  UNION
  (SELECT CASE WHEN tc.valvePin < 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('Tap ', t.tapNumber, ' Valve')      AS Hardware, ABS(tc.valvePin) AS pin FROM tapconfig tc LEFT JOIN taps t ON (tc.tapId = t.id))
  UNION
  (SELECT CASE WHEN pin        <> 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('RFID ', name, ' Trigger')          AS Hardware, ABS(pin) AS pin FROM rfidReaders)
  UNION
  (SELECT CASE WHEN pin        <> 0 THEN 'Pi' ELSE '' END AS shield, CONCAT('RFID ', name, ' Trigger')          AS Hardware, ABS(pin) AS pin FROM motionDetectors)
  UNION
  (SELECT CASE WHEN configValue<> 0 THEN 'Pi' ELSE '' END AS shield, displayName                                AS Hardware, ABS(configValue) AS pin FROM config WHERE configName IN ('valvesPowerPin', 'useFanPin'));

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


CREATE OR REPLACE VIEW `vwTaps` 
AS
 SELECT 
	t.*, 
	tc.*, 
	k.beerId 
 FROM taps t 
 LEFT JOIN tapconfig tc ON (t.id = tc.tapId) 
 LEFT JOIN kegs k ON (t.kegId = k.id);

 
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

CREATE OR REPLACE VIEW `vwFermentables` 
AS
 SELECT 
    f.*,
    srm.rgb
 FROM fermentables f LEFT JOIN srmRgb srm
        ON f.srm = srm.srm;

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
  te.amount,
  CASE WHEN te.type = 2 THEN (SELECT amount FROM tapEvents WHERE id = (SELECT MAX(id) FROM tapEvents WHERE id < te.id AND type = 1 AND tapId = te.tapId AND kegId = te.kegId AND beerId = te.beerId)) ELSE NULL END AS newAmount,
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


ALTER TABLE tempLog CHANGE COLUMN `temp` `temp` decimal(6,2) NULL ;
ALTER TABLE tempLog CHANGE COLUMN `humidity` `humidity` decimal(6,2) NULL ;


CALL addColumnIfNotExist(DATABASE(), 'config', 'validation', 'varchar(65)' );


DELETE FROM config where configName like 'displayUnit%';

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


CREATE OR REPLACE VIEW `vwTaps` 
AS
 SELECT 
	t.*, 
	tc.*, 
	k.beerId 
 FROM taps t 
 LEFT JOIN tapconfig tc ON (t.id = tc.tapId) 
 LEFT JOIN kegs k ON (t.kegId = k.id);
        

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
	
	
CREATE OR REPLACE VIEW vwGetFilledBottles
AS

SELECT
	t.id,
	b.id as 'beerId',
	b.name,
	b.untID,
	bs.name as 'style',
	br.name as 'breweryName',
	br.imageUrl as 'breweryImageUrl',
	b.rating,
	b.notes,
	b.abv,
	b.og as og,
	b.ogUnit as ogUnit,
	b.fg as fg,
	b.fgUnit as fgUnit,
	b.srm as srm,
	b.ibu as ibu,
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
    NULL
FROM bottles t
	LEFT JOIN beers b ON b.id = t.beerId
	LEFT JOIN bottleTypes bt ON bt.id = t.bottleTypeId
	LEFT JOIN beerStyles bs ON bs.id = b.beerStyleId
	LEFT JOIN breweries br ON br.id = b.breweryId
	LEFT JOIN srmRgb s ON s.srm = b.srm
WHERE t.active = true
ORDER BY t.id;

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
  te.amount,
  te.amountUnit,
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
	
UPDATE `config` SET `configValue` = '3.0.5.0' WHERE `configName` = 'version';


CREATE OR REPLACE VIEW vwTempLog
AS
SELECT
    tl.id,
	IFNULL(tp.notes, tl.probe) AS probe,
    temp,
    tempUnit,
    humidity,
    takenDate
FROM tempLog tl 
LEFT JOIN tempProbes tp ON tl.probe = tp.name;

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
							( 'repo', '1', 'The Repo Option from install', '0', NOW(), NOW() );
												
INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
							( 'showLastPour', '0', 'Show the Last Pour in Upper Right Corner instead of temp', '1', NOW(), NOW() );
							
							
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


CREATE OR REPLACE VIEW vwGetActiveTaps
AS

SELECT
	t.id,
	b.id as 'beerId',
	b.name,
	b.untID,
	bs.name as 'style',
	br.name as 'breweryName',
	br.imageUrl as 'breweryImageUrl',
	b.rating,
	b.notes,
	b.abv,
	b.og as og,
	b.ogUnit as ogUnit,
	b.fg as fg,
	b.fgUnit as fgUnit,
	b.srm as srm,
	b.ibu as ibu,
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
    tc.plaatoAuthToken
FROM taps t
	LEFT JOIN tapconfig tc ON t.id = tc.tapId
	LEFT JOIN kegs k ON k.id = t.kegId
	LEFT JOIN beers b ON b.id = k.beerId
	LEFT JOIN beerStyles bs ON bs.id = b.beerStyleId
	LEFT JOIN breweries br ON br.id = b.breweryId
	LEFT JOIN srmRgb s ON s.srm = b.srm
WHERE t.active = true
ORDER BY t.id;



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
    k.beerId,
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

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showPouredValue', '1', 'Show Poured Value', '1', NOW(), NOW() );
INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'showLastPouredValue', '1', 'Show Last Poured Value', '1', NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'amountPerPint', '0', 'Amount per pint. > 0 then display pints remaining', '0', NOW(), NOW() );

INSERT IGNORE INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'updateDate', '', '', '1', NOW(), NOW() );
UPDATE `config` SET `configValue` = NOW() WHERE `configName` = 'updateDate';


UPDATE `config` SET `configValue` = '3.0.9.0' WHERE `configName` = 'version';