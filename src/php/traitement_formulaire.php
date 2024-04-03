<?php
// Connexion à la base de données
$servername = "localhost"; // Remplacez par le nom de votre serveur MySQL
$username = "votre_nom_utilisateur"; // Remplacez par votre nom d'utilisateur MySQL
$password = "votre_mot_de_passe"; // Remplacez par votre mot de passe MySQL
$dbname = "nom_de_votre_base_de_donnees"; // Remplacez par le nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

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

if ($conn->query($sql) === TRUE) {
    echo "Utilisateur ajouté avec succès.";
} else {
    echo "Erreur lors de l'ajout de l'utilisateur : " . $conn->error;
}

// Fermer la connexion
$conn->close();
?>
