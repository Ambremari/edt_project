CREATE TEMPORARY TABLE planning(
   Unite VARCHAR(10),
   Semaine CHAR(1),
   Horaire CHAR(4),
   IdSalle VARCHAR(10),
   PRIMARY KEY(Unite)
);

LOAD DATA INFILE 'planning_generation\planning.csv' 
INTO TABLE planning FIELDS TERMINATED BY ';' ENCLOSED BY '"' LINES TERMINATED BY '\n' (Unite, Semaine, Horaire, IdSalle); 

UPDATE planning
SET semaine = NULL
WHERE semaine = "9";

UPDATE Unites
INNER JOIN planning Maj on Maj.Unite= Unites.Unite
SET Unites.Semaine = Maj.Semaine, 
Unites.Horaire = Maj.Horaire,
Unites.IdSalle = Maj.IdSalle; 

DROP TEMPORARY TABLE planning;