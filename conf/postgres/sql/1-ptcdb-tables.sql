CREATE TABLE Utilisateur (
    Utilisateur_id INT PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    mail VARCHAR(255)
);

CREATE TABLE Salles (
    Salle_id INT PRIMARY KEY,
    numero VARCHAR(255) 
);

INSERT INTO Salles (Salle_id, numero)
VALUES
(1, 'I207'),
(2, 'I305');



