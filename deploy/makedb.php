<?php

$create_db = "CREATE DATABASE `3dexchange`";
$create_users_table = "
    CREATE TABLE `users` (
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
  ) AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
  ";
$create_parts_db = "";




?>