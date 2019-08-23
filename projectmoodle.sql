-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2013 at 12:22 PM
-- Server version: 5.1.53
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `projectmoodle`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` text NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `score` double NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `batch_id` int(11) NOT NULL COMMENT 'denotes the batch/session of paper',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `answers`
--


-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE IF NOT EXISTS `assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `week_id` int(11) NOT NULL,
  `desc` text NOT NULL,
  `submit` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `batch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `assignment`
--


-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE IF NOT EXISTS `batch` (
  `id` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `name` text COMMENT 'Batch Name for reference'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `start_date`, `end_date`, `name`) VALUES
('2013-03-15', '2013-03-29', '2013-04-29', 'Batch1'),
('2013-08-16', '2013-10-10', '2013-11-06', 'Batch2');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` text NOT NULL COMMENT 'eg, BSCH4, BAAS2',
  `faculty_id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `faculty_id`, `name`) VALUES
('BSCH1', 1, 'Bachelors in computing science - Year 1'),
('BSCH2', 1, 'Bachelors in computing science - Year 2'),
('BSCH3', 1, 'Bachelors in Computing - Year 3'),
('BBA1', 2, 'Bachelors in Business Administration Year 1'),
('BBA2', 2, 'Business Studies Year 2'),
('BBA3', 2, 'Business Studies Year 3');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE IF NOT EXISTS `exams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `result_day` datetime NOT NULL COMMENT 'show result after this day',
  `batch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exams`
--


-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Faculty Names' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `name`) VALUES
(1, 'Computing Science'),
(2, 'Business Studies'),
(3, 'Fashion Design'),
(4, 'ACCA');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `week_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0 for files, 1 for assignment',
  `name` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `batch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files`
--


-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE IF NOT EXISTS `help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `help`
--

INSERT INTO `help` (`id`, `email`, `title`, `message`, `timestamp`) VALUES
(1, '', '0', 'Help me!', '2013-04-11 10:19:27'),
(2, '$this->session->userdata[', 'Check 2', 'Here is my Probem', '2013-04-11 10:27:26'),
(3, 'sth.safal@gmail.com', 'Check 3', 'Final Message CHeck', '2013-04-11 10:28:31');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subject` text NOT NULL,
  `from` text NOT NULL,
  `to` text NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 unread, 1 read',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `timeStamp`, `subject`, `from`, `to`, `message`, `status`) VALUES
(1, '2013-04-11 14:18:08', 'Hey', 'sth.safal@gmail.com', 'sth.safal@gmail.com', 'Hello All<br>', 0),
(2, '2013-04-11 14:24:25', 'Checking', 'facadmin@coll.ie', 'sth.safal@gmail.com', 'Type your message here ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nav`
--

CREATE TABLE IF NOT EXISTS `nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `privilege` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `nav`
--

INSERT INTO `nav` (`id`, `name`, `privilege`) VALUES
(1, 'Students', 1),
(2, 'Lecturers', 1),
(3, 'Admins', 1),
(4, 'Faculty', 1),
(5, 'Course', 1),
(6, 'Subject', 1),
(7, 'Batch', 1),
(8, 'Notice', 1),
(9, 'Announcements', 2),
(10, 'Announcements', 8),
(11, 'Login', 0),
(12, 'Support', 5),
(13, 'Support', 8),
(14, 'Help', 1),
(15, 'Message', 1),
(16, 'Message', 2),
(17, 'Message', 5),
(18, 'Message', 8),
(19, 'Help', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE IF NOT EXISTS `notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `timeStamp`, `title`, `content`) VALUES
(13, '2013-04-08 15:59:05', 'Hey', ' Enter Text Here '),
(12, '2013-04-09 14:41:09', 'New Notice', '<b>College </b>is <b>open </b>tomorrow and day after tomorrow!<br>   '),
(14, '2013-04-11 17:17:15', 'Checking3', 'TEST TEST TEST'),
(15, '2013-04-11 17:17:15', 'Checking 4', 'TEST TEST TEST');

-- --------------------------------------------------------

--
-- Table structure for table `personal_details`
--

CREATE TABLE IF NOT EXISTS `personal_details` (
  `user_id` text NOT NULL,
  `title` varchar(5) NOT NULL,
  `first_name` text NOT NULL,
  `family_name` text NOT NULL,
  `dob` date NOT NULL,
  `add1` text NOT NULL,
  `add2` text NOT NULL,
  `add3` text NOT NULL,
  `add4` text NOT NULL,
  `phone` text NOT NULL,
  `mobile` text NOT NULL,
  `nationality` text NOT NULL,
  `birth_country` text NOT NULL,
  `pps_no` text NOT NULL,
  `profilePic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 default, 1 defined'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_details`
--

INSERT INTO `personal_details` (`user_id`, `title`, `first_name`, `family_name`, `dob`, `add1`, `add2`, `add3`, `add4`, `phone`, `mobile`, `nationality`, `birth_country`, `pps_no`, `profilePic`) VALUES
('BbZpYoe', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('4Xa3DRi', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('GLwa3pD', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('v6wcTd9', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('gWHB2yb', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('x91hGkw', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('s29nLKM', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('oZujkhd', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('Kr3u2k1', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('rHGwPYf', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('ZNYxyh0', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('WmCyBz4', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('KJwmClT', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('kcXCWT9', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('zv6p2oi', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('86tKZBd', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('VMA1njF', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('h2MaFmp', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('m1XhHfu', 'Mr.', 'Safal', 'Shrestha', '1990-04-08', '66', 'Flat 4', 'South Circular Road', 'Dublin 8', '0834063180', '0834063180', 'Nepalese', 'Nepal', '1522173D', 1),
('lnJdth4', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('6dCn9FD', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0),
('admin', 'Mr.', 'Safal', 'Shrestha', '1990-04-08', '', '', '', '', '', '', '', '', '', 0),
('BCLPzA3', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `priviledge`
--

CREATE TABLE IF NOT EXISTS `priviledge` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='User''s Privileges';

--
-- Dumping data for table `priviledge`
--

INSERT INTO `priviledge` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Faculty Head'),
(3, 'Course Head'),
(4, 'Course Admin'),
(5, 'Lecturers'),
(8, 'Students'),
(9, 'Parents');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `section` varchar(1) NOT NULL,
  `number` tinyint(1) NOT NULL,
  `question` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `questions`
--


-- --------------------------------------------------------

--
-- Table structure for table `student_subject`
--

CREATE TABLE IF NOT EXISTS `student_subject` (
  `student_id` text NOT NULL COMMENT 'user_id',
  `subject_id` int(11) NOT NULL,
  `batch_id` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_subject`
--

INSERT INTO `student_subject` (`student_id`, `subject_id`, `batch_id`) VALUES
('6dCn9FD', 2, '2013-08-16'),
('6dCn9FD', 1, '2013-08-16'),
('GLwa3pD', 1, '2013-03-15'),
('GLwa3pD', 2, '2013-03-15'),
('GLwa3pD', 2, '2013-08-16'),
('GLwa3pD', 1, '2013-08-16'),
('6dCn9FD', 3, '2013-08-16'),
('BCLPzA3', 3, '2013-03-15'),
('BCLPzA3', 2, '2013-03-15'),
('BCLPzA3', 1, '2013-03-15'),
('m1XhHfu', 2, '2013-03-15'),
('m1XhHfu', 1, '2013-03-15');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` text NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `course_id`, `name`, `status`) VALUES
(1, 'BSCH1', 'Computer Programming', 1),
(2, 'BSCH1', 'Information Technology in Society', 1),
(3, 'BSCH1', 'Business Information System', 1),
(4, 'BBA1', 'Account Basics', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject_lecturer`
--

CREATE TABLE IF NOT EXISTS `subject_lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `lecturer_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='linking subject with their subject teachers!' AUTO_INCREMENT=10 ;

--
-- Dumping data for table `subject_lecturer`
--

INSERT INTO `subject_lecturer` (`id`, `subject_id`, `lecturer_id`) VALUES
(6, 2, 'KJwmClT'),
(5, 1, 'ZNYxyh0'),
(7, 1, 'h2MaFmp'),
(8, 2, 'h2MaFmp');

-- --------------------------------------------------------

--
-- Table structure for table `subject_weeks`
--

CREATE TABLE IF NOT EXISTS `subject_weeks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `week_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `assignment_status` int(1) NOT NULL DEFAULT '0' COMMENT '0 Yes, 1 No',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='show/hide assignment based on assignment status, details sho' AUTO_INCREMENT=49 ;

--
-- Dumping data for table `subject_weeks`
--

INSERT INTO `subject_weeks` (`id`, `subject_id`, `week_id`, `description`, `assignment_status`) VALUES
(1, 1, 1, 'hello', 0),
(2, 1, 2, 'Change of Schedule', 0),
(3, 1, 3, '', 0),
(4, 1, 4, '', 0),
(5, 1, 5, '', 0),
(6, 1, 6, '', 0),
(7, 1, 7, '', 0),
(8, 1, 8, '', 0),
(9, 1, 9, '', 0),
(10, 1, 10, '', 0),
(11, 1, 11, '', 0),
(12, 1, 12, '', 0),
(13, 2, 1, '', 0),
(14, 2, 2, '', 0),
(15, 2, 3, '', 0),
(16, 2, 4, '', 0),
(17, 2, 5, '', 0),
(18, 2, 6, '', 0),
(19, 2, 7, '', 0),
(20, 2, 8, '', 0),
(21, 2, 9, '', 0),
(22, 2, 10, '', 0),
(23, 2, 11, '', 0),
(24, 2, 12, '', 0),
(25, 3, 1, '', 0),
(26, 3, 2, '', 0),
(27, 3, 3, '', 0),
(28, 3, 4, '', 0),
(29, 3, 5, '', 0),
(30, 3, 6, '', 0),
(31, 3, 7, '', 0),
(32, 3, 8, '', 0),
(33, 3, 9, '', 0),
(34, 3, 10, '', 0),
(35, 3, 11, '', 0),
(36, 3, 12, '', 0),
(37, 4, 1, '', 0),
(38, 4, 2, '', 0),
(39, 4, 3, '', 0),
(40, 4, 4, '', 0),
(41, 4, 5, '', 0),
(42, 4, 6, '', 0),
(43, 4, 7, '', 0),
(44, 4, 8, '', 0),
(45, 4, 9, '', 0),
(46, 4, 10, '', 0),
(47, 4, 11, '', 0),
(48, 4, 12, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` text NOT NULL,
  `reg_no` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `privilege` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`reg_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `reg_no`, `email`, `password`, `privilege`, `timestamp`) VALUES
('m1XhHfu', 1, 'student1@coll.ie', 'bc8f6cae30484d0094af8ac0c085d36c', 8, '2013-04-11 22:28:39'),
('6dCn9FD', 2, 'student2@coll.ie', '619c69311660056ecd64117435adbd30', 8, '2013-04-09 16:12:11'),
('ZNYxyh0', 3, 'lect1@coll.ie', '523cb84f867551955a8cafacd9922086', 5, '2013-04-09 16:12:33'),
('admin', 4, 'sth.safal@gmail.com', 'bc8f6cae30484d0094af8ac0c085d36c', 1, '2013-04-09 16:11:59'),
('h2MaFmp', 5, 'facadmin@coll.ie', 'bc8f6cae30484d0094af8ac0c085d36c', 2, '2013-04-09 16:12:49'),
('KJwmClT', 6, 'lect3@coll.ie', 'd9be86986e3eff3379a37e2b8c390a2d', 5, '2013-04-09 16:13:06'),
('BCLPzA3', 7, 'sa@b.com', 'a4e87fa20d192d5649320b02675379d8', 8, '2013-04-12 11:32:22');
