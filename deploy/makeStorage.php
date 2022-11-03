<?php

$create_db = "CREATE DATABASE `3dexchange`";

$create_users_table = "
CREATE TABLE IF NOT EXISTS `users` (
  `idusers` int NOT NULL AUTO_INCREMENT COMMENT 'user numeric id. Should be used everywhere',
  `username` varchar(45) NOT NULL COMMENT 'user primary name',
  `password` varchar(45) NOT NULL COMMENT 'hash of password',
  `register_date` int DEFAULT NULL,
  `last_login_date` int DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL COMMENT 'optional field, could be used as secondary user id (for login only)',
  `phone_number` varchar(18) DEFAULT NULL COMMENT 'optional field, could be used as secondary user id (for login only)',
  `access_level` varchar(2) NOT NULL DEFAULT '1' COMMENT 'permission level',
  `extra` json DEFAULT NULL,
  `description_md` varchar(4096) DEFAULT NULL,
  `mood` varchar(45) DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idusers`),
  UNIQUE KEY `idusers_UNIQUE` (`idusers`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
";

$create_parts_table = "
CREATE TABLE IF NOT EXISTS `parts` (
  `idparts` int NOT NULL AUTO_INCREMENT,
  `first_author` int DEFAULT NULL COMMENT 'id of original part author (not in the world, only on site)',
  `original_manufacturer` varchar(45) DEFAULT NULL COMMENT 'manufacturer of ',
  `original_name` varchar(45) DEFAULT NULL COMMENT 'name of part given by manufacturer',
  `original_cost` varchar(45) DEFAULT NULL COMMENT 'cost of part from manufacturer',
  `original_material` varchar(20) DEFAULT NULL COMMENT 'material of original part',
  `original_made_for` varchar(1024) DEFAULT NULL COMMENT 'for what part is made (example: headlight lamp, that could be installed in different cars)',
  `fully_compatible_with` varchar(1024) DEFAULT NULL COMMENT 'for what it fully compatible (example: headlight lamp, that could be installed in different cars, but manufacturer is not recommending it)',
  `partly_compatible_with` varchar(1024) DEFAULT NULL COMMENT 'for what this part can be used without or with some changes. (example: original hinge has 3mm holes, but it can be drilled up to 6mm for other product)',
  `tags` varchar(512) DEFAULT NULL,
  `category` varchar(45) DEFAULT 'none',
  PRIMARY KEY (`idparts`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
";

$create_realizations_teble="
CREATE TABLE IF NOT EXISTS `realizations` (
  `idrealizations` int NOT NULL AUTO_INCREMENT,
  `is_realization_of` int DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `author` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `make_date` int DEFAULT NULL,
  `edit_date` int DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`idrealizations`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
";



?>