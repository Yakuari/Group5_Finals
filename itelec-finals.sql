-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 02:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itelec-finals`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `booking_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `phone`, `email`, `booking_date`, `created_at`) VALUES
(11, 'jayson dominguez', '09288715990', 'dominguezstephen01@gmail.com', '2024-10-01', '2024-12-11 07:50:05'),
(13, 'Yuri', '09559228273', 'diamondarrow360@gmail.com', '2025-01-06', '2024-12-11 16:12:45'),
(15, 'ewew', '911', 'yakuari@gmail.com', '2024-12-11', '2024-12-20 13:39:32'),
(16, 'Yuri4', '09559228273', 'davidyurit31@gmail.com', '2025-01-01', '2024-12-22 18:38:25'),
(17, 'Yuri4', '09559228273', 'davidyurit31@gmail.com', '2024-12-27', '2024-12-22 18:45:58'),
(18, 'Yuri4', '09559228273', 'davidyurit31@gmail.com', '2024-12-31', '2024-12-22 18:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `is_redeemed` tinyint(1) DEFAULT 0,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `is_redeemed`, `user_id`) VALUES
(1, 'WELCOME2A445', 1, 42),
(7, 'WELCOME9D26C', 1, 44),
(11, 'WELCOMEFAA37', 1, 47),
(12, 'WELCOME99768', 0, 47);

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE `email_config` (
  `id` int(145) NOT NULL,
  `email` varchar(145) DEFAULT NULL,
  `password` varchar(145) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_config`
--

INSERT INTO `email_config` (`id`, `email`, `password`, `create_at`, `update_at`) VALUES
(1, 'dominguezstephen01@gmail.com', 'dbjt hnsz vpzo zvei', '2024-11-24 03:06:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_uid` varchar(50) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_role` enum('manager','user','admin') NOT NULL,
  `user_amount` int(11) NOT NULL,
  `user_month` enum('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expire_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `coupon` varchar(255) DEFAULT NULL,
  `coupon_active` tinyint(1) DEFAULT 0,
  `subscription` enum('Bronze','Silver','Gold') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_uid`, `user_pass`, `user_email`, `user_role`, `user_amount`, `user_month`, `created_at`, `expire_at`, `status`, `coupon`, `coupon_active`, `subscription`) VALUES
(4, 'jayson', '$2y$10$gy1Z5vqRaU49hY01191WUOSXJtrEKqvc1LKvv5trAeEAq55luUyaW', 'dominguezstephen01@gmail.com', 'admin', 16000, '12', '2024-12-04 10:07:47', '2025-11-29 03:12:34', NULL, NULL, 0, NULL),
(30, 'stephen', '$2y$10$pMJ9QmNFAoK2Ks8fRK51jutBzAGWl2v1UGpLijOfr.hOVd6sxEpwu', 'dominguezstephen6@gmail.com', 'manager', 1500, '1', '2024-12-09 05:57:12', '2025-01-10 07:15:39', 'accepted', NULL, 0, NULL),
(34, 'bagnit', '$2y$10$Xjw9aAz/qWqLWuSkJB6HxOocszPvBL5IzHMtihVFyZrK7IJYrpIZS', 'wrenchnerbangit@gmail.com', 'user', 1500, '1', '2024-12-11 13:24:37', NULL, 'rejected', NULL, 0, NULL),
(35, 'yurit', '$2y$10$WpZq7ilzXE9b0Q55G0z.5eqhHrZy9UvLYLec.w2gC5ltJOWNAidKS', 'diamondarrow360@gmail.com', 'admin', 1500, '1', '2024-12-11 14:15:28', NULL, 'rejected', NULL, 0, NULL),
(36, 'yuri', '$2y$10$vegsiRkLM.U6h8bpHNvB/uw7AcifH0lh.EXcx4SFybWoEY6FuWfl6', 'yuritdavid31@gmail.com', 'manager', 6000, '4', '2024-12-11 14:18:24', '2025-04-13 05:25:59', 'accepted', NULL, 0, NULL),
(42, 'Kihei', '$2y$10$KXDaDr.w5y88s6w0E7OWVuTekPPBvyA2t.szQSp5VQqHuAILOFHUy', 'batmanrobinjoker123456@gmail.com', 'user', 4000, '3', '2024-12-22 23:04:04', '2025-03-22 16:04:45', 'accepted', 'WELCOME2A445', 1, NULL),
(44, 'Mitsubishi', '$2y$10$Mj9Tramhagl2oZaoj.Y1Iu.3zoOH.SxRZPORS7ya2EB/U9c2aoWQG', 'davidyurit31@gmail.com', 'user', 1500, '1', '2024-12-23 00:41:54', '2025-01-21 17:42:08', 'accepted', 'WELCOME9D26C', 1, NULL),
(47, 'Rivers', '$2y$10$IhkqjmlzBJECwU12WM50KOnmuiV3dzB/Kv16YHha.CFqLtiQXK2ge', 'kmashido@gmail.com', 'user', 3000, '2', '2024-12-23 01:08:42', '2025-02-20 18:08:55', 'accepted', 'WELCOMEFAA37', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `log_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `action` tinyint(1) NOT NULL,
  `performed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`log_id`, `user_id`, `action`, `performed_at`) VALUES
(1, 4, 1, '2024-12-04 10:12:34'),
(96, 34, 0, '2024-12-11 13:24:48'),
(97, 30, 0, '2024-12-11 14:15:39'),
(98, 35, 0, '2024-12-11 14:15:47'),
(99, 36, 0, '2024-12-14 12:25:59'),
(105, 42, 0, '2024-12-22 23:04:45'),
(107, 44, 0, '2024-12-23 00:42:08'),
(110, 47, 0, '2024-12-23 01:08:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `log_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
