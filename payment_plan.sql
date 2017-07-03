-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2017 at 08:51 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payment_plan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `itemId` int(11) NOT NULL,
  `itemHeader` varchar(512) NOT NULL COMMENT 'Heading',
  `itemSub` varchar(1021) NOT NULL COMMENT 'sub heading',
  `itemDesc` text COMMENT 'content or description',
  `itemImage` varchar(80) DEFAULT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`itemId`, `itemHeader`, `itemSub`, `itemDesc`, `itemImage`, `isDeleted`, `createdBy`, `createdDtm`, `updatedDtm`, `updatedBy`) VALUES
(1, 'jquery.validation.js', 'Contribution towards jquery.validation.js', 'jquery.validation.js is the client side javascript validation library authored by Jörn Zaefferer hosted on github for us and we are trying to contribute to it. Working on localization now', 'validation.png', 0, 1, '2015-09-02 00:00:00', NULL, NULL),
(2, 'CodeIgniter User Management', 'Demo for user management system', 'This the demo of User Management System (Admin Panel) using CodeIgniter PHP MVC Framework and AdminLTE bootstrap theme. You can download the code from the repository or forked it to contribute. Usage and installation instructions are provided in ReadMe.MD', 'cias.png', 0, 1, '2015-09-02 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plans`
--

CREATE TABLE `tbl_plans` (
  `planId` int(11) NOT NULL COMMENT 'Plan ID',
  `title` varchar(100) NOT NULL,
  `summary` text,
  `amount` int(11) NOT NULL,
  `payDate` date NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `userid` int(11) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT '0',
  `createdDtm` date NOT NULL,
  `updatedDtm` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_plans`
--

INSERT INTO `tbl_plans` (`planId`, `title`, `summary`, `amount`, `payDate`, `status`, `userid`, `isDeleted`, `createdDtm`, `updatedDtm`) VALUES
(1, 'Suffer123', '', 10001, '2016-10-11', 2, 1, 0, '2017-07-02', '2017-07-02'),
(2, 'Suffer', '', 100, '2017-07-04', 1, 1, 0, '2017-04-05', '2017-07-03'),
(3, 'Suffer 2', 'Sample Payment', 100, '2017-07-06', 1, 4, 0, '2017-07-03', NULL),
(4, 'Suffer 3', 'Sample Payment', 100, '2017-07-06', 1, 6, 0, '2017-07-03', NULL),
(5, 'Suffer 4', 'Sample Payment', 100, '2017-07-06', 1, 1, 0, '2017-07-03', NULL),
(6, 'Suffer 5', 'Sample Payment', 100, '2017-07-06', 1, 2, 0, '2017-07-03', NULL),
(7, 'Suffer', '', 5000, '2017-07-30', 2, 1, 0, '2017-07-02', '2017-07-03'),
(8, 'Small work', '', 30, '2017-07-12', 1, 1, 0, '2017-07-02', '2017-07-03'),
(9, '111', '', 1, '2017-07-20', 1, 1, 1, '2017-07-02', '2017-07-02'),
(10, '123123', '123123', 123, '2017-07-31', 1, 1, 1, '2017-07-03', '2017-07-03'),
(11, '113123123123', '11111112312312312321', 123, '2017-07-19', 1, 0, 1, '2017-07-03', '2017-07-03'),
(12, '13123123', '1231231231231231231', 123, '2017-07-12', 1, 3, 0, '2017-07-03', '2017-07-03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pstatuses`
--

CREATE TABLE `tbl_pstatuses` (
  `pstatusId` tinyint(4) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pstatuses`
--

INSERT INTO `tbl_pstatuses` (`pstatusId`, `status`) VALUES
(1, 'Active'),
(2, 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reset_password`
--

CREATE TABLE `tbl_reset_password` (
  `id` bigint(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activation_id` varchar(32) NOT NULL,
  `agent` varchar(512) NOT NULL,
  `client_ip` varchar(32) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` bigint(20) NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL,
  `updatedBy` bigint(20) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `roleId` tinyint(4) NOT NULL COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`roleId`, `role`) VALUES
(1, 'System Administrator'),
(2, 'Manager'),
(3, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userId` int(11) NOT NULL,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'hashed login password',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `mobile` varchar(20) DEFAULT NULL,
  `roleId` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userId`, `email`, `password`, `name`, `mobile`, `roleId`, `isDeleted`, `createdBy`, `createdDtm`, `updatedBy`, `updatedDtm`) VALUES
(1, 'admin@codeinsect.com', '$2y$10$XP685wAiv1mntkezbhUYT.A.Qx3f2wTMyOaN3VDL79qZyf0Q0yj52', 'Sorino Ivanov11123', '9890098900', 1, 0, 0, '2015-07-01 18:56:49', 1, '2017-07-02 21:30:23'),
(2, 'manager@codeinsect.com', '$2y$10$yGtOyUvt8.JXFRMPzqtKTeu8SgyARi0Rui7LqB.6M7izCwJEZfPYG', 'Ruth Moore', '9890098900', 2, 0, 1, '2016-12-09 17:49:56', 1, '2017-06-26 14:10:37'),
(3, 'employee@codeinsect.com', '$2y$10$m96ZL/dvPeEtIwhFH7.5y.R1Zp0KA2P4ND7So95.zHwctkCXoaM6y', 'David Moore', '9890098900', 3, 0, 1, '2016-12-09 17:50:22', 1, '2017-06-26 14:10:51'),
(4, 'employee1@codeinsect.com', '$2y$10$m96ZL/dvPeEtIwhFH7.5y.R1Zp0KA2P4ND7So95.zHwctkCXoaM6y', 'David Moore 1', '9890098900', 3, 0, 1, '2016-12-09 17:50:22', 1, '2017-06-26 14:10:51'),
(5, 'employee2@codeinsect.com', '$2y$10$m96ZL/dvPeEtIwhFH7.5y.R1Zp0KA2P4ND7So95.zHwctkCXoaM6y', 'David Moore 2', '9890098900', 2, 0, 1, '2016-12-09 17:50:22', 1, '2017-06-26 14:10:51'),
(6, 'employee3@codeinsect.com', '$2y$10$m96ZL/dvPeEtIwhFH7.5y.R1Zp0KA2P4ND7So95.zHwctkCXoaM6y', 'David Moore 3', '9890098900', 1, 0, 1, '2016-12-09 17:50:22', 1, '2017-06-26 14:10:51'),
(7, 'employee4@codeinsect.com', '$2y$10$m96ZL/dvPeEtIwhFH7.5y.R1Zp0KA2P4ND7So95.zHwctkCXoaM6y', 'David Moore 4', '9890098900', 2, 0, 1, '2016-12-09 17:50:22', 1, '2017-06-26 14:10:51'),
(8, 'employee5@codeinsect.com', '$2y$10$m96ZL/dvPeEtIwhFH7.5y.R1Zp0KA2P4ND7So95.zHwctkCXoaM6y', 'David Moore 5', '9890098900', 2, 0, 1, '2017-07-03 17:50:22', 1, '2017-06-26 14:10:51'),
(9, 'test@test.com', '$2y$10$dpZSk44fpqTCGogNAqWDcOLytXuypZEeS.OVM5IO49/6Nvp5UGMd6', 'Sorino Kk', '1111111111', 1, 0, 1, '2017-07-02 18:32:53', NULL, NULL),
(10, 'admin11@codeinsect.com', '$2y$10$xqCweLn9lKAIH1mtqGTIM./6OldjR/l2pl2MJo4Sm/VbcnCK13ZUS', '123 123', '1111111111', 1, 1, 1, '2017-07-02 18:34:32', 1, '2017-07-02 20:34:46'),
(11, 'admin123@codeinsect.com', '$2y$10$pLLYeW316io7cHyBkRso..N.4bhe.DFMkjL8H/we7qFLgRJXnBspK', '123123', '1211111111', 1, 1, 1, '2017-07-02 21:30:42', 3, '2017-07-03 08:00:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `tbl_plans`
--
ALTER TABLE `tbl_plans`
  ADD PRIMARY KEY (`planId`);

--
-- Indexes for table `tbl_pstatuses`
--
ALTER TABLE `tbl_pstatuses`
  ADD PRIMARY KEY (`pstatusId`);

--
-- Indexes for table `tbl_reset_password`
--
ALTER TABLE `tbl_reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`roleId`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_plans`
--
ALTER TABLE `tbl_plans`
  MODIFY `planId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Plan ID', AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_pstatuses`
--
ALTER TABLE `tbl_pstatuses`
  MODIFY `pstatusId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_reset_password`
--
ALTER TABLE `tbl_reset_password`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
