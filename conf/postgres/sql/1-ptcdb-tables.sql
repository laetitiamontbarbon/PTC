CREATE TABLE Utilisateur (
    Utilisateur_id INT PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    mail VARCHAR(255)
);

-- Insérer des utilisateurs avec des clef_id existants
INSERT INTO Utilisateur (Utilisateur_id, nom, prenom, mail)
VALUES
(2, 'Tremblay', 'Sophie', 'sophie.tremblay@example.com'),
(3, 'Garcia', 'Luis', 'luis.garcia@example.com');




