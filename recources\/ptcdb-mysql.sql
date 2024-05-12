SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE Utilisateur (
    utilisateur_id SERIAL PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    mail VARCHAR(255),
    tagNFC VARCHAR(255)
);

CREATE TABLE Salle (
    salle_id SERIAL PRIMARY KEY,
    nom VARCHAR(255)

);

CREATE TABLE Clef (
    clef_id SERIAL PRIMARY KEY,
    tagNFC VARCHAR(255),
    salle_id INT,
    FOREIGN KEY (salle_id) REFERENCES Salle(salle_id)
);

CREATE TABLE Clickshare (
    clickshare_id SERIAL PRIMARY KEY,
    tagNFC VARCHAR(255),
    salle_id INT,
    FOREIGN KEY (salle_id) REFERENCES Salle(salle_id)
);

CREATE TABLE Pret  (
    pret_id SERIAL PRIMARY KEY,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    rendu_check BOOLEAN,
    clef_id INT,
    utilisateur_id INT,
    clickshare_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(utilisateur_id),
    FOREIGN KEY (clef_id) REFERENCES Clef(clef_id),
    FOREIGN KEY (clickshare_id) REFERENCES Clickshare(clickshare_id)
);


-- Insérer une salle avec un nom 'I207'
INSERT INTO Salle (salle_id, nom)
VALUES
(1, 'I207'),
(2, 'I206'),
(3, 'I205'),
(4, 'I204'),
(5, 'I203'),
(6, 'I202'),
(7, 'I201'),
(8, 'I200');
PRINT coucou2
-- Insérer un Clickshare avec un tagNFC aléatoire
INSERT INTO Clickshare (clickshare_id, tagNFC, salle_id)
VALUES
(17, 6, 1),
(18, 5, 2),
(19, 4, 3),
(20, 3, 4),
(21, 2, 5),
(22, 1, 6),
(23, 0, 7),
(24, 12, 8);

-- Insérer une clé avec un tagNFC aléatoire
INSERT INTO Clef (clef_id, tagNFC, salle_id)
VALUES
(9,  12341341, 1),
(10, 13142443, 2),
(11, 12223341, 3),
(12, 44444444, 4),
(13, 42314147, 5),
(14, 41345139, 6),
(15, 42425250, 7),
(16, 99999999, 8);

INSERT INTO Utilisateur (nom, prenom, mail, tagNFC) 
VALUES ('Doe', 'John', 'john.doe@example.com', '12345678');

