-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  sam. 18 avr. 2020 à 16:45
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `factures&devis`
--

-- --------------------------------------------------------

--
-- Structure de la table `delivery`
--

CREATE TABLE `delivery` (
                            `id` int(11) NOT NULL,
                            `delivery` tinyint(1) DEFAULT NULL,
                            `date` datetime NOT NULL,
                            `years` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
                            `sheet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fos_user`
--

CREATE TABLE `fos_user` (
                            `id` int(11) NOT NULL,
                            `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
                            `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
                            `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
                            `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
                            `enabled` tinyint(1) NOT NULL,
                            `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                            `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                            `last_login` datetime DEFAULT NULL,
                            `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
                            `password_requested_at` datetime DEFAULT NULL,
                            `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(1, 'admin', 'admin', 'julien@ecotoner.fr', 'julien@ecotoner.fr', 1, NULL, '$2y$13$5mb885.IpMrKUX9LZ1jWUu9JWsTs6.2Chk57hq82SpFn3xWUDQrVO', '2019-10-14 15:11:31', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}'),
(2, 'julien', 'julien', 'decide66@hotmail.com', 'decide66@hotmail.com', 1, NULL, '$2y$13$n20u.2vYemOQG5kJYSVAq.GzZ7BE1TmjUmoz1AJ6HVMPQzPdbRmc6', '2019-10-13 10:16:04', NULL, NULL, 'a:0:{}'),
(3, 'hespel', 'hespel', 'hespel@acces77.fr', 'hespel@acces77.fr', 1, NULL, '$2y$13$cFOHd6M9nsAfUzNyLitUIuNCpe38bq5AT7FGbHe8ewVrjajk9JRuu', '2020-02-27 16:37:26', NULL, NULL, 'a:0:{}'),
(5, 'Arno', 'arno', 'touchet@acces77.fr', 'touchet@acces77.fr', 1, NULL, '$2y$13$5MdqDlRfS5Tflogqvszxuu2Ts.3IfmIw5EedHbcTwx6FS0XL0C8CS', '2019-12-12 15:37:09', NULL, NULL, 'a:0:{}'),
(6, 'keepco', 'keepco', 'decide1983@gmail.com', 'decide1983@gmail.com', 1, NULL, '$2y$13$nVxtIdZwODAnHC6P75wen.dEChGWqrltPUYPIJXCaulPLfhh2bdDm', '2019-12-13 08:14:03', NULL, NULL, 'a:0:{}'),
(7, 'M.VASA', 'm.vasa', 'vasa@acces77.fr', 'vasa@acces77.fr', 1, NULL, '$2y$13$Fzqd60YdCUSCCsSPCnLfWO6a11XjFjvtT4pRpVha78cunlisj4D6q', '2019-12-17 13:41:02', NULL, NULL, 'a:0:{}'),
(8, 'BRUNO LEFEBVRE', 'bruno lefebvre', 'bruno-lefebvre@wanadoo.fr', 'bruno-lefebvre@wanadoo.fr', 1, NULL, '$2y$13$GryOMc2d5HqO.gmoDUSgD.OG6pNtNTugOzkNUaDLP5GYt47tIdieS', '2020-01-21 16:00:17', NULL, NULL, 'a:0:{}');

-- --------------------------------------------------------

--
-- Structure de la table `link`
--

CREATE TABLE `link` (
                        `id` int(11) NOT NULL,
                        `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                        `linkname` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
                        `sheetdev_id` int(11) DEFAULT NULL,
                        `sheet_id` int(11) DEFAULT NULL,
                        `delivery_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `provider`
--

CREATE TABLE `provider` (
                            `id` int(11) NOT NULL,
                            `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                            `Code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
                            `contact` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sheet`
--

CREATE TABLE `sheet` (
                         `id` int(11) NOT NULL,
                         `provider_id` int(11) DEFAULT NULL,
                         `facture` tinyint(1) DEFAULT NULL,
                         `date` datetime NOT NULL,
                         `sheetdev_id` int(11) DEFAULT NULL,
                         `years` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sheet_dev`
--

CREATE TABLE `sheet_dev` (
                             `id` int(11) NOT NULL,
                             `society_id` int(11) DEFAULT NULL,
                             `devis` tinyint(1) DEFAULT NULL,
                             `date` datetime NOT NULL,
                             `years` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `society`
--

CREATE TABLE `society` (
                           `id` int(11) NOT NULL,
                           `society_name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
                           `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                           `zipcode` int(11) NOT NULL,
                           `city` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
                           `contact` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `years`
--

CREATE TABLE `years` (
                         `id` int(11) NOT NULL,
                         `years` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `years`
--

INSERT INTO `years` (`id`, `years`) VALUES
(1, '01');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `delivery`
--
ALTER TABLE `delivery`
    ADD PRIMARY KEY (`id`),
    ADD KEY `IDX_3781EC108B1206A5` (`sheet_id`);

--
-- Index pour la table `fos_user`
--
ALTER TABLE `fos_user`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
    ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
    ADD UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`);

--
-- Index pour la table `link`
--
ALTER TABLE `link`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `UNIQ_36AC99F14D4C0985` (`sheetdev_id`),
    ADD UNIQUE KEY `UNIQ_36AC99F18B1206A5` (`sheet_id`),
    ADD UNIQUE KEY `UNIQ_36AC99F112136921` (`delivery_id`);

--
-- Index pour la table `provider`
--
ALTER TABLE `provider`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sheet`
--
ALTER TABLE `sheet`
    ADD PRIMARY KEY (`id`),
    ADD KEY `IDX_873C91E2A53A8AA` (`provider_id`),
    ADD KEY `IDX_873C91E24D4C0985` (`sheetdev_id`);

--
-- Index pour la table `sheet_dev`
--
ALTER TABLE `sheet_dev`
    ADD PRIMARY KEY (`id`),
    ADD KEY `IDX_DC90DCF7E6389D24` (`society_id`);

--
-- Index pour la table `society`
--
ALTER TABLE `society`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `years`
--
ALTER TABLE `years`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `UNIQ_A308E877A308E877` (`years`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `delivery`
--
ALTER TABLE `delivery`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fos_user`
--
ALTER TABLE `fos_user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `link`
--
ALTER TABLE `link`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `provider`
--
ALTER TABLE `provider`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sheet`
--
ALTER TABLE `sheet`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sheet_dev`
--
ALTER TABLE `sheet_dev`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `society`
--
ALTER TABLE `society`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `years`
--
ALTER TABLE `years`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `delivery`
--
ALTER TABLE `delivery`
    ADD CONSTRAINT `FK_3781EC108B1206A5` FOREIGN KEY (`sheet_id`) REFERENCES `sheet` (`id`);

--
-- Contraintes pour la table `link`
--
ALTER TABLE `link`
    ADD CONSTRAINT `FK_36AC99F112136921` FOREIGN KEY (`delivery_id`) REFERENCES `delivery` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `FK_36AC99F14D4C0985` FOREIGN KEY (`sheetdev_id`) REFERENCES `sheet_dev` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `FK_36AC99F18B1206A5` FOREIGN KEY (`sheet_id`) REFERENCES `sheet` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sheet`
--
ALTER TABLE `sheet`
    ADD CONSTRAINT `FK_873C91E24D4C0985` FOREIGN KEY (`sheetdev_id`) REFERENCES `sheet_dev` (`id`),
    ADD CONSTRAINT `FK_873C91E2A53A8AA` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`id`);

--
-- Contraintes pour la table `sheet_dev`
--
ALTER TABLE `sheet_dev`
    ADD CONSTRAINT `FK_DC90DCF7E6389D24` FOREIGN KEY (`society_id`) REFERENCES `society` (`id`);
