<?php
// Paramètres de connexion à la base de données
$host = 'localhost'; 
$dbname = 'salle_sport';
$username = 'root';
$password = '';

try {
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "<script> alert('Connexion réussie à la base de données.');</script>";
} catch (PDOException $e) {
   
    die("<script>alert('Erreur de connexion à la base de données : ');</script>" . $e->getMessage());
}
?>
