-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2023 at 04:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog-system-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL DEFAULT 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و ',
  `banner` varchar(255) NOT NULL DEFAULT 'general.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`, `banner`) VALUES
(1, 'عمومی', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و', 'general.jpg'),
(2, 'ورزشی', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و ', 'sport.jpg'),
(3, 'سرگرمی', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و ', 'fun.png'),
(4, 'سرمایه گذاری', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و ', 'business.jpg'),
(5, 'طبیعت', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و ', 'nature.png'),
(6, 'تکنولوژی', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و', 'technology.jpg'),
(7, 'فرهنگی', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و ', 'calture.jpg'),
(8, 'هنری', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و ', 'art.jpg'),
(9, 'علمی', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و ', 'knowledge.jpg'),
(10, 'خوراکی', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و ', 'food.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(11, 1, 4),
(35, 1, 1),
(36, 1, 5),
(37, 1, 2),
(38, 1, 3),
(39, 1, 6),
(40, 1, 7),
(41, 6, 11),
(43, 6, 10),
(44, 6, 9),
(45, 6, 8),
(46, 6, 7),
(47, 6, 6),
(48, 6, 3),
(49, 6, 5),
(50, 4, 10),
(51, 4, 3),
(52, 4, 12),
(53, 4, 9),
(54, 4, 8),
(55, 4, 4),
(56, 3, 7),
(57, 3, 11),
(58, 3, 3),
(59, 3, 9),
(60, 3, 1),
(61, 3, 5),
(62, 5, 3),
(63, 5, 5),
(64, 5, 10),
(65, 5, 4),
(67, 2, 1),
(68, 2, 2),
(69, 2, 3),
(70, 2, 4),
(71, 2, 5),
(72, 2, 6),
(73, 2, 7),
(74, 2, 8),
(75, 2, 9),
(76, 2, 10),
(77, 2, 11),
(78, 2, 12),
(79, 6, 12);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `banner` varchar(255) NOT NULL DEFAULT 'post-default.jpg',
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `confirmation` smallint(6) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `view` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `title`, `content`, `author_id`, `banner`, `create_at`, `confirmation`, `likes`, `view`) VALUES
(1, 1, 'پست اول', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 1, 'post-default.jpg', '2023-08-15', 1, 3, 34),
(2, 2, 'پست دوم', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 3, 'post-2.jpg', '2023-08-16', 1, 2, 24),
(3, 3, 'پست سوم', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 4, 'post-3.jpg', '2023-08-17', 1, 6, 15),
(4, 4, 'پست چهارم', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 1, 'post-4.jpg', '2023-08-18', 1, 4, 76),
(5, 5, 'پست پنجم', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 2, 'post-5.jpg', '2023-08-19', 1, 5, 28),
(6, 6, 'پست ششم', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 5, 'post-6.jpg', '2023-08-20', 1, 3, 92),
(7, 7, 'پست هفتم', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 1, 'post-7.jpg', '2023-08-21', 1, 4, 28),
(8, 8, 'پست هشتم', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 4, 'post-8.jpg', '2023-08-22', 1, 3, 58),
(9, 9, 'پست نهم', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 3, 'post-9.jpg', '2023-08-23', 1, 4, 43),
(10, 10, 'پست دهم', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 5, 'post-10.jpg', '2023-08-24', 1, 4, 12),
(11, 5, 'پست یازدهم', 'لورم ایپسون متن ساز بی معنی و بدون مفهوم برای طراحان گرافیکی', 2, '20fe09cd01d2.jpg', '2023-08-27', 1, 3, 34),
(12, 5, 'پست دوازدهم', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 6, 'c6c7c29fbf5a.jpg', '2023-08-27', 1, 3, 21),
(13, 5, 'sfsdfsdf', 'sdfsdsdf', 6, '7b6a4d3f2bb6.jpg', '2023-08-28', 2, 0, 0),
(14, 5, 'دریا', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است.', 6, 'eb5563d7ed17.jpg', '2023-08-29', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_role` tinyint(1) NOT NULL DEFAULT 0,
  `show_name` varchar(100) NOT NULL DEFAULT 'کاربر سایت',
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'user.png',
  `joined_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_role`, `show_name`, `username`, `email`, `user_password`, `avatar`, `joined_date`) VALUES
(1, 1, 'ادمین', 'admin', 'admin@gmail.com', '1234', 'admin.png', '2023-08-24'),
(2, 0, 'محمد مهدی', 'mohamadmahdi', 'mohamadmahdi@gmail.com', '1234', 'user.png', '2023-08-25'),
(3, 0, 'رضا', 'reza', 'reza@gmail.com', '1234', 'reza.png', '2023-08-26'),
(4, 0, 'سارا', 'sara', 'sara@gmail.com', '1234', 'sara.jpg', '2023-08-27'),
(5, 0, 'محمد', 'mohamad', 'mohamad@gmail.com', '1234', 'mohamad.jpg', '2023-08-28'),
(6, 0, 'سهیل', 'soheil', 'soheil@gmail.com', '1234', 'soheil.jpg', '2023-08-29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
