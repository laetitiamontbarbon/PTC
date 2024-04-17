<?php


require_once 'config.php';

$titre = 'Connected Locker';
$menuItems = [
    ['href' => 'creationcompte.php', 'text' => 'Créer compte'],
    ['href' => 'utilisateurs.php', 'text' => 'Utilisateurs'],
    ['href' => 'salles.php', 'text' => 'Salles']
];



// Connexion à la base de données (à remplacer avec vos informations de connexion)
$host = $_ENV['DB_HOST'];  // Adresse du serveur MySQL
$user = $_ENV['DB_USER'];  // Nom d'utilisateur MySQL
$password = $_ENV['DB_PASSWORD'];  // Mot de passe MySQL
$database = $_ENV['DB_DB'];  // Nom de la base de données
$port = 5432;


try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;user=$user;password=$password";
    $dbh = new PDO($dsn);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les utilisateurs
    $sql = "SELECT
                u.nom AS Nom_Utilisateur,
                s.nom AS Nom_Salle
            FROM
                Utilisateur u
            LEFT JOIN
                Clef c ON u.clef_id = c.clef_id
            LEFT JOIN
                Salle s ON c.salle_id = s.salle_id
            LEFT JOIN
                Clickshare cs ON u.clickshare_id = cs.clickshare_id
            LEFT JOIN
                Salle s2 ON cs.salle_id = s2.salle_id";

    $dbh->beginTransaction();
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(); 
        $data = $sth->fetchAll();
        $dbh->commit();

        // Afficher les utilisateurs et les salles dans une liste HTML
        echo $twig->render('utilisateurs.twig', ['data' => $data]);

    } catch (PDOException $e) {
        $dbh->rollback();
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Gérer l'erreur
    }

} catch (PDOException $e) {
echo $e->getCode() . ' ' . $e->getMessage();
}




?>