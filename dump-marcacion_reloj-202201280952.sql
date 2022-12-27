-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: 10.6.15.33    Database: marcacion_reloj
-- ------------------------------------------------------
-- Server version	5.7.36-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `marcaciones`
--

DROP TABLE IF EXISTS `marcaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marcaciones` (
  `id_marcaciones` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `uid` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_marcaciones`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcaciones`
--

LOCK TABLES `marcaciones` WRITE;
/*!40000 ALTER TABLE `marcaciones` DISABLE KEYS */;
INSERT INTO `marcaciones` VALUES (20,166666666,'375','166666666','Fingerprint','28-01-2022','08:30:08','CEUY191060144','Entrada','10.6.17.116','2022-01-28 09:30:12',NULL),(21,166666666,'376','166666666','Fingerprint','28-01-2022','08:30:18','CEUY191060144','Salida','10.6.17.116','2022-01-28 09:30:20',NULL),(22,166666666,'377','166666666','Fingerprint','28-01-2022','08:30:25','CEUY191060144','Desayuno','10.6.17.116','2022-01-28 09:30:27',NULL),(23,166666666,'378','166666666','Fingerprint','28-01-2022','08:30:31','CEUY191060144','Almuerzo','10.6.17.116','2022-01-28 09:30:33',NULL),(24,166666666,'379','166666666','Fingerprint','28-01-2022','08:30:39','CEUY191060144','Once','10.6.17.116','2022-01-28 09:30:41',NULL),(25,166666666,'380','166666666','Fingerprint','28-01-2022','08:30:47','CEUY191060144','Cena','10.6.17.116','2022-01-28 09:30:49',NULL);
/*!40000 ALTER TABLE `marcaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relojes`
--

DROP TABLE IF EXISTS `relojes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relojes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serie` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relojes`
--

LOCK TABLES `relojes` WRITE;
/*!40000 ALTER TABLE `relojes` DISABLE KEYS */;
INSERT INTO `relojes` VALUES (1,'CEUY191060144','10.6.17.116','2022-01-27 09:12:57','2022-01-27 12:13:25',1),(2,'BYRQ190960710','10.6.17.180','2022-01-27 09:12:57','2022-01-27 12:14:38',1);
/*!40000 ALTER TABLE `relojes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'marcacion_reloj'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-28  9:52:20
