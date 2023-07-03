-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2023 at 04:02 AM
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
-- Table structure for table `tbl_charges`
--

CREATE TABLE `tbl_charges` (
  `id` int(11) NOT NULL,
  `fk_appointment_id` int(11) DEFAULT NULL,
  `fk_patient_id` int(11) DEFAULT NULL,
  `fk_charges_type_id` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `no_of_count` int(11) DEFAULT NULL,
  `total_amount` double NOT NULL,
  `dr_name` varchar(150) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_charges`
--
ALTER TABLE `tbl_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_appointment_id` (`fk_appointment_id`),
  ADD KEY `id` (`id`,`fk_patient_id`,`fk_charges_type_id`,`amount`,`no_of_count`,`total_amount`,`date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_charges`
--
ALTER TABLE `tbl_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
