-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2025 at 05:55 AM
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
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(10) NOT NULL,
  `passcode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `passcode`) VALUES
('admin', 'test'),
('guest', 'abc123'),
('manager', 'secret');

-- --------------------------------------------------------

--
-- Table structure for table `makeup_slips`
--

CREATE TABLE `makeup_slips` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `grade_level` varchar(10) NOT NULL,
  `section` char(1) NOT NULL,
  `subject` varchar(20) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `makeup_slips`
--

INSERT INTO `makeup_slips` (`id`, `first_name`, `last_name`, `grade_level`, `section`, `subject`, `teacher_name`, `start_date`, `end_date`, `created_at`, `email`, `reason`, `status`) VALUES
(2, 'Test1FN', 'Test1LN', 'Grade 1', 'A', 'Science', 'Ms. Ramos', '2025-05-06 00:00:00', '2025-05-09 00:00:00', '2025-05-11 13:45:13', 'banalkenan@gmail.com', 'Flu', 'Done'),
(3, 'FN11', 'LN11', 'Grade 1', 'A', 'Filipino', 'Mrs. Cruz', '2025-05-05 00:00:00', '2025-05-06 00:00:00', '2025-05-12 04:29:27', 'banalkenan@gmail.com', 'Flu', 'Pending'),
(4, 'FN12', 'LN12', 'Grade 1', 'B', 'Filipino', 'Mrs. Cruz', '2025-05-05 00:00:00', '2025-05-07 00:00:00', '2025-05-13 08:12:51', 'banalkenan@gmail.com', 'Wifi Disconnected', 'Pending'),
(5, 'FN13', 'LN13', 'Grade 1', 'B', 'English', 'Mr. Santos', '2025-05-05 00:00:00', '2025-05-07 00:00:00', '2025-05-13 08:14:43', 'banalkenan@gmail.com', 'Wifi Disconnected', 'Pending'),
(6, 'FN14', 'LN14', 'Grade 1', 'C', 'Filipino', 'Mrs. Cruz', '2025-05-05 00:00:00', '2025-05-07 00:00:00', '2025-05-13 08:19:07', 'banalkenan@gmail.com', 'Wifi Disconnected', 'Pending'),
(7, 'FN15', 'LN15', 'Grade 1', 'J', 'Filipino', 'Mrs. Cruz', '2025-05-07 00:00:00', '2025-05-08 00:00:00', '2025-05-13 08:20:57', 'banalkenan@gmail.com', 'Sick', 'Pending'),
(8, 'FN15', 'LN15', 'Grade 1', 'J', 'English', 'Mr. Santos', '2025-05-07 00:00:00', '2025-05-08 00:00:00', '2025-05-13 08:22:07', 'banalkenan@gmail.com', 'Sick', 'Pending'),
(9, 'FN16', 'LN16', 'Grade 1', 'J', 'Filipino', 'Mrs. Cruz', '2025-05-07 00:00:00', '2025-05-08 00:00:00', '2025-05-13 08:26:02', 'banalkenan@gmail.com', 'Sick', 'Pending'),
(10, 'FN16', 'LN16', 'Grade 1', 'A', 'Filipino', 'Mrs. Cruz', '2025-05-05 00:00:00', '2025-05-06 00:00:00', '2025-05-13 09:24:35', 'banalkenan@gmail.com', 'Sick', 'Pending'),
(11, 'FN17', 'LN17', 'Grade 1', 'B', 'English', 'Mr. Santos', '2025-05-05 00:00:00', '2025-05-09 00:00:00', '2025-05-13 13:03:51', 'banalkenan@gmail.com', 'none', 'Pending'),
(12, 'FN17', 'LN17', 'Grade 1', 'B', 'English', 'Mr. Santos', '2025-05-05 00:00:00', '2025-05-09 00:00:00', '2025-05-13 13:06:13', 'banalkenan@gmail.com', 'none', 'Pending'),
(13, 'FN18', 'LN18', 'Grade 1', 'K', 'English', 'Mr. Santos', '2025-05-05 00:00:00', '2025-05-12 00:00:00', '2025-05-13 23:24:26', 'banalkenan@gmail.com', 'Flu', 'Pending'),
(14, 'FN18', 'LN18', 'Grade 1', 'K', 'English', 'Mr. Santos', '2025-05-05 00:00:00', '2025-05-12 00:00:00', '2025-05-13 23:26:42', 'banalkenan@gmail.com', 'Flu', 'Pending'),
(15, 'FN18', 'LN18', 'Grade 1', 'K', 'English', 'Mr. Santos', '2025-05-05 00:00:00', '2025-05-12 00:00:00', '2025-05-13 23:28:17', 'banalkenan@gmail.com', 'Flu', 'Pending'),
(16, 'FN18', 'LN18', 'Grade 1', 'K', 'English', 'Mr. Santos', '2025-05-05 00:00:00', '2025-05-12 00:00:00', '2025-05-13 23:33:40', 'banalkenan@gmail.com', 'Flu', 'Pending'),
(17, 'FN18', 'LN18', 'Grade 1', 'K', 'English', 'Mr. Santos', '2025-05-05 00:00:00', '2025-05-12 00:00:00', '2025-05-13 23:36:04', 'banalkenan@gmail.com', 'Flu', 'Pending'),
(18, 'FN19', 'LN19', 'Grade 1', 'K', 'English', 'Mr. Santos', '2025-05-05 00:00:00', '2025-05-12 00:00:00', '2025-05-13 23:37:27', 'banalkenan@gmail.com', 'Flu', 'Pending'),
(19, 'Image', 'LN20', 'Grade 1', 'K', 'Filipino', 'Mrs. Cruz', '2025-05-06 00:00:00', '2025-05-11 00:00:00', '2025-05-13 23:41:02', 'banalkenan@gmail.com', 'Flu', 'Pending'),
(20, 'Image21', 'LN21', 'Grade 1', 'K', 'Filipino', 'Mrs. Cruz', '2025-05-06 00:00:00', '2025-05-11 00:00:00', '2025-05-13 23:46:55', 'banalkenan@gmail.com', 'Flu', 'Pending'),
(21, 'Image21', 'LN21', 'Grade 1', 'K', 'Filipino', 'Mrs. Cruz', '2025-05-06 00:00:00', '2025-05-11 00:00:00', '2025-05-13 23:57:25', 'banalkenan@gmail.com', 'Flu', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `teacher_name` varchar(100) DEFAULT NULL,
  `subject` varchar(50) DEFAULT NULL,
  `grade_level` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `teacher_name`, `subject`, `grade_level`, `email`) VALUES
(1, 'Ms. Lazo', 'Science', 'Kinder', NULL),
(2, 'Mr. Torres', 'Math', 'Kinder', NULL),
(3, 'Ms. Javier', 'English', 'Kinder', NULL),
(4, 'Mrs. Beltran', 'Filipino', 'Kinder', NULL),
(5, 'Mr. Rivera', 'AP', 'Kinder', NULL),
(6, 'Ms. Ramos', 'Science', 'Grade 1', 'kenanbanal3@gmail.com'),
(7, 'Mr. Santiago', 'Math', 'Grade 1', 'kenan_banal@dlsu.edu.ph'),
(8, 'Mr. Santos', 'English', 'Grade 1', 'banalkenan@gmail.com'),
(9, 'Mrs. Cruz', 'Filipino', 'Grade 1', 'zxiy523@gmail.com'),
(10, 'Ms. Alvarado', 'AP', 'Grade 1', 'dlsu.ece.thesis@gmail.com'),
(11, 'Mrs. David', 'Science', 'Grade 2', NULL),
(12, 'Mr. Reyes', 'Math', 'Grade 2', NULL),
(13, 'Ms. Gomez', 'English', 'Grade 2', NULL),
(14, 'Ms. Flores', 'Filipino', 'Grade 2', NULL),
(15, 'Mr. Castillo', 'AP', 'Grade 2', NULL),
(16, 'Mr. Ventura', 'Science', 'Grade 3', NULL),
(17, 'Ms. Lim', 'Math', 'Grade 3', NULL),
(18, 'Mrs. Hernandez', 'English', 'Grade 3', NULL),
(19, 'Ms. Bautista', 'Filipino', 'Grade 3', NULL),
(20, 'Mr. Domingo', 'AP', 'Grade 3', NULL),
(21, 'Ms. Medina', 'Science', 'Grade 4', NULL),
(22, 'Mr. Cruz', 'Math', 'Grade 4', NULL),
(23, 'Mrs. Santiago', 'English', 'Grade 4', NULL),
(24, 'Ms. Ramos', 'Filipino', 'Grade 4', NULL),
(25, 'Mr. Robles', 'AP', 'Grade 4', NULL),
(26, 'Mrs. Aquino', 'Science', 'Grade 5', NULL),
(27, 'Mr. Jimenez', 'Math', 'Grade 5', NULL),
(28, 'Ms. Morales', 'English', 'Grade 5', NULL),
(29, 'Mr. Fajardo', 'Filipino', 'Grade 5', NULL),
(30, 'Ms. Cabrera', 'AP', 'Grade 5', NULL),
(31, 'Mr. Ignacio', 'Science', 'Grade 6', NULL),
(32, 'Ms. Tan', 'Math', 'Grade 6', NULL),
(33, 'Mrs. Castro', 'English', 'Grade 6', NULL),
(34, 'Mrs. Dela Cruz', 'Filipino', 'Grade 6', NULL),
(35, 'Mr. Navarro', 'AP', 'Grade 6', NULL),
(36, 'Ms. Salazar', 'Science', 'Grade 7', NULL),
(37, 'Mr. Villanueva', 'Math', 'Grade 7', NULL),
(38, 'Ms. Reyes', 'English', 'Grade 7', NULL),
(39, 'Ms. Espinosa', 'Filipino', 'Grade 7', NULL),
(40, 'Mr. Padilla', 'AP', 'Grade 7', NULL),
(41, 'Mr. Mendoza', 'Science', 'Grade 8', NULL),
(42, 'Mr. Gonzales', 'Math', 'Grade 8', NULL),
(43, 'Ms. Lopez', 'English', 'Grade 8', NULL),
(44, 'Mrs. Dimaculangan', 'Filipino', 'Grade 8', NULL),
(45, 'Ms. Mercado', 'AP', 'Grade 8', NULL),
(46, 'Ms. Navarro', 'Science', 'Grade 9', NULL),
(47, 'Mr. Fernandez', 'Math', 'Grade 9', NULL),
(48, 'Ms. Cruz', 'English', 'Grade 9', NULL),
(49, 'Mrs. Santos', 'Filipino', 'Grade 9', NULL),
(50, 'Mr. Aquino', 'AP', 'Grade 9', NULL),
(51, 'Mrs. Ocampo', 'Science', 'Grade 10', NULL),
(52, 'Mr. Ramos', 'Math', 'Grade 10', NULL),
(53, 'Ms. Martinez', 'English', 'Grade 10', NULL),
(54, 'Ms. Villanueva', 'Filipino', 'Grade 10', NULL),
(55, 'Sir David', 'AP', 'Grade 10', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `makeup_slips`
--
ALTER TABLE `makeup_slips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `makeup_slips`
--
ALTER TABLE `makeup_slips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
