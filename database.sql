/*Kevin Estrada | Database | COP4331 small project*/
CREATE DATABASE COP4331;
USE COP4331;

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
  PRIMARY KEY (`ID`),
  INDEX `idx_user` (`UserID`), -- index to search for all the contacts of a specific user
  INDEX `idx_name` (`FirstName`, `LastName`), -- index to search for contacts according to name
  CONSTRAINT `fk_contacts_users`-- deletes contacts of a deleted user
    FOREIGN KEY (`UserID`) REFERENCES `Users`(`ID`)
    ON DELETE CASCADE -- deletes all contacts of a deleted user
) ENGINE = InnoDB;