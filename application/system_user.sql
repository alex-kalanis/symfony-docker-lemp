CREATE DATABASE IF NOT EXISTS `dummysymfony`;
CREATE DATABASE IF NOT EXISTS `testsymfony`;
ALTER DATABASE `dummysymfony` CHARACTER SET = 'utf8';
ALTER DATABASE `dummysymfony` COLLATE 'utf8mb4_general_ci';
ALTER DATABASE `testsymfony` CHARACTER SET = 'utf8';
ALTER DATABASE `testsymfony` COLLATE 'utf8mb4_general_ci';
CREATE USER IF NOT EXISTS 'kalasymfony'@'%' IDENTIFIED BY 'kalasymfony654';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, CREATE TEMPORARY TABLES, EXECUTE, CREATE VIEW, SHOW VIEW, TRIGGER
    ON *.* TO 'kalasymfony'@'%';
FLUSH PRIVILEGES;
