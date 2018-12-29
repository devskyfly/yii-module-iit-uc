-- MySQL dump 10.13  Distrib 5.6.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: yii_basic_test
-- ------------------------------------------------------
-- Server version	5.6.35-1+deb.sury.org~xenial+0.1

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
-- Table structure for table `agent`
--

DROP TABLE IF EXISTS `agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  `info` text,
  `lk_guid` char(36) DEFAULT NULL,
  `lng` char(40) DEFAULT NULL,
  `lat` char(40) DEFAULT NULL,
  `lk_address` text,
  `custom_address` text,
  `manager_in_charge` text,
  `_region__id` int(11) DEFAULT NULL,
  `_settlement__id` int(11) DEFAULT NULL,
  `phone` text,
  `email` text,
  `flag_is_license` enum('Y','N') NOT NULL,
  `flag_is_own` enum('Y','N') NOT NULL,
  `flag_is_public` enum('Y','N') NOT NULL,
  `flag_is_need_to_custom` enum('Y','N') NOT NULL,
  `partner_code` char(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent`
--

LOCK TABLES `agent` WRITE;
/*!40000 ALTER TABLE `agent` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `binder`
--

DROP TABLE IF EXISTS `binder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `binder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `master_id` int(11) DEFAULT NULL,
  `slave_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `binder`
--

LOCK TABLES `binder` WRITE;
/*!40000 ALTER TABLE `binder` DISABLE KEYS */;
/*!40000 ALTER TABLE `binder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity`
--

DROP TABLE IF EXISTS `entity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity`
--

LOCK TABLES `entity` WRITE;
/*!40000 ALTER TABLE `entity` DISABLE KEYS */;
/*!40000 ALTER TABLE `entity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity_without_section`
--

DROP TABLE IF EXISTS `entity_without_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_without_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_without_section`
--

LOCK TABLES `entity_without_section` WRITE;
/*!40000 ALTER TABLE `entity_without_section` DISABLE KEYS */;
/*!40000 ALTER TABLE `entity_without_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` char(36) DEFAULT NULL,
  `path` text,
  `item_table` varchar(256) NOT NULL,
  `__id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guid` (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iit_uc_binder`
--

DROP TABLE IF EXISTS `iit_uc_binder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iit_uc_binder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `master_id` int(11) DEFAULT NULL,
  `slave_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=400 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iit_uc_binder`
--

LOCK TABLES `iit_uc_binder` WRITE;
/*!40000 ALTER TABLE `iit_uc_binder` DISABLE KEYS */;
INSERT INTO `iit_uc_binder` VALUES (1,'ServicePackageToServiceBinder',1,1),(2,'ServicePackageToServiceBinder',2,1),(3,'ServicePackageToServiceBinder',2,4),(4,'ServicePackageToServiceBinder',3,1),(5,'ServicePackageToServiceBinder',3,4),(6,'ServicePackageToServiceBinder',4,2),(7,'ServicePackageToServiceBinder',4,12),(8,'ServicePackageToServiceBinder',4,4),(9,'ServicePackageToServiceBinder',5,2),(10,'ServicePackageToServiceBinder',5,12),(11,'ServicePackageToServiceBinder',5,4),(12,'ServicePackageToServiceBinder',6,1),(13,'ServicePackageToServiceBinder',6,4),(14,'ServicePackageToServiceBinder',7,5),(15,'ServicePackageToServiceBinder',7,4),(16,'StockToServicePackageBinder',1,1),(17,'StockToServicePackageBinder',1,7),(18,'StockToCheckedServiceBinder',1,1),(19,'StockToServicePackageBinder',2,2),(20,'StockToCheckedServiceBinder',2,1),(21,'StockToServicePackageBinder',3,3),(22,'StockToCheckedServiceBinder',3,1),(23,'StockToServicePackageBinder',4,4),(24,'StockToServicePackageBinder',5,5),(25,'StockToServicePackageBinder',6,6),(26,'StockToCheckedServiceBinder',6,1),(27,'RateToSiteBinder',9,10),(28,'RateToSiteBinder',18,181),(29,'RateToSiteBinder',18,186),(30,'RateToSiteBinder',18,183),(31,'RateToSiteBinder',18,184),(32,'RateToSiteBinder',18,185),(33,'RateToSiteBinder',16,177),(34,'RateToSiteBinder',13,11),(35,'RateToSiteBinder',17,176),(36,'RateToSiteBinder',15,178),(37,'RateToSiteBinder',8,9),(38,'RateToSiteBinder',25,167),(39,'RateToSiteBinder',19,189),(40,'RateToSiteBinder',14,179),(41,'RateToSiteBinder',7,8),(42,'RateToSiteBinder',12,174),(43,'RateToSiteBinder',12,175),(44,'RateToSiteBinder',6,64),(45,'RateToSiteBinder',6,65),(46,'RateToSiteBinder',6,66),(47,'RateToSiteBinder',6,67),(48,'RateToSiteBinder',6,68),(49,'RateToSiteBinder',6,125),(50,'RateToSiteBinder',6,132),(51,'RateToSiteBinder',6,133),(52,'RateToSiteBinder',6,151),(53,'RateToSiteBinder',6,69),(54,'RateToSiteBinder',6,71),(55,'RateToSiteBinder',6,78),(56,'RateToSiteBinder',6,81),(57,'RateToSiteBinder',6,83),(58,'RateToSiteBinder',6,84),(59,'RateToSiteBinder',6,85),(60,'RateToSiteBinder',6,87),(61,'RateToSiteBinder',6,88),(62,'RateToSiteBinder',6,89),(63,'RateToSiteBinder',6,90),(64,'RateToSiteBinder',6,91),(65,'RateToSiteBinder',6,94),(66,'RateToSiteBinder',6,95),(67,'RateToSiteBinder',6,96),(68,'RateToSiteBinder',6,97),(69,'RateToSiteBinder',6,99),(70,'RateToSiteBinder',6,100),(71,'RateToSiteBinder',6,7),(72,'RateToSiteBinder',6,101),(73,'RateToSiteBinder',6,102),(74,'RateToSiteBinder',6,103),(75,'RateToSiteBinder',6,104),(76,'RateToSiteBinder',6,105),(77,'RateToSiteBinder',6,106),(78,'RateToSiteBinder',6,108),(79,'RateToSiteBinder',6,109),(80,'RateToSiteBinder',6,110),(81,'RateToSiteBinder',6,111),(82,'RateToSiteBinder',6,114),(83,'RateToSiteBinder',6,115),(84,'RateToSiteBinder',6,116),(85,'RateToSiteBinder',6,119),(86,'RateToSiteBinder',6,120),(87,'RateToSiteBinder',6,124),(88,'RateToSiteBinder',6,126),(89,'RateToSiteBinder',6,8),(90,'RateToSiteBinder',6,128),(91,'RateToSiteBinder',6,70),(92,'RateToSiteBinder',6,113),(93,'RateToSiteBinder',6,142),(94,'RateToSiteBinder',6,150),(95,'RateToSiteBinder',6,152),(96,'RateToSiteBinder',6,134),(97,'RateToSiteBinder',6,153),(98,'RateToSiteBinder',6,155),(99,'RateToSiteBinder',6,161),(100,'RateToSiteBinder',6,162),(101,'RateToSiteBinder',6,163),(102,'RateToSiteBinder',6,164),(103,'RateToSiteBinder',6,168),(104,'RateToSiteBinder',29,198),(105,'RateToSiteBinder',21,170),(106,'RateToSiteBinder',22,169),(107,'RateToSiteBinder',24,12),(108,'RateToSiteBinder',24,160),(109,'RateToSiteBinder',4,64),(110,'RateToSiteBinder',4,65),(111,'RateToSiteBinder',4,66),(112,'RateToSiteBinder',4,67),(113,'RateToSiteBinder',4,68),(114,'RateToSiteBinder',4,125),(115,'RateToSiteBinder',4,132),(116,'RateToSiteBinder',4,133),(117,'RateToSiteBinder',4,151),(118,'RateToSiteBinder',4,134),(119,'RateToSiteBinder',4,161),(120,'RateToSiteBinder',23,4),(121,'RateToSiteBinder',28,172),(122,'RateToSiteBinder',20,48),(123,'RateToSiteBinder',3,173),(124,'RateToSiteBinder',10,193),(125,'RateToSiteBinder',26,190),(126,'RateToSiteBinder',1,1),(127,'RateToSiteBinder',1,36),(128,'RateToSiteBinder',1,13),(129,'RateToSiteBinder',1,14),(130,'RateToSiteBinder',1,37),(131,'RateToSiteBinder',1,15),(132,'RateToSiteBinder',1,38),(133,'RateToSiteBinder',1,39),(134,'RateToSiteBinder',1,40),(135,'RateToSiteBinder',1,16),(136,'RateToSiteBinder',1,17),(137,'RateToSiteBinder',1,18),(138,'RateToSiteBinder',1,19),(139,'RateToSiteBinder',1,20),(140,'RateToSiteBinder',1,21),(141,'RateToSiteBinder',1,22),(142,'RateToSiteBinder',1,41),(143,'RateToSiteBinder',1,43),(144,'RateToSiteBinder',1,44),(145,'RateToSiteBinder',1,25),(146,'RateToSiteBinder',1,23),(147,'RateToSiteBinder',1,26),(148,'RateToSiteBinder',1,27),(149,'RateToSiteBinder',1,28),(150,'RateToSiteBinder',1,29),(151,'RateToSiteBinder',1,30),(152,'RateToSiteBinder',1,31),(153,'RateToSiteBinder',1,32),(154,'RateToSiteBinder',1,33),(155,'RateToSiteBinder',1,47),(156,'RateToSiteBinder',1,45),(157,'RateToSiteBinder',1,34),(158,'RateToSiteBinder',1,35),(159,'RateToSiteBinder',1,46),(160,'RateToSiteBinder',1,49),(161,'RateToSiteBinder',1,130),(162,'RateToSiteBinder',1,131),(163,'RateToSiteBinder',1,52),(164,'RateToSiteBinder',1,50),(165,'RateToSiteBinder',1,51),(166,'RateToSiteBinder',1,135),(167,'RateToSiteBinder',1,137),(168,'RateToSiteBinder',1,138),(169,'RateToSiteBinder',1,139),(170,'RateToSiteBinder',1,53),(171,'RateToSiteBinder',1,54),(172,'RateToSiteBinder',1,140),(173,'RateToSiteBinder',1,117),(174,'RateToSiteBinder',1,127),(175,'RateToSiteBinder',1,145),(176,'RateToSiteBinder',1,146),(177,'RateToSiteBinder',1,147),(178,'RateToSiteBinder',1,148),(179,'RateToSiteBinder',1,55),(180,'RateToSiteBinder',1,56),(181,'RateToSiteBinder',1,57),(182,'RateToSiteBinder',1,156),(183,'RateToSiteBinder',1,191),(184,'RateToSiteBinder',1,58),(185,'RateToSiteBinder',1,197),(186,'RateToSiteBinder',1,157),(187,'RateToSiteBinder',1,158),(188,'RateToSiteBinder',1,159),(189,'RateToSiteBinder',1,59),(190,'RateToSiteBinder',1,60),(191,'RateToSiteBinder',1,154),(192,'RateToSiteBinder',1,107),(193,'RateToSiteBinder',1,129),(194,'RateToSiteBinder',1,143),(195,'RateToSiteBinder',1,165),(196,'RateToSiteBinder',1,62),(197,'RateToSiteBinder',1,63),(198,'RateToSiteBinder',1,123),(199,'RateToSiteBinder',1,166),(200,'RateToSiteBinder',1,61),(201,'RateToSiteBinder',5,69),(202,'RateToSiteBinder',5,71),(203,'RateToSiteBinder',5,81),(204,'RateToSiteBinder',5,83),(205,'RateToSiteBinder',5,84),(206,'RateToSiteBinder',5,85),(207,'RateToSiteBinder',5,87),(208,'RateToSiteBinder',5,88),(209,'RateToSiteBinder',5,89),(210,'RateToSiteBinder',5,90),(211,'RateToSiteBinder',5,91),(212,'RateToSiteBinder',5,94),(213,'RateToSiteBinder',5,95),(214,'RateToSiteBinder',5,96),(215,'RateToSiteBinder',5,97),(216,'RateToSiteBinder',5,99),(217,'RateToSiteBinder',5,100),(218,'RateToSiteBinder',5,7),(219,'RateToSiteBinder',5,101),(220,'RateToSiteBinder',5,102),(221,'RateToSiteBinder',5,103),(222,'RateToSiteBinder',5,104),(223,'RateToSiteBinder',5,105),(224,'RateToSiteBinder',5,106),(225,'RateToSiteBinder',5,108),(226,'RateToSiteBinder',5,109),(227,'RateToSiteBinder',5,110),(228,'RateToSiteBinder',5,111),(229,'RateToSiteBinder',5,114),(230,'RateToSiteBinder',5,115),(231,'RateToSiteBinder',5,116),(232,'RateToSiteBinder',5,119),(233,'RateToSiteBinder',5,120),(234,'RateToSiteBinder',5,124),(235,'RateToSiteBinder',5,126),(236,'RateToSiteBinder',5,8),(237,'RateToSiteBinder',5,128),(238,'RateToSiteBinder',5,70),(239,'RateToSiteBinder',5,113),(240,'RateToSiteBinder',5,142),(241,'RateToSiteBinder',5,150),(242,'RateToSiteBinder',5,152),(243,'RateToSiteBinder',5,153),(244,'RateToSiteBinder',5,155),(245,'RateToSiteBinder',5,162),(246,'RateToSiteBinder',5,163),(247,'RateToSiteBinder',5,164),(248,'RateToSiteBinder',5,168),(249,'RateToSiteBinder',2,1),(250,'RateToSiteBinder',2,36),(251,'RateToSiteBinder',2,13),(252,'RateToSiteBinder',2,14),(253,'RateToSiteBinder',2,37),(254,'RateToSiteBinder',2,15),(255,'RateToSiteBinder',2,38),(256,'RateToSiteBinder',2,39),(257,'RateToSiteBinder',2,40),(258,'RateToSiteBinder',2,16),(259,'RateToSiteBinder',2,17),(260,'RateToSiteBinder',2,18),(261,'RateToSiteBinder',2,19),(262,'RateToSiteBinder',2,20),(263,'RateToSiteBinder',2,21),(264,'RateToSiteBinder',2,22),(265,'RateToSiteBinder',2,41),(266,'RateToSiteBinder',2,43),(267,'RateToSiteBinder',2,44),(268,'RateToSiteBinder',2,25),(269,'RateToSiteBinder',2,23),(270,'RateToSiteBinder',2,26),(271,'RateToSiteBinder',2,27),(272,'RateToSiteBinder',2,28),(273,'RateToSiteBinder',2,29),(274,'RateToSiteBinder',2,30),(275,'RateToSiteBinder',2,31),(276,'RateToSiteBinder',2,32),(277,'RateToSiteBinder',2,33),(278,'RateToSiteBinder',2,47),(279,'RateToSiteBinder',2,45),(280,'RateToSiteBinder',2,34),(281,'RateToSiteBinder',2,35),(282,'RateToSiteBinder',2,46),(283,'RateToSiteBinder',2,49),(284,'RateToSiteBinder',2,130),(285,'RateToSiteBinder',2,131),(286,'RateToSiteBinder',2,52),(287,'RateToSiteBinder',2,50),(288,'RateToSiteBinder',2,51),(289,'RateToSiteBinder',2,135),(290,'RateToSiteBinder',2,137),(291,'RateToSiteBinder',2,138),(292,'RateToSiteBinder',2,139),(293,'RateToSiteBinder',2,53),(294,'RateToSiteBinder',2,54),(295,'RateToSiteBinder',2,140),(296,'RateToSiteBinder',2,117),(297,'RateToSiteBinder',2,127),(298,'RateToSiteBinder',2,145),(299,'RateToSiteBinder',2,146),(300,'RateToSiteBinder',2,147),(301,'RateToSiteBinder',2,148),(302,'RateToSiteBinder',2,55),(303,'RateToSiteBinder',2,56),(304,'RateToSiteBinder',2,57),(305,'RateToSiteBinder',2,156),(306,'RateToSiteBinder',2,191),(307,'RateToSiteBinder',2,58),(308,'RateToSiteBinder',2,197),(309,'RateToSiteBinder',2,157),(310,'RateToSiteBinder',2,158),(311,'RateToSiteBinder',2,159),(312,'RateToSiteBinder',2,59),(313,'RateToSiteBinder',2,60),(314,'RateToSiteBinder',2,154),(315,'RateToSiteBinder',2,107),(316,'RateToSiteBinder',2,129),(317,'RateToSiteBinder',2,143),(318,'RateToSiteBinder',2,165),(319,'RateToSiteBinder',2,62),(320,'RateToSiteBinder',2,63),(321,'RateToSiteBinder',2,123),(322,'RateToSiteBinder',2,166),(323,'RateToSiteBinder',2,24),(324,'RateToSiteBinder',2,61),(325,'RateToSiteBinder',2,199),(326,'RateToSiteBinder',2,200),(327,'RateToSiteBinder',2,201),(328,'RateToSiteBinder',11,192),(329,'RateToSiteBinder',27,187),(330,'RateToSiteBinder',36,26),(331,'RateToSiteBinder',35,202),(332,'PowerPackageToPowerBinder',1,1),(333,'PowerPackageToPowerBinder',1,2),(334,'PowerPackageToPowerBinder',1,3),(335,'PowerPackageToPowerBinder',1,4),(336,'PowerPackageToPowerBinder',1,5),(337,'RateToPowerPackageBinder',20,1),(338,'PowerPackageToPowerBinder',2,6),(339,'PowerPackageToPowerBinder',2,7),(340,'PowerPackageToPowerBinder',2,8),(341,'RateToPowerPackageBinder',23,2),(342,'PowerPackageToPowerBinder',3,9),(343,'PowerPackageToPowerBinder',3,10),(344,'PowerPackageToPowerBinder',3,11),(345,'PowerPackageToPowerBinder',3,12),(346,'PowerPackageToPowerBinder',3,13),(347,'PowerPackageToPowerBinder',3,14),(348,'PowerPackageToPowerBinder',3,15),(349,'PowerPackageToPowerBinder',3,16),(350,'PowerPackageToPowerBinder',3,17),(351,'PowerPackageToPowerBinder',3,18),(352,'PowerPackageToPowerBinder',3,19),(353,'PowerPackageToPowerBinder',3,20),(354,'PowerPackageToPowerBinder',3,21),(355,'PowerPackageToPowerBinder',3,22),(356,'PowerPackageToPowerBinder',3,23),(357,'PowerPackageToPowerBinder',3,24),(358,'PowerPackageToPowerBinder',3,25),(359,'PowerPackageToPowerBinder',3,26),(360,'PowerPackageToPowerBinder',3,27),(361,'PowerPackageToPowerBinder',3,28),(362,'PowerPackageToPowerBinder',3,29),(363,'PowerPackageToPowerBinder',3,30),(364,'PowerPackageToPowerBinder',3,31),(365,'PowerPackageToPowerBinder',3,32),(366,'PowerPackageToPowerBinder',3,33),(367,'PowerPackageToPowerBinder',3,34),(368,'PowerPackageToPowerBinder',3,35),(369,'PowerPackageToPowerBinder',3,36),(370,'PowerPackageToPowerBinder',3,37),(371,'PowerPackageToPowerBinder',3,38),(372,'PowerPackageToPowerBinder',3,39),(373,'PowerPackageToPowerBinder',3,40),(374,'PowerPackageToPowerBinder',3,41),(375,'PowerPackageToPowerBinder',3,42),(376,'PowerPackageToPowerBinder',3,43),(377,'PowerPackageToPowerBinder',3,44),(378,'PowerPackageToPowerBinder',3,45),(379,'PowerPackageToPowerBinder',3,46),(380,'PowerPackageToPowerBinder',3,47),(381,'PowerPackageToPowerBinder',3,48),(382,'PowerPackageToPowerBinder',3,49),(383,'PowerPackageToPowerBinder',3,50),(384,'PowerPackageToPowerBinder',3,51),(385,'PowerPackageToPowerBinder',3,52),(386,'RateToPowerPackageBinder',26,3),(387,'PowerPackageToPowerBinder',4,53),(388,'PowerPackageToPowerBinder',4,54),(389,'PowerPackageToPowerBinder',4,55),(390,'PowerPackageToPowerBinder',4,56),(391,'RateToPowerPackageBinder',34,4),(392,'PowerPackageToPowerBinder',5,57),(393,'PowerPackageToPowerBinder',5,58),(394,'PowerPackageToPowerBinder',5,59),(395,'RateToPowerPackageBinder',6,5),(396,'PowerPackageToPowerBinder',6,57),(397,'PowerPackageToPowerBinder',6,58),(398,'PowerPackageToPowerBinder',6,59),(399,'RateToPowerPackageBinder',4,6);
/*!40000 ALTER TABLE `iit_uc_binder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iit_uc_power`
--

DROP TABLE IF EXISTS `iit_uc_power`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iit_uc_power` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  `slx_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iit_uc_power`
--

LOCK TABLES `iit_uc_power` WRITE;
/*!40000 ALTER TABLE `iit_uc_power` DISABLE KEYS */;
INSERT INTO `iit_uc_power` VALUES (1,'Нет',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',326,NULL),(2,'Руководитель органа местного самоуправления',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',326,'1.2.643.5.1.24.2.19'),(3,'Руководитель территориального органа федерального органа исполнительной власти',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',326,'1.2.643.5.1.24.2.43'),(4,'Руководитель федерального органа исполнительной власти',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',326,'1.2.643.5.1.24.2.6'),(5,'Руководитель органа государственной власти субъекта Российской Федерации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',326,'1.2.643.5.1.24.2.20'),(6,'Заказчик',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',327,'1.2.643.6.32.1.2'),(7,'Уполномоченный орган',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',327,'1.2.643.6.32.1.3'),(8,'Специализированная организация',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',327,'1.2.643.6.32.1.4'),(9,'Старший судебный пристав-исполнитель',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.13'),(10,'Арбитражный управляющий',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.27'),(11,'Аудитор Счетной палаты Российской Федерации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.18'),(12,'Генеральный директор Федерального фонда содействия развитию жилищного строительства, заместитель генерального директора указанного фонда, руководитель филиала и представительства указанного фонда, действующий на основании доверенности, оформленной в соотв',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.42'),(13,'Главный судебный пристав Российской Федерации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.9'),(14,'Главный судебный пристав субъекта Российской Федерации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.11'),(15,'Должностные лица, уполномоченные решением Председателя Банка России',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.56'),(16,'Залогодержатель',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.29'),(17,'Заместитель главного судебного пристава Российской Федерации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.10'),(18,'Заместитель главного судебного пристава субъекта Российской Федерации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.12'),(19,'Заместитель Председателя Счетной палаты Российской Федерации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.17'),(20,'Заявитель - иностранное юридическое лицо',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.46'),(21,'Заявитель - физическое лицо',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.1.3'),(22,'Заявитель - юридическое лицо',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.30'),(23,'Кадастровый инженер',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.1.3'),(24,'Нотариус',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.26'),(25,'Ответственное лицо, от имени которого осуществляется шифрование и аутентификация на транспортном уровне веб-сервисов Удостоверяющих центров',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.2.6'),(26,'Председатель суда',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.7'),(27,'Председатель Счетной палаты Российской Федерации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.16'),(28,'Ответственное лицо, от имени которого осуществляется шифрование и аутентификация на транспортном уровне серверов Росреестра',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.2.5'),(29,'Президент государственной корпорации по строительству олимпийских объектов и развитию города Сочи как горноклиматического курорта',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.39'),(30,'Руководители (должностные лица) федеральных государственных органов, перечень которых определяется Президентом Российской Федерации, высшие должностные лица субъектов Российской Федерации (руководители высших исполнительных органов государственной власти',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.47'),(31,'Руководители (заместители руководителей) многофункциональных центров предоставления государственных (муниципальных) услуг',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.49'),(32,'Руководитель (заместитель руководителя) государственного внебюджетного фонда или иное уполномоченное лицо данного фонда в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.51'),(33,'Руководитель (заместитель руководителя) органа местного самоуправления по учету муниципального имущества или иное уполномоченное лицо данного органа в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.5'),(34,'Руководитель (заместитель руководителя) органа по учету государственного имущества Российской Федерации или иное уполномоченное лицо данного органа в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.4'),(35,'Руководитель (заместитель руководителя) органа прокуратуры или иное уполномоченное в соответствии с законодательством Российской Федерации должностное лицо данного органа',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.32'),(36,'Руководитель (заместитель руководителя) правоохранительного органа или иное уполномоченное в соответствии с законодательством Российской Федерации должностное лицо данного органа',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.15'),(37,'Руководитель (заместитель руководителя) территориального органа государственного внебюджетного фонда или иное уполномоченное лицо данного фонда в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.52'),(38,'Руководитель (заместитель руководителя) территориального органа федерального органа исполнительной власти по учету государственного имущества Российской Федерации или иное уполномоченное лицо данного органа в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.45'),(39,'Руководитель (заместитель руководителя)органа исполнительной власти субъекта Российской Федерации по учету государственного имущества субъекта Российской Федерации или иное уполномоченное лицо данного органа в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.44'),(40,'Руководитель органа государственной власти субъекта Российской Федерации или иное уполномоченное лицо данного органа в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.6'),(41,'Руководитель органа местного самоуправления или иное уполномоченное лицо данного органа в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.19'),(42,'Руководитель подведомственной организации органа государственной власти субъекта Российской Федерации, участвующей в предоставлении государственных или муниципальных услуг, или иное уполномоченное лицо данной организации в соответствии с федеральным закон',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.53'),(43,'Руководитель подведомственной организации органа местного самоуправления, участвующей в предоставлении государственных или муниципальных услуг, или иное уполномоченное лицо данной организации в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.54'),(44,'Руководитель подведомственной организации федерального органа исполнительной власти, участвующей в предоставлении государственных или муниципальных услуг, или иное уполномоченное лицо данной организации в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.55'),(45,'Руководитель территориального органа федерального органа исполнительной власти или иное уполномоченное лицо данного органа в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.43'),(46,'Руководитель федерального органа исполнительной власти или иное уполномоченное лицо данного органа в соответствии с федеральным законом',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.20'),(47,'Сотрудники Росреестра и его территориальных органов',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.2.2'),(48,'Сотрудники ФГБУ ФКП Росреестра и его филиалов',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.1.2'),(49,'Судебный пристав- исполнитель',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.14'),(50,'Судья',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.8'),(51,'Уполномоченный при Президенте Российской Федерации по защите прав предпринимателей, уполномоченных по защите прав предпринимателей в субъектах Российской Федерации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.57'),(52,'Уполномоченный при Президенте Российской Федерации по правам ребенка',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',328,'1.2.643.5.1.24.2.50'),(53,'Органы и организации, в ведение которых переданы архивы организаций, выдавших документы об образовании',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',329,'1.2.643.5.1.15.2.13'),(54,'Общеобразовательные организации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',329,'1.2.643.5.1.15.2.12'),(55,'Образовательные организации среднего профессионального образования',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',329,'1.2.643.5.1.15.2.11'),(56,'Образовательные организации (ОО) высшего образования',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',329,'1.2.643.5.1.15.2.10'),(57,'Администратор организации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',330,'1.2.643.6.3.1.4.1'),(58,'Уполномоченный специалист',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',330,'1.2.643.6.3.1.4.2'),(59,'Специалист с правом подписи контракта',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',330,'1.2.643.6.3.1.4.3');
/*!40000 ALTER TABLE `iit_uc_power` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iit_uc_power_package`
--

DROP TABLE IF EXISTS `iit_uc_power_package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iit_uc_power_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  `select_type` enum('MONO','MULTI') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iit_uc_power_package`
--

LOCK TABLES `iit_uc_power_package` WRITE;
/*!40000 ALTER TABLE `iit_uc_power_package` DISABLE KEYS */;
INSERT INTO `iit_uc_power_package` VALUES (1,'СМЭВ',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(2,'АСТ ГОЗ',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(3,'Росреестра',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(4,'ФРДО',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(5,'АЭТП и ФЭТП|ФЭТП',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(6,'АЭТП и ФЭТП|ФЭТП',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI');
/*!40000 ALTER TABLE `iit_uc_power_package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iit_uc_rate`
--

DROP TABLE IF EXISTS `iit_uc_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iit_uc_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  `__id` int(11) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `_stock__id` int(11) DEFAULT NULL,
  `slx_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iit_uc_rate`
--

LOCK TABLES `iit_uc_rate` WRITE;
/*!40000 ALTER TABLE `iit_uc_rate` DISABLE KEYS */;
INSERT INTO `iit_uc_rate` VALUES (1,'Квалифицированный сертификат для физических лиц',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:12',36,NULL,'950.00',6,'Y6UJ9A0002C0'),(2,'Электронная подпись Базовая',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:12',30,NULL,'1900.00',1,'Y6UJ9A0000XK'),(3,'Электронная подпись для ЕГАИС',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:12',33,NULL,'1800.00',4,'Y6UJ9A0001SY'),(4,'Электронная подпись для федеральных электронных площадок (ФЭТП)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'2600.00',NULL,'Y6UJ9A0000XL'),(5,'Электронная подпись для Ассоциации электронных площадок (АЭТП)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'2900.00',NULL,'Y6UJ9A0000XM'),(6,'Электронная подпись для АЭТП и ФЭТП',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'3500.00',NULL,'Y6UJ9A0000XN'),(7,'Электронная подпись для группы площадок B2B-Center',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'2000.00',NULL,'Y6UJ9A0000XP'),(8,'Электронная подпись для Сибирской торговой площадки',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'100.00',NULL,'Y6UJ9A0000XQ'),(9,'Электронная подпись для ЭТП Газпромбанка (ГПБ)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'3500.00',NULL,'Y6UJ9A0000ZU'),(10,'Электронная подпись для портала сдачи налоговой отчетности в ФНС (налог.ру)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',32,NULL,'600.00',NULL,'Y6UJ9A0001A7'),(11,'Электронная подпись для Федеральной таможенной службы (ФТС)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',32,NULL,'2000.00',NULL,'Y6UJ9A0001A6'),(12,'Электронная подпись для реестров ЕФРСФДЮЛ и ЕФРСБ',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',35,NULL,'100.00',NULL,'Y6UJ9A0000XS'),(13,'Электронная подпись для Центра Реализации',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'1700.00',NULL,'Y6UJ9A0001PX'),(14,'Электронная подпись для Системы комплексного раскрытия информации и новостей (СКРИН)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',35,NULL,'100.00',NULL,'Y6UJ9A00029S'),(15,'Электронная подпись для агентства экономической информации ПРАЙМ',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',35,NULL,'100.00',NULL,'Y6UJ9A00029R'),(16,'Электронная подпись для Ассоциации защиты информационных прав инвесторов (АЗИПИ)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',35,NULL,'100.00',NULL,'Y6UJ9A00029Q'),(17,'Электронная подпись для Системы раскрытия информации АК&М',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',35,NULL,'100.00',NULL,'Y6UJ9A00029T'),(18,'Квалифицированный сертификат для ОФД',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:12',37,NULL,'1500.00',2,'Y6UJ9A0002EH'),(19,'Электронная подпись для Центра раскрытия корпоративной информации (Интерфакс-ЦРКИ)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',35,NULL,'100.00',NULL,'Y6UJ9A00028O'),(20,'Квалифицированный сертификат электронной подписи для СМЭВ — орган исполнительной власти',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:12',34,NULL,'1500.00',3,'Y6UJ9A0000O1'),(21,'Электронная подпись для UralBidIn',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'1700.00',NULL,'Y6UJ9A0002UU'),(22,'Электронная подпись для Tender-ug',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'1700.00',NULL,'Y6UJ9A0002TS'),(23,'Электронная подпись для АСТ ГОЗ — Организатор процедур по 223-ФЗ',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'500.00',NULL,'Y6UJ9A0002H1'),(24,'Электронная подпись для ТЭК-Торг',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'1700.00',NULL,'Y6UJ9A0001QL'),(25,'Электронная подпись для ЭТП Арбитат',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'1700.00',NULL,'Y6UJ9A0001OU'),(26,'Электронная подпись для Росреестра',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',32,NULL,'600.00',NULL,'Y6UJ9A0000XU'),(27,'Квалифицированный сертификат ИС Маркировка',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:12',38,NULL,'2000.00',5,'Y6UJ9A0002QH'),(28,'Квалифицированный сертификат электронной подписи для СМЭВ — должностное лицо',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:12',34,NULL,'1500.00',3,'Y6UJ9A0000WT'),(29,'Электронная подпись для Единой торговой площадки Республики Башкортостан',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'4500.00',NULL,'Y6UJ9A0002VS'),(30,'Квалифицированный сертификат для образовательных организаций высшего образования (ФИС ФРДО)',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',325,NULL,'100.00',NULL,'Y6UJ9A0002X5'),(31,'Квалифицированный сертификат для образовательных организаций среднего профессионального образования (ФИС ФРДО)',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',325,NULL,'100.00',NULL,'Y6UJ9A0002X5'),(32,'Квалифицированный сертификат для общеобразовательных организаций (ФИС ФРДО)',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',325,NULL,'100.00',NULL,'Y6UJ9A0002X5'),(33,'Квалифицированный сертификат для органов и организаций, в ведение которых переданы архивы организаций, выдавших документы об образовании (ФИС ФРДО)',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',325,NULL,'100.00',NULL,'Y6UJ9A0002X5'),(34,'Электронная подпись для образовательных организаций (ФРДО)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',32,NULL,'100.00',NULL,'Y6UJ9A0002X5'),(35,'Центр дистанционных торгов — Организатор торгов',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'1600.00',NULL,'Y6UJ9A00031T'),(36,'Центр дистанционных торгов — Участник торгов',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',31,NULL,'6500.00',NULL,'Y6UJ9A00031U');
/*!40000 ALTER TABLE `iit_uc_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iit_uc_section`
--

DROP TABLE IF EXISTS `iit_uc_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iit_uc_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `entity_table` varchar(256) NOT NULL,
  `__id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iit_uc_section`
--

LOCK TABLES `iit_uc_section` WRITE;
/*!40000 ALTER TABLE `iit_uc_section` DISABLE KEYS */;
INSERT INTO `iit_uc_section` VALUES (30,'Базовый',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11','iit_uc_rate',NULL),(31,'Электронные торговые площадки',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11','iit_uc_rate',NULL),(32,'Государственные порталы',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11','iit_uc_rate',NULL),(33,'ЕГАИС',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11','iit_uc_rate',NULL),(34,'СМЭВ',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11','iit_uc_rate',NULL),(35,'Порталы раскрытия информации',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11','iit_uc_rate',NULL),(36,'Для физических лиц',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11','iit_uc_rate',NULL),(37,'Для ОФД',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11','iit_uc_rate',NULL),(38,'Для ГИС Маркировка',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11','iit_uc_rate',NULL),(306,'Электронные торговые площадки',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_site',NULL),(307,'Государственные информационные системы',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_site',NULL),(308,'Сертификат для ЕГАИС',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_site',NULL),(309,'Порталы раскрытия информации',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_site',NULL),(310,'Для физических лиц',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_site',NULL),(311,'Для ОФД',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_site',NULL),(312,'Сертификат для ИС «Маркировка»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_site',NULL),(313,'Система межведомственного электронного взаимодействия (СМЭВ)',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_site',NULL),(325,'Рособрнадзор',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11','iit_uc_rate',NULL),(326,'СМЭВ',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_power',NULL),(327,'АСТ ГОЗ',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_power',NULL),(328,'Росреестра',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_power',NULL),(329,'ФРДО',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_power',NULL),(330,'АЭТП и ФЭТП|ФЭТП',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12','iit_uc_power',NULL);
/*!40000 ALTER TABLE `iit_uc_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iit_uc_service`
--

DROP TABLE IF EXISTS `iit_uc_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iit_uc_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  `slx_id` varchar(20) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iit_uc_service`
--

LOCK TABLES `iit_uc_service` WRITE;
/*!40000 ALTER TABLE `iit_uc_service` DISABLE KEYS */;
INSERT INTO `iit_uc_service` VALUES (1,'USB-ключ JaCarta LT. Сертификат ФСТЭК',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'Y6UJ9A0001OT','900.00'),(2,'USB-ключ Рутокен ЭЦП 2.0',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'Y6UJ9A0002F8','1550.00'),(3,'USB-ключ JaCarta ГОСТ',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'Y6UJ9A0000V7','1500.00'),(4,'Настройка рабочего места',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'Y6UJ9A0001FF','975.00'),(5,'Расширенная настройка рабочего места',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'Y6UJ9A0001RB','1950.00'),(6,'Срочный выпуск сертификата электронной подписи в течение 1 часа',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'Y6UJ9A0000MA','1199.00'),(7,'Срочное подключение к электронной отчётности в течение 1 часа',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'','1199.00'),(8,'Открытие дополнительного направления обмена',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'','650.00'),(9,'Внеплановый перевыпуск сертификата абонента',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'','600.00'),(10,'Детализация отчётов за месяц',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'','500.00'),(11,'Настройка рабочего места',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'','800.00'),(12,'USB-ключ JaCarta ГОСТ SE 2',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'','1800.00');
/*!40000 ALTER TABLE `iit_uc_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iit_uc_service_package`
--

DROP TABLE IF EXISTS `iit_uc_service_package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iit_uc_service_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  `select_type` enum('MONO','MULTI') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iit_uc_service_package`
--

LOCK TABLES `iit_uc_service_package` WRITE;
/*!40000 ALTER TABLE `iit_uc_service_package` DISABLE KEYS */;
INSERT INTO `iit_uc_service_package` VALUES (1,'Базовый сертификат',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(2,'ОФД',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(3,'СМЭВ',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(4,'ЕГАИС',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(5,'Маркировка',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(6,'Квал. для физ. лиц',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MULTI'),(7,'Настройка рабочего места',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,'MONO');
/*!40000 ALTER TABLE `iit_uc_service_package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iit_uc_site`
--

DROP TABLE IF EXISTS `iit_uc_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iit_uc_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iit_uc_site`
--

LOCK TABLES `iit_uc_site` WRITE;
/*!40000 ALTER TABLE `iit_uc_site` DISABLE KEYS */;
INSERT INTO `iit_uc_site` VALUES (1,'Портал государственных услуг (Госуслуги)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'gosuslugi.ru'),(2,'Федеральные ЭТП (РТС-тендер, Сбербанк-АСТ, ЕЭТП, Национальная электронная площадка, zakazrf.ru, Электронная торговая площадка АСТ ГОЗ — Участник торгов, ЭТП РАД)',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,''),(3,'Федеральные ЭТП + Электронная торговая площадка АСТ ГОЗ — Организатор процедур',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,''),(4,'ЭТП АСТ ГОЗ — Организатор процедур по 223-ФЗ',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'astgoz.ru'),(5,'Ассоциация ЭТП (включая группу площадок В2В, uTender)',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,''),(6,'Федеральные ЭТП + Ассоциация ЭТП (включая группу площадок В2В, uTender, ЭТП ETPRF)',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,''),(7,'ЭТП uTender',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'utender.ru'),(8,'Группа площадок B2B',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'b2b-center.ru'),(9,'Сибирская торговая площадка',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'sibtoptrade.ru'),(10,'ЭТП ГПБ',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp.gpb.ru'),(11,'Электронная торговая площадка «Центр Реализации»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'centerr.ru'),(12,'Электронная торговая площадка «ТЭК-Торг»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'tektorg.ru'),(13,'Портал Росалкогольрегулирования',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'fsrar.ru'),(14,'Портал для сдачи отчетности (ФСС, Росстат)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'f4.fss.ru'),(15,'Портал ФГУП «Главный радиочастотный центр»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'grfc.ru'),(16,'Роспатент ФГБУ ФИПС',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'fips.ru'),(17,'Государственная информационная система в области энергосбережения и повышения энергетической эффективности',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'gisee.ru'),(18,'Росфинмониторинг (Федеральная служба по финансовому мониторингу)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'fedsfm.ru'),(19,'Единая система обмена данными с участниками финансового рынка',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'portal4.cbr.ru'),(20,'ФГИС Росаккредитации',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'fsa.gov.ru'),(21,'ФГИС территориального планирования',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'fgis.economy.gov.ru'),(22,'Портал Росприроднадзора',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'rpn.gov.ru'),(23,'Торговая Система «ГазНефтеторг.ру»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'gazneftetorg.ru'),(24,'Электронная площадка «ВТБ Центр»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'vtb-center.ru'),(25,'Группа электронных площадок OTC.RU',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,''),(26,'Центр дистанционных торгов — Участник торгов',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'cdtrf.ru'),(27,'Электронная торговая площадка УГМК',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'zakupki.ugmk.com'),(28,'Биржа «Санкт-Петербург»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'spbex.ru'),(29,'Автоматизированная система электронных закупок (АСЭЗ) Газпрома',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'zakupki.gazprom.ru'),(30,'Электронная торговая площадка «Элтокс»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'eltox.ru'),(31,'Торговая Система «ОБОРОНТОРГ»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'oborontorg.ru'),(32,'Электронная площадка Администрации города Красноярск',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'torgi.admkrsk.ru'),(33,'Универсальная электронная торговая площадка ESTP.RU',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'estp.ru'),(34,'Электронная торговая площадка ОАО «Россети»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp.rosseti.ru'),(35,'Торговая Система «Спецстройторг»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'sstorg.ru'),(36,'Официальный сайт Единой информационной системы в сфере закупок',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',307,'zakupki.gov.ru'),(37,'Портал Территориального органа Федеральной службы государственной статистики по Республике Башкортостан',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',307,'sbor.bashstat.ru/online'),(38,'Роскомнадзор. Единый реестр доменных имен, указателей страниц сайтов в сети «Интернет» и сетевых адресов, позволяющих идентифицировать сайты в сети «Интернет», содержащие информацию, распространение которой в Российской Федерации запрещено',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',307,'eais.rkn.gov.ru'),(39,'Роскомнадзор. Реестр доменных имен, указателей страниц сайтов в сети «Интернет» и сетевых адресов, позволяющих идентифицировать сайты в сети «Интернет», содержащие информацию, распространяемую с нарушением исключительных прав',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'nap.rkn.gov.ru/tooperators'),(40,'Росимущество. Межведомственный портал по управлению государственной собственностью',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'mvpt.rosim.ru'),(41,'Вестник государственной регистрации',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'vestnik-gosreg.ru'),(42,'ИС Росминтруда «Автоматизированная система анализа и контроля в области охраны труда (АС АКОТ)»',NULL,'N',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',307,'akot.rosmintrud.ru'),(43,'Портал Московского городского суда по защите интеллектуальных прав',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'lk.mos-gorsud.ru'),(44,'Государственная информационная система жилищно-коммунального хозяйства (ГИС ЖКХ)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'dom.gosuslugi.ru'),(45,'Портал «Коммерсант Картотека»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'kartoteka.ru'),(46,'Портал государственных программ Российской Федерации',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'programs.gov.ru/Portal'),(47,'Электронная торговая площадка «МФБ»',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp.mse.ru'),(48,'СМЭВ ОИВ',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',313,''),(49,'Портал городских услуг г. Москва',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'pgu.mos.ru'),(50,'Официальный сайт Российской Федерации о размещении информации о проведении торгов',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'torgi.gov.ru'),(51,'ЕГАИС «Учет древесины и сделок с ней»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'lesegais.ru'),(52,'Портал Федеральной нотариальной палаты для подачи сведений от органов местного самоуправления',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'fciit.ru'),(53,'Федеральная информационная адресная система (ФИАС)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'fias.nalog.ru'),(54,'Личный кабинет пользователя федеральной информационной адресной системы',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'fiasmo.nalog.ru'),(55,'Система приема обязательных экземпляров печатных изданий в электронной форме',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'oek.rsl.ru'),(56,'Система подачи документов в арбитражные суды в электронном виде «Мой Арбитр»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'my.arbitr.ru'),(57,'Единая государственная информационная система в сфере здравоохранения (ЕГИСЗ)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'nr.egisz.rosminzdrav.ru'),(58,'Портал сдачи в Минкомсвязи статистической отчетности операторов связи',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',307,'statreport.ru '),(59,'Федеральная государственная информационная система ценообразования в строительстве (ФГИС ЦС)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'fgiscs.minstroyrf.ru'),(60,'Автоматизированная система  «Меркурий»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'mercury.vetrf.ru'),(61,'ИС «Электронная путевка»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'test-evoucher.russiatourism.ru'),(62,'Информационно-аналитическая система «Держава Онлайн» (предоставление банковских гарантий и других кредитных продуктов)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'derzhava.online'),(63,'Тендертех (финансовые продукты онлайн для участников госзакупок по 44-ФЗ/223-ФЗ/185-ФЗ)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'tendertech.ru'),(64,'Сбербанк-АСТ (Электронная площадка Сберегательного банка Российской федерации)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'sberbank-ast.ru'),(65,'Национальная электронная площадка',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'etp-ets.ru'),(66,'Электронная торговая площадка РТС-тендер',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'rts-tender.ru'),(67,'ГУП «Агентство по государственному заказу, инвестиционной деятельности и межрегиональным связям Республики Татарстан»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'zakazrf.ru'),(68,'Единая электронная торговая площадка',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'roseltorg.ru'),(69,'Торговый портал «Фабрикант»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'fabrikant.ru'),(70,'Электронная торговая площадка ETPRF',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etprf.ru'),(71,'Группа площадок NAUMEN',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'naumen.ru'),(72,'Государственный заказ Республики Алтай',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'zakupki-altai.ru'),(73,'Государственный заказ Республики Бурятия',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'burzakup.ru'),(74,'Государственный заказ Вологодской области',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'gz.gov35.ru'),(75,'Государственный заказ Камчатского края',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'zakaz.kamchatka.gov.ru'),(76,'Государственный заказ Нижегородской области',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'goszakaz.nnov.ru'),(77,'Государственные и муниципальные закупки Омской области',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'omskzakaz.ru'),(78,'Государственный заказ Республики Татарстан',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'agzrt.ru'),(79,'Государственный заказ Республики Хакасия',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'zakaz.r-19.ru'),(80,'Государственный заказ Челябинской области',NULL,'N',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'chelgumr.ru'),(81,'Сбербанк-АСТ. Закупки и продажи для коммерческих заказчиков',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'utp.sberbank-ast.ru/Com/'),(82,'Сбербанк-АСТ. Торги для коммерческих заказчиков',NULL,'N',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'trade.sberbank-ast.ru'),(83,'Сбербанк-АСТ. Закупки OAO «Сбербанк России»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'sb.sberbank-ast.ru'),(84,'Аукционный Конкурсный Дом',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'a-k-d.ru'),(85,'Электронная торговая площадка «Байкал-Тендер»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'torgi.burzakup.ru'),(86,'Электронная торговая площадка «ИнвестЭнергосервис»',NULL,'N',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'ieservice.ru'),(87,'ТЗС «Электра»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'tzselektra.ru'),(88,'RB2B ООО «Закупочные и маркетинговые системы»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'rb2b.ru'),(89,'SETonline — многофункциональная система электронной торговли',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'setonline.ru'),(90,'Электронная торговая площадка BashZakaz.ru',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp.bashzakaz.ru'),(91,'Торгово закупочная система «АМС-Сервис»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'amstzs.ru'),(92,'Сеть региональных Электронных Торговых Площадок',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'urfotender.ru'),(93,'ЭТП «КамТендер»',NULL,'N',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'etp-kamtender.ru'),(94,'Уральская Электронная Торговая Площадка',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'etpu.ru'),(95,'Закупочный модуль ZakazRF 223',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'223etp.zakazrf.ru'),(96,'ЭТП СВФУ (Северо-Восточный федеральный университет)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp.s-vfu.ru'),(97,'Электронная торговая площадка «Тендер»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp-tender.ru'),(98,'Электронная торговая площадка 24tender.ru',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,''),(99,'Электронная торговая площадка Sakhaeltorg.ru',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'sakhaeltorg.ru'),(100,'Сбербанк-АСТ. Продажа имущества банкротов',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'bankruptcy.sberbank-ast.ru'),(101,'Электронная площадка «Аукционный тендерный центр»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'atctrade.ru'),(102,'ООО «Балтийская электронная площадка»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'bepspb.ru'),(103,'Межрегиональная Электронная Торговая Система «МЭТС»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'m-ets.ru'),(104,'ЗАО «РУССИА Онлайн»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'rus-on.ru'),(105,'ЭТП «Система электронных торгов имуществом»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'seltim.ru'),(106,'Электронная площадка «Аукционы Сибири»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'ausib.ru'),(107,'Электронная торговая площадка ELECTRO-TORGI.RU',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'http://electro-torgi.ru/'),(108,'Электронная торговая площадка «А-КОСТА»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'akosta.info'),(109,'ЭТП «Аукцион-центр»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'aukcioncenter.ru'),(110,'Электронная торговая площадка «Электронный капитал»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'eksystems.ru'),(111,'Электронная торговая площадка «Профит»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'etp-profit.ru'),(112,'Система электронных торгов ОАО «НПК «УРАЛВАГОНЗАВОД»',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'http://www.b2b-uvz.ru/ '),(113,'Электронная торговая площадка «Альфалот»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'alfalot.ru'),(114,'Электронная торговая площадка «ТендерСтандарт»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'tenderstandart.ru'),(115,'Электронная торговая площадка «Аукционы Дальнего Востока»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'torgidv.ru/index.html'),(116,'Электронная торговая площадка «ЭТС24»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'ets24.ru'),(117,'Электронная торговая площадка «Коммерсантъ КАРТОТЕКА»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp.kartoteka.ru/index.html'),(118,'Электронная площадка «Владимирский Тендерный Центр»',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'vtc33.ru'),(119,'Всероссийская Электронная Торговая Площадка',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'торговая-площадка-вэтп.рф'),(120,'Электронная торговая площадка «Новые Информационные Сервисы»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'nistp.ru'),(121,'Электронная торговая площадка «Агентство Правовых Коммуникаций»',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'apktorgi.ru'),(122,'Электронная торговая площадка E-TENDER',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'e-tender.info'),(123,'Электронная торговая площадка «Ру-Трейд»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'ru-trade24.ru'),(124,'Электронная торговая площадка «ПРОМ-Консалтинг»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'promkonsalt.ru'),(125,'Портал поставщиков Правительства Москвы',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'market.zakupki.mos.ru'),(126,'ЭТП «Объединенная Торговая Площадка»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'utpl.ru'),(127,'Электронная торговая площадка «223»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'etp223.ru'),(128,'Электронная площадка «АИСТ»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'aistorg.ru'),(129,'Электронная торговая площадка «СЭТАЙМ»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'setaim.ru'),(130,'Региональная торговая площадка',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'regtorg.com'),(131,'ЭТП «Центр развития электронных торгов»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'torgi223.ru'),(132,'Oфициальный сайт по государственным закупкам Республики Беларусь',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'icetrade.by '),(133,'ЭТП ОАО «Белорусская универсальная товарная биржа»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'zakupki.butb.by'),(134,'ЭТП «Национальный центр маркетинга и конъюнктуры цен»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'goszakupki.by'),(135,'ЭТП ГУП «Москоллектор»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp.moscollector.ru'),(136,'Прочие ЭТП',NULL,'N',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,''),(137,'ЭТП «Югра»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etpugra.ru'),(138,'Крымская электронная торговая площадка',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'torgi82.ru'),(139,'Евразийская торговая площадка',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'eurtp.ru'),(140,'EL-TORG аукционы и закупки',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'el-torg.ru'),(141,'Торгово-закупочная система RHtorg.com',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'rhtorg.com'),(142,'Электронная площадка REGION-AST',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'region-ast.center'),(143,'Электронная торговая площадка ООО «Автодор-ТП»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp-avtodor.ru'),(144,'Электронная торговая система «Торговъ»',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'торговъ.рф'),(145,'Электронная торговая площадка PropertyTrade',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'propertytrade.ru'),(146,'Электронная торговая площадка «СтройТорги»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'stroytorgi.ru'),(147,'Электронная торговая площадка «Тендер Гарант»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'tendergarant.com'),(148,'Электронная торговая площадка X-SOLD',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp.xsold.ru'),(150,'Электронная торговая площадка ЗАО «Сибирская Аграрная Группа»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'agro.zakupki.tomsk.ru'),(151,'ЭТП АСТ ГОЗ — Поставщик',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'astgoz.ru'),(152,'Электронная торговая площадка «Федерация»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'federal1.ru'),(153,'Электронная торговая площадка «Элторг»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'eltorg.org'),(154,'Электронная торговая площадка «Отраслевая система торгов»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'ostsn.ru'),(155,'ЭТП «Мета-Инвест»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'meta-invest.ru'),(156,'Электронная торговая площадка ГК «Росатом»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'atom2.roseltorg.ru'),(157,'Управление муниципальных закупок администрации городского округа город Воронеж',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'umz-vrn.etc.ru'),(158,'ЭТП Системы ЭЛектронных Торгов',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'selt-online.ru'),(159,'ЭТП НПО «Верхневолжский торговый союз»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'npovts.ru'),(160,'ЭТП ТЭК-Торг секция ПАО «НК «Роснефть»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'rn.tektorg.ru'),(161,'Электронная торговая площадка Российского аукционного дома (по 44-ФЗ)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'gz.lot-online.ru'),(162,'Электронная торговая площадка Российского аукционного дома (кроме торгов по 44-ФЗ)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'www.lot-online.ru'),(163,'Сбербанк-АСТ. Приватизация, аренда и продажа прав.',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'utp.sberbank-ast.ru/AP/NBT/Index/0/0/0/0'),(164,'Электронная торговая площадка «Регион»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'gloriaservice.ru'),(165,'Электронная площадка FINTENDER.RU',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'fintender.ru'),(166,'Южная ЭТП',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'torgibankrot.ru'),(167,'Электронная торговая площадка «Арбитат»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'arbitat.ru'),(168,'Электронная торговая площадка «Национальная электронная биржа»',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'neb24.ru'),(169,'Электронная торговая площадка «Tender-ug»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'tender-ug.ru'),(170,'Электронная торговая площадка «UralBidIn»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'uralbidin.ru'),(171,'Система электронного документооборота',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',313,''),(172,'СМЭВ ДЛ ОИВ',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',313,''),(173,'Единая государственная автоматизированная информационная система учета объема производства и оборота этилового спирта, алкогольной и спиртосодержащей продукции',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',308,'egais.ru'),(174,'ЕФРСФДЮЛ',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',309,'fedresurs.ru'),(175,'ЕФРСБ',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',309,'bankrot.fedresurs.ru'),(176,'Система раскрытия информации АК&М',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',309,'www.disclosure.ru'),(177,'АЗИПИ (Ассоциация защиты информационных прав инвесторов)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',309,'e-disclosure.azipi.ru'),(178,'Агентство экономической информации ПРАЙМ',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',309,'disclosure.1prime.ru'),(179,'СКРИН (АО «Система комплексного раскрытия информации и новостей»)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',309,'disclosure.skrin.ru'),(180,'Квалифицированный сертификат для физических лиц',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',310,''),(181,'Оператор фискальных данных (ОФД) Ярус',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',311,'ofd-ya.ru'),(182,'Квалифицированный сертификат для ОФД',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',311,''),(183,'Первый ОФД',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',311,'1-ofd.ru'),(184,'Такском ОФД',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',311,'taxcom.ru'),(185,'Платформа ОФД',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',311,'platformaofd.ru'),(186,'ПЕТЕР-СЕРВИС',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',311,'www.ofd.ru'),(187,'Информационный ресурс маркировки лекарственных препаратов',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',312,'markirovka.nalog.ru'),(188,'Единый федеральный реестр сведений о фактах деятельности юридических лиц (ЕФРСФДЮЛ); Единый федеральный ресурс сведений о банкротстве (ЕФРСБ)',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',309,'fedresurs.ru, bankrot.fedresurs.ru'),(189,'Центр раскрытия корпоративной информации (Интерфакс-ЦРКИ)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',309,'e-disclosure.ru'),(190,'Портал Росреестра',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'rosreestr.ru/wps/portal'),(191,'ФГИС «Единая информационно-аналитическая система ФСТ-РЭК — субъекты регулирования»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'eias.ru'),(192,'Федеральная таможенная служба',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'customs.ru'),(193,'Портал сдачи налоговой отчетности',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'service.nalog.ru/nbo'),(194,'Башфин',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,''),(195,'РИКС',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,''),(196,'Башфин + РИКС',NULL,'N',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,''),(197,'Автоматизированная система электронных паспортов транспортных средств (ПТС)',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',307,'elpts.ru'),(198,'ЭТП Единая торговая площадка Республики Башкортостан',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',306,'etprb.ru'),(199,'Универсальная электронная торговая площадка ОАО «РЖД»',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'etp.comita.ru'),(200,'Электронные системы Поволжья',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'el-torg.com'),(201,'Единая общероссийская справочно-информационная система по охране труда АС АКОТ',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',307,'akot.rosmintrud.ru'),(202,'Центр дистанционных торгов — Организатор торгов',NULL,'Y',NULL,'2018-12-29 14:43:11','2018-12-29 14:43:11',306,'cdtrf.ru');
/*!40000 ALTER TABLE `iit_uc_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iit_uc_stock`
--

DROP TABLE IF EXISTS `iit_uc_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iit_uc_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `client_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iit_uc_stock`
--

LOCK TABLES `iit_uc_stock` WRITE;
/*!40000 ALTER TABLE `iit_uc_stock` DISABLE KEYS */;
INSERT INTO `iit_uc_stock` VALUES (1,'Базовый сертификат',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,15,'[\'UR\',\'IP\',\'FIZ\']'),(2,'ОФД',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,42,'[\'UR\',\'IP\']'),(3,'СМЭВ',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,22,'[\'UR\']'),(4,'ЕГАИС',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,25,'[\'UR\',\'IP\']'),(5,'Маркировка',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,92,'[\'UR\',\'IP\']'),(6,'Квал. для физ. лиц',NULL,'Y',NULL,'2018-12-29 14:43:12','2018-12-29 14:43:12',NULL,39,'[\'FIZ\']');
/*!40000 ALTER TABLE `iit_uc_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ip_black_list`
--

DROP TABLE IF EXISTS `ip_black_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ip_black_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ip_black_list`
--

LOCK TABLES `ip_black_list` WRITE;
/*!40000 ALTER TABLE `ip_black_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ip_black_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1539786475),('m180921_101322_init_entity_table',1539786477),('m180921_134812_init_section_table',1539786477),('m180921_140529_init_page_table',1539786477),('m181016_105648_init_entity_without_section',1539786477),('m181025_065406_init_file_table',1540451132),('m181102_085516_create_agent_table',1541759024),('m181102_085531_create_region_table',1541759025),('m181102_085600_create_settlement_table',1541759025),('m181112_145128_init_user_table',1542034462),('m181126_071444_init_ip_black_list_table',1543216659),('m181212_124233_create_binder_table',1544618759),('m181225_130400_create_rate_table',1545808472),('m181225_130459_create_site_table',1545808472),('m181225_130511_create_service_table',1545808472),('m181225_130533_create_power_table',1545808472),('m181225_130555_create_service_package_table',1545808472),('m181225_130606_create_section_table',1545808472),('m181225_130612_create_binder_table',1545808472),('m181225_131624_create_stock_table',1545808472),('m181228_105929_create_power_package_table',1545994870);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preview_text` text,
  `detail_text` text,
  `preview_img` text,
  `detail_img` text,
  `title` text,
  `keywords` text,
  `description` text,
  `item_table` varchar(256) NOT NULL,
  `__id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  `str_nmb` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `entity_table` varchar(256) NOT NULL,
  `__id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section`
--

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settlement`
--

DROP TABLE IF EXISTS `settlement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settlement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_date_time` datetime DEFAULT NULL,
  `change_date_time` datetime DEFAULT NULL,
  `_section__id` int(11) DEFAULT NULL,
  `str_nmb` char(2) DEFAULT NULL,
  `type` enum('NOT_DEFINED','GOROD','STANICA','SELO','XUTOR','POS','PGT') NOT NULL,
  `_region__id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settlement`
--

LOCK TABLES `settlement` WRITE;
/*!40000 ALTER TABLE `settlement` DISABLE KEYS */;
/*!40000 ALTER TABLE `settlement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-29 15:02:16
