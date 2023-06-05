-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2023 at 11:31 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sih`
--

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `level_no` varchar(20) NOT NULL,
  `level_name` varchar(200) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` int(11) NOT NULL,
  `created_by` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `level_no`, `level_name`, `parent_id`, `status`, `created_at`, `created_by`) VALUES
(25, '1', 'EQUITY AND RESERVES', 0, 1, 0, '2023-06-05 18:45:18'),
(27, '1.01', 'SHARE CAPITAL AND RESERVES', 25, 1, 0, '2023-06-05 18:48:47'),
(28, '1.01.001', 'SHARE CAPITAL', 27, 1, 0, '2023-06-05 18:52:13'),
(29, '1.01.002', 'SHARE PREMIUM RESERVE', 27, 1, 0, '2023-06-05 19:22:44'),
(31, '1.01.003', 'UNAPPROPRIATED PROFIT/(LOSS)', 27, 1, 0, '2023-06-05 19:25:22'),
(32, '1.01.004', 'REVALUATION RESERVES', 27, 1, 0, '2023-06-05 19:25:45'),
(33, '1.01.005', 'DIVIDEND', 27, 1, 0, '2023-06-05 19:26:12'),
(34, '2', 'NON CURRENT LIABILITIES', 0, 1, 0, '2023-06-05 19:26:30'),
(35, '2.01', 'LONG TERM LOANS SECURED', 34, 1, 0, '2023-06-05 19:26:57'),
(36, '2.01.001', 'LONG TERM LOANS SECURED - INTEREST BEARING', 35, 1, 0, '2023-06-05 19:27:29'),
(37, '2.01.002', 'LONG TERM LOANS SECURED - NON INTEREST BEARING', 35, 1, 0, '2023-06-05 19:27:52'),
(38, '2.02', 'LONG TERM LOANS UN SECURED', 34, 1, 0, '2023-06-05 19:28:06'),
(39, '2.02.001', 'LONG TERM LOANS UN SECURED - INTEREST BEARING', 38, 1, 0, '2023-06-05 19:28:35'),
(40, '2.02.002', 'LONG TERM LOANS UN SECURED - NON INTEREST BEARING', 38, 1, 0, '2023-06-05 19:28:45'),
(41, '2.03', 'LEASE LIABILITIES', 34, 1, 0, '2023-06-05 19:29:01'),
(42, '2.03.001', 'LEASE LIABILITIES - VEHICLES', 41, 1, 0, '2023-06-05 19:29:21'),
(43, '2.03.002', 'LEASE LIABILITIES - BUILDINGS', 41, 1, 0, '2023-06-05 19:29:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
