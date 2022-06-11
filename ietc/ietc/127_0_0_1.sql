-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2018 at 11:13 AM
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
-- Database: `ietc`
--
CREATE DATABASE IF NOT EXISTS `ietc` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ietc`;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `lead` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_par` varchar(255) DEFAULT NULL,
  `second_par` varchar(255) DEFAULT NULL,
  `third_par` varchar(255) DEFAULT NULL,
  `fourth_par` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `lead`, `school`, `grade`, `phone`, `email`, `first_par`, `second_par`, `third_par`, `fourth_par`) VALUES
(24, 'Scdfv вавыа ывапы', 'фывавыап', '1-4', '+38 (222) 222-2222', 'sdsd@gh.dddd', 'выапвы рцкепрыв вавып', 'ыфваыф ыфваыфва фывыфа', '', ''),
(25, 'ВАМЫ ФЫВАФЫ ЫВАФЫ', 'ыфваыфв', '1-4', '+38 (111) 111-1111', 'sadfs@fgnb.dfvsd', 'ФЫВА ЫВА ФЫВАЫФВ', 'ЫФВАЫФВ ЫВАФЫВА ФЫВАЫФВА', '', ''),
(26, 'Asd Вапукп Укпуе', 'кйупйукпйци', '1-4', '+38 (555) 555-5555', 'sdvsa@dsv.sddddddd', 'Ыфапй Кп Й Йкп', 'Йцукп Фавмвапй Йцуа', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
