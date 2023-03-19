DROP TABLE IF EXISTS Unites;
DROP TABLE IF EXISTS IncompatibilitesChoix;
DROP TABLE IF EXISTS ContraintesSalles;
DROP TABLE IF EXISTS Parentes;
DROP TABLE IF EXISTS ContraintesProf;
DROP TABLE IF EXISTS ContraintesEns;
DROP TABLE IF EXISTS Cours;
DROP TABLE IF EXISTS Options;
DROP TABLE IF EXISTS CompoGroupes;
DROP TABLE IF EXISTS Enseigne;
DROP TABLE IF EXISTS LiensGroupes;
DROP TABLE IF EXISTS Eleves;
DROP TABLE IF EXISTS Salles;
DROP TABLE IF EXISTS TypesSalles;
DROP TABLE IF EXISTS Horaires;
DROP TABLE IF EXISTS Enseignants;
DROP TABLE IF EXISTS Enseignements;
DROP TABLE IF EXISTS Groupes;
DROP TABLE IF EXISTS Divisions;
DROP TABLE IF EXISTS Parents;
DROP TABLE IF EXISTS Directeurs;

CREATE TABLE Directeurs(
   IdDir VARCHAR(10) CHECK (IdDir LIKE 'DIR%'),
   NomDir VARCHAR(15) NOT NULL,
   PrenomDir VARCHAR(15) NOT NULL,
   MdpDir TEXT,
   MailDir VARCHAR(40) UNIQUE,
   PRIMARY KEY(IdDir)
);

CREATE TABLE Parents(
   IdParent VARCHAR(10) CHECK(IdParent LIKE 'PRT%'),
   NomParent VARCHAR(15) NOT NULL,
   PrenomParent VARCHAR(15) NOT NULL,
   MailParent VARCHAR(40) CHECK (MailParent LIKE '%@%.%'),
   MdpParent TEXT,
   PRIMARY KEY(IdParent)
);

CREATE TABLE Divisions(
   IdDiv VARCHAR(10) CHECK (IdDiv LIKE 'DIV%'),
   LibelleDiv VARCHAR(10) NOT NULL,
   NiveauDiv CHAR(4) CHECK (NiveauDiv IN ('6EME', '5EME', '4EME', '3EME')),
   EffectifPrevDiv INT NOT NULL DEFAULT 35,
   PRIMARY KEY(IdDiv)
);

CREATE TABLE Groupes(
   IdGrp VARCHAR(10) CHECK (IdGrp LIKE 'GRP%'),
   LibelleGrp VARCHAR(40)  NOT NULL,
   NiveauGrp VARCHAR(4)  NOT NULL CHECK (NiveauGrp IN ('6EME', '5EME', '4EME', '3EME')),
   EffectifPrevGrp INT NOT NULL DEFAULT 35,
   PRIMARY KEY(IdGrp)
);


CREATE TABLE Enseignements(
   IdEns VARCHAR(10) CHECK (IdEns LIKE 'ENS%'),
   LibelleEns VARCHAR(40) NOT NULL,
   NiveauEns CHAR(4) CHECK(NiveauEns IN ('6EME', '5EME', '4EME', '3EME')),
   VolHEns DECIMAL(3,1) NOT NULL,
   OptionEns BOOLEAN NOT NULL DEFAULT 0,
   PRIMARY KEY(IdEns)
);

CREATE TABLE Enseignants(
   IdProf VARCHAR(10) CHECK (IdProf LIKE 'PRF%'),
   NomProf VARCHAR(15) NOT NULL,
   PrenomProf VARCHAR(15) NOT NULL,
   MdpProf TEXT,
   MailProf VARCHAR(40) UNIQUE CHECK (MailProf LIKE '%@college-vh\.com'),
   VolHProf DECIMAL(3,1) NOT NULL,
   PRIMARY KEY(IdProf)
);

CREATE TABLE Horaires(
   Horaire CHAR(4) CHECK (Horaire REGEXP '[A-Z]{3}[1-9]'),
   Jour VARCHAR(10) CHECK (Jour IN ('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi')),
   HeureDebut TIME NOT NULL,
   HeureFin TIME NOT NULL,
   PRIMARY KEY(Horaire)
);

CREATE TABLE TypesSalles(
   TypeSalle VARCHAR(15),
   PRIMARY KEY(TypeSalle)
);

CREATE TABLE Salles(
   IdSalle VARCHAR(10) CHECK (IdSalle LIKE 'SAL%'),
   LibelleSalle VARCHAR(40),
   CapSalle INT NOT NULL,
   TypeSalle VARCHAR(15),
   PRIMARY KEY(IdSalle),
   FOREIGN KEY(TypeSalle) REFERENCES TypesSalles(TypeSalle)
);

CREATE TABLE Eleves(
   IdEleve VARCHAR(10) CHECK (IdEleve LIKE 'ELV%'),
   NomEleve VARCHAR(15)  NOT NULL,
   PrenomEleve VARCHAR(15)  NOT NULL,
   MdpEleve TEXT,
   AnneeNaisEleve DECIMAL(4) CHECK (AnneeNaisEleve>2000 AND AnneeNaisEleve<2100),
   NiveauEleve VARCHAR(4)  CHECK (NiveauEleve LIKE '%EME'),
   IdDiv VARCHAR(10) CHECK (IdDiv LIKE 'DIV%'),
   PRIMARY KEY(IdEleve),
   FOREIGN KEY(IdDiv) REFERENCES Divisions(IdDiv)
);

CREATE TABLE LiensGroupes(
   IdDiv VARCHAR(10) ,
   IdGrp VARCHAR(10) ,
   PRIMARY KEY(IdDiv, IdGrp),
   FOREIGN KEY(IdDiv) REFERENCES Divisions(IdDiv),
   FOREIGN KEY(IdGrp) REFERENCES Groupes(IdGrp)
);

CREATE TABLE Enseigne(
   IdProf VARCHAR(10) CHECK (IdProf LIKE 'PRF%'),
   IdEns VARCHAR(10)  CHECK (IdEns LIKE 'ENS%'),
   PRIMARY KEY(IdProf, IdEns),
   FOREIGN KEY(IdProf) REFERENCES Enseignants(IdProf),
   FOREIGN KEY(IdEns) REFERENCES Enseignements(IdEns)
);

CREATE TABLE CompoGroupes(
   IdEleve VARCHAR(10) ,
   IdGrp VARCHAR(10) ,
   PRIMARY KEY(IdEleve, IdGrp),
   FOREIGN KEY(IdEleve) REFERENCES Eleves(IdEleve),
   FOREIGN KEY(IdGrp) REFERENCES Groupes(IdGrp)
);

CREATE TABLE Options(
   IdEleve VARCHAR(10) ,
   IdEns VARCHAR(10) ,
   PRIMARY KEY(IdEleve, IdEns),
   FOREIGN KEY(IdEleve) REFERENCES Eleves(IdEleve),
   FOREIGN KEY(IdEns) REFERENCES Enseignements(IdEns)
);

CREATE TABLE Cours(
   IdCours VARCHAR(10) CHECK (IdCours LIKE 'CR%'),
   IdEns VARCHAR(10) CHECK (IdEns LIKE 'ENS%'),
   IdProf VARCHAR(10) CHECK (IdProf LIKE 'PRF%'),
   IdDiv VARCHAR(10) CHECK (IdDiv LIKE 'DIV%'),
   IdGrp VARCHAR(10) CHECK (IdGrp LIKE 'GRP%'),
   PRIMARY KEY(IdCours),
   FOREIGN KEY(IdProf, IdEns) REFERENCES Enseigne(IdProf, IdEns),
   FOREIGN KEY(IdDiv) REFERENCES Divisions(IdDiv),
   FOREIGN KEY(IdGrp) REFERENCES Groupes(IdGrp)
);

CREATE TABLE ContraintesEns(
   IdEns VARCHAR(10) CHECK (IdEns LIKE 'ENS%'),
   Horaire CHAR(4) CHECK (Horaire REGEXP '[A-Z]{3}[1-9]'),
   Prio INT CHECK (Prio IN('1','2','3')),
   PRIMARY KEY(IdEns, Horaire),
   FOREIGN KEY(IdEns) REFERENCES Enseignements(IdEns),
   FOREIGN KEY(Horaire) REFERENCES Horaires(Horaire)
);

CREATE TABLE ContraintesProf(
   IdProf VARCHAR(10) CHECK (IdProf LIKE 'PRF%'),
   Horaire CHAR(4) CHECK (Horaire REGEXP '[A-Z]{3}[1-9]'),
   Prio INT,
   PRIMARY KEY(IdProf, Horaire),
   FOREIGN KEY(IdProf) REFERENCES Enseignants(IdProf),
   FOREIGN KEY(Horaire) REFERENCES Horaires(Horaire)
);

CREATE TABLE Parentes(
   IdParent VARCHAR(10) CHECK(IdParent LIKE 'PRT%'),
   IdEleve VARCHAR(10) CHECK(IdEleve LIKE 'ELV%'),
   PRIMARY KEY(IdParent, IdEleve),
   FOREIGN KEY(IdParent) REFERENCES Parents(IdParent),
   FOREIGN KEY(IdEleve) REFERENCES Eleves(IdEleve)
);

CREATE TABLE ContraintesSalles(
   IdContSalle VARCHAR(10) CHECK (IdContSalle LIKE 'CS%'),
   TypeSalle VARCHAR(15),
   IdCours VARCHAR(10),
   VolHSalle DECIMAL(3,2) NOT NULL,
   DureeMinSalle INT NOT NULL DEFAULT 1,
   PRIMARY KEY(IdContSalle),
   FOREIGN KEY(TypeSalle) REFERENCES TypesSalles(TypeSalle),
   FOREIGN KEY(IdCours) REFERENCES Cours(IdCours)
);

CREATE TABLE IncompatibilitesChoix(
   IdEns1 VARCHAR(10),
   IdEns2 VARCHAR(10),
   PRIMARY KEY(IdEns1, IdEns2),
   FOREIGN KEY(IdEns1) REFERENCES Enseignements(IdEns),
   FOREIGN KEY(IdEns2) REFERENCES Enseignements(IdEns)
);

CREATE TABLE Unites(
   Unite VARCHAR(10) CHECK (Unite LIKE 'U%'),
   Semaine CHAR(1) CHECK (Semaine IN ('A', 'B')),
   Horaire CHAR(4) CHECK (Horaire LIKE '[A-Z]{3}[1-9]'),
   IdSalle VARCHAR(10) CHECK (IdSalle LIKE 'SAL%'),
   IdContSalle VARCHAR(10),
   PRIMARY KEY(Unite),
   FOREIGN KEY(Horaire) REFERENCES Horaires(Horaire),
   FOREIGN KEY(IdContSalle) REFERENCES ContraintesSalles(IdContSalle),
   FOREIGN KEY(IdSalle) REFERENCES Salles(IdSalle)
);

CREATE OR REPLACE VIEW DivisionCount
AS
   SELECT D.IdDiv, COUNT(IdEleve) EffectifReelDiv
   FROM Divisions D LEFT JOIN Eleves E ON D.IdDiv = E.IdDiv
   GROUP BY D.IdDiv;

CREATE OR REPLACE VIEW GroupCount
AS
   SELECT G.IdGrp, COUNT(IdEleve) EffectifReelGrp
   FROM Groupes G LEFT JOIN CompoGroupes C ON G.IdGrp = C.IdGrp
   GROUP BY G.IdGrp;

CREATE OR REPLACE VIEW GroupDivCount
AS
   SELECT G.IdGrp, COUNT(IdDiv) NbDivAssociees
   FROM Groupes G LEFT JOIN LiensGroupes L ON G.IdGrp = L.IdGrp
   GROUP BY G.IdGrp;

CREATE OR REPLACE VIEW LibellesCours
AS
   SELECT C.IdCours, C.IdDiv, C.IdGrp, C.IdProf, C.IdEns, LibelleEns, NomProf, PrenomProf, LibelleDiv, LibelleGrp
   FROM (((Cours C JOIN Enseignements E ON C.IdEns = E.IdEns)
         JOIN Enseignants P ON C.IdProf = P.IdProf)
         LEFT JOIN Divisions D ON C.IdDiv = D.IdDiv)
         LEFT JOIN Groupes G ON C.IdGrp = G.IdGrp;

CREATE OR REPLACE VIEW LibellesDiv
AS
   SELECT IdGrp, G.IdDiv, LibelleDiv
   FROM LiensGroupes G JOIN Divisions D ON G.IdDiv = D.IdDiv;

CREATE OR REPLACE VIEW EnsOption
AS
   SELECT *
   FROM Enseignements
   WHERE OptionEns IS true;

CREATE OR REPLACE VIEW HoraireDebutMatin
AS
   SELECT UNIQUE TIME_FORMAT(HeureDebut, '%H:%i') HeureDebut
   FROM Horaires
   WHERE Horaire LIKE "__M_";

CREATE OR REPLACE VIEW HoraireDebutAprem
AS
   SELECT UNIQUE TIME_FORMAT(HeureDebut, '%H:%i') HeureDebut
   FROM Horaires
   WHERE Horaire LIKE "__S_";

CREATE OR REPLACE VIEW GroupeLV1
AS
   SELECT IdEleve, C.IdGrp
   FROM CompoGroupes C JOIN GROUPES G on C.IdGrp = G.IdGrp
   WHERE LibelleGrp LIKE "%LV1%";

CREATE OR REPLACE VIEW GroupeLV2
AS
   SELECT IdEleve, C.IdGrp
   FROM CompoGroupes C JOIN GROUPES G on C.IdGrp = G.IdGrp
   WHERE LibelleGrp LIKE "%LV2%";

CREATE OR REPLACE VIEW VolumeHProf
AS
   SELECT T.IdProf, SUM(DECODE_ORACLE(VolHSalle, NULL, 0, VolHSalle)) VolHReelProf
   FROM (Enseignants T LEFT JOIN Cours E ON T.IdProf = E.IdProf)
         LEFT JOIN  ContraintesSalles Cs ON E.IdCours = Cs.IdCours
   GROUP BY T.IdProf;

CREATE OR REPLACE VIEW VolumeHIntermedProf
AS
   SELECT T.IdProf, SUM(VolHEns) VolHCalcProf
   FROM (Enseignants T LEFT JOIN Cours C ON T.IdProf = C.IdProf)
         LEFT JOIN  Enseignements E ON C.IdEns = E.IdEns
   GROUP BY T.IdProf;


CREATE OR REPLACE VIEW CoursDivisions
AS
   SELECT D.IdDiv, COUNT(IdEns) NbReel
   FROM Divisions D LEFT JOIN Cours C ON D.IdDiv = C.IdDiv
   GROUP BY D.IdDiv;

CREATE OR REPLACE VIEW CoursNiveau
AS 
   SELECT NiveauEns, COUNT(IdEns) NbCible
   FROM Enseignements 
   WHERE OptionEns IS false
   GROUP BY NiveauEns;

CREATE OR REPLACE VIEW OptionCount
AS
   SELECT E.IdEns, LibelleEns, NiveauEns, COUNT(IdEleve) Inscrits
   FROM Options O RIGHT JOIN EnsOption E ON O.IdEns = E.IdEns
   GROUP BY E.IdEns, LibelleEns, NiveauEns;

CREATE OR REPLACE VIEW VolumeDivSalle
AS
   SELECT IdDiv, IdEns, ROUND(DECODE_ORACLE(IdGrp, NULL, VolHSalle, VolHSalle/2), 2) VolHSalle
   FROM Cours C LEFT JOIN ContraintesSalles S ON C.IdCours = S.IdCours
   WHERE IdDiv IS NOT NULL;

CREATE OR REPLACE VIEW VolumeCoursDivSalle
AS
   SELECT IdDiv, IdEns, SUM(VolHSalle) VolTotSalle
   FROM VolumeDivSalle
   GROUP BY IdDiv, IdEns;
   

CREATE OR REPLACE VIEW VolumeCoursGrpSalle
AS
   SELECT IdDiv, IdGrp, IdEns, SUM(VolHSalle) VolTotSalle
   FROM Cours C LEFT JOIN ContraintesSalles S ON C.IdCours = S.IdCours
   WHERE IdGrp IS NOT NULL
   GROUP BY IdDiv, IdGrp, IdEns;


CREATE OR REPLACE VIEW VolumeDivTot
AS
   SELECT IdDiv, SUM(VolHSalle) VolTotSalle
   FROM VolumeDivSalle
   GROUP BY IdDiv;

CREATE OR REPLACE VIEW VolumeNiveauTot
AS
   SELECT NiveauEns, SUM(VolHEns) VolTotEns
   FROM Enseignements
   WHERE OptionEns IS false
   GROUP BY NiveauEns;

CREATE OR REPLACE VIEW UpdateTimes
AS 
	SELECT TABLE_NAME, UPDATE_TIME
	FROM   information_schema.tables;
	   