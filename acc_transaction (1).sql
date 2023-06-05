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
-- Table structure for table `acc_transaction`
--

CREATE TABLE `acc_transaction` (
  `ID` int(11) NOT NULL,
  `VNo` varchar(50) DEFAULT NULL,
  `VDate` date DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `account_no` varchar(30) DEFAULT NULL,
  `Narration` text DEFAULT NULL,
  `paytype` int(11) NOT NULL,
  `Debit` decimal(18,2) DEFAULT NULL,
  `Credit` decimal(18,2) DEFAULT NULL,
  `CreateBy` varchar(50) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acc_transaction`
--

INSERT INTO `acc_transaction` (`ID`, `VNo`, `VDate`, `account_id`, `account_no`, `Narration`, `paytype`, `Debit`, `Credit`, `CreateBy`, `CreateDate`, `UpdateBy`, `UpdateDate`) VALUES
(7, 'BM-1', '2023-06-06', 5, '1.01.001.0002', 'Testing one two', 2, '500.00', '0.00', '1', '2023-06-06 01:48:46', NULL, NULL),
(8, 'BM-1', '2023-06-06', 4, '1.01.001.0001', 'Testing one two', 2, '0.00', '500.00', '1', '2023-06-06 01:48:46', NULL, NULL),
(9, 'BR-1', '2023-06-06', 6, '1.01.001.0003', 'Testing', 1, '3000.00', '0.00', '1', '2023-06-06 02:02:49', NULL, NULL),
(10, 'CP-1', '2023-06-06', 5, '1.01.001.0002', 'Testing one', 1, '0.00', '500.00', '1', '2023-06-06 02:10:30', NULL, NULL),
(11, 'CP-1', '2023-06-06', 4, '1.01.001.0001', 'Testing one', 1, '500.00', '0.00', '1', '2023-06-06 02:10:30', NULL, NULL),
(12, 'CR-1', '2023-06-06', 5, '1.01.001.0002', 'Deposit ', 1, '5000.00', '0.00', '1', '2023-06-06 02:30:57', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acc_transaction`
--
ALTER TABLE `acc_transaction`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acc_transaction`
--
ALTER TABLE `acc_transaction`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
