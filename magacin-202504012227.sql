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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artikli`
--

LOCK TABLES `artikli` WRITE;
/*!40000 ALTER TABLE `artikli` DISABLE KEYS */;
INSERT INTO `artikli` VALUES
(1,1,'шљива',2,'','2025-04-01 19:28:52','2025-04-01 19:28:52'),
(2,2,'шљива',3,'','2025-04-01 19:29:12','2025-04-01 19:29:12'),
(3,3,'шљива',3,'','2025-04-01 19:29:22','2025-04-01 19:29:22'),
(4,4,'шљива',3,'','2025-04-01 19:29:38','2025-04-01 19:29:38'),
(5,5,'шљива',3,'','2025-04-01 19:29:53','2025-04-01 19:29:53'),
(6,6,'Дража шљива 0.7 л',1,'','2025-04-01 19:31:06','2025-04-01 19:31:06'),
(7,6,'Дража шљива 1 л',1,'','2025-04-01 19:31:31','2025-04-01 19:31:31'),
(8,1,'дуња',2,'','2025-04-01 19:32:07','2025-04-01 19:32:07'),
(9,2,'дуња',3,'','2025-04-01 19:32:29','2025-04-01 19:32:29'),
(10,3,'дуња',3,'','2025-04-01 19:32:38','2025-04-01 19:32:38'),
(11,4,'дуња',3,'','2025-04-01 19:33:01','2025-04-01 19:33:01'),
(12,5,'дуња',3,'','2025-04-01 19:33:19','2025-04-01 19:33:19'),
(13,6,'Дража дуња 0.7 л',1,'','2025-04-01 19:34:05','2025-04-01 19:34:05'),
(14,6,'Дража дуња 1 л',1,'','2025-04-01 19:34:22','2025-04-01 19:34:22'),
(15,7,'Флаша чутурица 0.7 л',1,'','2025-04-01 19:35:33','2025-04-01 19:35:33'),
(16,7,'Флаша 1 л',1,'','2025-04-01 19:35:50','2025-04-01 19:35:50'),
(17,7,'Затварач за флашу (чеп)',1,'','2025-04-01 19:37:15','2025-04-01 19:37:15'),
(18,8,'Неки артикал 1',3,'','2025-04-01 19:38:00','2025-04-01 19:38:29'),
(19,8,'Неки атрикал 2',1,'','2025-04-01 19:38:16','2025-04-01 19:38:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dobavljaci`
--

LOCK TABLES `dobavljaci` WRITE;
/*!40000 ALTER TABLE `dobavljaci` DISABLE KEYS */;
INSERT INTO `dobavljaci` VALUES
(1,'Град','Улица','1','000 00 00 000','dobavljac@example.com','Добављач 1','','2025-04-01 19:21:22','2025-04-01 19:21:22'),
(2,'','','','','','Добављач 2','','2025-04-01 19:21:53','2025-04-01 19:21:53'),
(3,'','','','','','Добављач 3','','2025-04-01 19:21:59','2025-04-01 19:21:59');
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
(1,'kom','комад','','2025-04-01 19:11:03','2025-04-01 19:11:03'),
(2,'kg','килограм','','2025-04-01 19:11:20','2025-04-01 19:11:20'),
(3,'l','литар','','2025-04-01 19:11:42','2025-04-01 19:11:42');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategorije_artikala`
--

LOCK TABLES `kategorije_artikala` WRITE;
/*!40000 ALTER TABLE `kategorije_artikala` DISABLE KEYS */;
INSERT INTO `kategorije_artikala` VALUES
(1,'сировина','','2025-04-01 19:12:12','2025-04-01 19:12:12'),
(2,'кљук','','2025-04-01 19:12:24','2025-04-01 19:12:24'),
(3,'мека','','2025-04-01 19:12:38','2025-04-01 19:12:38'),
(4,'дестилат','','2025-04-01 19:12:46','2025-04-01 19:12:46'),
(5,'ракија','готова ракија за флаширање','2025-04-01 19:13:36','2025-04-01 19:13:36'),
(6,'готов производ','','2025-04-01 19:14:21','2025-04-01 19:14:21'),
(7,'амбалажа','','2025-04-01 19:14:40','2025-04-01 19:14:40'),
(8,'разно','','2025-04-01 19:15:26','2025-04-01 19:15:26');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kupci`
--

LOCK TABLES `kupci` WRITE;
/*!40000 ALTER TABLE `kupci` DISABLE KEYS */;
INSERT INTO `kupci` VALUES
(1,'Купац 1','Град','Улица','22','000 00 00 000','kupac@example.com','','2025-04-01 19:19:30','2025-04-01 19:21:41'),
(2,'Купац 2','','','','','','','2025-04-01 19:19:46','2025-04-01 19:19:46'),
(3,'Купац 3','','','','','','','2025-04-01 19:20:00','2025-04-01 19:20:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logovi`
--

LOCK TABLES `logovi` WRITE;
/*!40000 ALTER TABLE `logovi` DISABLE KEYS */;
INSERT INTO `logovi` VALUES
(1,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 1\njm = kom\nnaziv = комад\nopis = \ncreated_at = 2025-04-01 19:11:03\nupdated_at = 2025-04-01 19:11:03\n','2025-04-01 19:11:03',1),
(2,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 2\njm = kg\nnaziv = килограм\nopis = \ncreated_at = 2025-04-01 19:11:20\nupdated_at = 2025-04-01 19:11:20\n','2025-04-01 19:11:20',1),
(3,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 3\njm = l\nnaziv = литар\nopis = \ncreated_at = 2025-04-01 19:11:42\nupdated_at = 2025-04-01 19:11:42\n','2025-04-01 19:11:42',1),
(4,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 1\nnaziv = сировина\nopis = \ncreated_at = 2025-04-01 19:12:12\nupdated_at = 2025-04-01 19:12:12\n','2025-04-01 19:12:12',1),
(5,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 2\nnaziv = кљук\nopis = \ncreated_at = 2025-04-01 19:12:24\nupdated_at = 2025-04-01 19:12:24\n','2025-04-01 19:12:24',1),
(6,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 3\nnaziv = мека\nopis = \ncreated_at = 2025-04-01 19:12:38\nupdated_at = 2025-04-01 19:12:38\n','2025-04-01 19:12:38',1),
(7,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 4\nnaziv = дестилат\nopis = \ncreated_at = 2025-04-01 19:12:46\nupdated_at = 2025-04-01 19:12:46\n','2025-04-01 19:12:46',1),
(8,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 5\nnaziv = ракија\nopis = готова ракија за флаширање\ncreated_at = 2025-04-01 19:13:36\nupdated_at = 2025-04-01 19:13:36\n','2025-04-01 19:13:36',1),
(9,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 6\nnaziv = готов производ\nopis = \ncreated_at = 2025-04-01 19:14:21\nupdated_at = 2025-04-01 19:14:21\n','2025-04-01 19:14:21',1),
(10,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 7\nnaziv = амбалажа\nopis = \ncreated_at = 2025-04-01 19:14:40\nupdated_at = 2025-04-01 19:14:40\n','2025-04-01 19:14:40',1),
(11,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 8\nnaziv = разно\nopis = \ncreated_at = 2025-04-01 19:15:26\nupdated_at = 2025-04-01 19:15:26\n','2025-04-01 19:15:26',1),
(12,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 1\nnaziv = сировина\nopis = \ncreated_at = 2025-04-01 19:15:58\nupdated_at = 2025-04-01 19:15:58\n','2025-04-01 19:15:58',1),
(13,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 2\nnaziv = кљук\nopis = \ncreated_at = 2025-04-01 19:16:26\nupdated_at = 2025-04-01 19:16:26\n','2025-04-01 19:16:26',1),
(14,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 3\nnaziv = мека\nopis = \ncreated_at = 2025-04-01 19:16:38\nupdated_at = 2025-04-01 19:16:38\n','2025-04-01 19:16:38',1),
(15,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 4\nnaziv = дестилат\nopis = \ncreated_at = 2025-04-01 19:16:51\nupdated_at = 2025-04-01 19:16:51\n','2025-04-01 19:16:51',1),
(16,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 5\nnaziv = ракија\nopis = ракија спремна за флаширање\ncreated_at = 2025-04-01 19:17:15\nupdated_at = 2025-04-01 19:17:15\n','2025-04-01 19:17:15',1),
(17,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 6\nnaziv = готов производ\nopis = \ncreated_at = 2025-04-01 19:17:32\nupdated_at = 2025-04-01 19:17:32\n','2025-04-01 19:17:32',1),
(18,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 7\nnaziv = амбалажа\nopis = \ncreated_at = 2025-04-01 19:17:57\nupdated_at = 2025-04-01 19:17:57\n','2025-04-01 19:17:57',1),
(19,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 8\nnaziv = разно\nopis = \ncreated_at = 2025-04-01 19:18:12\nupdated_at = 2025-04-01 19:18:12\n','2025-04-01 19:18:12',1),
(20,'ДОДАВАЊЕ','Додавање купца','kupci','[NEW]\nid = 1\nnaziv = Купац 1\nadresa_mesto = Град\nadresa_ulica = Улица\nadresa_broj = 22\ntelefon = 000 00 00 000\nemail = email@example.com\nnapomena = \ncreated_at = 2025-04-01 19:19:30\nupdated_at = 2025-04-01 19:19:30\n','2025-04-01 19:19:30',1),
(21,'ДОДАВАЊЕ','Додавање купца','kupci','[NEW]\nid = 2\nnaziv = Купац 2\nadresa_mesto = \nadresa_ulica = \nadresa_broj = \ntelefon = \nemail = \nnapomena = \ncreated_at = 2025-04-01 19:19:46\nupdated_at = 2025-04-01 19:19:46\n','2025-04-01 19:19:46',1),
(22,'ДОДАВАЊЕ','Додавање купца','kupci','[NEW]\nid = 3\nnaziv = Купац 3\nadresa_mesto = \nadresa_ulica = \nadresa_broj = \ntelefon = \nemail = \nnapomena = \ncreated_at = 2025-04-01 19:20:00\nupdated_at = 2025-04-01 19:20:00\n','2025-04-01 19:20:00',1),
(23,'ДОДАВАЊЕ','Додавање добављача','dobavljaci','[NEW]\nid = 1\nadresa_mesto = Град\nadresa_ulica = Улица\nadresa_broj = 1\ntelefon = 000 00 00 000\nemail = dobavljac@example.com\nnaziv = Добављач 1\nnapomena = \ncreated_at = 2025-04-01 19:21:22\nupdated_at = 2025-04-01 19:21:22\n','2025-04-01 19:21:22',1),
(24,'ИЗМЕНА','Измена купца','kupci','[NEW]\nid = 1\nnaziv = Купац 1\nadresa_mesto = Град\nadresa_ulica = Улица\nadresa_broj = 22\ntelefon = 000 00 00 000\nemail = kupac@example.com\nnapomena = \ncreated_at = 2025-04-01 19:19:30\nupdated_at = 2025-04-01 19:21:41\n\n[OLD]\nid = 1\nnaziv = Купац 1\nadresa_mesto = Град\nadresa_ulica = Улица\nadresa_broj = 22\ntelefon = 000 00 00 000\nemail = email@example.com\nnapomena = \ncreated_at = 2025-04-01 19:19:30\nupdated_at = 2025-04-01 19:19:30\n','2025-04-01 19:21:41',1),
(25,'ДОДАВАЊЕ','Додавање добављача','dobavljaci','[NEW]\nid = 2\nadresa_mesto = \nadresa_ulica = \nadresa_broj = \ntelefon = \nemail = \nnaziv = Добављач 2\nnapomena = \ncreated_at = 2025-04-01 19:21:53\nupdated_at = 2025-04-01 19:21:53\n','2025-04-01 19:21:53',1),
(26,'ДОДАВАЊЕ','Додавање добављача','dobavljaci','[NEW]\nid = 3\nadresa_mesto = \nadresa_ulica = \nadresa_broj = \ntelefon = \nemail = \nnaziv = Добављач 3\nnapomena = \ncreated_at = 2025-04-01 19:21:59\nupdated_at = 2025-04-01 19:21:59\n','2025-04-01 19:21:59',1),
(27,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 1\nid_tipa = 1\nnaziv = Магацин сировина 1\nadresa = Град, Улица 2/3\nnapomena = \ncreated_at = 2025-04-01 19:22:54\nupdated_at = 2025-04-01 19:22:54\n','2025-04-01 19:22:54',1),
(28,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 2\nid_tipa = 1\nnaziv = Магацин сировина 2\nadresa = Град, Улица 5/6\nnapomena = \ncreated_at = 2025-04-01 19:23:19\nupdated_at = 2025-04-01 19:23:19\n','2025-04-01 19:23:19',1),
(29,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 3\nid_tipa = 2\nnaziv = Магацин кљука 1\nadresa = Град, Улица 1/1\nnapomena = \ncreated_at = 2025-04-01 19:24:11\nupdated_at = 2025-04-01 19:24:11\n','2025-04-01 19:24:11',1),
(30,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 4\nid_tipa = 1\nnaziv = Магацин меке ракије 1\nadresa = Град, Улица 1/2\nnapomena = \ncreated_at = 2025-04-01 19:24:36\nupdated_at = 2025-04-01 19:24:36\n','2025-04-01 19:24:36',1),
(31,'ИЗМЕНА','Измена магацина','magacini','[NEW]\nid = 4\nid_tipa = 3\nnaziv = Магацин меке ракије 1\nadresa = Град, Улица 1/2\nnapomena = \ncreated_at = 2025-04-01 19:24:36\nupdated_at = 2025-04-01 19:24:44\n\n[OLD]\nid = 4\nid_tipa = 1\nnaziv = Магацин меке ракије 1\nadresa = Град, Улица 1/2\nnapomena = \ncreated_at = 2025-04-01 19:24:36\nupdated_at = 2025-04-01 19:24:36\n','2025-04-01 19:24:44',1),
(32,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 5\nid_tipa = 4\nnaziv = Магацин дестилата 1\nadresa = Град, Улица 1/3\nnapomena = \ncreated_at = 2025-04-01 19:25:05\nupdated_at = 2025-04-01 19:25:05\n','2025-04-01 19:25:05',1),
(33,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 6\nid_tipa = 5\nnaziv = Магацин готове ракије 1\nadresa = Град, Улица 1/4\nnapomena = \ncreated_at = 2025-04-01 19:25:38\nupdated_at = 2025-04-01 19:25:38\n','2025-04-01 19:25:38',1),
(34,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 7\nid_tipa = 6\nnaziv = Магацин готових производа 1\nadresa = Град, Улица 2/7\nnapomena = \ncreated_at = 2025-04-01 19:26:23\nupdated_at = 2025-04-01 19:26:23\n','2025-04-01 19:26:23',1),
(35,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 8\nid_tipa = 6\nnaziv = Магацин готових производа 1\nadresa = Град, Улица 3/6\nnapomena = \ncreated_at = 2025-04-01 19:26:51\nupdated_at = 2025-04-01 19:26:51\n','2025-04-01 19:26:51',1),
(36,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 9\nid_tipa = 7\nnaziv = Магацин амбалаже 1\nadresa = Град, Улица 1/1\nnapomena = \ncreated_at = 2025-04-01 19:27:39\nupdated_at = 2025-04-01 19:27:39\n','2025-04-01 19:27:39',1),
(37,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 10\nid_tipa = 8\nnaziv = Магацин разне робе\nadresa = Град, Улица 1/1\nnapomena = \ncreated_at = 2025-04-01 19:28:11\nupdated_at = 2025-04-01 19:28:11\n','2025-04-01 19:28:11',1),
(38,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 1\nid_kategorije = 1\nnaziv = шљива\nid_jm = 2\nnapomena = \ncreated_at = 2025-04-01 19:28:52\nupdated_at = 2025-04-01 19:28:52\n','2025-04-01 19:28:52',1),
(39,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 2\nid_kategorije = 2\nnaziv = шљива\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:29:12\nupdated_at = 2025-04-01 19:29:12\n','2025-04-01 19:29:12',1),
(40,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 3\nid_kategorije = 3\nnaziv = шљива\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:29:22\nupdated_at = 2025-04-01 19:29:22\n','2025-04-01 19:29:22',1),
(41,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 4\nid_kategorije = 4\nnaziv = шљива\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:29:38\nupdated_at = 2025-04-01 19:29:38\n','2025-04-01 19:29:38',1),
(42,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 5\nid_kategorije = 5\nnaziv = шљива\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:29:53\nupdated_at = 2025-04-01 19:29:53\n','2025-04-01 19:29:53',1),
(43,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 6\nid_kategorije = 6\nnaziv = Дража шљива 0.7 л\nid_jm = 1\nnapomena = \ncreated_at = 2025-04-01 19:31:06\nupdated_at = 2025-04-01 19:31:06\n','2025-04-01 19:31:06',1),
(44,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 7\nid_kategorije = 6\nnaziv = Дража шљива 1 л\nid_jm = 1\nnapomena = \ncreated_at = 2025-04-01 19:31:31\nupdated_at = 2025-04-01 19:31:31\n','2025-04-01 19:31:31',1),
(45,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 8\nid_kategorije = 1\nnaziv = дуња\nid_jm = 2\nnapomena = \ncreated_at = 2025-04-01 19:32:07\nupdated_at = 2025-04-01 19:32:07\n','2025-04-01 19:32:07',1),
(46,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 9\nid_kategorije = 2\nnaziv = дуња\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:32:29\nupdated_at = 2025-04-01 19:32:29\n','2025-04-01 19:32:29',1),
(47,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 10\nid_kategorije = 3\nnaziv = дуња\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:32:38\nupdated_at = 2025-04-01 19:32:38\n','2025-04-01 19:32:38',1),
(48,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 11\nid_kategorije = 4\nnaziv = дуња\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:33:01\nupdated_at = 2025-04-01 19:33:01\n','2025-04-01 19:33:01',1),
(49,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 12\nid_kategorije = 5\nnaziv = дуња\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:33:19\nupdated_at = 2025-04-01 19:33:19\n','2025-04-01 19:33:19',1),
(50,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 13\nid_kategorije = 6\nnaziv = Дража дуња 0.7 л\nid_jm = 1\nnapomena = \ncreated_at = 2025-04-01 19:34:05\nupdated_at = 2025-04-01 19:34:05\n','2025-04-01 19:34:05',1),
(51,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 14\nid_kategorije = 6\nnaziv = Дража дуња 1 л\nid_jm = 1\nnapomena = \ncreated_at = 2025-04-01 19:34:22\nupdated_at = 2025-04-01 19:34:22\n','2025-04-01 19:34:22',1),
(52,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 15\nid_kategorije = 7\nnaziv = Флаша чутурица 0.7 л\nid_jm = 1\nnapomena = \ncreated_at = 2025-04-01 19:35:33\nupdated_at = 2025-04-01 19:35:33\n','2025-04-01 19:35:33',1),
(53,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 16\nid_kategorije = 7\nnaziv = Флаша 1 л\nid_jm = 1\nnapomena = \ncreated_at = 2025-04-01 19:35:50\nupdated_at = 2025-04-01 19:35:50\n','2025-04-01 19:35:50',1),
(54,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 17\nid_kategorije = 7\nnaziv = Затварач за флашу (чеп)\nid_jm = 1\nnapomena = \ncreated_at = 2025-04-01 19:37:15\nupdated_at = 2025-04-01 19:37:15\n','2025-04-01 19:37:15',1),
(55,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 18\nid_kategorije = 8\nnaziv = Неки артикал\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:38:00\nupdated_at = 2025-04-01 19:38:00\n','2025-04-01 19:38:00',1),
(56,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 19\nid_kategorije = 8\nnaziv = Неки атрикал 2\nid_jm = 1\nnapomena = \ncreated_at = 2025-04-01 19:38:16\nupdated_at = 2025-04-01 19:38:16\n','2025-04-01 19:38:16',1),
(57,'ИЗМЕНА','Измена артикла','artikli','[NEW]\nid = 18\nid_kategorije = 8\nnaziv = Неки артикал 1\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:38:00\nupdated_at = 2025-04-01 19:38:29\n\n[OLD]\nid = 18\nid_kategorije = 8\nnaziv = Неки артикал\nid_jm = 3\nnapomena = \ncreated_at = 2025-04-01 19:38:00\nupdated_at = 2025-04-01 19:38:00\n','2025-04-01 19:38:29',1),
(58,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 1\ndatum = 2025-03-02\nbroj = БР-123/2025\nid_dobavljaca = 1\nid_magacina = 1\nnapomena = \ncreated_at = 2025-04-01 19:44:41\nupdated_at = 2025-04-01 19:44:41\n','2025-04-01 19:44:41',1),
(59,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 1\nid_prijemnice = 1\nid_artikla = 1\nkolicina = 8000.00\nopis = \ncreated_at = 2025-04-01 19:44:57\nupdated_at = 2025-04-01 19:44:57\n','2025-04-01 19:44:57',1),
(60,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 2\nid_prijemnice = 1\nid_artikla = 8\nkolicina = 5250.00\nopis = \ncreated_at = 2025-04-01 19:45:17\nupdated_at = 2025-04-01 19:45:17\n','2025-04-01 19:45:17',1),
(61,'БРИСАЊЕ','Брисање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 2\nid_prijemnice = 1\nid_artikla = 8\nkolicina = 5250.00\nopis = \ncreated_at = 2025-04-01 19:45:17\nupdated_at = 2025-04-01 19:45:17\n','2025-04-01 19:46:30',1),
(62,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 3\nid_prijemnice = 1\nid_artikla = 8\nkolicina = 5250.00\nopis = \ncreated_at = 2025-04-01 19:46:56\nupdated_at = 2025-04-01 19:46:56\n','2025-04-01 19:46:56',1),
(63,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 2\ndatum = 2025-03-08\nbroj = БР-444/2025\nid_dobavljaca = 2\nid_magacina = 1\nnapomena = \ncreated_at = 2025-04-01 19:47:48\nupdated_at = 2025-04-01 19:47:48\n','2025-04-01 19:47:48',1),
(64,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 4\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 7100.00\nopis = \ncreated_at = 2025-04-01 19:48:04\nupdated_at = 2025-04-01 19:48:04\n','2025-04-01 19:48:04',1),
(65,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 5\nid_prijemnice = 2\nid_artikla = 8\nkolicina = 5200.00\nopis = \ncreated_at = 2025-04-01 19:48:31\nupdated_at = 2025-04-01 19:48:31\n','2025-04-01 19:48:31',1),
(66,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 3\ndatum = 2025-03-19\nbroj = БР-565/2025\nid_dobavljaca = 1\nid_magacina = 2\nnapomena = \ncreated_at = 2025-04-01 19:49:30\nupdated_at = 2025-04-01 19:49:30\n','2025-04-01 19:49:30',1),
(67,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 6\nid_prijemnice = 3\nid_artikla = 1\nkolicina = 7555.00\nopis = \ncreated_at = 2025-04-01 19:49:46\nupdated_at = 2025-04-01 19:49:46\n','2025-04-01 19:49:46',1),
(68,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 4\ndatum = 2025-03-26\nbroj = БР-788/2025\nid_dobavljaca = 2\nid_magacina = 2\nnapomena = \ncreated_at = 2025-04-01 19:50:27\nupdated_at = 2025-04-01 19:50:27\n','2025-04-01 19:50:27',1),
(69,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 7\nid_prijemnice = 4\nid_artikla = 8\nkolicina = 8100.00\nopis = \ncreated_at = 2025-04-01 19:50:39\nupdated_at = 2025-04-01 19:50:39\n','2025-04-01 19:50:39',1),
(70,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 5\ndatum = 2025-04-29\nbroj = БР-111/2025\nid_dobavljaca = 3\nid_magacina = 9\nnapomena = \ncreated_at = 2025-04-01 19:51:32\nupdated_at = 2025-04-01 19:51:32\n','2025-04-01 19:51:32',1),
(71,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 8\nid_prijemnice = 5\nid_artikla = 15\nkolicina = 5000.00\nopis = \ncreated_at = 2025-04-01 19:51:52\nupdated_at = 2025-04-01 19:51:52\n','2025-04-01 19:51:52',1),
(72,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 9\nid_prijemnice = 5\nid_artikla = 16\nkolicina = 2500.00\nopis = \ncreated_at = 2025-04-01 19:52:06\nupdated_at = 2025-04-01 19:52:06\n','2025-04-01 19:52:06',1),
(73,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 10\nid_prijemnice = 5\nid_artikla = 17\nkolicina = 15000.00\nopis = \ncreated_at = 2025-04-01 19:52:33\nupdated_at = 2025-04-01 19:52:33\n','2025-04-01 19:52:33',1);
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
(1,1,'Магацин сировина 1','Град, Улица 2/3','','2025-04-01 19:22:54','2025-04-01 19:22:54'),
(2,1,'Магацин сировина 2','Град, Улица 5/6','','2025-04-01 19:23:19','2025-04-01 19:23:19'),
(3,2,'Магацин кљука 1','Град, Улица 1/1','','2025-04-01 19:24:11','2025-04-01 19:24:11'),
(4,3,'Магацин меке ракије 1','Град, Улица 1/2','','2025-04-01 19:24:36','2025-04-01 19:24:44'),
(5,4,'Магацин дестилата 1','Град, Улица 1/3','','2025-04-01 19:25:05','2025-04-01 19:25:05'),
(6,5,'Магацин готове ракије 1','Град, Улица 1/4','','2025-04-01 19:25:38','2025-04-01 19:25:38'),
(7,6,'Магацин готових производа 1','Град, Улица 2/7','','2025-04-01 19:26:23','2025-04-01 19:26:23'),
(8,6,'Магацин готових производа 1','Град, Улица 3/6','','2025-04-01 19:26:51','2025-04-01 19:26:51'),
(9,7,'Магацин амбалаже 1','Град, Улица 1/1','','2025-04-01 19:27:39','2025-04-01 19:27:39'),
(10,8,'Магацин разне робе','Град, Улица 1/1','','2025-04-01 19:28:11','2025-04-01 19:28:11');
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
  `id_artikla_iz` int(10) unsigned NOT NULL,
  `id_artikla_u` int(10) unsigned NOT NULL,
  `kolicina_iz` decimal(16,2) NOT NULL DEFAULT 0.00,
  `kolicina_u` decimal(16,2) NOT NULL DEFAULT 0.00,
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `nalog_artial_nalozi_FK` (`id_naloga`),
  KEY `nalog_artial_artikli_iz_FK` (`id_artikla_iz`),
  KEY `nalog_artial_artikli_u_FK` (`id_artikla_u`),
  CONSTRAINT `nalog_artial_artikli_iz_FK` FOREIGN KEY (`id_artikla_iz`) REFERENCES `artikli` (`id`),
  CONSTRAINT `nalog_artial_artikli_u_FK` FOREIGN KEY (`id_artikla_u`) REFERENCES `artikli` (`id`),
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
  `opis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `prijemnica_artikal_prijemnice_FK` (`id_prijemnice`),
  KEY `prijemnica_artikal_artikli_FK` (`id_artikla`),
  CONSTRAINT `prijemnica_artikal_artikli_FK` FOREIGN KEY (`id_artikla`) REFERENCES `artikli` (`id`),
  CONSTRAINT `prijemnica_artikal_prijemnice_FK` FOREIGN KEY (`id_prijemnice`) REFERENCES `prijemnice` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijemnica_artikal`
--

LOCK TABLES `prijemnica_artikal` WRITE;
/*!40000 ALTER TABLE `prijemnica_artikal` DISABLE KEYS */;
INSERT INTO `prijemnica_artikal` VALUES
(1,1,1,8000.00,'','2025-04-01 19:44:57','2025-04-01 19:44:57'),
(3,1,8,5250.00,'','2025-04-01 19:46:56','2025-04-01 19:46:56'),
(4,2,1,7100.00,'','2025-04-01 19:48:04','2025-04-01 19:48:04'),
(5,2,8,5200.00,'','2025-04-01 19:48:31','2025-04-01 19:48:31'),
(6,3,1,7555.00,'','2025-04-01 19:49:46','2025-04-01 19:49:46'),
(7,4,8,8100.00,'','2025-04-01 19:50:39','2025-04-01 19:50:39'),
(8,5,15,5000.00,'','2025-04-01 19:51:52','2025-04-01 19:51:52'),
(9,5,16,2500.00,'','2025-04-01 19:52:06','2025-04-01 19:52:06'),
(10,5,17,15000.00,'','2025-04-01 19:52:33','2025-04-01 19:52:33');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijemnice`
--

LOCK TABLES `prijemnice` WRITE;
/*!40000 ALTER TABLE `prijemnice` DISABLE KEYS */;
INSERT INTO `prijemnice` VALUES
(1,'2025-03-02','БР-123/2025',1,1,'','2025-04-01 19:44:41','2025-04-01 19:44:41'),
(2,'2025-03-08','БР-444/2025',2,1,'','2025-04-01 19:47:48','2025-04-01 19:47:48'),
(3,'2025-03-19','БР-565/2025',1,2,'','2025-04-01 19:49:30','2025-04-01 19:49:30'),
(4,'2025-03-26','БР-788/2025',2,2,'','2025-04-01 19:50:27','2025-04-01 19:50:27'),
(5,'2025-04-29','БР-111/2025',3,9,'','2025-04-01 19:51:32','2025-04-01 19:51:32');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stanje`
--

LOCK TABLES `stanje` WRITE;
/*!40000 ALTER TABLE `stanje` DISABLE KEYS */;
INSERT INTO `stanje` VALUES
(1,1,1,15100.00,'2025-04-01 19:44:57','2025-04-01 19:44:57'),
(2,1,8,10450.00,'2025-04-01 19:45:17','2025-04-01 19:45:17'),
(3,2,1,7555.00,'2025-04-01 19:49:46','2025-04-01 19:49:46'),
(4,2,8,8100.00,'2025-04-01 19:50:39','2025-04-01 19:50:39'),
(5,9,15,5000.00,'2025-04-01 19:51:52','2025-04-01 19:51:52'),
(6,9,16,2500.00,'2025-04-01 19:52:06','2025-04-01 19:52:06'),
(7,9,17,15000.00,'2025-04-01 19:52:33','2025-04-01 19:52:33');
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
(1,'сировина','','2025-04-01 19:15:58','2025-04-01 19:15:58'),
(2,'кљук','','2025-04-01 19:16:26','2025-04-01 19:16:26'),
(3,'мека','','2025-04-01 19:16:38','2025-04-01 19:16:38'),
(4,'дестилат','','2025-04-01 19:16:51','2025-04-01 19:16:51'),
(5,'ракија','ракија спремна за флаширање','2025-04-01 19:17:15','2025-04-01 19:17:15'),
(6,'готов производ','','2025-04-01 19:17:32','2025-04-01 19:17:32'),
(7,'амбалажа','','2025-04-01 19:17:57','2025-04-01 19:17:57'),
(8,'разно','','2025-04-01 19:18:12','2025-04-01 19:18:12');
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

-- Dump completed on 2025-04-01 22:27:22
