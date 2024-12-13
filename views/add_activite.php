<?php 

include "db_connect.php"; // Inclusion de la connexion à la base de données
        
// Récupération des valeurs du formulaire via POST
$nom = $_POST['nom']; 
$descriptionn = $_POST['description'];
$capacite = $_POST['capacite'];
$date_debut = $_POST['date_debut'];
$date_fin = $_POST['date_fin'];

try {
    // Insertion de l'activité dans la base de données avec requête préparée
    $stmt = $conn->prepare("INSERT INTO activite (nom_Activité, description, capacite, date_debut, date_fin) 
                            VALUES (?, ?, ?, ?, ?)");
    
    $stmt->execute([
        $nom,
        $descriptionn,
        $capacite,
        $date_debut,
        $date_fin
    ]);

    // Afficher un message d'alerte après la redirection
    echo '<script>alert("Activité ajoutée avec succès !");</script>';
    
    // Rediriger l'utilisateur vers la page admin
    header("Location: admin.php");
    exit(); // Assurez-vous de ne pas exécuter d'autres instructions après la redirection

} catch (PDOException $e) {
    echo '<script>alert("Erreur lors de l\'ajout de l\'activité : ' . $e->getMessage() . '");</script>';
}
?>
