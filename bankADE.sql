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
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
  `id_cmpt` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `numero` VARCHAR(32) NOT NULL UNIQUE,
  `id_user` INT NOT NULL,
  `id_monaie` INT NOT NULL,
  `solde` DECIMAL(15,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `comptes`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_monaie` (`id_monaie`);
  

-- --------------------------------------------------------

--
-- Structure de la table `monaie`
--

CREATE TABLE `monaies` (
  `id_Monaie` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `valeur` DECIMAL(15,5) NOT NULL,
  `nom` VARCHAR(32) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `depots`
--

CREATE TABLE `depots` (
  `id_depot` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_compte` INT NOT NULL,
  `id_monaie` INT NOT NULL,
  `montant` DECIMAL(15,5) NOT NULL,
  `verif` TINYINT(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `depots`
  ADD KEY `id_compte` (`id_compte`),
  ADD KEY `id_monaie` (`id_monaie`);

-- --------------------------------------------------------
--
-- Structure de la table `retraits`
--


CREATE TABLE `retraits` (
  `id_retrait` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_compte` INT NOT NULL,
  `id_monaie` INT NOT NULL,
  `montant` DECIMAL NOT NULL,
  `verif` TINYINT(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `retraits`
  ADD KEY `id_compte` (`id_compte`),
  ADD KEY `id_monaie` (`id_monaie`);


-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transactions` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_compte` INT NOT NULL,
  `montant` DECIMAL(15,5) NOT NULL,
  `id_monaie` INT NOT NULL,
  `date` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `transactions`
  ADD KEY `id_compte` (`id_compte`),
  ADD KEY `id_monaie` (`id_monaie`);


-- --------------------------------------------------------



ALTER TABLE `retraits`
  ADD CONSTRAINT `retraits_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `comptes` (`id_cmpt`),
  ADD CONSTRAINT `retraits_ibfk_2` FOREIGN KEY (`id_monaie`) REFERENCES `monaies` (`id_Monaie`);

ALTER TABLE `comptes`
  ADD CONSTRAINT `comptes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comptes_ibfk_2` FOREIGN KEY (`id_monaie`) REFERENCES `monaies` (`id_Monaie`);

ALTER TABLE `transactions`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `comptes` (`id_cmpt`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`id_monaie`) REFERENCES `monaies` (`id_Monaie`);

ALTER TABLE `depots`
  ADD CONSTRAINT `depots_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `comptes` (`id_cmpt`),
  ADD CONSTRAINT `depots_ibfk_2` FOREIGN KEY (`id_monaie`) REFERENCES `monaies` (`id_Monaie`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
