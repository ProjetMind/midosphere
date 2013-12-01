-- MySQL dump 10.13  Distrib 5.5.33, for osx10.6 (i386)
--
-- Host: localhost    Database: mind
-- ------------------------------------------------------
-- Server version	5.5.33

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
-- Table structure for table `acl_classes`
--

DROP TABLE IF EXISTS `acl_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_69DD750638A36066` (`class_type`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_classes`
--

LOCK TABLES `acl_classes` WRITE;
/*!40000 ALTER TABLE `acl_classes` DISABLE KEYS */;
INSERT INTO `acl_classes` VALUES (12,'Mind\\CommentaireBundle\\Entity\\CommentaireAvis'),(11,'Mind\\CommentaireBundle\\Entity\\CommentaireQuestion'),(3,'Mind\\MediaBundle\\Entity\\ImageAvis'),(5,'Mind\\MediaBundle\\Entity\\OpinionAvis'),(13,'Mind\\MediaBundle\\Entity\\OpinionQuestion'),(2,'Mind\\MediaBundle\\Entity\\Suivis'),(9,'Mind\\MpBundle\\Entity\\Conversation'),(8,'Mind\\MpBundle\\Entity\\Dossier'),(7,'Mind\\MpBundle\\Entity\\Lu'),(10,'Mind\\MpBundle\\Entity\\Message'),(6,'Mind\\MpBundle\\Entity\\Participants'),(1,'Mind\\SiteBundle\\Entity\\Avis'),(4,'Mind\\SiteBundle\\Entity\\Question');
/*!40000 ALTER TABLE `acl_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_entries`
--

DROP TABLE IF EXISTS `acl_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(10) unsigned NOT NULL,
  `object_identity_id` int(10) unsigned DEFAULT NULL,
  `security_identity_id` int(10) unsigned NOT NULL,
  `field_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ace_order` smallint(5) unsigned NOT NULL,
  `mask` int(11) NOT NULL,
  `granting` tinyint(1) NOT NULL,
  `granting_strategy` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `audit_success` tinyint(1) NOT NULL,
  `audit_failure` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4` (`class_id`,`object_identity_id`,`field_name`,`ace_order`),
  KEY `IDX_46C8B806EA000B103D9AB4A6DF9183C9` (`class_id`,`object_identity_id`,`security_identity_id`),
  KEY `IDX_46C8B806EA000B10` (`class_id`),
  KEY `IDX_46C8B8063D9AB4A6` (`object_identity_id`),
  KEY `IDX_46C8B806DF9183C9` (`security_identity_id`),
  CONSTRAINT `FK_46C8B806DF9183C9` FOREIGN KEY (`security_identity_id`) REFERENCES `acl_security_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_46C8B8063D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_46C8B806EA000B10` FOREIGN KEY (`class_id`) REFERENCES `acl_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_entries`
--

LOCK TABLES `acl_entries` WRITE;
/*!40000 ALTER TABLE `acl_entries` DISABLE KEYS */;
INSERT INTO `acl_entries` VALUES (1,1,5,1,NULL,0,128,1,'all',0,0),(2,2,6,1,NULL,0,128,1,'all',0,0),(3,1,7,1,NULL,0,128,1,'all',0,0),(4,2,8,1,NULL,0,128,1,'all',0,0),(5,3,9,1,NULL,0,128,1,'all',0,0),(6,1,10,1,NULL,0,128,1,'all',0,0),(7,2,11,2,NULL,0,128,1,'all',0,0),(8,4,12,2,NULL,0,128,1,'all',0,0),(9,5,13,2,NULL,0,128,1,'all',0,0),(10,6,14,2,NULL,0,128,1,'all',0,0),(11,6,15,1,NULL,0,128,1,'all',0,0),(12,6,16,3,NULL,0,128,1,'all',0,0),(13,7,17,2,NULL,0,128,1,'all',0,0),(14,7,18,2,NULL,0,128,1,'all',0,0),(15,7,19,2,NULL,0,128,1,'all',0,0),(16,8,20,2,NULL,0,128,1,'all',0,0),(17,8,21,1,NULL,0,128,1,'all',0,0),(18,8,22,3,NULL,0,128,1,'all',0,0),(19,9,23,2,NULL,0,128,1,'all',0,0),(20,10,24,2,NULL,0,128,1,'all',0,0),(21,7,25,2,NULL,0,128,1,'all',0,0),(22,7,26,2,NULL,0,128,1,'all',0,0),(23,7,27,2,NULL,0,128,1,'all',0,0),(24,5,28,2,NULL,0,128,1,'all',0,0),(25,11,29,2,NULL,0,128,1,'all',0,0),(26,12,30,2,NULL,0,128,1,'all',0,0),(27,2,31,1,NULL,0,128,1,'all',0,0),(28,2,32,1,NULL,0,128,1,'all',0,0),(29,2,33,1,NULL,0,128,1,'all',0,0),(30,13,34,1,NULL,0,128,1,'all',0,0),(31,2,35,2,NULL,0,128,1,'all',0,0),(32,2,36,2,NULL,0,128,1,'all',0,0),(33,2,37,2,NULL,0,128,1,'all',0,0),(34,2,38,2,NULL,0,128,1,'all',0,0),(35,4,39,2,NULL,0,128,1,'all',0,0),(36,13,40,2,NULL,0,128,1,'all',0,0),(37,5,41,2,NULL,0,128,1,'all',0,0),(38,13,42,2,NULL,0,128,1,'all',0,0),(39,13,43,2,NULL,0,128,1,'all',0,0),(40,13,44,2,NULL,0,128,1,'all',0,0),(41,13,45,2,NULL,0,128,1,'all',0,0),(42,13,46,2,NULL,0,128,1,'all',0,0),(43,7,47,2,NULL,0,128,1,'all',0,0),(44,7,48,2,NULL,0,128,1,'all',0,0),(45,7,49,2,NULL,0,128,1,'all',0,0);
/*!40000 ALTER TABLE `acl_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_object_identities`
--

DROP TABLE IF EXISTS `acl_object_identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_object_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_object_identity_id` int(10) unsigned DEFAULT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `object_identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entries_inheriting` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9407E5494B12AD6EA000B10` (`object_identifier`,`class_id`),
  KEY `IDX_9407E54977FA751A` (`parent_object_identity_id`),
  CONSTRAINT `FK_9407E54977FA751A` FOREIGN KEY (`parent_object_identity_id`) REFERENCES `acl_object_identities` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_object_identities`
--

LOCK TABLES `acl_object_identities` WRITE;
/*!40000 ALTER TABLE `acl_object_identities` DISABLE KEYS */;
INSERT INTO `acl_object_identities` VALUES (1,NULL,1,'2',1),(2,NULL,1,'3',1),(3,NULL,1,'4',1),(4,NULL,1,'5',1),(5,NULL,1,'6',1),(6,NULL,2,'8',1),(7,NULL,1,'8',1),(8,NULL,2,'9',1),(9,NULL,3,'4',1),(10,NULL,1,'9',1),(11,NULL,2,'10',1),(12,NULL,4,'1',1),(13,NULL,5,'2',1),(14,NULL,6,'1',1),(15,NULL,6,'2',1),(16,NULL,6,'3',1),(17,NULL,7,'1',1),(18,NULL,7,'2',1),(19,NULL,7,'3',1),(20,NULL,8,'1',1),(21,NULL,8,'2',1),(22,NULL,8,'3',1),(23,NULL,9,'1',1),(24,NULL,10,'1',1),(25,NULL,7,'4',1),(26,NULL,7,'5',1),(27,NULL,7,'6',1),(28,NULL,5,'3',1),(29,NULL,11,'1',1),(30,NULL,12,'1',1),(31,NULL,2,'11',1),(32,NULL,2,'12',1),(33,NULL,2,'13',1),(34,NULL,13,'1',1),(35,NULL,2,'14',1),(36,NULL,2,'15',1),(37,NULL,2,'16',1),(38,NULL,2,'17',1),(39,NULL,4,'2',1),(40,NULL,13,'2',1),(41,NULL,5,'4',1),(42,NULL,13,'3',1),(43,NULL,13,'4',1),(44,NULL,13,'5',1),(45,NULL,13,'6',1),(46,NULL,13,'7',1),(47,NULL,7,'7',1),(48,NULL,7,'8',1),(49,NULL,7,'9',1);
/*!40000 ALTER TABLE `acl_object_identities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_object_identity_ancestors`
--

DROP TABLE IF EXISTS `acl_object_identity_ancestors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_object_identity_ancestors` (
  `object_identity_id` int(10) unsigned NOT NULL,
  `ancestor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`object_identity_id`,`ancestor_id`),
  KEY `IDX_825DE2993D9AB4A6` (`object_identity_id`),
  KEY `IDX_825DE299C671CEA1` (`ancestor_id`),
  CONSTRAINT `FK_825DE299C671CEA1` FOREIGN KEY (`ancestor_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_825DE2993D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_object_identity_ancestors`
--

LOCK TABLES `acl_object_identity_ancestors` WRITE;
/*!40000 ALTER TABLE `acl_object_identity_ancestors` DISABLE KEYS */;
INSERT INTO `acl_object_identity_ancestors` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10),(11,11),(12,12),(13,13),(14,14),(15,15),(16,16),(17,17),(18,18),(19,19),(20,20),(21,21),(22,22),(23,23),(24,24),(25,25),(26,26),(27,27),(28,28),(29,29),(30,30),(31,31),(32,32),(33,33),(34,34),(35,35),(36,36),(37,37),(38,38),(39,39),(40,40),(41,41),(42,42),(43,43),(44,44),(45,45),(46,46),(47,47),(48,48),(49,49);
/*!40000 ALTER TABLE `acl_object_identity_ancestors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_security_identities`
--

DROP TABLE IF EXISTS `acl_security_identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_security_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `username` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8835EE78772E836AF85E0677` (`identifier`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_security_identities`
--

LOCK TABLES `acl_security_identities` WRITE;
/*!40000 ALTER TABLE `acl_security_identities` DISABLE KEYS */;
INSERT INTO `acl_security_identities` VALUES (3,'Mind\\UserBundle\\Entity\\User-Diallo',1),(1,'Mind\\UserBundle\\Entity\\User-Hipopeur',1),(2,'Mind\\UserBundle\\Entity\\User-Start',1);
/*!40000 ALTER TABLE `acl_security_identities` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avatar`
--

LOCK TABLES `avatar` WRITE;
/*!40000 ALTER TABLE `avatar` DISABLE KEYS */;
INSERT INTO `avatar` VALUES (1,'../web/img/avatar-femme.jpeg',NULL,NULL,1),(2,'../web/img/avatar-femme.jpeg',NULL,NULL,2),(3,'../web/img/avatar-femme.jpeg',NULL,NULL,3);
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
  `avis` longtext COLLATE utf8_unicode_ci NOT NULL,
  `type_opinion` int(11) NOT NULL,
  `avis_date_publication` datetime NOT NULL,
  `avis_date_edition` datetime DEFAULT NULL,
  `avis_auteur` int(11) NOT NULL,
  `avis_adresse` int(11) DEFAULT NULL,
  `avis_domaine` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8F91ABF0989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avis`
--

LOCK TABLES `avis` WRITE;
/*!40000 ALTER TABLE `avis` DISABLE KEYS */;
INSERT INTO `avis` VALUES (7,NULL,'Second avis avec ACL','second-avis-avec-acl','Utilisation de ACL sur suivis',2,'2013-11-26 02:54:32',NULL,1,NULL,1),(8,NULL,'Second avis avec ACL','second-avis-avec-acl-1','Second avis avec utilisation de ACL sur suivis',2,'2013-11-26 02:57:15','2013-11-26 22:11:42',1,NULL,2),(9,NULL,'Troisième avis avec ACL','troisieme-avis-avec-acl','Utilisation de ACL avec les images',1,'2013-11-26 03:01:22',NULL,1,NULL,3);
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
  `commentaire` longtext COLLATE utf8_unicode_ci NOT NULL,
  `commentaire_date_publication` datetime NOT NULL,
  `id_avis` int(11) NOT NULL,
  `commentaire_id_auteur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire_avis`
--

LOCK TABLES `commentaire_avis` WRITE;
/*!40000 ALTER TABLE `commentaire_avis` DISABLE KEYS */;
INSERT INTO `commentaire_avis` VALUES (1,NULL,'lool','2013-11-30 22:40:05',9,3);
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
  `commentaire` longtext COLLATE utf8_unicode_ci NOT NULL,
  `commentaire_date_publication` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire_question`
--

LOCK TABLES `commentaire_question` WRITE;
/*!40000 ALTER TABLE `commentaire_question` DISABLE KEYS */;
INSERT INTO `commentaire_question` VALUES (1,1,3,'loplrg  lfjer  eferf,er','2013-11-30 22:35:42');
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
  `auteur_conversation` int(11) NOT NULL,
  `date_debut_conversation` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conversation`
--

LOCK TABLES `conversation` WRITE;
/*!40000 ALTER TABLE `conversation` DISABLE KEYS */;
INSERT INTO `conversation` VALUES (1,3,'2013-11-29 11:00:46');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domaine`
--

LOCK TABLES `domaine` WRITE;
/*!40000 ALTER TABLE `domaine` DISABLE KEYS */;
INSERT INTO `domaine` VALUES (1,NULL,1,'Voyage','voyage',0,'2013-11-25 23:49:17',NULL,0,-1,0,1),(2,NULL,3,'Informatique','informatique',1,'2013-11-26 05:06:35',NULL,0,-1,2,2),(3,2,3,'PHP','php',1,'2013-11-26 05:07:00',NULL,1,0,1,2),(4,NULL,3,'Santé','sante',1,'2013-12-01 23:27:06',NULL,0,-1,0,4);
/*!40000 ALTER TABLE `domaine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dossier`
--

DROP TABLE IF EXISTS `dossier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dossier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_conversation` int(11) NOT NULL,
  `dossier` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dossier`
--

LOCK TABLES `dossier` WRITE;
/*!40000 ALTER TABLE `dossier` DISABLE KEYS */;
INSERT INTO `dossier` VALUES (1,3,1,'bal'),(2,1,1,'bal'),(3,2,1,'bal');
/*!40000 ALTER TABLE `dossier` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_avis`
--

LOCK TABLES `image_avis` WRITE;
/*!40000 ALTER TABLE `image_avis` DISABLE KEYS */;
INSERT INTO `image_avis` VALUES (4,NULL,'../web/uploads/avis/images/56bc19b31447c13dc5ea0505a6bddb22bdcc18b3.jpg','image/jpeg',69752,9);
/*!40000 ALTER TABLE `image_avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lu`
--

DROP TABLE IF EXISTS `lu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_message` int(11) NOT NULL,
  `id_conversation` int(11) NOT NULL,
  `lu` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lu`
--

LOCK TABLES `lu` WRITE;
/*!40000 ALTER TABLE `lu` DISABLE KEYS */;
INSERT INTO `lu` VALUES (1,3,1,1,1),(2,1,1,1,1),(3,2,1,1,0),(4,3,8,1,1),(5,1,8,1,0),(6,2,8,1,0),(7,3,9,1,1),(8,1,9,1,0),(9,2,9,1,0);
/*!40000 ALTER TABLE `lu` ENABLE KEYS */;
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
  CONSTRAINT `FK_80D4C541EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media__media` (`id`),
  CONSTRAINT `FK_80D4C5414E7AF8F` FOREIGN KEY (`gallery_id`) REFERENCES `media__gallery` (`id`)
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
  `id_conversation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (1,3,'Un premier message','2013-11-29 11:00:45',1),(2,3,'looool','2013-11-29 11:01:02',1),(3,1,'bouuuh','2013-11-29 11:18:35',1),(4,3,'test','2013-11-29 12:04:01',1),(5,3,'llknlknl','2013-11-29 12:05:41',1),(6,3,'jvvhjh','2013-11-29 12:08:22',1),(7,3,'jbkkhjghhg','2013-11-29 12:10:00',1),(8,3,'vbnv nl kl ljkl jkllkj lmj kljk ljkljl','2013-11-29 12:11:07',1),(9,3,'jn, n,n','2013-12-01 23:10:22',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opinion_question`
--

LOCK TABLES `opinion_question` WRITE;
/*!40000 ALTER TABLE `opinion_question` DISABLE KEYS */;
INSERT INTO `opinion_question` VALUES (1,3,1,2,'2013-11-30 23:58:20'),(7,3,2,1,'2013-12-01 21:22:16');
/*!40000 ALTER TABLE `opinion_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conversation` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants`
--

LOCK TABLES `participants` WRITE;
/*!40000 ALTER TABLE `participants` DISABLE KEYS */;
INSERT INTO `participants` VALUES (1,1,3),(2,1,1),(3,1,2);
/*!40000 ALTER TABLE `participants` ENABLE KEYS */;
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
  `question` longtext COLLATE utf8_unicode_ci NOT NULL,
  `question_date_publication` datetime NOT NULL,
  `question_date_edition` datetime DEFAULT NULL,
  `question_auteur` int(11) NOT NULL,
  `question_domaine` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B6F7494E989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'Question avec ACL','question-avec-acl','sefs knjknjk','2013-11-26 06:30:32','2013-11-30 22:33:47',3,1),(2,'Looooool','looooool','jebskjbc','2013-12-01 21:10:33',NULL,3,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suivis`
--

LOCK TABLES `suivis` WRITE;
/*!40000 ALTER TABLE `suivis` DISABLE KEYS */;
INSERT INTO `suivis` VALUES (1,1,1,'avis',1),(2,1,2,'avis',1),(3,1,3,'avis',1),(4,1,4,'avis',1),(5,1,5,'avis',1),(6,1,6,'avis',1),(8,1,8,'avis',1),(9,1,9,'avis',1),(13,1,1,'question',1),(16,3,1,'question',1),(17,3,2,'question',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Hipopeur','hipopeur','shonen.shojo@gmail.com','shonen.shojo@gmail.com',1,'tr2wqukglqo8okg0ck08s8kwokcok40','NZdTsWDBvX/77Amk4xTBajZqzCnNSW83xon/b8GU6hsPV/43Il7pZtesNkaq5hv7n038Ke1pDHw+BIVjCdi0aw==','2013-11-26 01:16:39',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,NULL,'../web/img/avatar-femme.jpeg','hipopeur',NULL,'1991-05-25','1','AN','2013-11-25 23:29:02',1,NULL),(2,'Diallo','diallo','diallo.mouhamadou.dev@gmail.com','diallo.mouhamadou.dev@gmail.com',1,'ar40cb0dlrcoog480o00ckwwok0g8c','qXsbFVIxmULmQ0F4LFPUZmboSVNIZisEYG6mrgTq/qEZwouHoldZJ5xHlt6aDdr1X59wy6YUBi5Mq37j9XtnSQ==','2013-11-26 03:11:25',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,NULL,'../web/img/avatar-femme.jpeg','diallo',NULL,'1917-09-25','0','AR','2013-11-26 03:09:35',1,NULL),(3,'Start','start','diallo.mouhamadou.sio@gmail.com','diallo.mouhamadou.sio@gmail.com',1,'linugm5hgw0wo4cgs8g08cokg000o4k','zqzX+/h+PLL/hdtzLJRl5XGzazUJroovtaaSewjH1Z8zzIC3nPAPbAJWdCLGZKWQHKlOXGxzkvTzmDbb4cpD6g==','2013-12-01 21:06:43',0,0,NULL,NULL,NULL,'a:2:{i:0;s:10:\"ROLE_ADMIN\";i:1;s:22:\"ROLE_ALLOWED_TO_SWITCH\";}',0,NULL,NULL,'../web/img/avatar-femme.jpeg','start',NULL,'1911-06-05','0','BS','2013-11-26 03:21:57',1,NULL);
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

-- Dump completed on 2013-12-01 23:30:16
