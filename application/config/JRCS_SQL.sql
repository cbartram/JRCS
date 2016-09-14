CREATE DATABASE `JRCS`;

CREATE TABLE `JRCS`.`volunteer_profile` ( `first_name` VARCHAR(25) NOT NULL ,`last_name` VARCHAR(25) NOT NULL , `street_address` VARCHAR(150) NOT NULL ,`city` VARCHAR(25) NOT NULL , `state` VARCHAR(25) NOT NULL , `zip_code`VARCHAR(10) NOT NULL , `email` VARCHAR(50) NOT NULL , `phone_number` VARCHAR(10)NOT NULL , `volunteer_type` VARCHAR(50) NOT NULL , `background_consent`VARCHAR(50) NOT NULL , `authentication_level` INT NOT NULL , `volunteer_id`VARCHAR(15) NOT NULL , PRIMARY KEY (`volunteer_id`(15))) ENGINE = InnoDB;

CREATE TABLE `JRCS`.`volunteer_availability` ( `volunteer_id` VARCHAR(15) NOT NULL , `volunteer_type` VARCHAR(50) NOT NULL , `days_available` VARCHAR(225) NOT NULL , `available_time` VARCHAR(50) NOT NULL , PRIMARY KEY (`volunteer_id`(15)))ENGINE = InnoDB;

CREATE TABLE `JRCS`.`volunteer_interests` ( `volunteer_id` VARCHAR(15) NOT NULL, `interests` LONGTEXT NOT NULL , PRIMARY KEY (`volunteer_id`(15))) ENGINE =InnoDB;

CREATE TABLE `JRCS`.`volunteer_references` ( `volunteer_id` VARCHAR(15) NOT NULL, `reference_one_name` VARCHAR(75) NOT NULL , `reference_one_address`VARCHAR(200) NOT NULL , `reference_one_city` VARCHAR(75) NOT NULL ,`reference_one_phone` VARCHAR(25) NOT NULL , `reference_two_name` VARCHAR(75)NOT NULL , `reference_two_address` VARCHAR(200) NOT NULL , `reference_two_city`VARCHAR(75) NOT NULL , `reference_two_phone` VARCHAR(25) NOT NULL , PRIMARY KEY(`volunteer_id`(15))) ENGINE = InnoDB;

CREATE TABLE `JRCS`.`emergency_contact` ( `volunteer_id` VARCHAR(15) NOT NULL ,`first_name` VARCHAR(75) NOT NULL , `last_name` VARCHAR(75) NOT NULL ,`street_address` VARCHAR(200) NOT NULL , `city` INT(75) NOT NULL , `state`INT(75) NOT NULL , `zip_code` INT(10) NOT NULL , `phone_number` INT(15) NOT NULL, `email` INT(75) NOT NULL , PRIMARY KEY (`volunteer_id`(15))) ENGINE = InnoDB;


CREATE TABLE `JRCS`.`volunteer_qualifications` ( `volunteer_id` VARCHAR(15) NOT NULL , `volunteer_type` VARCHAR(75) NOT NULL , `volunteer_skills` LONGTEXT NOT NULL , `education` VARCHAR(120) NOT NULL , `transportation` BOOLEAN NOT NULL ,`languages_spoken` TEXT NOT NULL , `previous_experience` LONGTEXT NOT NULL ,`criminal_convictions` BOOLEAN NOT NULL , `criminal_type` LONGTEXT NULL ,PRIMARY KEY (`volunteer_id`(15))) ENGINE = InnoDB;

CREATE TABLE `JRCS`.`staff_profile` ( `staff_id` VARCHAR(20) NOT NULL , `email`VARCHAR(120) NOT NULL , `authentication_level` INT NOT NULL , `password`VARCHAR(200) NOT NULL , `last_name` VARCHAR(75) NOT NULL , `first_name`VARCHAR(75) NOT NULL , `zip_code` INT(10) NOT NULL , `state` VARCHAR(10) NOT NULL , `city` VARCHAR(75) NOT NULL , `street_address` VARCHAR(120) NOT NULL ,PRIMARY KEY (`staff_id`(20))) ENGINE = InnoDB;

CREATE TABLE `JRCS`.`JACO_login` ( `volunteer_id` VARCHAR(15) NOT NULL , `email`VARCHAR(120) NOT NULL , `password` VARCHAR(200) NOT NULL ,  `staff_id` INT NULL, PRIMARY KEY(`volunteer_id`(15)), UNIQUE (`email`(120))) ENGINE = InnoDB;

CREATE TABLE `JRCS`.`BEBCO_login` ( `volunteer_id` VARCHAR(15) NOT NULL ,`email` VARCHAR(120) NOT NULL , `password` VARCHAR(200) NOT NULL , `staff_id`INT NULL , PRIMARY KEY (`volunteer_id`(15)), UNIQUE (`email`(120))) ENGINE =InnoDB;

CREATE TABLE `JRCS`.`JBC_login` ( `volunteer_id` VARCHAR(15) NOT NULL , `email`VARCHAR(120) NOT NULL , `password` VARCHAR(200) NOT NULL , `staff_id`VARCHAR(20) NULL , PRIMARY KEY (`volunteer_id`(15))) ENGINE = InnoDB;

CREATE TABLE `JRCS`.`volunteer_CICO` ( `volunteer_id` VARCHAR(20) NOT NULL ,`volunteer_email` VARCHAR(120) NOT NULL , `volunteer_organization` VARCHAR(120)NOT NULL , `volunteer_type` VARCHAR(75) NOT NULL , `volunteer_program`VARCHAR(75) NOT NULL , `check_in_timestamp` TIMESTAMP NOT NULL ,`check_out_timestamp` TIMESTAMP NOT NULL , PRIMARY KEY (`volunteer_id`(20)))ENGINE = InnoDB;

CREATE TABLE `JRCS`.`volunteer_event` ( `volunteer_id` VARCHAR(20) NOT NULL ,`attendee_count` INT NOT NULL , `event_description` LONGTEXT NOT NULL ,`volunteer_count` INT NOT NULL , `total_volunteer_hours` INT NOT NULL ,`donation_amount` INT NOT NULL , PRIMARY KEY (`volunteer_id`(20))) ENGINE =InnoDB;

CREATE TABLE `JRCS`.`donations` ( `volunteer_id` VARCHAR(20) NOT NULL ,`organization_name` VARCHAR(120) NOT NULL , `donation_description` LONGTEXT NOT NULL , `donation_value` INT NOT NULL , `date` DATE NOT NULL , PRIMARY KEY(`volunteer_id`(20))) ENGINE = InnoDB;

ALTER TABLE `BEBCO_login` ADD `staff_email` VARCHAR(120) NOT NULL AFTER `staff_id`;
ALTER TABLE `JACO_login` ADD `staff_email` VARCHAR(120) NOT NULL AFTER `staff_id`;
ALTER TABLE `JBC_login` ADD `staff_email` VARCHAR(120) NOT NULL AFTER `staff_id`;
ALTER TABLE `volunteer_profile` ADD `password` VARCHAR(200) NOT NULL AFTER `volunteer_id`;
