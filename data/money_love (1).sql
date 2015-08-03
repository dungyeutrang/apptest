-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2015 at 12:36 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `money_love`
--

-- --------------------------------------------------------

--
-- Table structure for table `mst_catalog`
--

CREATE TABLE IF NOT EXISTS `mst_catalog` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mst_catalog`
--

INSERT INTO `mst_catalog` (`id`, `name`) VALUES
(1, 'Income\r\n'),
(2, 'Expense');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `id` int(11) NOT NULL,
  `wallet_id` int(11) DEFAULT NULL,
  `catalog_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `is_perform` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `wallet_id`, `catalog_id`, `parent_id`, `name`, `avatar`, `is_default`, `status`, `is_perform`) VALUES
(1, NULL, 1, 0, 'Debt', '/Manage/img/icon-system/debt.png', 1, 0, 0),
(2, NULL, 1, 0, 'Give', '/Manage/img/icon-system/give.png', 1, 0, 0),
(3, NULL, 1, 0, 'Other', '/Manage/img/icon-system/other.png', 1, 0, 0),
(4, NULL, 1, 0, 'Award', '/Manage/img/icon-system/award.png', 1, 0, 1),
(5, NULL, 1, 0, 'Salary', '/Manage/img/icon-system/salary.png', 1, 0, 1),
(6, NULL, 2, 0, 'Loan', '/Manage/img/icon-system/loan.png', 1, 0, 0),
(7, NULL, 2, 0, 'Other', '/Manage/img/icon-system/other.png', 1, 0, 0),
(8, NULL, 2, 0, 'Phone', '/Manage/img/icon-system/phone.png', 1, 0, 1),
(9, NULL, 2, 0, 'Transport', '/Manage/img/icon-system/transport.png', 1, 0, 1),
(10, NULL, 2, 0, 'Entertaiment', '/Manage/img/icon-system/entertaiment.png', 1, 0, 1),
(11, NULL, 2, 0, 'Friends and Lover', '/Manage/img/icon-system/heart.png', 1, 0, 1),
(12, NULL, 2, 0, 'Travel', '/Manage/img/icon-system/travel.png', 1, 0, 1),
(55, 77, 1, 2, 'fwfwfw', '/Uploads/9/2015-08-03-12-08-03.jpg', 0, 1, 1),
(56, 78, 1, 0, 'wfwfwfwfwfw', NULL, 0, 0, 1),
(57, 77, 2, 0, 'fwfwfwf', NULL, 0, 1, 1),
(58, 77, 2, 7, 'Bonus', '/Uploads/9/2015-08-03-15-08-03.png', 0, 0, 1),
(59, 77, 2, 7, 'Sub Orther', '/Uploads/9/2015-08-03-14-08-06.png', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category_default_delete`
--

CREATE TABLE IF NOT EXISTS `tbl_category_default_delete` (
  `id` int(11) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_category_default_delete`
--

INSERT INTO `tbl_category_default_delete` (`id`, `wallet_id`, `category_id`) VALUES
(1, 77, 5),
(2, 77, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE IF NOT EXISTS `tbl_transaction` (
  `id` int(11) NOT NULL,
  `parent_transaction_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`id`, `parent_transaction_id`, `category_id`, `wallet_id`, `amount`, `note`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(17, 0, 3, 77, 5000000, 'Initial Balance', '2015-08-03 11:53:50', NULL, NULL, 0),
(18, 0, 3, 78, 125333, 'Initial Balance', '2015-08-03 11:54:07', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `birth_day` date DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `last_wallet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `email`, `password`, `phone`, `last_name`, `first_name`, `birth_day`, `is_active`, `last_wallet_id`) VALUES
(2, 'anhnhoem@gmail.com', '$2y$10$f5FcbSH4JEIFPa4Va3UO..hOct65qKCBoS.Lj8xIQvQksotJChqGC', '01672444730', 'wfw', 'wfwfw', '2015-07-29', 0, NULL),
(3, 'dungyeutrang@gmail.com', '$2y$10$RRJdb.TfZq1r5IGK5hcBHOlS4rGLWHSovr/XdeY17IUkcA.ynQZNC', '01672444730', 'ewf', 'vanwfwfw', '2015-07-30', 0, NULL),
(4, 'dungyeutrang123@gmail.com', '$2y$10$.MuT0DQvQi40pxtebKfryuAR75k3TNT8Z0meeAp/5sLUDqiDJfk4q', '01672444730', 'ewf', 'vanwfwfw', '2015-07-30', 0, NULL),
(5, 'dungbk@gmail.com', '$2y$10$x7Ad68eS3v7bGe6/jt52g.joi.J.Ap9xXIqZhBQrxBb3mW1Sdk.3i', '0189235667', 'dung', 'van', '2015-07-29', 1, NULL),
(6, 'kimcuongden.bk@gmail.com', '$2y$10$gCWxiiOFqYSxBVqF5lQ/4OOQzoTWkMscE7OCsNOqcsKCHwpI0KoLC', '0986555226', 'Phùng', 'Văn Dũng', '2015-07-14', 1, NULL),
(7, 'dungict@gmail.com', '$2y$10$Ggn4LCt4/fQbv2UU65gi0.80.q0.y0C5Xvl19XxdRhinIPV4JkmGu', '0989139255', 'Phung ', 'van dung', '2015-07-30', 0, NULL),
(8, 'dungictk55@gmail.com', '$2y$10$omvhEdFmnVeL55wJZuaB9uzDfdP83G31QyDpbys98D34TycaJbYaq', '0163222558', 'Phùng ', 'Văn  Dũng', '2015-07-15', 1, NULL),
(9, 'dungpv@rikkeisoft.com', '$2y$10$Y6g1IZTC7.zAZ9Fee.x1NO9jp8STGB7lH00h5W7p7T.OQGKrWxobC', '01672444732', 'van', 'nam', '2015-07-14', 1, NULL),
(10, 'cuongdola@gmail.com', '$2y$10$/t9DlDBJeQTJh/d/Rg4rd.oVDKhwawkD8q7IJpOdxBtEDWITnDXJG', '0986772553', 'dung', 'van', '2015-07-29', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wallet`
--

CREATE TABLE IF NOT EXISTS `tbl_wallet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `amount` float DEFAULT '0',
  `is_default` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_wallet`
--

INSERT INTO `tbl_wallet` (`id`, `user_id`, `name`, `amount`, `is_default`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(77, 9, 'Salary', 5000000, 1, '2015-08-03 11:08:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(78, 9, 'cocacola', 125333, 0, '2015-08-03 11:08:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_catalog`
--
ALTER TABLE `mst_catalog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`), ADD KEY `catalog_id` (`catalog_id`), ADD KEY `wallet_id` (`wallet_id`), ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `tbl_category_default_delete`
--
ALTER TABLE `tbl_category_default_delete`
  ADD PRIMARY KEY (`id`), ADD KEY `wallet_id` (`wallet_id`), ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`), ADD KEY `catalog_id` (`category_id`), ADD KEY `category_id` (`category_id`), ADD KEY `user_id` (`wallet_id`), ADD KEY `wallet_id` (`wallet_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`), ADD KEY `last_wallet_id` (`last_wallet_id`);

--
-- Indexes for table `tbl_wallet`
--
ALTER TABLE `tbl_wallet`
  ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_catalog`
--
ALTER TABLE `mst_catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `tbl_category_default_delete`
--
ALTER TABLE `tbl_category_default_delete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_wallet`
--
ALTER TABLE `tbl_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_category`
--
ALTER TABLE `tbl_category`
ADD CONSTRAINT `tbl_category_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `mst_catalog` (`id`),
ADD CONSTRAINT `tbl_category_ibfk_3` FOREIGN KEY (`wallet_id`) REFERENCES `tbl_wallet` (`id`);

--
-- Constraints for table `tbl_category_default_delete`
--
ALTER TABLE `tbl_category_default_delete`
ADD CONSTRAINT `tbl_category_default_delete_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `tbl_wallet` (`id`),
ADD CONSTRAINT `tbl_category_default_delete_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`);

--
-- Constraints for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
ADD CONSTRAINT `tbl_transaction_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`),
ADD CONSTRAINT `tbl_transaction_ibfk_3` FOREIGN KEY (`wallet_id`) REFERENCES `tbl_wallet` (`id`);

--
-- Constraints for table `tbl_wallet`
--
ALTER TABLE `tbl_wallet`
ADD CONSTRAINT `tbl_wallet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
