/*
roles (id INT, nomRole VARCHAR)

utilisateurs (id INT, nom VARCHAR, prenom VARCHAR, email VARCHAR, motDePasse VARCHAR, role_id INT)

reglements (id INT, nomOperateur VARCHAR)

clients (id INT, nom VARCHAR, prenom VARCHAR, telephone VARCHAR, email VARCHAR, adresse VARCHAR)

fournisseurs (id INT, nom VARCHAR, telephone VARCHAR, email VARCHAR, adresse VARCHAR)

produits (id INT, nom VARCHAR, description VARCHAR, categorie VARCHAR, prix NUMERIC(10,2), seuilAlerte INT, quantiteDisponible INT)

ventes (id INT, date VARCHAR, montantTotal NUMERIC(10,2), statut VARCHAR, client_id INT)

venteReglements (vente_id INT, reglement_id INT)

ligneVentes (id INT, quantite INT, prixUnitaire NUMERIC(10,2), sousTotal NUMERIC(10,2), vente_id INT, produit_id INT)

approvisionnements (id INT, date VARCHAR, montantTotal NUMERIC(10,2), statut VARCHAR, fournisseur_id INT)

ligneApprovisionnements (id INT, quantite INT, prixUnitaire NUMERIC(10,2), sousTotal NUMERIC(10,2), approvisionnement_id INT, produit_id INT)
*/

-- Activation des clés étrangères dans SQLite (à exécuter au début de chaque connexion)
PRAGMA foreign_keys = ON;

CREATE TABLE roles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nomRole VARCHAR(50) NOT NULL CHECK (nomRole IN ('adminBoutique', 'chargeVente', 'chargeStock', 'inventaire'))
);

CREATE TABLE utilisateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    motDePasse VARCHAR(255) NOT NULL,
    role_id INT REFERENCES roles(id)
);

CREATE TABLE reglements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nomOperateur VARCHAR(50) NOT NULL
);

CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20),
    email VARCHAR(150),
    adresse VARCHAR(255)
);
INSERT INTO clients (nom,prenom,telephone,email,adresse)
VALUES ('Diop','Khadza','771112133','khadza@gmail.com','yeumbeul');

CREATE TABLE fournisseurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20),
    email VARCHAR(150),
    adresse VARCHAR(255)
);

INSERT INTO fournisseurs (nom,telephone,email,adresse) VALUES 
('SEDIMA','776665544','sedima@gmail.com','Dakar');

CREATE TABLE produits (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(150) NOT NULL,
    prix NUMERIC(10, 2) NOT NULL,
    seuilAlerte INT,
    quantiteDisponible INT
);

INSERT INTO produits (nom,prix,seuilAlerte,quantiteDisponible)
VALUES ('Lait',125,5,100);

CREATE TABLE ventes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    date VARCHAR(50) DEFAULT CURRENT_DATE,
    montantTotal NUMERIC(10, 2) NOT NULL,
    statut VARCHAR(30),
    client_id INT NOT NULL REFERENCES clients(id)
);

INSERT INTO ventes (montantTotal,statut,client_id) VALUES(2000,"EN_COURS","3");

CREATE TABLE venteReglements (
    vente_id INT NOT NULL REFERENCES ventes(id) ON DELETE CASCADE,
    reglement_id INT NOT NULL REFERENCES reglements(id),
    PRIMARY KEY (vente_id, reglement_id)
);

CREATE TABLE ligneVentes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    quantite INT NOT NULL,
    prixUnitaire NUMERIC(10, 2) NOT NULL,
    sousTotal NUMERIC(10, 2) NOT NULL,
    vente_id INT NOT NULL REFERENCES ventes(id) ON DELETE CASCADE,
    produit_id INT NOT NULL REFERENCES produits(id)
);



CREATE TABLE approvisionnements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    date VARCHAR(50) DEFAULT CURRENT_DATE,
    montantTotal NUMERIC(10, 2) NOT NULL,
    statut VARCHAR(50),
    fournisseur_id INT NOT NULL REFERENCES fournisseurs(id)
);

CREATE TABLE ligneApprovisionnements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    quantite INT NOT NULL,
    prixUnitaire NUMERIC(10, 2) NOT NULL,
    sousTotal NUMERIC(10, 2) NOT NULL,
    approvisionnement_id INT NOT NULL REFERENCES approvisionnements(id) ON DELETE CASCADE,
    produit_id INT NOT NULL REFERENCES produits(id)
);

CREATE TABLE dettes (
    id INTEGER PRIMARY KEY,
    montant NUMERIC(10, 2) NOT NULL,
    montantRestant NUMERIC(10, 2) NOT NULL,
    date VARCHAR(50) DEFAULT CURRENT_DATE,
    statut VARCHAR(30),
    vente_id INTEGER UNIQUE NOT NULL REFERENCES Vente(id),
    client_id INTEGER NOT NULL REFERENCES clients(id)
);




SELECT v.*, c.nom AS client_nom, c.prenom AS client_prenom, 
c.telephone AS client_telephone, 
 c.email AS client_email, 
c.adresse AS client_adresse
FROM ventes v
INNER JOIN clients c ON v.client_id = c.id
ORDER BY v.id ASC;


SELECT v.*, 
c.nom AS client_nom, 
c.prenom AS client_prenom, 
c.telephone AS client_telephone, 
c.email AS client_email, 
c.adresse AS client_adresse
FROM ventes v
JOIN clients c ON v.client_id = c.id
ORDER BY v.id DESC
LIMIT 5;

SELECT v.*, 
c.nom AS client_nom, 
c.prenom AS client_prenom, 
c.telephone AS client_telephone, 
c.email AS client_email
FROM ventes v
INNER JOIN clients c ON v.client_id = c.id
WHERE v.id = 1;