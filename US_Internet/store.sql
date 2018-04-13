-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2018 at 05:10 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(5) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `account_type_id` int(5) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `place_id` int(11) NOT NULL,
  `moved_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `first_name`, `last_name`, `email`, `account_type_id`, `active`, `place_id`, `moved_on`) VALUES
(11, 'bob', 'walssss', 'bob@aol.com', 2, 0, 1, '2018-04-12 05:13:14'),
(12, 'one', 'two', 'three@four.com', 1, 0, 1, '2018-04-13 03:13:12'),
(13, 'bill', 'doe', 'doe@email.com', 3, 1, 3, '2018-03-13 03:15:09'),
(14, 'jon', 'doe', 'wow@wow.wowo', 3, 0, 4, '2018-04-13 03:15:13'),
(15, 'gogo', 'nono', 'go@no.cpom', 3, 0, 4, '2018-04-05 03:15:17'),
(16, 'num', 'six', 'six@qol.com', 1, 0, 1, '2018-04-13 03:14:31'),
(17, 'lavi', 'pretty', 'lavi@aol.com', 2, 1, 3, '2018-04-13 04:28:10'),
(18, 'tra', 'vis', 'tra@rob.com', 2, 0, 2, '2018-04-06 03:36:56'),
(19, 'and', 'blas', 'and@as.co', 3, 0, 2, '2018-04-13 05:06:46'),
(20, 'alex', 'cervantes', 'al@aol.com', 2, 0, 1, '2018-04-13 05:05:41');

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `id` int(5) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `cost` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='stores account types';

--
-- Dumping data for table `account_types`
--

INSERT INTO `account_types` (`id`, `account_type`, `description`, `cost`) VALUES
(1, 'basic', 'this is basic', 10),
(2, 'super', 'super description', 20),
(3, 'premium', 'description for premium', 30);

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int(5) NOT NULL,
  `place` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `place`, `description`) VALUES
(1, 'Confirmation', 'Initial state'),
(2, 'Setup', 'Account being setup'),
(3, 'Activated', 'Account is activated'),
(4, 'Deactivated', 'Account id Deactivated');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_type_id_idx` (`account_type_id`),
  ADD KEY `place_id_idx` (`place_id`);

--
-- Indexes for table `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `account_type_id` FOREIGN KEY (`account_type_id`) REFERENCES `account_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `place_id` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
