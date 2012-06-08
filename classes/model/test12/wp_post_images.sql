--
-- テーブルの構造 `wp332_post_images`
--

CREATE TABLE IF NOT EXISTS `wp332_post_images` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `extention` varchar(10) NOT NULL DEFAULT '',
  `org_name` varchar(200) NOT NULL DEFAULT '',
  `uq_name` varchar(200) NOT NULL DEFAULT '',
  `tn1_name` varchar(200) NOT NULL DEFAULT '',
  `tn2_name` varchar(200) NOT NULL DEFAULT '',
  `title` varchar(200) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `tn1_img` MEDIUMBLOB NOT NULL,
  `tn2_img` MEDIUMBLOB NOT NULL,
  `org_img` MEDIUMBLOB NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

