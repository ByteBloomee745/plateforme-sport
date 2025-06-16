Symfony Standard Edition
========================

**WARNING**: This distribution does not support Symfony 4. See the
[Installing & Setting up the Symfony Framework][15] page to find a replacement
that fits you best.

Welcome to the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

For details on how to download and get started with Symfony, see the
[Installation][1] chapter of the Symfony Documentation.

What's inside?
--------------

The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev env) - Adds code generation
    capabilities

  * [**WebServerBundle**][14] (in dev env) - Adds commands for running applications
    using the PHP built-in web server

  * **DebugBundle** (in dev/test env) - Adds Debug and VarDumper component
    integration

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!



[1]:  https://symfony.com/doc/3.4/setup.html
[6]:  https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[7]:  https://symfony.com/doc/3.4/doctrine.html
[8]:  https://symfony.com/doc/3.4/templating.html
[9]:  https://symfony.com/doc/3.4/security.html
[10]: https://symfony.com/doc/3.4/email.html
[11]: https://symfony.com/doc/3.4/logging.html
[13]: https://symfony.com/doc/current/bundles/SensioGeneratorBundle/index.html
[14]: https://symfony.com/doc/current/setup/built_in_web_server.html
[15]: https://symfony.com/doc/current/setup.html


-- ----------------------------------------------------------BD--------------------------------------------------------

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 16 juin 2025 à 15:28
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_club`
--

-- --------------------------------------------------------

--
-- Structure de la table `classement`
--

DROP TABLE IF EXISTS `classement`;
CREATE TABLE IF NOT EXISTS `classement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `membre_id` int DEFAULT NULL,
  `competition_id` int DEFAULT NULL,
  `points` int NOT NULL,
  `victoires` int NOT NULL,
  `defaites` int NOT NULL,
  `nuls` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_55EE9D6D6A99F74A` (`membre_id`),
  KEY `IDX_55EE9D6D7B39D312` (`competition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `competition`
--

DROP TABLE IF EXISTS `competition`;
CREATE TABLE IF NOT EXISTS `competition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sport_id` int DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateDebut` date NOT NULL,
  `format` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B50A2CB1AC78BCF8` (`sport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250616132917', '2025-06-16 13:29:21', 1904),
('DoctrineMigrations\\Version20250616150755', '2025-06-16 15:08:06', 86);

-- --------------------------------------------------------

--
-- Structure de la table `entrainement`
--

DROP TABLE IF EXISTS `entrainement`;
CREATE TABLE IF NOT EXISTS `entrainement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `equipe_id` int DEFAULT NULL,
  `coach_id` int DEFAULT NULL,
  `date` date NOT NULL,
  `lieu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A27444E56D861B89` (`equipe_id`),
  KEY `IDX_A27444E53C105691` (`coach_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `entrainement`
--

INSERT INTO `entrainement` (`id`, `equipe_id`, `coach_id`, `date`, `lieu`) VALUES
(1, 4, 2, '2025-02-19', 'fes'),
(2, 5, 1, '2030-02-10', 'marrackech'),
(3, 6, 1, '2025-06-12', 'fes');

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sport_id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coach_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2449BA15AC78BCF8` (`sport_id`),
  KEY `IDX_2449BA153C105691` (`coach_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id`, `sport_id`, `nom`, `description`, `coach_id`) VALUES
(4, 1, 'Tigers', 'Equipe de football', NULL),
(5, 2, 'Lions', 'Equipe de basketball', NULL),
(6, 3, 'hammam', 'test', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `match_table`
--

DROP TABLE IF EXISTS `match_table`;
CREATE TABLE IF NOT EXISTS `match_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `equipe_a_id` int NOT NULL,
  `equipe_b_id` int NOT NULL,
  `competition_id` int NOT NULL,
  `date` date NOT NULL,
  `score_a` int NOT NULL,
  `score_b` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4843F0E73297C2A6` (`equipe_a_id`),
  KEY `IDX_4843F0E720226D48` (`equipe_b_id`),
  KEY `IDX_4843F0E77B39D312` (`competition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membership`
--

DROP TABLE IF EXISTS `membership`;
CREATE TABLE IF NOT EXISTS `membership` (
  `id` int NOT NULL AUTO_INCREMENT,
  `membre_id` int NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_86FFD2856A99F74A` (`membre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membership`
--

INSERT INTO `membership` (`id`, `membre_id`, `role`) VALUES
(1, 1, 'Coach'),
(2, 2, 'Coach');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomPrenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateNaissance` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id`, `nomPrenom`, `dateNaissance`) VALUES
(1, 'Jean Dupont', '1990-01-01'),
(2, 'Sophie Martin', '1985-05-12'),
(3, 'Ali Ben', '1992-09-23');

-- --------------------------------------------------------

--
-- Structure de la table `sport`
--

DROP TABLE IF EXISTS `sport`;
CREATE TABLE IF NOT EXISTS `sport` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pointsVictoire` int DEFAULT NULL,
  `pointsNul` int DEFAULT NULL,
  `pointsDefaite` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sport`
--

INSERT INTO `sport` (`id`, `nom`, `type`, `description`, `pointsVictoire`, `pointsNul`, `pointsDefaite`) VALUES
(1, 'Football', 'collectif', 'Sport collectif', NULL, NULL, NULL),
(2, 'Basketball', 'collectif', 'Sport collectif', NULL, NULL, NULL),
(3, 'Tennis', 'individuel', 'Sport individuel', NULL, NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `classement`
--
ALTER TABLE `classement`
  ADD CONSTRAINT `FK_55EE9D6D6A99F74A` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `FK_55EE9D6D7B39D312` FOREIGN KEY (`competition_id`) REFERENCES `competition` (`id`);

--
-- Contraintes pour la table `competition`
--
ALTER TABLE `competition`
  ADD CONSTRAINT `FK_B50A2CB1AC78BCF8` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`);

--
-- Contraintes pour la table `entrainement`
--
ALTER TABLE `entrainement`
  ADD CONSTRAINT `FK_A27444E53C105691` FOREIGN KEY (`coach_id`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `FK_A27444E56D861B89` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`);

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `FK_2449BA153C105691` FOREIGN KEY (`coach_id`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `FK_2449BA15AC78BCF8` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`);

--
-- Contraintes pour la table `match_table`
--
ALTER TABLE `match_table`
  ADD CONSTRAINT `FK_4843F0E720226D48` FOREIGN KEY (`equipe_b_id`) REFERENCES `equipe` (`id`),
  ADD CONSTRAINT `FK_4843F0E73297C2A6` FOREIGN KEY (`equipe_a_id`) REFERENCES `equipe` (`id`),
  ADD CONSTRAINT `FK_4843F0E77B39D312` FOREIGN KEY (`competition_id`) REFERENCES `competition` (`id`);

--
-- Contraintes pour la table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `FK_86FFD2856A99F74A` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

















