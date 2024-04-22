-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 07:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `identity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `role`, `identity`) VALUES
(1, 'Manager', 1);

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `fiscal_code` varchar(16) DEFAULT NULL,
  `birth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `name`, `surname`, `fiscal_code`, `birth_date`) VALUES
(1, 'John', 'Doe', 'ABC1234567890123', '1990-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `budget` int(11) DEFAULT NULL,
  `project_state` enum('On Going','Completed','Closed') DEFAULT NULL,
  `team` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `start_date`, `description`, `last_update`, `budget`, `project_state`, `team`) VALUES
(1, 'Website Redesign', '2024-04-01', 'Redesigning company website for better user experience.', '2024-04-22 05:35:04', 5000, 'On Going', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `timeframe` bigint(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `percentage` int(11) DEFAULT NULL,
  `link` int(11) DEFAULT NULL,
  `project` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `timeframe`, `start_date`, `end_date`, `percentage`, `link`, `project`) VALUES
(1, 'Design wireframes', 432000000, '2024-04-01', '2024-04-05', 0, NULL, 1),
(2, 'Develop front-end', 864000000, '2024-04-06', '2024-04-15', 0, 1, 1),
(3, 'Implement back-end functionality', 1296000000, '2024-04-10', '2024-04-25', 0, 2, 1),
(4, 'Test website functionality', 604800000, '2024-04-20', '2024-04-27', 0, 3, 1),
(5, 'Deploy website', 259200000, '2024-04-28', '2024-04-30', 0, 4, 1),
(6, 'Content creation', 172800000, '2024-05-01', '2024-05-03', 0, 5, 1),
(7, 'SEO optimization', 259200000, '2024-05-04', '2024-05-07', 0, 6, 1),
(8, 'User testing', 345600000, '2024-05-08', '2024-05-12', 0, 7, 1),
(9, 'Final review', 172800000, '2024-05-13', '2024-05-15', 0, 8, 1),
(10, 'Launch', 86400000, '2024-05-16', '2024-05-17', 0, 9, 1),
(11, 'Gather feedback', 259200000, '2024-05-18', '2024-05-21', 0, 10, 1),
(12, 'Bug fixing', 172800000, '2024-05-22', '2024-05-24', 0, 11, 1),
(13, 'Documentation', 345600000, '2024-05-25', '2024-05-29', 0, 12, 1),
(14, 'Client review', 172800000, '2024-05-30', '2024-06-01', 0, 13, 1),
(15, 'Final deployment', 86400000, '2024-06-02', '2024-06-03', 0, 14, 1),
(16, 'Test', 259200000, '2024-05-18', '2024-05-21', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `team_leader` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `team_leader`) VALUES
(1, 'Development Team', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `identity` (`identity`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team` (`team`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link` (`link`),
  ADD KEY `project` (`project`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_leader` (`team_leader`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`identity`) REFERENCES `people` (`id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`team`) REFERENCES `teams` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`link`) REFERENCES `tasks` (`id`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`project`) REFERENCES `projects` (`id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`team_leader`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
