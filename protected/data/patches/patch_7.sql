ALTER TABLE  `mdb_commands` CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;
ALTER TABLE  `mdb_commands` CHANGE  `parameter`  `parameter` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;
ALTER TABLE  `mdb_commands` CHANGE  `rights`  `rights` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;
ALTER TABLE  `mdb_commands` CHANGE  `description`  `description` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;
CREATE TABLE IF NOT EXISTS `english_mdb_commands` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `parameter` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `rights` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mdb_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
ALTER TABLE  `english_mdb` DROP  `commands` ;
