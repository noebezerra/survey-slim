-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 03-Jun-2016 às 11:55
-- Versão do servidor: 5.5.49-0ubuntu0.14.04.1
-- versão do PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `survey`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `poll_answers`
--

CREATE TABLE IF NOT EXISTS `poll_answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_poll_question` int(10) unsigned NOT NULL,
  `answers` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_poll_question` (`id_poll_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `poll_questions`
--

CREATE TABLE IF NOT EXISTS `poll_questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `poll_questions`
--

INSERT INTO `poll_questions` (`id`, `question`) VALUES
(1, '1 - Primeira pergunta'),
(2, '2 - Segunda pergunta'),
(3, '3 - Terceira pergunta');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `poll` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `poll`) VALUES
(1, 'Noe Neto', 'noebezerra@hotmail.com', '$2y$10$A6iNKf8abmofljbpglisbOh9pSgw/d/Df64Q11eF2Q3I4J0GStQTq', '2016-05-24 20:08:12', '2016-05-22 15:51:44', 0),
(2, 'Teste', 'teste@hotmail.com', '$2y$10$.lOQUl2fqcyKthm5SWTS4eBsx.ee4LJCZ6YBzkEijZZZw/kFaHMsK', '2016-05-22 20:22:25', '2016-05-22 15:58:47', 1),
(4, 'Poll', 'poll@poll.com', '202cb962ac59075b964b07152d234b70', '2016-05-24 20:11:11', '0000-00-00 00:00:00', 0),
(5, 'TesteTwo', 'testetwo@teste.com', '202cb962ac59075b964b07152d234b70', '2016-05-24 20:14:11', '0000-00-00 00:00:00', 0),
(7, 'Noe Bezerra', 'noeneto@hotmail.com', '25f9e794323b453885f5181f1b624d0b', '2016-05-24 20:31:02', '0000-00-00 00:00:00', 0),
(8, 'teste', 'teste@teste.com.br', 'e10adc3949ba59abbe56e057f20f883e', '2016-05-25 02:48:27', '0000-00-00 00:00:00', 0),
(9, NULL, 'teste@teste.com', 'e10adc3949ba59abbe56e057f20f883e', '2016-05-25 02:50:27', '0000-00-00 00:00:00', 0),
(10, NULL, 'teste@teste.com', 'e10adc3949ba59abbe56e057f20f883e', '2016-05-25 02:50:40', '0000-00-00 00:00:00', 0),
(11, NULL, 'teste@teste.com', 'e10adc3949ba59abbe56e057f20f883e', '2016-05-25 02:53:06', '0000-00-00 00:00:00', 0);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `poll_answers`
--
ALTER TABLE `poll_answers`
  ADD CONSTRAINT `poll_answers_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `poll_answers_ibfk_2` FOREIGN KEY (`id_poll_question`) REFERENCES `poll_questions` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
