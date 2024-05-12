SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE Salle (
    salle_id SERIAL PRIMARY KEY,
    nom VARCHAR(255),
    clef_id INT,
    clickshare_id INT,
    FOREIGN KEY (clef_id) REFERENCES Clef(clef_id),
    FOREIGN KEY (clickshare_id) REFERENCES Clickshare(clickshare_id)
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

CREATE TABLE Utilisateur (
    utilisateur_id SERIAL PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    mail VARCHAR(255),
    tagNFC VARCHAR(255)
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
INSERT INTO Salle (salle_id, nom, clef_id, clickshare_id)
VALUES
(1, 'I207', 9, 17),
(2, 'I206', 10, 18),
(3, 'I205', 11, 19),
(4, 'I204', 12, 20),
(5, 'I203', 13, 21),
(6, 'I202', 14, 22),
(7, 'I201', 15, 23),
(8, 'I200', 16, 24);

-- Insérer un Clickshare avec un tagNFC aléatoire
INSERT INTO Clickshare (clickshare_id, tagNFC, salle_id)
VALUES
(17, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 1),
(18, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 2),
(19, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 3),
(20, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 4),
(21, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 5),
(22, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 6),
(23, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 7),
(24, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 8);

-- Insérer une clé avec un tagNFC aléatoire
INSERT INTO Clef (clef_id, tagNFC, salle_id)
VALUES
(9, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 1),
(10, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 2),
(11, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 3),
(12, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 4),
(13, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 5),
(14, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 6),
(15, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 7),
(16, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 8);

-- Insérer des utilisateurs
INSERT INTO Utilisateur (nom, prenom, mail, tagNFC)
VALUES
('Dupont', 'Jean', 'jean.dupont@example.com', '9564693'),
('Tremblay', 'Sophie', 'sophie.tremblay@example.com', '1393203'),
('Garcia', 'Luis', 'luis.garcia@example.com', '3131234');
