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

INSERT INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES 
( 'use3WireValves', '0', 'Use Three Wire Valves', 1, NOW(), NOW() ),
( 'displayRowsSameHeight', '0', 'Display all tap rows as the same height', '1', NOW(), NOW() ) ;

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
