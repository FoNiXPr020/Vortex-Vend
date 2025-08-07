-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 10:42 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alxportfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_verification`
--

CREATE TABLE `email_verification` (
  `id` int NOT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `verification_code` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `follower_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `followers`
--


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `seller_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('onsale','sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `views` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `name`, `description`, `price`, `quantity`, `created_at`, `updated_at`, `image`, `status`, `views`) VALUES
(32, 27, 'Be You Genial Cleanser', 'A gentle and effective face cleanser that removes makeup and impurities without stripping the skin of its natural oils.', 40.00, 1, '2024-06-05 16:53:14', '2024-06-05 16:53:14', 'http://localhost/assets/uploads/products/666097fabd437-1717606394.jpg', 'onsale', 2),
(33, 27, 'Protein Shaker Bottle', 'A highquality shaker bottle that is perfect for mixing your protein shakes and other supplements.', 10.00, 1, '2024-06-05 16:56:16', '2024-06-06 03:49:03', 'http://localhost/assets/uploads/products/666098b0e6112-1717606576.jpg', 'sold', 3),
(34, 27, 'Apple Watch Series 7', 'A sleek and stylish smartwatch that offers a wide range of features including fitness tracking health monitoring and mobile payments.', 300.00, 1, '2024-06-05 16:57:47', '2024-06-05 17:28:59', 'http://localhost/assets/uploads/products/6660990b4027c-1717606667.jpg', 'onsale', 3),
(35, 26, 'Cosmetic Set', 'A complete set of highquality cosmetics including a cleanser toner serum moisturizer and eye cream designed to nourish and protect your skin. ', 35.00, 1, '2024-06-05 16:59:04', '2024-06-05 16:59:04', 'http://localhost/assets/uploads/products/66609958b036e-1717606744.jpg', 'onsale', 2),
(36, 26, 'Chanel Coco Noir Perfume', 'A sophisticated and alluring fragrance for women with notes of black rose sandalwood and patchouli.', 120.00, 1, '2024-06-05 16:59:48', '2024-06-06 03:24:28', 'http://localhost/assets/uploads/products/666099847acca-1717606788.jpg', 'onsale', 4),
(37, 25, 'Nike Free Run 50', 'A lightweight and comfortable running shoe designed for a natural and flexible ride.', 400.00, 1, '2024-06-05 17:01:11', '2024-08-01 00:59:24', 'http://localhost/assets/uploads/products/666099d762e6f-1717606871.jpg', 'onsale', 4),
(38, 25, 'Solo3 W Headphone', 'Wireless headphones with a sleek design and powerful sound quality.', 90.00, 1, '2024-06-05 17:01:52', '2024-06-06 03:24:31', 'http://localhost/assets/uploads/products/66609a002af1f-1717606912.jpg', 'onsale', 3),
(39, 24, 'Carbon Fiber Road Bike', 'A highperformance road bike designed for speed and efficiency.', 900.00, 1, '2024-06-05 17:03:37', '2024-06-05 17:03:37', 'http://localhost/assets/uploads/products/66609a693a6c0-1717607017.jpg', 'onsale', 2),
(40, 24, 'Indoor Soccer Shoes', 'Durable and comfortable indoor soccer shoes with a stylish design.', 50.00, 1, '2024-06-05 17:04:29', '2024-06-05 17:04:29', 'http://localhost/assets/uploads/products/66609a9d0ed01-1717607069.jpg', 'onsale', 2),
(41, 23, 'Airoh Aviator 22 Helmet', ' A durable and protective motocross helmet with a sleek and modern design.', 60.00, 1, '2024-06-05 17:06:07', '2024-06-05 17:06:07', 'http://localhost/assets/uploads/products/66609affaf479-1717607167.jpg', 'onsale', 2),
(42, 23, 'Resilience CBD Bath Bombs', ' A luxurious and relaxing way to enjoy the benefits of CBD. Available in various scents to enhance your bath experience.', 400.00, 1, '2024-06-05 17:06:43', '2024-06-05 17:06:43', 'http://localhost/assets/uploads/products/66609b232f27c-1717607203.jpg', 'onsale', 2),
(43, 23, 'Rose Gold Watch', 'A sleek and stylish watch with a rose gold case and a black leather strap. The minimalist design features a white dial with a simple black hour and minute hand.', 50.00, 1, '2024-06-05 17:13:24', '2024-06-05 17:29:03', 'http://localhost/assets/uploads/products/66609cb47b7d0-1717607604.jpg', 'onsale', 3),
(44, 23, 'Hemp Seed Oil', 'A set of natural and organic products designed to cleanse and nourish the skin.', 45.00, 1, '2024-06-05 17:19:44', '2024-06-05 17:19:44', 'http://localhost/assets/uploads/products/66609e30d02e8-1717607984.jpg', 'onsale', 2),
(45, 24, 'Perfume and Skincare', 'A luxurious set of perfume and skincare products from Givenchy. The perfume is a delicate floral fragrance.', 60.00, 1, '2024-06-05 17:20:37', '2024-07-25 03:28:44', 'http://localhost/assets/uploads/products/66609e65e46fa-1717608037.jpg', 'onsale', 3),
(46, 24, 'Drawstring Cotton Bag', 'A durable and ecofriendly drawstring bag made from cotton. Perfect for carrying your essentials shopping or even using as a laundry bag.', 15.00, 1, '2024-06-05 17:21:27', '2024-06-05 17:28:52', 'http://localhost/assets/uploads/products/66609e9729293-1717608087.jpg', 'onsale', 3),
(47, 25, 'Classic Ink Pen', 'A beautiful and elegant ink and pen set that is perfect for the discerning writer. The set includes a traditional dip pen with a wooden handle and a bottle of highquality ink.', 50.00, 1, '2024-06-05 17:22:41', '2024-06-05 17:22:41', 'http://localhost/assets/uploads/products/66609ee13ad77-1717608161.jpg', 'onsale', 2),
(48, 25, 'CNoise Headphones', 'A highquality pair of wireless noisecanceling headphones that provide exceptional sound quality and a comfortable fit.', 45.00, 1, '2024-06-05 17:23:25', '2024-06-05 17:26:53', 'http://localhost/assets/uploads/products/66609f0deebbc-1717608205.jpg', 'onsale', 2),
(49, 26, 'Eltse Retro Headphones', 'A stylish and classic pair of headphones with a vintage look and feel. The headphones feature comfortable leather ear cups and a sturdy construction.', 35.00, 1, '2024-06-05 17:24:55', '2024-08-01 01:00:26', 'http://localhost/assets/uploads/products/66609f67e5cf9-1717608295.jpg', 'sold', 3),
(50, 26, 'Pantene ProV', 'A luxurious hair cream designed to deeply nourish and repair damaged hair. With a papaya scent it helps to revitalize and protect the hair from further damage.', 40.00, 1, '2024-06-05 17:26:01', '2024-06-06 03:23:38', 'http://localhost/assets/uploads/products/66609fa9ea812-1717608361.jpg', 'onsale', 3),
(51, 27, 'Lumix Micro Camera', 'A versatile and powerful camera designed for photographers and videographers alike. The camera features a highresolution sensor and a wide range of shooting modes', 300.00, 1, '2024-06-05 17:28:39', '2024-06-06 03:43:14', 'http://localhost/assets/uploads/products/6660a0473adcd-1717608519.jpg', 'sold', 6),
(52, 21, 'RayBan Clubmaster', 'A classic and timeless pair of sunglasses with a unique design that is perfect for both men and women.', 65.00, 1, '2024-06-05 17:30:23', '2024-06-05 17:30:23', 'http://localhost/assets/uploads/products/6660a0afa2804-1717608623.jpg', 'onsale', 2),
(53, 21, 'Natura Kreis CBD', 'Three bottles of highquality CBD oil from Natura Kreis. The oil is a fullspectrum extract meaning it contains all the beneficial cannabinoids found in the hemp plant', 33.00, 1, '2024-06-05 17:32:02', '2024-06-07 18:41:19', 'http://localhost/assets/uploads/products/6660a112ab3bc-1717608722.jpg', 'onsale', 4),
(54, 21, 'Leather Airpods', ' A luxurious and stylish leather case that protects your AirPods and adds a touch of sophistication to your tech accessories.', 99.00, 1, '2024-06-05 17:33:22', '2024-06-05 17:33:22', 'http://localhost/assets/uploads/products/6660a162381d5-1717608802.jpg', 'onsale', 2),
(56, 21, 'Camera', 'About Vortex Vend is a platform where you can sell and buy products....', 50.00, 1, '2024-07-04 20:05:45', '2024-07-25 03:29:20', 'http://localhost/assets/uploads/products/6687009908b1d-1720123545.jpg', 'onsale', 3);

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE `reset_password` (
  `id` int NOT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reset_password`
--


-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int NOT NULL,
  `buyer_id` int NOT NULL,
  `seller_id` int NOT NULL,
  `product_id` int NOT NULL,
  `token` varchar(32) NOT NULL,
  `payer_id` varchar(32) NOT NULL,
  `transaction_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `auth_id` varchar(60) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `age` varchar(10) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `role` varchar(32) NOT NULL DEFAULT 'guest',
  `profile_img` varchar(255) DEFAULT NULL,
  `profile_bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `status` enum('public','private') NOT NULL,
  `customers_status` enum('public','private') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `followers_status` enum('public','private') NOT NULL,
  `following_status` enum('public','private') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `auth_id`, `username`, `email_address`, `first_name`, `last_name`, `phone_number`, `address`, `age`, `password`, `created_at`, `updated_at`, `verified`, `role`, `profile_img`, `profile_bio`, `status`, `customers_status`, `followers_status`, `following_status`) VALUES
(22, NULL, 'EmmaSparke41', 'emma.holloway@example.com', 'Emma', 'Holloway', NULL, NULL, NULL, '$2y$10$IRfEe.dsCDVg8CyWJPmd3ODR8sSrrdr0Iv8mw7Im0O20q/DApvlqS', '2024-06-05 17:20:37', '2024-06-05 16:35:01', 0, 'guest', 'http://localhost/assets/uploads/profiles/EmmaSparke41-666093b522fe5-1717605301.jpg', 'Vortex Vend is a platform where you can sell and buy products', 'public', 'public', 'public', 'public'),
(23, NULL, 'LiamVoyager420', 'liam.dempsey@example.com', 'Liam', 'Dempsey', NULL, NULL, NULL, '$2y$10$vu.LyROXdFL8fF3TY0gLjugTF/fgHdIa.kAS0yuEAPnwKYtUjgJB.', '2024-06-05 17:36:00', '2024-06-05 16:36:25', 0, 'guest', 'http://localhost/assets/uploads/profiles/LiamVoyager420-6660940932089-1717605385.jpg', 'Vortex Vend is a platform where you can sell and buy products', 'public', 'public', 'public', 'public'),
(24, NULL, 'AvaWhisper10a4', 'ava.chandler@example.com', 'Ava', 'Chandler', NULL, NULL, NULL, '$2y$10$ZtqtfAIneHnBwyzRVYS7dOrerRs2U9eS7gfmGdUxLJHK5VkL/WVP6', '2024-06-05 17:36:52', '2024-06-05 16:37:40', 0, 'guest', 'http://localhost/assets/uploads/profiles/AvaWhisper10a4-66609454a9f91-1717605460.jpg', 'Vortex Vend is a platform where you can sell and buy products', 'public', 'public', 'public', 'public'),
(25, NULL, 'NoahMaverick40', 'noah.sinclair@example.com', 'Noah', 'Sinclair', NULL, NULL, NULL, '$2y$10$nHHhoO0SJfBf4EbY6WsShODMMH9p7fnJShh.HNxCIbdvpVBJuUUBu', '2024-06-05 17:38:21', '2024-06-05 16:42:17', 0, 'guest', 'http://localhost/assets/uploads/profiles/NoahMaverick40-66609569b90df-1717605737.jpg', 'Vortex Vend is a platform where you can sell and buy products', 'public', 'public', 'public', 'public'),
(26, NULL, 'MiaDreamer155', 'mia.bennett@example.com', 'Mia', 'Bennett', NULL, NULL, NULL, '$2y$10$os25tfX7p7D2Yh/ncVzl4u4c7RmyIoBVr6X48NjdpjT3fBemz5AYG', '2024-06-05 17:39:37', '2024-06-05 16:40:16', 0, 'guest', 'http://localhost/assets/uploads/profiles/MiaDreamer155-666094f09a4fa-1717605616.jpg', 'Vortex Vend is a platform where you can sell and buy products', 'public', 'public', 'public', 'public'),
(27, NULL, 'EthanEcho99', 'ethan.caldwell@example.com', 'Ethan', 'Caldwell', NULL, NULL, NULL, '$2y$10$D7PaCB5xpNvyvoeyG5IkDudyqnBPwYaaFGzRn2sUwkYf9mlMrBca2', '2024-06-05 17:40:44', '2024-06-05 16:42:58', 0, 'guest', 'http://localhost/assets/uploads/profiles/EthanEcho99-666095922a974-1717605778.jpg', 'Vortex Vend is a platform where you can sell and buy products', 'public', 'public', 'public', 'public'),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_follow` (`user_id`,`follower_id`),
  ADD KEY `follower_id` (`follower_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_verification`
--
ALTER TABLE `email_verification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
