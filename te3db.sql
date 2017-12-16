CREATE DATABASE  IF NOT EXISTS `te3db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `te3db`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: te3db
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.28-MariaDB

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
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `fileID` int(11) NOT NULL AUTO_INCREMENT,
  `tpID` int(11) NOT NULL,
  `tpFileName` varchar(50) NOT NULL,
  `tpModified` date DEFAULT NULL,
  PRIMARY KEY (`fileID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,2,'4p1h.sql','2017-08-22'),(2,3,'CSETHIC.docx','2017-11-28'),(3,1,'SofenggX22A_SRS_Bictory.pdf','2017-11-18');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `memberID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (0,2,7),(1,2,4),(2,3,4),(3,4,6),(4,4,10),(5,4,12),(6,1,2),(7,2,3),(8,3,3),(9,4,8);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tptable`
--

DROP TABLE IF EXISTS `tptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tptable` (
  `tpID` int(11) NOT NULL AUTO_INCREMENT,
  `tpTitle` varchar(99) NOT NULL,
  `tpDesc` varchar(10000) NOT NULL,
  `tpSDate` date NOT NULL,
  `tpEDate` date DEFAULT NULL,
  `tpAccessLVL` int(11) NOT NULL,
  `pHead` varchar(50) DEFAULT NULL,
  `pVentureC` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tpID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tptable`
--

LOCK TABLES `tptable` WRITE;
/*!40000 ALTER TABLE `tptable` DISABLE KEYS */;
INSERT INTO `tptable` VALUES (1,'BICTORY SRS SOFENGG','A software requirements specification (SRS) is a description of a software system to be developed. It lays out functional and non-functional requirements, and may include a set of use cases that describe user interactions that the software must provide.\r\n\r\nSoftware requirements specification establishes the basis for an agreement between customers and contractors or suppliers (in market-driven projects, these roles may be played by the marketing and development divisions) on what the software product is to do as well as what it is not expected to do. Software requirements specification permits a rigorous assessment of requirements before design can begin and reduces later redesign. It should also provide a realistic basis for estimating product costs, risks, and schedules. Used appropriately, software requirements specifications can help prevent software project failure.','2017-01-01','2017-11-29',1,'2','Christine Gendrano'),(2,'4 Pics 1 Hung (WEBAPDE)','A web application which is a crossover of 4 pics 1 word and hangman. Developed for WEBAPDE X22 under Arturo Caronongan.','2017-08-22','2017-09-15',1,'7','Arturo Caronongan'),(3,'CSETHIC Intellectual Property Paper','A paper on issues that shows unethical practices when it comes to patents, copyrights, and the like','2017-11-27','2017-11-28',1,'3','Edmund Gerald Cruz'),(4,'ADVANDB Query Optimization','A simple query application that issues queries to the Yelp database. The application displays an interface for selecting the query to be executed and viewing the query results.','2017-11-28','2017-11-29',1,'8','Christine Gendrano');
/*!40000 ALTER TABLE `tptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uName` varchar(45) NOT NULL,
  `uPass` varchar(15) NOT NULL,
  `uID` int(11) NOT NULL AUTO_INCREMENT,
  `uType` int(11) NOT NULL,
  `uFName` varchar(45) NOT NULL,
  `uLName` varchar(45) NOT NULL,
  `uGender` varchar(10) NOT NULL,
  `uOccupation` varchar(30) NOT NULL,
  `uAffiliation` varchar(50) NOT NULL,
  `uActive` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('michael_noble@dlsu.edu.ph','bungalow',1,0,'Michael Neil','Noble','Male','Project Manager','Bictory',1),('rafael_tanchuan@dlsu.edu.ph','bungalow',2,1,'Rafael Louis','Tanchuan','Male','Business Analyst','Bictory',1),('edmund_cruz@dlsu.edu.ph','bungalow',3,1,'Edmund Gerald','Cruz','Male','Business Analyst','Bictory',1),('arlan_gomez@dlsu.edu.ph','bungalow',4,0,'Arlan Ross','Gomez','Male','Quality Assurance','Bictory',1),('klaudia_borromeo@dlsu.edu.ph','bungalow',5,0,'Klaudia Gaia','Borromeo','Female','Quality Assurance','Bictory',1),('joesei_castro@dlsu.edu.ph','bungalow',6,0,'Joesei Jesus','Castro','Male','Developer','Bictory',1),('aron_tan@dlsu.edu.ph','bungalow',7,1,'Aron Joshua','Tan','Male','Developer','Bictory',1),('sam_marquez@dlsu.edu.ph','bungalow',8,1,'Sam','Marquez','Male','Developer','Bictory',1),('jan_lagayan@dlsu.edu.ph','bungalow',9,1,'Jan Alysa','Lagayan','Female','Developer','Bictory',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-16 15:21:05
