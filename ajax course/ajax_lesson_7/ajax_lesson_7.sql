-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2018 at 09:42 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `ajax_lesson_7`
--

CREATE TABLE `ajax_lesson_7` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajax_lesson_7`
--

INSERT INTO `ajax_lesson_7` (`id`, `name`, `pass`) VALUES
(1, 'as', 'ss'),
(2, 'asda', 'asd'),
(3, 'as', 'as'),
(4, 'dasf', 'dfasdf'),
(5, 'asdf', 'sadf'),
(6, 'asdf', 'asdfsadf'),
(7, 'as', 'as'),
(8, 'as', 'as'),
(9, 'asad', 'afaghn'),
(10, 'asdfas', 'eqtrqeg'),
(11, 'asd', 'asd'),
(12, 'asdfas', 'asdfsadf'),
(13, 'asd', 'sadfasdf'),
(14, 'asd', 'asdasd'),
(15, 'as', 'as'),
(16, 'dasdg', 'asd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ajax_lesson_7`
--
ALTER TABLE `ajax_lesson_7`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ajax_lesson_7`
--
ALTER TABLE `ajax_lesson_7`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
