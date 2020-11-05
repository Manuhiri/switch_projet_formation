-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 12 juin 2020 à 23:40
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `switch`
--

-- --------------------------------------------------------
/* Création de la base de donnée */
CREATE DATABASE switch;

/* Utilisation de la base de donnée*/
USE switch;
--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `switch_avis`;
CREATE TABLE IF NOT EXISTS `switch_avis` (
  `id_avis` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) DEFAULT NULL,
  `id_salle` int(3) DEFAULT NULL,
  `commentaire` text NOT NULL,
  `note` int(2) NOT NULL,
  `date_enrgistrement` datetime NOT NULL,
  PRIMARY KEY (`id_avis`),
  KEY `id_membre` (`id_membre`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `switch_commande`;
CREATE TABLE IF NOT EXISTS `switch_commande` (
  `id_commande` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) DEFAULT NULL,
  `id_produit` int(3) DEFAULT NULL,
  `date_enrgistrement` datetime NOT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `id_membre` (`id_membre`),
  KEY `id_produit` (`id_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `switch_membre`;
CREATE TABLE IF NOT EXISTS `switch_membre` (
  `id_membre` int(3) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT current_timestamp(),
  `statut` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_membre`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `switch_membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `date_enregistrement`, `statut`) VALUES
(3, 'toto', 'toto', 'toto', 'toto', 'toto@mail.ccom', 'm', '2020-05-27 23:41:24', 0),
(11, 'admin', 'admin', 'admin', 'admin', 'admin@hotmail.com', 'f', '2020-05-28 13:18:22', 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `switch_produit`;
CREATE TABLE IF NOT EXISTS `switch_produit` (
  `id_produit` int(3) NOT NULL AUTO_INCREMENT,
  `id_salle` int(3) DEFAULT NULL,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  `prix` int(3) NOT NULL,
  `etat` enum('libre','réservé') NOT NULL DEFAULT 'libre',
  PRIMARY KEY (`id_produit`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `switch_produit` (`id_produit`, `id_salle`, `date_arrivee`, `date_depart`, `prix`, `etat`) VALUES
(1, 1, '2020-07-05 00:00:00', '2020-07-11 00:00:00', 1000, 'libre'),
(2, 2, '2020-07-12 00:00:00', '2020-07-18 00:00:00', 200, 'libre'),
(3, 3, '2020-06-21 00:00:00', '2020-06-27 00:00:00', 500, 'libre');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `switch_salle`;
CREATE TABLE IF NOT EXISTS `switch_salle` (
  `id_salle` int(3) NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `capacite` int(3) NOT NULL,
  `categorie` enum('reunion','bureau','formation') NOT NULL DEFAULT 'reunion',
  PRIMARY KEY (`id_salle`),
  UNIQUE KEY `titre` (`titre`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `switch_salle` (`id_salle`, `titre`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(1, 'Cézanne', 'Cette salle sera parfaite pour vos réunions d\'entreprise', 'http://localhost/switch/photo/02_paris.webp', 'France', 'Paris', '30 rue mademoiselle', 75015, 30, 'reunion'),
(2, 'Mozart', 'Cette salle vous permettra de recevoir vos collaborateur en petit comité', 'http://localhost/switch/photo/02_marseille.webp', 'France', 'Marseille', '17 rue de turbigo', 75002, 5, 'formation'),
(3, 'Picasso', 'Cette salle vous permettra de travailler au calme', 'http://localhost/switch/photo/02_lyon.webp', 'France', 'Lyon', '28 quai claude bernard lyon', 69007, 2, 'bureau'),
(43, 'kjfngv', 'hb isdvb', 'http://localhost/switch/photo/02_paris - Copie.webp', 'qsdfc', 'Paris', 'efed', 15852, 25, 'reunion'),
(44, 'kjb efijb', '&sup2;kjbvfo', '', 'efbvi', 'Marseille', 'zzifbv', 125, 12, 'reunion'),
(45, 'fubiq', 'jd bgjb', 'http://localhost/switch/photo/02_paris - Copie.webp', 'France', 'Lyon', 'kjbfkv', 12548, 25, 'reunion'),
(46, 'test', 'teoh', '', 'ruhgIO', 'Paris', 'I&Ouml;PIHoi', 75215, 2, 'bureau');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
