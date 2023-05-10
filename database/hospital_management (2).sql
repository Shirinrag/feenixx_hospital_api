-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2023 at 03:11 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

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
-- Table structure for table `tbl_appointment`
--

CREATE TABLE `tbl_appointment` (
  `id` bigint(20) NOT NULL,
  `fk_doctor_id` int(11) DEFAULT NULL,
  `fk_patient_id` int(11) DEFAULT NULL,
  `fk_diseases_id` int(11) DEFAULT NULL,
  `appointment_date` varchar(100) DEFAULT NULL,
  `appointment_time` varchar(100) DEFAULT NULL,
  `prescription` longtext DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_appointment`
--

INSERT INTO `tbl_appointment` (`id`, `fk_doctor_id`, `fk_patient_id`, `fk_diseases_id`, `appointment_date`, `appointment_time`, `prescription`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 62, '09-05-2023', '18:30', 'uploads/pescription/LCT24609079/658964_images.png', 'Test Description', '2023-05-09 11:07:04', '2023-05-09 11:07:04'),
(2, 1, 1, 85, '09-05-2023', '12:07', 'uploads/pescription/LCT24609079/746987_H7bede4ac0f624719bbsss78c6e4f7fb3763Q-copy.jpg', 'test', '2023-05-09 12:32:24', '2023-05-09 17:46:10'),
(3, 1, 2, 32, '09-05-2023', '19:50', 'uploads/pescription/WZGL4297935/442064_download.jpg', 'Test description', '2023-05-09 17:44:30', '2023-05-09 17:46:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment_type`
--

CREATE TABLE `tbl_appointment_type` (
  `id` bigint(20) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cities`
--

CREATE TABLE `tbl_cities` (
  `id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_cities`
--

INSERT INTO `tbl_cities` (`id`, `city`, `state_id`) VALUES
(4, 'Adilabad', 1),
(515, 'Agra', 23),
(125, 'Ahmedabad', 5),
(313, 'Ahmednagar', 12),
(364, 'Aizawl', 15),
(431, 'Ajmer', 19),
(314, 'Akola', 12),
(249, 'Alappuzha', 10),
(517, 'Aligarh', 23),
(263, 'Alirajpur', 11),
(516, 'Allahabad', 23),
(502, 'Almora', 33),
(432, 'Alwar', 19),
(150, 'Ambala', 6),
(518, 'Ambedkar Nagar', 23),
(315, 'Amrawati', 12),
(126, 'Amreli District', 5),
(414, 'Amritsar', 18),
(127, 'Anand', 5),
(5, 'Anantapur', 1),
(183, 'Anantnag', 8),
(380, 'Angul', 17),
(27, 'Anjaw', 3),
(264, 'Anuppur', 11),
(59, 'Araria', 4),
(468, 'Ariyalur', 21),
(265, 'Ashok Nagar', 11),
(519, 'Auraiya', 23),
(60, 'Aurangabad', 4),
(316, 'Aurangabad', 12),
(520, 'Azamgarh', 23),
(522, 'Badaun', 23),
(184, 'Badgam', 8),
(222, 'Bagalkot', 9),
(503, 'Bageshwar', 33),
(523, 'Bagpat', 23),
(524, 'Bahraich', 23),
(266, 'Balaghat', 11),
(385, 'Baleswar', 17),
(526, 'Ballia', 23),
(528, 'Balrampur', 23),
(128, 'Banaskantha', 5),
(527, 'Banda', 23),
(185, 'Bandipore', 8),
(224, 'Bangalore Rural District', 9),
(225, 'Bangalore Urban District', 9),
(61, 'Banka', 4),
(587, 'Bankura', 24),
(435, 'Banswara', 19),
(521, 'Barabanki', 23),
(186, 'Baramula', 8),
(437, 'Baran', 19),
(588, 'Bardhaman', 24),
(529, 'Bareilly', 23),
(384, 'Bargarh', 17),
(434, 'Barmer', 19),
(37, 'Barpeta', 2),
(267, 'Barwani', 11),
(96, 'Bastar', 36),
(530, 'Basti', 23),
(415, 'Bathinda', 18),
(318, 'Beed', 12),
(62, 'Begusarai', 4),
(220, 'Belgaum', 9),
(223, 'Bellary', 9),
(268, 'Betul', 11),
(382, 'Bhadrak', 17),
(63, 'Bhagalpur', 4),
(317, 'Bhandara', 12),
(436, 'Bharatpur', 19),
(129, 'Bharuch', 5),
(130, 'Bhavnagar', 5),
(439, 'Bhilwara', 19),
(269, 'Bhind', 11),
(151, 'Bhiwani', 6),
(64, 'Bhojpur', 4),
(270, 'Bhopal', 11),
(219, 'Bidar', 9),
(221, 'Bijapur', 9),
(525, 'Bijnor', 23),
(433, 'Bikaner', 19),
(171, 'Bilaspur', 7),
(97, 'Bilaspur', 36),
(586, 'Birbhum', 24),
(348, 'Bishnupur', 13),
(199, 'Bokaro', 34),
(383, 'Bolangir', 17),
(38, 'Bongaigaon', 2),
(381, 'Boudh', 17),
(531, 'Bulandshahr', 23),
(319, 'Buldhana', 12),
(438, 'Bundi', 19),
(271, 'Burhanpur', 11),
(65, 'Buxar', 4),
(39, 'Cachar', 2),
(114, 'Central Delhi', 25),
(226, 'Chamarajnagar', 9),
(172, 'Chamba', 7),
(504, 'Chamoli', 33),
(505, 'Champawat', 33),
(365, 'Champhai', 15),
(532, 'Chandauli', 23),
(350, 'Chandel', 13),
(320, 'Chandrapur', 12),
(28, 'Changlang', 3),
(200, 'Chatra', 34),
(469, 'Chennai', 21),
(272, 'Chhatarpur', 11),
(273, 'Chhindwara', 11),
(247, 'Chikballapur', 9),
(227, 'Chikmagalur', 9),
(228, 'Chitradurga', 9),
(533, 'Chitrakoot', 23),
(6, 'Chittoor', 1),
(441, 'Chittorgarh', 19),
(349, 'Churachandpur', 13),
(440, 'Churu', 19),
(470, 'Coimbatore', 21),
(594, 'Cooch Behar', 24),
(471, 'Cuddalore', 21),
(386, 'Cuttack', 17),
(131, 'Dahod', 5),
(590, 'Dakshin Dinajpur', 24),
(231, 'Dakshina Kannada', 9),
(113, 'Daman', 29),
(274, 'Damoh', 11),
(98, 'Dantewada', 36),
(66, 'Darbhanga', 4),
(589, 'Darjeeling', 24),
(40, 'Darrang', 2),
(275, 'Datia', 11),
(442, 'Dausa', 19),
(229, 'Davanagere', 9),
(387, 'Debagarh', 17),
(506, 'Dehradun', 33),
(201, 'Deoghar', 34),
(534, 'Deoria', 23),
(276, 'Dewas', 11),
(498, 'Dhalai', 22),
(99, 'Dhamtari', 36),
(202, 'Dhanbad', 34),
(277, 'Dhar', 11),
(472, 'Dharmapuri', 21),
(230, 'Dharwad', 9),
(41, 'Dhemaji', 2),
(388, 'Dhenkanal', 17),
(443, 'Dholpur', 19),
(42, 'Dhubri', 2),
(321, 'Dhule', 12),
(34, 'Dibang Valley', 3),
(43, 'Dibrugarh', 2),
(372, 'Dimapur', 16),
(473, 'Dindigul', 21),
(278, 'Dindori', 11),
(112, 'Diu', 29),
(187, 'Doda', 8),
(203, 'Dumka', 34),
(444, 'Dungapur', 19),
(100, 'Durg', 36),
(115, 'East Delhi', 25),
(357, 'East Garo Hills', 14),
(7, 'East Godavari', 1),
(29, 'East Kameng', 3),
(358, 'East Khasi Hills', 14),
(464, 'East Sikkim', 20),
(250, 'Ernakulam', 10),
(474, 'Erode', 21),
(535, 'Etah', 23),
(537, 'Etawah', 23),
(541, 'Faizabad', 23),
(152, 'Faridabad', 6),
(417, 'Faridkot', 18),
(539, 'Farrukhabad', 23),
(153, 'Fatehabad', 6),
(418, 'Fatehgarh Sahib', 18),
(540, 'Fatehpur', 23),
(538, 'Firozabad', 23),
(416, 'Firozpur', 18),
(232, 'Gadag', 9),
(322, 'Gadchiroli', 12),
(390, 'Gajapati', 17),
(133, 'Gandhinagar', 5),
(445, 'Ganganagar', 19),
(389, 'Ganjam', 17),
(205, 'Garhwa', 34),
(542, 'Gautam Buddha Nagar', 23),
(68, 'Gaya', 4),
(546, 'Ghaziabad', 23),
(544, 'Ghazipur', 23),
(206, 'Giridih', 34),
(44, 'Goalpara', 2),
(207, 'Godda', 34),
(45, 'Golaghat', 2),
(543, 'Gonda', 23),
(323, 'Gondiya', 12),
(69, 'Gopalganj', 4),
(545, 'Gorkakhpur', 23),
(233, 'Gulbarga', 9),
(208, 'Gumla', 34),
(279, 'Guna', 11),
(8, 'Guntur', 1),
(419, 'Gurdaspur', 18),
(154, 'Gurgaon', 6),
(280, 'Gwalior', 11),
(46, 'Hailakandi', 2),
(173, 'Hamirpur', 7),
(547, 'Hamirpur', 23),
(446, 'Hanumangarh', 19),
(281, 'Harda', 11),
(548, 'Hardoi', 23),
(507, 'Haridwar', 33),
(234, 'Hassan', 9),
(235, 'Haveri District', 9),
(209, 'Hazaribagh', 34),
(324, 'Hingoli', 12),
(155, 'Hissar', 6),
(591, 'Hooghly', 24),
(282, 'Hoshangabad', 11),
(420, 'Hoshiarpur', 18),
(592, 'Howrah', 24),
(9, 'Hyderabad', 1),
(251, 'Idukki', 10),
(351, 'Imphal East', 13),
(356, 'Imphal West', 13),
(283, 'Indore', 11),
(284, 'Jabalpur', 11),
(393, 'Jagatsinghpur', 17),
(359, 'Jaintia Hills', 14),
(450, 'Jaipur', 19),
(451, 'Jaisalmer', 19),
(392, 'Jajapur', 17),
(421, 'Jalandhar', 18),
(551, 'Jalaun', 23),
(325, 'Jalgaon', 12),
(326, 'Jalna', 12),
(448, 'Jalore', 19),
(593, 'Jalpaiguri', 24),
(188, 'Jammu', 8),
(134, 'Jamnagar', 5),
(70, 'Jamui', 4),
(102, 'Janjgir-Champa', 36),
(101, 'Jashpur', 36),
(553, 'Jaunpur District', 23),
(71, 'Jehanabad', 4),
(285, 'Jhabua', 11),
(156, 'Jhajjar', 6),
(452, 'Jhalawar', 19),
(550, 'Jhansi', 23),
(391, 'Jharsuguda', 17),
(157, 'Jind', 6),
(449, 'Jodhpur', 19),
(47, 'Jorhat', 2),
(447, 'Juhnjhunun', 19),
(135, 'Junagadh', 5),
(552, 'Jyotiba Phule Nagar', 23),
(10, 'Kadapa', 1),
(74, 'Kaimur', 4),
(159, 'Kaithal', 6),
(396, 'Kalahandi', 17),
(475, 'Kanchipuram', 21),
(397, 'Kandhamal', 17),
(174, 'Kangra', 7),
(105, 'Kanker', 36),
(555, 'Kannauj', 23),
(253, 'Kannur', 10),
(554, 'Kanpur Dehat', 23),
(556, 'Kanpur Nagar', 23),
(536, 'Kanshiram Nagar', 23),
(476, 'Kanyakumari', 21),
(422, 'Kapurthala', 18),
(410, 'Karaikal', 27),
(453, 'Karauli', 19),
(48, 'Karbi Anglong', 2),
(189, 'Kargil', 8),
(49, 'Karimganj', 2),
(11, 'Karimnagar', 1),
(158, 'Karnal', 6),
(477, 'Karur', 21),
(254, 'Kasaragod', 10),
(190, 'Kathua', 8),
(75, 'Katihar', 4),
(286, 'Katni', 11),
(557, 'Kaushambi', 23),
(106, 'Kawardha', 36),
(399, 'Kendrapara', 17),
(395, 'Kendujhar', 17),
(72, 'Khagaria', 4),
(12, 'Khammam', 1),
(287, 'Khandwa', 11),
(288, 'Khargone', 11),
(137, 'Kheda', 5),
(394, 'Khordha', 17),
(175, 'Kinnaur', 7),
(73, 'Kishanganj', 4),
(236, 'Kodagu', 9),
(210, 'Koderma', 34),
(373, 'Kohima', 16),
(50, 'Kokrajhar', 2),
(237, 'Kolar', 9),
(366, 'Kolasib', 15),
(327, 'Kolhapur', 12),
(595, 'Kolkata', 24),
(252, 'Kollam', 10),
(238, 'Koppal', 9),
(398, 'Koraput', 17),
(103, 'Korba', 36),
(104, 'Koriya', 36),
(454, 'Kota', 19),
(255, 'Kottayam', 10),
(256, 'Kozhikode', 10),
(13, 'Krishna', 1),
(176, 'Kulu', 7),
(191, 'Kupwara', 8),
(14, 'Kurnool', 1),
(160, 'Kurukshetra', 6),
(558, 'Kushinagar', 23),
(136, 'Kutch', 5),
(177, 'Lahaul and Spiti', 7),
(51, 'Lakhimpur', 2),
(560, 'Lakhimpur Kheri', 23),
(76, 'Lakhisarai', 4),
(559, 'Lalitpur', 23),
(328, 'Latur', 12),
(367, 'Lawngtlai', 15),
(192, 'Leh', 8),
(211, 'Lohardaga', 34),
(30, 'Lohit', 3),
(31, 'Lower Subansiri', 3),
(561, 'Lucknow', 23),
(423, 'Ludhiana', 18),
(368, 'Lunglei', 15),
(79, 'Madhepura', 4),
(77, 'Madhubani', 4),
(478, 'Madurai', 21),
(549, 'Mahamaya Nagar', 23),
(564, 'Maharajganj', 23),
(107, 'Mahasamund', 36),
(15, 'Mahbubnagar', 1),
(411, 'Mahe', 27),
(161, 'Mahendragarh', 6),
(565, 'Mahoba', 23),
(568, 'Mainpuri', 23),
(257, 'Malappuram', 10),
(596, 'Malda', 24),
(400, 'Malkangiri', 17),
(369, 'Mamit', 15),
(178, 'Mandi', 7),
(289, 'Mandla', 11),
(290, 'Mandsaur', 11),
(239, 'Mandya', 9),
(424, 'Mansa', 18),
(52, 'Marigaon', 2),
(569, 'Mathura', 23),
(562, 'Mau', 23),
(401, 'Mayurbhanj', 17),
(16, 'Medak', 1),
(563, 'Meerut', 23),
(138, 'Mehsana', 5),
(162, 'Mewat', 6),
(597, 'Midnapore', 24),
(566, 'Mirzapur', 23),
(425, 'Moga', 18),
(374, 'Mokokchung', 16),
(375, 'Mon', 16),
(567, 'Moradabad', 23),
(291, 'Morena', 11),
(426, 'Mukatsar', 18),
(329, 'Mumbai City', 12),
(330, 'Mumbai suburban', 12),
(78, 'Munger', 4),
(598, 'Murshidabad', 24),
(570, 'Muzaffarnagar', 23),
(80, 'Muzaffarpur', 4),
(240, 'Mysore', 9),
(402, 'Nabarangpur', 17),
(599, 'Nadia', 24),
(53, 'Nagaon', 2),
(479, 'Nagapattinam', 21),
(455, 'Nagaur', 19),
(333, 'Nagpur', 12),
(508, 'Nainital', 33),
(81, 'Nalanda', 4),
(54, 'Nalbari', 2),
(17, 'Nalgonda', 1),
(481, 'Namakkal', 21),
(332, 'Nanded', 12),
(331, 'Nandurbar', 12),
(139, 'Narmada', 5),
(292, 'Narsinghpur', 11),
(334, 'Nashik', 12),
(140, 'Navsari', 5),
(82, 'Nawada', 4),
(427, 'Nawan Shehar', 18),
(404, 'Nayagarh', 17),
(293, 'Neemuch', 11),
(18, 'Nellore', 1),
(116, 'New Delhi', 25),
(3, 'Nicobar', 32),
(19, 'Nizamabad', 1),
(600, 'North 24 Parganas', 24),
(1, 'North and Middle Andaman', 32),
(55, 'North Cachar Hills', 2),
(117, 'North Delhi', 25),
(118, 'North East Delhi', 25),
(123, 'North Goa', 26),
(465, 'North Sikkim', 20),
(499, 'North Tripura', 22),
(119, 'North West Delhi', 25),
(403, 'Nuapada', 17),
(335, 'Osmanabad', 12),
(212, 'Pakur', 34),
(258, 'Palakkad', 10),
(213, 'Palamu', 34),
(456, 'Pali', 19),
(170, 'Palwal', 6),
(163, 'Panchkula', 6),
(142, 'Panchmahal', 5),
(164, 'Panipat', 6),
(294, 'Panna', 11),
(32, 'Papum Pare', 3),
(336, 'Parbhani', 12),
(95, 'Pashchim Champaran', 4),
(217, 'Pashchim Singhbhum', 34),
(141, 'Patan', 5),
(259, 'Pathanamthitta', 10),
(428, 'Patiala', 18),
(83, 'Patna', 4),
(509, 'Pauri Garhwal', 33),
(482, 'Perambalur', 21),
(376, 'Phek', 16),
(571, 'Pilibhit', 23),
(510, 'Pithoragharh', 33),
(193, 'Poonch', 8),
(143, 'Porbandar', 5),
(20, 'Prakasam', 1),
(457, 'Pratapgarh', 19),
(572, 'Pratapgarh', 23),
(412, 'Puducherry', 27),
(483, 'Pudukkottai', 21),
(194, 'Pulwama', 8),
(337, 'Pune', 12),
(67, 'Purba Champaran', 4),
(204, 'Purba Singhbhum', 34),
(405, 'Puri', 17),
(84, 'Purnia', 4),
(602, 'Purulia', 24),
(574, 'Rae Bareli', 23),
(241, 'Raichur', 9),
(338, 'Raigad', 12),
(108, 'Raigarh', 36),
(110, 'Raipur', 36),
(298, 'Raisen', 11),
(195, 'Rajauri', 8),
(296, 'Rajgarh', 11),
(144, 'Rajkot', 5),
(109, 'Rajnandgaon', 36),
(458, 'Rajsamand', 19),
(246, 'Ramanagara', 9),
(484, 'Ramanathapuram', 21),
(218, 'Ramgarh', 34),
(573, 'Rampur', 23),
(214, 'Ranchi', 34),
(21, 'Rangareddi', 1),
(297, 'Ratlam', 11),
(339, 'Ratnagiri', 12),
(406, 'Rayagada', 17),
(295, 'Rewa', 11),
(165, 'Rewari', 6),
(360, 'Ri-Bhoi', 14),
(166, 'Rohtak', 6),
(85, 'Rohtas', 4),
(511, 'Rudraprayag', 33),
(429, 'Rupnagar', 18),
(145, 'Sabarkantha', 5),
(299, 'Sagar', 11),
(575, 'Saharanpur', 23),
(86, 'Saharsa', 4),
(215, 'Sahibganj', 34),
(370, 'Saiha', 15),
(485, 'Salem', 21),
(87, 'Samastipur', 4),
(197, 'Samba', 8),
(407, 'Sambalpur', 17),
(341, 'Sangli', 12),
(430, 'Sangrur', 18),
(578, 'Sant Kabir Nagar', 23),
(581, 'Sant Ravidas Nagar', 23),
(90, 'Saran', 4),
(343, 'Satara', 12),
(300, 'Satna', 11),
(460, 'Sawai Madhopur', 19),
(301, 'Sehore', 11),
(352, 'Senapati', 13),
(302, 'Seoni', 11),
(216, 'Seraikela and Kharsawan', 34),
(371, 'Serchhip', 15),
(303, 'Shahdol', 11),
(577, 'Shahjahanpur', 23),
(304, 'Shajapur', 11),
(89, 'Sheikhpura', 4),
(88, 'Sheohar', 4),
(305, 'Sheopur', 11),
(179, 'Shimla', 7),
(242, 'Shimoga', 9),
(306, 'Shivpuri', 11),
(583, 'Shravasti', 23),
(56, 'Sibsagar', 2),
(579, 'Siddharthnagar', 23),
(307, 'Sidhi', 11),
(459, 'Sikar', 19),
(340, 'Sindhudurg', 12),
(308, 'Singrauli', 11),
(180, 'Sirmaur', 7),
(461, 'Sirohi', 19),
(167, 'Sirsa', 6),
(91, 'Sitamarhi', 4),
(576, 'Sitapur', 23),
(486, 'Sivagangai', 21),
(93, 'Siwan', 4),
(181, 'Solan', 7),
(342, 'Solapur', 12),
(580, 'Sonbhadra', 23),
(168, 'Sonepat', 6),
(57, 'Sonitpur', 2),
(601, 'South 24 Parganas', 24),
(2, 'South Andaman', 32),
(120, 'South Delhi', 25),
(361, 'South Garo Hills', 14),
(124, 'South Goa', 26),
(466, 'South Sikkim', 20),
(500, 'South Tripura', 22),
(121, 'South West Delhi', 25),
(22, 'Srikakulam', 1),
(196, 'Srinagar', 8),
(408, 'Subarnapur', 17),
(582, 'Sultanpur', 23),
(409, 'Sundargarh', 17),
(92, 'Supaul', 4),
(147, 'Surat', 5),
(146, 'Surendranagar', 5),
(111, 'Surguja', 36),
(353, 'Tamenglong', 13),
(512, 'Tehri Garhwal', 33),
(344, 'Thane', 12),
(491, 'Thanjavur', 21),
(132, 'The Dangs', 5),
(480, 'The Nilgiris', 21),
(489, 'Theni', 21),
(493, 'Thiruvallur', 21),
(261, 'Thiruvananthapuram', 10),
(494, 'Thiruvarur', 21),
(492, 'Thoothukudi', 21),
(354, 'Thoubal', 13),
(260, 'Thrissur', 10),
(309, 'Tikamgarh', 11),
(58, 'Tinsukia', 2),
(33, 'Tirap', 3),
(488, 'Tiruchirappalli', 21),
(490, 'Tirunelveli', 21),
(487, 'Tiruppur', 21),
(495, 'Tiruvannamalai', 21),
(462, 'Tonk', 19),
(377, 'Tuensang', 16),
(243, 'Tumkur', 9),
(463, 'Udaipur', 19),
(513, 'Udham Singh Nagar', 33),
(198, 'Udhampur', 8),
(244, 'Udupi', 9),
(310, 'Ujjain', 11),
(355, 'Ukhrul', 13),
(311, 'Umaria', 11),
(182, 'Una', 7),
(584, 'Unnao', 23),
(35, 'Upper Subansiri', 3),
(603, 'Uttar Dinajpur', 24),
(245, 'Uttara Kannada', 9),
(514, 'Uttarkashi', 33),
(148, 'Vadodara', 5),
(94, 'Vaishali', 4),
(149, 'Valsad', 5),
(585, 'Varanasi', 23),
(496, 'Vellore', 21),
(312, 'Vidisha', 11),
(497, 'Villupuram', 21),
(23, 'Vishakhapatnam', 1),
(24, 'Vizianagaram', 1),
(25, 'Warangal', 1),
(345, 'Wardha', 12),
(346, 'Washim', 12),
(262, 'Wayanad', 10),
(122, 'West Delhi', 25),
(362, 'West Garo Hills', 14),
(26, 'West Godavari', 1),
(36, 'West Kameng', 3),
(363, 'West Khasi Hills', 14),
(467, 'West Sikkim', 20),
(501, 'West Tripura', 22),
(378, 'Wokha', 16),
(248, 'Yadagiri', 9),
(169, 'Yamuna Nagar', 6),
(413, 'Yanam', 27),
(347, 'Yavatmal', 12),
(379, 'Zunheboto', 16);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation`
--

CREATE TABLE `tbl_designation` (
  `id` int(11) NOT NULL,
  `designation_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `del_status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_designation`
--

INSERT INTO `tbl_designation` (`id`, `designation_name`, `status`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 'Gynaecologist', 1, 1, '2023-05-05 10:57:54', '2023-05-05 10:57:54'),
(2, 'Physician & Diabetologist', 1, 1, '2023-05-05 10:57:54', '2023-05-05 10:57:54'),
(3, 'Orthopaedic / Spine Surgeon', 1, 1, '2023-05-05 10:57:54', '2023-05-05 10:57:54');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_diseases`
--

INSERT INTO `tbl_diseases` (`id`, `diseases_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Acute Flaccid Myelitis (AFM)', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(2, 'AIDS (HIV/AIDS)', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(3, 'Alphaviruses', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(4, 'Alzheimer’s Disease', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(5, 'Anemia', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(6, 'Anxiety disorders', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(7, 'Appendicitis', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(8, 'Arboviral Encephalitis', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(9, 'Arthritis', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(10, 'Asthma', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(11, 'Autism', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(12, 'Babesiosis', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(13, 'Back pain', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(14, 'Bacterial Vaginosis', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(15, 'Blood clots', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(16, 'Blue-green Algae', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(17, 'Bronchitis', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(18, 'Bulimia nervosa', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(19, 'Cancer', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(20, 'Cancer - Bladder', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(21, 'Cancer - Breast', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(22, 'Cancer - Breast Exams and Mammograms', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(23, 'Cancer - Cervical', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(24, '', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(25, 'Cancer - Colorectal', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(26, 'Cancer - Endometrial', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(27, 'Cancer - Kidney', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(28, 'Cancer - Leukemia', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(29, 'Cancer - Liver', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(30, 'Cancer - Lung', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(31, 'Cancer - Multiple Myeloma', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(32, 'Cancer - Oral', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(33, 'Cancer - Ovarian', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(34, 'Cancer - Pancreatic', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(35, 'Cancer - Skin', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(36, 'Cancer - Stomach', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(37, 'Cancer - Testicular', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(38, 'Cancer - Thyroid', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(39, 'Cancer - Uterus', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(40, 'Carbapenem-Resistant Enterobacteriaceae (CRE) Infections', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(41, 'Celiac Disease', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(42, 'Cardiovascular Disease', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(43, 'Chancroid', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(44, 'Chagas Disease', 1, '2023-05-10 15:20:21', '2023-05-10 15:20:21'),
(45, 'Chlamydia', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(46, 'Chronic Obstructive Pulmonary Disease (COPD)', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(47, 'Chronic Fatigue Syndrome', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(48, 'Conjunctivitis', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(49, 'Clostridium Difficile', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(50, 'Cirrhosis', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(51, 'Cold sores', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(52, 'Common cold', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(53, 'Congestive heart failure', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(54, 'Crohn\'s disease', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(55, 'Creutzfeldt-Jakob Disease', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(56, 'Crabs', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(57, 'Cyclospora', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(58, 'Cryptosporidiosis', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(59, 'Cystic fibrosis', 1, '2023-05-10 15:25:39', '2023-05-10 15:25:39'),
(60, 'Dementia', 1, '2023-05-10 15:27:14', '2023-05-10 15:27:14'),
(61, 'Depression', 1, '2023-05-10 15:27:14', '2023-05-10 15:27:14'),
(62, 'Diabetes', 1, '2023-05-10 15:27:14', '2023-05-10 15:27:14'),
(63, 'Diarrhea', 1, '2023-05-10 15:27:14', '2023-05-10 15:27:14'),
(64, 'Diphtheria', 1, '2023-05-10 15:27:14', '2023-05-10 15:27:14'),
(65, 'Down syndrome', 1, '2023-05-10 15:27:14', '2023-05-10 15:27:14'),
(66, 'Dyslexia', 1, '2023-05-10 15:27:14', '2023-05-10 15:27:14'),
(67, 'Eastern Equine Encephalitis Virus (EEEV)', 1, '2023-05-10 15:29:38', '2023-05-10 15:29:38'),
(68, 'E. Coli', 1, '2023-05-10 15:29:38', '2023-05-10 15:29:38'),
(69, 'Ear infections', 1, '2023-05-10 15:29:38', '2023-05-10 15:29:38'),
(70, 'Ebola Virus', 1, '2023-05-10 15:29:38', '2023-05-10 15:29:38'),
(71, 'Eczema', 1, '2023-05-10 15:29:38', '2023-05-10 15:29:38'),
(72, 'Ehrlichiosis', 1, '2023-05-10 15:29:38', '2023-05-10 15:29:38'),
(73, 'Enterovirus', 1, '2023-05-10 15:29:38', '2023-05-10 15:29:38'),
(74, 'Endometriosis', 1, '2023-05-10 15:29:38', '2023-05-10 15:29:38'),
(75, 'Epilepsy', 1, '2023-05-10 15:29:38', '2023-05-10 15:29:38'),
(76, 'Erectile dysfunction', 1, '2023-05-10 15:29:38', '2023-05-10 15:29:38'),
(77, 'Fibroids', 1, '2023-05-10 15:30:36', '2023-05-10 15:30:36'),
(78, 'Fibromyalgia', 1, '2023-05-10 15:30:36', '2023-05-10 15:30:36'),
(79, 'Flu', 1, '2023-05-10 15:30:36', '2023-05-10 15:30:36'),
(80, 'Food poisoning', 1, '2023-05-10 15:30:36', '2023-05-10 15:30:36'),
(81, 'Gallstones', 1, '2023-05-10 15:32:27', '2023-05-10 15:32:27'),
(82, 'Gastroesophageal reflux disease (GERD)', 1, '2023-05-10 15:32:27', '2023-05-10 15:32:27'),
(83, 'Genital Herpes', 1, '2023-05-10 15:32:27', '2023-05-10 15:32:27'),
(84, 'Giardiasis', 1, '2023-05-10 15:32:27', '2023-05-10 15:32:27'),
(85, 'Gonorrhea', 1, '2023-05-10 15:32:27', '2023-05-10 15:32:27'),
(86, 'Gout', 1, '2023-05-10 15:32:27', '2023-05-10 15:32:27'),
(87, 'Group A Streptococcus', 1, '2023-05-10 15:32:27', '2023-05-10 15:32:27'),
(88, 'Group A Streptococcus (Parents/Caregivers)', 1, '2023-05-10 15:32:27', '2023-05-10 15:32:27'),
(89, 'Haff Disease', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(90, 'Hantaviruses', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(91, 'Harmful Algal Blooms', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(92, 'Head Lice', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(93, 'Headaches', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(94, 'Heart attack', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(95, 'Helicobacter Pylori', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(96, 'Hemorrhoids', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(97, 'Hepatitis', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(98, 'Herpes', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(99, 'High Blood Pressure', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(100, 'High cholesterol', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(101, 'Histoplasmosis', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(102, 'HIV/AIDS', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(103, 'Huntington\'s disease', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(104, 'Human Metapneumovirus', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(105, 'Human Papillomavirus', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(106, 'Hyperthyroidism', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(107, 'Hypothyroidism', 1, '2023-05-10 15:36:47', '2023-05-10 15:36:47'),
(108, 'Incontinence', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(109, 'Inflammatory bowel disease (IBD)', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(110, 'Influenza', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(111, 'Insomnia', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(112, 'Irritable bowel syndrome (IBS)', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(113, 'Jaundice', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(114, 'Kidney stones', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(115, 'Lead Poisoning', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(116, 'Legionnaires\' Disease', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(117, 'Leptospirosis', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(118, 'Leukemia', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(119, 'Listeriosis', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(120, 'Lupus', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(121, 'Lyme Disease', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(122, 'Lymphogranuloma Venereum (LGV)', 1, '2023-05-10 15:40:56', '2023-05-10 15:40:56'),
(123, 'Malaria', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(124, 'Meningitis', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(125, 'Measles', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(126, 'Meningococcal Disease', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(127, 'Meningitis', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(128, 'Menopause', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(129, 'Migraines', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(130, 'MRSA', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(131, 'MRSA (Pet Owners)', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(132, 'Methyl Parathion', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(133, 'Molluscum Contagiosum', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(134, 'MPV', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(135, 'Mumps', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(136, 'Multiple sclerosis (MS)', 1, '2023-05-10 15:43:48', '2023-05-10 15:43:48'),
(137, 'Nasal congestion', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(138, 'Nausea', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(139, 'Neck pain', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(140, 'Nephritis', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(141, 'Neonatal Abstinence Syndrome', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(142, 'Naegleria Fowleri', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(143, 'Non-Gonococcal Urethritis (NGU)', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(144, 'Noroviruses', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(145, 'Norwalk Virus', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(146, 'Obesity', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(147, 'Obsessive-compulsive disorder (OCD)', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(148, 'Osteoarthritis', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(149, 'Osteoporosis', 1, '2023-05-10 15:46:22', '2023-05-10 15:46:22'),
(150, 'Parkinson\'s disease', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(151, 'Peptic ulcer', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(152, 'Pelvic Inflammatory Disease (PID)', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(153, 'Pertussis', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(154, 'Plague', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(155, 'Pneumococcal Disease', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(156, 'Pneumonia', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(157, 'Polio', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(158, 'Post-traumatic stress disorder (PTSD)', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(159, 'Primary Amebic Meningoencephalitis', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(160, 'Parkinson\'s Disease', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(161, 'PCOD', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(162, 'PCOS', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(163, 'Psoriasis', 1, '2023-05-10 15:49:42', '2023-05-10 15:49:42'),
(164, 'Rabies', 1, '2023-05-10 15:51:44', '2023-05-10 15:51:44'),
(165, 'Respiratory Illness Due to Enterovirus', 1, '2023-05-10 15:51:44', '2023-05-10 15:51:44'),
(166, 'Rheumatoid arthritis', 1, '2023-05-10 15:51:44', '2023-05-10 15:51:44'),
(167, 'Rocky Mountain Spotted Fever', 1, '2023-05-10 15:51:44', '2023-05-10 15:51:44'),
(168, 'Rosacea', 1, '2023-05-10 15:51:44', '2023-05-10 15:51:44'),
(169, 'Rotavirus', 1, '2023-05-10 15:51:44', '2023-05-10 15:51:44'),
(170, 'Rubella', 1, '2023-05-10 15:51:44', '2023-05-10 15:51:44'),
(171, 'Salmonella', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(172, 'Sarcoidosis', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(173, 'SARS', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(174, 'SARS (Healthcare Providers)', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(175, 'Scabies', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(176, 'Schizophrenia', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(177, 'Sciatica', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(178, 'Scoliosis', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(179, 'Seoul Virus', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(180, 'Sexually Transmitted Diseases (STDs)', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(181, 'Shigellosis', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(182, 'Shingles', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(183, 'Sinusitis', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(184, 'Sleep apnea', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(185, 'Smallpox', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(186, 'Sore throat', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(187, 'Staph Infection', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(188, 'Stress', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(189, 'Stroke', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(190, 'Substance abuse', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(191, 'Syphilis', 1, '2023-05-10 15:57:10', '2023-05-10 15:57:10'),
(192, 'Tennis elbow', 1, '2023-05-10 16:01:53', '2023-05-10 16:01:53'),
(193, 'Tetanus', 1, '2023-05-10 16:01:53', '2023-05-10 16:01:53'),
(194, 'Thrombosis', 1, '2023-05-10 16:01:53', '2023-05-10 16:01:53'),
(195, 'Tinnitus', 1, '2023-05-10 16:01:53', '2023-05-10 16:01:53'),
(196, 'Tuberculosis', 1, '2023-05-10 16:01:53', '2023-05-10 16:01:53'),
(197, 'Tularemia', 1, '2023-05-10 16:01:53', '2023-05-10 16:01:53'),
(198, 'Urinary tract infections (UTIs)', 1, '2023-05-10 16:04:40', '2023-05-10 16:04:40'),
(199, 'Varicose veins', 1, '2023-05-10 16:04:40', '2023-05-10 16:04:40'),
(200, 'Vertigo', 1, '2023-05-10 16:04:40', '2023-05-10 16:04:40'),
(201, 'Viral hepatitis', 1, '2023-05-10 16:04:40', '2023-05-10 16:04:40'),
(202, 'Vaginitis', 1, '2023-05-10 16:04:40', '2023-05-10 16:04:40'),
(203, 'West Nile Virus', 1, '2023-05-10 16:04:40', '2023-05-10 16:04:40'),
(204, 'Wilson\'s Disease', 1, '2023-05-10 16:04:40', '2023-05-10 16:04:40'),
(205, 'Whooping cough', 1, '2023-05-10 16:04:40', '2023-05-10 16:04:40'),
(206, 'Yellow Fever', 1, '2023-05-10 16:04:40', '2023-05-10 16:04:40'),
(207, 'Zika virus', 1, '2023-05-10 16:04:40', '2023-05-10 16:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doctor`
--

CREATE TABLE `tbl_doctor` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_no` varchar(30) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `fk_gender_id` int(11) DEFAULT NULL,
  `fk_designation_id` int(11) DEFAULT NULL,
  `address1` longtext DEFAULT NULL,
  `address2` longtext DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `image` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `del_status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_doctor`
--

INSERT INTO `tbl_doctor` (`id`, `first_name`, `last_name`, `email`, `contact_no`, `dob`, `fk_gender_id`, `fk_designation_id`, `address1`, `address2`, `state`, `city`, `pincode`, `image`, `status`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 'DR. SWAPNIL', 'GANESHPURE', 'swapnilganeshpure@gmail.com', '8010597078', '20/05/1988', 1, 2, 'Mumbai', '', '12', '329', '400007', 'uploads/236158_SWAPNILGANESHPURE.jpg', 1, 1, '2023-05-05 17:12:48', '2023-05-05 17:14:08'),
(2, 'DR. DIPTI', 'GUPTA', 'diptigupta@gmail.com', '8010597077', '21-05-1985', 2, 1, 'Mumbai', '', '12', '329', '400007', 'uploads/873677_Dr.-DIPTI-GUPTA.jpg', 1, 1, '2023-05-06 09:36:05', '2023-05-06 09:36:05'),
(3, 'DR. ARVIND', 'VATKAR', 'arvindvatkar@gmail.com', '8010597089', '21-05-1985', 1, 3, 'Mumbai', 'Mumbai', '12', '329', '400007', 'uploads/422420_Dr.-ARVIND-VATKAR.jpg', 1, 1, '2023-05-06 09:40:01', '2023-05-06 13:55:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gender`
--

CREATE TABLE `tbl_gender` (
  `id` int(11) NOT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_gender`
--

INSERT INTO `tbl_gender` (`id`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'Male', '2023-05-05 12:51:23', '2023-05-05 12:51:23'),
(2, 'Female', '2023-05-05 12:51:23', '2023-05-05 12:51:23'),
(3, 'Transgender', '2023-05-05 12:51:23', '2023-05-05 12:51:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_marital_status`
--

CREATE TABLE `tbl_marital_status` (
  `id` int(11) NOT NULL,
  `marital_status` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_marital_status`
--

INSERT INTO `tbl_marital_status` (`id`, `marital_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Single', 1, '2023-05-05 15:18:25', '2023-05-05 15:18:25'),
(2, 'Married', 1, '2023-05-05 15:18:25', '2023-05-05 15:18:25'),
(3, 'Divorced', 1, '2023-05-05 15:18:25', '2023-05-05 15:18:25'),
(4, 'Legally Seperated', 1, '2023-05-05 15:18:25', '2023-05-05 15:18:25'),
(5, 'Widowed', 1, '2023-05-05 15:18:25', '2023-05-05 15:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patients`
--

CREATE TABLE `tbl_patients` (
  `id` bigint(11) NOT NULL,
  `patient_id` varchar(100) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `dob` varchar(30) DEFAULT NULL,
  `fk_gender_id` int(11) DEFAULT NULL,
  `fk_marital_status_id` int(11) DEFAULT NULL,
  `fk_blood_group_id` int(11) DEFAULT NULL,
  `address1` longtext DEFAULT NULL,
  `address2` longtext DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `del_status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_patients`
--

INSERT INTO `tbl_patients` (`id`, `patient_id`, `first_name`, `last_name`, `email`, `contact_no`, `dob`, `fk_gender_id`, `fk_marital_status_id`, `fk_blood_group_id`, `address1`, `address2`, `state`, `city`, `pincode`, `emergency_contact_name`, `emergency_contact_phone`, `status`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 'LCT24609079', 'Shirin', 'Ragbansingh', 'ragbansinghshirin@gmail.com', '8010597070', '21/05/1992', 2, 1, 5, 'Asha Vihar Bld No 1', 'Hendre Pada Rd Kulgaon Badlapur (West)', 12, 344, '421503', 'Varsha Ragbansingh', '7875279816', 1, 1, '2023-05-08 10:15:33', '2023-05-08 10:58:08'),
(2, 'WZGL4297935', 'Mansi', 'Palkar', 'mansipalkar@gmail.com', '8010594040', '19-04-1995', 2, 1, 1, 'Mumbai', 'Mumbai', 12, 329, '400007', 'Shirin Ragbansingh', '8010597075', 1, 1, '2023-05-09 17:41:41', '2023-05-09 17:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient_medical_documents`
--

CREATE TABLE `tbl_patient_medical_documents` (
  `id` bigint(20) NOT NULL,
  `fk_patient_id` int(11) DEFAULT NULL,
  `fk_appointment_id` int(11) DEFAULT NULL,
  `documents` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_patient_medical_documents`
--

INSERT INTO `tbl_patient_medical_documents` (`id`, `fk_patient_id`, `fk_appointment_id`, `documents`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'uploads/document/6459dc005d173.jpg', '2023-05-09 11:07:04', '2023-05-09 11:09:11'),
(2, 1, 1, 'uploads/document/6459dc005eeaf.jpg', '2023-05-09 11:07:04', '2023-05-09 11:09:11'),
(3, 1, 1, 'uploads/document/6459dc0061243.jpg', '2023-05-09 11:07:04', '2023-05-09 11:09:11'),
(4, 1, 1, 'uploads/document/6459dc0062ff4.jpg', '2023-05-09 11:07:04', '2023-05-09 11:09:11'),
(5, 1, 2, 'uploads/documents/LCT24609079/6459f0005fd76.jpg', '2023-05-09 12:32:24', '2023-05-09 12:32:24'),
(6, 1, 2, 'uploads/documents/LCT24609079/6459f00061dfd.jpg', '2023-05-09 12:32:24', '2023-05-09 12:32:24'),
(7, 1, 2, 'uploads/documents/LCT24609079/6459f00063f9f.jpg', '2023-05-09 12:32:24', '2023-05-09 12:32:24'),
(8, 1, 2, 'uploads/documents/LCT24609079/6459f000683d3.png', '2023-05-09 12:32:24', '2023-05-09 12:32:24'),
(9, 2, 3, 'uploads/documents/WZGL4297935/645a3926499d5.jpg', '2023-05-09 17:44:30', '2023-05-09 17:44:30'),
(10, 2, 3, 'uploads/documents/WZGL4297935/645a3926516ea.jpg', '2023-05-09 17:44:30', '2023-05-09 17:44:30'),
(11, 2, 3, 'uploads/documents/WZGL4297935/645a392653662.png', '2023-05-09 17:44:30', '2023-05-09 17:44:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `id` bigint(20) NOT NULL,
  `fk_patient_id` int(11) DEFAULT NULL,
  `fk_appointment_id` int(11) DEFAULT NULL,
  `payment_type` varchar(10) DEFAULT NULL,
  `online_amount` double DEFAULT NULL,
  `cash_amount` double DEFAULT NULL,
  `mediclaim_amount` double DEFAULT NULL,
  `discount_amount` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`id`, `fk_patient_id`, `fk_appointment_id`, `payment_type`, `online_amount`, `cash_amount`, `mediclaim_amount`, `discount_amount`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Cash', 1000, 200, 500, 20, 200, '2023-05-09 11:07:04', '2023-05-09 11:07:04'),
(2, 1, 2, 'Cash', 100, 100, 100, 10, 290, '2023-05-09 12:32:24', '2023-05-09 12:32:24'),
(3, 2, 3, 'Cash', 1000, 1000, 200, 100, 2100, '2023-05-09 17:44:30', '2023-05-09 17:44:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_states`
--

CREATE TABLE `tbl_states` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_states`
--

INSERT INTO `tbl_states` (`id`, `name`, `country_id`) VALUES
(1, 'ANDHRA PRADESH', 105),
(2, 'ASSAM', 105),
(3, 'ARUNACHAL PRADESH', 105),
(4, 'BIHAR', 105),
(5, 'GUJRAT', 105),
(6, 'HARYANA', 105),
(7, 'HIMACHAL PRADESH', 105),
(8, 'JAMMU & KASHMIR', 105),
(9, 'KARNATAKA', 105),
(10, 'KERALA', 105),
(11, 'MADHYA PRADESH', 105),
(12, 'MAHARASHTRA', 105),
(13, 'MANIPUR', 105),
(14, 'MEGHALAYA', 105),
(15, 'MIZORAM', 105),
(16, 'NAGALAND', 105),
(17, 'ORISSA', 105),
(18, 'PUNJAB', 105),
(19, 'RAJASTHAN', 105),
(20, 'SIKKIM', 105),
(21, 'TAMIL NADU', 105),
(22, 'TRIPURA', 105),
(23, 'UTTAR PRADESH', 105),
(24, 'WEST BENGAL', 105),
(25, 'DELHI', 105),
(26, 'GOA', 105),
(27, 'PONDICHERY', 105),
(28, 'LAKSHDWEEP', 105),
(29, 'DAMAN & DIU', 105),
(30, 'DADRA & NAGAR', 105),
(31, 'CHANDIGARH', 105),
(32, 'ANDAMAN & NICOBAR', 105),
(33, 'UTTARANCHAL', 105),
(34, 'JHARKHAND', 105),
(35, 'CHATTISGARH', 105);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `fk_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_no` varchar(100) DEFAULT NULL,
  `password` longtext DEFAULT NULL,
  `fk_user_type` int(11) DEFAULT NULL,
  `login_status` int(11) NOT NULL DEFAULT 1,
  `del_status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `fk_id`, `first_name`, `last_name`, `email`, `contact_no`, `password`, `fk_user_type`, `login_status`, `del_status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Shirin', 'Ragbansingh', 'shirin@stzsoft.com', '8010597075', 'VUNtZmhSZjkvS3JDUVJvQUllNWc2Zz09', 1, 1, 1, '2023-05-05 17:09:47', '2023-05-05 17:09:47'),
(2, 1, 'DR. SWAPNIL', 'GANESHPURE', 'swapnilganeshpure@gmail.com', '8010597078', 'bFVOWmd2b0JaTE9McEE1NExNLzV5b2llWEJqWVJPOFJ5TWlkTFFDZ2E0QT0=', 2, 1, 1, '2023-05-05 17:12:48', '2023-05-05 17:12:48'),
(3, 2, 'DR. DIPTI', 'GUPTA', 'diptigupta@gmail.com', '8010597077', 'ZXFNZzluRmZTK2pGRjRwQVZYeHN1dz09', 2, 1, 1, '2023-05-06 09:36:05', '2023-05-06 09:36:05'),
(4, 3, 'DR. ARVIND', 'VATKAR', 'arvindvatkar@gmail.com', '8010597089', 'Y3FBM09oakRxV3pMd1Q3bm9kYlQ0Zz09', 2, 1, 1, '2023-05-06 09:40:01', '2023-05-06 13:55:56'),
(5, 1, 'Shirin', 'Ragbansingh', 'ragbansinghshirin@gmail.com', '8010597070', 'ZDNjZGJBYlRpbU1jNlNIVHdoWXJGZz09', 4, 1, 1, '2023-05-08 10:15:33', '2023-05-08 10:58:14'),
(6, 2, 'Mansi', 'Palkar', 'mansipalkar@gmail.com', '8010594040', 'ZDNjZGJBYlRpbU1jNlNIVHdoWXJGZz09', 4, 1, 1, '2023-05-09 17:41:41', '2023-05-09 17:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_type`
--

CREATE TABLE `tbl_user_type` (
  `id` int(11) NOT NULL,
  `user_type` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `del_status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_type`
--

INSERT INTO `tbl_user_type` (`id`, `user_type`, `status`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', 1, 1, '2023-05-03 18:33:31', '2023-05-03 18:33:31'),
(2, 'Doctor', 1, 1, '2023-05-03 18:33:31', '2023-05-03 18:33:31'),
(3, 'Nurse', 1, 1, '2023-05-03 18:33:31', '2023-05-03 18:33:31'),
(4, 'Patient', 1, 1, '2023-05-03 18:33:31', '2023-05-03 18:33:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ward`
--

CREATE TABLE `tbl_ward` (
  `id` int(11) NOT NULL,
  `wards` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `del_status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_ward`
--

INSERT INTO `tbl_ward` (`id`, `wards`, `status`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 'General Wards', 1, 1, '2023-05-04 13:58:23', '2023-05-04 13:58:23'),
(2, 'Intensive Care Units (ICU)', 1, 1, '2023-05-04 13:58:23', '2023-05-04 13:58:23'),
(3, 'Neonatal Intensive Care Units (NICU)', 1, 1, '2023-05-04 13:58:23', '2023-05-04 13:58:23'),
(4, 'Isolation Wards', 1, 1, '2023-05-04 13:58:23', '2023-05-04 13:58:23'),
(5, 'Psychiatric Wards', 1, 1, '2023-05-04 13:58:23', '2023-05-04 13:58:23'),
(6, 'Pediatric Wards', 1, 1, '2023-05-04 13:58:23', '2023-05-04 13:58:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `fk_doctor_id` (`fk_doctor_id`,`fk_patient_id`,`appointment_date`,`appointment_time`);

--
-- Indexes for table `tbl_appointment_type`
--
ALTER TABLE `tbl_appointment_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`type`);

--
-- Indexes for table `tbl_blood_group`
--
ALTER TABLE `tbl_blood_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `city` (`city`,`state_id`);

--
-- Indexes for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`designation_name`);

--
-- Indexes for table `tbl_diseases`
--
ALTER TABLE `tbl_diseases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_doctor`
--
ALTER TABLE `tbl_doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `first_name` (`first_name`),
  ADD KEY `last_name` (`last_name`,`email`,`contact_no`,`fk_gender_id`,`fk_designation_id`);

--
-- Indexes for table `tbl_gender`
--
ALTER TABLE `tbl_gender`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`gender`);

--
-- Indexes for table `tbl_marital_status`
--
ALTER TABLE `tbl_marital_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`marital_status`);

--
-- Indexes for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`first_name`,`last_name`,`email`,`contact_no`,`dob`,`fk_gender_id`,`fk_marital_status_id`);

--
-- Indexes for table `tbl_patient_medical_documents`
--
ALTER TABLE `tbl_patient_medical_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_patient_id`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_patient_id`,`fk_appointment_id`,`payment_type`,`online_amount`,`cash_amount`,`mediclaim_amount`,`discount_amount`,`total_amount`);

--
-- Indexes for table `tbl_states`
--
ALTER TABLE `tbl_states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`name`,`country_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_id`,`first_name`,`last_name`,`email`,`contact_no`,`fk_user_type`);

--
-- Indexes for table `tbl_user_type`
--
ALTER TABLE `tbl_user_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`user_type`);

--
-- Indexes for table `tbl_ward`
--
ALTER TABLE `tbl_ward`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`wards`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_appointment_type`
--
ALTER TABLE `tbl_appointment_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_blood_group`
--
ALTER TABLE `tbl_blood_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=604;

--
-- AUTO_INCREMENT for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_diseases`
--
ALTER TABLE `tbl_diseases`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `tbl_doctor`
--
ALTER TABLE `tbl_doctor`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_gender`
--
ALTER TABLE `tbl_gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_marital_status`
--
ALTER TABLE `tbl_marital_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_patient_medical_documents`
--
ALTER TABLE `tbl_patient_medical_documents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_states`
--
ALTER TABLE `tbl_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_user_type`
--
ALTER TABLE `tbl_user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_ward`
--
ALTER TABLE `tbl_ward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;