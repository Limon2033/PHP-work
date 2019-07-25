-- MySQL dump 10.13  Distrib 8.0.15, for Win64 (x86_64)
--
-- Host: localhost    Database: organizations
-- ------------------------------------------------------
-- Server version	8.0.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ref_org_type`
--

DROP TABLE IF EXISTS `ref_org_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `ref_org_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_org_type`
--

LOCK TABLES `ref_org_type` WRITE;
/*!40000 ALTER TABLE `ref_org_type` DISABLE KEYS */;
INSERT INTO `ref_org_type` VALUES (1,'Министерство'),(2,'Комитет'),(3,'Управление');
/*!40000 ALTER TABLE `ref_org_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_org`
--

DROP TABLE IF EXISTS `sys_org`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_org` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `bin` varchar(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `name` (`name`),
  KEY `bin` (`bin`),
  CONSTRAINT `sys_org_ibfk_1` FOREIGN KEY (`type`) REFERENCES `ref_org_type` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_org`
--

LOCK TABLES `sys_org` WRITE;
/*!40000 ALTER TABLE `sys_org` DISABLE KEYS */;
INSERT INTO `sys_org` VALUES (1,'Министерство финансов',1,'111111111111'),(2,'Министерство обороны',1,'111111111112'),(3,'Комитет финансов 1',2,'111111111113'),(4,'Комитет финансов 2',2,'111111111114'),(5,'Комитет обороны 1',2,'111111111115'),(6,'Комитет обороны 2',2,'111111111116'),(7,'Управление финансами 1',3,'111111111117'),(8,'Управление финансами 2',3,'111111111118'),(9,'Управление финансами 3',3,'111111111119'),(10,'Управление финансами 4',3,'111111111121'),(11,'Управление обороной 1',3,'111111111122'),(12,'Управление обороной 2',3,'111111111123'),(13,'Управление обороной 3',3,'111111111124'),(14,'Управление обороной 4',3,'111111111125'),(15,'Тестовое министерство',1,'111111111126'),(51,'Тестовый комитет',2,'123456789012'),(52,'Тестовое управление',3,'112233445566'),(53,'Еще 1 тестовое министерство',1,'222222222222'),(54,'Тестовый комитет 2',2,'333333333333'),(55,'Министерство иностранных дел',1,'444444444444'),(60,'Комитет иностранных дел',2,'123123123123'),(61,'Управление иностранными делами',3,'888888888888'),(62,'Министерство цифровизации',1,'666666666666'),(63,'Комитет цифровизации',2,'232323232323');
/*!40000 ALTER TABLE `sys_org` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_org_rel`
--

DROP TABLE IF EXISTS `sys_org_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_org_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `child` (`child_id`),
  KEY `parent` (`parent_id`),
  CONSTRAINT `sys_org_rel_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `sys_org` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `sys_org_rel_ibfk_2` FOREIGN KEY (`child_id`) REFERENCES `sys_org` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_org_rel`
--

LOCK TABLES `sys_org_rel` WRITE;
/*!40000 ALTER TABLE `sys_org_rel` DISABLE KEYS */;
INSERT INTO `sys_org_rel` VALUES (1,1,3,'2019-07-23','2099-12-31'),(2,1,4,'2019-07-22','2099-12-31'),(3,2,5,'2019-07-22','2099-12-31'),(4,2,6,'2019-07-22','2099-12-31'),(5,3,7,'2019-07-22','2099-12-31'),(6,3,8,'2019-07-22','2099-12-31'),(7,4,9,'2019-07-22','2099-12-31'),(8,4,10,'2019-07-22','2099-12-31'),(9,5,11,'2019-07-22','2099-12-31'),(10,5,12,'2019-07-22','2099-12-31'),(11,6,13,'2019-07-22','2099-12-31'),(12,6,14,'2019-07-22','2099-12-31'),(38,15,51,'2019-07-23','2099-12-31'),(39,51,52,'2019-07-23','2099-12-31'),(40,15,54,'2019-07-24','2099-12-31'),(44,55,60,'2019-07-24','2099-12-31'),(45,60,61,'2019-07-24','2099-12-31'),(46,62,63,'2019-07-25','2099-12-31');
/*!40000 ALTER TABLE `sys_org_rel` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-25 13:29:34
