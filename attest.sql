-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2023 at 09:40 AM
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
('17XYZ3', 'Demo Feature', 'Not Planned', 'New Feature', 'Demo feature for Assist Cards Tests', 1, '00u1jnlgxtz2gRnpB1d8', '2022-07-12 03:16:18', '00u1jnlgxtz2gRnpB1d8', '2022-07-12 03:16:18', 0);

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
('0cc0142c-001d-11ed-b09d-0c9a3ce20ee5', 'New Testplan Node', 'Answers', 'testplan', '00u1jnlgxtz2gRnpB1d8', '2022-07-10 06:53:48', '00u1jnlgxtz2gRnpB1d8', '2022-07-10 06:53:48', 0),
('2733a58e-001c-11ed-b09d-0c9a3ce20ee5', 'TestPlan Node 1', 'Answers', 'testplan', '00u1jnlgxtz2gRnpB1d8', '2022-07-10 06:47:23', '00u1jnlgxtz2gRnpB1d8', '2022-07-10 06:47:23', 0),
('29699302-fdb1-11ec-ba34-0c9a3ce20ee5', 'Open Channel', 'Messaging', 'testplan', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:50:24', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:50:24', 0),
('44c00fc3-0655-11ed-b99c-0c9a3ce20ee5', 'Feature runs', NULL, 'testlab', '00u1jnlgxtz2gRnpB1d8', '2022-07-18 04:51:21', '00u1jnlgxtz2gRnpB1d8', '2022-07-18 04:51:21', 0),
('4bdcb09c-97bb-11ed-9c18-00059a3c7a00', 'Assist Admin tests', 'Adhoc Runs', 'testlab', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:01', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:01', 0),
('7a720d70-a799-11ed-a6ae-42010a0a2036', 'Card Designer', NULL, 'testplan', '00u1jnlgxtz2gRnpB1d8', '2023-02-08 10:15:14', '00u1jnlgxtz2gRnpB1d8', '2023-02-08 10:15:14', 0),
('82affcb1-fd9c-11ec-ba34-0c9a3ce20ee5', 'Cards', 'Assist', 'testplan', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:26:22', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:26:22', 0),
('93de6338-0654-11ed-b99c-0c9a3ce20ee5', 'Release', NULL, 'testlab', '00u1jnlgxtz2gRnpB1d8', '2022-07-18 04:45:42', '00u1jnlgxtz2gRnpB1d8', '2022-07-18 04:45:42', 0),
('ad8d2d4b-0654-11ed-b99c-0c9a3ce20ee5', 'Adhoc Runs', NULL, 'testlab', '00u1jnlgxtz2gRnpB1d8', '2022-07-18 04:47:07', '00u1jnlgxtz2gRnpB1d8', '2022-07-18 04:47:07', 0),
('c9f81d8d-065a-11ed-b99c-0c9a3ce20ee5', 'Test adhoc run', 'Adhoc Runs', 'testlab', '00u1jnlgxtz2gRnpB1d8', '2022-07-18 05:30:52', '00u1jnlgxtz2gRnpB1d8', '2022-07-18 05:30:52', 0),
('cfae4e58-97b9-11ed-9c18-00059a3c7a00', 'Admin console', 'Assist', 'testplan', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:26:23', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:26:23', 0),
('da8b5ae8-fd9a-11ec-ba34-0c9a3ce20ee5', 'Answers', NULL, 'testplan', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:16:47', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:16:47', 0),
('da8b65fc-fd9a-11ec-ba34-0c9a3ce20ee5', 'Conversation', NULL, 'testplan', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:16:47', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:16:47', 0),
('da8b666b-fd9a-11ec-ba34-0c9a3ce20ee5', 'Messaging', NULL, 'testplan', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:16:47', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:16:47', 0),
('da8b66ac-fd9a-11ec-ba34-0c9a3ce20ee5', 'Voice', NULL, 'testplan', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:16:47', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:16:47', 0),
('da8b66ed-fd9a-11ec-ba34-0c9a3ce20ee5', 'Butterfly', NULL, 'testplan', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:16:47', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:16:47', 0),
('f0de7882-fd9a-11ec-ba34-0c9a3ce20ee5', 'Assist', NULL, 'testplan', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:12:11', '00u1jnlgxtz2gRnpB1d8', '2022-07-07 02:12:11', 0);

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
  `test_run_type` enum('Manual','Automation') DEFAULT 'Manual',
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
(21, 'Adhoc Runs', 1, 'Passed', '2022-11-15', NULL, 'CXPC-1232', NULL, '00u1jnlgxtz2gRnpB1d8', '2022-07-21 07:03:06', '00u1jnlgxtz2gRnpB1d8', '2022-07-21 07:03:06', 0),
(23, 'Adhoc Runs', 2, NULL, '2022-11-15', NULL, NULL, NULL, '00u1jnlgxtz2gRnpB1d8', '2022-11-15 05:51:13', '00u1jnlgxtz2gRnpB1d8', '2022-11-15 05:51:13', 0),
(25, 'Feature runs', 1, NULL, '2022-12-22', NULL, NULL, NULL, '00u1jnlgxtz2gRnpB1d8', '2022-12-22 06:09:12', '00u1jnlgxtz2gRnpB1d8', '2022-12-22 06:09:12', 0),
(26, 'Feature runs', 2, NULL, '2022-12-22', NULL, NULL, NULL, '00u1jnlgxtz2gRnpB1d8', '2022-12-22 06:09:12', '00u1jnlgxtz2gRnpB1d8', '2022-12-22 06:09:12', 0),
(27, 'Assist Admin tests', 4, 'Failed', '2023-05-09', NULL, 'UAT-1253', NULL, '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:16', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:16', 0),
(28, 'Assist Admin tests', 5, NULL, '2023-01-19', NULL, NULL, NULL, '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:16', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:16', 0),
(29, 'Assist Admin tests', 6, NULL, '2023-01-19', NULL, NULL, NULL, '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:16', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:16', 0),
(30, 'Assist Admin tests', 7, 'Failed', '2023-04-11', NULL, 'UAT-1214', 'https://cicd.cloud.247-inc.net/job/certify-test-framework/job/TCM_Adhoc_Test_Run/13', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:16', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:16', 0),
(31, 'Assist Admin tests', 8, 'Failed', '2023-04-11', NULL, 'UAT-1219', 'https://cicd.cloud.247-inc.net/job/certify-test-framework/job/TCM_Adhoc_Test_Run/13', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:16', '00u1jnlgxtz2gRnpB1d8', '2023-01-19 05:37:16', 0),
(36, 'Test adhoc run', 9, NULL, '2023-02-10', NULL, NULL, NULL, '00u1jnlgxtz2gRnpB1d8', '2023-02-10 10:25:39', '00u1jnlgxtz2gRnpB1d8', '2023-02-10 10:25:39', 0);

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
  `steps` blob DEFAULT NULL,
  `expected_output` blob DEFAULT NULL,
  `test_type` enum('Manual','Automation') DEFAULT 'Automation',
  `test_category` enum('UI','REST','HYBRID') NOT NULL DEFAULT 'UI',
  `priority` int(11) NOT NULL,
  `automation_status` enum('Not Planned','In Progress','Ready','Not Applicable') DEFAULT 'Not Planned',
  `automation_script_path` varchar(256) DEFAULT NULL,
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

INSERT INTO `tcm_tests` (`id`, `name`, `description`, `product`, `author`, `steps`, `expected_output`, `test_type`, `test_category`, `priority`, `automation_status`, `automation_script_path`, `automation_author`, `tag`, `scrum_name`, `pages_involved`, `feature_id`, `parent_node`, `created_by`, `created_date`, `last_updated_by`, `last_updated_date`, `is_deleted`) VALUES
(1, 'Verify chat', 'Verify user interaction with agent and vice versa', 'Assist', '00u1jnlgxtz2gRnpB1d8', 0x4c6f67696e3e3e4e6176696761746520746f2041737369737420636f6e736f6c653e3e56657269667920636861743e3e4c6f676f75743e3e, 0x5375636365737366756c206c6f67696e3e3e4e6f206572726f7273206f6e2041737369737420636f6e736f6c653e3e41626c6520746f20696e74657261637420776974682076697369746f723e3e436c6f736520636861743e3e, 'Automation', 'UI', 2, 'Not Planned', NULL, '00u1jnlgxtz2gRnpB1d8', 'smoke,regression,E2Etest', 'E2E Squad', 0x6f6e65546f4f6e6543686174436f6e74726f6c6c65722e6a732c61646d696e436f6e74726f6c6c65722e6a732c777261705570436f6e74726f6c6c65722e6a73, '17XYZ3', 'Cards', '00u1jnlgxtz2gRnpB1d8', '2022-07-06 21:10:40', '00u1jnlgxtz2gRnpB1d8', '2022-07-06 21:10:40', 0),
(2, 'Verify cards availability', 'Verify if the payment card created in card designed is available during chat', 'Assist', '00u1jnlgxtz2gRnpB1d8', 0x4c6f67696e20746f20746865206170706c69636174696f6e20616e64206e6176696761746520746f20636172642064657369676e65723e3e4372656174652061206e6577207061796d656e7420636172643e3e5665726966792074686520636861742073657373696f6e207769746820757365206f662063617264, 0x3e3e7061796d656e74206361726420746f2062652063726561746564207375636365737366756c6c792077697468204e616d652c206164647265737320616e642063617264206e756d6265723e3e, 'Automation', 'UI', 1, 'Not Planned', NULL, '00u1jnlgxtz2gRnpB1d8', 'regression,smoke', 'E2E', NULL, ',,17XYZ3,17XYZ3,17XY', 'Cards', '00u1jnlgxtz2gRnpB1d8', '2022-07-06 21:10:40', '00u1jnlgxtz2gRnpB1d8', '2022-07-06 21:10:40', 0),
(3, 'CoCoIne Sanity', '', 'Answers', '00u1jnlgxtz2gRnpB1d8', NULL, NULL, 'Automation', 'UI', 1, 'Ready', './tests/integration/openchannel/OpenChannel.ts', '00u1jnlgxtz2gRnpB1d8', NULL, 'E2E', NULL, NULL, 'New Testplan Node', '00u1jnlgxtz2gRnpB1d8', '2023-01-12 04:02:03', '00u1jnlgxtz2gRnpB1d8', '2023-01-12 04:02:03', 0),
(4, 'Create new Queue', '', 'Assist', '00u1jnlgxtz2gRnpB1d8', NULL, NULL, 'Automation', 'UI', 1, 'Ready', './tests/component/assist/adminconsole/QueueTests.ts', '00u1jnlgxtz2gRnpB1d8', 'queuepage.jsp', 'E2E', NULL, ',17XYZ3', 'Admin console', '00u1jnlgxtz2gRnpB1d8', '2023-01-18 23:57:14', '00u1jnlgxtz2gRnpB1d8', '2023-01-18 23:57:14', 0),
(5, 'Create new Skill', NULL, 'Assist', '00u1jnlgxtz2gRnpB1d8', NULL, NULL, 'Automation', 'UI', 1, 'Ready', './tests/component/assist/adminconsole/SkillTests.ts', '00u1jnlgxtz2gRnpB1d8', NULL, 'E2E', NULL, NULL, 'Admin console', '', '2023-01-19 00:06:36', '', '2023-01-19 00:06:36', 0),
(6, 'Create new Team', NULL, 'Assist', '00u1jnlgxtz2gRnpB1d8', NULL, NULL, 'Automation', 'UI', 2, 'Ready', './tests/component/assist/adminconsole/TeamTests.ts', '00u1jnlgxtz2gRnpB1d8', NULL, 'E2E', NULL, NULL, 'Admin console', '', '2023-01-19 00:06:36', '', '2023-01-19 00:06:36', 0),
(7, 'Create new User', NULL, 'Assist', '00u1jnlgxtz2gRnpB1d8', NULL, NULL, 'Automation', 'UI', 3, 'Ready', './tests/component/assist/adminconsole/UserTests.ts', '00u1jnlgxtz2gRnpB1d8', NULL, 'E2E', NULL, NULL, 'Admin console', '', '2023-01-19 00:06:36', '', '2023-01-19 00:06:36', 0),
(8, 'Update Skill', NULL, 'Assist', '00u1jnlgxtz2gRnpB1d8', NULL, NULL, 'Automation', 'UI', 1, 'Ready', './tests/component/assist/adminconsole/SkillTests.ts', '00u1jnlgxtz2gRnpB1d8', NULL, 'E2E', NULL, NULL, 'Admin console', '', '2023-01-19 00:06:36', '', '2023-01-19 00:06:36', 0),
(9, 'Create new Payment Card', 'Create new Payment Card', 'Answers', '00u1jnlgxtz2gRnpB1d8', NULL, NULL, 'Automation', 'UI', 1, 'Ready', './tests/component/carddesigner/PaymentCardTests.ts', '00u1jnlgxtz2gRnpB1d8', NULL, 'E2E', NULL, NULL, 'Card Designer', '00u1jnlgxtz2gRnpB1d8', '2023-02-08 04:57:38', '00u1jnlgxtz2gRnpB1d8', '2023-02-08 04:57:38', 0);

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
('00u1jnlgxtz2gRnpB1d8', 'Snehasish Das', 'Snehasish.Das@247-inc.com', '2b138823b6acf935674f955e65702ca8', 'manager', 'OKTA', '2023-06-05 07:08:27', 'OKTA', '2023-06-05 07:08:27', 0);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tcm_tests`
--
ALTER TABLE `tcm_tests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
