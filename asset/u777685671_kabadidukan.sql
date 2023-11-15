-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 15, 2023 at 03:26 AM
-- Server version: 10.6.14-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u777685671_kabadidukan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_area_master`
--

CREATE TABLE `admin_area_master` (
  `id` int(11) NOT NULL,
  `area_name` varchar(50) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_area_master`
--

INSERT INTO `admin_area_master` (`id`, `area_name`, `city`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(1, 'Bariniput', 1, '2023-09-16 12:23:03', 1, '2023-09-16 12:23:03', 1, 1),
(2, 'Gandhi Chowk Area', 1, '2023-09-16 12:24:13', 1, '2023-09-25 20:07:59', 1, 1),
(3, 'Uper Kolab Power House', 1, '2023-09-16 12:31:55', 1, '2023-09-25 19:58:52', 1, 1),
(4, 'Dhepaguda', 1, '2023-09-25 20:00:03', 1, '2023-09-25 20:00:03', 1, 1),
(5, 'Gauda Sahi', 1, '2023-09-25 20:00:57', 1, '2023-09-25 20:00:57', 1, 1),
(6, 'Parabeda And Extensions', 1, '2023-09-25 20:06:19', 1, '2023-09-25 20:09:33', 1, 1),
(7, 'Old Bus Stand Area', 1, '2023-09-25 20:06:50', 1, '2023-09-25 20:06:50', 1, 1),
(8, 'Christian Peta', 1, '2023-09-25 20:10:09', 1, '2023-09-25 20:10:09', 1, 1),
(9, 'Irrigation Colony And Extensions', 1, '2023-09-25 20:27:20', 1, '2023-09-25 20:27:30', 1, 1),
(10, 'New Bus Stand Area', 1, '2023-09-25 20:27:47', 1, '2023-09-25 20:27:47', 1, 1),
(11, 'Phula Bada Area ', 1, '2023-09-25 20:28:35', 1, '2023-09-25 20:28:35', 1, 1),
(12, 'Umeri', 1, '2023-09-25 20:32:42', 1, '2023-09-25 20:32:42', 1, 1),
(13, 'Nua Sahi Area', 1, '2023-09-25 21:08:15', 1, '2023-09-25 21:08:15', 1, 1),
(14, 'Main Road', 1, '2023-09-25 21:09:15', 1, '2023-09-25 21:09:15', 1, 1),
(15, 'Daily Market Area', 1, '2023-09-25 21:10:00', 1, '2023-09-25 21:10:00', 1, 1),
(16, 'Raja Nagar', 1, '2023-09-25 21:11:02', 1, '2023-09-25 21:11:02', 1, 1),
(17, 'Purnagad', 1, '2023-09-25 21:11:50', 1, '2023-09-25 21:36:08', 1, 1),
(18, 'Jaya Nagar', 1, '2023-09-25 21:14:44', 1, '2023-09-25 21:14:44', 1, 1),
(19, 'Powehouse Colony Jeypore', 1, '2023-09-25 21:15:11', 1, '2023-09-25 21:15:11', 1, 1),
(20, 'Brahmin Gaon', 1, '2023-09-25 21:17:20', 1, '2023-09-25 21:17:20', 1, 1),
(21, 'Tankua', 1, '2023-09-25 21:20:01', 1, '2023-09-25 21:20:01', 1, 1),
(22, 'PR Peta Area', 1, '2023-09-25 21:24:23', 1, '2023-09-25 21:24:23', 1, 1),
(23, 'Bell Road', 1, '2023-09-25 21:24:55', 1, '2023-09-25 21:25:42', 1, 1),
(24, 'MG Road', 1, '2023-09-25 21:25:49', 1, '2023-09-25 21:25:49', 1, 1),
(25, 'Kumbhar Sahi', 1, '2023-09-25 21:27:02', 1, '2023-09-25 21:27:02', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_city_master`
--

CREATE TABLE `admin_city_master` (
  `id` int(11) NOT NULL,
  `city_name` varchar(50) DEFAULT NULL,
  `commission` int(11) DEFAULT NULL,
  `contact_person` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_city_master`
--

INSERT INTO `admin_city_master` (`id`, `city_name`, `commission`, `contact_person`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(1, 'Jeypore', 100, 2, '2023-08-15 13:46:37', 1, '2023-10-30 06:10:38', 1, 1),
(2, 'Nabrangpur', 100, 2, '2023-08-15 16:24:10', 1, '2023-10-30 14:22:01', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_city_to_item_map`
--

CREATE TABLE `admin_city_to_item_map` (
  `id` int(11) NOT NULL,
  `city` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `pricing` varchar(50) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_city_to_item_map`
--

INSERT INTO `admin_city_to_item_map` (`id`, `city`, `item`, `unit`, `pricing`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(1, 1, 1, 'Kg', '(9-11) Rs', '2023-08-15 16:24:47', 1, '2023-10-30 14:20:12', 1, 1),
(2, 1, 4, 'Kg', '(80-95) Rs', '2023-09-25 11:37:17', 1, '2023-10-30 05:27:33', 1, 1),
(3, 1, 5, 'Kg', '40-45 RS', '2023-09-25 11:39:54', 1, '2023-10-27 16:45:01', 1, 1),
(4, 1, 10, 'Kg', '(5-7) Rs', '2023-09-25 11:40:28', 1, '2023-10-27 16:45:54', 1, 1),
(5, 1, 11, 'Kg', '(7-9) Rs', '2023-09-25 11:41:56', 1, '2023-10-30 05:26:48', 1, 1),
(6, 1, 8, 'Kg', '(3-5) Rs', '2023-09-25 11:42:49', 1, '2023-09-25 11:42:49', 1, 1),
(7, 1, 2, 'Kg', '(27-30) Rs', '2023-09-25 11:44:33', 1, '2023-10-30 05:26:30', 1, 1),
(8, 1, 7, 'Kg', '(5-7) Rs', '2023-09-25 11:47:33', 1, '2023-09-25 11:47:33', 1, 1),
(9, 1, 9, 'Kg', '5 Rs', '2023-09-25 11:48:16', 1, '2023-09-25 11:48:16', 1, 1),
(10, 1, 6, 'Kg', '(40-45) Rs', '2023-09-25 11:49:01', 1, '2023-10-27 16:54:52', 1, 1),
(11, 1, 3, 'Kg', '(15-18) Rs', '2023-09-25 11:49:35', 1, '2023-09-25 11:49:35', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_item_master`
--

CREATE TABLE `admin_item_master` (
  `id` int(11) NOT NULL,
  `item_name` varchar(50) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_item_master`
--

INSERT INTO `admin_item_master` (`id`, `item_name`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(1, 'Paper', '2023-08-15 16:24:25', 1, '2023-08-15 16:24:25', 1, 1),
(2, 'Iron', '2023-09-25 11:26:41', 1, '2023-09-25 11:26:41', 1, 1),
(3, 'Teen', '2023-09-25 11:27:04', 1, '2023-09-25 11:27:04', 1, 1),
(4, 'Aluminium', '2023-09-25 11:27:36', 1, '2023-09-25 11:27:36', 1, 1),
(5, 'Can items', '2023-09-25 11:29:36', 1, '2023-09-25 11:29:36', 1, 1),
(6, 'Steel', '2023-09-25 11:30:23', 1, '2023-09-25 11:30:23', 1, 1),
(7, 'Plastic items', '2023-09-25 11:31:07', 1, '2023-09-25 11:31:07', 1, 1),
(8, 'Fiber items', '2023-09-25 11:32:17', 1, '2023-09-25 11:32:17', 1, 1),
(9, 'Polythene items', '2023-09-25 11:32:54', 1, '2023-09-25 11:32:54', 1, 1),
(10, 'Cardboard', '2023-09-25 11:33:47', 1, '2023-09-25 11:33:47', 1, 1),
(11, 'Cartoons', '2023-09-25 11:34:31', 1, '2023-09-25 11:34:31', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_pec_map`
--

CREATE TABLE `admin_pec_map` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_pec_map`
--

INSERT INTO `admin_pec_map` (`id`, `user`, `city`, `created_on`, `created_by`, `updated_on`, `updated_by`) VALUES
(1, 4, 1, '2023-11-01 09:25:35', 1, '2023-11-01 09:25:35', 1),
(2, 5, 1, '2023-11-01 21:03:13', 1, '2023-11-01 21:03:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_booking_take_off`
--

CREATE TABLE `user_booking_take_off` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `detailed_address` varchar(500) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `take_off_date` date DEFAULT NULL,
  `scrap_price` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_booking_take_off`
--

INSERT INTO `user_booking_take_off` (`id`, `name`, `code`, `city`, `area`, `contact_no`, `detailed_address`, `booking_date`, `take_off_date`, `scrap_price`, `created_on`, `updated_on`, `updated_by`, `status`) VALUES
(1, 'Bhagirathi nayak', '1291023112055', 1, 1, '9178071067', 'Odisha,koraput, jepore, bariniput,B.maliguda, new colony,Lakshmi vikas global school ', '2023-10-29', '2023-10-30', 40, '2023-10-29 05:50:55', '2023-10-30 06:09:20', 1, 1),
(2, 'Ramakant sahu', '1291023115750', 1, 1, '7978331147', 'Jeypore koraput road ,new colony bariniput,764006', '2023-10-29', '2023-10-30', 192, '2023-10-29 06:27:50', '2023-10-30 06:09:07', 1, 1),
(3, 'Nila Madhaba Dash', '1011123210941', 1, 1, '9438480728', 'New colony', '2023-11-01', '2023-11-01', 6, '2023-11-01 15:39:41', '2023-11-01 21:15:17', 1, 1),
(4, 'Megha', '1061123055044', 1, 1, '1111111111', 'Bariniput chaka dukan.', '2023-11-06', '2023-11-06', 25, '2023-11-06 00:20:44', '2023-11-06 05:56:24', 1, 1),
(5, 'Tarini Panda', '1061123055157', 1, 1, '1111111111', 'Bariniput chaka dukan', '2023-11-06', '2023-11-06', 1170, '2023-11-06 00:21:57', '2023-11-06 05:56:05', 1, 1),
(6, 'Manju Lata Sahu ', '1061123055322', 1, 1, '1111111111', 'Bariniput chaka dukan', '2023-11-06', '2023-11-06', 40, '2023-11-06 00:23:22', '2023-11-06 05:55:05', 1, 1),
(7, 'Spn hot and cold bar ', '1061123095825', 1, 1, '7978375998', 'b.maliguda bullet showroom\nCoffee shop ', '2023-11-06', '2023-11-07', 235, '2023-11-06 04:28:25', '2023-11-06 21:36:20', 5, 1),
(8, 'Ranjan Sahu', '1081123124249', 1, 1, '1111111111', 'Chaka tiffin hotel', '2023-11-08', '2023-11-08', 45, '2023-11-08 07:12:49', '2023-11-08 12:44:20', 1, 1),
(9, 'Dadu Hotel', '1081123124309', 1, 1, '1111111111', 'Chaka tiffin hotel', '2023-11-08', '2023-11-08', 410, '2023-11-08 07:13:09', '2023-11-08 12:44:10', 1, 1),
(10, 'Susanta Nanda', '1091123101710', 1, 1, '1111111111', 'New colony farm area.', '2023-11-09', '2023-11-11', 265, '2023-11-09 04:47:10', '2023-11-11 07:55:03', 1, 1),
(11, 'Rabindra Swain', '1111123075134', 1, 1, '7735490052', 'New colony Bariniput near petrol pump', '2023-11-11', '2023-11-11', 50, '2023-11-11 02:21:34', '2023-11-11 07:54:14', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_item_details`
--

CREATE TABLE `user_item_details` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(20) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `price_given` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_item_details`
--

INSERT INTO `user_item_details` (`id`, `booking_id`, `item`, `quantity`, `price_given`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(1, '1291023115750', 11, 21.7, 192, '2023-11-01 09:37:24', 4, '2023-11-01 10:35:22', 4, 0),
(2, '1291023115750', 11, 21.7, 192, '2023-11-01 10:35:54', 4, '2023-11-01 10:35:54', 4, 1),
(3, '1291023112055', 11, 4.5, 40, '2023-11-01 10:36:10', 4, '2023-11-01 10:36:10', 4, 1),
(4, '1011123210941', 7, 1.1, 6, '2023-11-01 21:14:59', 4, '2023-11-01 21:15:06', 4, 1),
(5, '1061123055044', 11, 3.2, 25, '2023-11-06 06:21:50', 4, '2023-11-06 06:21:50', 4, 1),
(6, '1061123055157', 11, 130, 1170, '2023-11-06 06:22:33', 4, '2023-11-06 06:22:33', 4, 1),
(7, '1061123055322', 11, 4.2, 40, '2023-11-06 06:22:57', 4, '2023-11-06 06:22:57', 4, 1),
(8, '1061123095825', 5, 2, 80, '2023-11-07 12:34:59', 4, '2023-11-07 12:34:59', 4, 1),
(9, '1061123095825', 3, 3.6, 55, '2023-11-07 12:36:14', 4, '2023-11-07 12:36:14', 4, 1),
(10, '1061123095825', 11, 11, 90, '2023-11-07 12:36:54', 4, '2023-11-07 13:24:49', 4, 1),
(11, '1061123095825', 7, 2, 10, '2023-11-07 12:37:18', 4, '2023-11-07 12:37:18', 4, 1),
(12, '1081123124309', 11, 45.5, 410, '2023-11-08 12:46:13', 4, '2023-11-08 12:46:13', 4, 1),
(13, '1081123124249', 11, 5, 45, '2023-11-08 12:46:44', 4, '2023-11-08 12:46:44', 4, 1),
(14, '1091123101710', 10, 2, 15, '2023-11-11 07:37:51', 4, '2023-11-11 07:56:22', 4, 1),
(15, '1091123101710', 1, 17.8, 250, '2023-11-11 07:38:42', 4, '2023-11-11 07:38:42', 4, 1),
(16, '1111123075134', 11, 6, 50, '2023-11-11 07:57:17', 4, '2023-11-11 07:57:17', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_item_export_details`
--

CREATE TABLE `user_item_export_details` (
  `id` int(11) NOT NULL,
  `city` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `quantity_collect` float DEFAULT NULL,
  `price_given` int(11) DEFAULT NULL,
  `quantity_export` float DEFAULT NULL,
  `price_sold` int(11) DEFAULT NULL,
  `export_date` date DEFAULT NULL,
  `take_off_date_from` date DEFAULT NULL,
  `take_off_date_to` date DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `mail_address` varchar(200) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'USER',
  `otp` varchar(10) NOT NULL,
  `enc_password` varchar(1000) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`id`, `name`, `mail_address`, `contact_no`, `user_type`, `otp`, `enc_password`, `created`, `updated`, `status`) VALUES
(1, 'Subhendu Swain', 'swain1467@gmail.com', '7846993676', 'ADMIN', 'K8A1DF', '$2y$10$7lVvKf.XWbYFBkg15m2h7OgHnNzYkfehk7WfueKt8ijFAeLKF6sp6', '2023-08-15 13:40:53', '2023-08-15 13:42:29', 1),
(2, 'Gyanesh Kumar maharana', 'gyaneshmaharana@gmail.com', '8917490734', 'ADMIN', 'JZ8CV5', '$2y$10$iD7V8wGwEx2HVnEaP0/zcuVO96NRo2zbVX22FS4xGpVbWajUGPK5i', '2023-08-15 16:14:19', '2023-10-16 19:54:14', 1),
(3, 'Tarini Shankar Bishoyee ', 'dipunbishoyee8055@gmail.com', '8658098227', 'ADMIN', 'SLXW1H', '$2y$10$BtPF6dYBxQiljgRVeQkJbOXrsLJjvhoR5tYS8Br93nqhgOHqzMPRu', '2023-08-15 16:14:20', '2023-08-15 16:23:31', 1),
(4, 'Demo Emp', 'renthelpline247@gmail.com', '7846993676', 'EMPLOYEE', 'UAR18V', '$2y$10$aRFUk4hmnHGa9U5LIHHSBejzH1W4U4S0aBGGqYmMH2ynWJPvSLEKu', '2023-11-01 09:19:29', '2023-11-14 19:02:57', 1),
(5, 'Demo Manager', 'msm8055786@gmail.com', '7846993676', 'MANAGER', '314HUQ', '$2y$10$26R0Zr0RGQbj11dfBz5Gvu5atWoGse9v8V0dLMUVoQ8s5886/hwhy', '2023-11-01 09:23:32', '2023-11-14 18:58:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_area_master`
--
ALTER TABLE `admin_area_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city` (`city`);

--
-- Indexes for table `admin_city_master`
--
ALTER TABLE `admin_city_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_person` (`contact_person`);

--
-- Indexes for table `admin_city_to_item_map`
--
ALTER TABLE `admin_city_to_item_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city` (`city`),
  ADD KEY `item` (`item`);

--
-- Indexes for table `admin_item_master`
--
ALTER TABLE `admin_item_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_pec_map`
--
ALTER TABLE `admin_pec_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `city` (`city`);

--
-- Indexes for table `user_booking_take_off`
--
ALTER TABLE `user_booking_take_off`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city` (`city`),
  ADD KEY `area` (`area`);

--
-- Indexes for table `user_item_details`
--
ALTER TABLE `user_item_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item` (`item`);

--
-- Indexes for table `user_item_export_details`
--
ALTER TABLE `user_item_export_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city` (`city`),
  ADD KEY `item` (`item`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_area_master`
--
ALTER TABLE `admin_area_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `admin_city_master`
--
ALTER TABLE `admin_city_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_city_to_item_map`
--
ALTER TABLE `admin_city_to_item_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin_item_master`
--
ALTER TABLE `admin_item_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin_pec_map`
--
ALTER TABLE `admin_pec_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_booking_take_off`
--
ALTER TABLE `user_booking_take_off`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_item_details`
--
ALTER TABLE `user_item_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_item_export_details`
--
ALTER TABLE `user_item_export_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_area_master`
--
ALTER TABLE `admin_area_master`
  ADD CONSTRAINT `admin_area_master_ibfk_1` FOREIGN KEY (`city`) REFERENCES `admin_city_master` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `admin_city_master`
--
ALTER TABLE `admin_city_master`
  ADD CONSTRAINT `admin_city_master_ibfk_1` FOREIGN KEY (`contact_person`) REFERENCES `user_master` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `admin_city_to_item_map`
--
ALTER TABLE `admin_city_to_item_map`
  ADD CONSTRAINT `admin_city_to_item_map_ibfk_1` FOREIGN KEY (`city`) REFERENCES `admin_city_master` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_city_to_item_map_ibfk_2` FOREIGN KEY (`item`) REFERENCES `admin_item_master` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `admin_pec_map`
--
ALTER TABLE `admin_pec_map`
  ADD CONSTRAINT `admin_pec_map_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user_master` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_pec_map_ibfk_2` FOREIGN KEY (`city`) REFERENCES `admin_city_master` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_booking_take_off`
--
ALTER TABLE `user_booking_take_off`
  ADD CONSTRAINT `user_booking_take_off_ibfk_1` FOREIGN KEY (`city`) REFERENCES `admin_city_master` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_take_off_ibfk_2` FOREIGN KEY (`area`) REFERENCES `admin_area_master` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_item_details`
--
ALTER TABLE `user_item_details`
  ADD CONSTRAINT `user_item_details_ibfk_1` FOREIGN KEY (`item`) REFERENCES `admin_city_to_item_map` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_item_export_details`
--
ALTER TABLE `user_item_export_details`
  ADD CONSTRAINT `user_item_export_details_ibfk_1` FOREIGN KEY (`city`) REFERENCES `admin_city_master` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_item_export_details_ibfk_2` FOREIGN KEY (`item`) REFERENCES `admin_city_to_item_map` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
