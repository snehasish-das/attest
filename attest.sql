-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2022 at 11:45 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attest`
--

-- --------------------------------------------------------

--
-- Table structure for table `tcm_features`
--

CREATE TABLE `tcm_features` (
  `feature_id` varchar(20) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(128) NOT NULL,
  `is_multi_sprint` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(40) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_by` varchar(40) NOT NULL,
  `last_updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tcm_nodes`
--

CREATE TABLE `tcm_nodes` (
  `id` varchar(40) NOT NULL,
  `node_name` varchar(40) NOT NULL,
  `parent_node` bigint(20) DEFAULT NULL,
  `distance_from_root` int(11) NOT NULL,
  `node_type` enum('testlab','testplan') NOT NULL DEFAULT 'testplan',
  `created_by` varchar(40) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_by` varchar(40) NOT NULL,
  `last_updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tcm_releases`
--

CREATE TABLE `tcm_releases` (
  `id` bigint(20) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(128) NOT NULL,
  `test_id` bigint(20) NOT NULL,
  `test_status` varchar(16) NOT NULL DEFAULT 'PASSED',
  `execution_date` date NOT NULL,
  `test_run_type` varchar(40) NOT NULL DEFAULT 'Automation',
  `bug_no` varchar(16) DEFAULT NULL,
  `test_run_link` varchar(256) DEFAULT NULL,
  `created_by` varchar(40) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_by` varchar(40) NOT NULL,
  `last_updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tcm_tests`
--

CREATE TABLE `tcm_tests` (
  `id` bigint(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` varchar(128) NOT NULL,
  `product` varchar(16) NOT NULL,
  `author` varchar(40) NOT NULL,
  `steps` blob NOT NULL,
  `expected_output` blob NOT NULL,
  `test_type` enum('Manual','Automation') DEFAULT 'Automation',
  `priority` int(11) NOT NULL,
  `automation_status` enum('Not Planned','In Progress','Ready','Not Applicable') DEFAULT NULL,
  `automation_author` varchar(40) DEFAULT NULL,
  `tag` varchar(128) DEFAULT NULL,
  `scrum_name` varchar(40) DEFAULT NULL,
  `pages_involved` blob DEFAULT NULL,
  `feature_id` bigint(20) DEFAULT NULL,
  `parent_node` bigint(20) NOT NULL,
  `created_by` varchar(40) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_by` varchar(40) NOT NULL,
  `last_updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tcm_users`
--

CREATE TABLE `tcm_users` (
  `id` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` enum('engineer','lead','manager') NOT NULL DEFAULT 'engineer',
  `created_by` varchar(40) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_by` varchar(40) NOT NULL,
  `last_updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tcm_users`
--

INSERT INTO `tcm_users` (`id`, `name`, `email`, `password`, `role`, `created_by`, `created_date`, `last_updated_by`, `last_updated_date`, `is_deleted`) VALUES
('a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', 'Snehasish', 'snehasish.das@247.ai', '40324e3209c735d1731d25fa42370f68', 'manager', 'Snehasish', '2022-07-04 08:30:59', 'Snehasish', '2022-07-04 08:30:59', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tcm_features`
--
ALTER TABLE `tcm_features`
  ADD PRIMARY KEY (`feature_id`) USING BTREE;

--
-- Indexes for table `tcm_nodes`
--
ALTER TABLE `tcm_nodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `node_name` (`node_name`);

--
-- Indexes for table `tcm_releases`
--
ALTER TABLE `tcm_releases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcm_tests`
--
ALTER TABLE `tcm_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcm_users`
--
ALTER TABLE `tcm_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tcm_releases`
--
ALTER TABLE `tcm_releases`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tcm_tests`
--
ALTER TABLE `tcm_tests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
