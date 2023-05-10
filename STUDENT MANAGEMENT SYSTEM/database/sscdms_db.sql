-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2023 at 07:51 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `sscdms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_list`
--

CREATE TABLE `assign_list` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `desk_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assign_list`
--

INSERT INTO `assign_list` (`id`, `student_id`, `desk_id`, `remarks`, `status`, `created_at`) VALUES
(2, 3, 1, 'Sample Assign', 1, '2023-03-14 14:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `desk_list`
--

CREATE TABLE `desk_list` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `desk_list`
--

INSERT INTO `desk_list` (`id`, `code`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'A101', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pellentesque, diam sit amet facilisis iaculis, lorem est hendrerit velit, a semper augue felis tristique urna.', 1, '2023-03-14 10:56:01', NULL),
(2, 'A102', 'Nulla hendrerit erat eget placerat laoreet. Vivamus porta augue non bibendum pulvinar. Duis pellentesque orci eu bibendum pellentesque.', 1, '2023-03-14 10:57:34', NULL),
(3, 'A103', 'Aenean quis congue orci. Pellentesque quis felis purus. Etiam mi ipsum, consequat cursus scelerisque quis, tincidunt volutpat magna.', 1, '2023-03-14 10:59:18', NULL),
(4, 'B101', 'Suspendisse non lorem non ligula tincidunt aliquam.', 1, '2023-03-14 10:59:34', NULL),
(5, 'B102', 'Integer sollicitudin massa ut metus porta, vel posuere nunc fermentum. Curabitur quis sapien a nisl placerat pellentesque at sed mi.', 1, '2023-03-14 10:59:55', NULL),
(6, 'B103', 'Proin tempus, nisl et consequat convallis, nulla erat facilisis ante, eu sollicitudin nulla eros nec quam.', 1, '2023-03-14 11:00:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `id` int(11) NOT NULL,
  `regno` varchar(50) NOT NULL,
  `name` text NOT NULL,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`id`, `regno`, `name`, `contact`, `email`, `address`, `status`, `created_at`, `updated_at`) VALUES
(2, '2023031400001', 'Mark Cooper', '09123456789', 'mcooper@mail.com', 'Sample Address only', 1, '2023-03-14 10:41:52', '2023-03-14 10:43:55'),
(3, '2023031400002', 'Claire Blake', '0912345987', 'cblake@mail.com', 'Sample Address 101', 1, '2023-03-14 10:47:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Student Study Center Desk Management System'),
(6, 'short_name', 'SMS - SSCDMS'),
(11, 'logo', 'uploads/logo.png?v=1678759793'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1678759983'),
(17, 'phone', '456-987-1231'),
(18, 'mobile', '09123456987 / 094563212222 '),
(19, 'email', 'info@xyzsanitizationservices.com'),
(20, 'address', '7087 Henry St. Clifton Park, NY 12065');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='2';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', '', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1678760026', NULL, 1, '2021-01-20 14:02:37', '2023-03-14 10:13:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_list`
--
ALTER TABLE `assign_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `desk_list`
--
ALTER TABLE `desk_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_list`
--
ALTER TABLE `assign_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `desk_list`
--
ALTER TABLE `desk_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;
