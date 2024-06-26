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

// Connexion à la base de données
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

    $stmt_salles = $dbh->prepare("SELECT Salle_id, numero FROM Salles");
    $stmt_salles->execute();
    $salles = $stmt_salles->fetchAll(PDO::FETCH_ASSOC);

    $stmt_key = $dbh->prepare("SELECT key_text FROM encryption_key");
    $stmt_key->execute();
    $key = $stmt_key->fetch(PDO::FETCH_ASSOC)['key_text'];


} catch (PDOException $e) {
    // Gérer les erreurs de la base de données ici
    $message = "Erreur lors de la récupération des salles : " . $e->getMessage();
}

// Render the Twig template with the fetched data and message
echo $twig->render('creationcompte.twig', [
    'titre' => $titre,
    'menuItems' => $menuItems,
    'message' => $message, // Passer le message à Twig
    'salles' => $salles,
]);

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $tag_nfc = $_POST['tag_nfc'];
    $est_professeur = isset($_POST['est_professeur']) ? (bool)$_POST['est_professeur'] : false;
    $salles_utilisateur = isset($_POST['salles']) ? $_POST['salles'] : [];




    try {

        $dbh->beginTransaction(); // Commencer une transaction

        // Compter le nombre d'utilisateurs déjà présents
        $stmt_count = $dbh->prepare("SELECT COUNT(*) FROM Utilisateur");
        $stmt_count->execute();
        $count = $stmt_count->fetchColumn();

        // Calculer le nouvel ID
        $id = $count + 1;

       // Préparer la requête d'insertion
        $stmt = $dbh->prepare("INSERT INTO Utilisateur (Utilisateur_id, nom, prenom, mail, est_professeur, tag_nfc) VALUES (:id, pgp_sym_encrypt(:nom, :key), pgp_sym_encrypt(:prenom, :key), pgp_sym_encrypt(:mail, :key), :est_professeur, :tag_nfc)");

        // Bind des valeurs
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':est_professeur', $est_professeur, PDO::PARAM_BOOL);
        $stmt->bindParam(':tag_nfc', $tag_nfc);
        $stmt->bindParam(':key', $key);

        // Exécuter la requête
        $stmt->execute();

        // Insertion des salles auxquelles l'utilisateur a accès dans Utilisateur_Salles
        $stmt_insert_salle = $dbh->prepare("INSERT INTO Utilisateur_Salles (utilisateur_id, salle_id) VALUES (:user_id, :salle_id)");

        foreach ($salles_utilisateur as $salle_id) {
            $stmt_insert_salle->bindParam(':user_id', $id);
            $stmt_insert_salle->bindParam(':salle_id', $salle_id);
            $stmt_insert_salle->execute();
        }


        // Validation de la transaction
        $dbh->commit();

        // Message de succès
        $message = "Le compte de $prenom $nom a été créé avec succès!";

    } catch (PDOException $e) {
        // Gérer les erreurs de la base de données ici
        $message = "Erreur lors de la création du compte : " . $e->getMessage();
    }

    /*echo $twig->render('creationcompte.twig', [
        'message' => $message, // Passer le message à Twig
    ]);*/

}


