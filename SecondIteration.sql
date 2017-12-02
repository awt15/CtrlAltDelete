-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2017 at 08:39 PM
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
('mwalker', 1, 1),
('mwalker', 4, 1),
('mwalker', 5, 1),
('mwalker', 6, 1),
('mwalker', 7, 0),
('vtran', 1, 0),
('vtran', 4, 0),
('yolo', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `changes`
--

CREATE TABLE `changes` (
  `changeID` int(11) NOT NULL,
  `projectID` int(11) DEFAULT NULL,
  `taskID` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `changeType` int(11) NOT NULL,
  `username` varchar(45) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `text` varchar(256) DEFAULT NULL,
  `commentDate` date NOT NULL,
  `username` varchar(45) CHARACTER SET utf8 NOT NULL,
  `projectID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL
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
(4, 'Test', '2017-11-19', 'Test', '415290769594460e2e485922904f345d'),
(5, 'Yolo', '2017-11-19', 'swag', '098f6bcd4621d373cade4e832627b4f6'),
(6, 'Whats this project ID?', '2017-11-20', 'Finding a proj ID', '098f6bcd4621d373cade4e832627b4f6'),
(7, 'Blah', '2017-12-01', 'yolo', '098f6bcd4621d373cade4e832627b4f6');

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

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`taskID`, `dueDate`, `username`, `projectID`, `taskDescription`, `priority`, `status`, `title`, `abbreviation`) VALUES
(1, '2017-10-11', 'mwalker', 6, 'Test this interface', 3, 1, 'How do I sort lines by number of appearances UNIX?', 'WHA'),
(2, '2017-10-11', 'mwalker', 1, 'Tessssst', 1, 3, 'Test this interface', 'TES'),
(3, '2017-11-28', 'mwalker', 1, 'Test this interface', 2, 3, 'How do I sort lines by number of appearances UNIX?', 'TES'),
(4, '2017-11-28', 'vtran', 1, 'Please workkkkk', 3, 3, 'Please work', 'TES'),
(10, '2017-11-28', 'kle', 1, 'Test', 2, 2, 'Test this please', 'TES'),
(11, '0000-00-00', 'yolo', 7, 'testing', 1, 1, 'Testing', 'BLA'),
(12, '2017-12-31', 'mwalker', 1, 'TERR', 1, 1, 'Hopefully this works', 'TES'),
(13, '2017-11-28', 'mwalker', 1, 'DHJJHDH', 3, 3, 'Real', 'TES'),
(14, '2017-12-31', 'mwalker', 5, 'GHHGHGHGHG', 1, 1, 'Test this please', 'YOL');

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
('vtran', 'Vita', 'Tran', 'vtran@test.com', '098f6bcd4621d373cade4e832627b4f6'),
('yolo', 'Mark', 'Walker', 'yolo@test.com', '4fded1464736e77865df232cbcb4cd19');

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
-- Indexes for table `changes`
--
ALTER TABLE `changes`
  ADD PRIMARY KEY (`changeID`),
  ADD KEY `changes_ibfk_1` (`projectID`),
  ADD KEY `changes_ibfk_2` (`taskID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD UNIQUE KEY `commentID_UNIQUE` (`commentID`),
  ADD KEY `fk_comments_users1_idx` (`username`),
  ADD KEY `fk_comments_projects1_idx` (`projectID`),
  ADD KEY `taskID` (`taskID`);

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
-- AUTO_INCREMENT for table `changes`
--
ALTER TABLE `changes`
  MODIFY `changeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `projectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
-- Constraints for table `changes`
--
ALTER TABLE `changes`
  ADD CONSTRAINT `changes_ibfk_1` FOREIGN KEY (`projectID`) REFERENCES `projects` (`projectID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `changes_ibfk_2` FOREIGN KEY (`taskID`) REFERENCES `tasks` (`taskID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `changes_ibfk_3` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`taskID`) REFERENCES `tasks` (`taskID`),
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
