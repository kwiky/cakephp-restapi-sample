--
-- Structure de la table `keys`
--

CREATE TABLE IF NOT EXISTS `keys` (
  `id` varchar(32) NOT NULL,
  `secret` varchar(32) NOT NULL,
  `name` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `keys`
--

INSERT INTO `keys` (`id`, `secret`, `name`, `created`, `updated`) VALUES
('3c6e0b8a9c15224a8228b9a98ca1531d', '5ebe2294ecd0e0f08eab7690d2a6ee69', 'Sample Application', now(), now());

-- --------------------------------------------------------

--
-- Structure de la table `tokens`
--

CREATE TABLE IF NOT EXISTS `tokens` (
  `id` varchar(32) NOT NULL,
  `email` text NOT NULL,
  `key` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(32) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;