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

SET @dbname = DATABASE();
SET @tablename = "tapconfig";
SET @columnname = "valvePinState";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD ", @columnname, " INT(11)")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

CREATE OR REPLACE VIEW vwGetActiveTaps
AS

SELECT
	t.id,
	b.name,
	b.untID,
	bs.name as 'style',
	br.name as 'breweryName',
	br.imageUrl as 'breweryImageUrl',
	b.rating,
	b.notes,
	b.abv,
	b.og as og,
	b.fg as fg,
	b.srm as srm,
	b.ibu as ibu,
	t.startAmount,
	(IFNULL(t.startAmount,0) - IFNULL(t.currentAmount,0)) as amountPoured,
    IFNULL(t.currentAmount , 0)as remainAmount,
	t.tapNumber,
	t.tapRgba,
    tc.flowPin as pinId,
	s.rgb as srmRgb,
	tc.valveOn,
	tc.valvePinState
FROM taps t
	LEFT JOIN tapconfig tc ON t.id = tc.tapId
	LEFT JOIN kegs k ON k.id = t.kegId
	LEFT JOIN beers b ON b.id = k.beerId
	LEFT JOIN beerStyles bs ON bs.id = b.beerStyleId
	LEFT JOIN breweries br ON br.id = b.breweryId
	LEFT JOIN srmRgb s ON s.srm = b.srm
WHERE t.active = true
ORDER BY t.id;

-- --------------------------------------------------------

--
-- Create View `vwGetFilledBottles`
--

CREATE OR REPLACE VIEW vwGetFilledBottles
AS

SELECT
	t.id,
	b.name,
	b.untID,
	bs.name as 'style',
	br.name as 'breweryName',
	br.imageUrl as 'breweryImageUrl',
	b.rating,
	b.notes,
	b.abv,
	b.og as og,
	b.fg as fg,
	b.srm as srm,
	b.ibu as ibu,
	bt.volume,
	t.startAmount,
	IFNULL(null, 0) as amountPoured,
	t.currentAmount as remainAmount,
	t.capNumber,
	t.capRgba,
    NULL as pinId,
	s.rgb as srmRgb,
	1 as valveOn,
	1 as valvePinState
FROM bottles t
	LEFT JOIN beers b ON b.id = t.beerId
	LEFT JOIN bottleTypes bt ON bt.id = t.bottleTypeId
	LEFT JOIN beerStyles bs ON bs.id = b.beerStyleId
	LEFT JOIN breweries br ON br.id = b.breweryId
	LEFT JOIN srmRgb s ON s.srm = b.srm
WHERE t.active = true
ORDER BY t.id;

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


ALTER TABLE `raspberrypints`.`taps` 
CHANGE COLUMN `startAmount` `startAmount` DECIMAL(7,5) NULL DEFAULT NULL ,
CHANGE COLUMN `currentAmount` `currentAmount` DECIMAL(7,5) NULL DEFAULT NULL ;

SET @tablename = "tapconfig";
SET @columnname = "fermentationPSI";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD ", @columnname, " decimal(6, 2)")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = "keggingTemp";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD ", @columnname, " decimal(6, 2)")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = "loadCellCmdPin";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD ", @columnname, " int(11)")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;
SET @columnname = "loadCellRspPin";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD ", @columnname, " int(11)")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = "loadCellTareReq";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD ", @columnname, " int(11)")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;
SET @columnname = "loadCellTareDate";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD ", @columnname, " TIMESTAMP")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @tablename = "kegTypes";
SET @columnname = "emptyWeight";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD ", @columnname, " decimal(11, 4)")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @tablename = "kegs";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD ", @columnname, " decimal(11, 4)")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = "maxVolume";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  CONCAT("ALTER TABLE ", @tablename, " ADD ", @columnname, " decimal(11, 4)")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

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
    k.tapNumber,
    k.active,
    CASE WHEN (k.emptyWeight IS NULL OR k.emptyWeight = '' OR k.emptyWeight = 0) AND kt.emptyWeight IS NOT NULL THEN kt.emptyWeight ELSE k.emptyWeight END AS emptyWeight,
    CASE WHEN (k.maxVolume IS NULL OR k.maxVolume = '' OR k.maxVolume = 0) AND kt.maxAmount IS NOT NULL THEN kt.maxAmount ELSE k.maxVolume END AS maxVolume
 FROM kegs k LEFT JOIN kegTypes kt 
        ON k.kegTypeId = kt.id;

        
CREATE OR REPLACE VIEW vwGetActiveTaps
AS

SELECT
	t.id,
	b.name,
	b.untID,
	bs.name as 'style',
	br.name as 'breweryName',
	br.imageUrl as 'breweryImageUrl',
	b.rating,
	b.notes,
	b.abv,
	b.og as og,
	b.fg as fg,
	b.srm as srm,
	b.ibu as ibu,
	t.startAmount,
	(IFNULL(t.startAmount,0) - IFNULL(t.currentAmount,0)) as amountPoured,
    IFNULL(t.currentAmount , 0)as remainAmount,
	t.tapNumber,
	t.tapRgba,
    tc.flowPin as pinId,
	s.rgb as srmRgb,
	tc.valveOn,
	tc.valvePinState,
	tc.fermentationPSI,
  tc.keggingTemp
FROM taps t
	LEFT JOIN tapconfig tc ON t.id = tc.tapId
	LEFT JOIN kegs k ON k.id = t.kegId
	LEFT JOIN beers b ON b.id = k.beerId
	LEFT JOIN beerStyles bs ON bs.id = b.beerStyleId
	LEFT JOIN breweries br ON br.id = b.breweryId
	LEFT JOIN srmRgb s ON s.srm = b.srm
WHERE t.active = true
ORDER BY t.id;


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
( 'defaultFermPSI', '0', 'Default pressure of fermentation (0 if not pressure ferment)', '0', NOW(), NOW() ),
( 'defaultKeggingTemp', '56', 'Default Temperature of beer when kegging', '0', NOW(), NOW() );
