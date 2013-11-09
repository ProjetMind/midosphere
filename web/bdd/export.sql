-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: mind
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.04.1

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
-- Table structure for table `AbonnementDomaine`
--

DROP TABLE IF EXISTS `AbonnementDomaine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AbonnementDomaine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_domaine` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AbonnementDomaine`
--

LOCK TABLES `AbonnementDomaine` WRITE;
/*!40000 ALTER TABLE `AbonnementDomaine` DISABLE KEYS */;
/*!40000 ALTER TABLE `AbonnementDomaine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Adresse`
--

DROP TABLE IF EXISTS `Adresse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Adresse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adresse_adresse` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `adresse_ville` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `adresse_cp` int(11) NOT NULL,
  `adresse_pays` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `avis` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Adresse`
--

LOCK TABLES `Adresse` WRITE;
/*!40000 ALTER TABLE `Adresse` DISABLE KEYS */;
/*!40000 ALTER TABLE `Adresse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Participants`
--

DROP TABLE IF EXISTS `Participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conversation` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Participants`
--

LOCK TABLES `Participants` WRITE;
/*!40000 ALTER TABLE `Participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `Participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SujetQuestion`
--

DROP TABLE IF EXISTS `SujetQuestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SujetQuestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_question` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SujetQuestion`
--

LOCK TABLES `SujetQuestion` WRITE;
/*!40000 ALTER TABLE `SujetQuestion` DISABLE KEYS */;
/*!40000 ALTER TABLE `SujetQuestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SujetSuivis`
--

DROP TABLE IF EXISTS `SujetSuivis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SujetSuivis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SujetSuivis`
--

LOCK TABLES `SujetSuivis` WRITE;
/*!40000 ALTER TABLE `SujetSuivis` DISABLE KEYS */;
/*!40000 ALTER TABLE `SujetSuivis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abonnement`
--

DROP TABLE IF EXISTS `abonnement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abonnement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_souscripteur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abonnement`
--

LOCK TABLES `abonnement` WRITE;
/*!40000 ALTER TABLE `abonnement` DISABLE KEYS */;
/*!40000 ALTER TABLE `abonnement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avatar`
--

DROP TABLE IF EXISTS `avatar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avatar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` decimal(10,0) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avatar`
--

LOCK TABLES `avatar` WRITE;
/*!40000 ALTER TABLE `avatar` DISABLE KEYS */;
INSERT INTO `avatar` VALUES (2,'../web/uploads/user/avatars/4092b9e90158c1d89e49df39aef3340a62760eaa.jpeg','image/jpeg',14737,58),(3,'../web/img/avatar-homme.jpeg','',0,52),(4,'../web/img/avatar-homme.jpeg','',0,53),(5,'../web/img/avatar-homme.jpeg','',0,54),(6,'../web/uploads/user/avatars/c0235bf9df5a0da524452885b104d38281fb5515.jpeg','image/jpeg',14737,52);
/*!40000 ALTER TABLE `avatar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avis`
--

DROP TABLE IF EXISTS `avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deletedAt` datetime DEFAULT NULL,
  `avis_titre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avis` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_opinion` int(11) NOT NULL,
  `avis_date_publication` datetime NOT NULL,
  `avis_date_edition` datetime DEFAULT NULL,
  `avis_auteur` int(11) NOT NULL,
  `avis_adresse` int(11) DEFAULT NULL,
  `avis_domaine` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8F91ABF0989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avis`
--

LOCK TABLES `avis` WRITE;
/*!40000 ALTER TABLE `avis` DISABLE KEYS */;
INSERT INTO `avis` VALUES (1,NULL,'Premier avis','premier-avis','Contenu de l\'avis',3,'2013-10-24 22:46:34',NULL,52,NULL,2),(2,NULL,'Second avis','second-avis','Contenu du second avis',2,'2013-10-24 22:47:21',NULL,52,NULL,3),(3,NULL,'Troisième avis','troisieme-avis','Contenu du troisième avis',1,'2013-10-28 23:42:37',NULL,52,NULL,4);
/*!40000 ALTER TABLE `avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commentaire_avis`
--

DROP TABLE IF EXISTS `commentaire_avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commentaire_avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deletedAt` datetime DEFAULT NULL,
  `commentaire` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commentaire_date_publication` datetime NOT NULL,
  `id_avis` int(11) NOT NULL,
  `commentaire_id_auteur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire_avis`
--

LOCK TABLES `commentaire_avis` WRITE;
/*!40000 ALTER TABLE `commentaire_avis` DISABLE KEYS */;
/*!40000 ALTER TABLE `commentaire_avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commentaire_question`
--

DROP TABLE IF EXISTS `commentaire_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commentaire_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_question` int(11) NOT NULL,
  `commentaire_id_auteur` int(11) NOT NULL,
  `commentaire` int(11) NOT NULL,
  `commentaire_date_publication` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire_question`
--

LOCK TABLES `commentaire_question` WRITE;
/*!40000 ALTER TABLE `commentaire_question` DISABLE KEYS */;
INSERT INTO `commentaire_question` VALUES (1,2,52,0,'2013-10-24 23:49:30'),(2,2,52,0,'2013-10-24 23:49:56');
/*!40000 ALTER TABLE `commentaire_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conversation`
--

DROP TABLE IF EXISTS `conversation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conversation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dossier` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `auteur_conversation` int(11) NOT NULL,
  `tab_participants` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `date_debut_conversation` datetime NOT NULL,
  `etat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conversation`
--

LOCK TABLES `conversation` WRITE;
/*!40000 ALTER TABLE `conversation` DISABLE KEYS */;
INSERT INTO `conversation` VALUES (1,'archive',52,'a:2:{i:0;s:2:\"54\";i:1;s:2:\"53\";}','2013-10-24 22:54:10',1),(2,'bal',52,'a:3:{i:0;s:2:\"54\";i:1;s:2:\"53\";i:2;i:52;}','2013-10-24 22:58:53',1),(3,'archive',52,'a:3:{i:0;s:2:\"54\";i:1;s:2:\"53\";i:2;i:52;}','2013-10-24 23:05:20',1);
/*!40000 ALTER TABLE `conversation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domaine`
--

DROP TABLE IF EXISTS `domaine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domaine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `id_auteur` int(11) NOT NULL,
  `libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `niveau` int(11) NOT NULL,
  `borne_gauche` int(11) NOT NULL,
  `borne_droit` int(11) NOT NULL,
  `root` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_78AF0ACC989D9B62` (`slug`),
  KEY `IDX_78AF0ACC727ACA70` (`parent_id`),
  CONSTRAINT `FK_78AF0ACC727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `domaine` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domaine`
--

LOCK TABLES `domaine` WRITE;
/*!40000 ALTER TABLE `domaine` DISABLE KEYS */;
INSERT INTO `domaine` VALUES (1,NULL,52,'Voyage','voyage',1,'2013-10-24 22:31:03',NULL,0,-1,0,1),(2,NULL,52,'Informatique','informatique',1,'2013-10-24 22:31:21',NULL,0,-1,6,2),(3,2,52,'Programation','programation',1,'2013-10-24 22:31:51',NULL,1,0,3,2),(4,2,52,'Hardware','hardware',1,'2013-10-24 22:32:18',NULL,1,4,5,2),(5,3,52,'PHP','php',1,'2013-10-24 22:32:36',NULL,2,1,2,2);
/*!40000 ALTER TABLE `domaine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_avis`
--

DROP TABLE IF EXISTS `image_avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deletedAt` datetime DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` decimal(10,0) NOT NULL,
  `avis` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_avis`
--

LOCK TABLES `image_avis` WRITE;
/*!40000 ALTER TABLE `image_avis` DISABLE KEYS */;
/*!40000 ALTER TABLE `image_avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media__gallery`
--

DROP TABLE IF EXISTS `media__gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media__gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `context` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `default_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media__gallery`
--

LOCK TABLES `media__gallery` WRITE;
/*!40000 ALTER TABLE `media__gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `media__gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media__gallery_media`
--

DROP TABLE IF EXISTS `media__gallery_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media__gallery_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_80D4C5414E7AF8F` (`gallery_id`),
  KEY `IDX_80D4C541EA9FDD75` (`media_id`),
  CONSTRAINT `FK_80D4C5414E7AF8F` FOREIGN KEY (`gallery_id`) REFERENCES `media__gallery` (`id`),
  CONSTRAINT `FK_80D4C541EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media__media` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media__gallery_media`
--

LOCK TABLES `media__gallery_media` WRITE;
/*!40000 ALTER TABLE `media__gallery_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media__gallery_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media__media`
--

DROP TABLE IF EXISTS `media__media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media__media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `enabled` tinyint(1) NOT NULL,
  `provider_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_status` int(11) NOT NULL,
  `provider_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_metadata` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json)',
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `length` decimal(10,0) DEFAULT NULL,
  `content_type` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_size` int(11) DEFAULT NULL,
  `copyright` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cdn_is_flushable` tinyint(1) DEFAULT NULL,
  `cdn_flush_at` datetime DEFAULT NULL,
  `cdn_status` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media__media`
--

LOCK TABLES `media__media` WRITE;
/*!40000 ALTER TABLE `media__media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media__media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_expediteur` int(11) NOT NULL,
  `contenu_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_envoi_message` datetime NOT NULL,
  `message_lu` tinyint(1) NOT NULL,
  `id_conversation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (3,52,'message contenu ','2013-10-24 23:05:20',0,3);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opinion_avis`
--

DROP TABLE IF EXISTS `opinion_avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opinion_avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_avis` int(11) NOT NULL,
  `date_publication_opinion` datetime NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `type_opinion` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opinion_avis`
--

LOCK TABLES `opinion_avis` WRITE;
/*!40000 ALTER TABLE `opinion_avis` DISABLE KEYS */;
/*!40000 ALTER TABLE `opinion_avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opinion_question`
--

DROP TABLE IF EXISTS `opinion_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opinion_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_auteur` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `type_opinion` int(11) NOT NULL,
  `date_publication_opinion` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opinion_question`
--

LOCK TABLES `opinion_question` WRITE;
/*!40000 ALTER TABLE `opinion_question` DISABLE KEYS */;
INSERT INTO `opinion_question` VALUES (1,52,2,1,'2013-10-24 23:43:32');
/*!40000 ALTER TABLE `opinion_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_titre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `question_date_publication` datetime NOT NULL,
  `question_date_edition` datetime DEFAULT NULL,
  `question_auteur` int(11) NOT NULL,
  `question_domaine` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:object)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B6F7494E989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'Première question','premiere-question','Contenu de la première question','2013-10-24 22:49:09',NULL,52,'O:30:\"Mind\\SiteBundle\\Entity\\Domaine\":13:{s:34:\"\0Mind\\SiteBundle\\Entity\\Domaine\0id\";i:5;s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0idAuteur\";i:52;s:39:\"\0Mind\\SiteBundle\\Entity\\Domaine\0libelle\";s:3:\"PHP\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0slug\";s:3:\"php\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0etat\";b:1;s:44:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateCreation\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2013-10-24 22:32:36\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Europe/Paris\";}s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateUpdate\";N;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0niveau\";i:2;s:43:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneGauche\";i:1;s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneDroit\";i:2;s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0root\";i:2;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0parent\";O:30:\"Mind\\SiteBundle\\Entity\\Domaine\":13:{s:34:\"\0Mind\\SiteBundle\\Entity\\Domaine\0id\";i:3;s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0idAuteur\";i:52;s:39:\"\0Mind\\SiteBundle\\Entity\\Domaine\0libelle\";s:12:\"Programation\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0slug\";s:12:\"programation\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0etat\";b:1;s:44:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateCreation\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2013-10-24 22:31:51\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Europe/Paris\";}s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateUpdate\";N;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0niveau\";i:1;s:43:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneGauche\";i:0;s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneDroit\";i:3;s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0root\";i:2;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0parent\";O:30:\"Mind\\SiteBundle\\Entity\\Domaine\":13:{s:34:\"\0Mind\\SiteBundle\\Entity\\Domaine\0id\";i:2;s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0idAuteur\";i:52;s:39:\"\0Mind\\SiteBundle\\Entity\\Domaine\0libelle\";s:12:\"Informatique\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0slug\";s:12:\"informatique\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0etat\";b:1;s:44:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateCreation\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2013-10-24 22:31:21\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Europe/Paris\";}s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateUpdate\";N;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0niveau\";i:0;s:43:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneGauche\";i:-1;s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneDroit\";i:6;s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0root\";i:2;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0parent\";N;s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0children\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:39:\"\0Doctrine\\ORM\\PersistentCollection\0coll\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:54:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0_elements\";a:0:{}}s:46:\"\0Doctrine\\ORM\\PersistentCollection\0initialized\";b:0;}}s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0children\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:39:\"\0Doctrine\\ORM\\PersistentCollection\0coll\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:54:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0_elements\";a:0:{}}s:46:\"\0Doctrine\\ORM\\PersistentCollection\0initialized\";b:0;}}s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0children\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:39:\"\0Doctrine\\ORM\\PersistentCollection\0coll\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:54:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0_elements\";a:0:{}}s:46:\"\0Doctrine\\ORM\\PersistentCollection\0initialized\";b:0;}}'),(2,'Seconde question','seconde-question','Contenu de la seconde question','2013-10-24 22:49:51',NULL,52,'O:30:\"Mind\\SiteBundle\\Entity\\Domaine\":13:{s:34:\"\0Mind\\SiteBundle\\Entity\\Domaine\0id\";i:1;s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0idAuteur\";i:52;s:39:\"\0Mind\\SiteBundle\\Entity\\Domaine\0libelle\";s:6:\"Voyage\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0slug\";s:6:\"voyage\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0etat\";b:1;s:44:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateCreation\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2013-10-24 22:31:03\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Europe/Paris\";}s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateUpdate\";N;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0niveau\";i:0;s:43:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneGauche\";i:-1;s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneDroit\";i:0;s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0root\";i:1;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0parent\";N;s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0children\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:39:\"\0Doctrine\\ORM\\PersistentCollection\0coll\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:54:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0_elements\";a:0:{}}s:46:\"\0Doctrine\\ORM\\PersistentCollection\0initialized\";b:0;}}'),(3,'Une troisième question','une-troisieme-question','Contenu de la troisième question','2013-10-30 23:54:20',NULL,52,'O:30:\"Mind\\SiteBundle\\Entity\\Domaine\":13:{s:34:\"\0Mind\\SiteBundle\\Entity\\Domaine\0id\";i:5;s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0idAuteur\";i:52;s:39:\"\0Mind\\SiteBundle\\Entity\\Domaine\0libelle\";s:3:\"PHP\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0slug\";s:3:\"php\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0etat\";b:1;s:44:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateCreation\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2013-10-24 22:32:36\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Europe/Paris\";}s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateUpdate\";N;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0niveau\";i:2;s:43:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneGauche\";i:1;s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneDroit\";i:2;s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0root\";i:2;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0parent\";O:30:\"Mind\\SiteBundle\\Entity\\Domaine\":13:{s:34:\"\0Mind\\SiteBundle\\Entity\\Domaine\0id\";i:3;s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0idAuteur\";i:52;s:39:\"\0Mind\\SiteBundle\\Entity\\Domaine\0libelle\";s:12:\"Programation\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0slug\";s:12:\"programation\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0etat\";b:1;s:44:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateCreation\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2013-10-24 22:31:51\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Europe/Paris\";}s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateUpdate\";N;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0niveau\";i:1;s:43:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneGauche\";i:0;s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneDroit\";i:3;s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0root\";i:2;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0parent\";O:30:\"Mind\\SiteBundle\\Entity\\Domaine\":13:{s:34:\"\0Mind\\SiteBundle\\Entity\\Domaine\0id\";i:2;s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0idAuteur\";i:52;s:39:\"\0Mind\\SiteBundle\\Entity\\Domaine\0libelle\";s:12:\"Informatique\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0slug\";s:12:\"informatique\";s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0etat\";b:1;s:44:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateCreation\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2013-10-24 22:31:21\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Europe/Paris\";}s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0dateUpdate\";N;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0niveau\";i:0;s:43:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneGauche\";i:-1;s:42:\"\0Mind\\SiteBundle\\Entity\\Domaine\0borneDroit\";i:6;s:36:\"\0Mind\\SiteBundle\\Entity\\Domaine\0root\";i:2;s:38:\"\0Mind\\SiteBundle\\Entity\\Domaine\0parent\";N;s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0children\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:39:\"\0Doctrine\\ORM\\PersistentCollection\0coll\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:54:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0_elements\";a:0:{}}s:46:\"\0Doctrine\\ORM\\PersistentCollection\0initialized\";b:0;}}s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0children\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:39:\"\0Doctrine\\ORM\\PersistentCollection\0coll\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:54:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0_elements\";a:0:{}}s:46:\"\0Doctrine\\ORM\\PersistentCollection\0initialized\";b:0;}}s:40:\"\0Mind\\SiteBundle\\Entity\\Domaine\0children\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:39:\"\0Doctrine\\ORM\\PersistentCollection\0coll\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:54:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0_elements\";a:0:{}}s:46:\"\0Doctrine\\ORM\\PersistentCollection\0initialized\";b:0;}}');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suivis`
--

DROP TABLE IF EXISTS `suivis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suivis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_entity` int(11) NOT NULL,
  `type_entity` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suivis`
--

LOCK TABLES `suivis` WRITE;
/*!40000 ALTER TABLE `suivis` DISABLE KEYS */;
INSERT INTO `suivis` VALUES (2,52,2,'avis',0),(4,52,2,'question',0),(5,52,3,'avis',0),(6,52,3,'question',0),(21,52,1,'avis',1),(23,52,1,'question',1);
/*!40000 ALTER TABLE `suivis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sujet_avis`
--

DROP TABLE IF EXISTS `sujet_avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sujet_avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Avis` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sujet_avis`
--

LOCK TABLES `sujet_avis` WRITE;
/*!40000 ALTER TABLE `sujet_avis` DISABLE KEYS */;
/*!40000 ALTER TABLE `sujet_avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `nom` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_naissance` date NOT NULL,
  `ville` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pays` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_inscription` datetime NOT NULL,
  `cdt_generales` tinyint(1) DEFAULT NULL,
  `descrip_user` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_8D93D649989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (52,'Hipopeur','hipopeur','shonen.shojo@midosphere.com','shonen.shojo@midosphere.com',1,'5r1ggi0ccb8c0g8oc4cwcgg0s4ko0c8','vd66sPvRsjKF3yFgApClhEcqW5RloHHQZxwH/vAe0VqrBGtuBY6LX5rR7bpnJbLfsG8Qk+Xu0HpCladNWMRVNw==','2013-11-04 20:13:25',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,NULL,'../web/uploads/user/avatars/c0235bf9df5a0da524452885b104d38281fb5515.jpeg','hipopeur',NULL,'2013-10-24','1','FR','2013-10-24 12:47:07',1,NULL),(53,'Diallo','diallo','diallo@midosphere.com','diallo@midosphere.com',1,'evcpdoq27io884488g4ss80cogww0og','4N0UNudDc+voI4xbvjfISuJ/jpPjkfZW9jsdIPX4PJ9lOA/ovVuIM07lzbMY8gyMWzRcCZ75OhVYQc6xO0+IVw==',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,NULL,NULL,'diallo',NULL,'2013-10-24','1','FR','2013-10-24 12:47:07',1,NULL),(54,'Jean','jean','Jean@midosphere.com','jean@midosphere.com',1,'alp59jtqdyosgsggo8oksck8c4wgcgs','gbMSaEXB+QeVnO8DqJhOndnIL3Wqzmtp4swWcpNFpt+54r/IcU1A3+8jt85fVjfyi8YmYBmsRubqNshfYzGEUg==',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,NULL,NULL,'jean',NULL,'2013-10-24','1','FR','2013-10-24 12:47:07',1,NULL),(58,'Breaking dev','breaking dev','diallo.mouhamadou.dev@gmail.com','diallo.mouhamadou.dev@gmail.com',1,'ehvsarjkijw404g84wkgwokk0c4w44','M9E6O9kzvNzuxjwFK1ua9faqKk9GqVg/Zi4Ca0MkiB5CV4Bi6OXc9kUqKSkl+CckHGsy58vfusnAEcKastRP5w==','2013-10-31 01:53:55',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,NULL,'../web/uploads/user/avatars/4092b9e90158c1d89e49df39aef3340a62760eaa.jpeg','breaking-dev',NULL,'1904-06-06','1','DZ','2013-10-31 01:53:09',1,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote_avis`
--

DROP TABLE IF EXISTS `vote_avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote_avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avis_date_vote` datetime NOT NULL,
  `avis_nature_vote` smallint(6) NOT NULL,
  `avis_auteur_vote` int(11) NOT NULL,
  `avis` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote_avis`
--

LOCK TABLES `vote_avis` WRITE;
/*!40000 ALTER TABLE `vote_avis` DISABLE KEYS */;
/*!40000 ALTER TABLE `vote_avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote_commentaire`
--

DROP TABLE IF EXISTS `vote_commentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote_commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commentaire_date_vote` datetime NOT NULL,
  `commentaire_nature_vote` smallint(6) NOT NULL,
  `commentaire_auteur_vote` int(11) NOT NULL,
  `commentaire` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote_commentaire`
--

LOCK TABLES `vote_commentaire` WRITE;
/*!40000 ALTER TABLE `vote_commentaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `vote_commentaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote_question`
--

DROP TABLE IF EXISTS `vote_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_date_vote` datetime NOT NULL,
  `question_nature_vote` smallint(6) NOT NULL,
  `question_auteur_vote` int(11) NOT NULL,
  `avis` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote_question`
--

LOCK TABLES `vote_question` WRITE;
/*!40000 ALTER TABLE `vote_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `vote_question` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-11-05  2:06:35
