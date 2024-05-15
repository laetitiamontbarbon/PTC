<?php

require_once 'config.php';

$titre = 'Connected Locker';
$menuItems = [
    ['href' => 'creationcompte.php', 'text' => 'Créer compte'],
    ['href' => 'utilisateurs.php', 'text' => 'Utilisateurs'],
    ['href' => 'salles.php', 'text' => 'Salles']
];


// Database connection settings
$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_DB'];
$port = 5432;

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;user=$user;password=$password";
    $dbh = new PDO($dsn);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les utilisateurs
    $sql = "SELECT u.Utilisateur_id, u.nom, u.prenom, u.mail, u.est_professeur, u.tag_nfc, s.Salle_id, s.code, s.numero
    FROM Utilisateur u
    LEFT JOIN Utilisateur_Salles us ON u.Utilisateur_id = us.Utilisateur_id
    LEFT JOIN Salles s ON us.Salle_id = s.Salle_id";



    $dbh->beginTransaction(); // Commencer une transaction

    $sth = $dbh->prepare($sql);
    $sth->execute();
    $utilisateurs = $sth->fetchAll(PDO::FETCH_ASSOC); // Fetch data as associative array

    // Pour chaque utilisateur, récupérez les informations des salles associées
    foreach ($utilisateurs as &$utilisateur) {
        $userId = $utilisateur['Utilisateur_id'];
        $sqlSalles = "SELECT s.Salle_id, s.code, s.numero
                    FROM Salles s
                    JOIN Utilisateur_Salles us ON s.Salle_id = us.Salle_id
                    WHERE us.Utilisateur_id = :userId";

        $sthSalles = $dbh->prepare($sqlSalles);
        $sthSalles->bindParam(':userId', $userId, PDO::PARAM_INT);
        $sthSalles->execute();
        $salles = $sthSalles->fetchAll(PDO::FETCH_ASSOC);

        // Ajoutez les informations des salles à l'utilisateur correspondant
        $utilisateur['salle'] = $salles;
    }

    $dbh->commit(); // Valider la transaction


    // Transmettez les données récupérées à votre fichier Twig
    echo $twig->render('utilisateurs.twig', [
    'titre' => $titre,
    'menuItems' => $menuItems,
    'utilisateurs' => $utilisateurs
    ]);


} catch (PDOException $e) {
    echo $e->getCode() . ' ' . $e->getMessage();

}

