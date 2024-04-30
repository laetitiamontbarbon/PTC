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
    $sql = "SELECT 
                Utilisateur_id, nom, prenom, mail
            FROM
                Utilisateur";

    try {
        $dbh->beginTransaction(); // Commencer une transaction

        $sth = $dbh->prepare($sql);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC); // Fetch data as associative array

        // Pas besoin de commit ici, car il n'y a pas de modification de la base de données

        // Transmettez les données récupérées à votre fichier Twig
        echo $twig->render('utilisateurs.twig', ['users' => $data]);

    } catch (PDOException $e) {
        $dbh->rollback();
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Gérer l'erreur
    }

} catch (PDOException $e) {
    echo $e->getCode() . ' ' . $e->getMessage();
}
