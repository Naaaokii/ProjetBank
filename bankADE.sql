-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 17 jan. 2023 à 10:49
-- Version du serveur :  5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `BankADE`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--


CREATE TABLE `users` (
  `ID` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom` VARCHAR(32) NOT NULL,
  `prenom` VARCHAR(32) NOT NULL,
  `email` VARCHAR(40) NOT NULL UNIQUE,
  `telephone` VARCHAR(32) NOT NULL UNIQUE,
  `date_de_naissance` DATE NOT NULL,
  `motdepasse` VARCHAR(100) NOT NULL,
  `role` VARCHAR(15) NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--


CREATE TABLE `comptes` (
  `id_Cmpt` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `numero` VARCHAR(32) NOT NULL UNIQUE,
  `id_user` INT NOT NULL,
  `id_monnaie` INT NOT NULL,
  `solde` DECIMAL(15,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `comptes`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_monnaie` (`id_monnaie`);
  

-- --------------------------------------------------------

--
-- Structure de la table `monnaies`
--

CREATE TABLE `monnaies` (
  `id_Monnaie` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `valeur` DECIMAL(15,5) NOT NULL,
  `nom` VARCHAR(32) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `depots`
--

CREATE TABLE `depots` (
  `id_depot` int(11) NOT NULL,
  `id_compte` int(11) NOT NULL,
  `id_monaie` int(11) NOT NULL,
  `montant` decimal(10,4) NOT NULL,
  `verif` varchar(255) NOT NULL DEFAULT 'unverified',
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `depots`
  ADD KEY `id_compte` (`id_compte`),
  ADD KEY `id_monnaie` (`id_monnaie`);

-- --------------------------------------------------------
--
-- Structure de la table `retraits`
--


CREATE TABLE `retraits` (
  `id_retrait` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_compte` INT NOT NULL,
  `id_monnaie` INT NOT NULL,
  `montant` DECIMAL NOT NULL,
  `verif` varchar(255) NOT NULL DEFAULT 'unverified'
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `retraits`
  ADD KEY `id_compte` (`id_compte`),
  ADD KEY `id_monnaie` (`id_monnaie`);


-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `id_compte_expediteur` int(15) NOT NULL,
  `montant` decimal(15,4) NOT NULL,
  `id_monaie` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `num_compte_destinataire` varchar(32) NOT NULL,
  `num_compte_expediteur` varchar(32) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `transactions`
  ADD KEY `id_compte` (`id_compte`),
  ADD KEY `id_monnaie` (`id_monnaie`);


-- --------------------------------------------------------



ALTER TABLE `retraits`
  ADD CONSTRAINT `retraits_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `comptes` (`id_Cmpt`),
  ADD CONSTRAINT `retraits_ibfk_2` FOREIGN KEY (`id_monnaie`) REFERENCES `monnaies` (`id_Monnaie`);

ALTER TABLE `comptes`
  ADD CONSTRAINT `comptes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `comptes_ibfk_2` FOREIGN KEY (`id_monnaie`) REFERENCES `monnaies` (`id_Monnaie`);

ALTER TABLE `transactions`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `comptes` (`id_Cmpt`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`id_monnaie`) REFERENCES `monnaies` (`id_Monnaie`);

ALTER TABLE `depots`
  ADD CONSTRAINT `depots_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `comptes` (`id_Cmpt`),
  ADD CONSTRAINT `depots_ibfk_2` FOREIGN KEY (`id_monnaie`) REFERENCES `monnaies` (`id_Monnaie`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
