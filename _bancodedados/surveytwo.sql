-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 09, 2016 at 12:43 PM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `surveytwo`
--

-- --------------------------------------------------------

--
-- Table structure for table `level_users`
--

CREATE TABLE IF NOT EXISTS `level_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `level_users`
--

INSERT INTO `level_users` (`id`, `level`) VALUES
(1, 'Default'),
(2, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE IF NOT EXISTS `polls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poll` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `img` varchar(255) NOT NULL DEFAULT 'img/cardsurvey.jpg',
  `dta_start` date NOT NULL,
  `dta_finish` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `poll`, `description`, `img`, `dta_start`, `dta_finish`) VALUES
(44, 'a vida é um doce', 'Descricaoo', 'img/cardsurvey.jpg', '2016-07-20', '2016-09-10'),
(45, 'testinho', 'Descricaoaaaaa', 'img/cardsurvey.jpg', '2016-07-10', '2016-07-30');

-- --------------------------------------------------------

--
-- Table structure for table `poll_answers`
--

CREATE TABLE IF NOT EXISTS `poll_answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_question` int(10) unsigned NOT NULL,
  `answers` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_question` (`id_question`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `poll_questions`
--

CREATE TABLE IF NOT EXISTS `poll_questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_poll` int(10) unsigned NOT NULL,
  `question` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_poll` (`id_poll`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `poll_questions`
--

INSERT INTO `poll_questions` (`id`, `id_poll`, `question`) VALUES
(55, 44, 'Enquete22'),
(56, 44, 'Enquete21'),
(57, 45, 'qweqweqwe'),
(58, 45, 'eqweqweqwe'),
(59, 45, 'ewqewewew');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_level_user` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id_level_user` (`id_level_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `id_level_user`, `created_at`, `updated_at`) VALUES
(9, 'Admin Admin', 'admin@admin.com', '$2y$10$hmyDKNXyTFWGXm/PZWfn.eMT9f0J2IPcDdJ786G4z/Mu6RLCi2REC', 2, '2016-09-09 15:40:59', '2016-09-09 15:39:35'),
(10, 'User User', 'user@user.com', '$2y$10$fr.W1bQm1qj5OUcyxOiCg.B2/WSW9W5KBOWwNm2JjizpE3Q1QsSC2', 1, '2016-09-09 15:40:02', '2016-09-09 15:40:02');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `poll_answers`
--
ALTER TABLE `poll_answers`
  ADD CONSTRAINT `poll_answers_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `poll_answers_ibfk_3` FOREIGN KEY (`id_question`) REFERENCES `poll_questions` (`id`);

--
-- Constraints for table `poll_questions`
--
ALTER TABLE `poll_questions`
  ADD CONSTRAINT `poll_questions_ibfk_1` FOREIGN KEY (`id_poll`) REFERENCES `polls` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_level_user`) REFERENCES `level_users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
