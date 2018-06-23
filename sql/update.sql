INSERT INTO `config` (`configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`)  
SELECT 'showVerticleTapList', '0', 'Show the Tap List Vertically (ON = YES)', '1', NOW(), NOW() FROM DUAL 
    WHERE NOT EXISTS (SELECT configName from `config` WHERE configName = 'showVerticleTapList');
