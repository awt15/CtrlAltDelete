SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `CEN4020` DEFAULT CHARACTER SET utf8 ;
USE `CEN4020` ;

CREATE TABLE IF NOT EXISTS `CEN4020` `login` (
  `loginid` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`loginid`)
);

CREATE TABLE IF NOT EXISTS `CEN4020`.`users` (
  `username` NVARCHAR(45) NOT NULL,
  `first` NVARCHAR(45) NOT NULL,
  `last` NVARCHAR(45) NOT NULL,
  `passhash` BINARY(64) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE INDEX `idusers_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `CEN4020`.`projects` (
  `projectID` INT NOT NULL AUTO_INCREMENT,
  `projectName` NVARCHAR(45) NOT NULL,
  `projectStart` DATE NOT NULL,
  `projectDescription` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`projectID`),
  UNIQUE INDEX `projectID_UNIQUE` (`projectID` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `CEN4020`.`tasks` (
  `taskID` INT NOT NULL AUTO_INCREMENT,
  `dueDate` DATE NOT NULL,
  `username` NVARCHAR(45) NULL,
  `projectID` INT NOT NULL,
  `taskDescription` NVARCHAR(256) NOT NULL,
  PRIMARY KEY (`taskID`),
  UNIQUE INDEX `taskID_UNIQUE` (`taskID` ASC),
  INDEX `fk_tasks_users_idx` (`username` ASC),
  INDEX `fk_tasks_projects1_idx` (`projectID` ASC),
  CONSTRAINT `fk_tasks_users`
    FOREIGN KEY (`username`)
    REFERENCES `CEN4020`.`users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tasks_projects1`
    FOREIGN KEY (`projectID`)
    REFERENCES `CEN4020`.`projects` (`projectID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `CEN4020`.`belongTo` (
  `username` NVARCHAR(45) NOT NULL,
  `projectID` INT NOT NULL,
  `permissions` INT NOT NULL,
  PRIMARY KEY (`username`, `projectID`),
  INDEX `fk_users_has_projects_projects1_idx` (`projectID` ASC),
  INDEX `fk_users_has_projects_users1_idx` (`username` ASC),
  CONSTRAINT `fk_users_has_projects_users1`
    FOREIGN KEY (`username`)
    REFERENCES `CEN4020`.`users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_projects_projects1`
    FOREIGN KEY (`projectID`)
    REFERENCES `CEN4020`.`projects` (`projectID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `CEN4020`.`comments` (
  `commentID` INT NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(256) NULL,
  `commentDate` DATE NOT NULL,
  `username` NVARCHAR(45) NOT NULL,
  `projectID` INT NOT NULL,
  PRIMARY KEY (`commentID`),
  UNIQUE INDEX `commentID_UNIQUE` (`commentID` ASC),
  INDEX `fk_comments_users1_idx` (`username` ASC),
  INDEX `fk_comments_projects1_idx` (`projectID` ASC),
  CONSTRAINT `fk_comments_users1`
    FOREIGN KEY (`username`)
    REFERENCES `CEN4020`.`users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_projects1`
    FOREIGN KEY (`projectID`)
    REFERENCES `CEN4020`.`projects` (`projectID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
