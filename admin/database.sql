--
-- Struktura tabeli dla tabeli `edit_projects`
--

CREATE TABLE IF NOT EXISTS `edit_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `description` text NOT NULL,
  `tags` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `author_url` varchar(255) NOT NULL,
  `licence` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `stared` tinyint(4) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `default` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users`
--

CREATE TABLE IF NOT EXISTS `edit_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `username` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT '-1',
  `referer_id` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `stars` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_activations`
--

CREATE TABLE IF NOT EXISTS `edit_users_activations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `mktime` int(11) NOT NULL,
  `actived` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_aouth`
--

CREATE TABLE IF NOT EXISTS `edit_users_aouth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL,
  `linkedin` varchar(2000) NOT NULL,
  `dribbble` varchar(100) NOT NULL,
  `github` varchar(255) NOT NULL,
  `google` varchar(100) NOT NULL,
  `behance` varchar(100) NOT NULL,
  `codepen` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_counts`
--

CREATE TABLE IF NOT EXISTS `edit_users_counts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `snippets` int(11) NOT NULL,
  `plugins` int(11) NOT NULL,
  `themes` int(11) NOT NULL,
  `tutorials` int(11) NOT NULL,
  `followers` int(11) NOT NULL,
  `following` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_deletions`
--

CREATE TABLE IF NOT EXISTS `edit_users_deletions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `mktime` int(11) NOT NULL,
  `actived` int(11) NOT NULL,
  `reason` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_follows`
--

CREATE TABLE IF NOT EXISTS `edit_users_follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_informations`
--

CREATE TABLE IF NOT EXISTS `edit_users_informations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `website` varchar(2000) NOT NULL,
  `position` varchar(255) NOT NULL,
  `location` varchar(50) NOT NULL,
  `company` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `province` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `skills` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_logs`
--

CREATE TABLE IF NOT EXISTS `edit_users_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_id` tinyint(4) NOT NULL,
  `mktime` int(11) NOT NULL,
  `user_ip` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_messages`
--

CREATE TABLE IF NOT EXISTS `edit_users_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `mktime` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_reminds`
--

CREATE TABLE IF NOT EXISTS `edit_users_reminds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `mktime` int(11) NOT NULL,
  `actived` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_settings`
--

CREATE TABLE IF NOT EXISTS `edit_users_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hire_form` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_socials`
--

CREATE TABLE IF NOT EXISTS `edit_users_socials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `facebook` varchar(50) NOT NULL,
  `twitter` varchar(50) NOT NULL,
  `youtube` varchar(254) NOT NULL,
  `linkedin` varchar(2000) NOT NULL,
  `dribbble` varchar(100) NOT NULL,
  `github` varchar(255) NOT NULL,
  `google` varchar(100) NOT NULL,
  `behance` varchar(100) NOT NULL,
  `codepen` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla tabeli `edit_users_types`
--

CREATE TABLE IF NOT EXISTS `edit_users_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `ico` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

INSERT INTO `edit_users_types` (`id`, `project_id`, `name`, `position`, `ico`) VALUES
(1, 1, 'Creators', 0, 'fa fa-keyboard-o'),
(2, 1, 'Admins', 1, 'fa fa-bug'),
(3, 1, 'Moderators', 2, 'fa fa-edit'),
(4, 1, 'Advertisers', 3, 'fa fa-bullhorn'),
(5, 1, 'Publishers', 5, 'fa fa-video-camera'),
(6, 1, 'Reviewers', 4, 'fa fa-thumbs-o-up');