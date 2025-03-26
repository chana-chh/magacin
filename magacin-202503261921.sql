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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artikli`
--

LOCK TABLES `artikli` WRITE;
/*!40000 ALTER TABLE `artikli` DISABLE KEYS */;
INSERT INTO `artikli` VALUES
(4,4,'шљива',15,'','2025-03-26 18:12:15','2025-03-26 18:12:15'),
(5,5,'шљива',17,'','2025-03-26 18:12:42','2025-03-26 18:12:42'),
(6,6,'шљива',17,'','2025-03-26 18:12:55','2025-03-26 18:12:55'),
(7,7,'шљива',17,'','2025-03-26 18:13:08','2025-03-26 18:13:08'),
(8,8,'шљива',17,'','2025-03-26 18:13:47','2025-03-26 18:13:47'),
(9,9,'Дража шљива 0.7 l',14,'','2025-03-26 18:17:04','2025-03-26 18:17:04'),
(10,9,'Дража шљива 1 l',14,'','2025-03-26 18:17:56','2025-03-26 18:17:56'),
(11,4,'крушка',15,'','2025-03-26 18:52:54','2025-03-26 18:52:54');
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
  UNIQUE KEY `kupci_unique` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dobavljaci`
--

LOCK TABLES `dobavljaci` WRITE;
/*!40000 ALTER TABLE `dobavljaci` DISABLE KEYS */;
INSERT INTO `dobavljaci` VALUES
(3,'','','','','','добављач 1','','2025-03-26 18:34:13','2025-03-26 18:34:13'),
(4,'','','','','','добављач 2','','2025-03-26 18:34:25','2025-03-26 18:34:25'),
(5,'','','','','','добављач 3','','2025-03-26 18:34:36','2025-03-26 18:34:36');
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jedinice_mere`
--

LOCK TABLES `jedinice_mere` WRITE;
/*!40000 ALTER TABLE `jedinice_mere` DISABLE KEYS */;
INSERT INTO `jedinice_mere` VALUES
(14,'kom','комад','','2025-03-26 18:07:12','2025-03-26 18:07:12'),
(15,'kg','килограм','','2025-03-26 18:07:43','2025-03-26 18:07:43'),
(16,'t','тона','','2025-03-26 18:07:51','2025-03-26 18:07:51'),
(17,'l','литар','','2025-03-26 18:08:02','2025-03-26 18:08:02');
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
  UNIQUE KEY `tipovi_magacina_unique` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategorije_artikala`
--

LOCK TABLES `kategorije_artikala` WRITE;
/*!40000 ALTER TABLE `kategorije_artikala` DISABLE KEYS */;
INSERT INTO `kategorije_artikala` VALUES
(4,'сировина','воће','2025-03-26 18:09:58','2025-03-26 18:09:58'),
(5,'кљук','џибра','2025-03-26 18:10:14','2025-03-26 18:10:14'),
(6,'мека','мека ракија','2025-03-26 18:11:00','2025-03-26 18:11:00'),
(7,'љута','препек','2025-03-26 18:11:12','2025-03-26 18:11:12'),
(8,'ракија за флаширање','готова ракија спремна за флаширање','2025-03-26 18:11:36','2025-03-26 18:11:36'),
(9,'флаширана ракија','','2025-03-26 18:15:57','2025-03-26 18:15:57');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kupci`
--

LOCK TABLES `kupci` WRITE;
/*!40000 ALTER TABLE `kupci` DISABLE KEYS */;
INSERT INTO `kupci` VALUES
(3,'купац 1','Београд','Улица','12','011 222 333','','плаћа нередовно','2025-03-26 18:33:12','2025-03-26 18:33:12'),
(4,'купац 2','Ниш','Улица','12','','','','2025-03-26 18:33:50','2025-03-26 18:33:50');
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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logovi`
--

LOCK TABLES `logovi` WRITE;
/*!40000 ALTER TABLE `logovi` DISABLE KEYS */;
INSERT INTO `logovi` VALUES
(1,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 14\njm = ком\nnaziv = комад\nopis = \ncreated_at = 2025-03-26 18:07:12\nupdated_at = 2025-03-26 18:07:12\n','2025-03-26 18:07:12',1),
(2,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 15\njm = кг\nnaziv = килограм\nopis = \ncreated_at = 2025-03-26 18:07:43\nupdated_at = 2025-03-26 18:07:43\n','2025-03-26 18:07:43',1),
(3,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 16\njm = т\nnaziv = тона\nopis = \ncreated_at = 2025-03-26 18:07:51\nupdated_at = 2025-03-26 18:07:51\n','2025-03-26 18:07:51',1),
(4,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 17\njm = л\nnaziv = литар\nopis = \ncreated_at = 2025-03-26 18:08:02\nupdated_at = 2025-03-26 18:08:02\n','2025-03-26 18:08:02',1),
(5,'ИЗМЕНА','Измена јединице мере','jedinice_mere','[NEW]\nid = 14\njm = kom\nnaziv = комад\nopis = \ncreated_at = 2025-03-26 18:07:12\nupdated_at = 2025-03-26 18:07:12\n\n[OLD]\nid = 14\njm = ком\nnaziv = комад\nopis = \ncreated_at = 2025-03-26 18:07:12\nupdated_at = 2025-03-26 18:07:12\n','2025-03-26 18:08:27',1),
(6,'ИЗМЕНА','Измена јединице мере','jedinice_mere','[NEW]\nid = 15\njm = kg\nnaziv = килограм\nopis = \ncreated_at = 2025-03-26 18:07:43\nupdated_at = 2025-03-26 18:07:43\n\n[OLD]\nid = 15\njm = кг\nnaziv = килограм\nopis = \ncreated_at = 2025-03-26 18:07:43\nupdated_at = 2025-03-26 18:07:43\n','2025-03-26 18:08:35',1),
(7,'ИЗМЕНА','Измена јединице мере','jedinice_mere','[NEW]\nid = 16\njm = t\nnaziv = тона\nopis = \ncreated_at = 2025-03-26 18:07:51\nupdated_at = 2025-03-26 18:07:51\n\n[OLD]\nid = 16\njm = т\nnaziv = тона\nopis = \ncreated_at = 2025-03-26 18:07:51\nupdated_at = 2025-03-26 18:07:51\n','2025-03-26 18:08:43',1),
(8,'ИЗМЕНА','Измена јединице мере','jedinice_mere','[NEW]\nid = 17\njm = l\nnaziv = литар\nopis = \ncreated_at = 2025-03-26 18:08:02\nupdated_at = 2025-03-26 18:08:02\n\n[OLD]\nid = 17\njm = л\nnaziv = литар\nopis = \ncreated_at = 2025-03-26 18:08:02\nupdated_at = 2025-03-26 18:08:02\n','2025-03-26 18:08:52',1),
(9,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 4\nnaziv = сировина\nopis = воће\ncreated_at = 2025-03-26 18:09:58\nupdated_at = 2025-03-26 18:09:58\n','2025-03-26 18:09:58',1),
(10,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 5\nnaziv = кљук\nopis = џибра\ncreated_at = 2025-03-26 18:10:14\nupdated_at = 2025-03-26 18:10:14\n','2025-03-26 18:10:14',1),
(11,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 6\nnaziv = мека\nopis = мека ракија\ncreated_at = 2025-03-26 18:11:00\nupdated_at = 2025-03-26 18:11:00\n','2025-03-26 18:11:00',1),
(12,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 7\nnaziv = љута\nopis = препек\ncreated_at = 2025-03-26 18:11:12\nupdated_at = 2025-03-26 18:11:12\n','2025-03-26 18:11:12',1),
(13,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 8\nnaziv = готов производ\nopis = \ncreated_at = 2025-03-26 18:11:36\nupdated_at = 2025-03-26 18:11:36\n','2025-03-26 18:11:36',1),
(14,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 4\nid_kategorije = 4\nnaziv = шљива\nid_jm = 15\nnapomena = \ncreated_at = 2025-03-26 18:12:15\nupdated_at = 2025-03-26 18:12:15\n','2025-03-26 18:12:15',1),
(15,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 5\nid_kategorije = 5\nnaziv = шљива\nid_jm = 17\nnapomena = \ncreated_at = 2025-03-26 18:12:42\nupdated_at = 2025-03-26 18:12:42\n','2025-03-26 18:12:42',1),
(16,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 6\nid_kategorije = 6\nnaziv = шљива\nid_jm = 17\nnapomena = \ncreated_at = 2025-03-26 18:12:55\nupdated_at = 2025-03-26 18:12:55\n','2025-03-26 18:12:55',1),
(17,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 7\nid_kategorije = 7\nnaziv = шљива\nid_jm = 17\nnapomena = \ncreated_at = 2025-03-26 18:13:08\nupdated_at = 2025-03-26 18:13:08\n','2025-03-26 18:13:08',1),
(18,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 8\nid_kategorije = 8\nnaziv = шљива\nid_jm = 17\nnapomena = \ncreated_at = 2025-03-26 18:13:47\nupdated_at = 2025-03-26 18:13:47\n','2025-03-26 18:13:47',1),
(19,'ИЗМЕНА','Измена категорије артикла','kategorije_artikala','[NEW]\nid = 8\nnaziv = ракија за флаширање\nopis = готова ракија спремна за флаширање\ncreated_at = 2025-03-26 18:11:36\nupdated_at = 2025-03-26 18:11:36\n\n[OLD]\nid = 8\nnaziv = готов производ\nopis = \ncreated_at = 2025-03-26 18:11:36\nupdated_at = 2025-03-26 18:11:36\n','2025-03-26 18:15:22',1),
(20,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 9\nnaziv = флаширана ракија\nopis = \ncreated_at = 2025-03-26 18:15:57\nupdated_at = 2025-03-26 18:15:57\n','2025-03-26 18:15:57',1),
(21,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 9\nid_kategorije = 9\nnaziv = Дража шљива 0.7 l\nid_jm = 14\nnapomena = \ncreated_at = 2025-03-26 18:17:04\nupdated_at = 2025-03-26 18:17:04\n','2025-03-26 18:17:04',1),
(22,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 10\nid_kategorije = 9\nnaziv = Дража шљива 1 l\nid_jm = 14\nnapomena = \ncreated_at = 2025-03-26 18:17:56\nupdated_at = 2025-03-26 18:17:56\n','2025-03-26 18:17:56',1),
(23,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 4\nnaziv = сировине\nopis = магацин сировина\ncreated_at = 2025-03-26 18:18:45\nupdated_at = 2025-03-26 18:18:45\n','2025-03-26 18:18:45',1),
(24,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 5\nnaziv = кљук\nopis = магацин џибре\ncreated_at = 2025-03-26 18:19:03\nupdated_at = 2025-03-26 18:19:03\n','2025-03-26 18:19:03',1),
(25,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 6\nnaziv = мека ракија\nopis = магацин меке ракије\ncreated_at = 2025-03-26 18:19:25\nupdated_at = 2025-03-26 18:19:25\n','2025-03-26 18:19:25',1),
(26,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 7\nnaziv = љута ракија\nopis = магацин препечене ракије\ncreated_at = 2025-03-26 18:19:46\nupdated_at = 2025-03-26 18:19:46\n','2025-03-26 18:19:46',1),
(27,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 8\nnaziv = ракија за флаширање\nopis = магацин ракије спремне за флаширање\ncreated_at = 2025-03-26 18:20:49\nupdated_at = 2025-03-26 18:20:49\n','2025-03-26 18:20:49',1),
(28,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 9\nnaziv = готови производи\nopis = магацин готових производа\ncreated_at = 2025-03-26 18:21:15\nupdated_at = 2025-03-26 18:21:15\n','2025-03-26 18:21:15',1),
(29,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 4\nid_tipa = 4\nnaziv = магацин сировина 1\nadresa = Место, Улица 22\nnapomena = \ncreated_at = 2025-03-26 18:21:57\nupdated_at = 2025-03-26 18:21:57\n','2025-03-26 18:21:57',1),
(30,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 5\nid_tipa = 4\nnaziv = магацин сировина\nadresa = Место, Улица 30\nnapomena = \ncreated_at = 2025-03-26 18:22:24\nupdated_at = 2025-03-26 18:22:24\n','2025-03-26 18:22:24',1),
(31,'ИЗМЕНА','Измена магацина','magacini','[NEW]\nid = 5\nid_tipa = 4\nnaziv = магацин сировина 2\nadresa = Место, Улица 30\nnapomena = \ncreated_at = 2025-03-26 18:22:24\nupdated_at = 2025-03-26 18:22:24\n\n[OLD]\nid = 5\nid_tipa = 4\nnaziv = магацин сировина\nadresa = Место, Улица 30\nnapomena = \ncreated_at = 2025-03-26 18:22:24\nupdated_at = 2025-03-26 18:22:24\n','2025-03-26 18:22:32',1),
(32,'ИЗМЕНА','Измена артикла','artikli','[NEW]\nid = 8\nid_kategorije = 8\nnaziv = шљива\nid_jm = 16\nnapomena = \ncreated_at = 2025-03-26 18:13:47\nupdated_at = 2025-03-26 18:13:47\n\n[OLD]\nid = 8\nid_kategorije = 8\nnaziv = шљива\nid_jm = 17\nnapomena = \ncreated_at = 2025-03-26 18:13:47\nupdated_at = 2025-03-26 18:13:47\n','2025-03-26 18:22:57',1),
(33,'ИЗМЕНА','Измена артикла','artikli','[NEW]\nid = 8\nid_kategorije = 8\nnaziv = шљива\nid_jm = 17\nnapomena = \ncreated_at = 2025-03-26 18:13:47\nupdated_at = 2025-03-26 18:13:47\n\n[OLD]\nid = 8\nid_kategorije = 8\nnaziv = шљива\nid_jm = 16\nnapomena = \ncreated_at = 2025-03-26 18:13:47\nupdated_at = 2025-03-26 18:13:47\n','2025-03-26 18:23:03',1),
(34,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 6\nid_tipa = 5\nnaziv = магацин кљука\nadresa = Место, Улица 44\nnapomena = \ncreated_at = 2025-03-26 18:24:13\nupdated_at = 2025-03-26 18:24:13\n','2025-03-26 18:24:13',1),
(35,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 7\nid_tipa = 6\nnaziv = магацин меке ракије\nadresa = Место, Улица 11\nnapomena = \ncreated_at = 2025-03-26 18:24:34\nupdated_at = 2025-03-26 18:24:34\n','2025-03-26 18:24:34',1),
(36,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 8\nid_tipa = 7\nnaziv = магацин љуте ракије\nadresa = Место, Улица 1\nnapomena = \ncreated_at = 2025-03-26 18:24:52\nupdated_at = 2025-03-26 18:24:52\n','2025-03-26 18:24:52',1),
(37,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 9\nid_tipa = 8\nnaziv = магацин ракије спремне за флаширање\nadresa = Место, Улица 5\nnapomena = \ncreated_at = 2025-03-26 18:25:27\nupdated_at = 2025-03-26 18:25:27\n','2025-03-26 18:25:27',1),
(38,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 10\nid_tipa = 9\nnaziv = магацин готових производа\nadresa = Место, Улица 51\nnapomena = \ncreated_at = 2025-03-26 18:26:02\nupdated_at = 2025-03-26 18:26:02\n','2025-03-26 18:26:02',1),
(39,'ДОДАВАЊЕ','Додавање купца','kupci','[NEW]\nid = 3\nnaziv = купац 1\nadresa_mesto = Београд\nadresa_ulica = Улица\nadresa_broj = 12\ntelefon = 011 222 333\nemail = \nnapomena = плаћа нередовно\ncreated_at = 2025-03-26 18:33:12\nupdated_at = 2025-03-26 18:33:12\n','2025-03-26 18:33:12',1),
(40,'ДОДАВАЊЕ','Додавање купца','kupci','[NEW]\nid = 4\nnaziv = купац 2\nadresa_mesto = Ниш\nadresa_ulica = Улица\nadresa_broj = 12\ntelefon = \nemail = \nnapomena = \ncreated_at = 2025-03-26 18:33:50\nupdated_at = 2025-03-26 18:33:50\n','2025-03-26 18:33:50',1),
(41,'ДОДАВАЊЕ','Додавање добављача','dobavljaci','[NEW]\nid = 3\nadresa_mesto = \nadresa_ulica = \nadresa_broj = \ntelefon = \nemail = \nnaziv = добављач 1\nnapomena = \ncreated_at = 2025-03-26 18:34:13\nupdated_at = 2025-03-26 18:34:13\n','2025-03-26 18:34:13',1),
(42,'ДОДАВАЊЕ','Додавање добављача','dobavljaci','[NEW]\nid = 4\nadresa_mesto = \nadresa_ulica = \nadresa_broj = \ntelefon = \nemail = \nnaziv = добављач 2\nnapomena = \ncreated_at = 2025-03-26 18:34:25\nupdated_at = 2025-03-26 18:34:25\n','2025-03-26 18:34:25',1),
(43,'ДОДАВАЊЕ','Додавање добављача','dobavljaci','[NEW]\nid = 5\nadresa_mesto = \nadresa_ulica = \nadresa_broj = \ntelefon = \nemail = \nnaziv = добављач 3\nnapomena = \ncreated_at = 2025-03-26 18:34:36\nupdated_at = 2025-03-26 18:34:36\n','2025-03-26 18:34:36',1),
(44,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 4\ndatum = 2025-03-05\nbroj = СШ-001/2025\nid_dobavljaca = 3\nid_magacina = 4\nnapomena = \ncreated_at = 2025-03-26 18:37:12\nupdated_at = 2025-03-26 18:37:12\n','2025-03-26 18:37:12',1),
(45,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 1\nid_prijemnice = 4\nid_artikla = 4\nkolicina = 5500.00\ncreated_at = 2025-03-26 18:37:46\nupdated_at = 2025-03-26 18:37:46\n','2025-03-26 18:37:46',1),
(46,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 5\ndatum = 2025-03-07\nbroj = СШ-002/2025\nid_dobavljaca = 3\nid_magacina = 4\nnapomena = \ncreated_at = 2025-03-26 18:38:34\nupdated_at = 2025-03-26 18:38:34\n','2025-03-26 18:38:34',1),
(47,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 2\nid_prijemnice = 5\nid_artikla = 4\nkolicina = 2750.00\ncreated_at = 2025-03-26 18:39:21\nupdated_at = 2025-03-26 18:39:21\n','2025-03-26 18:39:21',1),
(48,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 6\ndatum = 2025-03-10\nbroj = ДД-006/2025\nid_dobavljaca = 4\nid_magacina = 5\nnapomena = \ncreated_at = 2025-03-26 18:40:21\nupdated_at = 2025-03-26 18:40:21\n','2025-03-26 18:40:21',1),
(49,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 3\nid_prijemnice = 6\nid_artikla = 4\nkolicina = 8050.00\ncreated_at = 2025-03-26 18:40:47\nupdated_at = 2025-03-26 18:40:47\n','2025-03-26 18:40:47',1),
(50,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 7\ndatum = 2025-03-15\nbroj = ПР-003\nid_dobavljaca = 5\nid_magacina = 5\nnapomena = \ncreated_at = 2025-03-26 18:43:36\nupdated_at = 2025-03-26 18:43:36\n','2025-03-26 18:43:36',1),
(51,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 4\nid_prijemnice = 7\nid_artikla = 4\nkolicina = 11240.00\ncreated_at = 2025-03-26 18:43:58\nupdated_at = 2025-03-26 18:43:58\n','2025-03-26 18:43:58',1),
(52,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 11\nid_kategorije = 4\nnaziv = крушка\nid_jm = 15\nnapomena = \ncreated_at = 2025-03-26 18:52:54\nupdated_at = 2025-03-26 18:52:54\n','2025-03-26 18:52:54',1),
(53,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 5\nid_prijemnice = 5\nid_artikla = 11\nkolicina = 4950.00\ncreated_at = 2025-03-26 18:53:26\nupdated_at = 2025-03-26 18:53:26\n','2025-03-26 18:53:26',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `magacini`
--

LOCK TABLES `magacini` WRITE;
/*!40000 ALTER TABLE `magacini` DISABLE KEYS */;
INSERT INTO `magacini` VALUES
(4,4,'магацин сировина 1','Место, Улица 22','','2025-03-26 18:21:57','2025-03-26 18:21:57'),
(5,4,'магацин сировина 2','Место, Улица 30','','2025-03-26 18:22:24','2025-03-26 18:22:24'),
(6,5,'магацин кљука','Место, Улица 44','','2025-03-26 18:24:13','2025-03-26 18:24:13'),
(7,6,'магацин меке ракије','Место, Улица 11','','2025-03-26 18:24:34','2025-03-26 18:24:34'),
(8,7,'магацин љуте ракије','Место, Улица 1','','2025-03-26 18:24:52','2025-03-26 18:24:52'),
(9,8,'магацин ракије спремне за флаширање','Место, Улица 5','','2025-03-26 18:25:27','2025-03-26 18:25:27'),
(10,9,'магацин готових производа','Место, Улица 51','','2025-03-26 18:26:02','2025-03-26 18:26:02');
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
  `kolicina` decimal(16,2) NOT NULL DEFAULT 0.00,
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `nalog_artial_nalozi_FK` (`id_naloga`),
  KEY `nalog_artial_artikli_FK` (`id_artikla`),
  CONSTRAINT `nalog_artial_artikli_FK` FOREIGN KEY (`id_artikla`) REFERENCES `artikli` (`id`),
  CONSTRAINT `nalog_artial_nalozi_FK` FOREIGN KEY (`id_naloga`) REFERENCES `nalozi` (`id`)
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
  `datum` date NOT NULL,
  `broj` varchar(100) NOT NULL,
  `id_iz_mag` int(10) unsigned NOT NULL,
  `id_u_mag` int(10) unsigned NOT NULL,
  `napomena` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `prijemnice_dobavljaci_FK` (`id_iz_mag`) USING BTREE,
  KEY `nalozi_magacini_FK_1` (`id_u_mag`),
  CONSTRAINT `nalozi_magacini_FK` FOREIGN KEY (`id_iz_mag`) REFERENCES `magacini` (`id`),
  CONSTRAINT `nalozi_magacini_FK_1` FOREIGN KEY (`id_u_mag`) REFERENCES `magacini` (`id`)
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
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `prijemnica_artikal_artikli_FK` (`id_artikla`) USING BTREE,
  KEY `prijemnica_artikal_prijemnice_FK` (`id_otpremnice`) USING BTREE,
  CONSTRAINT `otpremnica_artikal_artikli_FK` FOREIGN KEY (`id_artikla`) REFERENCES `artikli` (`id`),
  CONSTRAINT `otpremnica_artikal_otpremnice_FK` FOREIGN KEY (`id_otpremnice`) REFERENCES `otpremnice` (`id`)
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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `otpremnice_kupci_FK` (`id_kupca`),
  KEY `otpremnice_magacini_FK` (`id_magacina`),
  CONSTRAINT `otpremnice_kupci_FK` FOREIGN KEY (`id_kupca`) REFERENCES `kupci` (`id`),
  CONSTRAINT `otpremnice_magacini_FK` FOREIGN KEY (`id_magacina`) REFERENCES `magacini` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `prijemnica_artikal_prijemnice_FK` (`id_prijemnice`),
  KEY `prijemnica_artikal_artikli_FK` (`id_artikla`),
  CONSTRAINT `prijemnica_artikal_artikli_FK` FOREIGN KEY (`id_artikla`) REFERENCES `artikli` (`id`),
  CONSTRAINT `prijemnica_artikal_prijemnice_FK` FOREIGN KEY (`id_prijemnice`) REFERENCES `prijemnice` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijemnica_artikal`
--

LOCK TABLES `prijemnica_artikal` WRITE;
/*!40000 ALTER TABLE `prijemnica_artikal` DISABLE KEYS */;
INSERT INTO `prijemnica_artikal` VALUES
(1,4,4,5500.00,NULL,'2025-03-26 18:37:46','2025-03-26 18:37:46'),
(2,5,4,2750.00,NULL,'2025-03-26 18:39:21','2025-03-26 18:39:21'),
(3,6,4,8050.00,NULL,'2025-03-26 18:40:47','2025-03-26 18:40:47'),
(4,7,4,11240.00,NULL,'2025-03-26 18:43:58','2025-03-26 18:43:58'),
(5,5,11,4950.00,NULL,'2025-03-26 18:53:26','2025-03-26 18:53:26');
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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `prijemnice_dobavljaci_FK` (`id_dobavljaca`),
  KEY `prijemnice_magacini_FK` (`id_magacina`),
  CONSTRAINT `prijemnice_dobavljaci_FK` FOREIGN KEY (`id_dobavljaca`) REFERENCES `dobavljaci` (`id`),
  CONSTRAINT `prijemnice_magacini_FK` FOREIGN KEY (`id_magacina`) REFERENCES `magacini` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijemnice`
--

LOCK TABLES `prijemnice` WRITE;
/*!40000 ALTER TABLE `prijemnice` DISABLE KEYS */;
INSERT INTO `prijemnice` VALUES
(4,'2025-03-05','СШ-001/2025',3,4,'','2025-03-26 18:37:12','2025-03-26 18:37:12'),
(5,'2025-03-07','СШ-002/2025',3,4,'','2025-03-26 18:38:34','2025-03-26 18:38:34'),
(6,'2025-03-10','ДД-006/2025',4,5,'','2025-03-26 18:40:21','2025-03-26 18:40:21'),
(7,'2025-03-15','ПР-003',5,5,'','2025-03-26 18:43:36','2025-03-26 18:43:36');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stanje`
--

LOCK TABLES `stanje` WRITE;
/*!40000 ALTER TABLE `stanje` DISABLE KEYS */;
INSERT INTO `stanje` VALUES
(1,4,4,8250.00,'2025-03-26 18:37:46','2025-03-26 18:37:46'),
(2,5,4,19290.00,'2025-03-26 18:40:47','2025-03-26 18:40:47'),
(3,4,11,4950.00,'2025-03-26 18:53:26','2025-03-26 18:53:26');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipovi_magacina`
--

LOCK TABLES `tipovi_magacina` WRITE;
/*!40000 ALTER TABLE `tipovi_magacina` DISABLE KEYS */;
INSERT INTO `tipovi_magacina` VALUES
(4,'сировине','магацин сировина','2025-03-26 18:18:45','2025-03-26 18:18:45'),
(5,'кљук','магацин џибре','2025-03-26 18:19:03','2025-03-26 18:19:03'),
(6,'мека ракија','магацин меке ракије','2025-03-26 18:19:25','2025-03-26 18:19:25'),
(7,'љута ракија','магацин препечене ракије','2025-03-26 18:19:46','2025-03-26 18:19:46'),
(8,'ракија за флаширање','магацин ракије спремне за флаширање','2025-03-26 18:20:49','2025-03-26 18:20:49'),
(9,'готови производи','магацин готових производа','2025-03-26 18:21:15','2025-03-26 18:21:15');
/*!40000 ALTER TABLE `tipovi_magacina` ENABLE KEYS */;
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

-- Dump completed on 2025-03-26 19:21:58
