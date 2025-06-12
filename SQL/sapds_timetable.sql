-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: sapds.c7y6kwyygqfb.ap-southeast-1.rds.amazonaws.com    Database: sapds
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '';

--
-- Table structure for table `timetable`
--

DROP TABLE IF EXISTS `timetable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timetable` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(10) DEFAULT NULL,
  `day` enum('Mon','Tue','Wed','Thu','Fri') DEFAULT NULL,
  `timeslot` varchar(20) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `teacher` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_schedule` (`class`,`day`,`timeslot`)
) ENGINE=InnoDB AUTO_INCREMENT=601 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timetable`
--

LOCK TABLES `timetable` WRITE;
/*!40000 ALTER TABLE `timetable` DISABLE KEYS */;
INSERT INTO `timetable` VALUES (1,'1Alpha','Mon','08:00-09:00','BM','Ms Tan'),(2,'1Alpha','Tue','08:00-09:00','BI','Ms Hook'),(3,'1Alpha','Wed','08:00-09:00','Math','Ms Sabah'),(4,'1Alpha','Thu','08:00-09:00','Sejarah','Mr Ranti'),(5,'1Alpha','Fri','08:00-09:00','Science','Ms Tan'),(6,'1Alpha','Mon','09:00-10:00','Science','Ms Hook'),(7,'1Alpha','Tue','09:00-10:00','BM','Ms Tan'),(8,'1Alpha','Wed','09:00-10:00','BI','Ms Hook'),(9,'1Alpha','Thu','09:00-10:00','Math','Ms Sabah'),(10,'1Alpha','Fri','09:00-10:00','Sejarah','Mr Ranti'),(11,'1Alpha','Mon','10:00-11:00','Sejarah','Mr Ranti'),(12,'1Alpha','Tue','10:00-11:00','Science','Ms Sabah'),(13,'1Alpha','Wed','10:00-11:00','BM','Ms Tan'),(14,'1Alpha','Thu','10:00-11:00','BI','Ms Hook'),(15,'1Alpha','Fri','10:00-11:00','Math','Ms Sabah'),(16,'1Alpha','Mon','11:00-12:00','Math','Ms Sabah'),(17,'1Alpha','Tue','11:00-12:00','Sejarah','Mr Ranti'),(18,'1Alpha','Wed','11:00-12:00','Science','Ms Sabah'),(19,'1Alpha','Thu','11:00-12:00','BM','Ms Tan'),(20,'1Alpha','Fri','11:00-12:00','BI','Ms Hook'),(21,'1Alpha','Mon','12:00-13:00','BI','Ms Hook'),(22,'1Alpha','Tue','12:00-13:00','Math','Ms Sabah'),(23,'1Alpha','Wed','12:00-13:00','Sejarah','Mr Ranti'),(24,'1Alpha','Thu','12:00-13:00','Science','Ms Hook'),(25,'1Alpha','Fri','12:00-13:00','BM','Ms Tan'),(26,'1Alpha','Mon','13:00-14:00','Science','Ms Hook'),(27,'1Alpha','Tue','13:00-14:00','BI','Ms Hook'),(28,'1Alpha','Wed','13:00-14:00','Math','Ms Sabah'),(29,'1Alpha','Thu','13:00-14:00','Sejarah','Mr Ranti'),(30,'1Alpha','Fri','13:00-14:00','',''),(121,'1Bestari','Mon','08:00-09:00','BI','Ms Hook'),(122,'1Bestari','Tue','08:00-09:00','BM','Ms Tan'),(123,'1Bestari','Wed','08:00-09:00','Sejarah','Mr Ranti'),(124,'1Bestari','Thu','08:00-09:00','BI','Ms Hook'),(125,'1Bestari','Fri','08:00-09:00','Science','Mr Ranti'),(126,'1Bestari','Mon','09:00-10:00','BM','Ms Tan'),(127,'1Bestari','Tue','09:00-10:00','Science','Ms Sabah'),(128,'1Bestari','Wed','09:00-10:00','Sejarah','Mr Ranti'),(129,'1Bestari','Thu','09:00-10:00','BI','Ms Hook'),(130,'1Bestari','Fri','09:00-10:00','BM','Ms Tan'),(131,'1Bestari','Mon','10:00-11:00','Science','Ms Sabah'),(132,'1Bestari','Tue','10:00-11:00','Sejarah','Mr Ranti'),(133,'1Bestari','Wed','10:00-11:00','Math','Ms Sabah'),(134,'1Bestari','Thu','10:00-11:00','Sejarah','Mr Ranti'),(135,'1Bestari','Fri','10:00-11:00','BI','Ms Hook'),(136,'1Bestari','Mon','11:00-12:00','Sejarah','Mr Ranti'),(137,'1Bestari','Tue','11:00-12:00','Math','Ms Sabah'),(138,'1Bestari','Wed','11:00-12:00','BM','Ms Tan'),(139,'1Bestari','Thu','11:00-12:00','Math','Ms Sabah'),(140,'1Bestari','Fri','11:00-12:00','Math','Ms Sabah'),(141,'1Bestari','Mon','12:00-13:00','Math','Ms Sabah'),(142,'1Bestari','Tue','12:00-13:00','BI','Ms Hook'),(143,'1Bestari','Wed','12:00-13:00','BI','Ms Hook'),(144,'1Bestari','Thu','12:00-13:00','BM','Ms Tan'),(145,'1Bestari','Fri','12:00-13:00','Sejarah','Mr Ranti'),(146,'1Bestari','Mon','13:00-14:00','Math','Ms Sabah'),(147,'1Bestari','Tue','13:00-14:00','BM','Ms Tan'),(148,'1Bestari','Wed','13:00-14:00','Science','Ms Hook'),(149,'1Bestari','Thu','13:00-14:00','Science','Ms Tan'),(150,'1Bestari','Fri','13:00-14:00','','');
/*!40000 ALTER TABLE `timetable` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-12 10:50:03
