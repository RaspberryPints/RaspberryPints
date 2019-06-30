ALTER TABLE  `pours` ADD  `pinId` INT( 11 ) NULL AFTER  `tapId`;
ALTER TABLE  `taps` ADD  `pinId` INT( 11 ) NULL AFTER  `tapNumber`;
INSERT INTO `raspberrypints`.`config` (`id`, `configName`, `configValue`, `displayName`, `showOnPanel`, `createdDate`, `modifiedDate`) VALUES (NULL, 'useFlowMeter', '0', 'Use Flow Monitoring', '1', NOW(), NOW());
ALTER TABLE `pours` CHANGE `amountPoured` `amountPoured` FLOAT( 6, 3 ) NOT NULL;
ALTER TABLE  `pours` ADD  `pulses` INT( 6 ) NOT NULL AFTER  `amountPoured`;
