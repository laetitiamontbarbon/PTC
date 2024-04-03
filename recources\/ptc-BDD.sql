CREATE TABLE Salle (
    salle_id INT PRIMARY KEY,
    nom VARCHAR(255),
    clef_id INT,
    clickshare_id INT,
    FOREIGN KEY (clef_id) REFERENCES Clef(clef_id),
    FOREIGN KEY (clickshare_id) REFERENCES Clickshare(clickshare_id)
);

CREATE TABLE Clef (
    clef_id INT PRIMARY KEY,
    tagNFC VARCHAR(255),
    salle_id INT,
    FOREIGN KEY (salle_id) REFERENCES Salle(salle_id)
);

CREATE TABLE Clickshare (
    clickshare_id INT PRIMARY KEY,
    tagNFC VARCHAR(255),
    salle_id INT,
    FOREIGN KEY (salle_id) REFERENCES Salle(salle_id)
);

CREATE TABLE Utilisateur  (
    Utilisateur _id INT PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    mail VARCHAR(255),
    clef_id INT,
    clickshare_id INT,
    FOREIGN KEY (clef_id) REFERENCES Clef(clef_id),
    FOREIGN KEY (clickshare_id) REFERENCES Clickshare(clickshare_id)
);

-- Insérer une salle avec un nom 'I207'
INSERT INTO Salle (salle_id, nom, clef_id, clickshare_id)
VALUES (1, 'I207',9,17);
VALUES (2, 'I206',10,18);
VALUES (3, 'I205',11,19);
VALUES (4, 'I204',12,20);
VALUES (5, 'I203',13,21);
VALUES (6, 'I202',14,22);
VALUES (7, 'I201',15,23);
VALUES (8, 'I200',16,24);

-- Insérer un Clickshare avec un tagNFC aléatoire
INSERT INTO Clickshare (clickshare_id, tagNFC, salle_id)
VALUES (17, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 1);
VALUES (18, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 2);
VALUES (19, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 3);
VALUES (20, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 4);
VALUES (21, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 5);
VALUES (22, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 6);
VALUES (23, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 7);
VALUES (24, 'TAG_CLICKSHARE_' || FLOOR(RAND() * 1000000), 8);

-- Insérer une clé avec un tagNFC aléatoire
INSERT INTO Clef (clef_id, tagNFC, salle_id)
VALUES (9, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 1);
VALUES (10, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 2);
VALUES (11, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 3);
VALUES (12, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 4);
VALUES (13, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 5);
VALUES (14, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 6);
VALUES (15, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 7);
VALUES (16, 'TAG_CLEF_' || FLOOR(RAND() * 1000000), 8);