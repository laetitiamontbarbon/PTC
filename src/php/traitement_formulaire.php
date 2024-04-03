<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion à la base de données
$host =  $_ENV['DB_HOST'];  // Adresse du serveur MySQL
$user = $_ENV['DB_USER'];  // Nom d'utilisateur MySQL
$password = $_ENV['DB_PASSWORD'];  // Mot de passe MySQL
$database = $_ENV['DB_DB'];  // Nom de la base de données

// Création de la connexion
$conn = new mysqli($host, $user, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mail = $_POST['mail'];
$tagNFC = $_POST['tagNFC'];

// Requête d'insertion dans la table Utilisateur
$sql = "INSERT INTO Utilisateur (nom, prenom, mail, clef_id, clickshare_id)
        VALUES ('$nom', '$prenom', '$mail', (SELECT clef_id FROM Clef WHERE tagNFC = '$tagNFC'), (SELECT clickshare_id FROM Clickshare WHERE tagNFC = '$tagNFC'))";

// Afficher la requête SQL pour débogage
echo "Requête SQL: $sql<br>"

if ($conn->query($sql) === TRUE) {
    echo "Utilisateur ajouté avec succès.";
} else {
    echo "Erreur lors de l'ajout de l'utilisateur : " . $conn->error;
}

// Fermer la connexion
$conn->close();
?>
