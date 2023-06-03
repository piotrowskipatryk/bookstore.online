-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-server
-- Generation Time: Jun 03, 2023 at 12:48 PM
-- Server version: 8.0.19
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `iteminorder`
--

CREATE TABLE `iteminorder` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_sent` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `iteminorder`
--

INSERT INTO `iteminorder` (`id`, `order_id`, `product_id`, `quantity`, `price`, `is_sent`) VALUES
(8, 13, 1, 1, '39.99', 1),
(9, 13, 2, 1, '49.99', 1),
(10, 14, 3, 1, '29.39', 1),
(11, 15, 4, 1, '49.99', 1),
(12, 16, 2, 1, '49.99', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_value`) VALUES
(13, 1, '89.98'),
(14, 1, '29.39'),
(15, 1, '49.99'),
(16, 1, '49.99');

-- --------------------------------------------------------

--
-- Stand-in structure for view `order_table`
-- (See below for the actual view)
--
CREATE TABLE `order_table` (
`city` varchar(255)
,`first_name` varchar(255)
,`iteminorderid` int
,`itemtitle` varchar(255)
,`last_name` varchar(255)
,`order_id` int
,`postal_code` varchar(6)
,`price` decimal(10,2)
,`street` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `photo_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `photo_path`) VALUES
(1, 'Książka 1', '39.99', 'Książka 2 autorstwa XYZ. Przykładowy opis.', 'photos/1.jpg'),
(2, 'Książka 2', '29.99', 'Książka 2 autorstwa XYZ. Przykładowy opis.', 'photos/2.jpg'),
(3, 'Książka 3', '35.00', 'Książka 3 autorstwa XYZ. Przykładowy opis.', 'photos/3.jpg'),
(4, 'Książka 4', '49.95', 'Książka 4 autorstwa XYZ. Przykładowy opis.', 'photos/4.jpg'),
(5, 'Książka 5', '39.99', 'Książka 5 autorstwa XYZ. Przykładowy opis.', 'photos/5.jpg'),
(6, 'Książka 6', '24.99', 'Książka 6 autorstwa XYZ. Przykładowy opis.', 'photos/6.jpg'),
(7, 'Książka 7', '23.99', 'Książka 7 autorstwa XYZ. Przykładowy opis.', 'photos/7.jpg'),
(8, 'Książka 8', '19.99', 'Książka 8 autorstwa XYZ. Przykładowy opis.', 'photos/8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` varchar(6) NOT NULL,
  `is_staff` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `street`, `city`, `postal_code`, `is_staff`) VALUES
(1, 'Testowy', 'administrator', '9e38e8d688743e0d07d669a1fcbcd35b', 'admin@example.com', 'Testowa', 'Testowo', '01-410', 1),
(3, 'Testowy', 'użytkownik', '9e38e8d688743e0d07d669a1fcbcd35b', 'user@example.com', 'Testowa', 'Testowo', '01-410', 0);

-- --------------------------------------------------------

--
-- Structure for view `order_table`
--
DROP TABLE IF EXISTS `order_table`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `order_table`  AS  select `orders`.`id` AS `order_id`,`iteminorder`.`price` AS `price`,`iteminorder`.`id` AS `iteminorderid`,`users`.`first_name` AS `first_name`,`users`.`last_name` AS `last_name`,`users`.`street` AS `street`,`users`.`city` AS `city`,`users`.`postal_code` AS `postal_code`,`products`.`name` AS `itemtitle` from (((`orders` join `users` on((`orders`.`user_id` = `users`.`id`))) join `iteminorder` on((`iteminorder`.`order_id` = `orders`.`id`))) join `products` on(((`products`.`id` = `iteminorder`.`product_id`) and (`iteminorder`.`is_sent` = false)))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `iteminorder`
--
ALTER TABLE `iteminorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `iteminorder`
--
ALTER TABLE `iteminorder`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;