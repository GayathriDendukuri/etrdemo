-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2015 at 04:10 PM
-- Server version: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ert`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE IF NOT EXISTS `admin_login` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active_status` varchar(1) NOT NULL DEFAULT '1',
  `admin_type` varchar(5) NOT NULL,
  `employee_id` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `username`, `password`, `email`, `active_status`, `admin_type`, `employee_id`) VALUES
(1, 'ibadmin', 'cd0fd6a19ec92255990318f54cecc5cc', 'pradeep.ganapathy@ideabytes.com', '1', '1', '0'),
(2, 'gayathri', 'cd0fd6a19ec92255990318f54cecc5cc', 'gayathri.dendukuri234@ideabytes.com', '1', '2', '1'),
(6, 'g1', 'bc7ec38655ce31777b8ada7cc4f55b93', 'gayathri.dendukuri@ideabytes.com', '1', '2', '23');

-- --------------------------------------------------------

--
-- Table structure for table `check_options`
--

CREATE TABLE IF NOT EXISTS `check_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL,
  `description` varchar(300) NOT NULL,
  `notes_for_yes` varchar(10) NOT NULL,
  `notes_for_no` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `check_options`
--

INSERT INTO `check_options` (`id`, `question`, `description`, `notes_for_yes`, `notes_for_no`, `status`, `created_at`, `updated_at`) VALUES
(1, 'time reports filled', 'time reports filled', 'yes', '', 1, '2015-11-09 12:27:50', '0000-00-00 00:00:00'),
(2, 'is git check in ', 'is git check in', '', 'yes', 1, '2015-11-09 12:28:40', '0000-00-00 00:00:00'),
(3, 'db backup', 'db backup', 'yes', '', 1, '2015-11-10 11:51:29', '2015-11-12 11:23:09'),
(8, 'test', 'all functionalities', '', '', 1, '2015-11-12 11:28:48', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `uname`, `password`, `fname`, `lname`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'gayathri', 'cd0fd6a19ec92255990318f54cecc5cc', 'gayathri', 'd', 'gayathri.denukuri@ideabytes.com', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, '', '', 'asdf', 'df', 'gayathri.dendukuri@ideabytes.com', 1, '2015-11-12 14:37:33', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `employee_project_assignment`
--

CREATE TABLE IF NOT EXISTS `employee_project_assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employee_project_assignment`
--

INSERT INTO `employee_project_assignment` (`id`, `employee_id`, `project_id`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 1, '2015-11-10 13:15:00', '0000-00-00 00:00:00', 1),
(2, 2, 1, '2015-11-10 06:00:00', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_reporting`
--

CREATE TABLE IF NOT EXISTS `employee_reporting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employee_reporting`
--

INSERT INTO `employee_reporting` (`id`, `employee_id`, `project_id`, `data`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 1, 'a:10:{s:17:"check_notes_yes_1";s:0:"";s:7:"check_1";s:2:"no";s:16:"check_notes_no_1";s:0:"";s:17:"check_notes_yes_2";s:0:"";s:7:"check_2";s:2:"no";s:16:"check_notes_no_2";s:0:"";s:10:"project_id";s:1:"1";s:6:"emp_id";s:1:"1";s:10:"btncontact";s:6:"Submit";s:6:"action";s:4:"Edit";}', '2015-11-10 12:13:07', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'p1', 'werwerwerwe', 1, '2015-11-09 11:11:53', '0000-00-00 00:00:00'),
(2, 'p2', 'p2', 1, '2015-11-10 08:56:38', '0000-00-00 00:00:00'),
(3, 'p3', 'p3 desc', 1, '2015-11-10 11:24:05', '2015-11-12 10:57:37'),
(5, 'p4', 'adasd', 1, '2015-11-12 10:58:05', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_checklist_assignment`
--

CREATE TABLE IF NOT EXISTS `project_checklist_assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `assigned_chek_list` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `project_checklist_assignment`
--

INSERT INTO `project_checklist_assignment` (`id`, `project_id`, `assigned_chek_list`, `status`, `created_at`, `updated_at`) VALUES
(7, 1, '1,2', 1, '2015-11-12 10:16:03', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
