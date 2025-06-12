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
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance` (
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES ('AB800A02','siti','1Bestari','2025-05-05','17:05:30','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-05','17:05:37','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-05','17:05:41','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-05','17:05:45','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-05','21:22:14','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-05','21:50:05','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-06','00:39:09','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-06','00:39:29','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-08','22:46:59','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-10','23:55:02','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-10','23:55:11','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','00:11:56','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-11','00:12:00','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','00:14:20','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-11','00:14:59','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','00:17:10','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-11','00:17:15','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','00:23:54','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-11','00:23:56','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','00:31:24','Lab 1 class','IN'),('AB800A02','siti','1Bestari','2025-05-11','00:31:37','Lab 1 class','OUT'),('AB800A02','siti','1Bestari','2025-05-11','00:31:53','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-11','00:31:59','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','00:42:22','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-11','00:43:01','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','00:43:42','Lab 1 class','IN'),('AB800A02','siti','1Bestari','2025-05-11','00:43:54','Lab 1 class','OUT'),('AB800A02','siti','1Bestari','2025-05-11','00:44:12','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-11','00:44:18','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','02:07:45','Lab 1 class','IN'),('AB800A02','siti','1Bestari','2025-05-11','02:16:58','Lab 1 class','OUT'),('AB800A02','siti','1Bestari','2025-05-11','02:19:51','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-11','02:20:14','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-11','02:23:44','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','17:56:34','Lab 1 class','IN'),('AB800A02','siti','1Bestari','2025-05-11','18:00:04','Lab 1 class','OUT'),('AB800A02','siti','1Bestari','2025-05-11','18:07:55','Lab 1 class','IN'),('AB800A02','siti','1Bestari','2025-05-11','18:08:24','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','18:14:44','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-11','18:40:52','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','18:43:34','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-11','18:45:08','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','18:45:47','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-11','18:47:13','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-11','19:24:46','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-11','19:26:06','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-11','19:26:36','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-11','19:27:31','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-11','19:35:57','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-11','19:36:23','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-11','19:38:08','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-11','19:38:27','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-12','00:33:53','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-12','00:35:04','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-12','00:35:24','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-12','00:36:38','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-12','00:41:24','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-12','00:41:37','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-12','00:43:59','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-12','00:44:07','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-12','04:56:17','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-12','04:57:07','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-12','04:57:20','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-12','19:13:15','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-12','19:14:02','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-12','19:15:01','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-12','19:17:21','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-12','19:34:36','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-12','19:34:43','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-12','19:34:54','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-12','19:35:11','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-12','19:36:59','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-12','19:37:48','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-05-12','19:37:55','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-13','15:08:02','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-13','15:09:36','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-13','15:09:44','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-13','15:21:49','Lab 1','IN'),('91214E05','abu','1Alpha','2025-05-13','15:43:47','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-13','15:44:02','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-13','15:46:23','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-13','15:47:06','Main Gate','OUT'),('91214E05','abu','1Alpha','2025-05-13','16:06:51','Main Gate','IN'),('91214E05','abu','1Alpha','2025-05-13','16:07:04','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-05-17','16:09:57','Lab 1','IN'),('AB800A02','siti','1Bestari','2025-05-17','16:10:04','Lab 1','OUT'),('AB800A02','siti','1Bestari','2025-06-08','00:09:24','Main Gate','IN'),('AB800A02','siti','1Bestari','2025-06-08','00:09:59','Main Gate','OUT'),('AB800A02','siti','1Bestari','2025-06-08','00:10:33','Lab 1','IN'),('AB800A02','siti','1Bestari','2025-06-08','00:12:22','Lab 1','OUT'),('AB800A02','siti','1Bestari','2025-06-08','00:45:19','Lab 1','IN'),('91214E05','abu','1Alpha','2025-06-08','00:57:22','Main Gate','IN'),('91214E05','abu','1Alpha','2025-06-09','16:08:50','Main Gate','IN');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
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

-- Dump completed on 2025-06-12 10:50:05
