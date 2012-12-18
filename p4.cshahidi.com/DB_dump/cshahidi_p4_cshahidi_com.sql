-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 18, 2012 at 04:28 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cshahidi_p4_cshahidi_com`
--

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE IF NOT EXISTS `leads` (
  `lead_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL COMMENT 'who referred lead',
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` char(2) NOT NULL,
  `zipcode` char(5) NOT NULL,
  `vacant` enum('no','yes') NOT NULL,
  `mls_listing` enum('no','yes') NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `baths` float NOT NULL COMMENT 'can be e.g. 1.5',
  `liv_area_sqft` int(11) NOT NULL,
  `lot_size_sqft` int(11) NOT NULL,
  `type` enum('single','condo','2family','3family','4familyplus') NOT NULL,
  `year_built` int(11) NOT NULL,
  `asking_price` int(11) NOT NULL,
  `estimated_repairs` int(11) NOT NULL,
  `arv` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`lead_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`lead_id`, `created`, `modified`, `partner_id`, `address`, `city`, `state`, `zipcode`, `vacant`, `mls_listing`, `bedrooms`, `baths`, `liv_area_sqft`, `lot_size_sqft`, `type`, `year_built`, `asking_price`, `estimated_repairs`, `arv`, `comment`, `status`) VALUES
(5, 1355767435, 1355767435, 1, '45 Stowe Ro', 'Belmont', 'MA', '02149', 'no', 'no', 5, 2, 1800, 1900, '2family', 1978, 300000, 15000, 360000, 'Nick''s Second Lead', 'pending'),
(6, 1355767515, 1355767515, 1, '20 Tahoe St', 'San Francisco', 'CA', '90234', 'no', 'no', 2, 1, 980, 1000, 'condo', 1945, 450000, 20000, 520000, '', 'pending'),
(7, 1355809961, 1355809961, 1, '30 Wachusetts Road', 'Westford', 'MA', '02345', 'yes', 'yes', 10, 2.5, 24000, 3000, '2family', 1948, 180000, 10000, 240000, '', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE IF NOT EXISTS `partners` (
  `partner_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`partner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`partner_id`, `user_id`) VALUES
(1, 4),
(2, 6),
(3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `principals`
--

CREATE TABLE IF NOT EXISTS `principals` (
  `principal_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`principal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `principals`
--

INSERT INTO `principals` (`principal_id`, `user_id`) VALUES
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','principal','partner') NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This is also similar to the P2 "users" table' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `created`, `modified`, `token`, `password`, `first_name`, `last_name`, `email`, `role`) VALUES
(1, 0, 0, '', '', '', '', '', 'admin'),
(2, 1355688901, 1355688901, 'fb512aead3b73e2c5e46544e5c0f2c5da8ef26fc', '84802489959df1bc7124a1a492192d518c1c49db', 'fff', '', '', ''),
(3, 1355712287, 1355712287, '2285325c796c4e12f3d015a285487d4166220d8f', '9a8c2065ef4fcf1d8eddc9b9b5e95d381b555dc7', 'Judy', 'Grimes', 'judy@gmail.com', ''),
(4, 1355715549, 1355715549, 'fc541f871ea38c2e1349ca9792e13c81435ceb1c', '6a6e51138204db3a4a9591485179e2dc14614ded', 'Nick', 'Burns', 'nick@gmail.com', 'partner'),
(5, 1355716475, 1355716475, 'cfa9b3cfafd6d4893225ff78650b4c7b138e325f', '053903f206653575eb0a9a89c539a865a24757bc', 'Camran', 'Shahidi', 'camran@gmail.com', 'principal'),
(6, 1355806654, 1355806654, '6fc5692aced2e16775f83bc47acb1e2405e67c71', 'a10cde0c328c916a3705f4ad884722811c50f05d', 'Matt', 'Foley', 'matt@gmail.com', 'partner'),
(7, 1355847161, 1355847161, 'fce176576b8cf7d4797b65cc1adbff52aeb0b4fa', '53d0ff2c0ecd5688bd2341e24636b23b43eb7d02', 'Elvis', 'Presley', 'elvis@gmail.com', 'partner');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
