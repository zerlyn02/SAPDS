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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('school-administrator','guardian') COLLATE utf8mb4_general_ci NOT NULL,
  `admin_role` enum('clerk','teacher','school-operator','others') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `child_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `relationship` enum('parent','guardian') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `car_plate` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reset_token` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `noti_token` varchar(155) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'z','zerlyn0816@gmail.com','z','$2y$12$YwxCH2Zlw/cCemEdTel3BetdLagZEHoKDroeTs97O5iQgKiqwmBzK','+60-12-618-9662','drg','school-administrator','clerk',NULL,'parent',NULL,'2024-12-29 16:32:30','857f8573089d25aea67bbd5789a7dae9d7f8914a3512bfcf0833ca9ca893953b','2025-05-10 16:02:26',NULL),(7,'ze','kaiyingzerlyn@gmail.com','ze','$2y$10$kiFPiyXN5SpEAkpmchxdDOk7AShD5FCUKwWyzlId0xHsp8.rjCrN6','012791','drg','school-administrator','clerk',NULL,'parent',NULL,'2024-12-29 16:47:13',NULL,NULL,NULL),(9,'gr','gr@gmail.com','gr','$2y$10$qvdlDsCSx3c3/0Tb0V1/iOT9m3tO9n67qSnM4jlPEh2ewSognPzba','097','drg','guardian',NULL,'abu','parent','frc5567','2024-12-29 17:12:35',NULL,NULL,NULL),(10,'teacher','teacher@gmail.com','teacher','$2y$10$WppmsegnZgLHn1swHnuun.dgnSO.euD5Vqp0G5hAJA..ZqrI5oRfq','0-98','oi','school-administrator','teacher',NULL,'parent',NULL,'2025-01-06 17:14:30',NULL,NULL,NULL),(11,'ba','g@gmail.com','ba','$2y$10$HQtl.tRSTknZQ0YKacTaR.hvgafwEfIvABEMJf7Vk/za4kBVmuvH2','0-98','d','school-administrator','',NULL,'parent',NULL,'2025-01-21 09:16:39',NULL,NULL,NULL),(12,'j','j@gmail.com','j','$2y$10$Vn9s8WKEeJMR3z7/KpIY8uMDlYxIBPVfUkEs9fK8S9UiOQQuC.uBW','87','87','school-administrator','teacher',NULL,'parent',NULL,'2025-04-09 13:33:38',NULL,NULL,NULL),(13,'Test User','test@example.com','testuser','$2y$12$.CVpwIvkBWmS489KWXqwxug6VnWFm9HBduw/c6mbdKfh3M70Rely2','0123456789','123 Main St','',NULL,NULL,NULL,NULL,'2025-04-20 18:52:14',NULL,NULL,NULL),(15,'y','y@gmail.com','y','$2y$12$CXrXrswM3vQuq/sFzoTW/uQny8AifVHz3d3jY3.QQPTuq.w7odK..','54','54','school-administrator','clerk',NULL,NULL,NULL,'2025-04-20 18:58:47',NULL,NULL,NULL),(16,'sitimum','d@gmail.com','sitimum','$2y$12$RNk2B6Wxxd94J.TaxxB3d.P.GYhniA2Mu8r/Mw0sFPdg.FvM79u9.','34','f','guardian',NULL,'siti','parent','jdh8729','2025-05-11 16:43:32',NULL,NULL,NULL),(17,'Ms Tan','tan@gmail.com','tan','$2y$12$Rtbbv4SK.HtKLebm8w0QF.9AB9xZDZ.dhA33ydNg6tWQp1boVzY.2','326','Niu7','school-administrator','teacher',NULL,NULL,NULL,'2025-05-12 09:35:30',NULL,NULL,NULL),(18,'Ms Hook','hook@gmail.com','hook','$2y$12$avLBskFf7Q829GlOgM2LlubRWrmvBByw84gGACFbIoSM8g6P1RDTu','97643','Biha7','school-administrator','teacher',NULL,NULL,NULL,'2025-05-12 09:36:39',NULL,NULL,NULL),(19,'Ms Sabah','sabah@gmail.com','sabah','$2y$12$lOp7RpEyfYY.GewUwZYgK.KGeT5b9DRK7qy7qbr6QtBtnu64tn8hK','9334','Nud9','school-administrator','teacher',NULL,NULL,NULL,'2025-05-12 09:37:21',NULL,NULL,NULL),(20,'Mr Ranti','ranti@gmail.com','ranti','$2y$12$MasHCvVNA5vqtjkbgURw6.PnTBwSK7fRbc2QzvYTTLZYrxFjBov4a','952','Lopd0','school-administrator','teacher',NULL,NULL,NULL,'2025-05-12 09:38:25',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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

-- Dump completed on 2025-06-12 10:50:04
