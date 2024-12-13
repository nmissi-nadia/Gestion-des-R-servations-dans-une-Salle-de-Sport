# Gestion-des-R-servations-dans-une-Salle-de-Sport
Ce projet focalise sur le développement d'une interface de gestion des clients d'une Salle de Sport en utilisant PHP et SQL


## Description du Projet
Une salle de sport souhaite moderniser son système de gestion en mettant en place une application web. Actuellement, toutes les opérations sont réalisées manuellement, ce qui entraîne des erreurs et des difficultés dans la gestion quotidienne.

 Le but est de créer un outil simple pour :


Gérer les membres inscrits à la salle.

Planifier et afficher les activités ou équipements disponibles.

Permettre aux membres de réserver des activités ou des équipements.

## Fonctionnalités Principales

### **Gestion des Membres**  

- **Ajout d'un membre** : L'administrateur peut ajouter un nouveau membre en remplissant un formulaire contenant les champs suivants :  
  - Nom du membre  
  - Prénom  
  - Adresse e-mail  
  - Numéro de téléphone  

- **Affichage de la liste des membres** : Une table affiche tous les membres enregistrés avec leurs informations complètes, y compris leur nom, prénom, e-mail et téléphone.  

- **Suppression d'un membre** : Chaque membre peut être supprimé via un bouton **"Supprimer"**. Une confirmation de suppression est prévue pour éviter toute suppression accidentelle.  

### **Gestion des activité** 
- **Ajout d'une activité** : L'administrateur peut ajouter une nouvelle activité en renseignant un formulaire avec les champs suivants :
  - Nom de l'activité
  - Description
  - Capacité
  - Date de début
  - Date de fin
  
- **Affichage de la liste des activités** : Une table affiche toutes les activités créées avec leurs détails complets.

- **Suppression d'une activité** : Chaque activité peut être supprimée via un bouton "Supprimer". Une confirmation de suppression est prévue.

### **Gestion des Réservations**  

- **Ajout d'une réservation** : Les membres peuvent créer une réservation en choisissant une activité et en remplissant les informations nécessaires, comme la date et l'état de la réservation.  

- **Affichage de la liste des réservations** : Une table affiche toutes les réservations, y compris les détails suivants :  
  - Identifiant de la réservation  
  - Identifiant du membre  
  - Identifiant de l'activité  
  - Date de la réservation  
  - Statut de la réservation (Confirmée / Annulée)  

- **Suppression d'une réservation** : Chaque réservation peut être supprimée via un bouton **"Supprimer"**. Une confirmation de suppression est incluse pour prévenir les erreurs accidentelles.  

---

## Structure de la Base de Données
**Table : membres**  
```sql
CREATE TABLE membres (
    id_membre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    telephone VARCHAR(20) NOT NULL
);
```

**Table : activite**
```sql
CREATE TABLE activite (
    id_Activite INT AUTO_INCREMENT PRIMARY KEY,
    nom_Activité VARCHAR(100) NOT NULL,
    description TEXT,
    capacite INT,
    date_debut DATE,
    date_fin DATE,
    disponibilite TINYINT(1) DEFAULT 1
);
```
**Table : reservations**  
```sql
CREATE TABLE reservations (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    idmembre INT NOT NULL,
    idactivite INT NOT NULL,
    date_reservation DATETIME NOT NULL,
    statut ENUM('Confirmée', 'Annulée') DEFAULT 'Confirmée',
    FOREIGN KEY (idmembre) REFERENCES membres(id_membre),
    FOREIGN KEY (idactivite) REFERENCES activite(id_Activite)
);
```

### Champs de la table

### **Table Membre**  
- **id_membre** : Identifiant unique du membre (Primary Key).  
- **nom** : Nom du membre.  
- **prenom** : Prénom du membre.  
- **email** : Adresse e-mail du membre (doit être unique).  
- **telephone** : Numéro de téléphone du membre.  

---
### **Table Activite** 
- **id_Activite** : Identifiant unique de l'activité (Primary Key).
- **nom_Activité** : Nom de l'activité.
- **description** : Description détaillée de l'activité.
- **capacite** : Nombre maximum de participants.
- **date_debut** : Date de début de l'activité.
- **date_fin** : Date de fin de l'activité.
- **disponibilite** : Indicateur de la disponibilité (1 = disponible, 0 = non disponible).

---

### **Table reservations**  
- **id_reservation** : Identifiant unique de la réservation (Primary Key).  
- **idmembre** : Identifiant du membre associé à la réservation (clé étrangère de la table `membres`).  
- **idactivite** : Identifiant de l'activité associée à la réservation (clé étrangère de la table `activite`).  
- **date_reservation** : Date et heure de la réservation.  
- **statut** : Statut de la réservation (Confirmée ou Annulée).  

---


## Structure des Fichiers
```
/
|-- index.php              # Page contient lien vers page principale
|-- Doc                     # Dossier contient docummentation pour le projet
|-- views                  # Dossiers contenant les pages web 
    |-- admin.php          # Page principale de gestion des membres et activités et les résevations
    |-- db_connect.php     # Fichier de connexion à la base de données
    |-- add_activite.php   # Page permettant d'ajout d'une activité
    |-- membre.php         # Page permettant de supprimer une activité
|-- assets/                # Dossier contenant les fichiers CSS, JS et images
```

## Installation
1. **Cloner le dépôt** :
   ```bash
   git clone https://github.com/nmissi-nadia/Gestion-des-R-servations-dans-une-Salle-de-Sport.git
   cd Gestion-des-R-servations-dans-une-Salle-de-Sport
   ```
2. **Configuration de la base de données** :
   - Créez une base de données MySQL.
   - Importez le fichier `structure.sql` (fourni) pour créer les table.
   
3. **Connexion à la base de données** :
   - Modifiez le fichier `db_connect.php` pour inclure vos informations de connexion MySQL (hôte, utilisateur, mot de passe, nom de la base de données).

4. **Démarrage de l'application** :
   - Lancez un serveur local (XAMPP, WAMP, Laragon ou PHP built-in server) et accédez à `http://localhost/Gestion-des-R-servations-dans-une-Salle-de-Sport/index.html`.

## Exemple de Configuration de db_connect.php
```php
<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=nom_de_votre_base', 'utilisateur', 'mot_de_passe');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
    exit;
}
```

## Sécurité
- **Protection contre les injections SQL** : Utilisation de requêtes préparées.
- **Protection contre les failles XSS** : Utilisation de `htmlspecialchars()` lors de l'affichage des données utilisateur.
- **Validation des entrées** : Contrôle des champs du formulaire avant l'insertion dans la base de données.

## Bonnes Pratiques
- Utilisation de requêtes préparées pour éviter les injections SQL.
- Validation des champs d'entrée avant l'ajout des données dans la base.
- Affichage des messages d'erreur pour aider à débugger.

## Améliorations Futur
- Ajouter une la fonctionnalité du modification pour les membres, les activités et les réservations.
- Ajouter une fonction de recherche d'activité.


## Créé Par
Ce projet a été réalisé par **[NMISSI Nadia](https://github.com/nmissi-nadia)** dans le cadre d'un projet de développement web.

---

