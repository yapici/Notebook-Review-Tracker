-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Aug 23, 2016 at 03:13 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nrt_database`
--
CREATE DATABASE IF NOT EXISTS `nrt_database` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `nrt_database`;

-- --------------------------------------------------------

--
-- Table structure for table `notebooks`
--

CREATE TABLE IF NOT EXISTS `notebooks` (
  `id` int(11) NOT NULL,
  `notebook_no` varchar(30) NOT NULL,
  `author_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `last_modified_date` datetime NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notebooks`
--

INSERT INTO `notebooks` (`id`, `notebook_no`, `author_id`, `reviewer_id`, `created_date`, `status_id`, `last_modified_date`, `comments`) VALUES
(1, 'DIV1 Project2-000001', 1, 9, '2016-08-05 16:05:42', 1, '0000-00-00 00:00:00', ''),
(2, 'DIV1 Project2-000002', 9, 1, '2016-08-05 16:05:42', 1, '0000-00-00 00:00:00', ''),
(3, '11', 1, 9, '2016-08-22 04:34:57', 1, '2016-08-21 23:34:57', 'comment1'),
(4, '11', 1, 9, '2016-08-22 11:15:03', 1, '2016-08-22 06:15:03', 'comment1'),
(5, '11', 1, 9, '2016-08-22 11:15:08', 1, '2016-08-22 06:15:08', 'comment1'),
(6, 'DIV2 Project2-000333', 1, 9, '2016-08-22 23:33:46', 1, '2016-08-22 18:33:46', 'dfdfd'),
(7, 'DIV4 Project7-000213', 9, 10, '2016-08-23 00:25:10', 1, '2016-08-22 19:25:10', 'dfsdsd'),
(8, 'DIV3 Project6-000003', 9, 10, '2016-08-23 00:25:45', 1, '2016-08-22 19:25:45', 'adfds'),
(9, 'DIV3 Project6-000003', 1, 10, '2016-08-23 00:25:46', 1, '2016-08-22 19:25:46', 'adfds');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(40) NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `deleted_by_user_id` int(11) DEFAULT '0',
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status_name`, `created_by_user_id`, `created_date`, `deleted`, `deleted_by_user_id`, `deleted_date`) VALUES
(1, 'In Review', 1, '2016-08-05 14:44:54', 0, 0, '0000-00-00 00:00:00'),
(2, 'Returned to Author', 1, '2016-08-05 14:44:54', 0, 0, '0000-00-00 00:00:00'),
(3, 'Verified', 1, '2016-08-05 15:03:02', 0, 0, '0000-00-00 00:00:00'),
(4, 'Terminated', 1, '2016-08-05 15:03:02', 0, 0, '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notebooks`
--
ALTER TABLE `notebooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notebooks`
--
ALTER TABLE `notebooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
