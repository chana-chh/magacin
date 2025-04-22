/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.11-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: magacin
-- ------------------------------------------------------
-- Server version	10.11.11-MariaDB-0+deb12u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `artikli`
--

DROP TABLE IF EXISTS `artikli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `artikli` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_kategorije` int(10) unsigned NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `id_jm` int(10) unsigned NOT NULL,
  `napomena` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `artikli_unique` (`id_kategorije`,`naziv`),
  KEY `artikli_jedinice_mere_FK` (`id_jm`),
  CONSTRAINT `artikli_jedinice_mere_FK` FOREIGN KEY (`id_jm`) REFERENCES `jedinice_mere` (`id`),
  CONSTRAINT `artikli_kategorije_artikala_FK` FOREIGN KEY (`id_kategorije`) REFERENCES `kategorije_artikala` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artikli`
--

LOCK TABLES `artikli` WRITE;
/*!40000 ALTER TABLE `artikli` DISABLE KEYS */;
INSERT INTO `artikli` VALUES
(1,1,'шљива',1,'','2025-04-11 21:36:11','2025-04-11 21:36:11'),
(2,2,'шљива',2,'','2025-04-11 21:36:23','2025-04-11 21:36:23'),
(3,3,'шљива',2,'','2025-04-11 21:36:40','2025-04-11 21:36:40'),
(4,4,'шљива',2,'','2025-04-11 21:36:54','2025-04-11 21:36:54'),
(5,5,'шљива',2,'','2025-04-11 21:37:15','2025-04-11 21:37:15'),
(6,6,'Дража шљива 0.7',3,'','2025-04-11 21:38:11','2025-04-11 21:38:11'),
(7,6,'Дража шљива 1',3,'','2025-04-11 21:38:38','2025-04-11 21:38:38'),
(8,7,'Флаша 0.7',3,'','2025-04-11 21:39:16','2025-04-11 21:39:16'),
(9,7,'Флаша 1',3,'','2025-04-11 21:39:35','2025-04-11 21:39:35'),
(10,7,'затварач',3,'','2025-04-11 21:40:20','2025-04-11 21:40:20'),
(11,7,'етикета',3,'','2025-04-11 21:40:35','2025-04-11 21:40:35'),
(12,1,'крушка',1,'','2025-04-11 21:41:30','2025-04-11 21:41:30'),
(13,2,'крушка',2,'','2025-04-11 21:41:38','2025-04-11 21:41:38'),
(14,3,'крушка',2,'','2025-04-11 21:41:46','2025-04-11 21:41:46'),
(15,4,'крушка',2,'','2025-04-11 21:41:57','2025-04-11 21:41:57'),
(16,5,'крушка',2,'','2025-04-11 21:42:09','2025-04-11 21:42:09'),
(17,6,'Дража крушка 0.7',3,'','2025-04-11 21:43:03','2025-04-11 21:43:03'),
(18,6,'Дража крушка 1',3,'','2025-04-11 21:43:28','2025-04-11 21:43:28');
/*!40000 ALTER TABLE `artikli` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dobavljaci`
--

DROP TABLE IF EXISTS `dobavljaci`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dobavljaci` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adresa_mesto` varchar(50) DEFAULT NULL,
  `adresa_ulica` varchar(100) DEFAULT NULL,
  `adresa_broj` varchar(30) DEFAULT NULL,
  `telefon` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `naziv` varchar(255) NOT NULL,
  `napomena` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `dobavljaci_unique` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dobavljaci`
--

LOCK TABLES `dobavljaci` WRITE;
/*!40000 ALTER TABLE `dobavljaci` DISABLE KEYS */;
INSERT INTO `dobavljaci` VALUES
(1,'Место','Улица','1','','','Добављач 1','','2025-04-11 21:53:38','2025-04-11 21:53:38'),
(2,'Место','Улица','1','','','Добављач 2','','2025-04-11 21:53:54','2025-04-11 21:53:54');
/*!40000 ALTER TABLE `dobavljaci` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jedinice_mere`
--

DROP TABLE IF EXISTS `jedinice_mere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jedinice_mere` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jm` varchar(10) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `jedinice_mere_unique` (`jm`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jedinice_mere`
--

LOCK TABLES `jedinice_mere` WRITE;
/*!40000 ALTER TABLE `jedinice_mere` DISABLE KEYS */;
INSERT INTO `jedinice_mere` VALUES
(1,'kg','килограм','','2025-04-11 21:32:13','2025-04-11 21:32:13'),
(2,'l','литар','','2025-04-11 21:32:33','2025-04-11 21:32:33'),
(3,'kom','комад','','2025-04-11 21:32:49','2025-04-11 21:32:49');
/*!40000 ALTER TABLE `jedinice_mere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategorije_artikala`
--

DROP TABLE IF EXISTS `kategorije_artikala`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategorije_artikala` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(100) NOT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategorije_artikala_unique` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategorije_artikala`
--

LOCK TABLES `kategorije_artikala` WRITE;
/*!40000 ALTER TABLE `kategorije_artikala` DISABLE KEYS */;
INSERT INTO `kategorije_artikala` VALUES
(1,'сировина','','2025-04-11 21:33:31','2025-04-11 21:33:31'),
(2,'кљук','','2025-04-11 21:33:39','2025-04-11 21:33:39'),
(3,'мека','','2025-04-11 21:33:49','2025-04-11 21:33:49'),
(4,'дестилат','','2025-04-11 21:34:03','2025-04-11 21:34:03'),
(5,'ракија','','2025-04-11 21:34:16','2025-04-11 21:34:16'),
(6,'готов производ','','2025-04-11 21:34:53','2025-04-11 21:34:53'),
(7,'амбалажа','','2025-04-11 21:35:03','2025-04-11 21:35:03'),
(8,'разно','','2025-04-11 21:35:10','2025-04-11 21:35:10');
/*!40000 ALTER TABLE `kategorije_artikala` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `korisnici`
--

DROP TABLE IF EXISTS `korisnici`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `korisnici` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `korisnicko_ime` varchar(50) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `nivo` int(11) NOT NULL DEFAULT 1000,
  `puno_ime` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `korisnici_unique` (`korisnicko_ime`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `korisnici`
--

LOCK TABLES `korisnici` WRITE;
/*!40000 ALTER TABLE `korisnici` DISABLE KEYS */;
INSERT INTO `korisnici` VALUES
(1,'админ','$2y$10$7Eqch0.aLuKmQMicOvBTaeaBWdlVGY2i/iosfDJaj6546EP5C2Szm',0,'Администратор','2025-03-26 17:27:34','2025-03-26 17:27:34');
/*!40000 ALTER TABLE `korisnici` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kupci`
--

DROP TABLE IF EXISTS `kupci`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kupci` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(255) NOT NULL,
  `adresa_mesto` varchar(50) DEFAULT NULL,
  `adresa_ulica` varchar(100) DEFAULT NULL,
  `adresa_broj` varchar(30) DEFAULT NULL,
  `telefon` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `napomena` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kupci_unique` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kupci`
--

LOCK TABLES `kupci` WRITE;
/*!40000 ALTER TABLE `kupci` DISABLE KEYS */;
INSERT INTO `kupci` VALUES
(1,'Купац 1','Место','Улица','1','333 444','','','2025-04-11 21:52:36','2025-04-11 21:52:36'),
(2,'Купац 2','Место','Улица','1','555 666','','','2025-04-11 21:53:05','2025-04-11 21:53:05');
/*!40000 ALTER TABLE `kupci` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logovi`
--

DROP TABLE IF EXISTS `logovi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `logovi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tip` varchar(50) NOT NULL,
  `opis` varchar(255) NOT NULL DEFAULT '',
  `tabela` varchar(200) DEFAULT NULL,
  `podaci` text DEFAULT NULL,
  `vreme` datetime NOT NULL DEFAULT current_timestamp(),
  `id_korisnika` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logovi`
--

LOCK TABLES `logovi` WRITE;
/*!40000 ALTER TABLE `logovi` DISABLE KEYS */;
INSERT INTO `logovi` VALUES
(1,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 1\njm = kg\nnaziv = килограм\nopis = \ncreated_at = 2025-04-11 21:32:13\nupdated_at = 2025-04-11 21:32:13\n','2025-04-11 21:32:13',1),
(2,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 2\njm = l\nnaziv = литар\nopis = \ncreated_at = 2025-04-11 21:32:33\nupdated_at = 2025-04-11 21:32:33\n','2025-04-11 21:32:33',1),
(3,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 3\njm = kom\nnaziv = комад\nopis = \ncreated_at = 2025-04-11 21:32:49\nupdated_at = 2025-04-11 21:32:49\n','2025-04-11 21:32:49',1),
(4,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 1\nnaziv = сировина\nopis = \ncreated_at = 2025-04-11 21:33:31\nupdated_at = 2025-04-11 21:33:31\n','2025-04-11 21:33:31',1),
(5,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 2\nnaziv = кљук\nopis = \ncreated_at = 2025-04-11 21:33:39\nupdated_at = 2025-04-11 21:33:39\n','2025-04-11 21:33:39',1),
(6,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 3\nnaziv = мека\nopis = \ncreated_at = 2025-04-11 21:33:49\nupdated_at = 2025-04-11 21:33:49\n','2025-04-11 21:33:49',1),
(7,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 4\nnaziv = дестилат\nopis = \ncreated_at = 2025-04-11 21:34:03\nupdated_at = 2025-04-11 21:34:03\n','2025-04-11 21:34:03',1),
(8,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 5\nnaziv = ракија\nopis = \ncreated_at = 2025-04-11 21:34:16\nupdated_at = 2025-04-11 21:34:16\n','2025-04-11 21:34:16',1),
(9,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 6\nnaziv = готов производ\nopis = \ncreated_at = 2025-04-11 21:34:53\nupdated_at = 2025-04-11 21:34:53\n','2025-04-11 21:34:53',1),
(10,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 7\nnaziv = амбалажа\nopis = \ncreated_at = 2025-04-11 21:35:03\nupdated_at = 2025-04-11 21:35:03\n','2025-04-11 21:35:03',1),
(11,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 8\nnaziv = разно\nopis = \ncreated_at = 2025-04-11 21:35:10\nupdated_at = 2025-04-11 21:35:10\n','2025-04-11 21:35:10',1),
(12,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 1\nid_kategorije = 1\nnaziv = шљива\nid_jm = 1\nnapomena = \ncreated_at = 2025-04-11 21:36:11\nupdated_at = 2025-04-11 21:36:11\n','2025-04-11 21:36:11',1),
(13,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 2\nid_kategorije = 2\nnaziv = шљива\nid_jm = 2\nnapomena = \ncreated_at = 2025-04-11 21:36:23\nupdated_at = 2025-04-11 21:36:23\n','2025-04-11 21:36:23',1),
(14,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 3\nid_kategorije = 3\nnaziv = шљива\nid_jm = 2\nnapomena = \ncreated_at = 2025-04-11 21:36:40\nupdated_at = 2025-04-11 21:36:40\n','2025-04-11 21:36:40',1),
(15,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 4\nid_kategorije = 4\nnaziv = шљива\nid_jm = 2\nnapomena = \ncreated_at = 2025-04-11 21:36:54\nupdated_at = 2025-04-11 21:36:54\n','2025-04-11 21:36:54',1),
(16,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 5\nid_kategorije = 5\nnaziv = шљива\nid_jm = 2\nnapomena = \ncreated_at = 2025-04-11 21:37:15\nupdated_at = 2025-04-11 21:37:15\n','2025-04-11 21:37:15',1),
(17,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 6\nid_kategorije = 6\nnaziv = Дража шљива 0.7\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-11 21:38:11\nupdated_at = 2025-04-11 21:38:11\n','2025-04-11 21:38:11',1),
(18,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 7\nid_kategorije = 6\nnaziv = Дража шљива 1\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-11 21:38:38\nupdated_at = 2025-04-11 21:38:38\n','2025-04-11 21:38:38',1),
(19,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 8\nid_kategorije = 7\nnaziv = Флаша 0.7\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-11 21:39:16\nupdated_at = 2025-04-11 21:39:16\n','2025-04-11 21:39:16',1),
(20,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 9\nid_kategorije = 7\nnaziv = Флаша 1\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-11 21:39:35\nupdated_at = 2025-04-11 21:39:35\n','2025-04-11 21:39:35',1),
(21,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 10\nid_kategorije = 7\nnaziv = затварач\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-11 21:40:20\nupdated_at = 2025-04-11 21:40:20\n','2025-04-11 21:40:20',1),
(22,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 11\nid_kategorije = 7\nnaziv = етикета\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-11 21:40:35\nupdated_at = 2025-04-11 21:40:35\n','2025-04-11 21:40:35',1),
(23,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 12\nid_kategorije = 1\nnaziv = крушка\nid_jm = 1\nnapomena = \ncreated_at = 2025-04-11 21:41:30\nupdated_at = 2025-04-11 21:41:30\n','2025-04-11 21:41:30',1),
(24,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 13\nid_kategorije = 2\nnaziv = крушка\nid_jm = 2\nnapomena = \ncreated_at = 2025-04-11 21:41:38\nupdated_at = 2025-04-11 21:41:38\n','2025-04-11 21:41:38',1),
(25,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 14\nid_kategorije = 3\nnaziv = крушка\nid_jm = 2\nnapomena = \ncreated_at = 2025-04-11 21:41:46\nupdated_at = 2025-04-11 21:41:46\n','2025-04-11 21:41:46',1),
(26,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 15\nid_kategorije = 4\nnaziv = крушка\nid_jm = 2\nnapomena = \ncreated_at = 2025-04-11 21:41:57\nupdated_at = 2025-04-11 21:41:57\n','2025-04-11 21:41:57',1),
(27,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 16\nid_kategorije = 5\nnaziv = крушка\nid_jm = 2\nnapomena = \ncreated_at = 2025-04-11 21:42:09\nupdated_at = 2025-04-11 21:42:09\n','2025-04-11 21:42:09',1),
(28,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 17\nid_kategorije = 6\nnaziv = Дража крушка 0.7\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-11 21:43:03\nupdated_at = 2025-04-11 21:43:03\n','2025-04-11 21:43:03',1),
(29,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 18\nid_kategorije = 6\nnaziv = Дража крушка 1\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-11 21:43:28\nupdated_at = 2025-04-11 21:43:28\n','2025-04-11 21:43:28',1),
(30,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 1\nnaziv = сировина\nopis = \ncreated_at = 2025-04-11 21:44:01\nupdated_at = 2025-04-11 21:44:01\n','2025-04-11 21:44:01',1),
(31,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 2\nnaziv = кљук\nopis = \ncreated_at = 2025-04-11 21:44:09\nupdated_at = 2025-04-11 21:44:09\n','2025-04-11 21:44:09',1),
(32,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 3\nnaziv = мека\nopis = \ncreated_at = 2025-04-11 21:44:15\nupdated_at = 2025-04-11 21:44:15\n','2025-04-11 21:44:15',1),
(33,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 4\nnaziv = дестилат\nopis = \ncreated_at = 2025-04-11 21:44:23\nupdated_at = 2025-04-11 21:44:23\n','2025-04-11 21:44:23',1),
(34,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 5\nnaziv = ракија\nopis = \ncreated_at = 2025-04-11 21:44:29\nupdated_at = 2025-04-11 21:44:29\n','2025-04-11 21:44:29',1),
(35,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 6\nnaziv = готови производи\nopis = \ncreated_at = 2025-04-11 21:44:57\nupdated_at = 2025-04-11 21:44:57\n','2025-04-11 21:44:57',1),
(36,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 7\nnaziv = амбалажа\nopis = \ncreated_at = 2025-04-11 21:45:07\nupdated_at = 2025-04-11 21:45:07\n','2025-04-11 21:45:07',1),
(37,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 8\nnaziv = разно\nopis = \ncreated_at = 2025-04-11 21:45:14\nupdated_at = 2025-04-11 21:45:14\n','2025-04-11 21:45:14',1),
(38,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 1\nid_tipa = 1\nnaziv = Магацин сировине\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:46:52\nupdated_at = 2025-04-11 21:46:52\n','2025-04-11 21:46:52',1),
(39,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 2\nid_tipa = 2\nnaziv = Магацин кљука\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:47:12\nupdated_at = 2025-04-11 21:47:12\n','2025-04-11 21:47:12',1),
(40,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 3\nid_tipa = 3\nnaziv = Магацин меке\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:47:26\nupdated_at = 2025-04-11 21:47:26\n','2025-04-11 21:47:26',1),
(41,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 4\nid_tipa = 4\nnaziv = Магацин дестилата\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:47:41\nupdated_at = 2025-04-11 21:47:41\n','2025-04-11 21:47:41',1),
(42,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 5\nid_tipa = 5\nnaziv = Магацин готове ракије\nadresa = Место, Улица 1\nnapomena = ракија за флаширање\ncreated_at = 2025-04-11 21:48:14\nupdated_at = 2025-04-11 21:48:14\n','2025-04-11 21:48:14',1),
(43,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 6\nid_tipa = 6\nnaziv = Магацин готових производа\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:49:08\nupdated_at = 2025-04-11 21:49:08\n','2025-04-11 21:49:08',1),
(44,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 7\nid_tipa = 7\nnaziv = Магацин амбалаже\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:49:30\nupdated_at = 2025-04-11 21:49:30\n','2025-04-11 21:49:30',1),
(45,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 8\nid_tipa = 8\nnaziv = Магацин остале робе\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:49:49\nupdated_at = 2025-04-11 21:49:49\n','2025-04-11 21:49:49',1),
(46,'ИЗМЕНА','Измена магацина','magacini','[NEW]\nid = 1\nid_tipa = 1\nnaziv = Магацин сировине 1\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:46:52\nupdated_at = 2025-04-11 21:50:36\n\n[OLD]\nid = 1\nid_tipa = 1\nnaziv = Магацин сировине\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:46:52\nupdated_at = 2025-04-11 21:46:52\n','2025-04-11 21:50:36',1),
(47,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 9\nid_tipa = 1\nnaziv = Магацин сировина 2\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:51:01\nupdated_at = 2025-04-11 21:51:01\n','2025-04-11 21:51:01',1),
(48,'ИЗМЕНА','Измена магацина','magacini','[NEW]\nid = 9\nid_tipa = 1\nnaziv = Магацин сировине 2\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:51:01\nupdated_at = 2025-04-11 21:51:15\n\n[OLD]\nid = 9\nid_tipa = 1\nnaziv = Магацин сировина 2\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-04-11 21:51:01\nupdated_at = 2025-04-11 21:51:01\n','2025-04-11 21:51:15',1),
(49,'ДОДАВАЊЕ','Додавање купца','kupci','[NEW]\nid = 1\nnaziv = Купац 1\nadresa_mesto = Место\nadresa_ulica = Улица\nadresa_broj = 1\ntelefon = 333 444\nemail = \nnapomena = \ncreated_at = 2025-04-11 21:52:36\nupdated_at = 2025-04-11 21:52:36\n','2025-04-11 21:52:36',1),
(50,'ДОДАВАЊЕ','Додавање купца','kupci','[NEW]\nid = 2\nnaziv = Купац 2\nadresa_mesto = Место\nadresa_ulica = Улица\nadresa_broj = 1\ntelefon = 555 666\nemail = \nnapomena = \ncreated_at = 2025-04-11 21:53:05\nupdated_at = 2025-04-11 21:53:05\n','2025-04-11 21:53:05',1),
(51,'ДОДАВАЊЕ','Додавање добављача','dobavljaci','[NEW]\nid = 1\nadresa_mesto = Место\nadresa_ulica = Улица\nadresa_broj = 1\ntelefon = \nemail = \nnaziv = Добављач 1\nnapomena = \ncreated_at = 2025-04-11 21:53:38\nupdated_at = 2025-04-11 21:53:38\n','2025-04-11 21:53:38',1),
(52,'ДОДАВАЊЕ','Додавање добављача','dobavljaci','[NEW]\nid = 2\nadresa_mesto = Место\nadresa_ulica = Улица\nadresa_broj = 1\ntelefon = \nemail = \nnaziv = Добављач 2\nnapomena = \ncreated_at = 2025-04-11 21:53:54\nupdated_at = 2025-04-11 21:53:54\n','2025-04-11 21:53:54',1),
(53,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 1\ndatum = 2025-04-01\nbroj = 123\nid_dobavljaca = 1\nid_magacina = 1\nnapomena = \ncreated_at = 2025-04-11 21:58:09\nupdated_at = 2025-04-11 21:58:09\n','2025-04-11 21:58:09',1),
(54,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 1\nid_prijemnice = 1\nid_artikla = 1\nkolicina = 10000.00\niznos = 1000000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 10:22:45\nupdated_at = 2025-04-12 10:22:45\n','2025-04-12 10:22:45',1),
(55,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 2\nid_prijemnice = 1\nid_artikla = 12\nkolicina = 8000.00\niznos = 900000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 10:23:21\nupdated_at = 2025-04-12 10:23:21\n','2025-04-12 10:23:21',1),
(56,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 2\ndatum = 2025-04-03\nbroj = 456\nid_dobavljaca = 2\nid_magacina = 9\nnapomena = \ncreated_at = 2025-04-12 10:24:05\nupdated_at = 2025-04-12 10:24:05\n','2025-04-12 10:24:05',1),
(57,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 3\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 5000.00\niznos = 500000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 10:24:22\nupdated_at = 2025-04-12 10:24:22\n','2025-04-12 10:24:22',1),
(58,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 4\nid_prijemnice = 2\nid_artikla = 12\nkolicina = 4000.00\niznos = 450000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 10:24:41\nupdated_at = 2025-04-12 10:24:41\n','2025-04-12 10:24:41',1),
(59,'ДОДАВАЊЕ','Додавање типа налога','tipovi_naloga','[NEW]\nid = 1\nnaziv = кљук\nopis = претварање сировине у кљук\ncreated_at = 2025-04-12 11:20:21\nupdated_at = 2025-04-12 11:20:21\n','2025-04-12 11:20:21',1),
(60,'ДОДАВАЊЕ','Додавање налога','nalozi','[NEW]\nid = 1\nid_tipa = 1\ndatum = 2025-04-05\nbroj = 1\nmagacin_iz = \nmagacin_u = \nartikli_iz = \nartikli_u = \nnapomena = 1000 кг јабује у кљук\ncreated_at = 2025-04-12 11:21:07\nupdated_at = 2025-04-12 11:21:07\n','2025-04-12 11:21:07',1),
(61,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 1\nid_naloga = 1\nid_artikla = 1\nid_magacina = 1\nsmer = УЛАЗ\nkolicina = 1000.00\nopis = \ncreated_at = 2025-04-12 11:21:40\nupdated_at = 2025-04-12 11:21:40\n','2025-04-12 11:21:40',1),
(62,'БРИСАЊЕ','Брисање ставке отпремнице','nalog_artikal','[NEW]\nid = 1\nid_naloga = 1\nid_artikla = 1\nid_magacina = 1\nsmer = УЛАЗ\nkolicina = 1000.00\nopis = \ncreated_at = 2025-04-12 11:21:40\nupdated_at = 2025-04-12 11:21:40\n','2025-04-12 11:22:46',1),
(63,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 2\nid_naloga = 1\nid_artikla = 1\nid_magacina = 1\nsmer = ИЗЛАЗ\nkolicina = 1000.00\nopis = \ncreated_at = 2025-04-12 11:23:36\nupdated_at = 2025-04-12 11:23:36\n','2025-04-12 11:23:36',1),
(64,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 3\nid_naloga = 1\nid_artikla = 2\nid_magacina = 2\nsmer = УЛАЗ\nkolicina = 900.00\nopis = \ncreated_at = 2025-04-12 11:26:12\nupdated_at = 2025-04-12 11:26:12\n','2025-04-12 11:26:12',1),
(65,'БРИСАЊЕ','Брисање ставке отпремнице','nalog_artikal','[NEW]\nid = 3\nid_naloga = 1\nid_artikla = 2\nid_magacina = 2\nsmer = УЛАЗ\nkolicina = 900.00\nopis = \ncreated_at = 2025-04-12 11:26:12\nupdated_at = 2025-04-12 11:26:12\n','2025-04-12 11:31:26',1),
(66,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 4\nid_naloga = 1\nid_artikla = 2\nid_magacina = 1\nsmer = УЛАЗ\nkolicina = 0.00\nopis = \ncreated_at = 2025-04-12 11:31:44\nupdated_at = 2025-04-12 11:31:44\n','2025-04-12 11:31:44',1),
(67,'БРИСАЊЕ','Брисање ставке отпремнице','nalog_artikal','[NEW]\nid = 4\nid_naloga = 1\nid_artikla = 2\nid_magacina = 1\nsmer = УЛАЗ\nkolicina = 0.00\nopis = \ncreated_at = 2025-04-12 11:31:44\nupdated_at = 2025-04-12 11:31:44\n','2025-04-12 11:32:26',1),
(68,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 5\nid_naloga = 1\nid_artikla = 2\nid_magacina = 2\nsmer = УЛАЗ\nkolicina = 0.00\nopis = \ncreated_at = 2025-04-12 11:32:40\nupdated_at = 2025-04-12 11:32:40\n','2025-04-12 11:32:40',1),
(69,'ДОДАВАЊЕ','Додавање типа налога','tipovi_naloga','[NEW]\nid = 2\nnaziv = печење\nopis = печење кљука у меку ракију\ncreated_at = 2025-04-12 12:40:17\nupdated_at = 2025-04-12 12:40:17\n','2025-04-12 12:40:17',1),
(70,'ДОДАВАЊЕ','Додавање типа налога','tipovi_naloga','[NEW]\nid = 3\nnaziv = дестилација\nopis = препек меке ракије\ncreated_at = 2025-04-12 12:40:43\nupdated_at = 2025-04-12 12:40:43\n','2025-04-12 12:40:43',1),
(71,'ДОДАВАЊЕ','Додавање типа налога','tipovi_naloga','[NEW]\nid = 4\nnaziv = нормализација\nopis = свођење дестилата на жељену јачину\ncreated_at = 2025-04-12 12:42:04\nupdated_at = 2025-04-12 12:42:04\n','2025-04-12 12:42:04',1),
(72,'ДОДАВАЊЕ','Додавање типа налога','tipovi_naloga','[NEW]\nid = 5\nnaziv = флаширање\nopis = флаширање готове ракије\ncreated_at = 2025-04-12 12:42:31\nupdated_at = 2025-04-12 12:42:31\n','2025-04-12 12:42:31',1),
(73,'БРИСАЊЕ','Брисање ставке отпремнице','nalog_artikal','[NEW]\nid = 5\nid_naloga = 1\nid_artikla = 2\nid_magacina = 2\nsmer = УЛАЗ\nkolicina = 0.00\nopis = \ncreated_at = 2025-04-12 11:32:40\nupdated_at = 2025-04-12 11:32:40\n','2025-04-12 12:42:58',1),
(74,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 6\nid_naloga = 1\nid_artikla = 2\nid_magacina = 2\nsmer = УЛАЗ\nkolicina = 900.00\nopis = \ncreated_at = 2025-04-12 12:43:11\nupdated_at = 2025-04-12 12:43:11\n','2025-04-12 12:43:11',1),
(75,'ИЗМЕНА','Измена налога','nalozi','[NEW]\nid = 1\nid_tipa = 1\ndatum = 2025-04-05\nbroj = 1\nmagacin_iz = 1\nmagacin_u = 2\nartikli_iz = 1\nartikli_u = 2\nnapomena = 10000 кг јабује у кљук\ncreated_at = 2025-04-12 11:21:07\nupdated_at = 2025-04-12 12:51:05\n\n[OLD]\nid = 1\nid_tipa = 1\ndatum = 2025-04-05\nbroj = 1\nmagacin_iz = 1\nmagacin_u = 2\nartikli_iz = 1\nartikli_u = 2\nnapomena = 1000 кг јабује у кљук\ncreated_at = 2025-04-12 11:21:07\nupdated_at = 2025-04-12 12:43:11\n','2025-04-12 12:51:05',1),
(76,'БРИСАЊЕ','Брисање ставке отпремнице','nalog_artikal','[NEW]\nid = 2\nid_naloga = 1\nid_artikla = 1\nid_magacina = 1\nsmer = ИЗЛАЗ\nkolicina = 1000.00\nopis = \ncreated_at = 2025-04-12 11:23:36\nupdated_at = 2025-04-12 11:23:36\n','2025-04-12 12:51:42',1),
(77,'БРИСАЊЕ','Брисање ставке отпремнице','nalog_artikal','[NEW]\nid = 6\nid_naloga = 1\nid_artikla = 2\nid_magacina = 2\nsmer = УЛАЗ\nkolicina = 900.00\nopis = \ncreated_at = 2025-04-12 12:43:11\nupdated_at = 2025-04-12 12:43:11\n','2025-04-12 12:51:44',1),
(78,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 7\nid_naloga = 1\nid_artikla = 1\nid_magacina = 1\nsmer = ИЗЛАЗ\nkolicina = 10000.00\nopis = \ncreated_at = 2025-04-12 12:52:01\nupdated_at = 2025-04-12 12:52:01\n','2025-04-12 12:52:01',1),
(79,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 8\nid_naloga = 1\nid_artikla = 2\nid_magacina = 2\nsmer = УЛАЗ\nkolicina = 9000.00\nopis = \ncreated_at = 2025-04-12 12:52:43\nupdated_at = 2025-04-12 12:52:43\n','2025-04-12 12:52:43',1),
(80,'ДОДАВАЊЕ','Додавање налога','nalozi','[NEW]\nid = 2\nid_tipa = 2\ndatum = 2025-04-08\nbroj = 2\nmagacin_iz = \nmagacin_u = \nartikli_iz = \nartikli_u = \nnapomena = печење меке ракије\ncreated_at = 2025-04-12 12:53:57\nupdated_at = 2025-04-12 12:53:57\n','2025-04-12 12:53:57',1),
(81,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 9\nid_naloga = 2\nid_artikla = 2\nid_magacina = 2\nsmer = ИЗЛАЗ\nkolicina = 9000.00\nopis = \ncreated_at = 2025-04-12 12:54:25\nupdated_at = 2025-04-12 12:54:25\n','2025-04-12 12:54:25',1),
(82,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 10\nid_naloga = 2\nid_artikla = 2\nid_magacina = 3\nsmer = УЛАЗ\nkolicina = 7000.00\nopis = 18 степени јачине\ncreated_at = 2025-04-12 12:55:27\nupdated_at = 2025-04-12 12:55:27\n','2025-04-12 12:55:27',1),
(83,'БРИСАЊЕ','Брисање ставке отпремнице','nalog_artikal','[NEW]\nid = 10\nid_naloga = 2\nid_artikla = 2\nid_magacina = 3\nsmer = УЛАЗ\nkolicina = 7000.00\nopis = 18 степени јачине\ncreated_at = 2025-04-12 12:55:27\nupdated_at = 2025-04-12 12:55:27\n','2025-04-12 12:55:44',1),
(84,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 11\nid_naloga = 2\nid_artikla = 2\nid_magacina = 3\nsmer = УЛАЗ\nkolicina = 8000.00\nopis = 18 степени јачине\ncreated_at = 2025-04-12 12:56:04\nupdated_at = 2025-04-12 12:56:04\n','2025-04-12 12:56:04',1),
(85,'БРИСАЊЕ','Брисање ставке отпремнице','nalog_artikal','[NEW]\nid = 11\nid_naloga = 2\nid_artikla = 2\nid_magacina = 3\nsmer = УЛАЗ\nkolicina = 8000.00\nopis = 18 степени јачине\ncreated_at = 2025-04-12 12:56:04\nupdated_at = 2025-04-12 12:56:04\n','2025-04-12 12:56:27',1),
(86,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 12\nid_naloga = 2\nid_artikla = 3\nid_magacina = 3\nsmer = УЛАЗ\nkolicina = 8000.00\nopis = \ncreated_at = 2025-04-12 12:56:40\nupdated_at = 2025-04-12 12:56:40\n','2025-04-12 12:56:40',1),
(87,'ДОДАВАЊЕ','Додавање налога','nalozi','[NEW]\nid = 3\nid_tipa = 3\ndatum = 2025-04-08\nbroj = 3\nmagacin_iz = \nmagacin_u = \nartikli_iz = \nartikli_u = \nnapomena = \ncreated_at = 2025-04-12 12:57:22\nupdated_at = 2025-04-12 12:57:22\n','2025-04-12 12:57:22',1),
(88,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 13\nid_naloga = 3\nid_artikla = 3\nid_magacina = 3\nsmer = ИЗЛАЗ\nkolicina = 8000.00\nopis = \ncreated_at = 2025-04-12 12:57:39\nupdated_at = 2025-04-12 12:57:39\n','2025-04-12 12:57:39',1),
(89,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 14\nid_naloga = 3\nid_artikla = 4\nid_magacina = 4\nsmer = УЛАЗ\nkolicina = 7000.00\nopis = 65 степени јачине\ncreated_at = 2025-04-12 12:58:15\nupdated_at = 2025-04-12 12:58:15\n','2025-04-12 12:58:15',1),
(90,'ДОДАВАЊЕ','Додавање налога','nalozi','[NEW]\nid = 4\nid_tipa = 4\ndatum = 2025-04-09\nbroj = 4\nmagacin_iz = \nmagacin_u = \nartikli_iz = \nartikli_u = \nnapomena = прављење готове ракије за флаширање\ncreated_at = 2025-04-12 13:00:01\nupdated_at = 2025-04-12 13:00:01\n','2025-04-12 13:00:01',1),
(91,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 15\nid_naloga = 4\nid_artikla = 4\nid_magacina = 4\nsmer = ИЗЛАЗ\nkolicina = 7000.00\nopis = \ncreated_at = 2025-04-12 13:00:33\nupdated_at = 2025-04-12 13:00:33\n','2025-04-12 13:00:33',1),
(92,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 16\nid_naloga = 4\nid_artikla = 5\nid_magacina = 5\nsmer = УЛАЗ\nkolicina = 7000.00\nopis = \ncreated_at = 2025-04-12 13:00:53\nupdated_at = 2025-04-12 13:00:53\n','2025-04-12 13:00:53',1),
(93,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 3\ndatum = 2025-04-03\nbroj = 999\nid_dobavljaca = 2\nid_magacina = 7\nnapomena = \ncreated_at = 2025-04-12 13:01:35\nupdated_at = 2025-04-12 13:01:35\n','2025-04-12 13:01:35',1),
(94,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 5\nid_prijemnice = 3\nid_artikla = 8\nkolicina = 10000.00\niznos = 700000.00\nplaceno = 1\nopis = \ncreated_at = 2025-04-12 13:02:14\nupdated_at = 2025-04-12 13:02:14\n','2025-04-12 13:02:14',1),
(95,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 6\nid_prijemnice = 3\nid_artikla = 9\nkolicina = 3000.00\niznos = 400000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 13:02:41\nupdated_at = 2025-04-12 13:02:41\n','2025-04-12 13:02:41',1),
(96,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 7\nid_prijemnice = 3\nid_artikla = 10\nkolicina = 50000.00\niznos = 200000.00\nplaceno = 1\nopis = \ncreated_at = 2025-04-12 13:03:15\nupdated_at = 2025-04-12 13:03:15\n','2025-04-12 13:03:15',1),
(97,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 8\nid_prijemnice = 3\nid_artikla = 11\nkolicina = 100000.00\niznos = 150000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 13:03:31\nupdated_at = 2025-04-12 13:03:31\n','2025-04-12 13:03:31',1),
(98,'ДОДАВАЊЕ','Додавање налога','nalozi','[NEW]\nid = 5\nid_tipa = 5\ndatum = 2025-04-12\nbroj = 6\nmagacin_iz = \nmagacin_u = \nartikli_iz = \nartikli_u = \nnapomena = \ncreated_at = 2025-04-12 13:05:09\nupdated_at = 2025-04-12 13:05:09\n','2025-04-12 13:05:09',1),
(99,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 17\nid_naloga = 5\nid_artikla = 5\nid_magacina = 5\nsmer = ИЗЛАЗ\nkolicina = 3500.00\nopis = \ncreated_at = 2025-04-12 13:05:48\nupdated_at = 2025-04-12 13:05:48\n','2025-04-12 13:05:48',1),
(100,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 18\nid_naloga = 5\nid_artikla = 8\nid_magacina = 7\nsmer = ИЗЛАЗ\nkolicina = 5000.00\nopis = \ncreated_at = 2025-04-12 13:06:10\nupdated_at = 2025-04-12 13:06:10\n','2025-04-12 13:06:10',1),
(101,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 19\nid_naloga = 5\nid_artikla = 10\nid_magacina = 7\nsmer = ИЗЛАЗ\nkolicina = 5000.00\nopis = \ncreated_at = 2025-04-12 13:06:31\nupdated_at = 2025-04-12 13:06:31\n','2025-04-12 13:06:31',1),
(102,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 20\nid_naloga = 5\nid_artikla = 11\nid_magacina = 7\nsmer = ИЗЛАЗ\nkolicina = 5000.00\nopis = \ncreated_at = 2025-04-12 13:06:44\nupdated_at = 2025-04-12 13:06:44\n','2025-04-12 13:06:44',1),
(103,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 21\nid_naloga = 5\nid_artikla = 6\nid_magacina = 6\nsmer = УЛАЗ\nkolicina = 5000.00\nopis = \ncreated_at = 2025-04-12 13:07:06\nupdated_at = 2025-04-12 13:07:06\n','2025-04-12 13:07:06',1),
(104,'ДОДАВАЊЕ','Додавање отписа','otpisi','[NEW]\nid = 7\ndatum = 2025-04-09\nid_magacina = 9\nid_artikla = 1\nkolicina = 500.00\nnapomena = \ncreated_at = 2025-04-12 13:08:55\nupdated_at = 2025-04-12 13:08:55\n','2025-04-12 13:08:55',1),
(105,'ДОДАВАЊЕ','Додавање налога','nalozi','[NEW]\nid = 6\nid_tipa = 5\ndatum = 2025-04-12\nbroj = 7\nmagacin_iz = \nmagacin_u = \nartikli_iz = \nartikli_u = \nnapomena = \ncreated_at = 2025-04-12 13:10:24\nupdated_at = 2025-04-12 13:10:24\n','2025-04-12 13:10:24',1),
(106,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 22\nid_naloga = 6\nid_artikla = 7\nid_magacina = 6\nsmer = УЛАЗ\nkolicina = 1000.00\nopis = \ncreated_at = 2025-04-12 13:10:48\nupdated_at = 2025-04-12 13:10:48\n','2025-04-12 13:10:48',1),
(107,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 23\nid_naloga = 6\nid_artikla = 5\nid_magacina = 5\nsmer = ИЗЛАЗ\nkolicina = 1000.00\nopis = \ncreated_at = 2025-04-12 13:11:01\nupdated_at = 2025-04-12 13:11:01\n','2025-04-12 13:11:01',1),
(108,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 24\nid_naloga = 6\nid_artikla = 9\nid_magacina = 7\nsmer = ИЗЛАЗ\nkolicina = 1000.00\nopis = \ncreated_at = 2025-04-12 13:11:16\nupdated_at = 2025-04-12 13:11:16\n','2025-04-12 13:11:16',1),
(109,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 25\nid_naloga = 6\nid_artikla = 10\nid_magacina = 7\nsmer = ИЗЛАЗ\nkolicina = 1000.00\nopis = \ncreated_at = 2025-04-12 13:11:35\nupdated_at = 2025-04-12 13:11:35\n','2025-04-12 13:11:35',1),
(110,'ДОДАВАЊЕ','Додавање ставке налога','nalog_artikal','[NEW]\nid = 26\nid_naloga = 6\nid_artikla = 11\nid_magacina = 7\nsmer = ИЗЛАЗ\nkolicina = 1000.00\nopis = \ncreated_at = 2025-04-12 13:11:42\nupdated_at = 2025-04-12 13:11:42\n','2025-04-12 13:11:42',1),
(111,'ДОДАВАЊЕ','Додавање отпремнице','otpremnice','[NEW]\nid = 1\ndatum = 2025-04-14\nbroj = 222\nid_kupca = 1\nid_magacina = 6\nnapomena = \ncreated_at = 2025-04-12 13:13:27\nupdated_at = 2025-04-12 13:13:27\n','2025-04-12 13:13:27',1),
(112,'ДОДАВАЊЕ','Додавање ставке отпремнице','otpremnica_artikal','[NEW]\nid = 1\nid_otpremnice = 1\nid_artikla = 6\nkolicina = 1000.00\niznos = 2500000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 13:14:16\nupdated_at = 2025-04-12 13:14:16\n','2025-04-12 13:14:16',1),
(113,'ДОДАВАЊЕ','Додавање ставке отпремнице','otpremnica_artikal','[NEW]\nid = 2\nid_otpremnice = 1\nid_artikla = 7\nkolicina = 100.00\niznos = 300000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 13:15:28\nupdated_at = 2025-04-12 13:15:28\n','2025-04-12 13:15:28',1),
(114,'ДОДАВАЊЕ','Додавање отпремнице','otpremnice','[NEW]\nid = 2\ndatum = 2025-04-15\nbroj = 333\nid_kupca = 2\nid_magacina = 6\nnapomena = \ncreated_at = 2025-04-12 13:15:47\nupdated_at = 2025-04-12 13:15:47\n','2025-04-12 13:15:47',1),
(115,'ДОДАВАЊЕ','Додавање ставке отпремнице','otpremnica_artikal','[NEW]\nid = 3\nid_otpremnice = 2\nid_artikla = 6\nkolicina = 500.00\niznos = 1250000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 13:16:09\nupdated_at = 2025-04-12 13:16:09\n','2025-04-12 13:16:09',1),
(116,'ДОДАВАЊЕ','Додавање ставке отпремнице','otpremnica_artikal','[NEW]\nid = 4\nid_otpremnice = 2\nid_artikla = 7\nkolicina = 100.00\niznos = 300000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 13:16:20\nupdated_at = 2025-04-12 13:16:20\n','2025-04-12 13:16:20',1),
(117,'БРИСАЊЕ','Брисање ставке отпремнице','otpremnica_artikal','[NEW]\nid = 4\nid_otpremnice = 2\nid_artikla = 7\nkolicina = 100.00\ncena = 0.00\niznos = 300000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 13:16:20\nupdated_at = 2025-04-12 13:16:20\n','2025-04-21 12:51:20',1),
(118,'БРИСАЊЕ','Брисање ставке отпремнице','otpremnica_artikal','[NEW]\nid = 3\nid_otpremnice = 2\nid_artikla = 6\nkolicina = 500.00\ncena = 0.00\niznos = 1250000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 13:16:09\nupdated_at = 2025-04-12 13:16:09\n','2025-04-21 12:51:22',1),
(119,'БРИСАЊЕ','Брисање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 4\nid_prijemnice = 2\nid_artikla = 12\nkolicina = 4000.00\ncena = 0.00\niznos = 450000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 10:24:41\nupdated_at = 2025-04-12 10:24:41\n','2025-04-21 12:51:47',1),
(120,'БРИСАЊЕ','Брисање отписа','otpisi','[NEW]\nid = 7\ndatum = 2025-04-09\nid_magacina = 9\nid_artikla = 1\nkolicina = 500.00\nnapomena = \ncreated_at = 2025-04-12 13:08:55\nupdated_at = 2025-04-12 13:08:55\n','2025-04-21 12:56:13',1),
(121,'БРИСАЊЕ','Брисање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 3\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 5000.00\ncena = 0.00\niznos = 500000.00\nplaceno = 0\nopis = \ncreated_at = 2025-04-12 10:24:22\nupdated_at = 2025-04-12 10:24:22\n','2025-04-21 12:56:21',1),
(122,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 1\ndatum = 2025-04-22\nbroj = 133\nid_dobavljaca = 1\nid_magacina = 1\nnapomena = \nizdao_ime = ииии\nizdao_jmbg = 0000\nizdao_datum = 2025-04-15\nprimio_ime = пппп\nprimio_jmbg = 44444\nprimio_datum = 2025-04-22\nprevoz_ime = рррр\nprevoz_jmbg = 0123\nprevoz_datum = 2025-04-23\nprevoz_registracija = 9696\ncreated_at = 2025-04-22 23:08:57\nupdated_at = 2025-04-22 23:08:57\n','2025-04-22 23:08:57',1);
/*!40000 ALTER TABLE `logovi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `magacini`
--

DROP TABLE IF EXISTS `magacini`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `magacini` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipa` int(10) unsigned NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `adresa` varchar(255) NOT NULL,
  `napomena` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `magacini_tipovi_magacina_FK` (`id_tipa`),
  CONSTRAINT `magacini_tipovi_magacina_FK` FOREIGN KEY (`id_tipa`) REFERENCES `tipovi_magacina` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `magacini`
--

LOCK TABLES `magacini` WRITE;
/*!40000 ALTER TABLE `magacini` DISABLE KEYS */;
INSERT INTO `magacini` VALUES
(1,1,'Магацин сировине 1','Место, Улица 1','','2025-04-11 21:46:52','2025-04-11 21:50:36'),
(2,2,'Магацин кљука','Место, Улица 1','','2025-04-11 21:47:12','2025-04-11 21:47:12'),
(3,3,'Магацин меке','Место, Улица 1','','2025-04-11 21:47:26','2025-04-11 21:47:26'),
(4,4,'Магацин дестилата','Место, Улица 1','','2025-04-11 21:47:41','2025-04-11 21:47:41'),
(5,5,'Магацин готове ракије','Место, Улица 1','ракија за флаширање','2025-04-11 21:48:14','2025-04-11 21:48:14'),
(6,6,'Магацин готових производа','Место, Улица 1','','2025-04-11 21:49:08','2025-04-11 21:49:08'),
(7,7,'Магацин амбалаже','Место, Улица 1','','2025-04-11 21:49:30','2025-04-11 21:49:30'),
(8,8,'Магацин остале робе','Место, Улица 1','','2025-04-11 21:49:49','2025-04-11 21:49:49'),
(9,1,'Магацин сировине 2','Место, Улица 1','','2025-04-11 21:51:01','2025-04-11 21:51:15');
/*!40000 ALTER TABLE `magacini` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nalog_artikal`
--

DROP TABLE IF EXISTS `nalog_artikal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nalog_artikal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_naloga` int(10) unsigned NOT NULL,
  `id_artikla` int(10) unsigned NOT NULL,
  `id_magacina` int(10) unsigned NOT NULL,
  `smer` enum('УЛАЗ','ИЗЛАЗ') NOT NULL,
  `kolicina` decimal(16,2) NOT NULL DEFAULT 0.00,
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `nalog_artikal_nalozi_FK` (`id_naloga`),
  KEY `nalog_artikal_artikli_FK` (`id_artikla`),
  KEY `nalog_artikal_magacini_FK` (`id_magacina`),
  CONSTRAINT `nalog_artikal_artikli_FK` FOREIGN KEY (`id_artikla`) REFERENCES `artikli` (`id`),
  CONSTRAINT `nalog_artikal_magacini_FK` FOREIGN KEY (`id_magacina`) REFERENCES `magacini` (`id`),
  CONSTRAINT `nalog_artikal_nalozi_FK` FOREIGN KEY (`id_naloga`) REFERENCES `nalozi` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nalog_artikal`
--

LOCK TABLES `nalog_artikal` WRITE;
/*!40000 ALTER TABLE `nalog_artikal` DISABLE KEYS */;
/*!40000 ALTER TABLE `nalog_artikal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nalozi`
--

DROP TABLE IF EXISTS `nalozi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nalozi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipa` int(10) unsigned NOT NULL,
  `datum` date NOT NULL,
  `broj` varchar(100) NOT NULL,
  `magacin_iz` varchar(50) DEFAULT NULL,
  `magacin_u` varchar(50) DEFAULT NULL,
  `artikli_iz` varchar(50) DEFAULT NULL,
  `artikli_u` varchar(50) DEFAULT NULL,
  `napomena` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `nalozi_tipovi_naloga_FK` (`id_tipa`),
  CONSTRAINT `nalozi_tipovi_naloga_FK` FOREIGN KEY (`id_tipa`) REFERENCES `tipovi_naloga` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nalozi`
--

LOCK TABLES `nalozi` WRITE;
/*!40000 ALTER TABLE `nalozi` DISABLE KEYS */;
/*!40000 ALTER TABLE `nalozi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otpisi`
--

DROP TABLE IF EXISTS `otpisi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `otpisi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `id_magacina` int(10) unsigned NOT NULL,
  `id_artikla` int(10) unsigned NOT NULL,
  `kolicina` decimal(16,2) NOT NULL DEFAULT 0.00,
  `napomena` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `otpisi_artikli_FK` (`id_artikla`),
  KEY `otpisi_magacini_FK` (`id_magacina`),
  CONSTRAINT `otpisi_artikli_FK` FOREIGN KEY (`id_artikla`) REFERENCES `artikli` (`id`),
  CONSTRAINT `otpisi_magacini_FK` FOREIGN KEY (`id_magacina`) REFERENCES `magacini` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otpisi`
--

LOCK TABLES `otpisi` WRITE;
/*!40000 ALTER TABLE `otpisi` DISABLE KEYS */;
/*!40000 ALTER TABLE `otpisi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otpremnica_artikal`
--

DROP TABLE IF EXISTS `otpremnica_artikal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `otpremnica_artikal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_otpremnice` int(10) unsigned NOT NULL,
  `id_artikla` int(10) unsigned NOT NULL,
  `kolicina` decimal(16,2) NOT NULL DEFAULT 0.00,
  `cena` decimal(16,2) NOT NULL DEFAULT 0.00,
  `iznos` decimal(16,2) NOT NULL DEFAULT 0.00,
  `placeno` tinyint(4) NOT NULL DEFAULT 0,
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `otpremnica_artikal_artikli_FK` (`id_artikla`) USING BTREE,
  KEY `otpremnica_artikal_prijemnice_FK` (`id_otpremnice`) USING BTREE,
  CONSTRAINT `otpremnica_artikal_artikli_FK` FOREIGN KEY (`id_artikla`) REFERENCES `artikli` (`id`),
  CONSTRAINT `otpremnica_artikal_prijemnice_FK` FOREIGN KEY (`id_otpremnice`) REFERENCES `otpremnice` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otpremnica_artikal`
--

LOCK TABLES `otpremnica_artikal` WRITE;
/*!40000 ALTER TABLE `otpremnica_artikal` DISABLE KEYS */;
/*!40000 ALTER TABLE `otpremnica_artikal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otpremnice`
--

DROP TABLE IF EXISTS `otpremnice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `otpremnice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `broj` varchar(100) NOT NULL,
  `id_kupca` int(10) unsigned NOT NULL,
  `id_magacina` int(10) unsigned NOT NULL,
  `napomena` text DEFAULT NULL,
  `izdao_ime` varchar(100) DEFAULT NULL,
  `izdao_jmbg` varchar(20) DEFAULT NULL,
  `izdao_datum` date DEFAULT NULL,
  `primio_ime` varchar(100) DEFAULT NULL,
  `primio_jmbg` varchar(20) DEFAULT NULL,
  `primio_datum` date DEFAULT NULL,
  `prevoz_ime` varchar(100) DEFAULT NULL,
  `prevoz_jmbg` varchar(20) DEFAULT NULL,
  `prevoz_datum` date DEFAULT NULL,
  `prevoz_registracija` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `otpremnice_kupci_FK` (`id_kupca`),
  KEY `otpremnice_magacini_FK` (`id_magacina`),
  CONSTRAINT `otpremnice_kupci_FK` FOREIGN KEY (`id_kupca`) REFERENCES `kupci` (`id`),
  CONSTRAINT `otpremnice_magacini_FK` FOREIGN KEY (`id_magacina`) REFERENCES `magacini` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otpremnice`
--

LOCK TABLES `otpremnice` WRITE;
/*!40000 ALTER TABLE `otpremnice` DISABLE KEYS */;
/*!40000 ALTER TABLE `otpremnice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `popis_artikal`
--

DROP TABLE IF EXISTS `popis_artikal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `popis_artikal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_popisa` int(10) unsigned NOT NULL,
  `id_artikla` int(10) unsigned NOT NULL,
  `kolicina` decimal(16,2) NOT NULL DEFAULT 0.00,
  `stanje` decimal(16,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `popis_artikal_popisi_FK` (`id_popisa`),
  KEY `popis_artikal_artikli_FK` (`id_artikla`),
  CONSTRAINT `popis_artikal_artikli_FK` FOREIGN KEY (`id_artikla`) REFERENCES `artikli` (`id`),
  CONSTRAINT `popis_artikal_popisi_FK` FOREIGN KEY (`id_popisa`) REFERENCES `popisi` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `popis_artikal`
--

LOCK TABLES `popis_artikal` WRITE;
/*!40000 ALTER TABLE `popis_artikal` DISABLE KEYS */;
/*!40000 ALTER TABLE `popis_artikal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `popisi`
--

DROP TABLE IF EXISTS `popisi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `popisi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_magacina` int(10) unsigned NOT NULL,
  `datum` date NOT NULL,
  `napomena` text DEFAULT NULL,
  `zakljucan` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `popisi_magacini_FK` (`id_magacina`),
  CONSTRAINT `popisi_magacini_FK` FOREIGN KEY (`id_magacina`) REFERENCES `magacini` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `popisi`
--

LOCK TABLES `popisi` WRITE;
/*!40000 ALTER TABLE `popisi` DISABLE KEYS */;
/*!40000 ALTER TABLE `popisi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prijemnica_artikal`
--

DROP TABLE IF EXISTS `prijemnica_artikal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `prijemnica_artikal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_prijemnice` int(10) unsigned NOT NULL,
  `id_artikla` int(10) unsigned NOT NULL,
  `kolicina` decimal(16,2) NOT NULL DEFAULT 0.00,
  `cena` decimal(16,2) NOT NULL DEFAULT 0.00,
  `iznos` decimal(16,2) NOT NULL DEFAULT 0.00,
  `placeno` tinyint(4) NOT NULL DEFAULT 0,
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `prijemnica_artikal_prijemnice_FK` (`id_prijemnice`),
  KEY `prijemnica_artikal_artikli_FK` (`id_artikla`),
  CONSTRAINT `prijemnica_artikal_artikli_FK` FOREIGN KEY (`id_artikla`) REFERENCES `artikli` (`id`),
  CONSTRAINT `prijemnica_artikal_prijemnice_FK` FOREIGN KEY (`id_prijemnice`) REFERENCES `prijemnice` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijemnica_artikal`
--

LOCK TABLES `prijemnica_artikal` WRITE;
/*!40000 ALTER TABLE `prijemnica_artikal` DISABLE KEYS */;
/*!40000 ALTER TABLE `prijemnica_artikal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prijemnice`
--

DROP TABLE IF EXISTS `prijemnice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `prijemnice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `broj` varchar(100) NOT NULL,
  `id_dobavljaca` int(10) unsigned NOT NULL,
  `id_magacina` int(10) unsigned NOT NULL,
  `napomena` text DEFAULT NULL,
  `izdao_ime` varchar(100) DEFAULT NULL,
  `izdao_jmbg` varchar(20) DEFAULT NULL,
  `izdao_datum` date DEFAULT NULL,
  `primio_ime` varchar(100) DEFAULT NULL,
  `primio_jmbg` varchar(20) DEFAULT NULL,
  `primio_datum` date DEFAULT NULL,
  `prevoz_ime` varchar(100) DEFAULT NULL,
  `prevoz_jmbg` varchar(20) DEFAULT NULL,
  `prevoz_datum` date DEFAULT NULL,
  `prevoz_registracija` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `prijemnice_dobavljaci_FK` (`id_dobavljaca`),
  KEY `prijemnice_magacini_FK` (`id_magacina`),
  CONSTRAINT `prijemnice_dobavljaci_FK` FOREIGN KEY (`id_dobavljaca`) REFERENCES `dobavljaci` (`id`),
  CONSTRAINT `prijemnice_magacini_FK` FOREIGN KEY (`id_magacina`) REFERENCES `magacini` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijemnice`
--

LOCK TABLES `prijemnice` WRITE;
/*!40000 ALTER TABLE `prijemnice` DISABLE KEYS */;
INSERT INTO `prijemnice` VALUES
(1,'2025-04-22','133',1,1,'','ииии','0000','2025-04-15','пппп','44444','2025-04-22','рррр','0123','2025-04-23','9696','2025-04-22 23:08:57','2025-04-22 23:08:57');
/*!40000 ALTER TABLE `prijemnice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stanje`
--

DROP TABLE IF EXISTS `stanje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `stanje` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_magacina` int(10) unsigned NOT NULL,
  `id_artikla` int(10) unsigned NOT NULL,
  `kolicina` decimal(16,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `stanje_magacini_FK` (`id_magacina`),
  KEY `stanje_artikli_FK` (`id_artikla`),
  CONSTRAINT `stanje_artikli_FK` FOREIGN KEY (`id_artikla`) REFERENCES `artikli` (`id`),
  CONSTRAINT `stanje_magacini_FK` FOREIGN KEY (`id_magacina`) REFERENCES `magacini` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stanje`
--

LOCK TABLES `stanje` WRITE;
/*!40000 ALTER TABLE `stanje` DISABLE KEYS */;
/*!40000 ALTER TABLE `stanje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipovi_magacina`
--

DROP TABLE IF EXISTS `tipovi_magacina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipovi_magacina` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(100) NOT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipovi_magacina_unique` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipovi_magacina`
--

LOCK TABLES `tipovi_magacina` WRITE;
/*!40000 ALTER TABLE `tipovi_magacina` DISABLE KEYS */;
INSERT INTO `tipovi_magacina` VALUES
(1,'сировина','','2025-04-11 21:44:01','2025-04-11 21:44:01'),
(2,'кљук','','2025-04-11 21:44:09','2025-04-11 21:44:09'),
(3,'мека','','2025-04-11 21:44:15','2025-04-11 21:44:15'),
(4,'дестилат','','2025-04-11 21:44:23','2025-04-11 21:44:23'),
(5,'ракија','','2025-04-11 21:44:29','2025-04-11 21:44:29'),
(6,'готови производи','','2025-04-11 21:44:57','2025-04-11 21:44:57'),
(7,'амбалажа','','2025-04-11 21:45:07','2025-04-11 21:45:07'),
(8,'разно','','2025-04-11 21:45:14','2025-04-11 21:45:14');
/*!40000 ALTER TABLE `tipovi_magacina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipovi_naloga`
--

DROP TABLE IF EXISTS `tipovi_naloga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipovi_naloga` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(100) NOT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipovi_naloga_unique` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipovi_naloga`
--

LOCK TABLES `tipovi_naloga` WRITE;
/*!40000 ALTER TABLE `tipovi_naloga` DISABLE KEYS */;
INSERT INTO `tipovi_naloga` VALUES
(1,'кљук','претварање сировине у кљук','2025-04-12 11:20:21','2025-04-12 11:20:21'),
(2,'печење','печење кљука у меку ракију','2025-04-12 12:40:17','2025-04-12 12:40:17'),
(3,'дестилација','препек меке ракије','2025-04-12 12:40:43','2025-04-12 12:40:43'),
(4,'нормализација','свођење дестилата на жељену јачину','2025-04-12 12:42:04','2025-04-12 12:42:04'),
(5,'флаширање','флаширање готове ракије','2025-04-12 12:42:31','2025-04-12 12:42:31');
/*!40000 ALTER TABLE `tipovi_naloga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'magacin'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-22 23:32:32
