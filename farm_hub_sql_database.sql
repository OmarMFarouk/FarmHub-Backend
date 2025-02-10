-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Feb 10, 2025 at 04:15 PM
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
-- Database: `farm_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `message_id` int(11) NOT NULL,
  `message_body` text NOT NULL,
  `message_type` varchar(255) NOT NULL,
  `message_status` varchar(255) NOT NULL,
  `message_roomId` varchar(255) NOT NULL,
  `message_userId` varchar(255) NOT NULL,
  `message_dateCreated` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`message_id`, `message_body`, `message_type`, `message_status`, `message_roomId`, `message_userId`, `message_dateCreated`) VALUES
(22, 'Hello There!', 'text', 'read', '1ea9d4aaddac41acaa7f8277e8770f47', '1', '2025-02-02 02:33 PM'),
(23, 'Hello', 'text', 'read', '1ea9d4aaddac41acaa7f8277e8770f47', '2', '2025-02-02 02:43 PM'),
(24, 'Hey', 'text', 'read', '1ea9d4aaddac41acaa7f8277e8770f47', '1', '2025-02-02 02:43 PM'),
(25, 'fine', 'text', 'read', '1ea9d4aaddac41acaa7f8277e8770f47', '2', '2025-02-02 02:43 PM'),
(26, 'how are you doing', 'text', 'read', '1ea9d4aaddac41acaa7f8277e8770f47', '1', '2025-02-02 02:43 PM'),
(27, 'how much is the price', 'text', 'read', '1ea9d4aaddac41acaa7f8277e8770f47', '1', '2025-02-02 02:44 PM'),
(28, '1000$', 'text', 'read', '1ea9d4aaddac41acaa7f8277e8770f47', '2', '2025-02-02 02:45 PM'),
(29, '?', 'text', 'read', '1ea9d4aaddac41acaa7f8277e8770f47', '1', '2025-02-02 02:45 PM');

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `room_uid` int(11) NOT NULL,
  `room_id` varchar(255) NOT NULL,
  `room_u1` varchar(255) NOT NULL,
  `room_u2` varchar(255) NOT NULL,
  `room_msgCount` varchar(255) NOT NULL,
  `room_unreadCount` varchar(255) NOT NULL,
  `room_lastMsg` text NOT NULL,
  `room_lastMsger` varchar(255) NOT NULL,
  `room_dateCreated` varchar(25) NOT NULL,
  `room_dateUpdated` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_rooms`
--

INSERT INTO `chat_rooms` (`room_uid`, `room_id`, `room_u1`, `room_u2`, `room_msgCount`, `room_unreadCount`, `room_lastMsg`, `room_lastMsger`, `room_dateCreated`, `room_dateUpdated`) VALUES
(1, '1ea9d4aaddac41acaa7f8277e8770f47', '1', '2', '33', '33', '?', '1', '2025-01-25 1:10 AM', '2025-02-02 02:45 PM');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `file_link` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_referenceType` varchar(255) NOT NULL,
  `file_referenceId` varchar(255) NOT NULL,
  `file_status` varchar(255) NOT NULL,
  `file_dateCreated` varchar(25) NOT NULL,
  `file_dateUpdated` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `file_link`, `file_type`, `file_referenceType`, `file_referenceId`, `file_status`, `file_dateCreated`, `file_dateUpdated`) VALUES
(1, 'http://192.168.1.10/farm_hub/media/insights/1-Frame 599 (3).png', 'image', 'insight', '1', 'active', '2025-01-27 03:52 AM', '2025-01-27 03:52 AM'),
(2, 'http://192.168.1.10/farm_hub/media/listings/1-Frame 599 (4).png', 'image', 'listing', '1', 'active', '2025-01-27 03:52 AM', '2025-01-27 03:52 AM');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `follow_id` int(11) NOT NULL,
  `follow_byUserId` varchar(255) NOT NULL,
  `follow_toUserId` varchar(255) NOT NULL,
  `follow_dateCreated` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insights`
--

CREATE TABLE `insights` (
  `insight_id` int(11) NOT NULL,
  `insight_title` text NOT NULL,
  `insight_body` text NOT NULL,
  `insight_status` varchar(25) NOT NULL,
  `insight_likes` varchar(255) NOT NULL,
  `insight_views` varchar(255) NOT NULL,
  `insight_shares` varchar(255) NOT NULL,
  `insight_comments` varchar(255) NOT NULL,
  `insight_userId` varchar(255) NOT NULL,
  `insight_dateCreated` varchar(25) NOT NULL,
  `insight_dateUpdated` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insights`
--

INSERT INTO `insights` (`insight_id`, `insight_title`, `insight_body`, `insight_status`, `insight_likes`, `insight_views`, `insight_shares`, `insight_comments`, `insight_userId`, `insight_dateCreated`, `insight_dateUpdated`) VALUES
(1, 'First insight !!', 'First test on yofarm app!! \\nInsights', 'active', '1', '3', '2', '1', '1', '2025-01-27 03:52 AM', '2025-01-27 03:52 AM');

-- --------------------------------------------------------

--
-- Table structure for table `insights_comments`
--

CREATE TABLE `insights_comments` (
  `comment_id` int(11) NOT NULL,
  `comment_body` text NOT NULL,
  `comment_userId` varchar(255) NOT NULL,
  `comment_likes` varchar(255) NOT NULL,
  `comment_status` varchar(25) NOT NULL,
  `comment_insightId` varchar(255) NOT NULL,
  `comment_dateCreated` varchar(25) NOT NULL,
  `comment_dateUpdated` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insights_comments`
--

INSERT INTO `insights_comments` (`comment_id`, `comment_body`, `comment_userId`, `comment_likes`, `comment_status`, `comment_insightId`, `comment_dateCreated`, `comment_dateUpdated`) VALUES
(5, '121t', '1', '0', 'active', '178', '2025-01-26 07:38 PM', '2025-01-26 07:38 PM'),
(6, 'ghb GF dfghjbb hi', '1', '1', 'active', '178', '2025-01-26 07:39 PM', '2025-01-26 07:39 PM'),
(7, 'dsad', '1', '0', 'active', '178', '2025-01-26 07:41 PM', '2025-01-26 07:41 PM'),
(8, '121r', '1', '0', 'active', '178', '2025-01-26 07:42 PM', '2025-01-26 07:42 PM'),
(9, '121', '1', '1', 'active', '178', '2025-01-26 07:42 PM', '2025-01-26 07:42 PM'),
(10, 'sdas', '1', '0', 'active', '178', '2025-01-26 07:46 PM', '2025-01-26 07:46 PM'),
(11, 'Hello Niuggas', '1', '0', 'active', '178', '2025-01-27 03:16 AM', '2025-01-27 03:16 AM'),
(12, '1', '1', '1', 'active', '178', '2025-01-27 03:17 AM', '2025-01-27 03:17 AM'),
(13, 'tt', '1', '0', 'active', '178', '2025-01-27 03:18 AM', '2025-01-27 03:18 AM'),
(14, '1212121r', '1', '0', 'active', '178', '2025-01-27 03:18 AM', '2025-01-27 03:18 AM'),
(15, 'y', '1', '0', 'active', '178', '2025-01-27 03:18 AM', '2025-01-27 03:18 AM'),
(16, 'dry', '1', '0', 'active', '178', '2025-01-27 03:19 AM', '2025-01-27 03:19 AM'),
(17, 'r', '1', '0', 'active', '178', '2025-01-27 03:19 AM', '2025-01-27 03:19 AM'),
(18, 'u', '1', '0', 'active', '178', '2025-01-27 03:19 AM', '2025-01-27 03:19 AM'),
(19, 'q', '1', '0', 'active', '178', '2025-01-27 03:19 AM', '2025-01-27 03:19 AM'),
(20, '1', '1', '0', 'active', '1', '2025-01-27 03:35 AM', '2025-01-27 03:35 AM'),
(21, '12', '1', '0', 'active', '1', '2025-01-27 03:35 AM', '2025-01-27 03:35 AM'),
(22, '12', '1', '1', 'active', '1', '2025-01-27 03:35 AM', '2025-01-27 03:35 AM'),
(23, '1', '1', '1', 'active', '1', '2025-01-27 03:38 AM', '2025-01-27 03:38 AM'),
(24, 'Hello There', '1', '1', 'active', '1', '2025-01-27 03:53 AM', '2025-01-27 03:53 AM');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `like_referenceType` varchar(255) NOT NULL,
  `like_referenceId` varchar(255) NOT NULL,
  `like_userId` varchar(255) NOT NULL,
  `like_dateCreated` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `like_referenceType`, `like_referenceId`, `like_userId`, `like_dateCreated`) VALUES
(4, 'comment', '24', '1', '2025-01-27 03:53 AM'),
(5, 'insight', '1', '1', '2025-01-27 05:55 PM');

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `listing_id` int(11) NOT NULL,
  `listing_title` text NOT NULL,
  `listing_body` text NOT NULL,
  `listing_price` varchar(255) NOT NULL,
  `listing_status` varchar(25) NOT NULL,
  `listing_views` varchar(255) NOT NULL,
  `listing_shares` varchar(255) NOT NULL,
  `listing_userId` varchar(255) NOT NULL,
  `listing_dateCreated` varchar(25) NOT NULL,
  `listing_DateUpdated` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`listing_id`, `listing_title`, `listing_body`, `listing_price`, `listing_status`, `listing_views`, `listing_shares`, `listing_userId`, `listing_dateCreated`, `listing_DateUpdated`) VALUES
(1, 'Cows', 'Highest quality cows available in the region', '20000-50000', 'active', '3', '7', '2', '2025-01-27 03:52 AM', '2025-01-27 03:52 AM');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_fullName` varchar(255) NOT NULL,
  `user_orgName` varchar(255) NOT NULL,
  `user_phone` varchar(25) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_location` varchar(255) NOT NULL,
  `user_hwid` varchar(255) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `user_avatar` varchar(255) NOT NULL,
  `user_followingCount` varchar(255) NOT NULL,
  `user_followCount` varchar(255) NOT NULL,
  `user_dateCreated` varchar(25) NOT NULL,
  `user_dateLastAccess` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_fullName`, `user_orgName`, `user_phone`, `user_email`, `user_password`, `user_location`, `user_hwid`, `user_ip`, `user_avatar`, `user_followingCount`, `user_followCount`, `user_dateCreated`, `user_dateLastAccess`) VALUES
(1, 'AhmedMessi', 'Ahmed Atef', 'Ahmed Atef Farms', '011559944', 'AhmedMessi@gmail.com', '$2y$10$jjuaLodw0TYt7t4ZEz6dluaEZmDwRZh0e41/0F0yqE8H/c2vaDRGi', 'Cairo, Egypt', '1122e4e19bc3e3ff', '192.168.1.10', 'http://192.168.1.10/farm_hub/media/avatars/user_1.jpeg', '800', '1500', '2025-01-27 03:51 AM', '2025-01-27 03:51 AM'),
(2, 'o.m200233', 'Omar Farouk', 'Fero Farms', '01122195310', 'o.m200233@gmail.com', '$2y$10$jjuaLodw0TYt7t4ZEz6dluaEZmDwRZh0e41/0F0yqE8H/c2vaDRGi', 'Cairo, Egypt', '1122e4e19bc3e3ff', '', '', '50', '120', '2025-01-27 03:51 AM', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`room_uid`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`follow_id`);

--
-- Indexes for table `insights`
--
ALTER TABLE `insights`
  ADD PRIMARY KEY (`insight_id`);

--
-- Indexes for table `insights_comments`
--
ALTER TABLE `insights_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`listing_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `room_uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insights`
--
ALTER TABLE `insights`
  MODIFY `insight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insights_comments`
--
ALTER TABLE `insights_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `listing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
