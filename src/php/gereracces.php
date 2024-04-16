<?php


try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;user=$user;password=$password";
    $dbh = new PDO($dsn);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les pathologies
    $sql = "SELECT
                u.nom AS Nom_Utilisateur,
                s.nom AS Nom_Salle
            FROM
                Utilisateur u
            JOIN
                Clef c ON u.clef_id = c.clef_id
            JOIN
                Salle s ON c.salle_id = s.salle_id
            UNION
            SELECT
                u.nom AS Nom_Utilisateur,
                s.nom AS Nom_Salle
            FROM
                Utilisateur u
            JOIN
                Clickshare cs ON u.clickshare_id = cs.clickshare_id
            JOIN
                Salle s ON cs.salle_id = s.salle_id";

    $dbh->beginTransaction();
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(); 
        $data = $sth->fetchAll();
        $dbh->commit();

        // Afficher les pathologies dans une liste HTML
        foreach ($data as $i => $row) {
            // Affichage des descriptions des pathologies et symptômes associés
            $data[$i]["nom_utilisateur"] = isset($row["Nom_Utilisateur"]) ? $row["Nom_Utilisateur"] : "Nom d'utilisateur non disponible";
            $data[$i]["nom_salle"] = isset($row["Nom_Salle"]) ? $row["Nom_Salle"] : "Nom de salle non disponible";
        }
        
            }
            echo $twig->render('gereracces.twig', ['data' => $data]);



} catch (PDOException $e) {
        $dbh->rollback();
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // gestion de l’erreur
    }


} catch (PDOException $e) {
echo $e->getCode() . ' ' . $e->getMessage();
}




?>