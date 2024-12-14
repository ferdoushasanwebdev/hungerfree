-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 05:43 PM
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
-- Database: `hungerfree`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_duration`) VALUES
(1, 'Fruits', 72),
(3, 'Vegetables', 72),
(4, 'Dairy Products', 48),
(5, 'Meat', 48),
(7, 'Cooked Food', 48);

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `feed_id` int(11) NOT NULL,
  `feed_user` int(11) DEFAULT NULL,
  `feed_post` int(11) DEFAULT NULL,
  `feed_rating` int(11) DEFAULT NULL,
  `feed_comment` varchar(255) DEFAULT NULL,
  `feed_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `hist_id` int(11) NOT NULL,
  `hist_post` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `not_id` int(11) NOT NULL,
  `not_sender` int(11) DEFAULT NULL,
  `not_receiver` int(11) NOT NULL,
  `not_post` int(11) NOT NULL,
  `not_type` varchar(10) DEFAULT NULL,
  `not_read` tinyint(1) DEFAULT NULL,
  `not_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`not_id`, `not_sender`, `not_receiver`, `not_post`, `not_type`, `not_read`, `not_date`) VALUES
(1, 7, 10, 5, 'request', 1, '2024-12-12 14:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `post_food` varchar(20) DEFAULT NULL,
  `post_photo` varchar(255) DEFAULT NULL,
  `post_details` varchar(500) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_approved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `cat_id`, `post_food`, `post_photo`, `post_details`, `post_date`, `post_approved`) VALUES
(4, 5, 5, 'Burger', '__opt__aboutcom__coeus__resources.jpg', 'Please contact me as soon as possible.', '2024-11-27 01:59:42', 1),
(5, 10, 7, 'Rice', '507936866_6136178378001_6129561006001-vs-03eda158973046dcbab360b0a1644f71.jpg', 'Please contact me as soon as possible.', '2024-12-01 01:22:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `req_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `req_user` int(11) DEFAULT NULL,
  `req_receiver` int(11) NOT NULL,
  `req_accepted` tinyint(1) DEFAULT NULL,
  `req_donated` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`req_id`, `post_id`, `req_user`, `req_receiver`, `req_accepted`, `req_donated`) VALUES
(21, 5, 7, 10, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_address` varchar(255) DEFAULT NULL,
  `user_district` varchar(255) DEFAULT NULL,
  `user_division` varchar(255) NOT NULL,
  `user_photo` varchar(255) DEFAULT NULL,
  `user_file` varchar(255) DEFAULT NULL,
  `user_role` varchar(50) DEFAULT NULL,
  `user_approved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_phone`, `user_email`, `user_password`, `user_address`, `user_district`, `user_division`, `user_photo`, `user_file`, `user_role`, `user_approved`) VALUES
(1, 'Ferdous Hasan', '01678774794', 'ferdoushasan@gmail.com', '$2y$10$GnXP/H05Rh4AAs3Jl8Xv3OoMy5K5h0ZZsNbrmu.2DXUOuwfXuJdOO', 'Dhanmondi', 'Dhaka', 'Dhaka', 'ferdoushasan.png', 'Screenshot 2024-11-14 175929.png', 'admin', 1),
(5, 'Ferdous Hasan', '01678774795', 'ferdoushasan@gmail.com', '$2y$10$Kr0TQf25LPXuXyk0.PW/puhTLv2Pe.Zt3J7X1te6/NW0oGvR36zd2', 'Footpath', 'Moulvibazar', 'Sylhet', 'ferdoushasan.png', 'Screenshot 2024-11-14 175929.png', 'donor', 1),
(7, 'Food Foundation', '01678774797', 'foodfoundation@gmail.com', '$2y$10$ZSBuxttucTtEVVBEcGTlWOfp7JUdLQzmHayluQQ4n2qbi3pSccJci', '152/A', 'Gazipur', 'Dhaka', 'female-avater.jpg', 'Screenshot 2024-11-14 175929.png', 'recipient', 1),
(10, 'Fabiha Fayruj', '01678774796', 'fabiha@gmail.com', '$2y$10$hK5R3DfY8ZStHuMeyhkHre/n3nMLuo87fNu7ILFOwd.vJWSOuhsES', 'Footpath', 'Gazipur', 'Dhaka', 'female-avater.jpg', 'Screenshot 2024-11-14 175929.png', 'donor', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feed_id`),
  ADD KEY `feed_user` (`feed_user`),
  ADD KEY `feed_post` (`feed_post`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`hist_id`),
  ADD KEY `hist_post` (`hist_post`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`not_id`),
  ADD KEY `not_user` (`not_sender`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`req_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `req_user` (`req_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feed_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `hist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `not_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`feed_user`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `feedbacks_ibfk_2` FOREIGN KEY (`feed_post`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `histories`
--
ALTER TABLE `histories`
  ADD CONSTRAINT `histories_ibfk_1` FOREIGN KEY (`hist_post`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`not_sender`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`req_user`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
