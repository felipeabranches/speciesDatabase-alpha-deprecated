CREATE TABLE IF NOT EXISTS `wpt_provinces` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(63) NOT NULL,
`acronym` varchar(3) NOT NULL,
`id_country` int(11) NOT NULL,
`description` varchar(5120) COLLATE utf8_bin NOT NULL,
`note` varchar(255) COLLATE utf8_bin NOT NULL,
`image` varchar(255) COLLATE utf8_bin NOT NULL,
`published` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
