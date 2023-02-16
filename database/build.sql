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
   IdParent VARCHAR(10) ,
   NomParent VARCHAR(15)  NOT NULL,
   PrenomParent VARCHAR(15)  NOT NULL,
   MailParent VARCHAR(40) ,
   MdpParent TEXT,
   PRIMARY KEY(IdParent)
);

CREATE TABLE Divisions(
   IdDiv VARCHAR(10) ,
   LibelleDiv VARCHAR(10)  NOT NULL,
   NiveauDiv CHAR(4)  NOT NULL,
   EffectifPrevDiv INT NOT NULL DEFAULT 35,
   PRIMARY KEY(IdDiv)
);

CREATE TABLE Enseignements(
   IdEns VARCHAR(10) ,
   LibelleEns VARCHAR(15)  NOT NULL,
   NiveauEns CHAR(4)  NOT NULL,
   VolHEns DECIMAL(3,1)   NOT NULL,
   DureeMinEns INT NOT NULL DEFAULT 1,
   OptionEns BOOLEAN NOT NULL DEFAULT 0,
   PRIMARY KEY(IdEns)
);

CREATE TABLE Enseignants(
   IdProf VARCHAR(10) ,
   NomProf VARCHAR(15)  NOT NULL,
   PrenomProf VARCHAR(15)  NOT NULL,
   MdpProf TEXT,
   MailProf VARCHAR(40) ,
   VolHProf DECIMAL(3,1)   NOT NULL,
   PRIMARY KEY(IdProf)
);

CREATE TABLE Horaires(
   Horaire CHAR(4) ,
   Jour VARCHAR(10)  NOT NULL,
   HeureDebut TIME NOT NULL,
   HeureFin TIME NOT NULL,
   PRIMARY KEY(Horaire)
);

CREATE TABLE TypeSalles(
   TypeSalle VARCHAR(10) ,
   PRIMARY KEY(TypeSalle)
);

CREATE TABLE Salles(
   IdSalle VARCHAR(10) ,
   LibelleSalle VARCHAR(15) ,
   CapSalle INT NOT NULL,
   TypeSalle VARCHAR(10) ,
   PRIMARY KEY(IdSalle),
   FOREIGN KEY(TypeSalle) REFERENCES TypeSalles(TypeSalle)
);

CREATE TABLE Eleves(
   IdEleve VARCHAR(10) ,
   NomEleve VARCHAR(15)  NOT NULL,
   PrenomEleve VARCHAR(15)  NOT NULL,
   MdpEleve TEXT,
   AnneeNaisEleve DATE,
   NiveauEleve VARCHAR(4)  NOT NULL,
   IdDiv VARCHAR(10) ,
   PRIMARY KEY(IdEleve),
   FOREIGN KEY(IdDiv) REFERENCES Divisions(IdDiv)
);

CREATE TABLE Cours(
   IdCours VARCHAR(10) ,
   IdEns VARCHAR(10) ,
   IdProf VARCHAR(10) ,
   IdDiv VARCHAR(10) ,
   PRIMARY KEY(IdCours),
   FOREIGN KEY(IdEns) REFERENCES Enseignements(IdEns),
   FOREIGN KEY(IdProf) REFERENCES Enseignants(IdProf),
   FOREIGN KEY(IdDiv) REFERENCES Divisions(IdDiv)
);

CREATE TABLE ContraintesEns(
   IdEns VARCHAR(10) ,
   Horaire CHAR(4) ,
   Prio INT,
   PRIMARY KEY(IdEns, Horaire),
   FOREIGN KEY(IdEns) REFERENCES Enseignements(IdEns),
   FOREIGN KEY(Horaire) REFERENCES Horaires(Horaire)
);

CREATE TABLE ContraintesProf(
   IdProf VARCHAR(10) ,
   Horaire CHAR(4) ,
   Prio INT,
   PRIMARY KEY(IdProf, Horaire),
   FOREIGN KEY(IdProf) REFERENCES Enseignants(IdProf),
   FOREIGN KEY(Horaire) REFERENCES Horaires(Horaire)
);

CREATE TABLE Parentes(
   IdParent VARCHAR(10) ,
   IdEleve VARCHAR(10) ,
   PRIMARY KEY(IdParent, IdEleve),
   FOREIGN KEY(IdParent) REFERENCES Parents(IdParent),
   FOREIGN KEY(IdEleve) REFERENCES Eleves(IdEleve)
);

CREATE TABLE ContraintesSalles(
   TypeSalle VARCHAR(10) ,
   IdCours VARCHAR(10) ,
   VolHSalle DECIMAL(3,2)   NOT NULL,
   PRIMARY KEY(TypeSalle, IdCours),
   FOREIGN KEY(TypeSalle) REFERENCES TypeSalles(TypeSalle),
   FOREIGN KEY(IdCours) REFERENCES Cours(IdCours)
);

CREATE TABLE Unites(
   Unite VARCHAR(10) ,
   Semaine CHAR(1) ,
   Horaire CHAR(4) ,
   IdSalle VARCHAR(10) ,
   TypeSalle VARCHAR(10) ,
   IdCours VARCHAR(10) ,
   PRIMARY KEY(Unite),
   FOREIGN KEY(Horaire) REFERENCES Horaires(Horaire),
   FOREIGN KEY(TypeSalle, IdCours) REFERENCES ContraintesSalles(TypeSalle, IdCours),
   FOREIGN KEY(IdCours) REFERENCES Cours(IdCours)
);


