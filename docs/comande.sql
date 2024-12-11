-- Creation d'une base de donnee
create database salle_sport;
-- utilisation de base se donnes
use salle_sport ;
-- creation des tables dans la base de donnees
-- table du mebre
create table membres (
    id_Membre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    mail VARCHAR(100) NOT NULL UNIQUE,
    telephone VARCHAR(15)
);
-- table  des activités
CREATE TABLE activite (
    id_Activite INT AUTO_INCREMENT PRIMARY KEY,
    nom_Activité VARCHAR(100) NOT NULL,
    description TEXT,
    capacite INT,
    date_debut DATE,
    date_fin DATE,
    disponibilite TINYINT(1) DEFAULT 1
);
-- table de reservation
CREATE TABLE reservations (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    idmembre INT NOT NULL,
    idactivite INT NOT NULL,
    date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('Confirmée', 'Annulée') DEFAULT 'Confirmée',
    FOREIGN KEY (idmembre) REFERENCES membres(id_Membre) ON DELETE CASCADE,
    FOREIGN KEY (idactivite) REFERENCES activite(id_Activite) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Insertion dans les tables
-- table membre
INSERT INTO membres (nom, prenom, mail, telephone) 
VALUES ('NMISSI', 'Nadia', 'nmissi@example.com', '0612345678');
INSERT INTO membres (nom, prenom, mail, telephone) 
VALUES ('EL HAMRAOUI', 'Fatima', 'elhamraoui@example.com', '0654321987');
INSERT INTO membres (nom, prenom, mail, telephone) 
VALUES ('OUAHBI', 'Mohamed', 'ouahbi@example.com', '0678451239');
INSERT INTO membres (nom, prenom, mail, telephone) 
VALUES ('BENHADDOU', 'Salma', 'benhaddou@example.com', '0611223344');


-- table activite
INSERT INTO activite (nom_Activité, description, capacite, date_debut, date_fin, disponibilite) 
VALUES ('Yoga', 'Séance de yoga pour tous niveaux', 20, '2024-12-15', '2024-12-30', 1);
INSERT INTO activite (nom_Activité, description, capacite, date_debut, date_fin, disponibilite) 
VALUES ('Zumba', 'Séance de Zumba énergique et amusante', 30, '2024-12-20', '2025-01-05', 1);
INSERT INTO activite (nom_Activité, description, capacite, date_debut, date_fin, disponibilite) 
VALUES ('Musculation', 'Accès aux équipements de musculation', 15, '2024-12-01', '2024-12-31', 1);
INSERT INTO activite (nom_Activité, description, capacite, date_debut, date_fin, disponibilite) 
VALUES ('Natation', 'Cours de natation pour débutants', 10, '2024-12-10', '2024-12-25', 1);

-- table reservation 
INSERT INTO reservations (idmembre, idactivite, date_reservation, statut) 
VALUES (2, 3, '2024-12-10 15:30:00', 'Confirmée');
INSERT INTO reservations (idmembre, idactivite, date_reservation, statut) 
VALUES (3, 1, '2024-12-12 14:00:00', 'Annulée');
INSERT INTO reservations (idmembre, idactivite, date_reservation, statut) 
VALUES (2, 2, '2024-12-18 16:30:00', 'Confirmée');
INSERT INTO reservations (idmembre, idactivite, date_reservation, statut) 
VALUES (1, 3, '2024-12-22 09:00:00', 'Confirmée');


-- Afichage dans les tables
-- table membre
SELECT * FROM membres;

-- table activite
SELECT * FROM activite;

-- table reservation 
SELECT * FROM reservations;


-- update dans les tables
-- table membre
UPDATE membres 
SET telephone = '0698765432' 
WHERE id_Membre = 1;
UPDATE membres 
SET telephone = '0701234567' 
WHERE id_Membre = 2;
UPDATE membres 
SET mail = 'fatima.elhamraoui@example.com' 
WHERE id_Membre = 3;
UPDATE membres 
SET nom = 'BENHADDOU' 
WHERE id_Membre = 4;

-- table activite
UPDATE activite 
SET capacite = 25 
WHERE id_Activite = 1;
UPDATE activite 
SET capacite = 40 
WHERE id_Activite = 2;

UPDATE activite 
SET date_fin = '2025-01-15' 
WHERE id_Activite = 1;

UPDATE activite 
SET disponibilite = 0 
WHERE id_Activite = 3;

-- table reservation
UPDATE reservations 
SET statut = 'Annulée' 
WHERE id_reservation = 1;
UPDATE reservations 
SET statut = 'Confirmée' 
WHERE id_reservation = 2;

UPDATE reservations 
SET date_reservation = '2024-12-24 11:00:00' 
WHERE id_reservation = 3;

UPDATE reservations 
SET idmembre = 4 
WHERE id_reservation = 1;


-- suppression dans les tables
-- table membre
DELETE FROM membres 
WHERE id_Membre = 1;

-- table activite
DELETE FROM activite 
WHERE id_Activite = 1;

-- table reservation 
DELETE FROM reservations 
WHERE id_reservation = 1;


-- Requtes avec jointures 

SELECT reservations.date_reservation, reservations.statut, activite.nom_Activité
FROM reservations 
JOIN activite 
ON reservations.idactivite = activite.id_Activite;

-- Afficher toutes les réservations avec les informations des membres et des activités
SELECT 
    reservations.id_reservation,
    membres.nom AS nom_membre,
    membres.prenom AS prenom_membre,
    activite.nom_Activité AS nom_activite,
    reservations.date_reservation,
    reservations.statut
FROM 
    reservations
JOIN 
    membres ON reservations.idmembre = membres.id_Membre
JOIN 
    activite ON reservations.idactivite = activite.id_Activite;
