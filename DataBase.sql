-- MariaDB dump 10.19  Distrib 10.11.2-MariaDB, for osx10.17 (arm64)
--
-- Host: localhost    Database: college_databse
-- ------------------------------------------------------
-- Server version	10.11.2-MariaDB

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
-- Table structure for table `CompoGroupes`
--

DROP TABLE IF EXISTS `CompoGroupes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CompoGroupes` (
                                `IdEleve` varchar(10) NOT NULL,
                                `IdGrp` varchar(10) NOT NULL,
                                PRIMARY KEY (`IdEleve`,`IdGrp`),
                                KEY `IdGrp` (`IdGrp`),
                                CONSTRAINT `compogroupes_ibfk_1` FOREIGN KEY (`IdEleve`) REFERENCES `Eleves` (`IdEleve`),
                                CONSTRAINT `compogroupes_ibfk_2` FOREIGN KEY (`IdGrp`) REFERENCES `Groupes` (`IdGrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CompoGroupes`
--

LOCK TABLES `CompoGroupes` WRITE;
/*!40000 ALTER TABLE `CompoGroupes` DISABLE KEYS */;
/*!40000 ALTER TABLE `CompoGroupes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ContraintesEns`
--

DROP TABLE IF EXISTS `ContraintesEns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContraintesEns` (
                                  `IdEns` varchar(10) NOT NULL CHECK (`IdEns` like 'ENS%'),
                                  `Horaire` char(4) NOT NULL CHECK (`Horaire` like '[A-Z]{3}[1-9]'),
                                  `Prio` int(11) DEFAULT NULL CHECK (`Prio` in ('1','2','3')),
                                  PRIMARY KEY (`IdEns`,`Horaire`),
                                  KEY `Horaire` (`Horaire`),
                                  CONSTRAINT `contraintesens_ibfk_1` FOREIGN KEY (`IdEns`) REFERENCES `Enseignements` (`IdEns`),
                                  CONSTRAINT `contraintesens_ibfk_2` FOREIGN KEY (`Horaire`) REFERENCES `Horaires` (`Horaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ContraintesEns`
--

LOCK TABLES `ContraintesEns` WRITE;
/*!40000 ALTER TABLE `ContraintesEns` DISABLE KEYS */;
/*!40000 ALTER TABLE `ContraintesEns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ContraintesProf`
--

DROP TABLE IF EXISTS `ContraintesProf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContraintesProf` (
                                   `IdProf` varchar(10) NOT NULL CHECK (`IdProf` like 'PRF%'),
                                   `Horaire` char(4) NOT NULL CHECK (`Horaire` like '[A-Z]{3}[1-9]'),
                                   `Prio` int(11) DEFAULT NULL CHECK (`Prio` in ('1','2','3')),
                                   PRIMARY KEY (`IdProf`,`Horaire`),
                                   KEY `Horaire` (`Horaire`),
                                   CONSTRAINT `contraintesprof_ibfk_1` FOREIGN KEY (`IdProf`) REFERENCES `Enseignants` (`IdProf`),
                                   CONSTRAINT `contraintesprof_ibfk_2` FOREIGN KEY (`Horaire`) REFERENCES `Horaires` (`Horaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ContraintesProf`
--

LOCK TABLES `ContraintesProf` WRITE;
/*!40000 ALTER TABLE `ContraintesProf` DISABLE KEYS */;
/*!40000 ALTER TABLE `ContraintesProf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ContraintesSalles`
--

DROP TABLE IF EXISTS `ContraintesSalles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContraintesSalles` (
                                     `TypeSalle` varchar(15) NOT NULL,
                                     `IdCours` varchar(10) NOT NULL CHECK (`IdCours` like 'CR%'),
                                     `VolHSalle` decimal(3,2) NOT NULL,
                                     `DureeMinSalle` int(11) NOT NULL DEFAULT 1,
                                     PRIMARY KEY (`TypeSalle`,`IdCours`),
                                     KEY `IdCours` (`IdCours`),
                                     CONSTRAINT `contraintessalles_ibfk_1` FOREIGN KEY (`TypeSalle`) REFERENCES `TypesSalles` (`TypeSalle`),
                                     CONSTRAINT `contraintessalles_ibfk_2` FOREIGN KEY (`IdCours`) REFERENCES `Cours` (`IdCours`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ContraintesSalles`
--

LOCK TABLES `ContraintesSalles` WRITE;
/*!40000 ALTER TABLE `ContraintesSalles` DISABLE KEYS */;
/*!40000 ALTER TABLE `ContraintesSalles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Cours`
--

DROP TABLE IF EXISTS `Cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cours` (
                         `IdCours` varchar(10) NOT NULL CHECK (`IdCours` like 'CR%'),
                         `IdEns` varchar(10) DEFAULT NULL CHECK (`IdEns` like 'ENS%'),
                         `IdProf` varchar(10) DEFAULT NULL CHECK (`IdProf` like 'PRF%'),
                         `IdDiv` varchar(10) DEFAULT NULL CHECK (`IdDiv` like 'DIV%'),
                         `IdGrp` varchar(10) DEFAULT NULL CHECK (`IdGrp` like 'GRP%'),
                         PRIMARY KEY (`IdCours`),
                         KEY `IdProf` (`IdProf`,`IdEns`),
                         KEY `IdDiv` (`IdDiv`),
                         KEY `IdGrp` (`IdGrp`),
                         CONSTRAINT `cours_ibfk_1` FOREIGN KEY (`IdProf`, `IdEns`) REFERENCES `Enseigne` (`IdProf`, `IdEns`),
                         CONSTRAINT `cours_ibfk_2` FOREIGN KEY (`IdDiv`) REFERENCES `Divisions` (`IdDiv`),
                         CONSTRAINT `cours_ibfk_3` FOREIGN KEY (`IdGrp`) REFERENCES `Groupes` (`IdGrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cours`
--

LOCK TABLES `Cours` WRITE;
/*!40000 ALTER TABLE `Cours` DISABLE KEYS */;
/*!40000 ALTER TABLE `Cours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Directeurs`
--

DROP TABLE IF EXISTS `Directeurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Directeurs` (
                              `IdDir` varchar(10) NOT NULL CHECK (`IdDir` like 'DIR%'),
                              `NomDir` varchar(15) NOT NULL,
                              `PrenomDir` varchar(15) NOT NULL,
                              `MdpDir` text DEFAULT NULL,
                              `MailDir` varchar(40) DEFAULT NULL,
                              PRIMARY KEY (`IdDir`),
                              UNIQUE KEY `MailDir` (`MailDir`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Directeurs`
--

LOCK TABLES `Directeurs` WRITE;
/*!40000 ALTER TABLE `Directeurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `Directeurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Divisions`
--

DROP TABLE IF EXISTS `Divisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Divisions` (
                             `IdDiv` varchar(10) NOT NULL CHECK (`IdDiv` like 'DIV%'),
                             `LibelleDiv` varchar(10) NOT NULL,
                             `NiveauDiv` char(4) DEFAULT NULL CHECK (`NiveauDiv` in ('6EME','5EME','4EME','3EME')),
                             `EffectifPrevDiv` int(11) NOT NULL DEFAULT 35,
                             PRIMARY KEY (`IdDiv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Divisions`
--

LOCK TABLES `Divisions` WRITE;
/*!40000 ALTER TABLE `Divisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `Divisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Eleves`
--

DROP TABLE IF EXISTS `Eleves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Eleves` (
                          `IdEleve` varchar(10) NOT NULL CHECK (`IdEleve` like 'ELV%'),
                          `NomEleve` varchar(15) NOT NULL,
                          `PrenomEleve` varchar(15) NOT NULL,
                          `MdpEleve` text DEFAULT NULL,
                          `AnneeNaisEleve` decimal(4,0) DEFAULT NULL CHECK (`AnneeNaisEleve` > 2000 and `AnneeNaisEleve` < 2100),
                          `NiveauEleve` varchar(4) DEFAULT NULL CHECK (`NiveauEleve` like '%EME'),
                          `IdDiv` varchar(10) DEFAULT NULL CHECK (`IdDiv` like 'DIV%'),
                          PRIMARY KEY (`IdEleve`),
                          KEY `IdDiv` (`IdDiv`),
                          CONSTRAINT `eleves_ibfk_1` FOREIGN KEY (`IdDiv`) REFERENCES `Divisions` (`IdDiv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Eleves`
--

LOCK TABLES `Eleves` WRITE;
/*!40000 ALTER TABLE `Eleves` DISABLE KEYS */;
/*!40000 ALTER TABLE `Eleves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Enseignants`
--

DROP TABLE IF EXISTS `Enseignants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Enseignants` (
                               `IdProf` varchar(10) NOT NULL CHECK (`IdProf` like 'PRF%'),
                               `NomProf` varchar(15) NOT NULL,
                               `PrenomProf` varchar(15) NOT NULL,
                               `MdpProf` text DEFAULT NULL,
                               `MailProf` varchar(40) DEFAULT NULL CHECK (`MailProf` like '%@college-vh.com'),
                               `VolHProf` decimal(3,1) NOT NULL,
                               PRIMARY KEY (`IdProf`),
                               UNIQUE KEY `MailProf` (`MailProf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Enseignants`
--

LOCK TABLES `Enseignants` WRITE;
/*!40000 ALTER TABLE `Enseignants` DISABLE KEYS */;
/*!40000 ALTER TABLE `Enseignants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Enseigne`
--

DROP TABLE IF EXISTS `Enseigne`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Enseigne` (
                            `IdProf` varchar(10) NOT NULL CHECK (`IdProf` like 'PRF%'),
                            `IdEns` varchar(10) NOT NULL CHECK (`IdEns` like 'ENS%'),
                            PRIMARY KEY (`IdProf`,`IdEns`),
                            KEY `IdEns` (`IdEns`),
                            CONSTRAINT `enseigne_ibfk_1` FOREIGN KEY (`IdProf`) REFERENCES `Enseignants` (`IdProf`),
                            CONSTRAINT `enseigne_ibfk_2` FOREIGN KEY (`IdEns`) REFERENCES `Enseignements` (`IdEns`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Enseigne`
--

LOCK TABLES `Enseigne` WRITE;
/*!40000 ALTER TABLE `Enseigne` DISABLE KEYS */;
/*!40000 ALTER TABLE `Enseigne` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Enseignements`
--

DROP TABLE IF EXISTS `Enseignements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Enseignements` (
                                 `IdEns` varchar(10) NOT NULL CHECK (`IdEns` like 'ENS%'),
                                 `LibelleEns` varchar(40) NOT NULL,
                                 `NiveauEns` char(4) DEFAULT NULL CHECK (`NiveauEns` in ('6EME','5EME','4EME','3EME')),
                                 `VolHEns` decimal(3,1) NOT NULL,
                                 `OptionEns` tinyint(1) NOT NULL DEFAULT 0,
                                 PRIMARY KEY (`IdEns`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Enseignements`
--

LOCK TABLES `Enseignements` WRITE;
/*!40000 ALTER TABLE `Enseignements` DISABLE KEYS */;
/*!40000 ALTER TABLE `Enseignements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Groupes`
--

DROP TABLE IF EXISTS `Groupes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Groupes` (
                           `IdGrp` varchar(10) NOT NULL CHECK (`IdGrp` like 'GRP%'),
                           `LibelleGrp` varchar(40) NOT NULL,
                           `NiveauGrp` varchar(4) NOT NULL CHECK (`NiveauGrp` in ('6EME','5EME','4EME','3EME')),
                           `EffectifPrevGrp` int(11) NOT NULL DEFAULT 35,
                           PRIMARY KEY (`IdGrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Groupes`
--

LOCK TABLES `Groupes` WRITE;
/*!40000 ALTER TABLE `Groupes` DISABLE KEYS */;
/*!40000 ALTER TABLE `Groupes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Horaires`
--

DROP TABLE IF EXISTS `Horaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Horaires` (
                            `Horaire` char(4) NOT NULL CHECK (`Horaire` like '[A-Z]{3}[1-9]'),
                            `Jour` varchar(10) DEFAULT NULL CHECK (`Jour` in ('lundi','mardi','mercredi','jeudi','vendredi','samedi')),
                            `HeureDebut` time NOT NULL,
                            `HeureFin` time NOT NULL,
                            PRIMARY KEY (`Horaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Horaires`
--

LOCK TABLES `Horaires` WRITE;
/*!40000 ALTER TABLE `Horaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `Horaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LiensGroupes`
--

DROP TABLE IF EXISTS `LiensGroupes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LiensGroupes` (
                                `IdDiv` varchar(10) NOT NULL,
                                `IdGrp` varchar(10) NOT NULL,
                                PRIMARY KEY (`IdDiv`,`IdGrp`),
                                KEY `IdGrp` (`IdGrp`),
                                CONSTRAINT `liensgroupes_ibfk_1` FOREIGN KEY (`IdDiv`) REFERENCES `Divisions` (`IdDiv`),
                                CONSTRAINT `liensgroupes_ibfk_2` FOREIGN KEY (`IdGrp`) REFERENCES `Groupes` (`IdGrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LiensGroupes`
--

LOCK TABLES `LiensGroupes` WRITE;
/*!40000 ALTER TABLE `LiensGroupes` DISABLE KEYS */;
/*!40000 ALTER TABLE `LiensGroupes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Options`
--

DROP TABLE IF EXISTS `Options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Options` (
                           `IdEleve` varchar(10) NOT NULL,
                           `IdEns` varchar(10) NOT NULL,
                           PRIMARY KEY (`IdEleve`,`IdEns`),
                           KEY `IdEns` (`IdEns`),
                           CONSTRAINT `options_ibfk_1` FOREIGN KEY (`IdEleve`) REFERENCES `Eleves` (`IdEleve`),
                           CONSTRAINT `options_ibfk_2` FOREIGN KEY (`IdEns`) REFERENCES `Enseignements` (`IdEns`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Options`
--

LOCK TABLES `Options` WRITE;
/*!40000 ALTER TABLE `Options` DISABLE KEYS */;
/*!40000 ALTER TABLE `Options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Parentes`
--

DROP TABLE IF EXISTS `Parentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Parentes` (
                            `IdParent` varchar(10) NOT NULL CHECK (`IdParent` like 'PRT%'),
                            `IdEleve` varchar(10) NOT NULL CHECK (`IdEleve` like 'ELV%'),
                            PRIMARY KEY (`IdParent`,`IdEleve`),
                            KEY `IdEleve` (`IdEleve`),
                            CONSTRAINT `parentes_ibfk_1` FOREIGN KEY (`IdParent`) REFERENCES `Parents` (`IdParent`),
                            CONSTRAINT `parentes_ibfk_2` FOREIGN KEY (`IdEleve`) REFERENCES `Eleves` (`IdEleve`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Parentes`
--

LOCK TABLES `Parentes` WRITE;
/*!40000 ALTER TABLE `Parentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `Parentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Parents`
--

DROP TABLE IF EXISTS `Parents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Parents` (
                           `IdParent` varchar(10) NOT NULL CHECK (`IdParent` like 'PRT%'),
                           `NomParent` varchar(15) NOT NULL,
                           `PrenomParent` varchar(15) NOT NULL,
                           `MailParent` varchar(40) DEFAULT NULL CHECK (`MailParent` like '%@%.%'),
                           `MdpParent` text DEFAULT NULL,
                           PRIMARY KEY (`IdParent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Parents`
--

LOCK TABLES `Parents` WRITE;
/*!40000 ALTER TABLE `Parents` DISABLE KEYS */;
/*!40000 ALTER TABLE `Parents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Salles`
--

DROP TABLE IF EXISTS `Salles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Salles` (
                          `IdSalle` varchar(10) NOT NULL CHECK (`IdSalle` like 'SAL%'),
                          `LibelleSalle` varchar(40) DEFAULT NULL CHECK (`LibelleSalle` like 'Salle %'),
                          `CapSalle` int(11) NOT NULL,
                          `TypeSalle` varchar(15) DEFAULT NULL,
                          PRIMARY KEY (`IdSalle`),
                          KEY `TypeSalle` (`TypeSalle`),
                          CONSTRAINT `salles_ibfk_1` FOREIGN KEY (`TypeSalle`) REFERENCES `TypesSalles` (`TypeSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Salles`
--

LOCK TABLES `Salles` WRITE;
/*!40000 ALTER TABLE `Salles` DISABLE KEYS */;
/*!40000 ALTER TABLE `Salles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TypesSalles`
--

DROP TABLE IF EXISTS `TypesSalles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TypesSalles` (
                               `TypeSalle` varchar(15) NOT NULL,
                               PRIMARY KEY (`TypeSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TypesSalles`
--

LOCK TABLES `TypesSalles` WRITE;
/*!40000 ALTER TABLE `TypesSalles` DISABLE KEYS */;
/*!40000 ALTER TABLE `TypesSalles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Unites`
--

DROP TABLE IF EXISTS `Unites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Unites` (
                          `Unite` varchar(10) NOT NULL CHECK (`Unite` like 'U%'),
                          `Semaine` char(1) DEFAULT NULL CHECK (`Semaine` in ('A','B')),
                          `Horaire` char(4) DEFAULT NULL CHECK (`Horaire` like '[A-Z]{3}[1-9]'),
                          `IdSalle` varchar(10) DEFAULT NULL CHECK (`IdSalle` like 'SAL%'),
                          `TypeSalle` varchar(15) DEFAULT NULL,
                          `IdCours` varchar(10) DEFAULT NULL CHECK (`IdCours` like 'CR%'),
                          PRIMARY KEY (`Unite`),
                          KEY `Horaire` (`Horaire`),
                          KEY `TypeSalle` (`TypeSalle`,`IdCours`),
                          KEY `IdSalle` (`IdSalle`),
                          CONSTRAINT `unites_ibfk_1` FOREIGN KEY (`Horaire`) REFERENCES `Horaires` (`Horaire`),
                          CONSTRAINT `unites_ibfk_2` FOREIGN KEY (`TypeSalle`, `IdCours`) REFERENCES `ContraintesSalles` (`TypeSalle`, `IdCours`),
                          CONSTRAINT `unites_ibfk_3` FOREIGN KEY (`IdSalle`) REFERENCES `Salles` (`IdSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Unites`
--

LOCK TABLES `Unites` WRITE;
/*!40000 ALTER TABLE `Unites` DISABLE KEYS */;
/*!40000 ALTER TABLE `Unites` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-01 20:44:23
