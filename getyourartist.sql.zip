-- phpMyAdmin SQL Dump
-- version 4.0.10.16
-- http://www.phpmyadmin.net
--
-- Host: mysql
-- Generation Time: Feb 26, 2021 at 08:21 PM
-- Server version: 5.1.55
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `getyourartist`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists_profile`
--

CREATE TABLE IF NOT EXISTS `artists_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artistid` int(11) NOT NULL,
  `displayname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `bio` text COLLATE utf8_unicode_ci NOT NULL,
  `fees` int(11) NOT NULL,
  `profilepicture` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `gyausers`
--

CREATE TABLE IF NOT EXISTS `gyausers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `obfus` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `usertype` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `regdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `obfus` (`obfus`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
