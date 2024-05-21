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

    $stmt_key = $dbh->prepare("SELECT key_text FROM encryption_key");
    $stmt_key->execute();
    $key = $stmt_key->fetch(PDO::FETCH_ASSOC)['key_text'];

    // SQL query to retrieve users with their aggregated rooms
    $sql = "SELECT u.utilisateur_id, 
               pgp_sym_decrypt(u.nom::BYTEA, :key) AS nom, 
               pgp_sym_decrypt(u.prenom::BYTEA, :key) AS prenom, 
               pgp_sym_decrypt(u.mail::BYTEA, :key) AS mail, 
               u.est_professeur, 
               u.tag_nfc, 
               s.salle_id, 
               s.code, 
               s.numero
        FROM Utilisateur u
        LEFT JOIN Utilisateur_Salles us ON u.utilisateur_id = us.utilisateur_id
        LEFT JOIN Salles s ON us.salle_id = s.salle_id";
    
    $stmt = $dbh->prepare($sql); // Préparer la requête SQL
    $stmt->bindParam(':key', $key); // Lier la clé à la requête

    $stmt->execute(); // Exécuter la requête
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer les résultats


    // Initialize $utilisateurs as an empty array
    $utilisateurs = [];

    // If there are results, organize them
    if ($result) {
        foreach ($result as $row) {
            $userId = $row['utilisateur_id'];
            if (!isset($utilisateurs[$userId])) {
                $utilisateurs[$userId] = [
                    'utilisateur_id' => $row['utilisateur_id'],
                    'nom' => $row['nom'],
                    'prenom' => $row['prenom'],
                    'mail' => $row['mail'],
                    'est_professeur' => $row['est_professeur'],
                    'tag_nfc' => $row['tag_nfc'],
                    'salles' => []
                ];
            }
            if ($row['salle_id']) {
                $utilisateurs[$userId]['salles'][] = [
                    'salle_id' => $row['salle_id'],
                    'code' => $row['code'],
                    'numero' => $row['numero']
                ];
            }
        }
    }


    // Transmettez les données récupérées à votre fichier Twig
    echo $twig->render('utilisateurs.twig', [
        'titre' => $titre,
        'menuItems' => $menuItems,
        'utilisateurs' => $utilisateurs
    ]);

} catch (PDOException $e) {
    echo $e->getCode() . ' ' . $e->getMessage();
}
