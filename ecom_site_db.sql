-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Dec 05, 2024 at 12:08 PM
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
-- Database: `ecomsite_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(250) NOT NULL,
  `admin_email` text NOT NULL,
  `admin_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
(1, 'alice', 'admin1@gmail.com', '7abdccbea8473767e91378e37850d296'),
(2, 'aaron', 'admin2@gmail.com', 'b9ea8bc466008ae3abd2e7165f7ec6bc');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_cost` decimal(6,2) NOT NULL,
  `order_status` varchar(100) NOT NULL DEFAULT 'on_hold',
  `user_id` int(11) NOT NULL,
  `user_phone` int(11) NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_cost`, `order_status`, `user_id`, `user_phone`, `user_city`, `user_address`, `order_date`) VALUES
(1, 25.00, 'paid', 1, 778575377, 'Colombo', 'A7, 345/8, Flower Road, Colombo 7', '2024-12-05 12:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `product_name`, `product_image`, `product_price`, `product_quantity`, `user_id`, `order_date`) VALUES
(1, 1, '3', 'Nike Workout Top', 'featured4.jpg', 25.00, 1, 1, '2024-12-05 12:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `details_id` varchar(250) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `user_id`, `details_id`, `payment_date`) VALUES
(1, 1, 1, '3X901050VR4967409', '2024-12-05 12:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_area` varchar(500) NOT NULL,
  `product_name` varchar(500) NOT NULL,
  `product_category` varchar(108) NOT NULL,
  `product_description` varchar(1000) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_image2` varchar(255) DEFAULT NULL,
  `product_image3` varchar(255) DEFAULT NULL,
  `product_image4` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_special_offer` int(2) DEFAULT NULL,
  `product_color` varchar(108) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_area`, `product_name`, `product_category`, `product_description`, `product_image`, `product_image2`, `product_image3`, `product_image4`, `product_price`, `product_special_offer`, `product_color`) VALUES
(1, 'Shoes (Men & Women)', 'Nike Running Shoes', 'shoe', 'A classic pair of shoes meant for both men and women to rock during the summer. What would it feel like to lace a pair of clouds to your feet? You\'ll never know, but we think the Nike Wear-all-day is pretty close. Featuring plush padding around the ankle, a thick, downy tongue and unbelievably soft foam underfoot, this sport-inspired shoe is the embodiment of comfort. Mesh on the upper adds breathability that lasts, while the rubber Waffle outsole gives you traction every day.', 'featured1.jpg', 'featured1_2.jpg', 'featured1_3.jpg', 'featured1_4.jpg', 150.00, 0, 'white'),
(2, 'Bags (Men & Women)', 'Nike Clove Edition Gym Bag', 'bag', 'A classic jet black Nike Clove edition gym bag', 'featured2.jpg', 'featured2.jpg', 'featured2.jpg', 'featured2.jpg', 180.00, 0, 'black'),
(3, 'Tops (Men)', 'Nike Workout Top', 'top', 'Nike Workout Top for Men in the colour Teal', 'featured4.jpg', 'featured4.jpg', 'featured4.jpg', 'featured4.jpg', 25.00, 0, 'teal'),
(4, 'Dresses (Women)', 'Floral Sunfire Dress', 'dresses_coats', 'Floral Sunfire Dress available in all international sizes for Women', 'Clothes1.jpg', 'Clothes1.jpg', 'Clothes1.jpg', 'Clothes1.jpg', 40.00, 0, 'white, brown, blue'),
(5, 'Dresses (Women)', 'Casual Celine Evening Dress', 'dresses_coats', 'Casual Celine Evening Dress in black and available in all international sizes', 'Clothes2.jpg', 'Clothes2.jpg', 'Clothes2.jpg', 'Clothes2.jpg', 200.00, 0, 'black'),
(6, 'Coats (Men)', 'Balmain Casual Fur Coat', 'dresses_coats', 'Balmain Casual Fur Coat for Men in Forest Green only!', 'Clothes3.jpg', 'Clothes3.jpg', 'Clothes3.jpg', 'Clothes3.jpg', 150.00, 0, 'forest green'),
(7, 'Coats (Men)', 'Fedora Luxury Cashmere Coat', 'dresses_coats', 'Fedora Luxury Cashmere Coat for Men', 'Clothes4.jpg', 'Clothes4.jpg', 'Clothes4.jpg', 'Clothes4.jpg', 200.00, 0, 'brown'),
(8, 'Watches (Men)', 'Premium Bulgari Leather Watch', 'watches', 'Premium Bulgari Leather Watch for Men', 'watches1.jpg', 'watches1.jpg', 'watches1.jpg', 'watches1.jpg', 230.00, 0, 'black'),
(9, 'Watches (Women)', 'Bulgari Gold Edition Watch', 'watches', 'Bulgari Gold Edition Watch for Women', 'watches2.jpg', 'watches2.jpg', 'watches2.jpg', 'watches2.jpg', 220.00, 0, 'gold'),
(10, 'Watches (Women)', 'Bulgari Charm Edition 1 Watch', 'watches', 'Bulgari Charm Edition 1 Watch for Teenagers', 'watches3.jpg', 'watches3.jpg', 'watches3.jpg', 'watches3.jpg', 190.00, 0, 'lavender'),
(11, 'Watches (Men)', 'Tetris Active Wear Watch', 'watches', 'Tetris Active Wear Watch for Men available in the colour forest green', 'watches4.jpg', 'watches4.jpg', 'watches4.jpg', 'watches4.jpg', 100.00, 0, 'sage'),
(12, 'Shoes (Women)', 'Celine Ballet Flats', 'shoes', 'Celine Ballet Flats for Women', 'shoes1.jpg', 'shoes1.jpg', 'shoes1.jpg', 'shoes1.jpg', 120.00, 0, 'lavender'),
(13, 'Shoes (Men)', 'Air Jordan Matte Edition Shoes', 'shoes', 'Air Jordan Matte Edition for Men', 'shoes2.jpg', 'shoes2.jpg', 'shoes2.jpg', 'shoes2.jpg', 200.00, 0, 'black'),
(14, 'Shoes (Women)', 'Converse 77 Shoes', 'shoes', 'Limited Edition Converse 77 Shoes', 'shoes3.jpg', 'shoes3.jpg', 'shoes3.jpg', 'shoes3.jpg', 90.00, 0, 'white'),
(15, 'Shoes (Men & Women)', 'Nike Hiking Edition 7 Shoes', 'shoes', 'Nike Hiking Edition 7 Shoes for both men and women', 'shoes4.jpg', 'shoes4.jpg', 'shoes4.jpg', 'shoes4.jpg', 100.00, 0, 'white and orange'),
(16, 'Watches (Men)', 'Coral Plazma Watch', 'watch', 'Coral Plazma Edition Watch for Men', 'featured3.jpg', 'featured3.jpg', 'featured3.jpg', 'featured3.jpg', 115.00, 0, 'black'),
(17, 'Tops (Women)', 'Aritzia Beige Blouse', 'tops', 'Limited edition linen blouse in the colour beige', 'featured5.jpg', 'featured5.jpg', 'featured5.jpg', 'featured5.jpg', 35.00, 0, 'beige'),
(18, 'Tops (Women)', 'Ellesse Crop Top', 'tops', 'Limited edition cotton crop top in the colour black', 'featured6.jpg', 'featured6.jpg', 'featured6.jpg', 'featured6.jpg', 20.00, 0, 'black'),
(19, 'Tops (Women)', 'Riders Casual Cotton T-shirt', 'tops', 'Riders Casual Cotton T-shirt for Summer', 'featured7.jpg', 'featured7.jpg', 'featured7.jpg', 'featured7.jpg', 20.00, 0, 'off-white'),
(20, 'Tops (Women)', 'Zara Skinny Crop Top', 'tops', 'Zara Skinny Crop Top for the summer', 'featured8.jpg', 'featured8.jpg', 'featured8.jpg', 'featured8.jpg', 15.00, 0, 'white with pink details'),
(21, 'Bags (Women)', 'Birkin Bag', 'bags', 'Premium Birkin Hand Bag in Leather', 'bag1_1.jpg', 'bag1_2.jpg', 'bag1_3.jpg', 'bag1_4.jpg', 180.00, 0, 'blue, red, black, grey');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(108) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(1, 'test', 'test@gmail.com', '$2y$10$DRjl6bAyzJsY4Wf1CxUDRuYxM/Lp4C0/hTfww7kX/fH4OTdC0DLD.'),
(2, 'amy', 'amy@gmail.com', '$2y$10$rIgUQrcfg4oy/fUm..yPC.uUC7f1a4Gvxjk5uBS6LSaTPwVgf177y'),
(3, 'brad', 'brad@gmail.com', '$2y$10$My6H6OWfSPt7./M58lUvzOspMcXFrN6sUR8p01xl/yfL4VGiTUkEW'),
(4, 'mary', 'mary@gmail.com', '$2y$10$4Ct7pe62SB4gjhpXSrVOiOE2UbXNGOBEUjiYFeYq5/N5zX.7zqzKO'),
(5, 'kevin', 'kevin@gmail.com', '$2y$10$U5uJrhEdtzloEtCQLMVzw.n/9mTVk6EPoVEkeQkafBqMDUa8F2Zva'),
(6, 'kaya', 'kaya@gmail.com', '$2y$10$NUji2/YcN7pfUHOe4zCfkOvWkyRPzSjDcAXcA1xT9r6y62Rn/O9rS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UX_Constraint` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
