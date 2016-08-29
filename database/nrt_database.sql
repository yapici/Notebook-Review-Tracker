-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Aug 29, 2016 at 04:17 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `notebook_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `notebook_id`, `sender_id`, `datetime`, `comment`) VALUES
(1, 2, 13, '2016-08-27 14:00:35', '1'),
(2, 2, 1, '2016-08-27 14:01:28', 'dsgsdf'),
(3, 2, 13, '2016-08-27 14:02:34', 'dfdsg'),
(4, 2, 12, '2016-08-27 14:02:53', 'dsgfsg'),
(5, 2, 23, '2016-08-27 14:03:17', 'dsfsg'),
(6, 2, 13, '2016-08-27 14:05:03', 'sdgfd'),
(7, 2, 1, '2016-08-27 14:05:25', 'sdgfdg'),
(8, 2, 13, '2016-08-27 14:05:43', 'sdgfdfh'),
(9, 2, 1, '2016-08-27 14:06:50', 'qewrtyuiyo'),
(10, 2, 13, '2016-08-27 16:35:39', 'adsfsdfg'),
(11, 0, 1, '2016-08-27 16:35:59', 'sgf'),
(12, 0, 1, '2016-08-27 16:36:07', 'dfsd'),
(13, 23, 1, '2016-08-27 16:36:26', 'dgf'),
(14, 0, 1, '2016-08-27 16:37:05', 'xzvc'),
(15, 7, 1, '2016-08-27 16:38:28', 'dfd'),
(16, 4, 1, '2016-08-27 16:54:45', ''),
(17, 7, 1, '2016-08-27 16:55:11', ''),
(18, 3, 1, '2016-08-27 17:05:17', ''),
(19, 4, 1, '2016-08-27 17:07:20', 'df'),
(20, 2, 1, '2016-08-27 17:28:54', 'dsfdsgsdg'),
(21, 11, 1, '2016-08-27 18:15:11', 'fsgfd');

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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

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
(9, 'DIV3 Project6-000003', 1, 10, '2016-08-23 00:25:46', 1, '2016-08-22 19:25:46', 'adfds'),
(10, 'DIV2 Project7-012345', 1, 10, '2016-08-23 03:37:10', 1, '2016-08-22 22:37:10', 'test'),
(11, 'DIV2 Project2-000023', 1, 9, '2016-08-24 14:30:11', 1, '2016-08-24 09:30:11', 'dfdsfg'),
(12, 'DIV1 Project4-000005', 1, 9, '2016-08-24 15:14:47', 1, '2016-08-24 10:14:47', 'tryturftyu'),
(13, 'DIV2 Project2-000032', 16, 1, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(14, 'DIV2 Project2-000032', 1, 12, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(15, 'DIV2 Project2-000032', 1, 13, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(16, 'DIV2 Project2-000032', 1, 14, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(17, 'DIV2 Project2-000032', 1, 15, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(18, 'DIV2 Project2-000032', 1, 16, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(19, 'DIV2 Project2-000032', 22, 1, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(20, 'DIV2 Project2-000032', 1, 1, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(21, 'DIV2 Project2-000032', 1, 34, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(22, 'DIV2 Project2-000032', 15, 1, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(23, 'DIV2 Project2-000032', 9, 1, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(24, 'DIV2 Project2-000032', 13, 1, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(25, 'DIV2 Project2-000032', 25, 1, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(26, 'DIV2 Project2-000032', 1, 23, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(27, 'DIV2 Project2-000032', 1, 12, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(28, 'DIV2 Project2-000032', 1, 43, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(29, 'DIV2 Project2-000032', 1, 44, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(30, 'DIV2 Project2-000032', 1, 32, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments'),
(31, 'DIV2 Project2-000032', 1, 44, '2016-08-25 03:41:41', 1, '2016-08-24 22:41:41', 'Comments');

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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `notebooks`
--
ALTER TABLE `notebooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
