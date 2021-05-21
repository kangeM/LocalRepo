-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 07, 2018 at 08:27 AM
-- Server version: 5.7.20
-- PHP Version: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bongasms`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `visible` tinyint(2) DEFAULT '1',
  `inserted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `action`, `visible`, `inserted_at`, `updated_at`) VALUES
(1, 'omnipotent', 0, '2018-03-21 12:34:03', '2018-08-17 14:13:46'),
(2, 'manage_clients', 0, '2018-08-17 18:28:07', '2018-09-03 18:59:08'),
(3, 'manage_users', 1, '2018-08-19 10:35:25', '2018-08-19 07:35:25'),
(4, 'manage_actions', 0, '2018-09-03 21:57:08', '2018-09-03 18:57:08'),
(5, 'manage_permissions', 1, '2018-09-03 21:57:58', '2018-09-03 18:57:58'),
(6, 'manage_user_groups', 1, '2018-09-03 21:58:19', '2018-09-03 18:58:19'),
(7, 'manage_groups', 1, '2018-09-03 21:58:45', '2018-09-03 18:58:45'),
(8, 'manage_notifications', 0, '2018-09-04 18:49:10', '2018-09-04 15:49:10'),
(9, 'view_user_audits', 1, '2018-09-06 19:08:50', '2018-09-06 16:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  `sms_credits_cr` int(11) DEFAULT '0',
  `sms_credits_dr` int(11) DEFAULT '0',
  `sms_credits` int(11) DEFAULT '0',
  `api_key` varchar(255) DEFAULT NULL,
  `api_secret` varchar(255) DEFAULT NULL,
  `api_token` varchar(255) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1',
  `parent_id` int(11) DEFAULT '1',
  `reseller_flag` char(3) DEFAULT 'NO',
  `cost_per_sms` float DEFAULT '1',
  `inserted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `phone`, `address`, `sms_credits_cr`, `sms_credits_dr`, `sms_credits`, `api_key`, `api_secret`, `api_token`, `status`, `parent_id`, `reseller_flag`, `cost_per_sms`, `inserted_at`, `updated_at`) VALUES
(1, 'Olive', 'chaliblues@gmail.com', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 'NO', 1, NULL, '2018-09-03 12:16:13'),
(7, 'Olive Tree Test', 'wambani@live.com', '254704965665', NULL, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 'NO', 1, '2018-09-03 21:45:17', '2018-09-03 18:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `inserted_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group`, `client_id`, `created_by`, `updated_by`, `inserted_at`, `updated_at`) VALUES
(1, 'GODS', 1, 2, 2, '2018-03-21 12:33:10', '2018-08-17 15:29:05'),
(2, 'ADMINS', 1, 2, 2, '2018-08-17 18:30:28', '2018-08-17 15:30:28');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1532171409),
('m130524_201442_init', 1532171413);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `msisdn` varchar(50) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `status` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `processed` tinyint(2) DEFAULT '0',
  `inserted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `email`, `msisdn`, `subject`, `message`, `status`, `client_id`, `processed`, `inserted_at`, `updated_at`) VALUES
(1, 'chaliblues@gmail.com', '254704965665', NULL, 'Hi ,<br/>\n              Your BongaSMS account password recovery request has been processed. Kindly Follow the below link to complete your password recovery.<br/><br/>\n              Link:<a href=\"http://localhost/bongasms/index.php/site/recover-password?&email=chaliblues@gmail.com&token=z3vApOgrZv\">Password Recover Link</a>\n    <br/>', 1, NULL, 0, '2018-09-03 12:55:32', '2018-09-03 09:55:32'),
(2, 'wambani@live.com', '254704965665', 'BongaSMS Registration Notification', 'Hi Wambani Sewe ,<br/>\n              Your BongaSMS account has has been processed. Details are listed below :<br/><br/>\n              \n              Account Name : Olive Tree Test<br/>\n              Account Email: wambani@live.com<br/>\n              Account Phone: 254704965665<br/><br/>\n\n              Admin User Name  : Wambani Sewe<br/>\n              Admin User Phone : 254704965665<br/>\n    <br/>', 1, NULL, 0, '2018-09-03 21:45:17', '2018-09-03 18:45:17'),
(3, 'chaliblues@gmail.com', '254704965665', 'BongaSMS Forgot Password Notification', 'Hi ,<br/>\n              Your BongaSMS account password recovery request has been processed. Kindly Follow the below link to complete your password recovery.<br/><br/>\n              Link:<a href=\"http://localhost/bongasms/index.php/site/recover-password?&email=chaliblues@gmail.com&token=TXmcTN41bc\">Password Recover Link</a>\n    <br/>', 1, NULL, 0, '2018-09-05 10:26:23', '2018-09-05 07:26:23'),
(4, 'chaliblues@gmail.com', '254704965665', 'BongaSMS Forgot Password Notification', 'Hi ,<br/>\n              Your BongaSMS account password recovery request has been processed. Kindly Follow the below link to complete your password recovery.<br/><br/>\n              Link:<a href=\"http://localhost/bongasms/index.php/site/recover-password?&email=chaliblues@gmail.com&token=U5r9cGzmgs\">Password Recover Link</a>\n    <br/>', 1, NULL, 0, '2018-09-05 10:30:13', '2018-09-05 07:30:13'),
(5, 'chaliblues@gmail.com', '254704965665', 'BongaSMS Forgot Password Notification', 'Hi ,<br/>\n              Your BongaSMS account password recovery request has been processed. Kindly Follow the below link to complete your password recovery.<br/><br/>\n              Link:<a href=\"http://localhost/bongasms/index.php/site/recover-password?&email=chaliblues@gmail.com&token=krBXAesvqJ\">Password Recover Link</a>\n    <br/>', 1, NULL, 0, '2018-09-05 10:31:09', '2018-09-05 07:31:09'),
(6, 'chaliblues@gmail.com', '254704965665', 'BongaSMS Forgot Password Notification', 'Hi ,<br/>\n              Your BongaSMS account password recovery request has been processed. Kindly Follow the below link to complete your password recovery.<br/><br/>\n              Link:<a href=\"http://localhost/bongasms/index.php/site/recover-password?&email=chaliblues@gmail.com&token=B8umKGJeZZ\">Password Recover Link</a>\n    <br/>', 1, 1, 0, '2018-09-05 10:33:42', '2018-09-05 07:33:42'),
(7, 'chaliblues@gmail.com', '254704965665', 'BongaSMS Forgot Password Notification', 'Hi ,<br/>\n              Your BongaSMS account password recovery request has been processed. Kindly Follow the below link to complete your password recovery.<br/><br/>\n              Link:<a href=\"http://localhost/bongasms/index.php/site/recover-password?&email=chaliblues@gmail.com&token=HuxKTdfOYs\">Password Recover Link</a>\n    <br/>', 1, 1, 0, '2018-09-05 10:40:25', '2018-09-05 07:40:25'),
(8, 'chaliblues@gmail.com', '254704965665', 'BongaSMS Forgot Password Notification', 'Hi ,<br/>\n              Your BongaSMS account password recovery request has been processed. Kindly Follow the below link to complete your password recovery.<br/><br/>\n              Link:<a href=\"http://localhost/bongasms/index.php/site/recover-password?&email=chaliblues@gmail.com&token=6fh0C93SR4\">Password Recover Link</a>\n    <br/>', 1, 1, 0, '2018-09-05 10:42:10', '2018-09-05 07:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `inserted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `group_id`, `action_id`, `status`, `created_by`, `updated_by`, `inserted_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2, 2, '2018-03-21 12:34:20', '2018-03-21 09:34:20'),
(2, 2, 2, 2, 2, 11, '2018-08-19 10:56:15', '2018-09-03 18:29:21'),
(3, 2, 3, 1, 2, 2, '2018-08-19 10:56:15', '2018-08-19 07:56:15'),
(5, 2, 5, 1, 2, 2, '2018-09-03 22:04:31', '2018-09-03 19:04:31'),
(6, 2, 6, 1, 2, 2, '2018-09-03 22:04:31', '2018-09-03 19:04:31'),
(7, 2, 7, 1, 2, 2, '2018-09-03 22:04:31', '2018-09-03 19:04:31'),
(8, 2, 9, 1, 2, 2, '2018-09-06 22:10:33', '2018-09-06 19:10:33');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `visible` tinyint(2) DEFAULT '0',
  `inserted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`, `visible`, `inserted_at`) VALUES
(1, 'ACTIVE', 1, '2017-07-26 06:33:14'),
(2, 'INACTIVE', 1, '2017-07-26 06:33:14'),
(3, 'PENDING', 1, '2017-07-26 06:33:14'),
(4, 'FAILED_AUTH', 1, '2017-07-26 06:33:14'),
(5, 'SUCCESS', 1, '2017-08-04 15:21:59'),
(6, 'FAILED', 1, '2017-08-04 15:22:10');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `names` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msisdn` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `inserted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `names`, `msisdn`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `client_id`, `status`, `created_by`, `updated_by`, `inserted_at`, `updated_at`) VALUES
(2, 'Charles Sewe', '254704965665', 'chaliblues', '', '$2y$13$4xxaPQ8.8Lh4fIDzrJACZeS3YzsmP9wLp0FS/QVAmMU89MLktHmNG', '$2y$13$WSSfxFvW5xsbhsEOynja6uVJj9DnPnnjNaqbLNe5OQCMXpvaYKtwu', 'chaliblues@gmail.com', 1, 1, 2, NULL, '2018-07-21 00:00:00', '2018-09-05 07:42:10'),
(14, 'Wambani C Sewe', '254704965665', NULL, NULL, '$2y$13$JJhaj4GULBzLhEpo6OYGP.zR0H63rApaUki9nuts9HxiXgOWLmdiq', NULL, 'wambani@live.com', 7, 1, NULL, 2, '2018-09-03 21:45:17', '2018-09-06 19:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_audits`
--

CREATE TABLE `user_audits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `action_id` int(11) DEFAULT NULL,
  `comments` text,
  `table_name` varchar(255) DEFAULT NULL,
  `table_key` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `inserted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_audits`
--

INSERT INTO `user_audits` (`id`, `user_id`, `client_id`, `action_id`, `comments`, `table_name`, `table_key`, `status`, `inserted_at`, `updated_at`) VALUES
(1, 2, 1, 3, 'UPDATE', 'user', 14, 5, '2018-09-06 21:42:21', '2018-09-06 18:42:21'),
(2, 2, 1, 3, 'UPDATE', 'user', 14, 5, '2018-09-06 21:43:07', '2018-09-06 18:43:07'),
(3, 2, 1, 3, 'UPDATE', 'user', 14, 5, '2018-09-06 22:03:35', '2018-09-06 19:03:35'),
(4, 2, 1, 3, 'UPDATE', 'user', 14, 5, '2018-09-06 22:05:33', '2018-09-06 19:05:33'),
(5, 2, 1, 3, 'UPDATE', 'user', 14, 5, '2018-09-06 22:05:54', '2018-09-06 19:05:54'),
(6, 2, 1, 3, 'UPDATE', 'user', 14, 5, '2018-09-06 22:06:55', '2018-09-06 19:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_audit_details`
--

CREATE TABLE `user_audit_details` (
  `id` int(11) NOT NULL,
  `user_audit_id` int(11) DEFAULT NULL,
  `old_value` text,
  `new_value` text,
  `field` varchar(250) DEFAULT NULL,
  `inserted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_audit_details`
--

INSERT INTO `user_audit_details` (`id`, `user_audit_id`, `old_value`, `new_value`, `field`, `inserted_at`) VALUES
(1, 6, 'Wambani Sewe', 'Wambani C Sewe', 'names', '2018-09-06 19:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `inserted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `user_id`, `group_id`, `status`, `created_by`, `updated_by`, `inserted_at`, `updated_at`) VALUES
(1, 2, 1, 1, 4, 4, '2018-08-17 12:19:09', '2018-08-17 09:19:09'),
(8, 14, 2, 1, NULL, NULL, '2018-09-03 21:45:17', '2018-09-03 18:45:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_phone` (`phone`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_fk0` (`client_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_id` (`group_id`,`action_id`),
  ADD KEY `group_actions_fk0` (`group_id`),
  ADD KEY `group_actions_fk1` (`action_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `user_audits`
--
ALTER TABLE `user_audits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_audit_details`
--
ALTER TABLE `user_audit_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_groups_fk0` (`user_id`),
  ADD KEY `user_groups_fk1` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_audits`
--
ALTER TABLE `user_audits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_audit_details`
--
ALTER TABLE `user_audit_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
