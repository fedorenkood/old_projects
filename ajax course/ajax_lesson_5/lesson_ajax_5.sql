-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2018 at 10:16 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lesson_ajax`
--
CREATE DATABASE IF NOT EXISTS `lesson_ajax` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lesson_ajax`;

-- --------------------------------------------------------

--
-- Table structure for table `first_ajax_table`
--

CREATE TABLE `first_ajax_table` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `first_ajax_table`
--

INSERT INTO `first_ajax_table` (`id`, `name`, `description`) VALUES
(23, 'Name', 'here is a huge comment'),
(24, 'Name', 'Here is a huge comment'),
(25, 'Name', 'Here is a huge comment'),
(26, 'Name', 'Here is a huge comment'),
(27, 'Name', 'Here is a huge comment'),
(28, 'Name', 'Here is a huge comment'),
(29, 'Name', 'Here is a huge comment'),
(30, 'Name', 'Here is a huge comment'),
(31, 'Name', 'Here is a huge comment'),
(32, 'Name', 'Here is a huge comment'),
(33, 'Name', 'Here is a huge comment'),
(34, 'Name', 'Here is a huge comment'),
(35, 'Name', 'Here is a huge comment'),
(36, 'Name', 'Here is a huge comment'),
(37, 'Name', 'Here is a huge comment'),
(38, 'Name', 'Here is a huge comment'),
(39, 'Name', 'Here is a huge comment'),
(40, 'Name', 'Here is a huge comment'),
(41, 'Name', 'Here is a huge comment'),
(42, 'Name', 'Here is a huge comment'),
(43, 'Name', 'Here is a huge comment'),
(44, 'Name', 'Here is a huge comment'),
(45, 'Name', 'Here is a huge comment'),
(46, 'Name', 'Here is a huge comment'),
(47, 'Name', 'Here is a huge comment'),
(48, 'Name', 'Here is a huge comment'),
(49, 'Name', 'Here is a huge comment');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `first_ajax_table`
--
ALTER TABLE `first_ajax_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `first_ajax_table`
--
ALTER TABLE `first_ajax_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
