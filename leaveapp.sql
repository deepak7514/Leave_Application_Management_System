-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2015 at 07:49 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `leaveapp`
--
CREATE DATABASE IF NOT EXISTS `leaveapp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `leaveapp`;

-- --------------------------------------------------------

--
-- Table structure for table `leaves_taken`
--

CREATE TABLE IF NOT EXISTS `leaves_taken` (
  `person_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `leave_type` varchar(30) NOT NULL,
  PRIMARY KEY (`person_id`,`start_date`,`end_date`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leaves_taken`
--

INSERT INTO `leaves_taken` (`person_id`, `start_date`, `end_date`, `leave_type`) VALUES
(19, '2014-05-26', '2014-10-18', 'Non-sick Leave'),
(19, '2014-09-29', '2014-10-29', 'Sick Leave'),
(20, '2015-03-30', '2015-04-18', 'Non-sick Leave'),
(20, '2015-04-28', '2015-05-14', 'Ordinal Leave'),
(20, '2015-05-04', '2015-05-04', 'Others'),
(20, '2015-05-05', '2015-05-07', 'Sick Leave'),
(20, '2015-05-28', '2015-06-05', 'Ordinal Leave'),
(20, '2015-05-29', '2015-05-30', 'Sick Leave'),
(20, '2015-06-04', '2015-06-06', 'Non-sick Leave'),
(28, '2015-05-13', '2015-05-23', 'Sick Leave');

--
-- Triggers `leaves_taken`
--
DROP TRIGGER IF EXISTS `update_notification`;
DELIMITER //
CREATE TRIGGER `update_notification` AFTER INSERT ON `leaves_taken`
 FOR EACH ROW update person
set notification_number=notification_number + 1 where person_id=NEW.person_id
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(50) NOT NULL,
  `content` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `signature` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `subject`, `content`, `date`, `signature`) VALUES
(3, 'internship application', '1432741221_3rdsemester2013pdf.pdf', '2015-05-25', 'admin'),
(4, 'timetable', '1432744664_timetablejpeg.jpeg', '2015-05-25', 'admin'),
(5, 'dbms assignment', '1432776409_dbms1jpeg.jpeg', '0000-00-00', 'deepak');

-- --------------------------------------------------------

--
-- Table structure for table `pending_requests`
--

CREATE TABLE IF NOT EXISTS `pending_requests` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `leave_type` varchar(30) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `other_data` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`leave_id`),
  UNIQUE KEY `person_id` (`person_id`,`start_date`,`end_date`),
  KEY `person_id_2` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `pending_requests`
--

INSERT INTO `pending_requests` (`leave_id`, `person_id`, `leave_type`, `start_date`, `end_date`, `other_data`, `status`) VALUES
(7, 19, 'Sick Leave', '2014-09-29', '2014-10-29', ' ', 1),
(8, 19, 'Non-sick Leave', '2014-05-26', '2014-10-18', ' ', 1),
(9, 20, 'Non-sick Leave', '2015-03-30', '2015-04-18', ' bhasad', 1),
(10, 20, 'Ordinal Leave', '2015-05-28', '2015-06-05', ' ', 1),
(11, 20, 'Ordinal Leave', '2015-04-28', '2015-05-14', ' ', 1),
(12, 20, 'Sick Leave', '2015-05-05', '2015-05-07', ' ', 1),
(13, 20, 'Others', '2015-05-04', '2015-05-04', ' ', 1),
(14, 20, 'Non-sick Leave', '2015-06-04', '2015-06-06', ' Visit to allahbad', 1),
(16, 20, 'Sick Leave', '2015-05-29', '2015-05-31', ' High Fever', 0),
(17, 20, 'Sick Leave', '2015-05-29', '2015-05-30', ' ', 1),
(18, 28, 'Sick Leave', '2015-05-13', '2015-05-23', ' ', 1);

--
-- Triggers `pending_requests`
--
DROP TRIGGER IF EXISTS `pending_update`;
DELIMITER //
CREATE TRIGGER `pending_update` AFTER UPDATE ON `pending_requests`
 FOR EACH ROW BEGIN
	INSERT INTO `leaves_taken` (`person_id`,`start_date`,`end_date`,`leave_type`) 			VALUES(NEW.person_id,NEW.start_date,NEW.end_date,NEW.leave_type);
    END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(250) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `by_admin` int(11) DEFAULT NULL,
  `Notification_number` int(11) NOT NULL DEFAULT '0',
  `avatar_path` varchar(50) NOT NULL DEFAULT '"./avatars/default.jpg"',
  PRIMARY KEY (`person_id`),
  UNIQUE KEY `username` (`username`),
  KEY `by_admin` (`by_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `first_name`, `last_name`, `username`, `password`, `is_admin`, `by_admin`, `Notification_number`, `avatar_path`) VALUES
(19, 'divjot', 'singh', 'divjot', '$2y$10$FF//GifJQj6InXUc2s5q2evKmOj7Ek6./rlFxfpojW8vZQNc9hEKq', 0, NULL, 0, '"./avatars/default.jpg"'),
(20, 'Astha', 'arya', 'astha', '$2y$10$CxX3EAIN5VZ0FeiKjCizy.GPNY2S4pB4epHnyNF.c2MQQeLQHsdRS', 0, NULL, 1, './avatars/astha_arya_1432769660.jpg'),
(21, 'dhrthi', 'nanda', 'dhrthi', '$2y$10$Nd6mg9pWJK4vNn6g9NcN4.9aBfWJ7T1uvP/jxQuV3vaAf0EsXqELy', 1, NULL, 0, './avatars/default.jpg'),
(22, 'dhrthi', 'nanda', 'dhrthi_nanda', '$2y$10$q6LlW2PHOqLfNLteKdBB1uHb/N6akRjOhVLDjC8HImU5TdtjKyJ8m', 1, NULL, 0, '"./avatars/default.jpg"'),
(23, 'asdfghj', 'ased', 'lakshya', '$2y$10$9Yvf01ybe0Py7/YDqpQwEO36NUr6I8HfhzL.VICeqgVnSjmSelmkG', 1, NULL, 0, '"./avatars/default.jpg"'),
(24, 'astha', 'arya', 'aryaastha', '$2y$10$Ga3PixbpITgm8niVkw9VAO2cvYgmBaruROE4IhvfepbSnWYE5uegO', 1, NULL, 0, '"./avatars/default.jpg"'),
(25, 'astha', 'arya', 'aryaastha1', '$2y$10$qGxFcm7a0gV9xkirVCiRSO/XlXiJFKpxFKft1yIhWYDrfDlHsi7fu', 1, NULL, 0, '"./avatars/default.jpg"'),
(26, 'astha', 'arya', 'aryaastha3', '$2y$10$tuGNguwFx9ZdGjYjUDG5Hulm0pERWVGPWb1sFiWH0S6aEMkgO/bZ.', 1, NULL, 0, '"./avatars/default.jpg"'),
(27, 'astha', 'arya', 'asthaarya', '$2y$10$47f3pMcGGZbu2AHN.MnwmOsvHeNH6B8EAHCtTm2RrOzk5vNi90gjO', 0, NULL, 0, '"./avatars/default.jpg"'),
(28, 'Savita', 'aggarwal', 'savita', '$2y$10$VswStdrg5YXlZJEGFFD8p.NxrTIR/h8/rA7A0320XeAU0MjWyDHGG', 1, NULL, 0, './avatars/savita_arya_1432769358.jpg'),
(29, 'akshit', 'verma', 'akshit', '$2y$10$DfV0fTT/NtqhzNTrSUUqiumvw.so8qnPALWUKMEgjBUzq/pvbGzCu', 0, NULL, 0, '"./avatars/default.jpg"'),
(30, 'deepak', 'goel', 'deepak', '$2y$10$L4/ZCJ1znVLqvAk5RsQffuve4OT5Kz0EtSGzGdHDKEm7yatATYWea', 0, NULL, 0, '"./avatars/default.jpg"');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pending_requests`
--
ALTER TABLE `pending_requests`
  ADD CONSTRAINT `pending_requests_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
