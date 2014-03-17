ALTER TABLE kegs MODIFY `make` text NOT NULL;
ALTER TABLE kegs MODIFY `model` text NOT NULL;
ALTER TABLE kegs MODIFY `serial` text NOT NULL;
ALTER TABLE kegs MODIFY `stampedOwner` text NOT NULL;
ALTER TABLE kegs MODIFY `stampedLoc` text NOT NULL;
ALTER TABLE kegs MODIFY `notes` text NOT NULL;
ALTER TABLE kegs MODIFY `weight` decimal(11,4) NOT NULL;