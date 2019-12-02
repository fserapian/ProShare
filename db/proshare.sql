-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2019 at 02:48 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(3) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Cin&eacute;ma et cours m&eacute;trages'),
(2, 'Artisanat'),
(3, 'Jeux Traditionnels'),
(4, 'Jeux Vid&eacute;os'),
(5, 'Musique'),
(6, 'Nourriture'),
(7, 'Technologies'),
(8, 'Livres et autres m&eacute;diums papier'),
(9, 'DIY'),
(10, 'Divers');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `postid` int(11) DEFAULT NULL,
  `content` text,
  `note` int(11) DEFAULT NULL,
  `dateComment` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `userID`, `postid`, `content`, `note`, `dateComment`) VALUES
(29, 4, 36, 'hfshfkldslkhflkshdlkfklsdlfklsdfhlksdfsdfsd', 4, '2019-10-28 00:19:45'),
(30, 4, 36, 'hfshfkldslkhflkshdlkfklsdlfklsdfhlksdfsdfsd', 1, '2019-10-28 00:19:54'),
(31, 4, 36, 'sdgsdkfj lskdhl fhslk dglkhskl h dlksh lgds;lk hgsld s', 4, '2019-10-28 00:49:53'),
(32, 21, 25, 'ifklsdf hs klhlkdh lkfhslk hfklsh lkdfhlks hf;sh kl;fhs fd', 4, '2019-10-28 20:49:26'),
(33, 21, 25, 'fds fklsd fhslk hfkls kfkls hs fdklfs f', 1, '2019-10-28 20:49:34');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text,
  `categories` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `body`, `created_at`, `content`, `categories`) VALUES
(1, 8, 'Pizza Hawaiienne', 'Id&eacute;es pour faire la pizza la plus controvers&eacute;e de l\'internet', '2019-09-07 18:21:39', 'Commencez par la p&acirc;te, ajoutez de la sauce, du fromage, du jambon et des ananas puis mettez au four!', 6),
(10, 8, 'Sokoban', 'Poss&eacute;dez une superbe version remasteuris&eacute;e de Sokoban', '2019-09-11 00:27:39', 'Un simple disque compact (CD) dans une superbe boîte ouvrag&eacute;e d\'or et de diamants. ', 4),
(14, 5, 'Hello World in Pascal', 'Program that greets the world!', '2019-09-11 01:13:20', 'AND IT SAYS HELLO BACK', 7),
(15, 6, 'Autoprog', 'Programme qui fait vos devoirs de programmation &agrave; votre place!', '2019-09-11 21:25:32', 'Envoyez lui du texte par bluetooth et ses mains m&eacute;chaniques écriront ce que vous lui avez envoy&eacute; sur un clavier! (Clavier non-inclus)', 7),
(17, 4, 'Free Netflix', 'Ayez acc&egrave;s à tous les programmes de Netflix gratuitement', '2019-09-12 12:44:10', 'Pour un seul paiement facile de 9999,95$', 1),
(18, 8, '&Eacute;checs pour 3', 'Une r&eacute;imagination du jeu de strat&eacute;gie classique pour 3 joueurs', '2019-09-12 19:17:18', 'Commandez maintenant!', 3),
(19, 3, 'Statues en bois', 'Je grave votre relief ou celui de votre copine dans du ch&ecirc;ne. ', '2019-09-13 16:46:55', 'Garanti d\'&ecirc;tre unique! &Eacute;patez tous vos amis!', 2),
(20, 7, 'Building a football team', 'Gathering football players to participate in the tournament', '2019-09-17 00:56:52', 'this is the content', 3),
(24, 15, 'L&#39;HISTOIRE DE L&#39;HUMANITE', 'Ce documentaire explique l&#39;idÃ©e de l&#39;Ã©volution de Charles Darwin', '2019-09-23 17:28:08', 'Vient avec un test gÃ©nÃ©tique gratuit chez 23 and me', 1),
(25, 15, 'Monde Ã‰ternel', 'PÃ©trifiez le monde et gardez le dans votre poche', '2019-10-01 14:20:03', 'Les technologies nÃ©cessaires pour ce projet ne seront crÃ©es que d&#39;ici approximativement 150 ans', 2),
(26, 8, 'ASP.NET Core project', 'Introduction to asp.net core using vs code', '2019-10-20 00:54:54', 'This is the a sentence', 7),
(36, 8, 'Collection Mozart', 'PerformÃ©e par l&#39;Orquesta SinfÃ³nica de Galicia au Palacio de la Ã“pera de A Coruna en 2013, dirigÃ©e par Dima Slobodeniouk', '2019-10-26 03:09:17', 'simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,', 5);

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`id`, `type`, `post_id`, `user_id`) VALUES
(116, -1, 36, 8),
(117, 1, 25, 21),
(118, -1, 19, 21);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `level` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `image`, `created_at`, `level`) VALUES
(3, 'Alan', 'Miller', 'amill@gmail.co.uk', '$2y$10$pK2fo7CXO0fg1wuAqK6yIelK8bV4JKHGam8Rcybu45p96gXAp5lNi', '5db3095550ee98.14769912.jpg', '2019-09-04 20:32:24', 2),
(4, 'Judy', 'Abott', 'jabot@gmail.com', '$2y$10$wgUpGl8EaXatBCV/6wRZdeY8wqJiGn07jzdveSJ8n1oqrxIiTuxJ2', '5db20189149332.89301213.jpg', '2019-09-04 20:34:52', 1),
(5, 'Bob', 'Kill', 'boby@killit.com', '$2y$10$O4dt53WGnH36D/.xI1el1ODBBUk8rv1fm9rdiEQv5q6QiTvfgBcL.', '', '2019-09-04 20:40:18', 1),
(6, 'Karen', 'Brown', 'kbb@hotmail.com', '$2y$10$Mk82XXnsHYfUP6NT8iISNufSV58JcVFZm4u1oWaUsF8uelja/ntaq', '', '2019-09-04 22:28:02', 2),
(7, 'Will', 'Brady', 'willy@mail.com', '$2y$10$og1vfmi8kVuPIqg7hT5FpuSOmAdLnu7pfCp6DgDkGd.WyMgLwa8wC', '5db238210a4148.56017431.png', '2019-09-04 22:29:17', 1),
(8, 'Fadi', 'Serapian', 'fserapian@email.com', '$2y$10$bmFr9S.7e6abQxdMiWXhcetwzR7J6CJZew.HUNge4Eg/k66r80lMG', '5db315f4650381.06211653.jpeg', '2019-09-04 22:31:09', 3),
(9, 'blall', 'blall', 'email@email.com', '$2y$10$2bXYmFunfT7ZGBP/VTH.ruC7YVA56EIrYaHJ89V7NzidlDBkn0g3e', '\r\n', '2019-09-04 22:33:48', 1),
(10, 'test', 'test1', 'mail@test.com', '$2y$10$oyKwrP8OihF.W1gNeLgg/O.jTjhJRgeWS8Izfwy/KRy5HWec.i8GO', '', '2019-09-04 22:35:04', 1),
(11, 'testi', 'testii', 'test@test.com', '$2y$10$D3e6MCJmVNc.zO0uaI7Pgedn/Lf3K9/Q2XLSzIpuUiyGjUDso9aHW', '', '2019-09-04 22:36:11', 2),
(12, 'john', 'dorian', 'jondor@blabla.com', '$2y$10$Nr4kPxY3h3DnhrI9X8HsHu.g0hoDvfXZKcSDlxWsp9pHEtlVn5WVC', '', '2019-09-05 18:03:47', 1),
(15, 'Samuel', 'Garant', 'samgar@untel.com', '$2y$10$TM33bw69C9zosAFnSd84seBsAF3HRLbAlRfnGkQmi7XI9CRCQeLhy', '5db2014f0de980.96745982.jpg', '2019-09-13 23:00:59', 3),
(16, 'Sam2', 'Gar2', 'samgar@untel2.com', '$2y$10$1xXPzaR7zr4S1WGOQf.dO.7wLYBK03lT7HFn2RxoRn2wLewXwG2xO', '\r\n', '2019-09-15 23:01:12', 1),
(18, 'test', 'test', 'test1@test.com', '$2y$10$PhGMM22TwJrHvE0gvKCKBeojmqn/wO/aVW7eX1Q4OE466o3ljvPkq', '', '2019-10-21 00:55:03', 1),
(19, 'fsd', 'dsg', 'fdsg@fsdg', '$2y$10$uHxD2h/t9URnSaq5jRnLSesn3Z3K2QtxDJY6kCjgeg.7hQnSzb6dy', '', '2019-10-25 00:46:36', 1),
(20, 'fs', 'fds', 'fds@fsd', '$2y$10$CAn6a4pTtyA.wXDT3U/f8esFiZ7wSCz0Bbq3/qzwpsWUK8gyxU6HG', '', '2019-10-25 00:50:03', 1),
(21, 'Fadi', 'Serapian', 'fadi.serapian@gmail.com', '$2y$10$Z4.KazHeKbyFNWsD1vYbFeN4cYCi2CZkhsBAFi/IfbimNazsKAcUO', '5db753bf7f4793.80501125.jpg', '2019-10-28 20:45:40', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_reactions_postId_userId` (`post_id`,`user_id`),
  ADD KEY `fs_reactions_users` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `fk_reactions_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fs_reactions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
