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

    // Requête SQL pour récupérer les salles et les utilisateurs (nom et prénom uniquement)
    $sql = "SELECT s.salle_id, 
                   s.code, 
                   s.numero,
                   pgp_sym_decrypt(u.nom::BYTEA, (SELECT key_text FROM encryption_key)) AS nom, 
                   pgp_sym_decrypt(u.prenom::BYTEA, (SELECT key_text FROM encryption_key)) AS prenom
            FROM Salles s
            LEFT JOIN Utilisateur_Salles us ON s.salle_id = us.salle_id
            LEFT JOIN Utilisateur u ON us.utilisateur_id = u.utilisateur_id";

    try {
        $dbh->beginTransaction(); // Commencer une transaction

        $sth = $dbh->prepare($sql);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC); // Fetch data as associative array

        $salles = [];
        foreach ($data as $row) {
            if (!isset($salles[$row['salle_id']])) {
                $salles[$row['salle_id']] = [
                    'salle_id' => $row['salle_id'],
                    'code' => $row['code'],
                    'numero' => $row['numero'],
                    'utilisateurs' => []
                ];
            }
            if ($row['nom'] || $row['prenom']) {
                $salles[$row['salle_id']]['utilisateurs'][] = [
                    'nom' => $row['nom'],
                    'prenom' => $row['prenom']
                ];
            }
        }

        $dbh->commit(); // Commit the transaction

        // Transmettez les données récupérées à votre fichier Twig
        echo $twig->render('salles.twig', [
            'titre' => $titre,
            'menuItems' => $menuItems,
            'salles' => array_values($salles)
        ]);

    } catch (PDOException $e) {
        $dbh->rollback();
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Gérer l'erreur
    }

} catch (PDOException $e) {
    echo $e->getCode() . ' ' . $e->getMessage();
}
?>
