# Gestion-des-R-servations-dans-une-Salle-de-Sport
Ce projet focalise sur le développement d'une interface de gestion des clients d'une Salle de Sport en utilisant PHP et SQL


## Description du Projet
Ce projet est une application web de gestion des activités. L'objectif est de permettre à un administrateur de créer, modifier, supprimer et afficher des activités via une interface web intuitive. Chaque activité comporte des informations essentielles comme le nom, la description, la capacité, la date de début et la date de fin. Le système est conçu pour être rapide, sécurisé et facile à utiliser.

## Fonctionnalités Principales
- **Ajout d'une activité** : L'administrateur peut ajouter une nouvelle activité en renseignant un formulaire avec les champs suivants :
  - Nom de l'activité
  - Description
  - Capacité
  - Date de début
  - Date de fin
  
- **Affichage de la liste des activités** : Une table affiche toutes les activités créées avec leurs détails complets.

- **Modification d'une activité** : Chaque activité peut être modifiée via un bouton "Modifier".

- **Suppression d'une activité** : Chaque activité peut être supprimée via un bouton "Supprimer". Une confirmation de suppression est prévue.

## Structure de la Base de Données
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
### Champs de la table
- **id_Activite** : Identifiant unique de l'activité (Primary Key).
- **nom_Activité** : Nom de l'activité.
- **description** : Description détaillée de l'activité.
- **capacite** : Nombre maximum de participants.
- **date_debut** : Date de début de l'activité.
- **date_fin** : Date de fin de l'activité.
- **disponibilite** : Indicateur de la disponibilité (1 = disponible, 0 = non disponible).

## Structure des Fichiers
```
/
|-- admin.php           # Page principale de gestion des activités
|-- db_connect.php      # Fichier de connexion à la base de données
|-- edit_activite.php   # Page permettant de modifier une activité
|-- delete_activite.php # Page permettant de supprimer une activité
|-- assets/             # Dossier contenant les fichiers CSS, JS et images
```

## Installation
1. **Cloner le dépôt** :
   ```bash
   git clone https://github.com/votre-utilisateur/gestion-activites.git
   cd gestion-activites
   ```
2. **Configuration de la base de données** :
   - Créez une base de données MySQL.
   - Importez le fichier `structure.sql` (fourni) pour créer la table `activite`.
   
3. **Connexion à la base de données** :
   - Modifiez le fichier `db_connect.php` pour inclure vos informations de connexion MySQL (hôte, utilisateur, mot de passe, nom de la base de données).

4. **Démarrage de l'application** :
   - Lancez un serveur local (XAMPP, WAMP, Laragon ou PHP built-in server) et accédez à `http://localhost/gestion-activites/admin.php`.

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

## Captures d'écran
### 1. Formulaire d'ajout d'activité
![Formulaire d'ajout](assets/screenshots/form_ajout.png)

### 2. Liste des activités
![Table des activités](assets/screenshots/liste_activites.png)

## Sécurité
- **Protection contre les injections SQL** : Utilisation de requêtes préparées.
- **Protection contre les failles XSS** : Utilisation de `htmlspecialchars()` lors de l'affichage des données utilisateur.
- **Validation des entrées** : Contrôle des champs du formulaire avant l'insertion dans la base de données.

## Bonnes Pratiques
- Utilisation de requêtes préparées pour éviter les injections SQL.
- Validation des champs d'entrée avant l'ajout des données dans la base.
- Affichage des messages d'erreur pour aider à débugger.

## Améliorations Futur
- Ajouter une pagination pour la liste des activités.
- Ajouter une fonction de recherche d'activité.
- Ajouter une confirmation avant la suppression d'une activité.

## Créé Par
Ce projet a été réalisé par **[Votre Nom]** dans le cadre d'un projet de développement web.

---

## Licence
Ce projet est sous licence MIT - voir le fichier [LICENSE](LICENSE) pour plus de détails.

