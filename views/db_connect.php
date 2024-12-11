<?php
// Paramètres de connexion à la base de données
$host = 'localhost'; 
$dbname = 'salle_sport';
$username = 'root';
$password = '';

try {
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Définir le mode d'erreur de PDO pour afficher les exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Afficher un message si la connexion est réussie
    // echo "Connexion réussie à la base de données.";
} catch (PDOException $e) {
    // Afficher un message si la connexion échoue
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
