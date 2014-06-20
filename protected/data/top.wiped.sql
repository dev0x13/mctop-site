-- phpMyAdmin SQL Dump
-- version 4.2.0-beta1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 19, 2014 at 09:43 PM
-- Server version: 5.5.35-log
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `top`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
`id` smallint(4) unsigned NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=861 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_site_rights`
--

CREATE TABLE IF NOT EXISTS `admin_site_rights` (
`id` int(11) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `role` smallint(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

CREATE TABLE IF NOT EXISTS `adverts` (
`id` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `position` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  `pay_type` tinyint(1) NOT NULL,
  `payer_type` tinyint(1) unsigned NOT NULL,
  `payer_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `displayed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `adverts_sites`
--

CREATE TABLE IF NOT EXISTS `adverts_sites` (
  `advert` int(10) unsigned NOT NULL,
  `site` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `balance_projects`
--

CREATE TABLE IF NOT EXISTS `balance_projects` (
  `id` int(10) unsigned NOT NULL,
  `balance` float unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `balance_users`
--

CREATE TABLE IF NOT EXISTS `balance_users` (
  `id` int(10) unsigned NOT NULL,
  `balance` float unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bank_transactions`
--

CREATE TABLE IF NOT EXISTS `bank_transactions` (
`id` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  `description` varchar(512) NOT NULL,
  `result` tinyint(1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`id` int(6) NOT NULL,
  `parent` int(11) NOT NULL,
  `user` int(6) unsigned NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `module` tinyint(6) NOT NULL,
  `entity_id` int(6) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
`id` tinyint(3) unsigned NOT NULL,
  `code` varchar(2) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `forgotten_passwords`
--

CREATE TABLE IF NOT EXISTS `forgotten_passwords` (
  `uid` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `guilds`
--

CREATE TABLE IF NOT EXISTS `guilds` (
  `pid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `motd` varchar(255) NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `members` int(10) unsigned NOT NULL,
  `rating` float(10,0) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `guilds_members`
--

CREATE TABLE IF NOT EXISTS `guilds_members` (
  `pid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `roles_weight` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `guilds_news`
--

CREATE TABLE IF NOT EXISTS `guilds_news` (
`id` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `tags` varchar(512) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `guilds_roles`
--

CREATE TABLE IF NOT EXISTS `guilds_roles` (
`id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` smallint(5) unsigned NOT NULL,
  `actions` varchar(512) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `ha_logins`
--

CREATE TABLE IF NOT EXISTS `ha_logins` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `loginProvider` varchar(50) NOT NULL,
  `loginProviderIdentifier` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `iconomy`
--

CREATE TABLE IF NOT EXISTS `iconomy` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `balance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
`id` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `width` int(10) unsigned NOT NULL,
  `height` int(10) unsigned NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `using` tinyint(1) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdb`
--

CREATE TABLE IF NOT EXISTS `mdb` (
`id` int(10) unsigned NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '; 0 - plugin; 1 - mod',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `commands` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` tinyint(4) unsigned NOT NULL,
  `few_words` varchar(255) NOT NULL,
  `full` text NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news_categories`
--

CREATE TABLE IF NOT EXISTS `news_categories` (
`id` tinyint(4) unsigned NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` varchar(256) NOT NULL,
  `site` varchar(64) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `country` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `score` int(10) unsigned NOT NULL,
  `give_bonuses` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `script_url` varchar(255) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Banned; Waiting for moderation; Displaying',
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `servers_count` tinyint(4) NOT NULL,
  `banner_clickable` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `having_site` tinyint(1) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects_roles`
--

CREATE TABLE IF NOT EXISTS `projects_roles` (
`id` int(11) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `project` int(10) unsigned NOT NULL,
  `role` tinyint(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

--
-- Table structure for table `recommended_servers`
--

CREATE TABLE IF NOT EXISTS `recommended_servers` (
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `till` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `registered` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `approved` tinyint(4) NOT NULL,
  `payed` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
`id` tinyint(4) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `weight` smallint(4) NOT NULL,
  `actions` varchar(1024) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
`id` tinyint(4) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `weight` tinyint(3) unsigned NOT NULL,
  `actions` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE IF NOT EXISTS `servers` (
`id` int(10) unsigned NOT NULL,
  `project` int(10) unsigned NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(128) NOT NULL,
  `version` varchar(128) NOT NULL,
  `license` tinyint(4) NOT NULL,
  `whitelist` tinyint(1) NOT NULL,
  `own_client` tinyint(4) NOT NULL,
  `mods` varchar(256) NOT NULL,
  `plugins` varchar(256) NOT NULL,
  `address` varchar(128) NOT NULL,
  `images` varchar(256) NOT NULL,
  `images_weight` varchar(256) NOT NULL,
  `map_url` varchar(256) NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avg_online` int(11) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `servers_mods`
--

CREATE TABLE IF NOT EXISTS `servers_mods` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `servers_plugins`
--

CREATE TABLE IF NOT EXISTS `servers_plugins` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `servers_types`
--

CREATE TABLE IF NOT EXISTS `servers_types` (
`id` tinyint(3) unsigned NOT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `servers_versions`
--

CREATE TABLE IF NOT EXISTS `servers_versions` (
`id` tinyint(3) unsigned NOT NULL,
  `version` varchar(6) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE IF NOT EXISTS `socials` (
`id` tinyint(1) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `secretkey` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_messages`
--

CREATE TABLE IF NOT EXISTS `tickets_messages` (
`id` int(10) unsigned NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `message` varchar(255) NOT NULL,
  `ticket` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_topics`
--

CREATE TABLE IF NOT EXISTS `tickets_topics` (
`id` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `login` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `pwd` varchar(128) NOT NULL,
  `registered` date NOT NULL,
  `name` varchar(64) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `birthday` date NOT NULL,
  `last_update` time NOT NULL,
  `language` varchar(2) NOT NULL DEFAULT 'ru',
  `avatar` varchar(255) NOT NULL,
  `can_change_login` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `show_all_projects` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_social_logins`
--

CREATE TABLE IF NOT EXISTS `users_social_logins` (
  `user` int(10) unsigned NOT NULL,
  `system` tinyint(3) unsigned NOT NULL,
  `id_in_system` int(10) unsigned NOT NULL,
  `social_avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_oauth`
--

CREATE TABLE IF NOT EXISTS `user_oauth` (
  `user_id` int(11) NOT NULL,
  `provider` varchar(45) NOT NULL,
  `identifier` varchar(64) NOT NULL,
  `profile_cache` text,
  `session_data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
`id` int(10) unsigned NOT NULL,
  `ip` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_site_rights`
--
ALTER TABLE `admin_site_rights`
 ADD PRIMARY KEY (`id`), ADD KEY `admin_site_right_user_id` (`user`) USING BTREE;

--
-- Indexes for table `adverts`
--
ALTER TABLE `adverts`
 ADD PRIMARY KEY (`id`), ADD KEY `adverts_user_id` (`user`);

--
-- Indexes for table `adverts_sites`
--
ALTER TABLE `adverts_sites`
 ADD PRIMARY KEY (`advert`);

--
-- Indexes for table `balance_projects`
--
ALTER TABLE `balance_projects`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balance_users`
--
ALTER TABLE `balance_users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
 ADD PRIMARY KEY (`id`), ADD KEY `transactions_user` (`user`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`), ADD KEY `comments_user_fk` (`user`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forgotten_passwords`
--
ALTER TABLE `forgotten_passwords`
 ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `guilds`
--
ALTER TABLE `guilds`
 ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `guilds_members`
--
ALTER TABLE `guilds_members`
 ADD PRIMARY KEY (`pid`,`uid`), ADD KEY `guild_member_uid` (`uid`);

--
-- Indexes for table `guilds_news`
--
ALTER TABLE `guilds_news`
 ADD PRIMARY KEY (`id`), ADD KEY `guilds_news_pid` (`pid`), ADD KEY `guilds_news_author` (`author`);

--
-- Indexes for table `guilds_roles`
--
ALTER TABLE `guilds_roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ha_logins`
--
ALTER TABLE `ha_logins`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `loginProvider_2` (`loginProvider`,`loginProviderIdentifier`), ADD KEY `loginProvider` (`loginProvider`), ADD KEY `loginProviderIdentifier` (`loginProviderIdentifier`), ADD KEY `userId` (`userId`), ADD KEY `id` (`id`);

--
-- Indexes for table `iconomy`
--
ALTER TABLE `iconomy`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
 ADD PRIMARY KEY (`id`), ADD KEY `images_user` (`user`);

--
-- Indexes for table `mdb`
--
ALTER TABLE `mdb`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
 ADD PRIMARY KEY (`id`), ADD KEY `news_author_id` (`author`), ADD KEY `news_category_id` (`category`);

--
-- Indexes for table `news_categories`
--
ALTER TABLE `news_categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
 ADD PRIMARY KEY (`id`), ADD KEY `projects_country_id` (`country`);

--
-- Indexes for table `projects_roles`
--
ALTER TABLE `projects_roles`
 ADD PRIMARY KEY (`id`), ADD KEY `project_role_user` (`user`), ADD KEY `project_role_project` (`project`);

--
-- Indexes for table `recommended_servers`
--
ALTER TABLE `recommended_servers`
 ADD PRIMARY KEY (`sid`), ADD KEY `sid` (`sid`);

--
-- Indexes for table `rights`
--
ALTER TABLE `rights`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
 ADD PRIMARY KEY (`id`), ADD KEY `server_project_id` (`project`);

--
-- Indexes for table `servers_mods`
--
ALTER TABLE `servers_mods`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servers_plugins`
--
ALTER TABLE `servers_plugins`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servers_types`
--
ALTER TABLE `servers_types`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servers_versions`
--
ALTER TABLE `servers_versions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_messages`
--
ALTER TABLE `tickets_messages`
 ADD PRIMARY KEY (`id`), ADD KEY `tickets_messages_author_id` (`author`), ADD KEY `tickets_messages_ticket_id` (`ticket`);

--
-- Indexes for table `tickets_topics`
--
ALTER TABLE `tickets_topics`
 ADD PRIMARY KEY (`id`), ADD KEY `tickets_topics_user_id` (`user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_social_logins`
--
ALTER TABLE `users_social_logins`
 ADD PRIMARY KEY (`user`,`id_in_system`), ADD KEY `logins_system_id` (`system`);

--
-- Indexes for table `user_oauth`
--
ALTER TABLE `user_oauth`
 ADD PRIMARY KEY (`provider`,`identifier`), ADD UNIQUE KEY `unic_user_id_name` (`user_id`,`provider`), ADD KEY `oauth_user_id` (`user_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
MODIFY `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=861;
--
-- AUTO_INCREMENT for table `admin_site_rights`
--
ALTER TABLE `admin_site_rights`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `adverts`
--
ALTER TABLE `adverts`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `guilds_news`
--
ALTER TABLE `guilds_news`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `guilds_roles`
--
ALTER TABLE `guilds_roles`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `ha_logins`
--
ALTER TABLE `ha_logins`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mdb`
--
ALTER TABLE `mdb`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news_categories`
--
ALTER TABLE `news_categories`
MODIFY `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `projects_roles`
--
ALTER TABLE `projects_roles`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `rights`
--
ALTER TABLE `rights`
MODIFY `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `servers_mods`
--
ALTER TABLE `servers_mods`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `servers_plugins`
--
ALTER TABLE `servers_plugins`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `servers_types`
--
ALTER TABLE `servers_types`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `servers_versions`
--
ALTER TABLE `servers_versions`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tickets_messages`
--
ALTER TABLE `tickets_messages`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tickets_topics`
--
ALTER TABLE `tickets_topics`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_site_rights`
--
ALTER TABLE `admin_site_rights`
ADD CONSTRAINT `admin_site_rights_user_id` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `adverts`
--
ALTER TABLE `adverts`
ADD CONSTRAINT `adverts_user_id` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `adverts_sites`
--
ALTER TABLE `adverts_sites`
ADD CONSTRAINT `adverts_sites_advert_id` FOREIGN KEY (`advert`) REFERENCES `adverts` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `balance_projects`
--
ALTER TABLE `balance_projects`
ADD CONSTRAINT `project_balance_pid` FOREIGN KEY (`id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `balance_users`
--
ALTER TABLE `balance_users`
ADD CONSTRAINT `user_balance_user` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
ADD CONSTRAINT `transactions_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `comments_user_fk` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `guilds`
--
ALTER TABLE `guilds`
ADD CONSTRAINT `guild_project_id` FOREIGN KEY (`pid`) REFERENCES `projects` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `guilds_members`
--
ALTER TABLE `guilds_members`
ADD CONSTRAINT `guild_member_pid` FOREIGN KEY (`pid`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `guild_member_uid` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `guilds_news`
--
ALTER TABLE `guilds_news`
ADD CONSTRAINT `guilds_news_author` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `guilds_news_pid` FOREIGN KEY (`pid`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
ADD CONSTRAINT `images_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
ADD CONSTRAINT `news_author_id` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `news_category_id` FOREIGN KEY (`category`) REFERENCES `news_categories` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
ADD CONSTRAINT `projects_country_id` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `projects_roles`
--
ALTER TABLE `projects_roles`
ADD CONSTRAINT `project_role_project` FOREIGN KEY (`project`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `project_role_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recommended_servers`
--
ALTER TABLE `recommended_servers`
ADD CONSTRAINT `recommended_servers_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `servers` (`id`);

--
-- Constraints for table `servers`
--
ALTER TABLE `servers`
ADD CONSTRAINT `server_project_id` FOREIGN KEY (`project`) REFERENCES `projects` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tickets_messages`
--
ALTER TABLE `tickets_messages`
ADD CONSTRAINT `tickets_messages_author_id` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `tickets_messages_ticket_id` FOREIGN KEY (`ticket`) REFERENCES `tickets_topics` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tickets_topics`
--
ALTER TABLE `tickets_topics`
ADD CONSTRAINT `tickets_topics_user_id` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users_social_logins`
--
ALTER TABLE `users_social_logins`
ADD CONSTRAINT `logins_system_id` FOREIGN KEY (`system`) REFERENCES `socials` (`id`) ON DELETE NO ACTION,
ADD CONSTRAINT `logins_user_id` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
