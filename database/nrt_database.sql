-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Sep 01, 2016 at 01:07 AM
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
-- Table structure for table `audit_trail`
--

CREATE TABLE IF NOT EXISTS `audit_trail` (
  `id` int(11) NOT NULL,
  `changed_table` varchar(20) NOT NULL,
  `changed_item_id` int(11) NOT NULL,
  `changed_field_name` varchar(100) NOT NULL,
  `old_value` varchar(1000) NOT NULL,
  `new_value` varchar(1000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`id`, `changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `date`, `user_id`) VALUES
(1, 'notebooks', 46, 'status_id', '2', '1', '2016-08-31 22:57:31', 1),
(2, 'notebooks', 46, 'last_modified_by', '0', '1', '2016-08-31 22:57:31', 1),
(3, 'notebooks', 46, 'status_id', '1', '2', '2016-08-31 22:59:56', 1),
(4, 'notebooks', 46, 'last_modified_date', '2016-08-31 15:10:47', '2016-08-31 17:59:56', '2016-08-31 22:59:56', 1),
(5, 'notebooks', 47, 'NEW_ITEM', 'NEW_ITEM', 'DIV1 Project2-002345', '2016-08-31 23:00:27', 1),
(6, 'comments', 105, 'NEW_ITEM', 'NEW_ITEM', 'test', '2016-08-31 23:05:31', 1),
(7, 'notebooks', 1, 'notebook_id', '8', '7', '2016-08-31 23:05:50', 1),
(8, 'notebooks', 1, 'notebook_id', '7', '8', '2016-08-31 23:05:52', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `notebook_id`, `sender_id`, `datetime`, `comment`) VALUES
(1, 8, 1, '2016-08-30 13:38:57', 'testing'),
(2, 8, 1, '2016-08-30 13:39:06', 'testing<br />\n<br />\ntesting'),
(3, 8, 1, '2016-08-30 13:42:50', 'test'),
(4, 8, 1, '2016-08-30 13:43:15', 'test'),
(5, 8, 1, '2016-08-30 13:44:34', 'test'),
(6, 8, 1, '2016-08-30 13:45:10', 'test'),
(7, 8, 1, '2016-08-30 13:46:10', 'df'),
(8, 8, 1, '2016-08-30 17:16:34', 'dsgfdhgf'),
(9, 8, 1, '2016-08-30 17:20:09', 'sadsgfh'),
(10, 8, 1, '2016-08-30 17:22:47', 'sfdgfhgnjh'),
(11, 8, 1, '2016-08-30 17:22:49', 'sfdgfhgnjhdsfbd'),
(12, 8, 1, '2016-08-30 17:22:57', 'aaaaaaÃ¦a'),
(13, 8, 1, '2016-08-30 17:27:35', 'ffffff'),
(14, 8, 1, '2016-08-30 17:29:07', 'rrrrr'),
(15, 8, 1, '2016-08-30 17:29:45', 'fgf'),
(16, 8, 1, '2016-08-30 17:31:27', 'eeeee'),
(17, 8, 1, '2016-08-30 17:32:18', 'ggg'),
(18, 8, 1, '2016-08-30 17:33:11', 'dfdd'),
(19, 8, 1, '2016-08-30 17:33:14', 'fdfdg'),
(20, 8, 1, '2016-08-30 17:33:32', 'sfdgfhjmmhgfds'),
(21, 7, 1, '2016-08-30 17:33:42', 'scafdaew'),
(22, 7, 1, '2016-08-30 17:33:44', 'dsferw'),
(23, 7, 1, '2016-08-30 17:33:45', 'sdfasgerwq'),
(24, 7, 1, '2016-08-30 17:33:46', 'dfagewq'),
(25, 7, 1, '2016-08-30 17:33:47', 'weafgsdewq'),
(26, 7, 1, '2016-08-30 17:34:47', 'sadsfdew'),
(27, 7, 1, '2016-08-30 17:34:48', 'svfdasa'),
(28, 7, 1, '2016-08-30 17:34:49', 'asadvsdfs'),
(29, 8, 1, '2016-08-31 11:35:15', 'fdgfdsq'),
(30, 8, 1, '2016-08-31 11:35:16', 'fsdaadf'),
(31, 8, 1, '2016-08-31 11:35:21', 'vfsds'),
(32, 8, 1, '2016-08-31 11:37:10', 'xcxvnbbdfsa'),
(33, 8, 1, '2016-08-31 11:37:11', 'sadsfdbgfew'),
(34, 8, 1, '2016-08-31 11:37:13', 'sadfsgds'),
(35, 8, 1, '2016-08-31 11:37:40', 'dafsdghfsdas<br />\n<br />\nadsfdbgfsa<br />\n<br />\n<br />\nsadfghffsa'),
(36, 0, 1, '2016-08-31 11:51:10', 'test'),
(37, 0, 1, '2016-08-31 12:01:26', 'sdsfdvew'),
(38, 13, 1, '2016-08-31 12:11:02', 'Comments'),
(39, 14, 1, '2016-08-31 12:12:21', 'Comments'),
(40, 15, 1, '2016-08-31 12:20:02', 'Comments'),
(41, 18, 1, '2016-08-31 12:21:06', 'test'),
(42, 27, 1, '2016-08-31 12:51:50', 'fdsafdasf'),
(43, 14, 1, '2016-08-31 12:52:07', 'dfghgfds'),
(44, 14, 1, '2016-08-31 12:52:09', 'sADSFDGFF'),
(45, 22, 1, '2016-08-31 12:53:44', 'sadsfdd'),
(46, 22, 1, '2016-08-31 12:53:47', 'sfdsd'),
(47, 22, 1, '2016-08-31 12:54:23', 'fgfgdsa'),
(48, 22, 1, '2016-08-31 12:54:25', 'dfdss'),
(49, 26, 1, '2016-08-31 12:55:45', 'sfdd'),
(50, 26, 1, '2016-08-31 12:55:47', 'sdfsd'),
(51, 26, 1, '2016-08-31 12:55:50', 'sds'),
(52, 26, 1, '2016-08-31 12:55:51', 'csd'),
(53, 22, 1, '2016-08-31 12:56:14', 'dfd'),
(54, 21, 1, '2016-08-31 12:57:30', 'sds'),
(55, 21, 1, '2016-08-31 12:57:33', 'sds'),
(56, 21, 1, '2016-08-31 12:57:35', 'sdsd'),
(57, 21, 1, '2016-08-31 12:57:36', 'sdsd'),
(58, 21, 1, '2016-08-31 12:57:37', 'sdsd'),
(59, 21, 1, '2016-08-31 12:57:38', 'sds'),
(60, 21, 1, '2016-08-31 12:57:39', 'dfdgnfhgj'),
(61, 21, 1, '2016-08-31 12:57:40', 'gfhgjkhlj'),
(62, 21, 1, '2016-08-31 12:57:41', 'fgdhfjgkh'),
(63, 21, 1, '2016-08-31 12:57:42', 'sfgdhfjgk'),
(64, 21, 1, '2016-08-31 12:57:44', 'sfdghfjgkh'),
(65, 21, 1, '2016-08-31 12:58:07', 'sfds'),
(66, 0, 1, '2016-08-31 13:20:44', 'test'),
(67, 35, 1, '2016-08-31 13:42:50', 'test'),
(68, 35, 1, '2016-08-31 13:42:53', 'test'),
(69, 35, 1, '2016-08-31 13:42:54', 'test'),
(70, 35, 1, '2016-08-31 13:42:57', 'test<br />\n<br />\n<br />\ntest'),
(71, 35, 1, '2016-08-31 13:42:58', 'test'),
(72, 35, 1, '2016-08-31 13:43:00', 'test'),
(73, 35, 1, '2016-08-31 13:43:05', 'test<br />\n<br />\nteste<br />\n<br />\n<br />\n<br />\nstets<br />\n<br />\ntetd'),
(74, 35, 1, '2016-08-31 13:43:35', 'What is Lorem Ipsum?<br />\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br />\n<br />\nWhy do we use it?<br />\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).'),
(75, 37, 1, '2016-08-31 13:44:16', 'What is Lorem Ipsum?<br />\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br />\n<br />\nWhy do we use it?<br />\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).'),
(76, 37, 1, '2016-08-31 13:45:38', 'What is Lorem Ipsum?<br />\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br />\n<br />\nWhy do we use it?<br />\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).'),
(77, 37, 1, '2016-08-31 13:51:52', 'aSDF'),
(78, 37, 1, '2016-08-31 13:51:56', 'ZCXZVZC'),
(79, 37, 1, '2016-08-31 13:51:58', 'sadsfdgdfds'),
(80, 37, 1, '2016-08-31 13:52:01', 'wergh<br />\n<br />\ndsfgdhrterwq'),
(81, 37, 1, '2016-08-31 13:52:23', 'dfghjkhtyree dwfgehrte wqw wef wgreht yer weq wwqe fwgreht y tew rg re g   qefwgrehtregfwqd dwefwrget rwqqrtyewqw qewretr erewqeqrwte'),
(82, 43, 1, '2016-08-31 14:11:52', 'test'),
(83, 43, 1, '2016-08-31 14:12:00', 'test<br />\n<br />\ntest<br />\ntest'),
(84, 43, 1, '2016-08-31 14:16:57', 'xcvbcvn'),
(85, 43, 1, '2016-08-31 14:17:46', 'sadfsd'),
(86, 43, 1, '2016-08-31 14:21:25', 'stet'),
(87, 43, 1, '2016-08-31 14:24:03', 'df'),
(88, 42, 1, '2016-08-31 14:24:11', 'dszfdxgfchvjbkjhgfdsa'),
(89, 43, 1, '2016-08-31 14:28:45', 'sadfgh'),
(90, 43, 1, '2016-08-31 14:28:51', 'sadzfxghgjfgdsa'),
(91, 0, 1, '2016-08-31 20:07:29', 'testing'),
(92, 46, 1, '2016-08-31 22:00:00', 'sdsfgdhfgjhkj'),
(93, 46, 1, '2016-08-31 22:00:01', 'sadsfgdhjkl;/,&gt;?'),
(94, 46, 1, '2016-08-31 22:00:04', 'sadfsgdh<br />\njgk<br />\new<br />\nerwtey<br />\nutyk<br />\njhgfedrthj'),
(95, 46, 1, '2016-08-31 22:00:16', '&lt;&gt;'),
(96, 46, 1, '2016-08-31 22:01:17', 'edfdgfhgjkhgh%3C%3E'),
(97, 46, 1, '2016-08-31 22:01:25', 'safdsg%0Ad%0A%0Aew%0Artethrter'),
(98, 46, 1, '2016-08-31 22:18:48', '23456'),
(99, 46, 1, '2016-08-31 22:18:51', '%2C.'),
(100, 46, 1, '2016-08-31 22:19:08', ')(*%26%5E%25'),
(101, 46, 1, '2016-08-31 22:23:54', '&lt;&gt;'),
(102, 46, 1, '2016-08-31 22:24:11', '&lt;script&gt;alert(&quot;sds&quot;)&lt;/script&gt;'),
(103, 46, 1, '2016-08-31 22:24:24', '&amp;*()(*&amp;^%$#'),
(104, 46, 1, '2016-08-31 22:25:48', 'EWRGeht<br />\n<br />\newgr<br />\n<br />\nw<br />\nf<br />\nweg<br />\n&lt;&gt;??<br />\n;@#$%^$#@#'),
(105, 46, 1, '2016-08-31 23:05:31', 'test');

--
-- Triggers `comments`
--
DELIMITER $$
CREATE TRIGGER `after_insert_comments` AFTER INSERT ON `comments`
 FOR EACH ROW INSERT INTO audit_trail 
            (`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
        VALUES 
            ("comments", NEW.id, "NEW_ITEM", "NEW_ITEM", NEW.comment, NEW.sender_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_comments` AFTER UPDATE ON `comments`
 FOR EACH ROW begin
IF OLD.id != NEW.id THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "id", OLD.id, NEW.id, NEW.sender_id);
END IF;

IF OLD.notebook_id != NEW.notebook_id THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "notebook_id", OLD.notebook_id, NEW.notebook_id, NEW.sender_id);
END IF;

IF OLD.sender_id != NEW.sender_id THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "sender_id", OLD.sender_id, NEW.sender_id, NEW.sender_id);
END IF;

IF OLD.datetime != NEW.datetime THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "datetime", OLD.datetime, NEW.datetime, NEW.sender_id);
END IF;

IF OLD.comment != NEW.comment THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "comment", OLD.comment, NEW.comment, NEW.sender_id);
END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notebooks`
--

CREATE TABLE IF NOT EXISTS `notebooks` (
  `id` int(11) NOT NULL,
  `notebook_no` varchar(30) NOT NULL,
  `author_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `last_modified_by` int(11) NOT NULL,
  `last_modified_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notebooks`
--

INSERT INTO `notebooks` (`id`, `notebook_no`, `author_id`, `reviewer_id`, `created_by`, `created_date`, `status_id`, `last_modified_by`, `last_modified_date`) VALUES
(1, 'DIV1 Project1-000001', 1, 17, 0, '2016-08-29 23:00:20', 1, 0, '2016-08-29 18:00:20'),
(2, 'DIV1 Project1-000002', 1, 14, 0, '2016-08-29 23:02:22', 1, 0, '2016-08-29 18:02:22'),
(3, 'DIV2 Project1-000003', 1, 11, 0, '2016-08-30 13:19:28', 1, 0, '2016-08-30 08:19:28'),
(4, 'DIV2 Project2-000001', 1, 9, 0, '2016-08-30 13:22:32', 1, 0, '2016-08-30 08:22:32'),
(5, 'DIV1 Project1-000004', 1, 17, 0, '2016-08-30 13:23:13', 1, 0, '2016-08-30 08:23:13'),
(6, 'DIV3 Project2-000001', 1, 15, 0, '2016-08-30 13:25:45', 1, 0, '2016-08-30 08:25:45'),
(7, 'DIV3 Project4-000004', 1, 14, 0, '2016-08-30 13:26:07', 1, 0, '2016-08-30 08:26:07'),
(8, 'DIV4 Project2-000005', 1, 12, 0, '2016-08-30 13:26:25', 1, 0, '2016-08-30 08:26:25'),
(9, 'DIV3 Project2-000003', 1, 11, 0, '2016-08-30 13:27:07', 1, 0, '2016-08-30 08:27:07'),
(10, 'DIV3 Project2-000006', 1, 17, 0, '2016-08-30 13:27:42', 1, 0, '2016-08-30 08:27:42'),
(11, 'DIV1 Project4-000004', 1, 9, 0, '2016-08-31 11:51:10', 1, 0, '2016-08-31 06:51:10'),
(12, 'DIV2 Project2-000222', 1, 11, 0, '2016-08-31 12:01:26', 1, 0, '2016-08-31 07:01:26'),
(13, 'DIV1 Project2-000003', 1, 11, 0, '2016-08-31 12:11:02', 1, 0, '2016-08-31 07:11:02'),
(14, 'DIV3 Project1-000111', 1, 9, 0, '2016-08-31 12:12:21', 1, 0, '2016-08-31 07:12:21'),
(15, 'DIV1 Project1-002222', 1, 17, 0, '2016-08-31 12:20:02', 1, 0, '2016-08-31 07:20:02'),
(16, 'DIV1 Project1-000333', 1, 11, 0, '2016-08-31 12:20:26', 1, 0, '2016-08-31 07:20:26'),
(17, 'DIV1 Project1-000034', 1, 17, 0, '2016-08-31 12:20:45', 1, 0, '2016-08-31 07:20:45'),
(18, 'DIV1 Project6-001111', 1, 11, 0, '2016-08-31 12:21:06', 1, 0, '2016-08-31 07:21:06'),
(19, 'DIV1 Project4-003333', 1, 13, 0, '2016-08-31 12:21:56', 1, 0, '2016-08-31 07:21:56'),
(20, 'DIV1 Project1-000555', 1, 17, 0, '2016-08-31 12:23:16', 1, 0, '2016-08-31 07:23:16'),
(21, 'DIV1 Project1-000666', 1, 14, 0, '2016-08-31 12:28:36', 1, 0, '2016-08-31 07:28:36'),
(22, 'DIV1 Project1-000777', 1, 15, 0, '2016-08-31 12:28:57', 1, 0, '2016-08-31 07:28:57'),
(23, 'DIV1 Project1-000888', 1, 17, 0, '2016-08-31 12:30:37', 1, 0, '2016-08-31 07:30:37'),
(24, 'DIV1 Project1-000999', 1, 13, 0, '2016-08-31 12:42:07', 1, 0, '2016-08-31 07:42:07'),
(25, 'DIV1 Project1-001111', 1, 9, 0, '2016-08-31 12:44:09', 1, 0, '2016-08-31 07:44:09'),
(26, 'DIV1 Project1-002222', 1, 15, 0, '2016-08-31 12:51:33', 1, 0, '2016-08-31 07:51:33'),
(27, 'DIV1 Project1-003333', 1, 17, 0, '2016-08-31 12:51:50', 1, 0, '2016-08-31 07:51:50'),
(28, 'DIV1 Project1-004444', 1, 13, 0, '2016-08-31 13:20:44', 1, 0, '2016-08-31 08:20:44'),
(29, 'DIV1 Project2-005555', 1, 17, 0, '2016-08-31 13:28:56', 1, 0, '2016-08-31 08:28:56'),
(30, 'DIV1 Project1-006666', 1, 16, 0, '2016-08-31 13:29:36', 1, 0, '2016-08-31 08:29:36'),
(31, 'DIV1 Project1-007777', 1, 11, 0, '2016-08-31 13:32:32', 1, 0, '2016-08-31 08:32:32'),
(32, 'DIV1 Project1-008888', 1, 11, 0, '2016-08-31 13:33:24', 1, 0, '2016-08-31 08:33:24'),
(33, 'DIV1 Project1-009999', 1, 9, 0, '2016-08-31 13:36:57', 1, 0, '2016-08-31 08:36:57'),
(34, 'DIV1 Project1-011111', 1, 17, 0, '2016-08-31 13:38:14', 1, 0, '2016-08-31 08:38:14'),
(35, 'DIV1 Project1-022222', 1, 15, 0, '2016-08-31 13:38:35', 1, 0, '2016-08-31 08:38:35'),
(36, 'DIV1 Project1-033333', 1, 12, 0, '2016-08-31 13:39:51', 1, 0, '2016-08-31 08:39:51'),
(37, 'DIV1 Project1-4444444', 1, 17, 0, '2016-08-31 13:40:03', 1, 0, '2016-08-31 08:40:03'),
(38, 'DIV2 Project1-000032', 1, 16, 0, '2016-08-31 14:00:51', 1, 0, '2016-08-31 09:00:51'),
(39, 'DIV1 Project1-034567', 1, 13, 0, '2016-08-31 14:01:53', 1, 0, '2016-08-31 09:01:53'),
(40, 'DIV1 Project1-009876', 1, 17, 0, '2016-08-31 14:02:26', 1, 0, '2016-08-31 09:02:26'),
(41, 'DIV1 Project1-002345', 1, 14, 0, '2016-08-31 14:03:09', 1, 0, '2016-08-31 09:03:09'),
(42, 'DIV1 Project2-000232', 1, 41, 0, '2016-08-31 14:03:45', 1, 0, '2016-08-31 09:03:45'),
(43, 'DIV1 Project1-002323', 1, 17, 0, '2016-08-31 14:04:11', 1, 0, '2016-08-31 09:04:11'),
(44, 'DIV1 Project1-111111', 14, 15, 0, '2016-08-31 20:07:29', 1, 0, '2016-08-31 15:07:29'),
(45, 'DIV1 Project1-222222', 16, 1, 0, '2016-08-31 20:09:14', 3, 0, '2016-08-31 15:09:14'),
(46, 'DIV1 Project1-333333', 17, 1, 0, '2016-08-31 20:10:47', 2, 1, '2016-08-31 17:59:56'),
(47, 'DIV1 Project2-002345', 15, 13, 1, '2016-08-31 23:00:27', 1, 1, '2016-08-31 18:00:27');

--
-- Triggers `notebooks`
--
DELIMITER $$
CREATE TRIGGER `after_insert_notebooks` AFTER INSERT ON `notebooks`
 FOR EACH ROW INSERT INTO audit_trail 
            (`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
        VALUES 
            ("notebooks", NEW.id, "NEW_ITEM", "NEW_ITEM", NEW.notebook_no, NEW.created_by)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_notebooks` AFTER UPDATE ON `notebooks`
 FOR EACH ROW begin
IF OLD.id != NEW.id THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "id", OLD.id, NEW.id, NEW.last_modified_by);
END IF;

IF OLD.notebook_no != NEW.notebook_no THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "notebook_no", OLD.notebook_no, NEW.notebook_no, NEW.last_modified_by);
END IF;

IF OLD.author_id != NEW.author_id THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "author_id", OLD.author_id, NEW.author_id, NEW.last_modified_by);
END IF;

IF OLD.reviewer_id != NEW.reviewer_id THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "reviewer_id", OLD.reviewer_id, NEW.reviewer_id, NEW.last_modified_by);
END IF;

IF OLD.created_by != NEW.created_by THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "created_by", OLD.created_by, NEW.created_by, NEW.last_modified_by);
END IF;

IF OLD.created_date != NEW.created_date THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "created_date", OLD.created_date, NEW.created_date, NEW.last_modified_by);
END IF;

IF OLD.status_id != NEW.status_id THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "status_id", OLD.status_id, NEW.status_id, NEW.last_modified_by);
END IF;

IF OLD.last_modified_date != NEW.last_modified_date THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("notebooks", OLD.id, "last_modified_date", OLD.last_modified_date, NEW.last_modified_date, NEW.last_modified_by);
END IF;
end
$$
DELIMITER ;

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
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `notebooks`
--
ALTER TABLE `notebooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
