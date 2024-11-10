-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 06:44 PM
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
-- Database: `reviewmate`
--

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `user_id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `joined_on` date DEFAULT curdate(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `pfp_url` varchar(255) DEFAULT 'reviewmate\\assets\\images\\profile_picture\\default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`user_id`, `login_id`, `fname`, `lname`, `country`, `address`, `bio`, `joined_on`, `created_at`, `pfp_url`) VALUES
(1, 1, 'John', 'Doe', 'USA', '123 Main St, Anytown, USA', 'Movie enthusiast and blogger.', '2024-11-07', '2024-11-07 07:57:49', 'assets/images/profile_picture/default.png'),
(2, 2, 'Jane', 'Smith', 'Canada', '456 Maple Ave, Toronto, Canada', 'Film critic and writer.', '2024-11-07', '2024-11-07 07:57:49', 'assets/images/profile_picture/default.png'),
(3, 3, 'Bob', 'Brown', 'UK', '789 Oak Rd, London, UK', 'Aspiring filmmaker.', '2024-11-07', '2024-11-07 07:57:49', 'assets/images/profile_picture/default.png'),
(4, 4, 'Alice', 'White', 'Australia', '321 Pine St, Sydney, Australia', 'Cinema lover and reviewer.', '2024-11-07', '2024-11-07 07:57:49', 'assets/images/profile_picture/default.png'),
(5, 5, 'test', 'tes2', 'USA', '9 test street, test NSW 2154', 'lorem ipsum', '2024-11-07', '2024-11-07 08:02:29', 'assets/images/profile_picture/default.png'),
(6, 6, 'ritesh', 'dhungel', 'Australia', 'not saying st', 'This is a test data set', '2024-11-07', '2024-11-07 12:10:43', 'assets/images/profile_picture/default.png'),
(7, 7, 'ritesh', 'ritesh', 'ritesh', 'ritesh', 'ritesh', '2024-11-07', '2024-11-07 12:22:59', 'assets/images/profile_picture/default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `login_id` (`login_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD CONSTRAINT `userinfo_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `userlogin` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
