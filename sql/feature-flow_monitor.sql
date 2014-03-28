-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE IF NOT EXISTS `batches` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`beerId` int(11) NOT NULL,
	`kegId` int(11) NOT NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	`ogAct` decimal(4,3) NULL,
	`fgAct` decimal(4,3) NULL,
	`srmAct` decimal(3,1) NULL,
	`ibuAct` int(4) NULL,
	`startKg` decimal(6,2) NULL,
	`startLiter` decimal(6,2) NULL,
	`createdDate` TIMESTAMP NULL,
	`modifiedDate` TIMESTAMP NULL,

	-- temp fields
	`tapName` VARCHAR(255) NULL,
	
	PRIMARY KEY (`id`),
	FOREIGN KEY (`beerId`) REFERENCES beers(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`kegId`) REFERENCES kegs(`id`) ON DELETE CASCADE
) ENGINE=InnoDB	DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Migrate taps data to the new batches table
-- We were putting 
--

INSERT INTO batches( beerId, kegId, active, ogAct, fgAct, srmAct, ibuAct, startLiter, createdDate, modifiedDate, tapName )
SELECT beerId, kegId, active, ogAct, fgAct, srmAct, ibuAct, startAmount * 3.7854, createdDate, modifiedDate, tapNumber FROM taps;


-- --------------------------------------------------------

--
-- Update taps columns
--

ALTER TABLE taps ADD COLUMN batchId int(11) NULL;

ALTER TABLE taps CHANGE COLUMN `tapNumber` `name` VARCHAR(255);

UPDATE taps t LEFT JOIN batches b ON b.beerId = t.beerId AND b.kegId = t.KegId SET t.batchId = b.Id;

ALTER TABLE taps ADD CONSTRAINT FK_taps_batchId FOREIGN KEY (`batchId`) REFERENCES batches(`id`) ON DELETE CASCADE;

ALTER TABLE taps ADD COLUMN `pinAddress` varchar(255) NULL;

ALTER TABLE taps ADD CONSTRAINT `pinAddress_UNIQUE` UNIQUE KEY (`pinAddress`);

ALTER TABLE taps ADD COLUMN pulsesPerLiter int NULL;

ALTER TABLE taps DROP FOREIGN KEY `taps_ibfk_1`;

ALTER TABLE taps DROP FOREIGN KEY `taps_ibfk_2`;

ALTER TABLE taps DROP COLUMN `beerId`;

ALTER TABLE taps DROP COLUMN `kegId`;

ALTER TABLE taps DROP COLUMN `ogAct`;

ALTER TABLE taps DROP COLUMN `fgAct`;

ALTER TABLE taps DROP COLUMN `srmAct`;

ALTER TABLE taps DROP COLUMN `ibuAct`;

ALTER TABLE taps DROP COLUMN `startAmount`;

ALTER TABLE taps DROP COLUMN `currentAmount`;

-- --------------------------------------------------------

--
-- Update pours columns
--

ALTER TABLE pours ADD COLUMN batchId int(11) NOT NULL;

ALTER TABLE pours ADD CONSTRAINT FK_pours_batchId FOREIGN KEY (`batchId`) REFERENCES batches(`id`) ON DELETE CASCADE;

ALTER TABLE pours ADD COLUMN pinAddress varchar(255) NOT NULL;

ALTER TABLE pours ADD CONSTRAINT FK_pours_pinAddress FOREIGN KEY (`pinAddress`) REFERENCES taps(`pinAddress`) ON DELETE CASCADE;

ALTER TABLE pours ADD COLUMN pulseCount int(11) NOT NULL;

ALTER TABLE pours ADD COLUMN pulsesPerLiter int NOT NULL;

ALTER TABLE pours ADD COLUMN liters decimal(6,2) NOT NULL;

ALTER TABLE pours DROP COLUMN `amountPoured`;

-- --------------------------------------------------------

--
-- Add new config options
--

INSERT INTO `config` ( configName, configValue, displayName, showOnPanel, createdDate, modifiedDate ) VALUES
( 'useMetric', '0', 'Use Metric', '1', NOW(), NOW() );


-- --------------------------------------------------------

--
-- Change kegTypes maxAmount to maxLiters and convert data from gallons to liters
--

ALTER TABLE kegTypes CHANGE maxAmount maxLiters decimal(6,2);

UPDATE kegTypes SET maxLiters = maxLiters * 3.7854;


-- --------------------------------------------------------

--
-- delete all tap information and rebuild it using the info in batches
--

DELETE FROM taps;

SET @rowNum=0;
INSERT INTO taps(`name`, `active`, `createdDate`, `modifiedDate`, `batchId`)
SELECT 
	@rowNum:=@rowNum+1 AS `name`,
	IFNULL(b2.active, 0) AS `active`,
	b2.createdDate,
	b2.modifiedDate,
	b2.Id AS `batchId`
FROM config c
	RIGHT JOIN batches b ON @rowNum < c.configValue
	LEFT JOIN batches b2 ON b2.active = 1 AND b2.tapName = (@rowNum + 1)
WHERE c.configName = 'numberOfTaps';





-- --------------------------------------------------------

--
-- Batches cleanup
--

ALTER TABLE batches DROP COLUMN tapName;






-- --------------------------------------------------------

--
-- Drop/Create View `vwGetTapsAmountPoured`
--

DROP VIEW IF EXISTS vwGetTapsAmountPoured;

CREATE VIEW vwGetTapsAmountPoured
AS
SELECT batchId, SUM(liters) as litersPoured FROM pours GROUP BY batchId;


-- --------------------------------------------------------

--
-- Drop/Create View `vwGetActiveTaps`
--

DROP VIEW IF EXISTS vwGetActiveTaps;

CREATE VIEW vwGetActiveTaps
AS

SELECT
	t.id,
	be.name as 'beerName',
	bs.name as 'style',
	be.notes,
	ba.ogAct,
	ba.fgAct,
	ba.srmAct,
	ba.ibuAct,
	ba.startLiter,
	IFNULL(p.litersPoured, 0) as litersPoured,
	ba.startLiter - IFNULL(p.litersPoured, 0) as remainAmount,
	t.name,
	s.rgb as srmRgb
FROM taps t
	LEFT JOIN batches ba ON ba.id = t.batchId
	LEFT JOIN beers be ON be.id = ba.beerId
	LEFT JOIN beerStyles bs ON bs.id = be.beerStyleId
	LEFT JOIN srmRgb s ON s.srm = ba.srmAct
	LEFT JOIN vwGetTapsAmountPoured as p ON p.batchId = ba.Id
WHERE t.active = true
ORDER BY t.id;



-- --------------------------------------------------------

--
-- Make columns not null
--

ALTER TABLE kegs MODIFY make text;
ALTER TABLE kegs MODIFY model text;
ALTER TABLE kegs MODIFY serial text;
ALTER TABLE kegs MODIFY stampedOwner text;
ALTER TABLE kegs MODIFY stampedLoc text;
ALTER TABLE kegs MODIFY notes text;



-- --------------------------------------------------------

--
-- Make table columns more consistant
--

ALTER TABLE kegTypes CHANGE displayName `name` text;

-- --------------------------------------------------------

--
-- Change createdDate and modifiedDate to match Laravel's naming
--

ALTER TABLE batches CHANGE createdDate created_at timestamp;
ALTER TABLE batches CHANGE modifiedDate updated_at timestamp;

ALTER TABLE beers CHANGE createdDate created_at timestamp;
ALTER TABLE beers CHANGE modifiedDate updated_at timestamp;

ALTER TABLE users CHANGE createdDate created_at timestamp;
ALTER TABLE users CHANGE modifiedDate updated_at timestamp;

ALTER TABLE taps CHANGE createdDate created_at timestamp;
ALTER TABLE taps CHANGE modifiedDate updated_at timestamp;

ALTER TABLE srmRgb CHANGE createdDate created_at timestamp;
ALTER TABLE srmRgb CHANGE modifiedDate updated_at timestamp;

ALTER TABLE pours CHANGE createdDate created_at timestamp;
ALTER TABLE pours CHANGE modifiedDate updated_at timestamp;

ALTER TABLE kegs CHANGE createdDate created_at timestamp;
ALTER TABLE kegs CHANGE modifiedDate updated_at timestamp;

ALTER TABLE kegTypes CHANGE createdDate created_at timestamp;
ALTER TABLE kegTypes CHANGE modifiedDate updated_at timestamp;

ALTER TABLE kegStatuses CHANGE createdDate created_at timestamp;
ALTER TABLE kegStatuses CHANGE modifiedDate updated_at timestamp;

ALTER TABLE config CHANGE createdDate created_at timestamp;
ALTER TABLE config CHANGE modifiedDate updated_at timestamp;

ALTER TABLE beerStyles CHANGE createdDate created_at timestamp;
ALTER TABLE beerStyles CHANGE modifiedDate updated_at timestamp;
