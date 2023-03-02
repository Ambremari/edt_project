-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           10.6.11-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage de la structure de la table collegedata. compogroupes
CREATE TABLE IF NOT EXISTS `compogroupes` (
  `IdEleve` varchar(10) NOT NULL,
  `IdGrp` varchar(10) NOT NULL,
  PRIMARY KEY (`IdEleve`,`IdGrp`),
  KEY `IdGrp` (`IdGrp`),
  CONSTRAINT `compogroupes_ibfk_1` FOREIGN KEY (`IdEleve`) REFERENCES `eleves` (`IdEleve`),
  CONSTRAINT `compogroupes_ibfk_2` FOREIGN KEY (`IdGrp`) REFERENCES `groupes` (`IdGrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.compogroupes : ~1 rows (environ)
/*!40000 ALTER TABLE `compogroupes` DISABLE KEYS */;
INSERT INTO `compogroupes` (`IdEleve`, `IdGrp`) VALUES
	('ELV1022', 'GRP103');
/*!40000 ALTER TABLE `compogroupes` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. contraintesens
CREATE TABLE IF NOT EXISTS `contraintesens` (
  `IdEns` varchar(10) NOT NULL CHECK (`IdEns` like 'ENS%'),
  `Horaire` char(4) NOT NULL CHECK (`Horaire` like '[A-Z]{3}[1-9]'),
  `Prio` int(11) DEFAULT NULL CHECK (`Prio` in ('1','2','3')),
  PRIMARY KEY (`IdEns`,`Horaire`),
  KEY `Horaire` (`Horaire`),
  CONSTRAINT `contraintesens_ibfk_1` FOREIGN KEY (`IdEns`) REFERENCES `enseignements` (`IdEns`),
  CONSTRAINT `contraintesens_ibfk_2` FOREIGN KEY (`Horaire`) REFERENCES `horaires` (`Horaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.contraintesens : ~0 rows (environ)
/*!40000 ALTER TABLE `contraintesens` DISABLE KEYS */;
/*!40000 ALTER TABLE `contraintesens` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. contraintesprof
CREATE TABLE IF NOT EXISTS `contraintesprof` (
  `IdProf` varchar(10) NOT NULL CHECK (`IdProf` like 'PRF%'),
  `Horaire` char(4) NOT NULL CHECK (`Horaire` like '[A-Z]{3}[1-9]'),
  `Prio` int(11) DEFAULT NULL CHECK (`Prio` in ('1','2','3')),
  PRIMARY KEY (`IdProf`,`Horaire`),
  KEY `Horaire` (`Horaire`),
  CONSTRAINT `contraintesprof_ibfk_1` FOREIGN KEY (`IdProf`) REFERENCES `enseignants` (`IdProf`),
  CONSTRAINT `contraintesprof_ibfk_2` FOREIGN KEY (`Horaire`) REFERENCES `horaires` (`Horaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.contraintesprof : ~0 rows (environ)
/*!40000 ALTER TABLE `contraintesprof` DISABLE KEYS */;
/*!40000 ALTER TABLE `contraintesprof` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. contraintessalles
CREATE TABLE IF NOT EXISTS `contraintessalles` (
  `TypeSalle` varchar(15) NOT NULL,
  `IdCours` varchar(10) NOT NULL CHECK (`IdCours` like 'CR%'),
  `VolHSalle` decimal(3,2) NOT NULL,
  `DureeMinSalle` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`TypeSalle`,`IdCours`),
  KEY `IdCours` (`IdCours`),
  CONSTRAINT `contraintessalles_ibfk_1` FOREIGN KEY (`TypeSalle`) REFERENCES `typessalles` (`TypeSalle`),
  CONSTRAINT `contraintessalles_ibfk_2` FOREIGN KEY (`IdCours`) REFERENCES `cours` (`IdCours`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.contraintessalles : ~0 rows (environ)
/*!40000 ALTER TABLE `contraintessalles` DISABLE KEYS */;
/*!40000 ALTER TABLE `contraintessalles` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. cours
CREATE TABLE IF NOT EXISTS `cours` (
  `IdCours` varchar(10) NOT NULL CHECK (`IdCours` like 'CR%'),
  `IdEns` varchar(10) DEFAULT NULL CHECK (`IdEns` like 'ENS%'),
  `IdProf` varchar(10) DEFAULT NULL CHECK (`IdProf` like 'PRF%'),
  `IdDiv` varchar(10) DEFAULT NULL CHECK (`IdDiv` like 'DIV%'),
  `IdGrp` varchar(10) DEFAULT NULL CHECK (`IdGrp` like 'GRP%'),
  PRIMARY KEY (`IdCours`),
  KEY `IdProf` (`IdProf`,`IdEns`),
  KEY `IdDiv` (`IdDiv`),
  KEY `IdGrp` (`IdGrp`),
  CONSTRAINT `cours_ibfk_1` FOREIGN KEY (`IdProf`, `IdEns`) REFERENCES `enseigne` (`IdProf`, `IdEns`),
  CONSTRAINT `cours_ibfk_2` FOREIGN KEY (`IdDiv`) REFERENCES `divisions` (`IdDiv`),
  CONSTRAINT `cours_ibfk_3` FOREIGN KEY (`IdGrp`) REFERENCES `groupes` (`IdGrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.cours : ~0 rows (environ)
/*!40000 ALTER TABLE `cours` DISABLE KEYS */;
/*!40000 ALTER TABLE `cours` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. directeurs
CREATE TABLE IF NOT EXISTS `directeurs` (
  `IdDir` varchar(10) NOT NULL CHECK (`IdDir` like 'DIR%'),
  `NomDir` varchar(15) NOT NULL,
  `PrenomDir` varchar(15) NOT NULL,
  `MdpDir` text DEFAULT NULL,
  `MailDir` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`IdDir`),
  UNIQUE KEY `MailDir` (`MailDir`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.directeurs : ~1 rows (environ)
/*!40000 ALTER TABLE `directeurs` DISABLE KEYS */;
INSERT INTO `directeurs` (`IdDir`, `NomDir`, `PrenomDir`, `MdpDir`, `MailDir`) VALUES
	('DIR001', 'Principal', 'Adjoint', '$2y$10$DgvkQVZO3.Mn/uAmBdpVg.cf0MLBaJEcrN4aWeCkL9T3NBmyrQrly', 'admin@college-vh.com');
/*!40000 ALTER TABLE `directeurs` ENABLE KEYS */;

-- Listage de la structure de la vue collegedata. divisioncount
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `divisioncount` (
	`IdDiv` VARCHAR(10) NOT NULL COLLATE 'utf8mb3_general_ci',
	`EffectifReelDiv` BIGINT(21) NOT NULL
) ENGINE=MyISAM;

-- Listage de la structure de la table collegedata. divisions
CREATE TABLE IF NOT EXISTS `divisions` (
  `IdDiv` varchar(10) NOT NULL CHECK (`IdDiv` like 'DIV%'),
  `LibelleDiv` varchar(10) NOT NULL,
  `NiveauDiv` char(4) DEFAULT NULL CHECK (`NiveauDiv` in ('6EME','5EME','4EME','3EME')),
  `EffectifPrevDiv` int(11) NOT NULL DEFAULT 35,
  PRIMARY KEY (`IdDiv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.divisions : ~14 rows (environ)
/*!40000 ALTER TABLE `divisions` DISABLE KEYS */;
INSERT INTO `divisions` (`IdDiv`, `LibelleDiv`, `NiveauDiv`, `EffectifPrevDiv`) VALUES
	('DIV001', '6èmeA', '6EME', 35),
	('DIV002', '5èmeA', '5EME', 35),
	('DIV003', '4èmeA', '4EME', 35),
	('DIV004', '3èmeA', '3EME', 35),
	('DIV011', '6èmeC', '6EME', 35),
	('DIV012', '5èmeC', '5EME', 35),
	('DIV013', '4èmeC', '4EME', 35),
	('DIV014', '3èmeC', '3EME', 35),
	('DIV021', '6èmeB', '6EME', 35),
	('DIV022', '5èmeB', '5EME', 35),
	('DIV023', '4èmeB', '4EME', 35),
	('DIV024', '3èmeB', '3EME', 35),
	('DIV09ad3', '3èmeE', '3EME', 30),
	('DIV0a164', '3èmeE', '3EME', 30);
/*!40000 ALTER TABLE `divisions` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. eleves
CREATE TABLE IF NOT EXISTS `eleves` (
  `IdEleve` varchar(10) NOT NULL CHECK (`IdEleve` like 'ELV%'),
  `NomEleve` varchar(15) NOT NULL,
  `PrenomEleve` varchar(15) NOT NULL,
  `MdpEleve` text DEFAULT NULL,
  `AnneeNaisEleve` decimal(4,0) DEFAULT NULL CHECK (`AnneeNaisEleve` > 2000 and `AnneeNaisEleve` < 2100),
  `NiveauEleve` varchar(4) DEFAULT NULL CHECK (`NiveauEleve` like '%EME'),
  `IdDiv` varchar(10) DEFAULT NULL CHECK (`IdDiv` like 'DIV%'),
  PRIMARY KEY (`IdEleve`),
  KEY `IdDiv` (`IdDiv`),
  CONSTRAINT `eleves_ibfk_1` FOREIGN KEY (`IdDiv`) REFERENCES `divisions` (`IdDiv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.eleves : ~10 rows (environ)
/*!40000 ALTER TABLE `eleves` DISABLE KEYS */;
INSERT INTO `eleves` (`IdEleve`, `NomEleve`, `PrenomEleve`, `MdpEleve`, `AnneeNaisEleve`, `NiveauEleve`, `IdDiv`) VALUES
	('ELV1002', 'Kim', 'Lani', NULL, 2009, '4EME', NULL),
	('ELV1006', 'Miles', 'Jeanette', NULL, 2011, '5EME', NULL),
	('ELV1010', 'Reynolds', 'Alea', NULL, 2008, '3EME', NULL),
	('ELV1014', 'Howe', 'Dane', NULL, 2013, '6EME', NULL),
	('ELV1018', 'Holden', 'Macey', NULL, 2010, '6EME', 'DIV001'),
	('ELV1022', 'Bean', 'Nora', NULL, 2008, '4EME', 'DIV003'),
	('ELV1026', 'Bond', 'Daniel', NULL, 2012, '5EME', NULL),
	('ELV1030', 'Holmes', 'Michelle', NULL, 2011, '4EME', NULL),
	('ELV1034', 'Harvey', 'Nevada', NULL, 2010, '4EME', NULL),
	('ELV1038', 'Dyer', 'Norman', NULL, 2013, '5EME', NULL);
/*!40000 ALTER TABLE `eleves` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. enseignants
CREATE TABLE IF NOT EXISTS `enseignants` (
  `IdProf` varchar(10) NOT NULL CHECK (`IdProf` like 'PRF%'),
  `NomProf` varchar(15) NOT NULL,
  `PrenomProf` varchar(15) NOT NULL,
  `MdpProf` text DEFAULT NULL,
  `MailProf` varchar(40) DEFAULT NULL CHECK (`MailProf` like '%@college-vh.com'),
  `VolHProf` decimal(3,1) NOT NULL,
  PRIMARY KEY (`IdProf`),
  UNIQUE KEY `MailProf` (`MailProf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.enseignants : ~20 rows (environ)
/*!40000 ALTER TABLE `enseignants` DISABLE KEYS */;
INSERT INTO `enseignants` (`IdProf`, `NomProf`, `PrenomProf`, `MdpProf`, `MailProf`, `VolHProf`) VALUES
	('PRF001', 'Dupont', 'Jean', '$2y$10$RK0x.6xHtPqQq143zDL7C.3zKvPcvCl1mkxGlvRD8vlN5aoN0nAqi', 'jean.dupont@college-vh.com', 35.0),
	('PRF002', 'Dubois', 'Jean-Luc', NULL, 'jean-luc.dubois@college-vh.com', 35.0),
	('PRF003', 'Mari', 'Jean-Louis', NULL, 'jean-louis.mari@college-vh.com', 35.0),
	('PRF004', 'Nouioua', 'Karim', NULL, 'karim.nouioua@college-vh.com', 35.0),
	('PRF005', 'Novelli', 'Noel', NULL, 'noel.novelli@college-vh.com', 35.0),
	('PRF006', 'Estellon', 'Bertrand', NULL, 'bertrand.estellon@college-vh.com', 35.0),
	('PRF007', 'Lamarche', 'Juliette', NULL, 'juliette.lamarche@college-vh.com', 35.0),
	('PRF008', 'Courtin', 'Sophie', NULL, 'sophie.courtin@college-vh.com', 35.0),
	('PRF009', 'Fournier', 'François', NULL, 'françois.fournier@college-vh.com', 35.0),
	('PRF010', 'Henry', 'Pierre', NULL, 'pierre.henry@college-vh.com', 35.0),
	('PRF011', 'Devoird', 'Bertrand', NULL, 'bertrand.devoird@college-vh.com', 35.0),
	('PRF012', 'Henry', 'Paul', NULL, 'paul.henry@college-vh.com', 35.0),
	('PRF013', 'Saez', 'Damien', NULL, 'damien.saez@college-vh.com', 35.0),
	('PRF014', 'Bachelete', 'Manon', NULL, 'manon.bachelet@college-vh.com', 35.0),
	('PRF015', 'Casting', 'Magali', NULL, 'magali.casting@college-vh.com', 35.0),
	('PRF016', 'Rizza', 'Mariz', NULL, 'maria.rizza@college-vh.com', 35.0),
	('PRF017', 'Manzoni', 'Coline', NULL, 'coline.manzoni@college-vh.com', 35.0),
	('PRF018', 'Vaz', 'Alexie', NULL, 'alexie.vaz@college-vh.com', 35.0),
	('PRF019', 'Diallo', 'Moussa', NULL, 'moussa.diallo@college-vh.com', 35.0),
	('PRF020', 'Martin', 'Françoise', NULL, 'françoise.martin@college-vh.com', 35.0);
/*!40000 ALTER TABLE `enseignants` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. enseigne
CREATE TABLE IF NOT EXISTS `enseigne` (
  `IdProf` varchar(10) NOT NULL CHECK (`IdProf` like 'PRF%'),
  `IdEns` varchar(10) NOT NULL CHECK (`IdEns` like 'ENS%'),
  PRIMARY KEY (`IdProf`,`IdEns`),
  KEY `IdEns` (`IdEns`),
  CONSTRAINT `enseigne_ibfk_1` FOREIGN KEY (`IdProf`) REFERENCES `enseignants` (`IdProf`),
  CONSTRAINT `enseigne_ibfk_2` FOREIGN KEY (`IdEns`) REFERENCES `enseignements` (`IdEns`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.enseigne : ~0 rows (environ)
/*!40000 ALTER TABLE `enseigne` DISABLE KEYS */;
/*!40000 ALTER TABLE `enseigne` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. enseignements
CREATE TABLE IF NOT EXISTS `enseignements` (
  `IdEns` varchar(10) NOT NULL CHECK (`IdEns` like 'ENS%'),
  `LibelleEns` varchar(40) NOT NULL,
  `NiveauEns` char(4) DEFAULT NULL CHECK (`NiveauEns` in ('6EME','5EME','4EME','3EME')),
  `VolHEns` decimal(3,1) NOT NULL,
  `OptionEns` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`IdEns`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.enseignements : ~53 rows (environ)
/*!40000 ALTER TABLE `enseignements` DISABLE KEYS */;
INSERT INTO `enseignements` (`IdEns`, `LibelleEns`, `NiveauEns`, `VolHEns`, `OptionEns`) VALUES
	('ENS001', 'Français', '6EME', 4.5, 0),
	('ENS002', 'Français', '5EME', 4.5, 0),
	('ENS003', 'Français', '4EME', 4.5, 0),
	('ENS004', 'Français', '3EME', 4.5, 0),
	('ENS005', 'Mathématiques', '6EME', 4.5, 0),
	('ENS006', 'Mathématiques', '5EME', 3.5, 0),
	('ENS007', 'Mathématiques', '4EME', 3.5, 0),
	('ENS008', 'Mathématiques', '3EME', 3.5, 0),
	('ENS009', 'Histoire-géographie', '6EME', 3.0, 0),
	('ENS010', 'Histoire-géographie', '5EME', 3.0, 0),
	('ENS011', 'Histoire-géographie', '4EME', 3.0, 0),
	('ENS012', 'Histoire-géographie', '3EME', 3.5, 0),
	('ENS013', 'Anglais LV1', '6EME', 4.0, 1),
	('ENS014', 'Anglais LV1', '5EME', 3.0, 1),
	('ENS015', 'Anglais LV1', '4EME', 3.0, 1),
	('ENS016', 'Anglais LV1', '3EME', 3.0, 1),
	('ENS017', 'Espagnol LV2', '6EME', 2.5, 1),
	('ENS018', 'Espagnol LV2', '5EME', 2.5, 1),
	('ENS019', 'Espagnol LV2', '4EME', 2.5, 1),
	('ENS020', 'Espagnol LV2', '3EME', 2.5, 1),
	('ENS021', 'SVT-physique-chimie', '6EME', 4.0, 0),
	('ENS022', 'SVT', '5EME', 1.5, 0),
	('ENS023', 'SVT', '4EME', 1.5, 0),
	('ENS024', 'SVT', '3EME', 1.5, 0),
	('ENS025', 'Physique-chimie', '5EME', 1.5, 0),
	('ENS026', 'Physique-chimie', '4EME', 1.5, 0),
	('ENS027', 'Physique-chimie', '3EME', 1.5, 0),
	('ENS028', 'Technologie', '5EME', 1.5, 0),
	('ENS029', 'Technologie', '4EME', 1.5, 0),
	('ENS030', 'Technologie', '3EME', 1.5, 0),
	('ENS031', 'Éducation physique et sportive', '6EME', 4.0, 0),
	('ENS032', 'Éducation physique et sportive', '5EME', 3.0, 0),
	('ENS033', 'Éducation physique et sportive', '4EME', 3.0, 0),
	('ENS034', 'Éducation physique et sportive', '3EME', 3.0, 0),
	('ENS035', 'Arts plastiques', '6EME', 1.0, 0),
	('ENS036', 'Arts plastiques', '5EME', 1.0, 0),
	('ENS037', 'Arts plastiques', '4EME', 1.0, 0),
	('ENS038', 'Arts plastiques', '3EME', 1.0, 0),
	('ENS039', 'Éducation musicale', '6EME', 1.0, 0),
	('ENS040', 'Éducation musicale', '5EME', 1.0, 0),
	('ENS041', 'Éducation musicale', '4EME', 1.0, 0),
	('ENS042', 'Éducation musicale', '3EME', 1.0, 0),
	('ENS043', 'Langues et cultures européennes', '5EME', 1.0, 1),
	('ENS044', 'Langues et cultures européennes', '4EME', 1.0, 1),
	('ENS045', 'Langues et cultures européennes', '3EME', 1.0, 1),
	('ENS046', 'Langues et cultures régionales', '6EME', 1.0, 1),
	('ENS047', 'Langues et cultures régionales', '5EME', 1.0, 1),
	('ENS048', 'Langues et cultures régionales', '4EME', 1.0, 1),
	('ENS049', 'Langues et cultures régionales', '3EME', 1.0, 1),
	('ENS050', 'Langues et cultures de l\'antiquité', '6EME', 1.0, 1),
	('ENS051', 'Langues et cultures de l\'antiquité', '5EME', 1.0, 1),
	('ENS052', 'Langues et cultures de l\'antiquité', '4EME', 1.0, 1),
	('ENS053', 'Langues et cultures de l\'antiquité', '3EME', 1.0, 1);
/*!40000 ALTER TABLE `enseignements` ENABLE KEYS */;

-- Listage de la structure de la vue collegedata. ensoption
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `ensoption` (
	`IdEns` VARCHAR(10) NOT NULL COLLATE 'utf8mb3_general_ci',
	`LibelleEns` VARCHAR(40) NOT NULL COLLATE 'utf8mb3_general_ci',
	`NiveauEns` CHAR(4) NULL COLLATE 'utf8mb3_general_ci',
	`VolHEns` DECIMAL(3,1) NOT NULL,
	`OptionEns` TINYINT(1) NOT NULL
) ENGINE=MyISAM;

-- Listage de la structure de la vue collegedata. groupcount
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `groupcount` (
	`IdGrp` VARCHAR(10) NOT NULL COLLATE 'utf8mb3_general_ci',
	`EffectifReelGrp` BIGINT(21) NOT NULL
) ENGINE=MyISAM;

-- Listage de la structure de la vue collegedata. groupdivcount
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `groupdivcount` (
	`IdGrp` VARCHAR(10) NOT NULL COLLATE 'utf8mb3_general_ci',
	`NbDivAssociees` BIGINT(21) NOT NULL
) ENGINE=MyISAM;

-- Listage de la structure de la table collegedata. groupes
CREATE TABLE IF NOT EXISTS `groupes` (
  `IdGrp` varchar(10) NOT NULL CHECK (`IdGrp` like 'GRP%'),
  `LibelleGrp` varchar(40) NOT NULL,
  `NiveauGrp` varchar(4) NOT NULL CHECK (`NiveauGrp` in ('6EME','5EME','4EME','3EME')),
  `EffectifPrevGrp` int(11) NOT NULL DEFAULT 35,
  PRIMARY KEY (`IdGrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.groupes : ~10 rows (environ)
/*!40000 ALTER TABLE `groupes` DISABLE KEYS */;
INSERT INTO `groupes` (`IdGrp`, `LibelleGrp`, `NiveauGrp`, `EffectifPrevGrp`) VALUES
	('GRP001', 'Grp Latin 6ème', '6EME', 35),
	('GRP002', 'Grp Latin 5ème', '5EME', 35),
	('GRP003', 'Grp Latin 4ème', '4EME', 35),
	('GRP004', 'Grp Latin 3ème', '3EME', 35),
	('GRP0a164A', '3èmeEGP A', '3EME', 15),
	('GRP0a164B', '3èmeEGP A', '3EME', 15),
	('GRP101', 'Grp A Anglais LV1 6ème', '6EME', 35),
	('GRP102', 'Grp A Anglais LV1 5ème', '5EME', 35),
	('GRP103', 'Grp A Anglais LV1 4ème', '4EME', 35),
	('GRP104', 'Grp A Anglais LV1 3ème', '3EME', 35);
/*!40000 ALTER TABLE `groupes` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. horaires
CREATE TABLE IF NOT EXISTS `horaires` (
  `Horaire` char(4) NOT NULL CHECK (`Horaire` like '[A-Z]{3}[1-9]'),
  `Jour` varchar(10) DEFAULT NULL CHECK (`Jour` in ('lundi','mardi','mercredi','jeudi','vendredi','samedi')),
  `HeureDebut` time NOT NULL,
  `HeureFin` time NOT NULL,
  PRIMARY KEY (`Horaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.horaires : ~0 rows (environ)
/*!40000 ALTER TABLE `horaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `horaires` ENABLE KEYS */;

-- Listage de la structure de la vue collegedata. libellescours
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `libellescours` (
	`IdDiv` VARCHAR(10) NULL COLLATE 'utf8mb3_general_ci',
	`IdGrp` VARCHAR(10) NULL COLLATE 'utf8mb3_general_ci',
	`IdProf` VARCHAR(10) NULL COLLATE 'utf8mb3_general_ci',
	`IdEns` VARCHAR(10) NULL COLLATE 'utf8mb3_general_ci',
	`LibelleEns` VARCHAR(40) NOT NULL COLLATE 'utf8mb3_general_ci',
	`NomProf` VARCHAR(15) NOT NULL COLLATE 'utf8mb3_general_ci',
	`PrenomProf` VARCHAR(15) NOT NULL COLLATE 'utf8mb3_general_ci',
	`LibelleDiv` VARCHAR(10) NULL COLLATE 'utf8mb3_general_ci',
	`LibelleGrp` VARCHAR(40) NULL COLLATE 'utf8mb3_general_ci'
) ENGINE=MyISAM;

-- Listage de la structure de la vue collegedata. libellesdiv
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `libellesdiv` (
	`IdGrp` VARCHAR(10) NOT NULL COLLATE 'utf8mb3_general_ci',
	`IdDiv` VARCHAR(10) NOT NULL COLLATE 'utf8mb3_general_ci',
	`LibelleDiv` VARCHAR(10) NOT NULL COLLATE 'utf8mb3_general_ci'
) ENGINE=MyISAM;

-- Listage de la structure de la table collegedata. liensgroupes
CREATE TABLE IF NOT EXISTS `liensgroupes` (
  `IdDiv` varchar(10) NOT NULL,
  `IdGrp` varchar(10) NOT NULL,
  PRIMARY KEY (`IdDiv`,`IdGrp`),
  KEY `IdGrp` (`IdGrp`),
  CONSTRAINT `liensgroupes_ibfk_1` FOREIGN KEY (`IdDiv`) REFERENCES `divisions` (`IdDiv`),
  CONSTRAINT `liensgroupes_ibfk_2` FOREIGN KEY (`IdGrp`) REFERENCES `groupes` (`IdGrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.liensgroupes : ~5 rows (environ)
/*!40000 ALTER TABLE `liensgroupes` DISABLE KEYS */;
INSERT INTO `liensgroupes` (`IdDiv`, `IdGrp`) VALUES
	('DIV003', 'GRP103'),
	('DIV013', 'GRP103'),
	('DIV023', 'GRP103'),
	('DIV0a164', 'GRP0a164A'),
	('DIV0a164', 'GRP0a164B');
/*!40000 ALTER TABLE `liensgroupes` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. options
CREATE TABLE IF NOT EXISTS `options` (
  `IdEleve` varchar(10) NOT NULL,
  `IdEns` varchar(10) NOT NULL,
  PRIMARY KEY (`IdEleve`,`IdEns`),
  KEY `IdEns` (`IdEns`),
  CONSTRAINT `options_ibfk_1` FOREIGN KEY (`IdEleve`) REFERENCES `eleves` (`IdEleve`),
  CONSTRAINT `options_ibfk_2` FOREIGN KEY (`IdEns`) REFERENCES `enseignements` (`IdEns`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.options : ~2 rows (environ)
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` (`IdEleve`, `IdEns`) VALUES
	('ELV1022', 'ENS015'),
	('ELV1034', 'ENS015');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. parentes
CREATE TABLE IF NOT EXISTS `parentes` (
  `IdParent` varchar(10) NOT NULL CHECK (`IdParent` like 'PRT%'),
  `IdEleve` varchar(10) NOT NULL CHECK (`IdEleve` like 'ELV%'),
  PRIMARY KEY (`IdParent`,`IdEleve`),
  KEY `IdEleve` (`IdEleve`),
  CONSTRAINT `parentes_ibfk_1` FOREIGN KEY (`IdParent`) REFERENCES `parents` (`IdParent`),
  CONSTRAINT `parentes_ibfk_2` FOREIGN KEY (`IdEleve`) REFERENCES `eleves` (`IdEleve`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.parentes : ~0 rows (environ)
/*!40000 ALTER TABLE `parentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `parentes` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. parents
CREATE TABLE IF NOT EXISTS `parents` (
  `IdParent` varchar(10) NOT NULL CHECK (`IdParent` like 'PRT%'),
  `NomParent` varchar(15) NOT NULL,
  `PrenomParent` varchar(15) NOT NULL,
  `MailParent` varchar(40) DEFAULT NULL CHECK (`MailParent` like '%@%.%'),
  `MdpParent` text DEFAULT NULL,
  PRIMARY KEY (`IdParent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.parents : ~0 rows (environ)
/*!40000 ALTER TABLE `parents` DISABLE KEYS */;
/*!40000 ALTER TABLE `parents` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. salles
CREATE TABLE IF NOT EXISTS `salles` (
  `IdSalle` varchar(10) NOT NULL CHECK (`IdSalle` like 'SAL%'),
  `LibelleSalle` varchar(40) DEFAULT NULL CHECK (`LibelleSalle` like 'Salle %'),
  `CapSalle` int(11) NOT NULL,
  `TypeSalle` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`IdSalle`),
  KEY `TypeSalle` (`TypeSalle`),
  CONSTRAINT `salles_ibfk_1` FOREIGN KEY (`TypeSalle`) REFERENCES `typessalles` (`TypeSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.salles : ~38 rows (environ)
/*!40000 ALTER TABLE `salles` DISABLE KEYS */;
INSERT INTO `salles` (`IdSalle`, `LibelleSalle`, `CapSalle`, `TypeSalle`) VALUES
	('SAL001', 'Salle Gaston Vaseur', 30, 'Cours'),
	('SAL002', 'Salle Marie Curie', 30, 'Cours'),
	('SAL003', 'Salle Louis Pasteur', 30, 'Cours'),
	('SAL004', 'Salle Xavier Lepichon', 30, 'Cours'),
	('SAL005', 'Salle Katia Kraft', 30, 'Cours'),
	('SAL006', 'Salle Amedeo Avogadro', 30, 'Cours'),
	('SAL007', 'Salle Charles Coulomb', 30, 'Cours'),
	('SAL008', 'Salle Léon Foucault', 30, 'Cours'),
	('SAL009', 'Salle Pierre Fermat', 30, 'Cours'),
	('SAL010', 'Salle Werner Heisenberg', 30, 'Cours'),
	('SAL011', 'Salle Alfred Kastler', 30, 'Cours'),
	('SAL012', 'Salle Frantz Fanon', 30, 'Cours'),
	('SAL013', 'Salle Archimède', 30, 'Cours'),
	('SAL014', 'Salle Henry Becquerel', 30, 'Cours'),
	('SAL015', 'Salle Anders Celsius', 30, 'Cours'),
	('SAL016', 'Salle Delaire', 15, 'TP'),
	('SAL017', 'Salle Jean Fabre', 15, 'TP'),
	('SAL018', 'Salle Charles Frankel', 15, 'TP'),
	('SAL019', 'Salle Beaumont', 15, 'TP'),
	('SAL020', 'Salle Darwin', 15, 'TP'),
	('SAL021', 'Salle Menez', 15, 'TP'),
	('SAL022', 'Salle Gargani', 15, 'TP'),
	('SAL023', 'Salle Beaudoin', 15, 'TP'),
	('SAL024', 'Salle Motenat', 15, 'TP'),
	('SAL025', 'Salle Gargani', 15, 'TP'),
	('SAL026', 'Salle Lagny', 15, 'TP'),
	('SAL027', 'Salle Chauvel', 15, 'TP'),
	('SAL028', 'Salle Larouzière', 15, 'TP'),
	('SAL029', 'Salle Gaudant', 15, 'TP'),
	('SAL030', 'Salle Mahrez', 15, 'TP'),
	('SAL031', 'Salle de Foot', 40, 'Sport'),
	('SAL032', 'Salle de Volley', 40, 'Sport'),
	('SAL033', 'Salle de Basket-ball', 40, 'Sport'),
	('SAL034', 'Salle de Hand-ball', 40, 'Sport'),
	('SAL035', 'Salle de Tennis', 40, 'Sport'),
	('SAL036', 'Salle de Musculation', 40, 'Sport'),
	('SAL037', 'Salle de Fitness', 40, 'Sport'),
	('SAL813', 'Salle Jules Hoffman', 30, 'Cours');
/*!40000 ALTER TABLE `salles` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. typessalles
CREATE TABLE IF NOT EXISTS `typessalles` (
  `TypeSalle` varchar(15) NOT NULL,
  PRIMARY KEY (`TypeSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.typessalles : ~4 rows (environ)
/*!40000 ALTER TABLE `typessalles` DISABLE KEYS */;
INSERT INTO `typessalles` (`TypeSalle`) VALUES
	('Cours'),
	('Informatique'),
	('Sport'),
	('TP');
/*!40000 ALTER TABLE `typessalles` ENABLE KEYS */;

-- Listage de la structure de la table collegedata. unites
CREATE TABLE IF NOT EXISTS `unites` (
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
  CONSTRAINT `unites_ibfk_1` FOREIGN KEY (`Horaire`) REFERENCES `horaires` (`Horaire`),
  CONSTRAINT `unites_ibfk_2` FOREIGN KEY (`TypeSalle`, `IdCours`) REFERENCES `contraintessalles` (`TypeSalle`, `IdCours`),
  CONSTRAINT `unites_ibfk_3` FOREIGN KEY (`IdSalle`) REFERENCES `salles` (`IdSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Listage des données de la table collegedata.unites : ~0 rows (environ)
/*!40000 ALTER TABLE `unites` DISABLE KEYS */;
/*!40000 ALTER TABLE `unites` ENABLE KEYS */;

-- Listage de la structure de la vue collegedata. divisioncount
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `divisioncount`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `divisioncount` AS SELECT D.IdDiv, COUNT(IdEleve) EffectifReelDiv
   FROM Divisions D LEFT JOIN Eleves E ON D.IdDiv = E.IdDiv
   GROUP BY D.IdDiv; ;

-- Listage de la structure de la vue collegedata. ensoption
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `ensoption`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ensoption` AS SELECT *
   FROM Enseignements
   WHERE OptionEns IS true ;

-- Listage de la structure de la vue collegedata. groupcount
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `groupcount`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `groupcount` AS SELECT G.IdGrp, COUNT(IdEleve) EffectifReelGrp
   FROM Groupes G LEFT JOIN CompoGroupes C ON G.IdGrp = C.IdGrp
   GROUP BY G.IdGrp; ;

-- Listage de la structure de la vue collegedata. groupdivcount
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `groupdivcount`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `groupdivcount` AS SELECT G.IdGrp, COUNT(IdDiv) NbDivAssociees
   FROM Groupes G LEFT JOIN LiensGroupes L ON G.IdGrp = L.IdGrp
   GROUP BY G.IdGrp; ;

-- Listage de la structure de la vue collegedata. libellescours
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `libellescours`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `libellescours` AS SELECT C.IdDiv, C.IdGrp, C.IdProf, C.IdEns, LibelleEns, NomProf, PrenomProf, LibelleDiv, LibelleGrp
   FROM (((Cours C JOIN Enseignements E ON C.IdEns = E.IdEns)
         JOIN Enseignants P ON C.IdProf = P.IdProf)
         LEFT JOIN Divisions D ON C.IdDiv = D.IdDiv)
         LEFT JOIN Groupes G ON C.IdGrp = G.IdGrp; ;

-- Listage de la structure de la vue collegedata. libellesdiv
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `libellesdiv`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `libellesdiv` AS SELECT IdGrp, G.IdDiv, LibelleDiv
   FROM LiensGroupes G JOIN Divisions D ON G.IdDiv = D.IdDiv; ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
