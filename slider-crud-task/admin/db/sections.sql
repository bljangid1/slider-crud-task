-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2026 at 06:54 PM
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
-- Database: `wpoet_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` enum('Learning','Technology','Communication') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `tag`, `title`, `image`, `category`, `created_at`) VALUES
(1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Usability enhancement and Training for Transaction Portal for Customers', '6a05e5da40b58.jpg', 'Learning', '2026-05-14 15:10:18'),
(2, 'Voluptate ratione om', 'Voluptatem aut sed ptate ratioptate ratio', '6a05e5fc9df58.jpg', 'Technology', '2026-05-14 15:10:52'),
(3, 'Ut harum ex debitisnim inci', 'Magnam ut enim incidagnam ut enim inagnam ut enim in', '6a05e623911f6.jpg', 'Communication', '2026-05-14 15:11:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
