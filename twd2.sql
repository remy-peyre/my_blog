-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Sam 29 Avril 2017 à 19:34
-- Version du serveur :  5.6.33
-- Version de PHP :  7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `twd2`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `matricule` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `image`, `user_id`, `date`, `matricule`) VALUES
(50, 'The Walking Dead saison 7 – Tout savoir sur l’épisode 16 (SEASON FINALE) : Promo, Infos, Photos & Vidéos', 'Infos épisode 16 : The First Day of the Rest of Your Life\r\n\r\nTitre : The First Day of the Rest of Your Life\r\nSynopsis : “Les enjeux continuent de croître à force que les chemins se croisent; le groupe élabore un plan complexe”.\r\nScénariste : Scott M. Gimple\r\nRéalisateur : Greg Nicotero', 'uploads/Vertragg05/blog.jpg', 22, '2017-04-24 00:55:34', '8NPvoFpFyuOra2cce1zq'),
(51, 'The Walking Dead saison 7 : critique de l’épisode 15 “Something They Need”', 'Retour à Oceanside\r\n\r\nPersonne n’était dupe lorsque nous avons découvert Oceanside et leur armurerie. Nous savions tous que Rick et sa bande allaient y faire un tour, il nous restait juste à savoir quand. C’est donc dans l’épisode 15 que nous retournons sur cette île. Tara a enfin lâché l’info à Rick et un groupe est réuni afin d’y faire une halte. Tara a finalement rompu sa promesse. Celle-ci ouvre justement la voie et met sa vie en péril. Dommage qu’elle ne la perde pas, ça aurait fait un boulet en moins et ça aurait mis un peu de piment à cette excursion !', 'uploads/Vertragg05/blog2.jpg', 22, '2017-04-24 13:56:11', 'mT5XVs6loXggdkbsjVDg'),
(52, 'The Walking Dead saison 8 : ces trois personnages auront un rôle plus important', '<p><strong>Pour rappel,</strong> Steven Ogg joue Simon, le bras droit du chef des Sauveurs Negan. Katelyn Nacon est Enid, une adolescente d’Alexandria qui s’est montrée très proche de Carl. Pollyanna McIntosh joue l’un des nouveaux personnages de la série, Jadis, chef de la communauté des Scavengers. C’est étonnant de voir que Katelyn Nacon n’avait pas encore été promue “régulière”. Elle est arrivée depuis quelques temps dans la série et n’a pour l’instant été qu’un personnage “secondaire”.</p>', 'uploads/Vertragg05/blog3.jpg', 22, '2017-04-26 16:53:48', 'YOLSn2lUqmBe1SNQpKsz'),
(58, 'Vous devez renseigner vos équipes par envoi de mail à cyril.teixeira@supinternet.fr .', '<p>II.a - Page de login Accessible:​ user non connect&eacute; seulement Contenu:​ formulaire de connexion</p><p>II.b - Page d&rsquo;inscription Accessible:​ user non connect&eacute; seulement Contenu:​ formulaire d&rsquo;inscription</p><p>II.c - Page d&rsquo;accueil Accessible:​ user non connect&eacute; + user connect&eacute; Contenu:​ tous les articles du blog</p>', 'uploads/Vertragg05/Cover_Blue-Trai_300CMYK-1100x700.jpg', 22, '2017-04-29 00:13:16', '1f2VgH16Xd3D3CbNG6h');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `content`, `article_id`, `user_id`, `date`) VALUES
(23, 'test com', 58, 25, '2017-04-29 16:30:04');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `birthday`) VALUES
(20, 'aaaaaa1A', '$2y$10$c2FsdHlzYWx0eXNhbHR5cuE2SLIEvSLzl49SCclSZ4HHy9pYJtmFa', 'aaaaaa1A', 'aaaaaa1A', 'aaaaaa1A'),
(21, 'coucou1A', '$2y$10$c2FsdHlzYWx0eXNhbHR5cululJWk/B2rxgQLYfLVyiLYQamZKwV7e', 'coucou1A', 'coucou1A', 'coucou1A'),
(22, 'Vertragg05', '$2y$10$c2FsdHlzYWx0eXNhbHR5cuJ5l3Px7DMo4f44fADa8koLjXt2I6d4e', 'Rémy', 'PEYRE', '05/06/89'),
(23, 'coucou', '$2y$10$c2FsdHlzYWx0eXNhbHR5cu7FWq7UdTYxgKtK7D5RrQee28WdeEF8C', 'coucou', 'coucou', '05/06/1989'),
(24, 'Buster05', '$2y$10$c2FsdHlzYWx0eXNhbHR5cuAYeklzXoKNlYxYlj8yz0qefNTnkMfh2', 'Rem', 'PEyRE', '12/04/56'),
(25, 'remcos75', '$2y$10$c2FsdHlzYWx0eXNhbHR5cuxyAZ177aKHW619BnJ87gJeiW0K/ZzqK', 'remrem', 'pepere', '29/04/2017');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_article` (`article_id`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `id_article_2` (`article_id`,`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
