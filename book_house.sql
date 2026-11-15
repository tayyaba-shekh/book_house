-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2026 at 04:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_house`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `email`, `password`) VALUES
(101, 'taiba9158@gmail.com', '874890');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `b_id` int(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `author` varchar(25) NOT NULL,
  `per_day_price` varchar(25) NOT NULL,
  `status` varchar(25) NOT NULL,
  `location` varchar(25) NOT NULL,
  `cover` varchar(25) DEFAULT NULL,
  `uid` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `p_id` int(25) NOT NULL,
  `p_method` varchar(25) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `rentid` int(11) NOT NULL,
  `u_id` int(25) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `rent_id` int(25) NOT NULL,
  `start_date` varchar(25) NOT NULL,
  `end_date` varchar(25) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `u_id` int(25) NOT NULL,
  `b_id` int(25) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'rented'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_book`
--

CREATE TABLE `return_book` (
  `rid` int(11) NOT NULL,
  `return_date` varchar(25) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `rent_id` int(25) NOT NULL,
  `uid` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `u_id` int(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `adress` varchar(100) NOT NULL,
  `ph_no` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'approve',
  `profile_picture` varchar(150) NOT NULL DEFAULT 'uploads/avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `rentid` (`rentid`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`rent_id`),
  ADD KEY `u_id` (`u_id`,`b_id`),
  ADD KEY `b_id` (`b_id`);

--
-- Indexes for table `return_book`
--
ALTER TABLE `return_book`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `u_id` (`rent_id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `b_id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `p_id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rent`
--
ALTER TABLE `rent`
  MODIFY `rent_id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_book`
--
ALTER TABLE `return_book`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(25) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `u_id` FOREIGN KEY (`uid`) REFERENCES `user` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `rentid` FOREIGN KEY (`rentid`) REFERENCES `rent` (`rent_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `b_id` FOREIGN KEY (`b_id`) REFERENCES `book` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `u_id_` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `return_book`
--
ALTER TABLE `return_book`
  ADD CONSTRAINT `rent_id` FOREIGN KEY (`rent_id`) REFERENCES `rent` (`rent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uid` FOREIGN KEY (`uid`) REFERENCES `user` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
