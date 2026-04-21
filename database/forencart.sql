-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2026 at 08:50 AM
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
-- Database: `forencart`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `button_text`, `button_link`, `image`, `is_active`, `created_at`) VALUES
(2, 'Upgrade Your Style with Forencart', 'Discover premium fashion, footwear & accessories designed for everyday confidence.', 'Shop Now', 'pages/shop.php', '1769928985_banner01.jpg', 1, '2026-02-01 06:56:25'),
(3, 'Everything You Love, All in One Place', 'From latest fashion to must-have essentials — explore our full collection.', '🛒 Explore Collection', 'pages/shop.php', '1769929042_banner02.jpg', 1, '2026-02-01 06:57:22'),
(4, '⚡ Mega Sale Is Live!', 'Grab your favorites at unbeatable prices — limited time only. Keep Hurry up!', '💸 Grab Deals', 'pages/shop.php', '1769929072_banner03.jpg', 0, '2026-02-01 06:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `status`, `created_at`, `parent_id`) VALUES
(1, 'Electronics', 'electronics', 1, '2026-01-28 12:08:07', NULL),
(2, 'Fashion', 'fashion', 1, '2026-01-28 12:08:07', NULL),
(3, 'Jewellery', 'jewellery', 1, '2026-01-28 12:08:07', NULL),
(4, 'Home & Kitchen', 'home-kitchen', 1, '2026-01-28 12:08:07', NULL),
(5, 'Books', 'books', 1, '2026-01-28 12:08:07', NULL),
(6, 'Beauty', 'beauty', 1, '2026-01-28 12:08:07', NULL),
(7, 'Sports', 'sports', 1, '2026-01-28 12:08:07', NULL),
(8, 'Toys', 'toys', 1, '2026-01-28 12:08:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`, `status`) VALUES
(1, 'ForenCart', 'forencart@gamil.com', 'Hey Aman\r\nI am ForenCart.', '2026-03-31 11:00:56', 'read'),
(3, 'Aman', 'amandiwakar8630@gmail.com', 'Hey', '2026-04-01 05:34:04', 'unread'),
(4, 'Tee Tren', 'teetrenstore@gmail.com', 'Hey ForenCart', '2026-04-01 06:14:40', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `email_otp`
--

CREATE TABLE `email_otp` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` enum('percentage','fixed') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `title`, `type`, `value`, `start_date`, `end_date`, `status`, `category_id`) VALUES
(2, 'Beauty Sale', 'percentage', 10.00, '2026-03-25 11:48:00', '2026-03-25 11:48:00', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `offer_products`
--

CREATE TABLE `offer_products` (
  `id` int(11) NOT NULL,
  `offer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cancelled_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `order_cancellations`
--

CREATE TABLE `order_cancellations` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_item_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'active',
  `cancelled_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `otp_verifications`
--

CREATE TABLE `otp_verifications` (
  `id` int(11) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `attempts` int(11) DEFAULT 0,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(220) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_new` tinyint(1) DEFAULT 0,
  `is_best_seller` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tags` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `image`, `status`, `is_featured`, `is_new`, `is_best_seller`, `created_at`, `tags`) VALUES
(1, 4, 'Non-Stick Frying Pan', NULL, 'Durable non-stick frying pan designed for easy cooking and cleaning. Ideal for everyday kitchen use.', 999.00, 0, '1769612270_Non-Stick Frying Pan.jpg', 1, 0, 0, 0, '2026-01-28 14:57:50', NULL),
(2, 6, 'Hydrating Face Cream', NULL, 'A lightweight face cream that deeply moisturizes skin and keeps it soft and fresh all day. Suitable for daily use on all skin types.', 149.00, 0, '1769851660_Night Repair Cream.jpg', 1, 0, 0, 0, '2026-01-31 09:27:40', NULL),
(3, 6, 'Vitamin C Face Serum', NULL, 'This serum helps brighten skin tone and improve texture. Enriched with Vitamin C for a healthy and glowing look.', 199.00, 0, '1769851709_Face Scrub.jpg', 1, 0, 0, 0, '2026-01-31 09:28:29', NULL),
(4, 6, 'Herbal Face Wash', NULL, 'A gentle face wash that removes dirt and oil while maintaining skin’s natural moisture balance. Ideal for daily cleansing.', 199.00, 0, '1769851750_herbal face wash.jpg', 1, 0, 0, 0, '2026-01-31 09:29:10', NULL),
(5, 6, 'Matte Finish Lipstick', NULL, 'Long-lasting matte lipstick that provides rich color and smooth application. Perfect for everyday and party wear.', 199.00, 0, '1769851785_Matte Finish Lipstick.jpg', 1, 0, 0, 0, '2026-01-31 09:29:45', NULL),
(6, 6, 'Nourishing Hair Oil', NULL, 'Hair oil enriched with natural ingredients to strengthen roots and reduce hair fall. Makes hair shiny and healthy.', 89.00, 0, '1769851823_Nourishing Hair Oil.jpg', 1, 0, 0, 0, '2026-01-31 09:30:23', NULL),
(7, 6, 'Aloe Vera Gel', NULL, 'Pure aloe vera gel that soothes skin and provides instant hydration. Can be used on face, hair, and body.', 99.00, 0, '1769851861_Aloe Vera Gel.jpg', 1, 0, 0, 0, '2026-01-31 09:31:01', NULL),
(8, 6, 'Sunscreen SPF 50', NULL, 'High-protection sunscreen that shields skin from harmful UV rays. Lightweight and non-greasy formula.', 149.00, 0, '1769851898_Sunscreen SPF 50.jpg', 1, 0, 0, 0, '2026-01-31 09:31:38', NULL),
(9, 6, 'Moisturizing Body Lotion', NULL, 'Body lotion that deeply nourishes dry skin and keeps it smooth for long hours. Suitable for all seasons.', 299.00, 0, '1769851936_Moisturizing Body Lotion.jpg', 1, 0, 0, 0, '2026-01-31 09:32:16', NULL),
(10, 6, 'Charcoal Face Mask', NULL, 'A detoxifying face mask that removes impurities and excess oil. Leaves skin clean, fresh, and glowing.', 49.00, 0, '1769852029_Charcoal Face Mask.jpg', 1, 0, 0, 0, '2026-01-31 09:33:49', NULL),
(11, 6, 'Makeup Compact Powder', NULL, 'Compact powder that gives a smooth and even finish. Controls oil and keeps makeup intact for hours.', 99.00, 0, '1769852072_Makeup Compact Powder.jpg', 1, 0, 0, 0, '2026-01-31 09:34:32', NULL),
(12, 6, 'Rose Water Toner', NULL, 'Refreshing rose water toner that tightens pores and balances skin pH. Suitable for all skin types.', 99.00, 0, '1769852103_Rose Water Toner.jpg', 1, 0, 0, 0, '2026-01-31 09:35:03', NULL),
(13, 6, 'Anti-Dandruff Shampoo', NULL, 'Shampoo specially formulated to reduce dandruff and cleanse scalp deeply. Leaves hair soft and manageable.', 249.00, 0, '1769852145_Anti-Dandruff Shampoo.jpg', 1, 0, 0, 0, '2026-01-31 09:35:45', NULL),
(14, 6, 'Lip Balm', NULL, 'Hydrating lip balm that heals dry and chapped lips. Provides long-lasting moisture with a natural shine.', 29.00, 0, '1769852197_Lip Balm.jpg', 1, 0, 0, 0, '2026-01-31 09:36:37', NULL),
(15, 6, 'Makeup Remover Wipes', NULL, 'Soft wipes that gently remove makeup and impurities without irritating skin. Easy to use and travel-friendly.', 99.00, 0, '1769852235_Makeup Remover Wipes.jpg', 1, 0, 0, 0, '2026-01-31 09:37:15', NULL),
(16, 2, 'Men’s Casual T-Shirt', NULL, 'A comfortable cotton t-shirt designed for daily wear. Soft fabric with a modern fit for all-day comfort.', 599.00, 0, '1769852314_Men’s Casual T-Shirt.jpg', 1, 0, 0, 0, '2026-01-31 09:38:34', NULL),
(17, 2, 'Women’s Floral Kurti', NULL, 'Stylish floral kurti made with breathable fabric. Perfect for casual outings and daily wear.', 399.00, 0, '1769852355_Women’s Floral Kurti.jpg', 1, 0, 0, 0, '2026-01-31 09:39:15', NULL),
(18, 2, 'Men’s Slim Fit Jeans', NULL, 'Slim fit jeans with a modern look and durable fabric. Suitable for casual and semi-formal occasions.', 699.00, 0, '1769852392_Men’s Slim Fit Jeans.jpg', 1, 0, 0, 0, '2026-01-31 09:39:52', NULL),
(19, 2, 'Women’s Denim Jacket', NULL, 'Trendy denim jacket that adds a stylish layer to any outfit. Ideal for all seasons.', 1299.00, 0, '1769852437_Women’s Denim Jacket.jpg', 1, 0, 0, 0, '2026-01-31 09:40:37', NULL),
(20, 2, 'Men’s Formal Shirt', NULL, 'Classic formal shirt with a clean finish. Perfect for office wear and formal events.', 399.00, 0, '1769852473_Men’s Formal Shirt.jpg', 1, 0, 0, 0, '2026-01-31 09:41:13', NULL),
(21, 2, 'Women’s Cotton Saree', NULL, 'Lightweight cotton saree with elegant design. Comfortable for daily and festive wear.', 1300.00, 0, '1769852506_Women’s Cotton Saree.jpg', 1, 0, 0, 0, '2026-01-31 09:41:46', NULL),
(22, 2, 'Men’s Hooded Sweatshirt', NULL, 'Warm and cozy hoodie made from soft fabric. Ideal for winter wear and casual outings.', 799.00, 0, '1769852537_Men’s Hooded Sweatshirt.jpg', 1, 0, 0, 0, '2026-01-31 09:42:17', NULL),
(23, 2, 'Women’s Leggings', NULL, 'Stretchable leggings that provide a comfortable fit. Suitable for daily wear and workouts.', 499.00, 0, '1769852566_Women’s Leggings.jpg', 1, 0, 0, 0, '2026-01-31 09:42:46', NULL),
(24, 2, 'Men’s Casual Shoes', NULL, 'Durable casual shoes with a stylish design. Provides comfort and strong grip for daily use.', 899.00, 0, '1769852605_Men’s Casual Shoes.jpg', 1, 0, 0, 0, '2026-01-31 09:43:25', NULL),
(25, 2, 'Women’s Handbag', NULL, 'Spacious and stylish handbag with a modern design. Perfect for daily use and special occasions.', 999.00, 0, '1769852641_Women’s Handbag.jpg', 1, 0, 0, 0, '2026-01-31 09:44:01', NULL),
(26, 4, 'Stainless Steel Cookware Set', NULL, 'Premium stainless steel cookware set for daily cooking. Strong, long-lasting, and easy to maintain.', 499.00, 0, '1769852814_Stainless Steel Cookware Set.jpg', 1, 0, 0, 0, '2026-01-31 09:46:54', NULL),
(27, 4, 'Electric Kettle', NULL, 'Fast-boiling electric kettle with automatic shut-off feature. Perfect for tea, coffee, and instant meals.', 699.00, 0, '1769852848_Electric Kettle.jpg', 1, 0, 0, 0, '2026-01-31 09:47:28', NULL),
(28, 4, 'Kitchen Storage Containers', NULL, 'Airtight storage containers to keep food fresh and organized. Suitable for grains, snacks, and spices.', 299.00, 0, '1769852888_Kitchen Storage Containers.jpg', 1, 0, 0, 0, '2026-01-31 09:48:08', NULL),
(29, 4, 'Mixer Grinder', NULL, 'Powerful mixer grinder for blending, grinding, and mixing. Essential appliance for every modern kitchen.', 699.00, 0, '1769852924_Mixer Grinder.jpg', 1, 0, 0, 0, '2026-01-31 09:48:44', NULL),
(30, 4, 'Pressure Cooker', NULL, 'High-quality pressure cooker that cooks food faster and saves energy. Safe and easy to use.', 1999.00, 0, '1769924323_Pressure Cooker.jpg', 1, 0, 0, 0, '2026-02-01 05:38:43', NULL),
(31, 4, 'Kitchen Knife Set', NULL, 'Sharp and durable knife set for precise cutting. Designed for comfort and everyday cooking tasks.', 399.00, 0, '1769924389_Kitchen Knife Set.jpg', 1, 0, 0, 0, '2026-02-01 05:39:49', NULL),
(32, 4, 'Gas Stove Burner', NULL, 'Efficient gas stove burner with strong flame control. Suitable for daily cooking needs.', 2999.00, 0, '1769924504_Gas Stove Burner.jpg', 1, 0, 0, 0, '2026-02-01 05:41:44', NULL),
(33, 4, 'Water Bottle Set', NULL, 'Reusable water bottles made from safe material. Perfect for home, office, and travel use.', 1299.00, 0, '1769924547_Water Bottle Set.jpg', 1, 0, 0, 0, '2026-02-01 05:42:27', NULL),
(34, 5, 'Introduction to Computer Programming', NULL, 'A beginner-friendly book that explains programming concepts with simple examples. Ideal for students starting their coding journey.', 999.00, 0, '1769924754_Introduction to Computer Programming.jpg', 1, 0, 0, 0, '2026-02-01 05:45:55', NULL),
(35, 5, 'Data Structures and Algorithms', NULL, 'Comprehensive guide covering arrays, linked lists, stacks, and algorithms. Helpful for competitive programming and interviews.', 299.00, 0, '1769924807_Data Structures and Algorithms.jpg', 1, 0, 0, 0, '2026-02-01 05:46:47', NULL),
(36, 5, 'Web Development Basics', NULL, 'Covers HTML, CSS, and JavaScript fundamentals. Perfect for beginners who want to build responsive websites.', 290.00, 0, '1769924858_Web Development Basics.jpg', 1, 0, 0, 0, '2026-02-01 05:47:38', NULL),
(37, 5, 'Python Programming Handbook', NULL, 'Step-by-step guide to learning Python with practical examples. Suitable for students and aspiring developers.', 399.00, 0, '1769924942_Python Programming Handbook.jpg', 1, 0, 0, 0, '2026-02-01 05:49:02', NULL),
(38, 5, 'DBMS', NULL, 'Explains database concepts, SQL queries, and normalization. Useful for academic learning and real-world applications.', 499.00, 0, '1769925026_Database Management Systems.jpg', 1, 0, 0, 0, '2026-02-01 05:50:26', NULL),
(39, 5, 'Operating System Concepts', NULL, 'Covers core OS topics like processes, memory management, and file systems. Written in a student-friendly manner.', 180.00, 0, '1769925075_Operating System Concepts.jpg', 1, 0, 0, 0, '2026-02-01 05:51:15', NULL),
(40, 5, 'Computer Networks Essentials', NULL, 'An easy-to-understand book on networking fundamentals, protocols, and network models. Ideal for exam preparation.', 280.00, 0, '1769925139_Computer Networks Essentials.jpg', 1, 0, 0, 0, '2026-02-01 05:52:19', NULL),
(41, 5, 'Software Engineering Principles', NULL, 'Introduces software development life cycle, design models, and project management basics. Good for academic projects.', 399.00, 0, '1769925184_Software Engineering Principles.jpg', 1, 0, 0, 0, '2026-02-01 05:53:04', NULL),
(42, 5, 'Artificial Intelligence Basics', NULL, 'Explains AI concepts such as machine learning and expert systems in a simple and practical way.', 199.00, 0, '1769925233_Artificial Intelligence Basics.jpg', 1, 0, 0, 0, '2026-02-01 05:53:53', NULL),
(43, 5, 'Cyber Security Fundamentals', NULL, 'Covers basic cyber security concepts, threats, and protection techniques. Useful for students and beginners.', 99.00, 0, '1769925272_Cyber Security Fundamentals.jpg', 1, 0, 0, 0, '2026-02-01 05:54:32', NULL),
(44, 1, 'Wireless Bluetooth Headphones', NULL, 'High-quality wireless headphones with clear sound and deep bass. Comfortable design suitable for long listening hours.', 1299.00, 0, '1769925566_electronics-wireless-bluetooth-headphones-01.jpg', 1, 0, 0, 0, '2026-02-01 05:59:26', NULL),
(45, 1, 'Smart LED TV', NULL, 'Smart LED TV with HD display and built-in streaming apps. Delivers an immersive viewing experience.', 3999.00, 0, '1769925925_electronics-smart-led-tv-02.jpg', 1, 0, 0, 0, '2026-02-01 06:05:25', NULL),
(46, 1, 'Portable Bluetooth Speaker', NULL, 'Compact and powerful Bluetooth speaker with clear audio. Easy to carry and perfect for indoor and outdoor use.', 499.00, 0, '1769925964_electronics-portable-bluetooth-speaker-03.jpg', 1, 0, 0, 0, '2026-02-01 06:06:04', NULL),
(47, 1, 'Power Bank 20000mAh', NULL, 'High-capacity power bank for fast and reliable charging. Ideal for travel and daily smartphone use.', 1599.00, 0, '1769925994_electronics-power-bank-20000mah-04.jpg', 1, 0, 0, 0, '2026-02-01 06:06:34', NULL),
(48, 1, 'Wireless Mouse', NULL, 'Ergonomic wireless mouse with smooth cursor control. Suitable for office work and everyday computing.', 499.00, 0, '1769926021_electronics-wireless-mouse-05.jpg', 1, 0, 0, 0, '2026-02-01 06:07:01', NULL),
(49, 1, 'Smart Watch', NULL, 'Modern smart watch with fitness tracking and notification features. Stylish design for daily wear.', 2999.00, 0, '1769926050_electronics-smart-watch-06.jpg', 1, 0, 0, 0, '2026-02-01 06:07:30', NULL),
(50, 1, 'Wired Earphones', NULL, 'Lightweight wired earphones with clear sound quality. Ideal for calls, music, and online classes.', 1299.00, 1, '1769926090_electronics-wired-earphones-07.jpg', 1, 0, 0, 0, '2026-02-01 06:08:10', NULL),
(51, 1, 'Laptop Cooling Pad', NULL, 'Cooling pad designed to reduce laptop overheating. Improves performance and extends device life.', 999.00, 0, '1769926137_electronics-laptop-cooling-pad-08.jpg', 1, 0, 0, 0, '2026-02-01 06:08:57', NULL),
(52, 1, 'USB Flash Drive 64GB', NULL, 'High-speed USB flash drive for storing and transferring data. Compact and easy to carry.', 999.00, 0, '1769926163_electronics-usb-flash-drive-64gb-09.jpg', 1, 0, 0, 0, '2026-02-01 06:09:23', NULL),
(53, 1, 'Bluetooth Keyboard', NULL, 'Wireless Bluetooth keyboard with smooth keys and modern design. Suitable for laptops, tablets, and PCs.', 899.00, 0, '1769926183_electronics-bluetooth-keyboard-10.jpg', 1, 0, 0, 0, '2026-02-01 06:09:43', NULL),
(54, 3, 'Gold Plated Necklace Set', NULL, 'Elegant gold plated necklace set with matching earrings. Perfect for weddings, festivals, and special occasions.', 12999.00, 0, '1769926608_jewellery-gold-plated-necklace-set-01.jpg', 1, 0, 0, 0, '2026-02-01 06:16:48', NULL),
(55, 3, 'Silver Stud Earrings', NULL, 'Minimal silver stud earrings with a classy design. Suitable for daily wear and formal outfits.', 999.00, 0, '1769926646_jewellery-silver-stud-earrings-02.jpg', 1, 0, 0, 0, '2026-02-01 06:17:26', NULL),
(56, 3, 'Traditional Bridal Bangles', NULL, 'Beautiful traditional bangles designed for bridal and festive wear. Adds elegance to ethnic outfits.', 1299.00, 0, '1769926673_jewellery-bridal-bangles-set-03.jpg', 1, 0, 0, 0, '2026-02-01 06:17:53', NULL),
(57, 3, 'Diamond Style Ring', NULL, 'Stylish ring with a diamond-look design. Ideal for parties, engagements, and special events.', 2999.00, 0, '1769926724_jewellery-diamond-style-ring-04.jpg', 1, 0, 0, 0, '2026-02-01 06:18:44', NULL),
(58, 3, 'Kundan Choker Necklace', NULL, 'Premium kundan choker necklace crafted for royal looks. Perfect for weddings and ethnic functions.', 11999.00, 0, '1769926763_jewellery-kundan-choker-necklace-05.jpg', 1, 0, 0, 0, '2026-02-01 06:19:23', NULL),
(59, 3, 'Pearl Drop Earrings', NULL, 'Classic pearl drop earrings with a graceful finish. Suitable for traditional and modern outfits.', 1299.00, 0, '1769926798_jewellery-pearl-drop-earrings-06.jpg', 1, 0, 0, 0, '2026-02-01 06:19:58', NULL),
(60, 3, 'Men’s Stainless Steel Bracelet', NULL, 'Stylish stainless steel bracelet designed for men. Strong build with a modern and masculine look.', 299.00, 0, '1769926823_jewellery-mens-steel-bracelet-07.jpg', 1, 0, 0, 0, '2026-02-01 06:20:23', NULL),
(61, 3, 'Oxidized Silver Anklet', NULL, 'Traditional oxidized silver anklet with detailed design. Ideal for ethnic wear and daily use.', 699.00, 0, '1769926854_jewellery-oxidized-silver-anklet-08.jpg', 1, 0, 0, 0, '2026-02-01 06:20:54', NULL),
(62, 3, 'Mangalsutra Necklace', NULL, 'Elegant mangalsutra necklace with a modern touch. Designed for married women with a stylish look.', 599.00, 0, '1769926886_jewellery-mangalsutra-necklace-09.jpg', 1, 0, 0, 0, '2026-02-01 06:21:26', NULL),
(63, 3, 'Fashion Jewelry Combo Set', NULL, 'Complete fashion jewelry combo including necklace, earrings, and bangles. Perfect for gifting and occasions.', 1999.00, 0, '1769926913_jewellery-fashion-combo-set-10.jpg', 1, 0, 0, 0, '2026-02-01 06:21:53', NULL),
(64, 7, 'Cricket Bat (English Willow Style)', NULL, 'High-quality cricket bat designed for powerful shots and better grip. Suitable for practice and match play.', 2499.00, 0, '1769927022_sports-cricket-bat-01.jpg', 1, 0, 0, 0, '2026-02-01 06:23:42', NULL),
(65, 7, 'Cricket Leather Ball', NULL, 'Durable leather cricket ball with excellent swing and bounce. Ideal for training and professional matches.', 399.00, 0, '1769927082_sports-cricket-ball-02.jpg', 1, 0, 0, 0, '2026-02-01 06:24:42', NULL),
(66, 7, 'Football (Size 5)', NULL, 'Standard size football made from durable material. Suitable for outdoor practice and competitive play.', 899.00, 0, '1769927128_sports-football-size-5-03.jpg', 1, 0, 0, 0, '2026-02-01 06:25:28', NULL),
(67, 7, 'Badminton Racket', NULL, 'Lightweight badminton racket with strong frame and good balance. Perfect for beginners and intermediate players.', 1299.00, 0, '1769927167_sports-badminton-racket-04.jpg', 1, 0, 0, 0, '2026-02-01 06:26:07', NULL),
(68, 7, 'Badminton Shuttlecock Pack', NULL, 'Pack of durable shuttlecocks with stable flight performance. Suitable for regular practice sessions.', 499.00, 0, '1769927212_sports-shuttlecock-pack-05.jpg', 1, 0, 0, 0, '2026-02-01 06:26:52', NULL),
(69, 7, 'Yoga Mat (Non-Slip)', NULL, 'Non-slip yoga mat with cushioned surface for comfort. Ideal for yoga, meditation, and workouts.', 699.00, 0, '1769927253_sports-yoga-mat-06.jpg', 1, 0, 0, 0, '2026-02-01 06:27:33', NULL),
(70, 8, 'Remote Control Car', NULL, 'Fun remote control car with smooth controls and durable build. Perfect for kids and indoor play.', 1499.00, 0, '1769927336_toys-remote-control-car-01.jpg', 1, 0, 0, 0, '2026-02-01 06:28:56', NULL),
(71, 8, 'Soft Teddy Bear', NULL, 'Soft and cuddly teddy bear made from child-safe material. Ideal gift for kids and loved ones.', 799.00, 0, '1769927379_toys-soft-teddy-bear-02.jpg', 1, 0, 0, 0, '2026-02-01 06:29:39', NULL),
(72, 7, 'Building Blocks Set', NULL, 'Colorful building blocks set that helps improve creativity and motor skills in children.', 1099.00, 0, '1769927423_toys-building-blocks-set-03.jpg', 1, 0, 0, 0, '2026-02-01 06:30:23', NULL),
(73, 8, 'Kids Puzzle Game', NULL, 'Engaging puzzle game that boosts problem-solving and logical thinking skills in kids.', 499.00, 0, '1769927477_toys-kids-puzzle-game-04.jpg', 1, 0, 0, 0, '2026-02-01 06:31:17', NULL),
(74, 8, 'Toy Train Set', NULL, 'Classic toy train set with tracks and realistic design. Provides hours of fun and imaginative play.', 1899.00, 0, '1769927530_toys-toy-train-set-05.jpg', 1, 0, 0, 0, '2026-02-01 06:32:10', NULL),
(75, 8, 'Mirana Mr. Robot', NULL, 'Smart Talkback with Voice Changer Feature: Mirana Mr. Robot repeats what your child says with a fun voice-changing twist, making conversations playful and boosting communication skills.\r\nDancing Robot with Built-in Music: Designed for joyful moments, this robot toy comes with preloaded songs and dance moves that keep kids entertained and grooving for hours.\r\nRechargeable via USB Type-C: No more hassle of replacing batteries. Mr. Robot features a USB Type-C rechargeable battery, making it both eco-friendly and easy to power up.\r\nColorful & Attractive Design: With a bright, eye-catching appearance and friendly look, Mr. Robot’s colorful design instantly grabs kids\' attention and keeps them coming back to play.\r\nFun Learning & Educational Play: More than just a toy, Mr. Robot encourages active learning, imaginative storytelling, and creativity, making it a smart pick for toddlers and young kids.\r\nPerfect Gift for Boys & Girls: Ideal for birthdays or special occasions, this smart robot toy is the best gift for boys and girls 2+ 3+ 4+ 5+ years, combining fun, music, and learning.\r\nMade in India – Safe & Durable: Proudly made in India using child-safe materials, this durable robot toy is designed for long-lasting fun and supports local manufacturing excellence.', 799.00, 0, '1775029824_toy.webp', 1, 0, 0, 0, '2026-04-01 07:49:34', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

CREATE TABLE `refunds` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `review_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mobile` varchar(15) DEFAULT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `mobile`, `otp_code`, `otp_expire`) VALUES
(1, 'Admin', 'admin@forencart.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, '2026-01-28 12:07:49', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_backup`
--

CREATE TABLE `users_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mobile` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_backup`
--

INSERT INTO `users_backup` (`id`, `name`, `email`, `password`, `phone`, `role`, `status`, `created_at`, `mobile`) VALUES
(1, 'Admin', 'admin@forencart.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'admin', 1, '2026-01-28 12:07:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_otp`
--
ALTER TABLE `email_otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_products`
--
ALTER TABLE `offer_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offer_id` (`offer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_cancellations`
--
ALTER TABLE `order_cancellations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `mobile_2` (`mobile`),
  ADD UNIQUE KEY `mobile_3` (`mobile`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `email_otp`
--
ALTER TABLE `email_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `offer_products`
--
ALTER TABLE `offer_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_cancellations`
--
ALTER TABLE `order_cancellations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `offer_products`
--
ALTER TABLE `offer_products`
  ADD CONSTRAINT `offer_products_ibfk_1` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`),
  ADD CONSTRAINT `offer_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
