-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 20 Avril 2018 à 10:31
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gsb_frais`
--

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE IF NOT EXISTS `etat` (
  `id` char(2) NOT NULL,
  `libelle` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
('CL', 'Fiche Signée, saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('MP', 'Mise en paiement'),
('RB', 'Remboursée'),
('RE', 'Refusée'),
('VA', 'Validée');

-- --------------------------------------------------------

--
-- Structure de la table `fichefrais`
--

CREATE TABLE IF NOT EXISTS `fichefrais` (
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `nbJustificatifs` int(11) DEFAULT NULL,
  `montantValide` decimal(10,2) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `idEtat` char(2) DEFAULT 'CR',
  `CommentaireRefus` text NOT NULL,
  PRIMARY KEY (`idVisiteur`,`mois`),
  KEY `idEtat` (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `fichefrais`
--

INSERT INTO `fichefrais` (`idVisiteur`, `mois`, `nbJustificatifs`, `montantValide`, `dateModif`, `idEtat`, `CommentaireRefus`) VALUES
('a131', '201704', 0, '0.00', '2018-04-19', 'CR', ''),
('a131', '201705', 0, '0.00', '2018-04-19', 'CR', ''),
('a131', '201706', 0, '0.00', '2018-04-19', 'CR', ''),
('a131', '201707', 0, '0.00', '2018-04-19', 'CR', ''),
('a131', '201708', 0, '0.00', '2018-04-19', 'CR', 'test'),
('a131', '201709', 0, '1133.47', '2018-04-19', 'CR', ''),
('a131', '201710', 0, '1133.10', '2018-04-20', 'CR', ''),
('a131', '201711', 0, '0.00', '2018-04-19', 'CR', ''),
('a131', '201712', 0, '0.00', '2018-04-19', 'CR', 'a'),
('a131', '201801', 0, '0.00', '2018-04-19', 'CR', 'test'),
('a131', '201802', 0, '0.00', '2018-04-19', 'CR', ''),
('a131', '201803', 0, '0.00', '2018-04-20', 'CL', ''),
('a131', '201804', 0, '0.00', '2018-04-20', 'CL', ''),
('a17', '201706', 0, '0.00', '2017-11-14', 'CR', ''),
('a17', '201707', 0, '0.00', '2018-04-04', 'CR', ''),
('a17', '201708', 0, '0.00', '2017-12-05', 'CR', ''),
('a17', '201709', 0, '0.00', '2017-12-05', 'CR', ''),
('a17', '201710', 0, '0.00', '2017-12-05', 'CR', ''),
('a17', '201711', 0, '0.00', '2018-04-17', 'CR', ''),
('b16', '201705', 0, '0.00', '2017-10-10', 'CR', ''),
('b16', '201706', 0, '0.00', '2017-10-10', 'CR', ''),
('b16', '201707', 0, '0.00', '2018-04-03', 'CR', ''),
('b16', '201708', 0, '0.00', '2017-12-05', 'CR', ''),
('b16', '201709', 0, '0.00', '2017-12-05', 'CR', ''),
('b16', '201710', 0, '0.00', '2017-12-05', 'CR', ''),
('f21', '201705', 0, '0.00', '2017-10-17', 'CR', ''),
('f21', '201706', 0, '0.00', '2017-10-17', 'CR', ''),
('f21', '201707', 0, '0.00', '2018-04-03', 'CR', ''),
('f21', '201708', 0, '0.00', '2017-12-05', 'CR', ''),
('f21', '201709', 0, '0.00', '2017-12-05', 'CR', ''),
('f21', '201710', 0, '0.00', '2017-12-05', 'CR', ''),
('f39', '201705', 0, '0.00', '2017-10-17', 'CR', ''),
('f39', '201706', 0, '0.00', '2017-10-17', 'CR', ''),
('f39', '201707', 0, '0.00', '2017-10-17', 'CR', ''),
('f39', '201708', 0, '0.00', '2018-02-13', 'CR', ''),
('f39', '201709', 0, '0.00', '2017-12-05', 'CR', ''),
('f39', '201710', 0, '0.00', '2017-12-05', 'CR', ''),
('f39', '201711', 0, '0.00', '2017-11-28', 'CR', ''),
('f4', '201705', 0, '0.00', '2017-10-10', 'CR', ''),
('f4', '201706', 0, '0.00', '2017-10-10', 'CR', ''),
('f4', '201707', 0, '0.00', '2018-02-13', 'CR', ''),
('f4', '201708', 0, '0.00', '2017-12-05', 'CR', ''),
('f4', '201709', 0, '0.00', '2017-12-05', 'CR', ''),
('f4', '201710', 0, '0.00', '2017-11-28', 'CR', ''),
('f4', '201711', 0, '0.00', '2017-11-21', 'CR', ''),
('f4', '201712', 0, '0.00', '2017-12-05', 'CR', ''),
('f4', '201801', 0, '0.00', '2018-04-03', 'CR', ''),
('f4', '201802', 0, '0.00', '2018-04-03', 'CR', ''),
('f4', '201803', 0, '0.00', '2018-04-03', 'CR', ''),
('f4', '201804', 0, '0.00', '2018-04-04', 'CR', '');

-- --------------------------------------------------------

--
-- Structure de la table `fraisforfait`
--

CREATE TABLE IF NOT EXISTS `fraisforfait` (
  `id` char(3) NOT NULL,
  `libelle` char(20) DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `fraisforfait`
--

INSERT INTO `fraisforfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '0.62'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `lignefraisforfait`
--

CREATE TABLE IF NOT EXISTS `lignefraisforfait` (
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `idFraisForfait` char(3) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  `montantApplique` decimal(5,2) NOT NULL,
  PRIMARY KEY (`idVisiteur`,`mois`,`idFraisForfait`),
  KEY `idFraisForfait` (`idFraisForfait`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `lignefraisforfait`
--

INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`, `idFraisForfait`, `quantite`, `montantApplique`) VALUES
('a131', '201704', 'ETP', 0, '115.00'),
('a131', '201704', 'KM', 0, '0.62'),
('a131', '201704', 'NUI', 0, '80.00'),
('a131', '201704', 'REP', 0, '25.00'),
('a131', '201705', 'ETP', 0, '110.00'),
('a131', '201705', 'KM', 0, '0.62'),
('a131', '201705', 'NUI', 0, '80.00'),
('a131', '201705', 'REP', 0, '25.00'),
('a131', '201706', 'ETP', 0, '115.30'),
('a131', '201706', 'KM', 0, '0.62'),
('a131', '201706', 'NUI', 0, '80.00'),
('a131', '201706', 'REP', 0, '25.00'),
('a131', '201707', 'ETP', 0, '110.00'),
('a131', '201707', 'KM', 0, '0.62'),
('a131', '201707', 'NUI', 0, '80.00'),
('a131', '201707', 'REP', 0, '25.00'),
('a131', '201708', 'ETP', 0, '110.00'),
('a131', '201708', 'KM', 0, '0.62'),
('a131', '201708', 'NUI', 0, '80.00'),
('a131', '201708', 'REP', 0, '25.00'),
('a131', '201709', 'ETP', 5, '110.00'),
('a131', '201709', 'KM', 5, '0.62'),
('a131', '201709', 'NUI', 5, '80.00'),
('a131', '201709', 'REP', 5, '25.00'),
('a131', '201710', 'ETP', 5, '110.00'),
('a131', '201710', 'KM', 5, '0.62'),
('a131', '201710', 'NUI', 5, '80.00'),
('a131', '201710', 'REP', 5, '25.00'),
('a131', '201711', 'ETP', 0, '110.04'),
('a131', '201711', 'KM', 0, '0.62'),
('a131', '201711', 'NUI', 0, '80.00'),
('a131', '201711', 'REP', 0, '25.00'),
('a131', '201712', 'ETP', 0, '110.00'),
('a131', '201712', 'KM', 0, '0.62'),
('a131', '201712', 'NUI', 0, '80.00'),
('a131', '201712', 'REP', 0, '25.00'),
('a131', '201801', 'ETP', 0, '110.00'),
('a131', '201801', 'KM', 0, '0.62'),
('a131', '201801', 'NUI', 0, '80.00'),
('a131', '201801', 'REP', 0, '25.00'),
('a131', '201802', 'ETP', 0, '110.00'),
('a131', '201802', 'KM', 0, '0.62'),
('a131', '201802', 'NUI', 0, '80.00'),
('a131', '201802', 'REP', 0, '25.00'),
('a131', '201803', 'ETP', 0, '110.00'),
('a131', '201803', 'KM', 0, '0.62'),
('a131', '201803', 'NUI', 0, '80.00'),
('a131', '201803', 'REP', 0, '25.00'),
('a131', '201804', 'ETP', 0, '110.00'),
('a131', '201804', 'KM', 0, '0.62'),
('a131', '201804', 'NUI', 0, '80.00'),
('a131', '201804', 'REP', 0, '25.00'),
('a17', '201706', 'ETP', 0, '110.00'),
('a17', '201706', 'KM', 0, '0.62'),
('a17', '201706', 'NUI', 0, '80.00'),
('a17', '201706', 'REP', 0, '25.00'),
('a17', '201707', 'ETP', 0, '110.00'),
('a17', '201707', 'KM', 0, '0.62'),
('a17', '201707', 'NUI', 0, '80.00'),
('a17', '201707', 'REP', 0, '25.00'),
('a17', '201708', 'ETP', 0, '110.00'),
('a17', '201708', 'KM', 0, '0.62'),
('a17', '201708', 'NUI', 0, '80.00'),
('a17', '201708', 'REP', 0, '25.00'),
('a17', '201709', 'ETP', 0, '110.00'),
('a17', '201709', 'KM', 0, '0.62'),
('a17', '201709', 'NUI', 0, '80.00'),
('a17', '201709', 'REP', 0, '25.00'),
('a17', '201710', 'ETP', 0, '110.00'),
('a17', '201710', 'KM', 0, '0.62'),
('a17', '201710', 'NUI', 0, '80.00'),
('a17', '201710', 'REP', 0, '25.00'),
('a17', '201711', 'ETP', 0, '110.00'),
('a17', '201711', 'KM', 0, '0.62'),
('a17', '201711', 'NUI', 0, '80.00'),
('a17', '201711', 'REP', 0, '25.00'),
('b16', '201705', 'ETP', 0, '110.00'),
('b16', '201705', 'KM', 0, '0.62'),
('b16', '201705', 'NUI', 0, '80.00'),
('b16', '201705', 'REP', 0, '25.00'),
('b16', '201706', 'ETP', 0, '110.00'),
('b16', '201706', 'KM', 0, '0.62'),
('b16', '201706', 'NUI', 0, '80.00'),
('b16', '201706', 'REP', 0, '25.00'),
('b16', '201707', 'ETP', 0, '110.00'),
('b16', '201707', 'KM', 0, '0.62'),
('b16', '201707', 'NUI', 0, '80.00'),
('b16', '201707', 'REP', 0, '25.00'),
('b16', '201708', 'ETP', 0, '110.00'),
('b16', '201708', 'KM', 0, '0.62'),
('b16', '201708', 'NUI', 0, '80.00'),
('b16', '201708', 'REP', 0, '25.00'),
('b16', '201709', 'ETP', 0, '110.00'),
('b16', '201709', 'KM', 0, '0.62'),
('b16', '201709', 'NUI', 0, '80.00'),
('b16', '201709', 'REP', 0, '25.00'),
('b16', '201710', 'ETP', 0, '110.00'),
('b16', '201710', 'KM', 0, '0.62'),
('b16', '201710', 'NUI', 0, '80.00'),
('b16', '201710', 'REP', 0, '25.00'),
('f21', '201705', 'ETP', 0, '110.00'),
('f21', '201705', 'KM', 0, '0.62'),
('f21', '201705', 'NUI', 0, '80.00'),
('f21', '201705', 'REP', 0, '25.00'),
('f21', '201706', 'ETP', 0, '110.00'),
('f21', '201706', 'KM', 0, '0.62'),
('f21', '201706', 'NUI', 0, '80.00'),
('f21', '201706', 'REP', 0, '25.00'),
('f21', '201707', 'ETP', 0, '110.00'),
('f21', '201707', 'KM', 0, '0.62'),
('f21', '201707', 'NUI', 0, '80.00'),
('f21', '201707', 'REP', 0, '25.00'),
('f21', '201708', 'ETP', 0, '110.00'),
('f21', '201708', 'KM', 0, '0.62'),
('f21', '201708', 'NUI', 0, '80.00'),
('f21', '201708', 'REP', 0, '25.00'),
('f21', '201709', 'ETP', 0, '110.00'),
('f21', '201709', 'KM', 0, '0.62'),
('f21', '201709', 'NUI', 0, '80.00'),
('f21', '201709', 'REP', 0, '25.00'),
('f21', '201710', 'ETP', 0, '110.00'),
('f21', '201710', 'KM', 0, '0.62'),
('f21', '201710', 'NUI', 0, '80.00'),
('f21', '201710', 'REP', 0, '25.00'),
('f39', '201705', 'ETP', 0, '110.00'),
('f39', '201705', 'KM', 0, '0.62'),
('f39', '201705', 'NUI', 0, '80.00'),
('f39', '201705', 'REP', 0, '25.00'),
('f39', '201706', 'ETP', 0, '110.00'),
('f39', '201706', 'KM', 0, '0.62'),
('f39', '201706', 'NUI', 0, '80.00'),
('f39', '201706', 'REP', 0, '25.00'),
('f39', '201707', 'ETP', 0, '110.00'),
('f39', '201707', 'KM', 0, '0.62'),
('f39', '201707', 'NUI', 0, '80.00'),
('f39', '201707', 'REP', 0, '25.00'),
('f39', '201708', 'ETP', 0, '110.00'),
('f39', '201708', 'KM', 0, '0.62'),
('f39', '201708', 'NUI', 0, '80.00'),
('f39', '201708', 'REP', 0, '25.00'),
('f39', '201709', 'ETP', 0, '110.00'),
('f39', '201709', 'KM', 0, '0.62'),
('f39', '201709', 'NUI', 0, '80.00'),
('f39', '201709', 'REP', 0, '25.00'),
('f39', '201710', 'ETP', 0, '110.00'),
('f39', '201710', 'KM', 0, '0.62'),
('f39', '201710', 'NUI', 0, '80.00'),
('f39', '201710', 'REP', 0, '25.00'),
('f39', '201711', 'ETP', 0, '110.00'),
('f39', '201711', 'KM', 0, '0.62'),
('f39', '201711', 'NUI', 0, '80.00'),
('f39', '201711', 'REP', 0, '25.00'),
('f4', '201705', 'ETP', 0, '110.00'),
('f4', '201705', 'KM', 0, '0.62'),
('f4', '201705', 'NUI', 0, '80.00'),
('f4', '201705', 'REP', 0, '25.00'),
('f4', '201706', 'ETP', 0, '110.00'),
('f4', '201706', 'KM', 0, '0.62'),
('f4', '201706', 'NUI', 0, '80.00'),
('f4', '201706', 'REP', 0, '25.00'),
('f4', '201707', 'ETP', 0, '110.00'),
('f4', '201707', 'KM', 0, '0.62'),
('f4', '201707', 'NUI', 0, '80.00'),
('f4', '201707', 'REP', 0, '25.00'),
('f4', '201708', 'ETP', 0, '110.00'),
('f4', '201708', 'KM', 0, '0.62'),
('f4', '201708', 'NUI', 0, '80.00'),
('f4', '201708', 'REP', 0, '25.00'),
('f4', '201709', 'ETP', 0, '110.00'),
('f4', '201709', 'KM', 0, '0.62'),
('f4', '201709', 'NUI', 0, '80.00'),
('f4', '201709', 'REP', 0, '25.00'),
('f4', '201710', 'ETP', 0, '110.00'),
('f4', '201710', 'KM', 0, '0.62'),
('f4', '201710', 'NUI', 0, '80.00'),
('f4', '201710', 'REP', 0, '25.00'),
('f4', '201711', 'ETP', 0, '110.00'),
('f4', '201711', 'KM', 0, '0.62'),
('f4', '201711', 'NUI', 0, '80.00'),
('f4', '201711', 'REP', 0, '25.00'),
('f4', '201712', 'ETP', 0, '110.00'),
('f4', '201712', 'KM', 0, '0.62'),
('f4', '201712', 'NUI', 0, '80.00'),
('f4', '201712', 'REP', 0, '25.00'),
('f4', '201801', 'ETP', 0, '110.00'),
('f4', '201801', 'KM', 0, '0.62'),
('f4', '201801', 'NUI', 0, '80.00'),
('f4', '201801', 'REP', 0, '25.00'),
('f4', '201802', 'ETP', 0, '110.00'),
('f4', '201802', 'KM', 0, '0.62'),
('f4', '201802', 'NUI', 0, '80.00'),
('f4', '201802', 'REP', 0, '25.00'),
('f4', '201803', 'ETP', 0, '110.00'),
('f4', '201803', 'KM', 0, '0.62'),
('f4', '201803', 'NUI', 0, '80.00'),
('f4', '201803', 'REP', 0, '25.00'),
('f4', '201804', 'ETP', 0, '110.00'),
('f4', '201804', 'KM', 0, '0.62'),
('f4', '201804', 'NUI', 0, '80.00'),
('f4', '201804', 'REP', 0, '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `lignefraishorsforfait`
--

CREATE TABLE IF NOT EXISTS `lignefraishorsforfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idVisiteur` (`idVisiteur`,`mois`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `lignefraishorsforfait`
--

INSERT INTO `lignefraishorsforfait` (`id`, `idVisiteur`, `mois`, `libelle`, `date`, `montant`) VALUES
(1, 'a131', '201710', 'test', '2017-10-11', '55.00'),
(2, 'a131', '201709', 'test', '2017-09-12', '55.37'),
(12, 'a131', '201705', 'etet', '2018-04-12', '1.00'),
(13, 'a131', '201705', 'fr', '2018-04-04', '10.00');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` char(4) NOT NULL,
  `statut` enum('comptable','visiteur') NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `login` char(20) DEFAULT NULL,
  `mdp` char(20) DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `statut`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateEmbauche`) VALUES
('a131', 'visiteur', 'Villachane', 'Louis', 'lvillachane', 'jux7g', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21'),
('a17', 'visiteur', 'Andre', 'David', 'dandre', 'oppg5', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23'),
('a55', 'visiteur', 'Bedos', 'Christian', 'cbedos', 'gmhxd', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12'),
('a93', 'visiteur', 'Tusseau', 'Louis', 'ltusseau', 'ktp3s', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01'),
('b13', 'visiteur', 'Bentot', 'Pascal', 'pbentot', 'doyw1', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09'),
('b16', 'visiteur', 'Bioret', 'Luc', 'lbioret', 'hrjfs', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11'),
('b19', 'visiteur', 'Bunisset', 'Francis', 'fbunisset', '4vbnd', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21'),
('b25', 'visiteur', 'Bunisset', 'Denise', 'dbunisset', 's1y1r', '23 rue Manin', '75019', 'paris', '2010-12-05'),
('b28', 'visiteur', 'Cacheux', 'Bernard', 'bcacheux', 'uf7r3', '114 rue Blanche', '75017', 'Paris', '2009-11-12'),
('b34', 'visiteur', 'Cadic', 'Eric', 'ecadic', '6u8dc', '123 avenue de la République', '75011', 'Paris', '2008-09-23'),
('b4', 'visiteur', 'Charoze', 'Catherine', 'ccharoze', 'u817o', '100 rue Petit', '75019', 'Paris', '2005-11-12'),
('b50', 'visiteur', 'Clepkens', 'Christophe', 'cclepkens', 'bw1us', '12 allée des Anges', '93230', 'Romainville', '2003-08-11'),
('b59', 'visiteur', 'Cottin', 'Vincenne', 'vcottin', '2hoh9', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18'),
('c14', 'visiteur', 'Daburon', 'François', 'fdaburon', '7oqpv', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11'),
('c3', 'visiteur', 'De', 'Philippe', 'pde', 'gk9kx', '13 rue Barthes', '94000', 'Créteil', '2010-12-14'),
('c54', 'visiteur', 'Debelle', 'Michel', 'mdebelle', 'od5rt', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23'),
('d13', 'visiteur', 'Debelle', 'Jeanne', 'jdebelle', 'nvwqq', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11'),
('d51', 'visiteur', 'Debroise', 'Michel', 'mdebroise', 'sghkb', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17'),
('e22', 'visiteur', 'Desmarquest', 'Nathalie', 'ndesmarquest', 'f1fob', '14 Place d Arc', '45000', 'Orléans', '2005-11-12'),
('e24', 'visiteur', 'Desnost', 'Pierre', 'pdesnost', '4k2o5', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05'),
('e39', 'visiteur', 'Dudouit', 'Frédéric', 'fdudouit', '44im8', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01'),
('e49', 'visiteur', 'Duncombe', 'Claude', 'cduncombe', 'qf77j', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10'),
('e5', 'visiteur', 'Enault-Pascreau', 'Céline', 'cenault', 'y2qdu', '25 place de la gare', '23200', 'Gueret', '1995-09-01'),
('e52', 'visiteur', 'Eynde', 'Valérie', 'veynde', 'i7sn3', '3 Grand Place', '13015', 'Marseille', '1999-11-01'),
('f21', 'visiteur', 'Finck', 'Jacques', 'jfinck', 'mpb3t', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10'),
('f39', 'visiteur', 'Frémont', 'Fernande', 'ffremont', 'xs5tq', '4 route de la mer', '13012', 'Allauh', '1998-10-01'),
('f4', 'comptable', 'Gest', 'Alain', 'agest', 'dywvt', '30 avenue de la mer', '13025', 'Berre', '1985-11-01');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `fichefrais`
--
ALTER TABLE `fichefrais`
  ADD CONSTRAINT `fichefrais_ibfk_1` FOREIGN KEY (`idEtat`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `fichefrais_ibfk_2` FOREIGN KEY (`idVisiteur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `lignefraisforfait`
--
ALTER TABLE `lignefraisforfait`
  ADD CONSTRAINT `lignefraisforfait_ibfk_1` FOREIGN KEY (`idVisiteur`, `mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`),
  ADD CONSTRAINT `lignefraisforfait_ibfk_2` FOREIGN KEY (`idFraisForfait`) REFERENCES `fraisforfait` (`id`);

--
-- Contraintes pour la table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  ADD CONSTRAINT `lignefraishorsforfait_ibfk_1` FOREIGN KEY (`idVisiteur`, `mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
