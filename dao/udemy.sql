-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 13 Décembre 2016 à 23:02
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `udemy`
--

-- --------------------------------------------------------

--
-- Structure de la table `youtube`
--

CREATE TABLE IF NOT EXISTS `youtube` (
`id` int(10) NOT NULL,
  `linkAffiliate` text NOT NULL,
  `shortenLinkAffiliate` varchar(255) NOT NULL,
  `linkVideo` text NOT NULL,
  `sizeVideo` int(100) NOT NULL,
  `titleOrigine` varchar(255) NOT NULL,
  `titleModified` varchar(255) NOT NULL,
  `descOrgine` text,
  `descModified` text NOT NULL,
  `thumb` text NOT NULL,
  `uploaded` varchar(50) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `youtube`
--

INSERT INTO `youtube` (`id`, `linkAffiliate`, `shortenLinkAffiliate`, `linkVideo`, `sizeVideo`, `titleOrigine`, `titleModified`, `descOrgine`, `descModified`, `thumb`, `uploaded`) VALUES
(12, 'ggg', 'ggg', 'gg', 44, '5555', '555', '5', '5', '5', 'none'),
(44, '44', '44', '44', 4, '', '4', '4', '4', '4', 'none');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `youtube`
--
ALTER TABLE `youtube`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `youtube`
--
ALTER TABLE `youtube`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
