/*
Navicat MySQL Data Transfer

Source Server         : loc
Source Server Version : 50535
Source Host           : localhost:3306
Source Database       : top

Target Server Type    : MYSQL
Target Server Version : 50535
File Encoding         : 65001

Date: 2014-05-19 21:37:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `actions`
-- ----------------------------
DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=861 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of actions
-- ----------------------------
INSERT INTO `actions` VALUES ('10', 'project_delete');
INSERT INTO `actions` VALUES ('20', 'project_edit');
INSERT INTO `actions` VALUES ('30', 'project_view');
INSERT INTO `actions` VALUES ('40', 'project_set_roles');
INSERT INTO `actions` VALUES ('50', 'project_programmer_check_bonus_script');
INSERT INTO `actions` VALUES ('60', 'project_programmer_change_bonus_word');
INSERT INTO `actions` VALUES ('70', 'project_financer_create_advert');
INSERT INTO `actions` VALUES ('80', 'project_financer_delete_advert');
INSERT INTO `actions` VALUES ('90', 'project_financer_edit_advert');
INSERT INTO `actions` VALUES ('100', 'project_financer_pay_money');
INSERT INTO `actions` VALUES ('110', 'project_add_server');
INSERT INTO `actions` VALUES ('120', 'project_delete_server');
INSERT INTO `actions` VALUES ('130', 'project_edit_server');
INSERT INTO `actions` VALUES ('131', 'project_guild_founder');
INSERT INTO `actions` VALUES ('132', 'guild_news_manage');
INSERT INTO `actions` VALUES ('133', 'guild_news_comments_manage');
INSERT INTO `actions` VALUES ('134', 'guild_add_comment');
INSERT INTO `actions` VALUES ('300', 'site_news_edit');
INSERT INTO `actions` VALUES ('310', 'site_news_delete');
INSERT INTO `actions` VALUES ('320', 'site_news_create');
INSERT INTO `actions` VALUES ('330', 'site_news_category_delete');
INSERT INTO `actions` VALUES ('331', 'site_news_category_list');
INSERT INTO `actions` VALUES ('332', 'site_news_category_manage');
INSERT INTO `actions` VALUES ('340', 'site_news_category_create');
INSERT INTO `actions` VALUES ('350', 'site_news_category_edit');
INSERT INTO `actions` VALUES ('351', 'site_news_list');
INSERT INTO `actions` VALUES ('352', 'site_news_manage');
INSERT INTO `actions` VALUES ('360', 'site_user_delete');
INSERT INTO `actions` VALUES ('361', 'site_user_create');
INSERT INTO `actions` VALUES ('370', 'site_user_edit');
INSERT INTO `actions` VALUES ('371', 'site_user_list');
INSERT INTO `actions` VALUES ('372', 'site_user_manage');
INSERT INTO `actions` VALUES ('380', 'site_countries_edit');
INSERT INTO `actions` VALUES ('390', 'site_countries_delete');
INSERT INTO `actions` VALUES ('400', 'site_countries_create');
INSERT INTO `actions` VALUES ('401', 'site_countries_list');
INSERT INTO `actions` VALUES ('402', 'site_countries_manage');
INSERT INTO `actions` VALUES ('410', 'site_project_edit');
INSERT INTO `actions` VALUES ('420', 'site_project_delete');
INSERT INTO `actions` VALUES ('430', 'site_project_create');
INSERT INTO `actions` VALUES ('440', 'site_project_manage');
INSERT INTO `actions` VALUES ('441', 'site_project_list');
INSERT INTO `actions` VALUES ('450', 'site_server_edit');
INSERT INTO `actions` VALUES ('460', 'site_server_delete');
INSERT INTO `actions` VALUES ('470', 'site_server_create');
INSERT INTO `actions` VALUES ('480', 'site_server_manage');
INSERT INTO `actions` VALUES ('481', 'site_server_list');
INSERT INTO `actions` VALUES ('490', 'site_servers_mods_edit');
INSERT INTO `actions` VALUES ('500', 'site_servers_mods_delete');
INSERT INTO `actions` VALUES ('510', 'site_servers_mods_create');
INSERT INTO `actions` VALUES ('520', 'site_servers_mods_manage');
INSERT INTO `actions` VALUES ('521', 'site_servers_mods_list');
INSERT INTO `actions` VALUES ('530', 'site_servers_types_create');
INSERT INTO `actions` VALUES ('540', 'site_servers_types_edit');
INSERT INTO `actions` VALUES ('550', 'site_servers_types_delete');
INSERT INTO `actions` VALUES ('560', 'site_servers_types_manage');
INSERT INTO `actions` VALUES ('570', 'site_servers_types_list');
INSERT INTO `actions` VALUES ('580', 'site_adverts_list');
INSERT INTO `actions` VALUES ('581', 'site_adverts_create');
INSERT INTO `actions` VALUES ('582', 'site_adverts_edit');
INSERT INTO `actions` VALUES ('583', 'site_adverts_delete');
INSERT INTO `actions` VALUES ('584', 'site_adverts_manage');
INSERT INTO `actions` VALUES ('600', 'site_images_list');
INSERT INTO `actions` VALUES ('601', 'site_images_create');
INSERT INTO `actions` VALUES ('602', 'site_images_edit');
INSERT INTO `actions` VALUES ('603', 'site_images_delete');
INSERT INTO `actions` VALUES ('604', 'site_images_manage');
INSERT INTO `actions` VALUES ('620', 'site_balance_user_list');
INSERT INTO `actions` VALUES ('630', 'site_balance_user_create');
INSERT INTO `actions` VALUES ('640', 'site_balance_user_edit');
INSERT INTO `actions` VALUES ('650', 'site_balance_user_delete');
INSERT INTO `actions` VALUES ('660', 'site_balance_user_manage');
INSERT INTO `actions` VALUES ('670', 'site_balance_project_list');
INSERT INTO `actions` VALUES ('680', 'site_balance_project_create');
INSERT INTO `actions` VALUES ('690', 'site_balance_project_edit');
INSERT INTO `actions` VALUES ('700', 'site_balance_project_delete');
INSERT INTO `actions` VALUES ('710', 'site_balance_project_manage');
INSERT INTO `actions` VALUES ('720', 'site_bank_transactions_list');
INSERT INTO `actions` VALUES ('730', 'site_bank_transactions_create');
INSERT INTO `actions` VALUES ('740', 'site_bank_transactions_edit');
INSERT INTO `actions` VALUES ('750', 'site_bank_transactions_delete');
INSERT INTO `actions` VALUES ('760', 'site_bank_transactions_manage');
INSERT INTO `actions` VALUES ('770', 'site_projects_roles_list');
INSERT INTO `actions` VALUES ('780', 'site_projects_roles_create');
INSERT INTO `actions` VALUES ('790', 'site_projects_roles_edit');
INSERT INTO `actions` VALUES ('800', 'site_projects_roles_delete');
INSERT INTO `actions` VALUES ('810', 'site_projects_roles_manage');
INSERT INTO `actions` VALUES ('820', 'site_project_moderation');
INSERT INTO `actions` VALUES ('830', 'site_server_moderation');
INSERT INTO `actions` VALUES ('840', 'site_image_moderation');
INSERT INTO `actions` VALUES ('850', 'site_advert_moderation');
INSERT INTO `actions` VALUES ('860', 'site_support');

-- ----------------------------
-- Table structure for `admin_site_rights`
-- ----------------------------
DROP TABLE IF EXISTS `admin_site_rights`;
CREATE TABLE `admin_site_rights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `role` smallint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_site_right_user_id` (`user`) USING BTREE,
  CONSTRAINT `admin_site_rights_user_id` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_site_rights
-- ----------------------------
INSERT INTO `admin_site_rights` VALUES ('1', '2', '2');

-- ----------------------------
-- Table structure for `adverts`
-- ----------------------------
DROP TABLE IF EXISTS `adverts`;
CREATE TABLE `adverts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `position` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  `pay_type` tinyint(1) NOT NULL,
  `payer_type` tinyint(1) unsigned NOT NULL,
  `payer_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `displayed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `adverts_user_id` (`user`),
  CONSTRAINT `adverts_user_id` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of adverts
-- ----------------------------

-- ----------------------------
-- Table structure for `adverts_sites`
-- ----------------------------
DROP TABLE IF EXISTS `adverts_sites`;
CREATE TABLE `adverts_sites` (
  `advert` int(10) unsigned NOT NULL,
  `site` varchar(255) NOT NULL,
  PRIMARY KEY (`advert`),
  CONSTRAINT `adverts_sites_advert_id` FOREIGN KEY (`advert`) REFERENCES `adverts` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of adverts_sites
-- ----------------------------

-- ----------------------------
-- Table structure for `balance_projects`
-- ----------------------------
DROP TABLE IF EXISTS `balance_projects`;
CREATE TABLE `balance_projects` (
  `id` int(10) unsigned NOT NULL,
  `balance` float unsigned NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `project_balance_pid` FOREIGN KEY (`id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of balance_projects
-- ----------------------------
INSERT INTO `balance_projects` VALUES ('74', '0');

-- ----------------------------
-- Table structure for `balance_users`
-- ----------------------------
DROP TABLE IF EXISTS `balance_users`;
CREATE TABLE `balance_users` (
  `id` int(10) unsigned NOT NULL,
  `balance` float unsigned NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `user_balance_user` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of balance_users
-- ----------------------------
INSERT INTO `balance_users` VALUES ('1', '0');
INSERT INTO `balance_users` VALUES ('2', '0');

-- ----------------------------
-- Table structure for `bank_transactions`
-- ----------------------------
DROP TABLE IF EXISTS `bank_transactions`;
CREATE TABLE `bank_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  `description` varchar(512) NOT NULL,
  `result` tinyint(1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `transactions_user` (`user`),
  CONSTRAINT `transactions_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bank_transactions
-- ----------------------------

-- ----------------------------
-- Table structure for `comments`
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `user` int(6) unsigned NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `module` tinyint(6) NOT NULL,
  `entity_id` int(6) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comments_user_fk` (`user`),
  CONSTRAINT `comments_user_fk` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for `countries`
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of countries
-- ----------------------------
INSERT INTO `countries` VALUES ('1', 'ru', 'Россия');
INSERT INTO `countries` VALUES ('2', 'ua', 'Украина');
INSERT INTO `countries` VALUES ('3', 'by', 'Белоруссия');
INSERT INTO `countries` VALUES ('4', 'de', 'Германия');
INSERT INTO `countries` VALUES ('5', 'sl', 'Словения');

-- ----------------------------
-- Table structure for `forgotten_passwords`
-- ----------------------------
DROP TABLE IF EXISTS `forgotten_passwords`;
CREATE TABLE `forgotten_passwords` (
  `uid` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of forgotten_passwords
-- ----------------------------
INSERT INTO `forgotten_passwords` VALUES ('1', '2d588fdee83370fc7697986a689c4d3b', '2014-05-19 20:53:21');

-- ----------------------------
-- Table structure for `guilds`
-- ----------------------------
DROP TABLE IF EXISTS `guilds`;
CREATE TABLE `guilds` (
  `pid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `motd` varchar(255) NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `members` int(10) unsigned NOT NULL,
  `rating` float(10,0) unsigned NOT NULL,
  PRIMARY KEY (`pid`),
  CONSTRAINT `guild_project_id` FOREIGN KEY (`pid`) REFERENCES `projects` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of guilds
-- ----------------------------
INSERT INTO `guilds` VALUES ('74', 'Гильдия проекта MCTop.Tester', 'Харе Кришна!', '2014-05-17 02:37:16', '1', '1');

-- ----------------------------
-- Table structure for `guilds_members`
-- ----------------------------
DROP TABLE IF EXISTS `guilds_members`;
CREATE TABLE `guilds_members` (
  `pid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `roles_weight` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`pid`,`uid`),
  KEY `guild_member_uid` (`uid`),
  CONSTRAINT `guild_member_pid` FOREIGN KEY (`pid`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `guild_member_uid` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of guilds_members
-- ----------------------------
INSERT INTO `guilds_members` VALUES ('74', '2', '2');

-- ----------------------------
-- Table structure for `guilds_news`
-- ----------------------------
DROP TABLE IF EXISTS `guilds_news`;
CREATE TABLE `guilds_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `tags` varchar(512) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `guilds_news_pid` (`pid`),
  KEY `guilds_news_author` (`author`),
  CONSTRAINT `guilds_news_author` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `guilds_news_pid` FOREIGN KEY (`pid`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of guilds_news
-- ----------------------------

-- ----------------------------
-- Table structure for `guilds_roles`
-- ----------------------------
DROP TABLE IF EXISTS `guilds_roles`;
CREATE TABLE `guilds_roles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `weight` smallint(5) unsigned NOT NULL,
  `actions` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of guilds_roles
-- ----------------------------
INSERT INTO `guilds_roles` VALUES ('1', 'Основатель гильдии', '2', ':131:, :132:, :133:, :134:');
INSERT INTO `guilds_roles` VALUES ('2', 'Администратор гильдии', '4', ':132:, :133:, :134:');
INSERT INTO `guilds_roles` VALUES ('3', 'Модератор гильдии', '8', ':132:, :133:, :134:');
INSERT INTO `guilds_roles` VALUES ('4', 'Редактор новостей', '16', ':132:, :133:, :134:');
INSERT INTO `guilds_roles` VALUES ('10', 'Участник', '1024', ':134:');

-- ----------------------------
-- Table structure for `ha_logins`
-- ----------------------------
DROP TABLE IF EXISTS `ha_logins`;
CREATE TABLE `ha_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `loginProvider` varchar(50) NOT NULL,
  `loginProviderIdentifier` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loginProvider_2` (`loginProvider`,`loginProviderIdentifier`),
  KEY `loginProvider` (`loginProvider`),
  KEY `loginProviderIdentifier` (`loginProviderIdentifier`),
  KEY `userId` (`userId`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ha_logins
-- ----------------------------

-- ----------------------------
-- Table structure for `iconomy`
-- ----------------------------
DROP TABLE IF EXISTS `iconomy`;
CREATE TABLE `iconomy` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `balance` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iconomy
-- ----------------------------
INSERT INTO `iconomy` VALUES ('1', '0Medvedkoo', '301');

-- ----------------------------
-- Table structure for `images`
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `width` int(10) unsigned NOT NULL,
  `height` int(10) unsigned NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `using` tinyint(1) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `images_user` (`user`),
  CONSTRAINT `images_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images
-- ----------------------------
INSERT INTO `images` VALUES ('1', '1', 'reklama1.gif', 'eeb4ecb8c159836294bd253a01f615ce.gif', '468', '60', '24872', '0', '0');
INSERT INTO `images` VALUES ('2', '2', 'reklama1.gif', 'e5f990dce04dbe22e72f59ca58dfb323.gif', '0', '0', '0', '0', '0');
INSERT INTO `images` VALUES ('3', '2', 'reklama1.gif', '508a52c562a9944e40b3b1ca5534013a.gif', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `mdb`
-- ----------------------------
DROP TABLE IF EXISTS `mdb`;
CREATE TABLE `mdb` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL COMMENT '; 0 - plugin; 1 - mod',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `commands` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mdb
-- ----------------------------
INSERT INTO `mdb` VALUES ('1', '1', 'Industrial Craft', ' Модификация для SSP и SMP режимов Minecraft. Добавляет в мир электричество, новые устройства, инструменты, блоки, предметы и многое другое.', '/spawn - Перемещает Вас на спаун;\r\n/warp имя_точки - перемещает Вас в точку специально созданную на сервере;\r\n/pm имя_игрока сообщение - отправить приватное сообщение игроку;\r\n/r сообщение - отправить сообщение в текущую приватную беседу;\r\n/time - узнать игровое время;\r\n/list - список игроков на сервере;\r\n/call имя_игрока - запросить телепортацию, чтобы подтвердить запрос нужно ввести /bring (ввести должен тот игрок у которого Вы запрашиваете телепорт).');
INSERT INTO `mdb` VALUES ('2', '0', 'AuthMe', 'AuthMe prevents people, which aren\'t logged in, from doing stuff like placing blocks, moving, typing commands or seeing the inventory of the current player.\r\n\r\nThe possibility to set up name spoof protection kicks players with uncommon long or short player names before they could actually join. Login Sessions make it possible that you don\'t have to login within a given time period.\r\n\r\nEach command and every setting can be enabled or disabled by a easy structured config file. And if you don\'t prefer English or don\'t like my translations you can easily edit nearly every message sent by AuthMe!', '/register <password>	Register yourself on the server\r\n/login <password>	Login to the server\r\n/logout	Logout from the server\r\n/changepassword <oldpassword> <newpassword>	Change your password(you have to be logged in)\r\n/unregister <password>	Unregister from the server\r\n<hr>\r\n/authme reload	Reload the cache\r\n/authme register <playername> <password>	Register a player\r\n/authme changepassword <playername> <newpassword>	Change password of a player\r\n/authme unregister <playername>	Unregister a player\r\n/authme purge <days>	Delete players from database that haven\'t logged in for <days> days.');
INSERT INTO `mdb` VALUES ('3', '1', 'League of Crafters', 'Мод добавляет в игру большую кучу нужных предметов, а один из главных - это конечно же очень профессионально сделанные мобы, которые сразу могут узнать те, кто играл в популярную игру \"League of Legends\" (сокращённо называют \"лолкой\"). \r\n\r\nТак что если вы играли там, а теперь сидити в майнкрафте, то этот мод вам понравится бесспорно. \r\nЭлементов из той игры здесь будет достаточно много, чтобы вернуться и вспомнить ту атмосферу, когда игра кипела и вы там были.\r\n', '');

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` tinyint(4) unsigned NOT NULL,
  `few_words` varchar(255) NOT NULL,
  `full` text NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `tags` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_author_id` (`author`),
  KEY `news_category_id` (`category`),
  CONSTRAINT `news_author_id` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `news_category_id` FOREIGN KEY (`category`) REFERENCES `news_categories` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------

-- ----------------------------
-- Table structure for `news_categories`
-- ----------------------------
DROP TABLE IF EXISTS `news_categories`;
CREATE TABLE `news_categories` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news_categories
-- ----------------------------
INSERT INTO `news_categories` VALUES ('1', 'Обновления');
INSERT INTO `news_categories` VALUES ('2', 'Крупные события Minecraft');
INSERT INTO `news_categories` VALUES ('3', 'Minecraft News');

-- ----------------------------
-- Table structure for `projects`
-- ----------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `having_site` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_country_id` (`country`),
  CONSTRAINT `projects_country_id` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of projects
-- ----------------------------
INSERT INTO `projects` VALUES ('73', 'Ru-Craft', 'Описание', 'http://mctop.su', '/static/img/u1/eeb4ecb8c159836294bd253a01f615ce.gif', '1', '0', '0', '', '', '1', '2014-05-17 02:35:24', '1', '1', '1');
INSERT INTO `projects` VALUES ('74', 'MCTop.Tester', 'test', 'http://mctop.at.ua', '/static/img/u/508a52c562a9944e40b3b1ca5534013a.gif', '1', '8', '0', '', '', '1', '2011-11-10 00:00:00', '3', '1', '0');

-- ----------------------------
-- Table structure for `projects_roles`
-- ----------------------------
DROP TABLE IF EXISTS `projects_roles`;
CREATE TABLE `projects_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `project` int(10) unsigned NOT NULL,
  `role` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_role_user` (`user`),
  KEY `project_role_project` (`project`),
  CONSTRAINT `project_role_project` FOREIGN KEY (`project`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `project_role_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of projects_roles
-- ----------------------------
INSERT INTO `projects_roles` VALUES ('76', '1', '73', '2');
INSERT INTO `projects_roles` VALUES ('77', '2', '74', '2');

-- ----------------------------
-- Table structure for `recommended_servers`
-- ----------------------------
DROP TABLE IF EXISTS `recommended_servers`;
CREATE TABLE `recommended_servers` (
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `till` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `registered` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `approved` tinyint(4) NOT NULL,
  `payed` tinyint(4) NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `sid` (`sid`),
  CONSTRAINT `recommended_servers_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `servers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of recommended_servers
-- ----------------------------
INSERT INTO `recommended_servers` VALUES ('24', '2014-06-17 22:31:27', '2014-05-18 22:31:27', '1', '1');
INSERT INTO `recommended_servers` VALUES ('25', '2014-06-17 22:49:25', '2014-05-18 22:49:25', '1', '1');

-- ----------------------------
-- Table structure for `rights`
-- ----------------------------
DROP TABLE IF EXISTS `rights`;
CREATE TABLE `rights` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `weight` smallint(4) NOT NULL,
  `actions` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rights
-- ----------------------------
INSERT INTO `rights` VALUES ('1', 'rating_administrator', 'Администратор рейтинга', '2', ':300:, :310:, :320:, :330:, :331:, :332:, :340, :350:, :351:, :352:, :360:, :361:, :370:, :371:, :372:, :380:, :390:, \r\n:400:, :401:, :402:, :410:, :420:, :430:, :440:, :441:, :450, :460:, :470:, :480:, :481, :490:, \r\n:500:, :510:, :520:, :521:, :530:, :540:, :550:, :560:, :570:, :580:, :581:, :582:, :583:, :584:,\r\n:600:, :601:, :602:, :603:, :604:, :610:, \r\n:620:, :630:, :640:, :650:, :660,\r\n:670:, :680:, :690:, :700:, :710:,\r\n:720:, :730:, :740:, :750:, :760:,\r\n:770:, :780:, :790:, :800:, :810:,\r\n:820:, :830:, :840:, :850:');
INSERT INTO `rights` VALUES ('2', 'rating_moderator', 'Модератор рейтинга', '4', ':820:');
INSERT INTO `rights` VALUES ('3', 'image_moderator', 'Модератор изображений', '8', ':840:');
INSERT INTO `rights` VALUES ('4', 'advert_moderator', 'Модератор рекламных объявлений', '16', ':850:');
INSERT INTO `rights` VALUES ('5', 'global_moderator', 'Модератор', '32', ':820:, :840:, :850:');
INSERT INTO `rights` VALUES ('6', 'news_reporter', 'Новостной репортер', '64', ':300:, :320:,\r\n:351:');
INSERT INTO `rights` VALUES ('7', 'support_agent', 'Агент поддержки', '128', ':860:');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `weight` tinyint(3) unsigned NOT NULL,
  `actions` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'founder', 'Основатель', '2', ':10:, :20:, :30:, :40:, :50:, :60:, :70:, :80:, :90:, :100:, :110:, :120:, :130:, :131:');
INSERT INTO `roles` VALUES ('2', 'admin', 'Администратор', '4', ':20:, :30:, :40:, :50:, :60:, :70:, :80:, :90:, :100:, :110:, :120:, :130:');
INSERT INTO `roles` VALUES ('3', 'programmer', 'Программист', '8', ':50:, :60:');
INSERT INTO `roles` VALUES ('4', 'financer', 'Менеджер по финансам', '16', ':70:, :80:, :90:, :100:');
INSERT INTO `roles` VALUES ('5', 'viewer', 'Пока что никто >_>', '32', ':30:');

-- ----------------------------
-- Table structure for `servers`
-- ----------------------------
DROP TABLE IF EXISTS `servers`;
CREATE TABLE `servers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `avg_online` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `server_project_id` (`project`),
  CONSTRAINT `server_project_id` FOREIGN KEY (`project`) REFERENCES `projects` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of servers
-- ----------------------------
INSERT INTO `servers` VALUES ('24', '74', 'Minecraft Sunlight', 'Хороший сервер, правда', ':1:', '5', '0', '1', '0', '', '', 'mctop.su', '', '', '', '2014-05-17 02:36:24', '0');
INSERT INTO `servers` VALUES ('25', '74', 'GoodDay', 'test', ':6:', '5', '0', '0', '0', '', '', '188.165.207.217:25580', '', '', '', '2014-05-17 02:36:25', '0');

-- ----------------------------
-- Table structure for `servers_mods`
-- ----------------------------
DROP TABLE IF EXISTS `servers_mods`;
CREATE TABLE `servers_mods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of servers_mods
-- ----------------------------
INSERT INTO `servers_mods` VALUES ('1', 'Industrial Craft', '');
INSERT INTO `servers_mods` VALUES ('2', 'CrushCraft', '');
INSERT INTO `servers_mods` VALUES ('3', 'League of Crafters', '');
INSERT INTO `servers_mods` VALUES ('4', 'Antique Atlas', '');
INSERT INTO `servers_mods` VALUES ('6', 'Autofish  1', 'Установите этот замечательный мод и сможете AFK-шить во время рыбалки. Он будет ловить рыбу за вас.');

-- ----------------------------
-- Table structure for `servers_plugins`
-- ----------------------------
DROP TABLE IF EXISTS `servers_plugins`;
CREATE TABLE `servers_plugins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of servers_plugins
-- ----------------------------

-- ----------------------------
-- Table structure for `servers_types`
-- ----------------------------
DROP TABLE IF EXISTS `servers_types`;
CREATE TABLE `servers_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of servers_types
-- ----------------------------
INSERT INTO `servers_types` VALUES ('1', 'Классический');
INSERT INTO `servers_types` VALUES ('2', 'Индастриал');
INSERT INTO `servers_types` VALUES ('3', 'RPG');
INSERT INTO `servers_types` VALUES ('4', 'Magic');
INSERT INTO `servers_types` VALUES ('5', 'Mini-Games');
INSERT INTO `servers_types` VALUES ('6', 'Creative');

-- ----------------------------
-- Table structure for `servers_versions`
-- ----------------------------
DROP TABLE IF EXISTS `servers_versions`;
CREATE TABLE `servers_versions` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of servers_versions
-- ----------------------------
INSERT INTO `servers_versions` VALUES ('1', '1.4.2');
INSERT INTO `servers_versions` VALUES ('2', '1.4.3');
INSERT INTO `servers_versions` VALUES ('3', '1.4.4');
INSERT INTO `servers_versions` VALUES ('4', '1.4.5');
INSERT INTO `servers_versions` VALUES ('5', '1.4.6');
INSERT INTO `servers_versions` VALUES ('6', '1.4.7');
INSERT INTO `servers_versions` VALUES ('7', '1.5');
INSERT INTO `servers_versions` VALUES ('8', '1.5.1');
INSERT INTO `servers_versions` VALUES ('9', '1.5.2');
INSERT INTO `servers_versions` VALUES ('10', '1.6.1');
INSERT INTO `servers_versions` VALUES ('11', '1.6.2');
INSERT INTO `servers_versions` VALUES ('12', '1.6.4');
INSERT INTO `servers_versions` VALUES ('13', '1.7.2');
INSERT INTO `servers_versions` VALUES ('14', '1.7.4');
INSERT INTO `servers_versions` VALUES ('15', '1.7.5');

-- ----------------------------
-- Table structure for `socials`
-- ----------------------------
DROP TABLE IF EXISTS `socials`;
CREATE TABLE `socials` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `secretkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of socials
-- ----------------------------
INSERT INTO `socials` VALUES ('1', 'Vkontakte', '');
INSERT INTO `socials` VALUES ('2', 'Facebook', '');

-- ----------------------------
-- Table structure for `tickets_messages`
-- ----------------------------
DROP TABLE IF EXISTS `tickets_messages`;
CREATE TABLE `tickets_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author` int(10) unsigned NOT NULL,
  `message` varchar(255) NOT NULL,
  `ticket` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tickets_messages_author_id` (`author`),
  KEY `tickets_messages_ticket_id` (`ticket`),
  CONSTRAINT `tickets_messages_author_id` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tickets_messages_ticket_id` FOREIGN KEY (`ticket`) REFERENCES `tickets_topics` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tickets_messages
-- ----------------------------

-- ----------------------------
-- Table structure for `tickets_topics`
-- ----------------------------
DROP TABLE IF EXISTS `tickets_topics`;
CREATE TABLE `tickets_topics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_topics_user_id` (`user`),
  CONSTRAINT `tickets_topics_user_id` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tickets_topics
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `show_all_projects` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'IlyaVorozhbit', 'ilya@mctop.im', '$1$AB0.Jy3.$5AH0dZVwos1E0gBv8FCI30', '2014-05-17', 'Илья', 'Ворожбит', '0', '1970-01-01', '21:35:25', 'ru', 'http://cs7011.vk.me/c614928/v614928037/c286/IdkuFoMR5ok.jpg', '0', '1');
INSERT INTO `users` VALUES ('2', 'IV', 'medvedkoo@xakep.ru', '$1$WA2.n40.$dOZ/OSVNv7s1j/AZTbXDW/', '2011-11-10', 'Ilya', 'Vorozhbit', '0', '1996-01-08', '20:53:47', 'ru', '', '0', '1');

-- ----------------------------
-- Table structure for `users_social_logins`
-- ----------------------------
DROP TABLE IF EXISTS `users_social_logins`;
CREATE TABLE `users_social_logins` (
  `user` int(10) unsigned NOT NULL,
  `system` tinyint(3) unsigned NOT NULL,
  `id_in_system` int(10) unsigned NOT NULL,
  `social_avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`user`,`id_in_system`),
  KEY `logins_system_id` (`system`),
  CONSTRAINT `logins_system_id` FOREIGN KEY (`system`) REFERENCES `socials` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `logins_user_id` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_social_logins
-- ----------------------------

-- ----------------------------
-- Table structure for `user_oauth`
-- ----------------------------
DROP TABLE IF EXISTS `user_oauth`;
CREATE TABLE `user_oauth` (
  `user_id` int(11) NOT NULL,
  `provider` varchar(45) NOT NULL,
  `identifier` varchar(64) NOT NULL,
  `profile_cache` text,
  `session_data` text,
  PRIMARY KEY (`provider`,`identifier`),
  UNIQUE KEY `unic_user_id_name` (`user_id`,`provider`),
  KEY `oauth_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_oauth
-- ----------------------------
INSERT INTO `user_oauth` VALUES ('2', 'Vkontakte', '222087037', 'a:22:{s:10:\"identifier\";i:222087037;s:10:\"webSiteURL\";N;s:10:\"profileURL\";s:24:\"http://vk.com/rodu.slava\";s:8:\"photoURL\";s:59:\"http://cs7011.vk.me/c614928/v614928037/c286/IdkuFoMR5ok.jpg\";s:11:\"displayName\";s:0:\"\";s:11:\"description\";N;s:9:\"firstName\";s:8:\"Илья\";s:8:\"lastName\";s:16:\"Ворожбит\";s:6:\"gender\";s:4:\"male\";s:8:\"language\";N;s:3:\"age\";N;s:8:\"birthDay\";i:1996;s:10:\"birthMonth\";i:1;s:9:\"birthYear\";i:8;s:5:\"email\";N;s:13:\"emailVerified\";N;s:5:\"phone\";N;s:7:\"address\";N;s:7:\"country\";N;s:6:\"region\";N;s:4:\"city\";N;s:3:\"zip\";N;}', 'a:6:{s:42:\"hauth_session.vkontakte.token.access_token\";s:93:\"s:85:\"666612b192d9c61712f04b99efe4c903609ec8342630c1272234a6601bb96881f3422511063b9c24448de\";\";s:43:\"hauth_session.vkontakte.token.refresh_token\";s:7:\"s:0:\"\";\";s:40:\"hauth_session.vkontakte.token.expires_in\";s:8:\"i:86400;\";s:40:\"hauth_session.vkontakte.token.expires_at\";s:13:\"i:1400366390;\";s:31:\"hauth_session.vkontakte.user_id\";s:12:\"i:222087037;\";s:36:\"hauth_session.vkontakte.is_logged_in\";s:4:\"i:1;\";}');

-- ----------------------------
-- Table structure for `votes`
-- ----------------------------
DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of votes
-- ----------------------------
INSERT INTO `votes` VALUES ('1', '127.0.0.1', '0Medvedkoo', '0000-00-00 00:00:00');
