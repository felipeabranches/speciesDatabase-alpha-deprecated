
--
-- `piscis_morphology` table structure
--
CREATE TABLE `piscis_morphology` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tomb` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'TABLE piscis',
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'male or female',
  `weight` float(6,3) NOT NULL DEFAULT '0.000',
  `height` float(6,3) NOT NULL DEFAULT '0.000',
  `total_length` float(6,3) NOT NULL DEFAULT '0.000',
  `default_length` float(6,3) NOT NULL DEFAULT '0.000',
  `lateral_line` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

