<?php



try {
    $dbh = new PDO('mysql:host=postgres;dbname=nom_de_votre_base_de_donnees', 'postgres', 'postgres');

    $sql = "SELECT 
                Pret.pret_id as id,
                Pret.date_inscription as 'date d\'emprunt',
                Pret.Utilisateur_id as Utilisateur,
                Pret.clickshare_id as Clickshare,
                Pret.clef_id as Clé,
                Pret.rendu_check as 'rendu ?'
            FROM 
                Pret
            WHERE clef_id IS NOT NULL OR clickshare_id IS NOT NULL
            GROUP BY
                Pret.date_inscription";
             
    $stmt = $dbh->query($sql);
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo $twig->render('logs.html.twig', [
        'entities' => $resultats,
    ]);

} catch (PDOException $e) {
    echo "Échec de la connexion à la base de données : " . $e->getMessage();
}

?>
