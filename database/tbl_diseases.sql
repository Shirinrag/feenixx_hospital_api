-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2023 at 07:06 PM
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
-- Table structure for table `tbl_diseases`
--

CREATE TABLE `tbl_diseases` (
  `id` bigint(20) NOT NULL,
  `diseases_name` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_diseases`
--

INSERT INTO `tbl_diseases` (`id`, `diseases_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Acute Flaccid Myelitis (AFM)', 1, '2023-05-07 22:17:37', '2023-05-07 22:17:37'),
(2, 'Adenovirus', 1, '2023-05-07 22:17:37', '2023-05-07 22:17:37'),
(3, 'AIDS (Acquired Immune Deficiency Syndrome)', 1, '2023-05-07 22:17:37', '2023-05-07 22:17:37'),
(4, 'Anthrax', 1, '2023-05-07 22:17:37', '2023-05-07 22:17:37'),
(5, 'Arboviral Infections', 1, '2023-05-07 22:19:31', '2023-05-07 22:19:31'),
(6, 'Botulism', 1, '2023-05-07 22:19:31', '2023-05-07 22:19:31'),
(7, 'Blue-Green Algae', 1, '2023-05-07 22:19:31', '2023-05-07 22:19:31'),
(8, 'Brucellosis', 1, '2023-05-07 22:19:31', '2023-05-07 22:19:31'),
(9, 'Campylobacteriosis', 1, '2023-05-07 22:19:31', '2023-05-07 22:19:31'),
(10, 'Cat Scratch Disease', 1, '2023-05-07 22:19:31', '2023-05-07 22:19:31'),
(11, 'Chagas Disease (American trypanosomiasis)', 1, '2023-05-07 22:19:31', '2023-05-07 22:19:31'),
(12, 'Chickenpox (Varicella and Shingles)', 1, '2023-05-07 22:19:31', '2023-05-07 22:19:31'),
(13, 'Chikungunya', 1, '2023-05-07 22:19:31', '2023-05-07 22:19:31'),
(14, 'Chlamydia', 1, '2023-05-07 22:19:31', '2023-05-07 22:19:31'),
(15, 'Cholera', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(16, 'Congenital Rubella Syndrome', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(17, 'Coronavirus Disease 2019 (COVID-19)', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(18, 'Creutzfeldt-Jakob Disease', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(19, 'Cryptosporidiosis', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(20, 'Cyclosporiasis', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(21, 'Cytomegalovirus', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(22, 'Dengue Fever', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(23, 'Diphtheria', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(24, 'E. coli', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(25, 'Ebola Virus Disease', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(26, 'Ehrlichiosis', 1, '2023-05-07 22:23:28', '2023-05-07 22:23:28'),
(27, 'Enteroviruses', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(28, 'Fifth Disease', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(29, 'Giardiasis', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(30, 'Gonorrhea', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(31, 'Haemophilus Influenzae Invasive Disease (Sterile Site)', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(32, 'Hand, Foot, and Mouth Disease', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(33, 'Hand Hygiene', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(34, 'Hansen\'s Disease', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(35, 'Hantavirus', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(36, 'Head Lice', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(37, 'Heartland Virus', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(38, 'Hemolytic Uremic Syndrome', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(39, 'Hepatitis A', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(40, 'HIV infection (Human Immunodeficeincy virus)', 1, '2023-05-07 22:26:28', '2023-05-07 22:26:28'),
(41, 'Influenza', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(42, 'Legionellosis', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(43, 'Leprosy (Hansen\'s Disease)', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(44, 'Leptospirosis', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(45, 'Lice', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(46, 'Listeriosis', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(47, 'Lyme Disease', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(48, 'Malaria', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(49, 'Measles (Rubeola)', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(50, 'Meningitis', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(51, 'Meningococcal Disease', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(52, 'Molluscum Contagiosum', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(53, 'Monkeypox', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(54, 'Mononucleosis', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(55, 'Mumps', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(56, 'Norovirus', 1, '2023-05-07 22:29:09', '2023-05-07 22:29:09'),
(57, 'Pertussis', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(58, 'Plague', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(59, 'Polio (polio myelitis)', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(60, 'Primary Amebic Meningoencephalitis (PAM)', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(61, 'Psittacosis', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(62, 'Q Fever', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(63, 'Rabies', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(64, 'Respiratory Syncytial Virus (RSV)', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(65, 'Reye Syndrome', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(66, 'Ringworm', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(67, 'Rocky Mountain Spotted Fever', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(68, 'Rotavirus', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(69, 'Rubella (German Measles)', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(70, 'Salmonellosis', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(71, 'Scabies', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(72, 'Shiga toxin-producing E. coli (STEC)', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(73, 'Shigellosis', 1, '2023-05-07 22:31:55', '2023-05-07 22:31:55'),
(74, 'Shingles', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(75, 'Smallpox', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(76, 'Southern Tick-Associated Rash Illness (STARI)', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(77, 'Streptococcus, group A, invasive disease', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(78, 'Streptococcus pneumoniae, invasive disease', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(79, 'Syphilis', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(80, 'Tetanus', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(81, 'Toxoplasmosis', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(82, 'Trichinellosis', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(83, 'Tuberculosis', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(84, 'Tularemia', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(85, 'Typhoid Fever', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(86, 'Varicella (Chickenpox and Shingles)', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(87, 'Vibrio species', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(88, 'Vibrio cholera', 1, '2023-05-07 22:34:24', '2023-05-07 22:34:24'),
(89, 'Vibrio vulnificus', 1, '2023-05-07 22:35:27', '2023-05-07 22:35:27'),
(90, 'Vibrio parahaemolyticus', 1, '2023-05-07 22:35:27', '2023-05-07 22:35:27'),
(91, 'West Nile Virus', 1, '2023-05-07 22:35:27', '2023-05-07 22:35:27'),
(92, 'Yellow Fever', 1, '2023-05-07 22:35:27', '2023-05-07 22:35:27'),
(93, 'Zika Virus', 1, '2023-05-07 22:35:27', '2023-05-07 22:35:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_diseases`
--
ALTER TABLE `tbl_diseases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_diseases`
--
ALTER TABLE `tbl_diseases`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
