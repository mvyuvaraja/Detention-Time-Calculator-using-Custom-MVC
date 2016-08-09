-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2016 at 03:57 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `detentions`
--

DROP TABLE IF EXISTS `detentions`;
CREATE TABLE IF NOT EXISTS `detentions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `roll_no` int(11) unsigned NOT NULL,
  `student_name` varchar(128) NOT NULL,
  `offense_id` int(11) unsigned NOT NULL,
  `time_type` enum('Good','Bad') NOT NULL DEFAULT 'Good',
  `calc_mode` enum('Concurrent','Consecutive') NOT NULL DEFAULT 'Concurrent',
  `recorded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `calc_mode` (`calc_mode`),
  KEY `time_type` (`time_type`),
  KEY `offense_id` (`offense_id`),
  KEY `student_name` (`student_name`),
  KEY `roll_no` (`roll_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `offenses`
--

DROP TABLE IF EXISTS `offenses`;
CREATE TABLE IF NOT EXISTS `offenses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `detention_period` float unsigned NOT NULL COMMENT 'in Hours',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `offenses`
--

INSERT INTO `offenses` (`id`, `name`, `detention_period`) VALUES
(6, 'Homework Not Done', 1),
(7, 'Stealing', 2),
(8, 'Fighting', 0.5),
(9, 'Untidyness', 1),
(10, 'Lying', 1.5),
(11, 'SchoolPropertyDamage', 1.5);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detentions`
--
ALTER TABLE `detentions`
  ADD CONSTRAINT `detentions_ibfk_1` FOREIGN KEY (`offense_id`) REFERENCES `offenses` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
