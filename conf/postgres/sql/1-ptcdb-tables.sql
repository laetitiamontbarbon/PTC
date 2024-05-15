CREATE EXTENSION IF NOT EXISTS pgcrypto;


CREATE TABLE Utilisateur (
    Utilisateur_id INT PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    mail VARCHAR(255),
    est_professeur BOOLEAN,
    tag_nfc VARCHAR(255) UNIQUE
);

CREATE TABLE Salles (
    Salle_id INT PRIMARY KEY,
    code INT,
    numero VARCHAR(255) UNIQUE
);

CREATE TABLE Utilisateur_Salles (
    Utilisateur_id INT,
    Salle_id INT,
    FOREIGN KEY (Utilisateur_id) REFERENCES Utilisateur(Utilisateur_id),
    FOREIGN KEY (Salle_id) REFERENCES Salles(Salle_id),
    PRIMARY KEY (Utilisateur_id, Salle_id)
);

-- Remplissage de la table Salles
INSERT INTO Salles (Salle_id, code, numero)
VALUES
(1, 123, 'I207'),
(2, 456, 'I203'),
(3, 789, 'I206'),
(4, 1011, 'I308');






