-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 01-Set-2018 às 12:56
-- Versão do servidor: 5.7.21
-- PHP Version: 7.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `speciesDatabase`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `camp_campaings`
--

DROP TABLE IF EXISTS `camp_campaings`;
CREATE TABLE IF NOT EXISTS `camp_campaings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(5120) COLLATE utf8_bin NOT NULL,
  `note` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `id_ref` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `camp_tombs`
--

DROP TABLE IF EXISTS `camp_tombs`;
CREATE TABLE IF NOT EXISTS `camp_tombs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_campaing` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_waypoint` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_specie` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `specie_count` tinyint(3) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `entity` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(5120) COLLATE utf8_bin NOT NULL,
  `note` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `id_ref` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--

-- --------------------------------------------------------

--
-- Estrutura da tabela `camp_waypoints`
--

DROP TABLE IF EXISTS `camp_waypoints`;
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `sp_species`
--

DROP TABLE IF EXISTS `sp_species`;
CREATE TABLE IF NOT EXISTS `sp_species` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` varchar(255) COLLATE utf8_bin NOT NULL,
  `specie` varchar(255) COLLATE utf8_bin NOT NULL,
  `dubious` tinyint(1) DEFAULT '0',
  `etymology` varchar(255) COLLATE utf8_bin NOT NULL,
  `common_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_taxon` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `incertae_sedis` tinyint(1) NOT NULL DEFAULT '0',
  `year` varchar(4) COLLATE utf8_bin NOT NULL,
  `revised` tinyint(1) NOT NULL DEFAULT '0',
  `validate` tinyint(1) NOT NULL DEFAULT '1',
  `redirect` varchar(255) COLLATE utf8_bin NOT NULL,
  `habitat` varchar(255) COLLATE utf8_bin NOT NULL,
  `distribution` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(5120) COLLATE utf8_bin NOT NULL,
  `note` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sp_taxa`
--

DROP TABLE IF EXISTS `sp_taxa`;
CREATE TABLE IF NOT EXISTS `sp_taxa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `etymology` varchar(255) COLLATE utf8_bin NOT NULL,
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `sp_taxa_types`
--

DROP TABLE IF EXISTS `sp_taxa_types`;
CREATE TABLE IF NOT EXISTS `sp_taxa_types` (
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `sp_taxonomists`
--

DROP TABLE IF EXISTS `sp_taxonomists`;
CREATE TABLE IF NOT EXISTS `sp_taxonomists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(5120) COLLATE utf8_bin NOT NULL,
  `note` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sp_taxonomists_map`
--

DROP TABLE IF EXISTS `sp_taxonomists_map`;
CREATE TABLE IF NOT EXISTS `sp_taxonomists_map` (
  `id_specie` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_taxonomist` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
