CREATE DATABASE `app`;
USE `app`;
CREATE TABLE `user` (
  `id` VARCHAR(64) NOT NULL COMMENT 'Permanent identifier',
  `username` VARCHAR(50) NOT NULL COMMENT 'Changeable username',
  `created_datetime` DATETIME NOT NULL COMMENT 'When the user was created',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) COMMENT='User';