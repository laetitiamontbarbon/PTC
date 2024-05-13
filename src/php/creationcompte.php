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

    // Connexion à la base de données (à remplacer avec vos informations de connexion)
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

        // Compter le nombre d'utilisateurs déjà présents
        $stmt_count = $dbh->prepare("SELECT COUNT(*) FROM Utilisateur");
        $stmt_count->execute();
        $count = $stmt_count->fetchColumn();

        // Calculer le nouvel ID
        $id = $count + 1;


       // Préparer la requête d'insertion
        $stmt = $dbh->prepare("INSERT INTO Utilisateur (Utilisateur_id, nom, prenom, mail) VALUES (:id, :nom, :prenom, :mail)");

        // Bind des valeurs
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mail', $mail);

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