-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 01 Juin 2021 à 09:21
-- Version du serveur :  10.3.27-MariaDB-0+deb10u1
-- Version de PHP :  7.3.27-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ea-vegetal`
--

-- --------------------------------------------------------

--
-- Structure de la table `CO2`
--

CREATE TABLE `CO2` (
  `ID` smallint(1) UNSIGNED NOT NULL COMMENT 'ID du relevé de CO2',
  `ID_date` smallint(1) UNSIGNED NOT NULL COMMENT 'ID de la table "Date"',
  `valeur_CO2` smallint(4) UNSIGNED NOT NULL COMMENT 'Valeur CO2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `CO2`
--

INSERT INTO `CO2` (`ID`, `ID_date`, `valeur_CO2`) VALUES
(0, 0, 9999);

-- --------------------------------------------------------

--
-- Structure de la table `Date`
--

CREATE TABLE `Date` (
  `ID` smallint(1) UNSIGNED NOT NULL COMMENT 'ID de la date du relevé',
  `date` date NOT NULL COMMENT 'Date du relevé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Date`
--

INSERT INTO `Date` (`ID`, `date`) VALUES
(0, '2000-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `HumiditeAir`
--

CREATE TABLE `HumiditeAir` (
  `ID` smallint(1) UNSIGNED NOT NULL COMMENT 'ID du relevé de l''humidité de l''air',
  `ID_date` smallint(1) UNSIGNED NOT NULL COMMENT 'ID du relevé de la table "Date"',
  `valeur_humAir` tinyint(7) UNSIGNED NOT NULL COMMENT 'Taux d''humidité dans l''air'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `HumiditeAir`
--

INSERT INTO `HumiditeAir` (`ID`, `ID_date`, `valeur_humAir`) VALUES
(0, 0, 127);

-- --------------------------------------------------------

--
-- Structure de la table `HumiditeSol`
--

CREATE TABLE `HumiditeSol` (
  `ID` smallint(1) UNSIGNED NOT NULL COMMENT 'ID du relevé de l''humidité au sol',
  `ID_date` smallint(1) UNSIGNED NOT NULL COMMENT 'ID de la date (table "Date")',
  `valeur_humSol` tinyint(7) UNSIGNED NOT NULL COMMENT 'Taux d''humidité au sol'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `HumiditeSol`
--

INSERT INTO `HumiditeSol` (`ID`, `ID_date`, `valeur_humSol`) VALUES
(0, 0, 127);

-- --------------------------------------------------------

--
-- Structure de la table `Luminosite`
--

CREATE TABLE `Luminosite` (
  `ID` smallint(1) UNSIGNED NOT NULL COMMENT 'ID du relevé de luminosité',
  `ID_date` smallint(1) UNSIGNED NOT NULL COMMENT 'ID de la date situé dans la table "Date"',
  `valeur_lum` smallint(1) UNSIGNED NOT NULL COMMENT 'Taux de luminosité'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Luminosite`
--

INSERT INTO `Luminosite` (`ID`, `ID_date`, `valeur_lum`) VALUES
(0, 0, 65364);

-- --------------------------------------------------------

--
-- Structure de la table `Plantes`
--

CREATE TABLE `Plantes` (
  `ID` tinyint(255) UNSIGNED NOT NULL COMMENT 'ID de la plantes',
  `nom` varchar(255) NOT NULL COMMENT 'Nom de la plante',
  `date_ajout` date NOT NULL COMMENT 'Date d''ajout de la plante',
  `date_retrait` date DEFAULT NULL COMMENT 'Date de retrait de la plante'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Données sur les plantes à entretenir';

--
-- Contenu de la table `Plantes`
--

INSERT INTO `Plantes` (`ID`, `nom`, `date_ajout`, `date_retrait`) VALUES
(1, 'Hedera Helix', '2021-01-17', NULL),
(2, 'Hedera Helix', '2021-01-17', NULL),
(3, 'Fittonia', '2021-01-17', NULL),
(4, 'Fittonia', '2021-01-17', NULL),
(5, 'Fittonia', '2021-01-17', NULL),
(6, 'Fittonia', '2021-01-17', NULL),
(7, 'Fittonia Lemon', '2021-01-17', NULL),
(9, 'Fittonia Mosaic F.F', '2021-01-17', NULL),
(10, 'Chlorophytum', '2021-01-17', NULL),
(11, 'Chlorophytum', '2021-01-17', NULL),
(12, 'Codiaeum', '2021-01-17', NULL),
(13, 'Codiaeum', '2021-01-17', NULL),
(14, 'Schefflera Janine', '2021-01-17', NULL),
(15, 'Schefflera Janine', '2021-01-17', NULL),
(16, 'Areca lutescens', '2021-01-17', NULL),
(17, 'Areca lutescens', '2021-01-17', NULL),
(18, 'Spathiphyllum', '2021-01-17', NULL),
(19, 'Spathiphyllum', '2021-01-17', NULL),
(20, 'Spathiphyllum', '2021-01-17', NULL),
(21, 'Spathiphyllum', '2021-01-17', NULL),
(22, 'Chamaedorea elegans', '2021-01-17', NULL),
(23, 'Chamaedorea elegans', '2021-01-17', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Temperature`
--

CREATE TABLE `Temperature` (
  `ID` smallint(1) UNSIGNED NOT NULL COMMENT 'ID du relevé de température',
  `ID_date` smallint(1) UNSIGNED NOT NULL COMMENT 'ID de la date situé dans la table "Date"',
  `valeur_temp` float NOT NULL COMMENT 'Température en float'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Temperature`
--

INSERT INTO `Temperature` (`ID`, `ID_date`, `valeur_temp`) VALUES
(0, 0, 9999.99);

-- --------------------------------------------------------

--
-- Structure de la table `TEST`
--

CREATE TABLE `TEST` (
  `NOM` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `TEST`
--

INSERT INTO `TEST` (`NOM`) VALUES
('oui'),
('oui'),
('oui'),
('oui');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `CO2`
--
ALTER TABLE `CO2`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_date` (`ID_date`);

--
-- Index pour la table `Date`
--
ALTER TABLE `Date`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `HumiditeAir`
--
ALTER TABLE `HumiditeAir`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `HumiditeSol`
--
ALTER TABLE `HumiditeSol`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Luminosite`
--
ALTER TABLE `Luminosite`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Plantes`
--
ALTER TABLE `Plantes`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Temperature`
--
ALTER TABLE `Temperature`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `CO2`
--
ALTER TABLE `CO2`
  MODIFY `ID` smallint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID du relevé de CO2', AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `Date`
--
ALTER TABLE `Date`
  MODIFY `ID` smallint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID de la date du relevé', AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `HumiditeAir`
--
ALTER TABLE `HumiditeAir`
  MODIFY `ID` smallint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID du relevé de l''humidité de l''air', AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `HumiditeSol`
--
ALTER TABLE `HumiditeSol`
  MODIFY `ID` smallint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID du relevé de l''humidité au sol', AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `Luminosite`
--
ALTER TABLE `Luminosite`
  MODIFY `ID` smallint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID du relevé de luminosité', AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `Plantes`
--
ALTER TABLE `Plantes`
  MODIFY `ID` tinyint(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID de la plantes', AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `Temperature`
--
ALTER TABLE `Temperature`
  MODIFY `ID` smallint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID du relevé de température', AUTO_INCREMENT=1;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `CO2`
--
ALTER TABLE `CO2`
  ADD CONSTRAINT `fk_id_date_CO2` FOREIGN KEY (`ID_date`) REFERENCES `Date` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Contraintes pour la table `HumiditeAir`
--
ALTER TABLE `HumiditeAir`
  ADD CONSTRAINT `fk_id_date_HumiditeAir` FOREIGN KEY (`ID_date`) REFERENCES `Date` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Contraintes pour la table `HumiditeSol`
--
ALTER TABLE `HumiditeSol`
  ADD CONSTRAINT `fk_id_date_HumiditeSol` FOREIGN KEY (`ID_date`) REFERENCES `Date` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Contraintes pour la table `Luminosite`
--
ALTER TABLE `Luminosite`
  ADD CONSTRAINT `fk_id_date_Luminosite` FOREIGN KEY (`ID_date`) REFERENCES `Date` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Contraintes pour la table `Luminosite`
--
ALTER TABLE `Temperature`
  ADD CONSTRAINT `fk_id_date_Temperature` FOREIGN KEY (`ID_date`) REFERENCES `Date` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
