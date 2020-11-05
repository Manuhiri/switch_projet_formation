/* Création de la base de donnée */
CREATE DATABASE switch;

/* Utilisation de la base de donnée*/
USE switch;

/* Création de la table Salle */
CREATE TABLE switch_salle (
    id_salle int(3) NOT NULL AUTO_INCREMENT,
    titre varchar(200) NOT NULL,
    description text NOT NULL,
    photo varchar(200) NOT NULL,
    pays varchar(20) NOT NULL,
    ville varchar(20) NOT NULL,
    adresse varchar(50) NOT NULL,
    cp int(5) NOT NULL,
    capacite int(3) NOT NULL,
    categorie enum('réunion','bureau','formation') NOT NULL default 'réunion',
  /* Liaison entre les tables */
    PRIMARY KEY (id_salle),
  /* Le titre de la salle doit être unique */
    UNIQUE KEY titre (titre)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

/* Création des fiches des différentes salles */
INSERT INTO salle (id_salle, titre, description, photo, pays, ville, adresse, cp, capacite, categorie) VALUES
(1, 'Cézanne', 'Cette salle sera parfaite pour vos réunions d\'entreprise', '*****', 'France', 'Paris', '30 rue mademoiselle', '75015', '30', 'réunion'),
(2, 'Mozart', 'Cette salle vous permettra de recevoir vos collaborateur en petit comité', '******', 'France', 'Paris', '17 rue de turbigo', '75002', '5', 'réunion'),
(3, 'Picasso', 'Cette salle vous permettra de travailler au calme', '******', 'France', 'Lyon', '28 quai claude ber,ard lyon', '69007', '2', 'bureau');



/* Création de la table Produit */
CREATE TABLE switch_produit (
    id_produit int(3) NOT NULL AUTO_INCREMENT,
    id_salle int(3) default NULL,
    date_arrivee datetime NOT NULL,
    date_depart datetime NOT NULL,
    prix int(3) NOT NULL,
  /* On donne une valeur par défault */
    etat enum('libre','réservé') NOT NULL default 'libre',
  /* Liaison entre les tables */
    PRIMARY KEY (id_produit),
  /* Intégration d'une contrainte */
    KEY id_salle (id_salle)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;



/* Création de la table commande */
CREATE TABLE switch_commande(
    id_commande int(3) NOT NULL AUTO_INCREMENT,
    id_membre int(3) default NULL,
    id_produit int(3) default NULL,
    date_enrgistrement datetime NOT NULL,
  /* Liaison entre les tables */
    PRIMARY KEY (id_commande),
  /* Intégration d'une contrainte */
    KEY id_membre (id_membre),
    KEY id_produit (id_produit)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;



/* Création de la table avis */
CREATE TABLE switch_avis(
    id_avis int(3) NOT NULL AUTO_INCREMENT,
    id_membre int(3) default NULL,
    id_salle int(3) default NULL,
    commentaire text NOT NULL,
    note int(2) NOT NULL,
    date_enrgistrement datetime NOT NULL,
  /* Liaison entre les tables */
    PRIMARY KEY (id_avis),
  /* Intégration d'une contrainte */
    KEY id_membre (id_membre),
    KEY id_salle (id_salle)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;



/* Création de la table membre */
CREATE TABLE switch_membre(
    id_membre int(3) NOT NULL AUTO_INCREMENT,
    pseudo varchar(20) NOT NULL,
    mdp varchar(60) NOT NULL,
    nom varchar(20) NOT NULL,
    prenom varchar(20) NOT NULL,
    email varchar(50) NOT NULL,
    civilite enum('m','f') NOT NULL,
    date_enregistrement datetime NOT NULL,
  /* Permet de savoir si l'utilisateur est admin ou pas*/
    statut int(1)  NOT NULL,
  /* Liaison entre les tables */
    PRIMARY KEY (id_membre),
  /* Le titre de la salle doit être unique */
    UNIQUE KEY pseudo (pseudo)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
/* ON rentre 2 profil */
INSERT INTO switch_membre (id_membre, pseudo, mdp, nom, prenom, email, civilite, date_enregistrement, statut) VALUES
(1, 'momo', 'momo', 'Momo', 'moo', 'momo@site.fr', 'm', '2020/01/01', 0),
(2, 'admin', 'admin', 'Admin', 'admin', 'admin@site.fr', 'm', '2019/01/01', 1);



/* Clef étrangère contrainte lié */
/* dans la table produit vérifier si la salle existe réellement*/
ALTER TABLE switch_produit
  ADD CONSTRAINT switch_produit_ibfk_1 FOREIGN KEY (id_salle) REFERENCES switch_salle (id_salle) ON DELETE SET NULL ON UPDATE CASCADE;


/* dans la table commande vérifier si le membre et le produit existe réellement*/
ALTER TABLE switch_commande
  ADD CONSTRAINT switch_commande_ibfk_1 FOREIGN KEY (id_membre) REFERENCES switch_membre (id_membre) ON DELETE SET NULL ON UPDATE CASCADE;
  
ALTER TABLE switch_commande
  ADD CONSTRAINT switch_commande_ibfk_2 FOREIGN KEY (id_produit) REFERENCES switch_produit (id_produit) ON DELETE SET NULL ON UPDATE CASCADE;


/* dans la table avis vérifier si le membre et la salle existe réellement*/
ALTER TABLE switch_avis
  ADD CONSTRAINT switch_avis_ibfk_1 FOREIGN KEY (id_membre) REFERENCES switch_membre (id_membre) ON DELETE SET NULL ON UPDATE CASCADE;
  
ALTER TABLE switch_avis
  ADD CONSTRAINT switch_avis_ibfk_2 FOREIGN KEY (id_salle) REFERENCES switch_salle (id_salle) ON DELETE SET NULL ON UPDATE CASCADE;