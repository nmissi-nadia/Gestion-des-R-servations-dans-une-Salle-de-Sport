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
    nom_Activite VARCHAR(100) NOT NULL,
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
    FOREIGN KEY (idmembre) REFERENCES membres(id_Membre) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idactivite) REFERENCES activite(id_Activite) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Insertion dans les tables
-- table membre
INSERT INTO membres (nom, prenom, mail, telephone) 
VALUES ('NMISSI', 'Nadia', 'nmissi@example.com', '0612345678');

-- table activite
INSERT INTO activite (nom_Activite, description, capacite, date_debut, date_fin, disponibilite) 
VALUES ('Yoga', 'Séance de yoga pour tous niveaux', 20, '2024-12-15', '2024-12-30', 1);

-- table reservation 
INSERT INTO reservations (idmembre, idactivite, date_reservation, statut) 
VALUES (2, 3, '2024-12-10 15:30:00', 'Confirmée');


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

-- table activite
UPDATE activite 
SET capacite = 25 
WHERE id_Activite = 1;

-- table reservation
UPDATE reservations 
SET statut = 'Annulée' 
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
-- Afficher toutes les réservations avec les informations des membres et des activités
SELECT 
    reservations.id_reservation,
    membres.nom AS nom_membre,
    membres.prenom AS prenom_membre,
    activite.nom_Activite AS nom_activite,
    reservations.date_reservation,
    reservations.statut
FROM 
    reservations
JOIN 
    membres ON reservations.idmembre = membres.id_Membre
JOIN 
    activite ON reservations.idactivite = activite.id_Activite;
--  Lister les membres qui ont réservé une activité spécifique
SELECT 
    membres.id_Membre,
    membres.nom,
    membres.prenom,
    activite.nom_Activite
FROM 
    reservations
JOIN 
    membres ON reservations.idmembre = membres.id_Membre
JOIN 
    activite ON reservations.idactivite = activite.id_Activite
WHERE 
    activite.nom_Activite = 'Nom de l activité';

-- Lister toutes les activités avec le nombre de réservations associées
SELECT 
    activite.nom_Activite,
    COUNT(reservations.id_reservation) AS nombre_reservations
FROM 
    activite
JOIN 
    reservations ON activite.id_Activite = reservations.idactivite
GROUP BY 
    activite.nom_Activite;
-- Trouver les membres qui n'ont jamais fait de réservation
SELECT 
    membres.id_Membre,
    membres.nom,
    membres.prenom
FROM 
    membres
LEFT JOIN 
    reservations ON membres.id_Membre = reservations.idmembre
WHERE 
    reservations.idmembre IS NULL;
-- Lister toutes les activités et leurs informations, même si elles n'ont aucune réservation
SELECT 
    activite.id_Activite,
    activite.nom_Activite,
    activite.description,
    activite.capacite,
    activite.disponibilite,
    COUNT(reservations.id_reservation) AS nombre_reservations
FROM 
    activite
LEFT JOIN 
    reservations ON activite.id_Activite = reservations.idactivite
GROUP BY 
    activite.id_Activite;
