--
-- Estrutura da tabela `camp_units`
--

CREATE TABLE IF NOT EXISTS `wpt_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_parent` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_type` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `level` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `description` varchar(5120) COLLATE utf8_bin NOT NULL,
  `note` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `id_ref` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Estrutura da tabela `camp_units_types`
--

CREATE TABLE IF NOT EXISTS `wpt_units_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `order` tinyint(3) NOT NULL DEFAULT '0',
  `description` varchar(5120) COLLATE utf8_bin NOT NULL,
  `note` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `id_ref` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Estrutura da tabela `wpt_countries`
--

CREATE TABLE IF NOT EXISTS `wpt_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(63) NOT NULL,
  `nicename` varchar(63) NOT NULL,
  `iso` char(2) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  `description` varchar(5120) COLLATE utf8_bin NOT NULL,
  `note` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Estrutura da tabela `wpt_places`
--

CREATE TABLE IF NOT EXISTS `wpt_places` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(63) NOT NULL,
`id_province` int(11) NOT NULL,
`description` varchar(5120) COLLATE utf8_bin NOT NULL,
`note` varchar(255) COLLATE utf8_bin NOT NULL,
`image` varchar(255) COLLATE utf8_bin NOT NULL,
`published` tinyint(1) NOT NULL DEFAULT '1',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Estrutura da tabela `wpt_provinces`
--

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

--
-- Estrutura da tabela `camp_waypoints`
--

CREATE TABLE IF NOT EXISTS `camp_waypoints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_unit` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `place` varchar(255) COLLATE utf8_bin NOT NULL,
  `latitude` decimal(11,7) NOT NULL,
  `longitude` decimal(11,7) NOT NULL,
  `date` date NOT NULL,
  `entity` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(5120) COLLATE utf8_bin NOT NULL,
  `note` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `id_ref` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Changes in `camp_waypoints`
--
# Rename table name "camp_waypoints" to "wpt_waypoints"
RENAME TABLE camp_waypoints TO wpt_waypoints;
# Alter "latitude" type of data to POINT
ALTER TABLE `wpt_waypoints` CHANGE `latitude` `latitude` POINT NOT NULL;
# Alter "longitude" type of data to POINT
ALTER TABLE `wpt_waypoints` CHANGE `longitude` `longitude` POINT NOT NULL;
# Alter "date" to "time" and change its data type (DATETIME or TIMESTAMP)
ALTER TABLE `wpt_waypoints` CHANGE `date` `time` DATETIME NOT NULL;
# Add "elevation" and define its data type
ALTER TABLE `wpt_waypoints` ADD `elevation` DECIMAL(10,6) UNSIGNED NULL AFTER `longitude`;
# Add "symbol" and define its data type
ALTER TABLE `wpt_waypoints` ADD `symbol` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Flag, Blue' AFTER `time`;
# Drop "entity"
ALTER TABLE `wpt_waypoints` DROP `entity`;
# Drop "id_ref"
ALTER TABLE `wpt_waypoints` DROP `id_ref`;
