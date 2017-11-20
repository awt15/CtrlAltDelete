-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2017 at 01:44 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cen4020`
--

-- --------------------------------------------------------

--
-- Table structure for table `belongto`
--

CREATE TABLE `belongto` (
  `username` varchar(45) CHARACTER SET utf8 NOT NULL,
  `projectID` int(11) NOT NULL,
  `permissions` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `belongto`
--

INSERT INTO `belongto` (`username`, `projectID`, `permissions`) VALUES
('kle', 1, 0),
('kle', 2, 1),
('kle', 3, 1),
('mwalker', 1, 1),
('vtran', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `text` varchar(256) DEFAULT NULL,
  `commentDate` date NOT NULL,
  `username` varchar(45) CHARACTER SET utf8 NOT NULL,
  `projectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `projectID` int(11) NOT NULL,
  `projectName` varchar(45) CHARACTER SET utf8 NOT NULL,
  `projectStart` date NOT NULL,
  `projectDescription` varchar(2000) NOT NULL,
  `projectKey` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`projectID`, `projectName`, `projectStart`, `projectDescription`, `projectKey`) VALUES
(1, 'Test Project', '2017-11-19', 'Please  Work', '098f6bcd4621d373cade4e832627b4f6'),
(2, 'Khoas Trip', '2017-11-19', 'YOlo', '098f6bcd4621d373cade4e832627b4f6'),
(3, 'It works', '2017-11-19', 'haha', '098f6bcd4621d373cade4e832627b4f6');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `taskID` int(11) NOT NULL,
  `dueDate` date NOT NULL,
  `username` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `projectID` int(11) NOT NULL,
  `taskDescription` varchar(256) CHARACTER SET utf8 NOT NULL,
  `priority` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `title` varchar(256) NOT NULL,
  `abbreviation` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(45) CHARACTER SET utf8 NOT NULL,
  `first` varchar(45) CHARACTER SET utf8 NOT NULL,
  `last` varchar(45) CHARACTER SET utf8 NOT NULL,
  `email` varchar(45) NOT NULL,
  `passhash` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `first`, `last`, `email`, `passhash`) VALUES
('atieu', 'Anthony', 'Tieu', 'atieu@test.com', '098f6bcd4621d373cade4e832627b4f6'),
('kle', 'Khoa', 'Le', 'kle@test.com', '098f6bcd4621d373cade4e832627b4f6'),
('mwalker', 'Mark', 'Walker', 'mtw14@my.fsu.edu', '5a105e8b9d40e1329780d62ea2265d8a'),
('vtran', 'Vita', 'Tran', 'vtran@test.com', '098f6bcd4621d373cade4e832627b4f6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `belongto`
--
ALTER TABLE `belongto`
  ADD PRIMARY KEY (`username`,`projectID`),
  ADD KEY `fk_users_has_projects_projects1_idx` (`projectID`),
  ADD KEY `fk_users_has_projects_users1_idx` (`username`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD UNIQUE KEY `commentID_UNIQUE` (`commentID`),
  ADD KEY `fk_comments_users1_idx` (`username`),
  ADD KEY `fk_comments_projects1_idx` (`projectID`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`projectID`),
  ADD UNIQUE KEY `projectID_UNIQUE` (`projectID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskID`),
  ADD UNIQUE KEY `taskID_UNIQUE` (`taskID`),
  ADD KEY `fk_tasks_users_idx` (`username`),
  ADD KEY `fk_tasks_projects1_idx` (`projectID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `idusers_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `projectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `belongto`
--
ALTER TABLE `belongto`
  ADD CONSTRAINT `fk_users_has_projects_projects1` FOREIGN KEY (`projectID`) REFERENCES `projects` (`projectID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_projects_users1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_projects1` FOREIGN KEY (`projectID`) REFERENCES `projects` (`projectID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comments_users1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_projects1` FOREIGN KEY (`projectID`) REFERENCES `projects` (`projectID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tasks_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
