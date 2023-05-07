-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2023 at 04:12 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blood_group`
--

CREATE TABLE `tbl_blood_group` (
  `id` int(11) NOT NULL,
  `blood_group` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_blood_group`
--

INSERT INTO `tbl_blood_group` (`id`, `blood_group`, `status`, `created_at`, `updated_at`) VALUES
(1, 'A+', 1, '2023-05-07 19:42:04', '2023-05-07 19:42:04'),
(2, 'A-', 1, '2023-05-07 19:42:04', '2023-05-07 19:42:04'),
(3, 'B+', 1, '2023-05-07 19:42:04', '2023-05-07 19:42:04'),
(4, 'B-', 1, '2023-05-07 19:42:04', '2023-05-07 19:42:04'),
(5, 'O+', 1, '2023-05-07 19:42:04', '2023-05-07 19:42:04'),
(6, 'O-', 1, '2023-05-07 19:42:04', '2023-05-07 19:42:04'),
(7, 'AB+', 1, '2023-05-07 19:42:04', '2023-05-07 19:42:04'),
(8, 'AB-', 1, '2023-05-07 19:42:04', '2023-05-07 19:42:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_blood_group`
--
ALTER TABLE `tbl_blood_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_blood_group`
--
ALTER TABLE `tbl_blood_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
