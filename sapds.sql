-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2025 at 10:52 AM
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
-- Database: `sapds`
--

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `ic_number` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `class` varchar(50) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `role` enum('school-administrator','guardian') NOT NULL,
  `admin_role` enum('clerk','teacher','school-operator','others') DEFAULT NULL,
  `child_name` varchar(255) DEFAULT NULL,
  `relationship` enum('parent','guardian') DEFAULT NULL,
  `car_plate` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `phone`, `address`, `role`, `admin_role`, `child_name`, `relationship`, `car_plate`, `created_at`) VALUES
(1, 'z', 'zerlyn0816@gmail.com', 'z', '$2y$10$mvzGQrYWsTB9NyYykwHXGuBLWgrEpX/SR8uhM9h7FxElobAd2/X4C', '+60-12-618-9662', 'drg', 'school-administrator', 'clerk', NULL, 'parent', NULL, '2024-12-29 16:32:30'),
(7, 'ze', 'kaiyingzerlyn@gmail.com', 'ze', '$2y$10$kiFPiyXN5SpEAkpmchxdDOk7AShD5FCUKwWyzlId0xHsp8.rjCrN6', '012791', 'drg', 'school-administrator', 'clerk', NULL, 'parent', NULL, '2024-12-29 16:47:13'),
(9, 'gr', 'gr@gmail.com', 'gr', '$2y$10$qvdlDsCSx3c3/0Tb0V1/iOT9m3tO9n67qSnM4jlPEh2ewSognPzba', '097', 'drg', 'guardian', NULL, 'abu', 'parent', 'frc5567', '2024-12-29 17:12:35'),
(10, 'teacher', 'teacher@gmail.com', 'teacher', '$2y$10$WppmsegnZgLHn1swHnuun.dgnSO.euD5Vqp0G5hAJA..ZqrI5oRfq', '0-98', 'oi', 'school-administrator', 'teacher', NULL, 'parent', NULL, '2025-01-06 17:14:30'),
(11, 'ba', 'g@gmail.com', 'ba', '$2y$10$HQtl.tRSTknZQ0YKacTaR.hvgafwEfIvABEMJf7Vk/za4kBVmuvH2', '0-98', 'd', 'school-administrator', '', NULL, 'parent', NULL, '2025-01-21 09:16:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`ic_number`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
