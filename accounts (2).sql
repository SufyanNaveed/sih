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
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(5) NOT NULL,
  `level_id` int(11) NOT NULL,
  `level_no` varchar(20) NOT NULL,
  `account_no` varchar(35) NOT NULL,
  `name` varchar(100) NOT NULL,
  `adate` datetime NOT NULL,
  `balance` double DEFAULT NULL,
  `description` text DEFAULT NULL,
  `account_type` enum('Assets','Expenses','Income','Liabilities','Equity','Basic') NOT NULL DEFAULT 'Basic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `level_id`, `level_no`, `account_no`, `name`, `adate`, `balance`, `description`, `account_type`) VALUES
(4, 28, '1.01.001', '1.01.001.0001', 'PAID UP CAPITAL - MRS. TALAT KHAN', '2023-06-06 00:54:07', 49500, 'Testing First Account', 'Equity'),
(5, 28, '1.01.001', '1.01.001.0002', 'PAID UP CAPITAL - DR. RASHID LATIF KHAN', '2023-06-06 01:00:08', 5500, 'Testing Second Account', 'Equity'),
(6, 28, '1.01.001', '1.01.001.0003', 'PAID UP CAPITAL - DR. HAROON LATIF KHAN', '2023-06-06 01:00:40', 3000, 'Testing 3rd Account', 'Equity');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `acn` (`account_no`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
