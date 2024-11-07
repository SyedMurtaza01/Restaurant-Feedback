-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2024 at 12:18 PM
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `rating`, `voice_note`, `created_at`) VALUES
(1, 'Okay', '', '2024-11-07 10:53:20'),
(2, 'Good', 'blob:http://localhost/311c8dd2-7685-48b6-970a-fc0533fccafe', '2024-11-07 10:54:53'),
(3, 'Okay', '', '2024-11-07 10:55:57'),
(4, 'Bad', 'blob:http://localhost/cfc77d1a-1159-44ca-9a63-ae3533fdfd9c', '2024-11-07 10:56:49'),
(5, 'Good', 'blob:http://localhost/cf34c37a-2b5d-462a-8d85-5c90627c4081', '2024-11-07 11:06:50'),
(6, 'Good', 'blob:http://localhost/c4fd8ff3-64b5-4e9c-a428-0b13f9c38d82', '2024-11-07 11:27:08'),
(7, 'Good', 'blob:http://localhost/41525128-8133-4fd4-9150-d547929d2317', '2024-11-07 11:27:27'),
(8, 'Good', 'blob:http://localhost/1e45aa07-98f2-41f8-9f69-5bbb779cea02', '2024-11-07 11:35:19');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
