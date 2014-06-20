-- ----------------------------
-- Table structure for `english_mdb`
-- ----------------------------
DROP TABLE IF EXISTS `english_mdb`;
CREATE TABLE `english_mdb` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `commands` text,
  PRIMARY KEY (`id`),
  CONSTRAINT `english_mdb_id` FOREIGN KEY (`id`) REFERENCES `mdb` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `english_news_categories`
-- ----------------------------
DROP TABLE IF EXISTS `english_news_categories`;
CREATE TABLE `english_news_categories` (
  `category` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`category`),
  CONSTRAINT `english_news_categories_id` FOREIGN KEY (`category`) REFERENCES `news_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `english_news_post`
-- ----------------------------
DROP TABLE IF EXISTS `english_news_post`;
CREATE TABLE `english_news_post` (
  `post` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `few_words` varchar(255) NOT NULL,
  `full` text NOT NULL,
  `tags` varchar(255) NOT NULL,
  PRIMARY KEY (`post`),
  CONSTRAINT `english_news_post_id` FOREIGN KEY (`post`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `english_project`
-- ----------------------------
DROP TABLE IF EXISTS `english_project`;
CREATE TABLE `english_project` (
  `project` int(11) unsigned NOT NULL,
  `description` text NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`project`),
  CONSTRAINT `english_project_descriptions` FOREIGN KEY (`project`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `english_server`
-- ----------------------------
DROP TABLE IF EXISTS `english_server`;
CREATE TABLE `english_server` (
  `server` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`server`),
  CONSTRAINT `english_server_id` FOREIGN KEY (`server`) REFERENCES `servers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

