DROP TABLE IF EXISTS Unites;
DROP TABLE IF EXISTS ContraintesSalles;
DROP TABLE IF EXISTS Parentes;
DROP TABLE IF EXISTS ContraintesProf;
DROP TABLE IF EXISTS ContraintesEns;
DROP TABLE IF EXISTS Cours;
DROP TABLE IF EXISTS Eleves;
DROP TABLE IF EXISTS Salles;
DROP TABLE IF EXISTS TypeSalles;
DROP TABLE IF EXISTS Horaires;
DROP TABLE IF EXISTS Enseignants;
DROP TABLE IF EXISTS Enseignements;
DROP TABLE IF EXISTS Divisions;
DROP TABLE IF EXISTS Parents;

CREATE TABLE Parents(
   IdParent VARCHAR(10) CHECK(IdParent LIKE 'PRT%'),
   NomParent VARCHAR(15) NOT NULL,
   PrenomParent VARCHAR(15) NOT NULL,
   MailParent VARCHAR(40) CHECK (MailParent LIKE '%@%.%'),
   MdpParent TEXT CHECK(LEN(MdpParent))>=8 AND LEN(MdpParent) <=20,
   PRIMARY KEY(IdParent)
);

CREATE TABLE Divisions(
   IdDiv VARCHAR(10) CHECK (IdDiv LIKE 'DIV%'),
   LibelleDiv VARCHAR(10) NOT NULL,
   NiveauDiv CHAR(4) CHECK (NiveauDiv IN ('6EME', '5EME', '4EME', '3EME')),
   EffectifPrevDiv INT NOT NULL DEFAULT 35,
   PRIMARY KEY(IdDiv)
);

CREATE TABLE Enseignements(
   IdEns VARCHAR(10) CHECK (IdEns LIKE 'ENS%'),
   LibelleEns VARCHAR(15) NOT NULL,
   NiveauEns CHAR(4) CHECK(NiveauEns IN ('6EME', '5EME', '4EME', '3EME')),
   VolHEns DECIMAL(3,1) NOT NULL,
   DureeMinEns INT NOT NULL DEFAULT 1,
   OptionEns BOOLEAN NOT NULL DEFAULT 'false',
   PRIMARY KEY(IdEns)
);

CREATE TABLE Enseignants(
   IdProf VARCHAR(10) CHECK (IdProf LIKE 'PRF%'),
   NomProf VARCHAR(15) NOT NULL,
   PrenomProf VARCHAR(15) NOT NULL,
   MdpProf TEXT CHECK (LEN(MdpProf))>=8 AND LEN(MdpProf) <=20,
   MailProf VARCHAR(40) CHECK (MailProf LIKE '%@college-VH.com'),
   VolHProf DECIMAL(3,1) NOT NULL,
   PRIMARY KEY(IdProf)
);

CREATE TABLE Horaires(
   Horaire CHAR(4) CHECK (Horaire LIKE '[A-Z]{3}[1-9]'),
   Jour VARCHAR(10) CHECK (Jour IN ('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi')),
   HeureDebut TIME NOT NULL,
   HeureFin TIME NOT NULL,
   PRIMARY KEY(Horaire)
);

CREATE TABLE TypeSalles(
   TypeSalle VARCHAR(10) CHECK (TypeSalle IN('Cours','TP','Sport')),
   PRIMARY KEY(TypeSalle)
);

CREATE TABLE Salles(
   IdSalle VARCHAR(10) CHECK (IdSalle LIKE 'SAL%'),
   LibelleSalle VARCHAR(15) CHECK (LibelleSalle LIKE 'Salle %'),
   CapSalle INT NOT NULL,
   TypeSalle VARCHAR(10) CHECK (TypeSalle IN('Cours','TP','Sport')),
   PRIMARY KEY(IdSalle),
   FOREIGN KEY(TypeSalle) REFERENCES TypeSalles(TypeSalle)
);

CREATE TABLE Eleves(
   IdEleve VARCHAR(10) CHECK (IdEleve LIKE 'ELV%'),
   NomEleve VARCHAR(15)  NOT NULL,
   PrenomEleve VARCHAR(15)  NOT NULL,
   MdpEleve TEXT CHECK(LEN(MdpEleve))>=8 AND LEN(MdpEleve) <=20,
   AnneeNaisEleve DATE CHECK (AnneNaisEleve>2000 AND AnneNaisEleve<2100),
   NiveauEleve VARCHAR(4)  CHECK (NiveauEleve LIKE '%EME'),
   IdDiv VARCHAR(10) CHECK (IdDiv LIKE 'DIV'%),
   PRIMARY KEY(IdEleve),
   FOREIGN KEY(IdDiv) REFERENCES Divisions(IdDiv)
);

CREATE TABLE Cours(
   IdCours VARCHAR(10) CHECK (IdCours LIKE 'CR%'),
   IdEns VARCHAR(10) CHECK (IdEns LIKE 'ENS%'),
   IdProf VARCHAR(10) CHECK (IdProf LIKE 'PRF%'),
   IdDiv VARCHAR(10) CHECK (IdDiv LIKE 'DIV%'),
   PRIMARY KEY(IdCours),
   FOREIGN KEY(IdEns) REFERENCES Enseignements(IdEns),
   FOREIGN KEY(IdProf) REFERENCES Enseignants(IdProf),
   FOREIGN KEY(IdDiv) REFERENCES Divisions(IdDiv)
);

CREATE TABLE ContraintesEns(
   IdEns VARCHAR(10) CHECK (IdEns LIKE 'ENS%'),
   Horaire CHAR(4) CHECK (Horaire LIKE '[A-Z]{3}[1-9]'),
   Prio INT CHECK (Prio IN('1','2','3')),
   PRIMARY KEY(IdEns, Horaire),
   FOREIGN KEY(IdEns) REFERENCES Enseignements(IdEns),
   FOREIGN KEY(Horaire) REFERENCES Horaires(Horaire)
);

CREATE TABLE ContraintesProf(
   IdProf VARCHAR(10) CHECK (IdProf LIKE 'PRF%'),
   Horaire CHAR(4) CHECK (Horaire LIKE '[A-Z]{3}[1-9]'),
   Prio INT CHECK (Prio IN('1','2','3')),
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
   TypeSalle VARCHAR(10) CHECK (TypeSalle IN('Cours','TP','Sport')),
   IdCours VARCHAR(10) CHECK (IdCours LIKE 'CR%'),
   VolHSalle DECIMAL(3,2) NOT NULL,
   PRIMARY KEY(TypeSalle, IdCours),
   FOREIGN KEY(TypeSalle) REFERENCES TypeSalles(TypeSalle),
   FOREIGN KEY(IdCours) REFERENCES Cours(IdCours)
);

CREATE TABLE Unites(
   Unite VARCHAR(10) CHECK (Unite LIKE 'U%'),
   Semaine CHAR(1) CHECK (Semaine IN ('A', 'B')),
   Horaire CHAR(4) CHECK (Horaire LIKE '[A-Z]{3}[1-9]'),
   IdSalle VARCHAR(10) CHECK (IdSalle LIKE 'SAL%'),
   TypeSalle VARCHAR(10) CHECK (TypeSalle IN('Cours','TP','Sport')),
   IdCours VARCHAR(10) CHECK (IdCours LIKE 'CR%'),
   PRIMARY KEY(Unite),
   FOREIGN KEY(Horaire) REFERENCES Horaires(Horaire),
   FOREIGN KEY(IdSalle, TypeSalle) REFERENCES ContraintesSalles(IdSalle, TypeSalle),
   FOREIGN KEY(IdCours) REFERENCES Cours(IdCours)
);


