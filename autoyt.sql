-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 18 Septembre 2017 à 20:22
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `autoyt`
--

-- --------------------------------------------------------

--
-- Structure de la table `affiliatelink`
--

CREATE TABLE IF NOT EXISTS `affiliatelink` (
`id` int(20) NOT NULL,
  `link` varchar(250) DEFAULT NULL,
  `idVideo` int(20) DEFAULT NULL,
  `idChannel` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
`id` int(10) NOT NULL,
  `idCatList` varchar(20) DEFAULT NULL,
  `json` varchar(255) DEFAULT NULL,
  `idSource` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `idCatList`, `json`, `idSource`) VALUES
(1, '1', NULL, 1),
(2, '2', NULL, 1),
(3, '3', NULL, 1),
(4, '4', NULL, 1),
(5, '5', NULL, 1),
(6, '6', NULL, 1),
(7, '7', NULL, 1),
(8, '8', NULL, 1),
(9, '9', NULL, 1),
(10, '10', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `categoriechannel`
--

CREATE TABLE IF NOT EXISTS `categoriechannel` (
  `idCategorie` int(10) DEFAULT NULL,
  `idChannel` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categoriechannel`
--

INSERT INTO `categoriechannel` (`idCategorie`, `idChannel`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `categorielist`
--

CREATE TABLE IF NOT EXISTS `categorielist` (
`id` int(20) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `isParentCat` varchar(10) DEFAULT NULL,
  `idSource` int(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categorielist`
--

INSERT INTO `categorielist` (`id`, `name`, `link`, `number`, `isParentCat`, `idSource`) VALUES
(1, 'Development', '/courses/development/', '1640', '1640', 1),
(2, 'Web Development', '/courses/development/web-development/', '1656', '1640', 1),
(3, 'Mobile Apps', '/courses/development/mobile-apps/', '1658', '1640', 1),
(4, 'Programming Languages', '/courses/development/programming-languages/', '1660', '1640', 1),
(5, 'Game Development', '/courses/development/game-development/', '1662', '1640', 1),
(6, 'Databases', '/courses/development/databases/', '1664', '1640', 1),
(7, 'Software Testing', '/courses/development/software-testing/', '1666', '1640', 1),
(8, 'Software Engineering', '/courses/development/software-engineering/', '1668', '1640', 1),
(9, 'Development Tools', '/courses/development/development-tools/', '1934', '1640', 1),
(10, 'E-Commerce', '/courses/development/e-commerce/', '1930', '1640', 1),
(11, 'Business', '/courses/business/', '1624', '1624', 1),
(12, 'Finance', '/courses/business/finance/', '1670', '1624', 1),
(13, 'Entrepreneurship', '/courses/business/entrepreneurship/', '1672', '1624', 1),
(14, 'Communications', '/courses/business/communications/', '1674', '1624', 1),
(15, 'Management', '/courses/business/management/', '1676', '1624', 1),
(16, 'Sales', '/courses/business/sales/', '1678', '1624', 1),
(17, 'Strategy', '/courses/business/strategy/', '1680', '1624', 1),
(18, 'Operations', '/courses/business/operations/', '1682', '1624', 1),
(19, 'Project Management', '/courses/business/project-management/', '1684', '1624', 1),
(20, 'Business Law', '/courses/business/business-law/', '1686', '1624', 1),
(21, 'Data &amp; Analytics', '/courses/business/data-and-analytics/', '1688', '1624', 1),
(22, 'Home Business', '/courses/business/home-business/', '1690', '1624', 1),
(23, 'Human Resources', '/courses/business/human-resources/', '1692', '1624', 1),
(24, 'Industry', '/courses/business/industry/', '1694', '1624', 1),
(25, 'Media', '/courses/business/media/', '1696', '1624', 1),
(26, 'Real Estate', '/courses/business/real-estate/', '1698', '1624', 1),
(27, 'Other', '/courses/business/other/', '1700', '1624', 1),
(28, 'IT & Software', '/courses/it-and-software/', '1646', '1646', 1),
(29, 'IT Certification', '/courses/it-and-software/it-certification/', '1766', '1646', 1),
(30, 'Network &amp; Security', '/courses/it-and-software/network-and-security/', '1768', '1646', 1),
(31, 'Hardware', '/courses/it-and-software/hardware/', '1770', '1646', 1),
(32, 'Operating Systems', '/courses/it-and-software/operating-systems/', '1772', '1646', 1),
(33, 'Other', '/courses/it-and-software/other/', '1774', '1646', 1),
(34, 'Office Productivity', '/courses/office-productivity/', '1644', '1644', 1),
(35, 'Microsoft', '/courses/office-productivity/microsoft/', '1732', '1644', 1),
(36, 'Apple', '/courses/office-productivity/apple/', '1734', '1644', 1),
(37, 'Google', '/courses/office-productivity/google/', '1736', '1644', 1),
(38, 'SAP', '/courses/office-productivity/sap/', '1738', '1644', 1),
(39, 'Intuit', '/courses/office-productivity/intuit/', '1740', '1644', 1),
(40, 'Salesforce', '/courses/office-productivity/salesforce/', '1932', '1644', 1),
(41, 'Oracle', '/courses/office-productivity/oracle/', '1742', '1644', 1),
(42, 'Other', '/courses/office-productivity/other/', '1744', '1644', 1),
(43, 'Personal Development', '/courses/personal-development/', '1648', '1648', 1),
(44, 'Personal Transformation', '/courses/personal-development/personal-transformation/', '1776', '1648', 1),
(45, 'Productivity', '/courses/personal-development/productivity/', '1778', '1648', 1),
(46, 'Leadership', '/courses/personal-development/leadership/', '1780', '1648', 1),
(47, 'Personal Finance', '/courses/personal-development/personal-finance/', '1782', '1648', 1),
(48, 'Career Development', '/courses/personal-development/career-development/', '1784', '1648', 1),
(49, 'Parenting &amp; Relationships', '/courses/personal-development/parenting-and-relationships/', '1786', '1648', 1),
(50, 'Happiness', '/courses/personal-development/happiness/', '1788', '1648', 1),
(51, 'Religion &amp; Spirituality', '/courses/personal-development/religion-and-spirituality/', '1790', '1648', 1),
(52, 'Personal Brand Building', '/courses/personal-development/personal-brand-building/', '1792', '1648', 1),
(53, 'Creativity', '/courses/personal-development/creativity/', '1794', '1648', 1),
(54, 'Influence', '/courses/personal-development/influence/', '1796', '1648', 1),
(55, 'Self Esteem', '/courses/personal-development/self-esteem/', '1798', '1648', 1),
(56, 'Stress Management', '/courses/personal-development/stress-management/', '1800', '1648', 1),
(57, 'Memory &amp; Study Skills', '/courses/personal-development/memory/', '1802', '1648', 1),
(58, 'Motivation', '/courses/personal-development/motivation/', '1804', '1648', 1),
(59, 'Other', '/courses/personal-development/other/', '1806', '1648', 1),
(60, 'Design', '/courses/design/', '1626', '1626', 1),
(61, 'Web Design', '/courses/design/web-design/', '1654', '1626', 1),
(62, 'Graphic Design', '/courses/design/graphic-design/', '1746', '1626', 1),
(63, 'Design Tools', '/courses/design/design-tools/', '1748', '1626', 1),
(64, 'User Experience', '/courses/design/user-experience/', '1750', '1626', 1),
(65, 'Game Design', '/courses/design/game-design/', '1752', '1626', 1),
(66, 'Design Thinking', '/courses/design/design-thinking/', '1754', '1626', 1),
(67, '3D &amp; Animation', '/courses/design/3d-and-animation/', '1756', '1626', 1),
(68, 'Fashion', '/courses/design/fashion/', '1758', '1626', 1),
(69, 'Architectural Design', '/courses/design/architectural-design/', '1760', '1626', 1),
(70, 'Interior Design', '/courses/design/interior-design/', '1762', '1626', 1),
(71, 'Other', '/courses/design/other/', '1764', '1626', 1),
(72, 'Marketing', '/courses/marketing/', '1642', '1642', 1),
(73, 'Digital Marketing', '/courses/marketing/digital-marketing/', '1702', '1642', 1),
(74, 'Search Engine Optimization', '/courses/marketing/search-engine-optimization/', '1704', '1642', 1),
(75, 'Social Media Marketing', '/courses/marketing/social-media-marketing/', '1706', '1642', 1),
(76, 'Branding', '/courses/marketing/branding/', '1708', '1642', 1),
(77, 'Marketing Fundamentals', '/courses/marketing/marketing-fundamentals/', '1710', '1642', 1),
(78, 'Analytics &amp; Automation', '/courses/marketing/analytics-and-automation/', '1712', '1642', 1),
(79, 'Public Relations', '/courses/marketing/public-relations/', '1714', '1642', 1),
(80, 'Advertising', '/courses/marketing/advertising/', '1716', '1642', 1),
(81, 'Video &amp; Mobile Marketing', '/courses/marketing/video-and-mobile-marketing/', '1718', '1642', 1),
(82, 'Content Marketing', '/courses/marketing/content-marketing/', '1720', '1642', 1),
(83, 'Non-Digital Marketing', '/courses/marketing/non-digital-marketing/', '1722', '1642', 1),
(84, 'Growth Hacking', '/courses/marketing/growth-hacking/', '1724', '1642', 1),
(85, 'Affiliate Marketing', '/courses/marketing/affiliate-marketing/', '1726', '1642', 1),
(86, 'Product Marketing', '/courses/marketing/product-marketing/', '1728', '1642', 1),
(87, 'Other', '/courses/marketing/other/', '1730', '1642', 1),
(88, 'Lifestyle', '/courses/lifestyle/', '1630', '1630', 1),
(89, 'Arts &amp; Crafts', '/courses/lifestyle/arts-and-crafts/', '1808', '1630', 1),
(90, 'Food &amp; Beverage', '/courses/lifestyle/food-and-beverage/', '1810', '1630', 1),
(91, 'Beauty &amp; Makeup', '/courses/lifestyle/beauty-and-makeup/', '1812', '1630', 1),
(92, 'Travel', '/courses/lifestyle/travel/', '1814', '1630', 1),
(93, 'Gaming', '/courses/lifestyle/gaming/', '1816', '1630', 1),
(94, 'Home Improvement', '/courses/lifestyle/home-improvement/', '1818', '1630', 1),
(95, 'Pet Care &amp; Training', '/courses/lifestyle/pet-care-and-training/', '1820', '1630', 1),
(96, 'Other', '/courses/lifestyle/other/', '1822', '1630', 1),
(97, 'Photography', '/courses/photography/', '1628', '1628', 1),
(98, 'Digital Photography', '/courses/photography/digital-photography/', '1936', '1628', 1),
(99, 'Photography Fundamentals', '/courses/photography/photography-fundamentals/', '1824', '1628', 1),
(100, 'Portraits', '/courses/photography/portraits/', '1832', '1628', 1),
(101, 'Landscape', '/courses/photography/landscape/', '1828', '1628', 1),
(102, 'Black &amp; White', '/courses/photography/black-and-white/', '1834', '1628', 1),
(103, 'Photography Tools', '/courses/photography/photography-tools/', '1826', '1628', 1),
(104, 'Mobile Photography', '/courses/photography/mobile-photography/', '1830', '1628', 1),
(105, 'Travel Photography', '/courses/photography/travel-photography/', '1838', '1628', 1),
(106, 'Commercial Photography', '/courses/photography/commercial-photography/', '1836', '1628', 1),
(107, 'Wedding Photography', '/courses/photography/wedding-photography/', '1840', '1628', 1),
(108, 'Wildlife Photography', '/courses/photography/wildlife-photography/', '1842', '1628', 1),
(109, 'Video Design', '/courses/photography/video-design/', '1844', '1628', 1),
(110, 'Other', '/courses/photography/other/', '1846', '1628', 1),
(111, 'Health & Fitness', '/courses/health-and-fitness/', '1632', '1632', 1),
(112, 'Fitness', '/courses/health-and-fitness/fitness/', '1848', '1632', 1),
(113, 'General Health', '/courses/health-and-fitness/general-health/', '1850', '1632', 1),
(114, 'Sports', '/courses/health-and-fitness/sports/', '1852', '1632', 1),
(115, 'Nutrition', '/courses/health-and-fitness/nutrition/', '1854', '1632', 1),
(116, 'Yoga', '/courses/health-and-fitness/yoga/', '1856', '1632', 1),
(117, 'Mental Health', '/courses/health-and-fitness/mental-health/', '1858', '1632', 1),
(118, 'Dieting', '/courses/health-and-fitness/dieting/', '1860', '1632', 1),
(119, 'Self Defense', '/courses/health-and-fitness/self-defense/', '1862', '1632', 1),
(120, 'Safety &amp; First Aid', '/courses/health-and-fitness/safety-and-first-aid/', '1864', '1632', 1),
(121, 'Dance', '/courses/health-and-fitness/dance/', '1866', '1632', 1),
(122, 'Meditation', '/courses/health-and-fitness/meditation/', '1868', '1632', 1),
(123, 'Other', '/courses/health-and-fitness/other/', '1870', '1632', 1),
(124, 'Teacher Training', '/courses/teacher-training/', '1634', '1634', 1),
(125, 'Instructional Design', '/courses/teacher-training/instructional-design/', '1872', '1634', 1),
(126, 'Educational Development', '/courses/teacher-training/educational-development/', '1874', '1634', 1),
(127, 'Teaching Tools', '/courses/teacher-training/teaching-tools/', '1876', '1634', 1),
(128, 'Other', '/courses/teacher-training/other/', '1878', '1634', 1),
(129, 'Music', '/courses/music/', '1636', '1636', 1),
(130, 'Instruments', '/courses/music/instruments/', '1906', '1636', 1),
(131, 'Production', '/courses/music/production/', '1908', '1636', 1),
(132, 'Music Fundamentals', '/courses/music/music-fundamentals/', '1910', '1636', 1),
(133, 'Vocal', '/courses/music/vocal/', '1912', '1636', 1),
(134, 'Music Techniques', '/courses/music/music-techniques/', '1914', '1636', 1),
(135, 'Music Software', '/courses/music/music-software/', '1916', '1636', 1),
(136, 'Other', '/courses/music/other/', '1918', '1636', 1),
(137, 'Academics', '/courses/academics/', '1652', '1652', 1),
(138, 'Social Science', '/courses/academics/social-science/', '1938', '1652', 1),
(139, 'Math &amp; Science', '/courses/academics/math-and-science/', '1940', '1652', 1),
(140, 'Humanities', '/courses/academics/humanities/', '1942', '1652', 1),
(141, 'Language', '/courses/language/', '1638', '1638', 1),
(142, 'English', '/courses/language/english/', '1880', '1638', 1),
(143, 'Spanish', '/courses/language/spanish/', '1882', '1638', 1),
(144, 'German', '/courses/language/german/', '1884', '1638', 1),
(145, 'French', '/courses/language/french/', '1886', '1638', 1),
(146, 'Japanese', '/courses/language/japanese/', '1888', '1638', 1),
(147, 'Portuguese', '/courses/language/portuguese/', '1890', '1638', 1),
(148, 'Chinese', '/courses/language/chinese/', '1892', '1638', 1),
(149, 'Russian', '/courses/language/russian/', '1894', '1638', 1),
(150, 'Latin', '/courses/language/latin/', '1896', '1638', 1),
(151, 'Arabic', '/courses/language/arabic/', '1898', '1638', 1),
(152, 'Hebrew', '/courses/language/hebrew/', '1900', '1638', 1),
(153, 'Italian', '/courses/language/italian/', '1902', '1638', 1),
(154, 'Other', '/courses/language/other/', '1904', '1638', 1),
(155, 'Test Prep', '/courses/test-prep/', '1650', '1650', 1),
(156, 'Grad Entry Exam', '/courses/test-prep/grad-entry-exam/', '1920', '1650', 1),
(157, 'International High School', '/courses/test-prep/international-high-school/', '1922', '1650', 1),
(158, 'College Entry Exam', '/courses/test-prep/college-entry-exam/', '1924', '1650', 1),
(159, 'Test Taking Skills', '/courses/test-prep/test-taking-skills/', '1926', '1650', 1),
(160, 'Other', '/courses/test-prep/other/', '1928', '1650', 1);

-- --------------------------------------------------------

--
-- Structure de la table `channel`
--

CREATE TABLE IF NOT EXISTS `channel` (
`id` int(10) NOT NULL,
  `channelID` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `refToken` varchar(255) DEFAULT NULL,
  `verified` varchar(10) DEFAULT NULL,
  `status` varchar(5) DEFAULT 'ok',
  `availablePosts` varchar(10) DEFAULT 'yes',
  `dateAdd` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `channel`
--

INSERT INTO `channel` (`id`, `channelID`, `token`, `refToken`, `verified`, `status`, `availablePosts`, `dateAdd`) VALUES
(1, 'UCvMmtKQ2_heXJ2663wC2B1Q', 'ya29.GluzBJikonRO3awvhTwqbXwwZ3HMbo41-jDx_ZNwRhoOTBGVmd5Dow13_TMc8x2eqisuBYswsgXbUVoPYwKlvgRkkk3lxpyEs8_EoTA9W22l_C-OdO8o3cLq7miA', '1/D66R2bOctFHBGf14mPT0Xa7dI3AxC1s2lF2pJbmPKQs', 'allowed', 'ok', 'yes', '2017-09-02 23:35:12');

-- --------------------------------------------------------

--
-- Structure de la table `owner`
--

CREATE TABLE IF NOT EXISTS `owner` (
`id` int(20) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `id_channel` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
`id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `idChannel` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
`id` int(15) NOT NULL,
  `articleID` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `nbVideos` int(10) DEFAULT NULL,
  `uploaded` varchar(15) DEFAULT NULL,
  `idCategorie` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `runhistory`
--

CREATE TABLE IF NOT EXISTS `runhistory` (
`id` int(20) NOT NULL,
  `idPost` int(20) DEFAULT NULL,
  `idChannel` int(20) DEFAULT NULL,
  `dateRun` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='run history ';

--
-- Contenu de la table `runhistory`
--

INSERT INTO `runhistory` (`id`, `idPost`, `idChannel`, `dateRun`) VALUES
(1, 23, 1, '2017-09-10 10:36:36');

-- --------------------------------------------------------

--
-- Structure de la table `source`
--

CREATE TABLE IF NOT EXISTS `source` (
`id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `source`
--

INSERT INTO `source` (`id`, `name`) VALUES
(1, 'udemy'),
(2, 'fiverr');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
`id` int(10) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `YoutubeID` varchar(60) DEFAULT NULL,
  `idPost` int(10) DEFAULT NULL,
  `dateAjout` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `videoplaylist`
--

CREATE TABLE IF NOT EXISTS `videoplaylist` (
  `idPlayList` int(10) DEFAULT NULL,
  `idVideo` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `affiliatelink`
--
ALTER TABLE `affiliatelink`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorielist`
--
ALTER TABLE `categorielist`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `channel`
--
ALTER TABLE `channel`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `owner`
--
ALTER TABLE `owner`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `playlist`
--
ALTER TABLE `playlist`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `runhistory`
--
ALTER TABLE `runhistory`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `source`
--
ALTER TABLE `source`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `affiliatelink`
--
ALTER TABLE `affiliatelink`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `categorielist`
--
ALTER TABLE `categorielist`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT pour la table `channel`
--
ALTER TABLE `channel`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `owner`
--
ALTER TABLE `owner`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `playlist`
--
ALTER TABLE `playlist`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `runhistory`
--
ALTER TABLE `runhistory`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `source`
--
ALTER TABLE `source`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
