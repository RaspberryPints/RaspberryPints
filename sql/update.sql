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
