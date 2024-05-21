CREATE EXTENSION IF NOT EXISTS pgcrypto;


CREATE TABLE Utilisateur (
    utilisateur_id INT PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    mail VARCHAR(255),
    est_professeur BOOLEAN,
    tag_nfc VARCHAR(255) UNIQUE
);

CREATE TABLE Salles (
    salle_id INT PRIMARY KEY,
    code INT,
    numero VARCHAR(255) UNIQUE
);

CREATE TABLE Utilisateur_Salles (
    utilisateur_id INT,
    salle_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(utilisateur_id),
    FOREIGN KEY (salle_id) REFERENCES Salles(salle_id),
    PRIMARY KEY (utilisateur_id, salle_id)
);

CREATE TABLE encryption_key (
    key_text VARCHAR(255)
);


-- Remplissage de la table Salles
INSERT INTO Salles (salle_id, code, numero)
VALUES
(1, 123, 'I207'),
(2, 456, 'I203'),
(3, 789, 'I206'),
(4, 1011, 'I308');



INSERT INTO encryption_key (key_text)
VALUES
('60iQQp0V3QBRYbEivN1Z+UuA+2jcx7lJpuByuqvenHI=');


