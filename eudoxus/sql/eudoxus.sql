-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2017 at 07:09 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eudoxus`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(4) NOT NULL,
  `title` varchar(30) NOT NULL,
  `semester` int(1) NOT NULL,
  `points` int(2) NOT NULL,
  `lesson` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `semester`, `points`, `lesson`) VALUES
(1, 'C se vathos', 1, 15, 'C'),
(2, 'C gia arxarious', 1, 15, 'C'),
(3, 'Eisagogh sthn plhroforia', 1, 15, 'Eisagogh_sthn_Plhroforikh'),
(4, 'Plhroforikh', 1, 15, 'Eisagogh_sthn_Plhroforikh'),
(5, 'Vasikoi Algorithmikh', 1, 15, 'Algorithmikh'),
(6, 'Algorithmikes Ennoies', 1, 15, 'Algorithmikh'),
(7, 'Mathimatika kai Matlab', 1, 15, 'Mathimatika'),
(8, 'Mathimatikh poluplokothta', 1, 15, 'Mathimatika'),
(9, 'Vaseis C++ ', 2, 15, 'C++'),
(10, 'C++ gia arxarious', 2, 15, 'C++'),
(11, 'Diakrites Ennoies', 2, 15, 'Diakrita Mathimatika'),
(12, 'Logikh kai Mathimatika', 2, 15, 'Diakrita Mathimatika'),
(13, 'Domes Dedomenwn', 2, 15, 'Domes Dedomenwn'),
(14, 'Vasikes Domes', 2, 15, 'Domes Dedomenwn'),
(15, 'Psifiaka Systhmata', 2, 15, 'Psifiakh Sxediash'),
(16, 'Psifiakh Sxediash', 2, 15, 'Psifiakh Sxediash'),
(17, 'Vaseis gia arxarious', 3, 15, 'Vaseis 1'),
(18, 'Vaseis SQL', 3, 15, 'Vaseis 1'),
(19, 'Diktya & Epikoinonies', 3, 15, 'Diktya 1'),
(20, 'Vasikes Ennoies Diktuwn', 3, 15, 'Diktya 1'),
(21, 'Leitourgika Systhmata 1', 3, 15, 'Leitourgika 1'),
(22, 'Leitourgikothta upologistwn', 3, 15, 'Leitourgika 1'),
(23, 'Arxitektonikes H/Y', 3, 15, 'Arxitektonikh H/Y'),
(24, 'Arxitektonikh kai upologistes', 3, 15, 'Arxitektonikh H/Y'),
(25, 'Leitourgika Systhmata 2', 4, 15, 'Leitourgika 2'),
(26, 'Leitourgikothta h/y 2', 4, 15, 'Leitourgika 2'),
(27, 'Vaseis gia proxorhmenous', 4, 15, 'Vaseis 2'),
(28, 'Vaseis Oracle', 4, 15, 'Vaseis 2'),
(29, 'Diadiktuosh 2', 4, 15, 'Diktya 2'),
(30, 'Thlepikoinonies', 4, 15, 'Diktya 2'),
(31, 'Java basics', 4, 15, 'JAVA'),
(32, 'Java gia arxarious', 4, 15, 'JAVA');

-- --------------------------------------------------------

--
-- Table structure for table `students_books`
--

CREATE TABLE `students_books` (
  `student_id` int(4) NOT NULL,
  `book_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students_books`
--

INSERT INTO `students_books` (`student_id`, `book_id`) VALUES
(1, 2),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `student_id` int(4) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(10) NOT NULL,
  `points` int(2) NOT NULL,
  `semester` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`student_id`, `name`, `password`, `points`, `semester`) VALUES
(1, 'root', 'root', 10, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `students_books`
--
ALTER TABLE `students_books`
  ADD PRIMARY KEY (`student_id`,`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `student_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
