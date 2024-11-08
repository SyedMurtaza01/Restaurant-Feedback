-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2024 at 08:18 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `rating` varchar(255) NOT NULL,
  `voice_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mobile_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `rating`, `voice_note`, `created_at`, `mobile_number`) VALUES
(1, 'Okay', '', '2024-11-07 10:53:20', NULL),
(2, 'Good', 'blob:http://localhost/311c8dd2-7685-48b6-970a-fc0533fccafe', '2024-11-07 10:54:53', NULL),
(3, 'Okay', '', '2024-11-07 10:55:57', NULL),
(4, 'Bad', 'blob:http://localhost/cfc77d1a-1159-44ca-9a63-ae3533fdfd9c', '2024-11-07 10:56:49', NULL),
(5, 'Good', 'blob:http://localhost/cf34c37a-2b5d-462a-8d85-5c90627c4081', '2024-11-07 11:06:50', NULL),
(6, 'Good', 'blob:http://localhost/c4fd8ff3-64b5-4e9c-a428-0b13f9c38d82', '2024-11-07 11:27:08', NULL),
(7, 'Good', 'blob:http://localhost/41525128-8133-4fd4-9150-d547929d2317', '2024-11-07 11:27:27', NULL),
(8, 'Good', 'blob:http://localhost/1e45aa07-98f2-41f8-9f69-5bbb779cea02', '2024-11-07 11:35:19', NULL),
(9, 'Good', '', '2024-11-08 05:14:20', '4555555541235'),
(10, 'Good', '', '2024-11-08 05:17:06', '1111111222222'),
(11, 'Okay', '', '2024-11-08 05:33:59', '0231112222222'),
(12, 'Good', 'uploads/feedback_audio.wav', '2024-11-08 05:56:17', '0325849612'),
(13, 'Good', 'uploads/feedback_audio.wav', '2024-11-08 06:26:31', '0321654987'),
(14, 'Bad', 'uploads/feedback_audio.wav', '2024-11-08 06:30:57', '123456789123'),
(15, 'Good', 'uploads/feedback_audio.wav', '2024-11-08 06:33:30', '03422529464'),
(16, 'Good', 'uploads/feedback_audio.wav', '2024-11-08 06:34:48', '03132531960'),
(17, 'Bad', 'uploads/feedback_audio.wav', '2024-11-08 07:50:00', '03225456595');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
