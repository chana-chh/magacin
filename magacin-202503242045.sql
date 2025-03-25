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
  PRIMARY KEY (`id`),
  UNIQUE KEY `artikli_unique` (`naziv`),
  KEY `artikli_jedinice_mere_FK` (`id_jm`),
  KEY `artikli_kategorije_artikala_FK` (`id_kategorije`),
  CONSTRAINT `artikli_jedinice_mere_FK` FOREIGN KEY (`id_jm`) REFERENCES `jedinice_mere` (`id`),
  CONSTRAINT `artikli_kategorije_artikala_FK` FOREIGN KEY (`id_kategorije`) REFERENCES `kategorije_artikala` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artikli`
--

LOCK TABLES `artikli` WRITE;
/*!40000 ALTER TABLE `artikli` DISABLE KEYS */;
INSERT INTO `artikli` VALUES
(1,1,'јабука1',10,'asd'),
(2,3,'јабука',13,'');
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
  `naziv` varchar(255) NOT NULL,
  `adresa_mesto` varchar(50) DEFAULT NULL,
  `adresa_ulica` varchar(100) DEFAULT NULL,
  `adresa_broj` varchar(30) DEFAULT NULL,
  `telefon` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `napomena` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dobavljaci_unique` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dobavljaci`
--

LOCK TABLES `dobavljaci` WRITE;
/*!40000 ALTER TABLE `dobavljaci` DISABLE KEYS */;
INSERT INTO `dobavljaci` VALUES
(1, 'Neki dobavljac A', 'Kragujevac', 'Neka ulica', '23', '33344455', 'nmelic@mmm.com', 'Napomena 123');
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `jedinice_mere_unique` (`jm`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jedinice_mere`
--

LOCK TABLES `jedinice_mere` WRITE;
/*!40000 ALTER TABLE `jedinice_mere` DISABLE KEYS */;
INSERT INTO `jedinice_mere` VALUES
(10,'ком','комад','опис 123'),
(13,'л','литар','');
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipovi_magacina_unique` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategorije_artikala`
--

LOCK TABLES `kategorije_artikala` WRITE;
/*!40000 ALTER TABLE `kategorije_artikala` DISABLE KEYS */;
INSERT INTO `kategorije_artikala` VALUES
(1,'сировина',''),
(3,'кљук','џибра');
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
(1,'админ','$2y$10$7Eqch0.aLuKmQMicOvBTaeaBWdlVGY2i/iosfDJaj6546EP5C2Szm',0,'Администратор');
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
(1, 'купац 1', 'Београд', NULL, NULL, NULL, NULL, NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logovi`
--

LOCK TABLES `logovi` WRITE;
/*!40000 ALTER TABLE `logovi` DISABLE KEYS */;
INSERT INTO `logovi` VALUES
(1,'ДОДАВАЊЕ','Додавање јединице мере',NULL,'[NEW]\nid = 10\njm = ком\nnaziv = комад\nopis = \n','2025-03-01 20:30:35',1),
(2,'ДОДАВАЊЕ','Додавање јединице мере',NULL,'[NEW]\nid = 11\njm = л\nnaziv = литар\nopis = \n','2025-03-02 20:30:53',1),
(3,'ДОДАВАЊЕ','Додавање јединице мере',NULL,'[NEW]\njedinice_mere\nid = 12\njm = т\nnaziv = тона\nopis = \n','2025-03-10 20:36:57',1),
(4,'БРИСАЊЕ','Брисање јединице мере',NULL,'[NEW]\ntable = jedinice_mere\nid = 12\njm = т\nnaziv = тона\nopis = \n','2025-03-10 20:40:04',1),
(5,'БРИСАЊЕ','Брисање јединице мере','jedinice_mere','[NEW]\ntable = jedinice_mere\nid = 11\njm = л\nnaziv = литар\nopis = \n','2025-03-15 21:02:43',1),
(6,'ИЗМЕНА','Измена јединице мере','jedinice_mere','[NEW]\nid = 10\njm = ком\nnaziv = комад\nopis = опис\n\n\n[OLD]\nid = 10\njm = ком\nnaziv = комад\nopis = \n','2025-03-20 21:08:40',1),
(7,'ИЗМЕНА','Измена јединице мере','jedinice_mere','[NEW]\nid = 10\njm = ком\nnaziv = комад\nopis = опис 123\n\n[OLD]\nid = 10\njm = ком\nnaziv = комад\nopis = опис\n','2025-03-20 21:09:54',1),
(8,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 1\nnaziv = амбалажа\nopis = магацин амбалаже\n','2025-03-22 08:37:28',1),
(9,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 2\nnaziv = тест\nopis = тест магацин\n','2025-03-22 08:38:41',1),
(10,'ИЗМЕНА','Измена типа магацина','tipovi_magacina','[NEW]\nid = 2\nnaziv = тест\nopis = тест магацин123\n\n[OLD]\nid = 2\nnaziv = тест\nopis = тест магацин\n','2025-03-22 08:50:20',1),
(11,'БРИСАЊЕ','Брисање типа магацина','tipovi_magacina','[NEW]\nid = 2\nnaziv = тест\nopis = тест магацин123\n','2025-03-22 08:50:51',1),
(12,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 1\nid_tipa = 1\nnaziv = магацин амбалаже 1\nadresa = Место, Улица 22\nnapomena = \n','2025-03-22 10:03:01',1),
(13,'ДОДАВАЊЕ','Додавање типа магацина','tipovi_magacina','[NEW]\nid = 3\nnaziv = сировине\nopis = магацин сировина\n','2025-03-22 10:09:18',1),
(14,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 2\nid_tipa = 3\nnaziv = магацин сировина\nadresa = Место, Улица 44\nnapomena = овде се складишти воће\n','2025-03-22 10:10:23',1),
(15,'ИЗМЕНА','Измена магацина','magacini','[NEW]\nid = 1\nid_tipa = 1\nnaziv = магацин амбалаже 1\nadresa = Место, Улица 22\nnapomena = ддд\n\n[OLD]\nid = 1\nid_tipa = 1\nnaziv = магацин амбалаже 1\nadresa = Место, Улица 22\nnapomena = \n','2025-03-22 10:32:00',1),
(16,'ИЗМЕНА','Измена магацина','magacini','[NEW]\nid = 1\nid_tipa = 1\nnaziv = магацин амбалаже 12\nadresa = Место, Улица 22\nnapomena = ддд\n\n[OLD]\nid = 1\nid_tipa = 1\nnaziv = магацин амбалаже 1\nadresa = Место, Улица 22\nnapomena = ддд\n','2025-03-22 10:32:16',1),
(17,'ДОДАВАЊЕ','Додавање магацина','magacini','[NEW]\nid = 3\nid_tipa = 1\nnaziv = тест\nadresa = еее\nnapomena = ееееее\n','2025-03-22 10:32:32',1),
(18,'БРИСАЊЕ','Брисање магацина','magacini','[NEW]\nid = 3\nid_tipa = 1\nnaziv = тест\nadresa = еее\nnapomena = ееееее\n','2025-03-22 10:35:19',1),
(19,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 1\nnaziv = сировина\nopis = \n','2025-03-22 12:42:21',1),
(20,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 2\nnaziv = тест\nopis = \n','2025-03-22 12:42:34',1),
(21,'ИЗМЕНА','Измена категорије артикла','kategorije_artikala','[NEW]\nid = 2\nnaziv = тест\nopis = 1234\n\n[OLD]\nid = 2\nnaziv = тест\nopis = \n','2025-03-22 12:50:24',1),
(22,'БРИСАЊЕ','Брисање категорије артикла','kategorije_artikala','[NEW]\nid = 2\nnaziv = тест\nopis = 1234\n','2025-03-22 12:50:28',1),
(23,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 1\nid_kategorije = 1\nnaziv = jabuka\nid_jm = 10\nnapomena = asd\n','2025-03-22 13:30:47',1),
(24,'ДОДАВАЊЕ','Додавање категорије артикла','kategorije_artikala','[NEW]\nid = 3\nnaziv = кљук јабука\nopis = џибра од јабуке\n','2025-03-22 13:38:43',1),
(25,'ДОДАВАЊЕ','Додавање јединице мере','jedinice_mere','[NEW]\nid = 13\njm = л\nnaziv = литар\nopis = \n','2025-03-22 13:39:03',1),
(26,'ИЗМЕНА','Измена категорије артикла','kategorije_artikala','[NEW]\nid = 3\nnaziv = кљук\nopis = џибра\n\n[OLD]\nid = 3\nnaziv = кљук јабука\nopis = џибра од јабуке\n','2025-03-22 13:39:54',1),
(27,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 2\nid_kategorije = 3\nnaziv = јабука\nid_jm = 13\nnapomena = \n','2025-03-22 13:40:21',1),
(28,'ДОДАВАЊЕ','Додавање артикла','artikli','[NEW]\nid = 3\nid_kategorije = 1\nnaziv = тест\nid_jm = 10\nnapomena = ддд\n','2025-03-22 13:40:35',1),
(29,'ИЗМЕНА','Измена артикла','artikli','[NEW]\nid = 3\nid_kategorije = 1\nnaziv = тест\nid_jm = 10\nnapomena = ддд2222\n\n[OLD]\nid = 3\nid_kategorije = 1\nnaziv = тест\nid_jm = 10\nnapomena = ддд\n','2025-03-22 13:53:50',1),
(30,'БРИСАЊЕ','Брисање артикла','artikli','[NEW]\nid = 3\nid_kategorije = 1\nnaziv = тест\nid_jm = 10\nnapomena = ддд2222\n','2025-03-22 13:56:06',1),
(31,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 1\ndatum = 2025-03-01\nbroj = о-256\nid_dobavljaca = 2\nid_magacina = 1\nnapomena = нап\n','2025-03-22 18:36:57',1),
(32,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 2\ndatum = 2025-03-05\nbroj = 778899\nid_dobavljaca = 1\nid_magacina = 1\nnapomena = \n','2025-03-22 18:38:03',1),
(33,'ИЗМЕНА','Измена пријемнице','prijemnice','[NEW]\nid = 2\ndatum = 2025-03-05\nbroj = 778899\nid_dobavljaca = 1\nid_magacina = 2\nnapomena = \n\n[OLD]\nid = 2\ndatum = 2025-03-05\nbroj = 778899\nid_dobavljaca = 1\nid_magacina = 1\nnapomena = \n','2025-03-22 18:57:35',1),
(34,'ДОДАВАЊЕ','Додавање пријемнице','prijemnice','[NEW]\nid = 3\ndatum = 2025-03-14\nbroj = тест\nid_dobavljaca = 1\nid_magacina = 1\nnapomena = тест\n','2025-03-22 19:02:05',1),
(35,'ИЗМЕНА','Измена пријемнице','prijemnice','[NEW]\nid = 3\ndatum = 2025-03-14\nbroj = тест\nid_dobavljaca = 1\nid_magacina = 1\nnapomena = тестис\n\n[OLD]\nid = 3\ndatum = 2025-03-14\nbroj = тест\nid_dobavljaca = 1\nid_magacina = 1\nnapomena = тест\n','2025-03-22 19:03:12',1),
(36,'БРИСАЊЕ','Брисање пријемнице','prijemnice','[NEW]\nid = 3\ndatum = 2025-03-14\nbroj = тест\nid_dobavljaca = 1\nid_magacina = 1\nnapomena = тестис\n','2025-03-22 19:03:30',1),
(37,'ИЗМЕНА','Измена магацина','magacini','[NEW]\nid = 1\nid_tipa = 1\nnaziv = магацин амбалаже\nadresa = Место, Улица 22\nnapomena = ддд\n\n[OLD]\nid = 1\nid_tipa = 1\nnaziv = магацин амбалаже 12\nadresa = Место, Улица 22\nnapomena = ддд\n','2025-03-22 22:50:47',1),
(38,'ИЗМЕНА','Измена артикла','artikli','[NEW]\nid = 1\nid_kategorije = 1\nnaziv = јабука1\nid_jm = 10\nnapomena = asd\n\n[OLD]\nid = 1\nid_kategorije = 1\nnaziv = jabuka\nid_jm = 10\nnapomena = asd\n','2025-03-23 12:56:15',1),
(39,'ИЗМЕНА','Измена пријемнице','prijemnice','[NEW]\nid = 2\ndatum = 2025-03-05\nbroj = ГГ-778899/2025\nid_dobavljaca = 1\nid_magacina = 2\nnapomena = \n\n[OLD]\nid = 2\ndatum = 2025-03-05\nbroj = 778899\nid_dobavljaca = 1\nid_magacina = 2\nnapomena = \n','2025-03-23 13:07:43',1),
(40,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 2\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 500.00\n','2025-03-23 14:15:54',1),
(41,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 5\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 500.00\n','2025-03-23 14:18:31',1),
(42,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 6\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 500.00\n','2025-03-23 14:18:44',1),
(43,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 8\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 0.00\n','2025-03-23 14:20:53',1),
(44,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 9\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 1000.00\n','2025-03-23 14:21:06',1),
(45,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 1\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 100.00\n','2025-03-23 14:23:16',1),
(46,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 2\nid_prijemnice = 2\nid_artikla = 2\nkolicina = 1000.00\n','2025-03-23 14:23:29',1),
(47,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 3\nid_prijemnice = 2\nid_artikla = 2\nkolicina = 100.00\n','2025-03-23 14:23:43',1),
(48,'ДОДАВАЊЕ','Додавање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 4\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 100.00\n','2025-03-23 14:23:51',1),
(49,'БРИСАЊЕ','Брисање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 3\nid_prijemnice = 2\nid_artikla = 2\nkolicina = 100.00\n','2025-03-23 14:37:40',1),
(50,'БРИСАЊЕ','Брисање ставке пријемнице','prijemnica_artikal','[NEW]\nid = 4\nid_prijemnice = 2\nid_artikla = 1\nkolicina = 100.00\n','2025-03-23 14:37:48',1);
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
  PRIMARY KEY (`id`),
  KEY `magacini_tipovi_magacina_FK` (`id_tipa`),
  CONSTRAINT `magacini_tipovi_magacina_FK` FOREIGN KEY (`id_tipa`) REFERENCES `tipovi_magacina` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `magacini`
--

LOCK TABLES `magacini` WRITE;
/*!40000 ALTER TABLE `magacini` DISABLE KEYS */;
INSERT INTO `magacini` VALUES
(1,1,'магацин амбалаже','Место, Улица 22','ддд'),
(2,3,'магацин сировина','Место, Улица 44','овде се складишти воће');
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
  PRIMARY KEY (`id`),
  KEY `prijemnice_dobavljaci_FK` (`id_dobavljaca`),
  KEY `prijemnice_magacini_FK` (`id_magacina`),
  CONSTRAINT `prijemnice_dobavljaci_FK` FOREIGN KEY (`id_dobavljaca`) REFERENCES `dobavljaci` (`id`),
  CONSTRAINT `prijemnice_magacini_FK` FOREIGN KEY (`id_magacina`) REFERENCES `magacini` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijemnice`
--

LOCK TABLES `prijemnice` WRITE;
/*!40000 ALTER TABLE `prijemnice` DISABLE KEYS */;
INSERT INTO `prijemnice` VALUES
(1,'2025-03-01','о-256',2,1,'нап'),
(2,'2025-03-05','ГГ-778899/2025',1,2,'');
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipovi_magacina_unique` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipovi_magacina`
--

LOCK TABLES `tipovi_magacina` WRITE;
/*!40000 ALTER TABLE `tipovi_magacina` DISABLE KEYS */;
INSERT INTO `tipovi_magacina` VALUES
(1,'амбалажа','магацин амбалаже'),
(3,'сировине','магацин сировина');
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

-- Dump completed on 2025-03-24 20:45:39
