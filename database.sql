/*Kevin Estrada | Database | COP4331 small project*/
CREATE DATABASE IF NOT EXISTS COP4331;
USE COP4331;
DROP TABLE IF EXISTS `COP4331`.`Contacts`;
DROP TABLE IF EXISTS `COP4331`.`Users`;

CREATE TABLE `COP4331`.`Users`
(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `FirstName` VARCHAR(50) NOT NULL DEFAULT '',
  `LastName` VARCHAR(50) NOT NULL DEFAULT '',
  `Login` VARCHAR(100) NOT NULL DEFAULT '',
  `Password` VARCHAR(255) NOT NULL DEFAULT '',
  `DateCreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE (`Login`)
) ENGINE = InnoDB;



CREATE TABLE `COP4331`.`Contacts`
(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `FirstName` VARCHAR(50) NOT NULL DEFAULT '',
  `LastName` VARCHAR(50) NOT NULL DEFAULT '',
  `Phone` VARCHAR(50) NOT NULL DEFAULT '',
  `Email` VARCHAR(100) NOT NULL DEFAULT '',
  `UserID` INT NOT NULL DEFAULT '0', -- links contact to appropriate user
  `DateCreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `VaultNumber` INT NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  INDEX `idx_user` (`UserID`), -- index to search for all the contacts of a specific user
  INDEX `idx_name` (`FirstName`, `LastName`), -- index to search for contacts according to name
  INDEX `idx_user_vault` (`UserID`, `VaultNumber`), 
  CONSTRAINT `fk_contacts_users`-- deletes contacts of a deleted user
    FOREIGN KEY (`UserID`) REFERENCES `Users`(`ID`)
    ON DELETE CASCADE -- deletes all contacts of a deleted user
) ENGINE = InnoDB;



DELIMITER $$ -- ignore semicolons to allow multiple sql statements to execute, ends on $$

CREATE TRIGGER assign_vault_number -- automatic rule that assigns a random VaultNumber
BEFORE INSERT ON Users -- runs before a user/row is inserted
FOR EACH ROW -- runs once for every user/row inserted
BEGIN -- trigger starts
  SET NEW.VaultNumber = FLOOR(1 + RAND() * 122); -- generated a random decimal between 0-1, multiplied by 122, FLOOR rounds down
END$$ -- trigger ends

DELIMITER ;