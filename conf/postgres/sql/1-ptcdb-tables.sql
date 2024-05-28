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

-- Remplissage de la table Utilisateur
INSERT INTO Utilisateur (Utilisateur_id, nom, prenom, mail, est_professeur, tag_nfc)
VALUES
(1, 'Jarry', 'Alexandre', 'jarry.alexandre@gmail.com', false, '012312'),
(2, 'Degironde', 'Alix', 'degironde.alix@gmail.com', true, '203284'),
(3, 'Bachelot', 'Aurelien', 'bachelot.aurelien@gmail.com', false, '431254');

-- Remplissage de la table Utilisateur_Salles (exemples fictifs d'associations)
INSERT INTO Utilisateur_Salles (Utilisateur_id, Salle_id)
VALUES
(1, 1), -- Utilisateur 1 a accès à la salle 1
(1, 2), -- Utilisateur 1 a accès à la salle 2
(2, 3), -- Utilisateur 2 a accès à la salle 3
(3, 1), -- Utilisateur 3 a accès à la salle 1
(3, 4); -- Utilisateur 3 a accès à la salle 4




INSERT INTO encryption_key (key_text)
VALUES
('60iQQp0V3QBRYbEivN1Z+UuA+2jcx7lJpuByuqvenHI=');


