<?php

require_once 'config.php';

$titre = 'Connected Locker';
$menuItems = [
    ['href' => 'creationcompte.php', 'text' => 'Créer compte'],
    ['href' => 'utilisateurs.php', 'text' => 'Utilisateurs'],
    ['href' => 'salles.php', 'text' => 'Salles']
];



// Initialiser la variable de message
$message = '';

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $tagNFC = $_POST['tagNFC'];

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

        // Préparer la requête d'insertion
        $stmt = $dbh->prepare("INSERT INTO utilisateurs (nom, prenom, mail, tagNFC) VALUES (:nom, :prenom, :mail, :tagNFC)");

        // Bind des valeurs
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':tagNFC', $tagNFC);

        // Exécuter la requête
        $stmt->execute();

        // Message de succès
        $message = "Le compte de $prenom $nom a été créé avec succès!";
    } catch (PDOException $e) {
        // Gérer les erreurs de la base de données ici
        $message = "Erreur lors de la création du compte : " . $e->getMessage();
    }
}

// Render the Twig template with the fetched data and message
echo $twig->render('creationcompte.twig', [
    'titre' => $titre,
    'menuItems' => $menuItems,
    'message' => $message, // Passer le message à Twig
]);
?>