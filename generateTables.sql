CREATE DATABASE IF NOT EXISTS montanarouteplanner;

CREATE TABLE IF NOT EXISTS `montanarouteplanner`.`mostselectedlocations` (
	`location` VARCHAR(255) NULL ,
	`frequency` INT NULL DEFAULT '0' ) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `montanarouteplanner`.`mostselectedroutes` (
	`location1` VARCHAR(255) NULL ,
	`location2` VARCHAR(255) NULL ,
	`frequency` INT NULL DEFAULT '0' ) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `montanarouteplanner`.`logs` (
	`datetime` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
	`ip` VARCHAR(255) NULL ,
	`route` VARCHAR(255) NULL ) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `montanarouteplanner`.`users` (
	`username` VARCHAR(255) NOT NULL ,
	`password` VARCHAR(255) NOT NULL ) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `montanarouteplanner`.`routeOverlays` (
	`location1` VARCHAR(255) NULL ,
	`location2` VARCHAR(255) NULL ,
	`filepath` VARCHAR(255) NULL ) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `montanarouteplanner`.`cityInformation` (
	`city` VARCHAR(255) NULL ,
	`latitude` VARCHAR(255) NULL ,
	`longitude` VARCHAR(255) NULL ) ENGINE = InnoDB;