-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2022 at 11:42 AM
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
  `status` enum('Not Started','In Progress','Delivered','Partially Delivered','Cancelled','Not Planned') NOT NULL,
  `feature_type` enum('New Feature','Enhancement') NOT NULL,
  `description` varchar(128) NOT NULL,
  `is_multi_sprint` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(40) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_by` varchar(40) NOT NULL,
  `last_updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tcm_features`
--

INSERT INTO `tcm_features` (`feature_id`, `name`, `status`, `feature_type`, `description`, `is_multi_sprint`, `created_by`, `created_date`, `last_updated_by`, `last_updated_date`, `is_deleted`) VALUES
('17XYZ3', 'Demo Feature', 'Not Planned', 'New Feature', 'Demo feature for Assist Cards Tests', 1, 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-12 03:16:18', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-12 03:16:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcm_nodes`
--

CREATE TABLE `tcm_nodes` (
  `id` varchar(40) NOT NULL,
  `node_name` varchar(40) NOT NULL,
  `parent_node` varchar(40) DEFAULT NULL,
  `node_type` enum('testlab','testplan') NOT NULL DEFAULT 'testplan',
  `created_by` varchar(40) NOT NULL DEFAULT 'Seed Data',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_by` varchar(40) NOT NULL DEFAULT 'Seed Data',
  `last_updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tcm_nodes`
--

INSERT INTO `tcm_nodes` (`id`, `node_name`, `parent_node`, `node_type`, `created_by`, `created_date`, `last_updated_by`, `last_updated_date`, `is_deleted`) VALUES
('0cc0142c-001d-11ed-b09d-0c9a3ce20ee5', 'New Testplan Node', 'Answers', 'testplan', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-10 06:53:48', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-10 06:53:48', 0),
('2733a58e-001c-11ed-b09d-0c9a3ce20ee5', 'TestPlan Node 1', 'Answers', 'testplan', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-10 06:47:23', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-10 06:47:23', 0),
('29699302-fdb1-11ec-ba34-0c9a3ce20ee5', 'Open Channel', 'Messaging', 'testplan', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-07 02:50:24', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-07 02:50:24', 0),
('44c00fc3-0655-11ed-b99c-0c9a3ce20ee5', 'Feature runs', NULL, 'testlab', 'Seed Data', '2022-07-18 04:51:21', 'Seed Data', '2022-07-18 04:51:21', 0),
('82affcb1-fd9c-11ec-ba34-0c9a3ce20ee5', 'Cards', 'Assist', 'testplan', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-07 02:26:22', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-07 02:26:22', 0),
('93de6338-0654-11ed-b99c-0c9a3ce20ee5', 'Release', NULL, 'testlab', 'Seed Data', '2022-07-18 04:45:42', 'Seed Data', '2022-07-18 04:45:42', 0),
('ad8d2d4b-0654-11ed-b99c-0c9a3ce20ee5', 'Adhoc Runs', NULL, 'testlab', 'Seed Data', '2022-07-18 04:47:07', 'Seed Data', '2022-07-18 04:47:07', 0),
('c9f81d8d-065a-11ed-b99c-0c9a3ce20ee5', 'Test adhoc run', 'Adhoc Runs', 'testlab', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-18 05:30:52', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-18 05:30:52', 0),
('da8b5ae8-fd9a-11ec-ba34-0c9a3ce20ee5', 'Answers', NULL, 'testplan', 'Seed Data', '2022-07-07 02:16:47', 'Seed Data', '2022-07-07 02:16:47', 0),
('da8b65fc-fd9a-11ec-ba34-0c9a3ce20ee5', 'Conversation', NULL, 'testplan', 'Seed Data', '2022-07-07 02:16:47', 'Seed Data', '2022-07-07 02:16:47', 0),
('da8b666b-fd9a-11ec-ba34-0c9a3ce20ee5', 'Messaging', NULL, 'testplan', 'Seed Data', '2022-07-07 02:16:47', 'Seed Data', '2022-07-07 02:16:47', 0),
('da8b66ac-fd9a-11ec-ba34-0c9a3ce20ee5', 'Voice', NULL, 'testplan', 'Seed Data', '2022-07-07 02:16:47', 'Seed Data', '2022-07-07 02:16:47', 0),
('da8b66ed-fd9a-11ec-ba34-0c9a3ce20ee5', 'Butterfly', NULL, 'testplan', 'Seed Data', '2022-07-07 02:16:47', 'Seed Data', '2022-07-07 02:16:47', 0),
('f0de7882-fd9a-11ec-ba34-0c9a3ce20ee5', 'Assist', NULL, 'testplan', 'Seed Data', '2022-07-07 02:12:11', 'Seed Data', '2022-07-07 02:12:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcm_options`
--

CREATE TABLE `tcm_options` (
  `id` bigint(20) NOT NULL,
  `option_key` varchar(40) NOT NULL,
  `option_value` varchar(128) NOT NULL,
  `extra` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tcm_options`
--

INSERT INTO `tcm_options` (`id`, `option_key`, `option_value`, `extra`) VALUES
(1, 'site_name', 'Attest', '');

-- --------------------------------------------------------

--
-- Table structure for table `tcm_releases`
--

CREATE TABLE `tcm_releases` (
  `id` bigint(20) NOT NULL,
  `parent_node` varchar(40) NOT NULL,
  `test_id` bigint(20) NOT NULL,
  `test_status` enum('Not Started','Passed','Failed') DEFAULT 'Passed',
  `execution_date` date DEFAULT NULL,
  `test_run_type` varchar(40) DEFAULT 'Automation',
  `bug_no` varchar(16) DEFAULT NULL,
  `test_run_link` varchar(256) DEFAULT NULL,
  `created_by` varchar(40) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_by` varchar(40) NOT NULL,
  `last_updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tcm_releases`
--

INSERT INTO `tcm_releases` (`id`, `parent_node`, `test_id`, `test_status`, `execution_date`, `test_run_type`, `bug_no`, `test_run_link`, `created_by`, `created_date`, `last_updated_by`, `last_updated_date`, `is_deleted`) VALUES
(6, 'Test adhoc run', 1, 'Not Started', '2022-07-19', NULL, NULL, NULL, 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-19 07:37:47', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-19 07:37:47', 0),
(7, 'Test adhoc run', 2, 'Not Started', '2022-07-19', NULL, NULL, NULL, 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-19 07:37:47', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-19 07:37:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcm_tests`
--

CREATE TABLE `tcm_tests` (
  `id` bigint(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `product` varchar(16) NOT NULL,
  `author` varchar(40) NOT NULL,
  `steps` blob NOT NULL,
  `expected_output` blob NOT NULL,
  `test_type` enum('Manual','Automation') DEFAULT 'Automation',
  `priority` int(11) NOT NULL,
  `automation_status` enum('Not Planned','In Progress','Ready','Not Applicable') DEFAULT 'Not Planned',
  `automation_author` varchar(40) DEFAULT NULL,
  `tag` varchar(128) DEFAULT NULL,
  `scrum_name` varchar(40) DEFAULT NULL,
  `pages_involved` blob DEFAULT NULL,
  `feature_id` varchar(20) DEFAULT NULL,
  `parent_node` varchar(40) NOT NULL,
  `created_by` varchar(40) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_by` varchar(40) NOT NULL,
  `last_updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tcm_tests`
--

INSERT INTO `tcm_tests` (`id`, `name`, `description`, `product`, `author`, `steps`, `expected_output`, `test_type`, `priority`, `automation_status`, `automation_author`, `tag`, `scrum_name`, `pages_involved`, `feature_id`, `parent_node`, `created_by`, `created_date`, `last_updated_by`, `last_updated_date`, `is_deleted`) VALUES
(1, 'Dummy cards test 1', 'Some long description ', 'Assist', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', 0x4c6f67696e3e3e4e6176696761746520746f2041737369737420636f6e736f6c653e3e56657269667920636861743e3e4c6f676f75743e3e, 0x5375636365737366756c206c6f67696e3e3e4e6f206572726f7273206f6e2041737369737420636f6e736f6c653e3e41626c6520746f20696e74657261637420776974682076697369746f723e3e436c6f736520636861743e3e, 'Automation', 2, 'Not Planned', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', 'smoke,regression', 'E2E Squad', 0x6f6e65546f4f6e6543686174436f6e74726f6c6c65722e6a732c61646d696e436f6e74726f6c6c65722e6a732c777261705570436f6e74726f6c6c65722e6a73, '17XYZ3', 'Cards', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-07 02:40:40', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-07 02:40:40', 0),
(2, 'Some Meaningful Name', 'Some long description qwsdefg', 'Assist', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', 0x5374657020776974686f7574206578706563743e3e, 0x3e3e45787065637420776974686f75742073746570, 'Automation', 1, 'Not Planned', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', 'regression,smoke', 'E2E', NULL, ',,17XYZ3,17XYZ3,17XY', 'Cards', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-07 02:40:40', 'a1b2dc81-fb73-11ec-98ee-0c9a3ce20ee5', '2022-07-07 02:40:40', 0);

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
  ADD UNIQUE KEY `node_name` (`node_name`),
  ADD KEY `parent_node` (`parent_node`);

--
-- Indexes for table `tcm_options`
--
ALTER TABLE `tcm_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `option_key` (`option_key`);

--
-- Indexes for table `tcm_releases`
--
ALTER TABLE `tcm_releases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parent_node` (`parent_node`,`test_id`) USING BTREE;

--
-- Indexes for table `tcm_tests`
--
ALTER TABLE `tcm_tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `author` (`author`),
  ADD KEY `auto_author` (`automation_author`),
  ADD KEY `ts_parent_node` (`parent_node`);

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
-- AUTO_INCREMENT for table `tcm_options`
--
ALTER TABLE `tcm_options`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tcm_releases`
--
ALTER TABLE `tcm_releases`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tcm_tests`
--
ALTER TABLE `tcm_tests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tcm_releases`
--
ALTER TABLE `tcm_releases`
  ADD CONSTRAINT `tl_parent_node` FOREIGN KEY (`parent_node`) REFERENCES `tcm_nodes` (`node_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tcm_tests`
--
ALTER TABLE `tcm_tests`
  ADD CONSTRAINT `author` FOREIGN KEY (`author`) REFERENCES `tcm_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auto_author` FOREIGN KEY (`automation_author`) REFERENCES `tcm_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ts_parent_node` FOREIGN KEY (`parent_node`) REFERENCES `tcm_nodes` (`node_name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
