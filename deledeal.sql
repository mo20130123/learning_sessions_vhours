-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2021 at 05:27 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deledeal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `lang` enum('en','ar') DEFAULT 'en',
  `jwt` varchar(225) DEFAULT NULL,
  `remember_token` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `phone` varchar(220) DEFAULT NULL,
  `super_admin` tinyint(1) NOT NULL DEFAULT 0,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `password`, `lang`, `jwt`, `remember_token`, `email`, `phone`, `super_admin`, `role_id`) VALUES
(1, 'admin', 'admin', '$2y$10$N8jJmfNjxWK9SIw00v69SOS1GnN/NzlCplJ6Hffc0Q53dgHg/fd8K', 'en', 'mmfMcIStxxZCEjAshDcWWUeR9FEhcy9DsaVtcYZarzf4G9n1Mbo1', 'V1lKQ4xa52kgWRRmZ6MKQTHVAjgW3wqWTqWGF8mVU0TQL54AXYQ7YfeReN8A', 't54r.kl@gmail.com', '201094943793', 1, 1),
(2, 'zayed', 'zayed', '$2y$10$N8jJmfNjxWK9SIw00v69SOS1GnN/NzlCplJ6Hffc0Q53dgHg/fd8K', 'en', 'mmfMcIStxxZCEjAshDcWWUeR9FEhcy9DsaVtcYZarzf4G9n1Mbo1', 'V1lKQ4xa52kgWRRmZ6MKQTHVAjgW3wqWTqWGF8mVU0TQL54AXYQ7YfeReN8A', 't54r.kl@gmail.com', '201094943793', 1, 1),
(7, 'Order 1', 'Test order 1', '$2y$10$Sltksz/wcxV7Dj8n/OjtSeXr06rlxyUmmHxL6qEUk0PYwDUec9zNi', 'en', 'qyZnWanFl6kqv2yzexah7bsrVS4c7OhmALq3mV6bh9vLvcDu0Zkt', NULL, 'hadeer.elshamy@vhorus.com', '011111070745', 0, 6),
(8, 'Test 2', 'Dispatched', '$2y$10$n2zJwqBeLNDhlEDRgX39iO512S6wGWc1zdiO1jCZj5qvEPLl01Y3G', 'en', '1MsxFUwYepfZlUk9zezRjOKk53o5Sx6XJXwmeHJqTcqpQufyHa8u', NULL, 'hadeer1601@gmail.com', '01111070745', 0, 7),
(9, 'Delivered', 'Order test', '$2y$10$f1MwTwhviF7sb6rYVDABjOs3SxeU9ApR3c54hC/1Q/Dkc2KvESJqq', 'en', 'u7c2O5dKEAsQC9wIi3mfpVhC3puyQFbbTd6rIagXby1KEQ825Rxm', NULL, 'hadeer1601@gmail.com', '01165413', 0, 8),
(10, 'ali', 'ali', '$2y$10$YxdfMYpFYDXD2ZN0P1XTFOIojiifBX4bDTTAmkgMvjOeqZMaYNDSe', 'en', 'PFsD3jRleQImDNYYVmQOO49r2EmhiUQ7ZIX1yCHsG35VbGuZdCqo', NULL, 'ali@.com', '3232323232', 0, 9),
(11, 'Yasmine Essam', 'Yasmine Essam', '$2y$10$ya1sttNS7k9DDlZmpXcxRej1zX/doaEdB8dYUQw4nw2XRfpYvdFJC', 'en', NULL, NULL, 'yasmine.essam@premiere-retail.com>', '01155030877', 0, 6),
(12, 'Marina', 'Marina', '$2y$10$L6IoF6ZMdvaXReFvJw2Xgur26IQSfODI/iGf4kkqTsVBMeHyy18zC', 'en', 'Tpcgcosww2Y2zPe3ESwdPrVg24ZDQvKaBZDbfFbbHreS0Ffat1M2', NULL, 'Marina.milad@premierefoodservices.com', '01101600917', 0, 6),
(13, 'Abdelrahman', 'Abdelrahman', '$2y$10$sUSLHnDiKV4JojQlgE8vm.qu8CifV8gpZCG405N57ekPNC.fjQhW.', 'en', 'AfDvBRz4glgwiNO13zPuO2yaShvKsWal09DhJ2haPtctvlpRV43M', NULL, 'abdelrahman.wasfy@premierefoodservices.com', '01156699868', 0, 6),
(14, 'Noha', 'Noha', '$2y$10$t3qmww1qrNzrQL2wxyTuxO6X7SWyQW/3WhFTFLX/T9B31VtvFTEi6', 'en', 'fEeee7NxlvzdFwd54EOyU8TsmYRkkgfpSkA8x0H2K9ae2Vn8fuZP', NULL, 'noha.tammam@premierefoodservices.com', '01142244322', 0, 6),
(15, 'Mina', 'Mina', '$2y$10$oiwU2hoMHzw5CwTYuBMiUeg9Cju7VJ2TTON6kRZgZQ1VRL5Y/Gq8m', 'en', 'GhkX6bKlammwUI5HSCzA0QjLVYbQV9paQg9L8slLyUoMWGKoMvkw', NULL, 'mina.adel@premierefoodservices.com', '01141223667', 0, 9);

-- --------------------------------------------------------

--
-- Table structure for table `ads_objectives`
--

CREATE TABLE `ads_objectives` (
  `id` int(11) NOT NULL,
  `name_en` varchar(225) NOT NULL,
  `name_ar` varchar(225) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ads_objectives`
--

INSERT INTO `ads_objectives` (`id`, `name_en`, `name_ar`, `position`, `status`) VALUES
(1, 'Reach', 'تصل', NULL, 1),
(2, 'Traffic', 'حركة المرور', NULL, 1),
(3, 'Engagement', 'الارتباط', NULL, 1),
(4, 'App Installs', 'عمليات تثبيت التطبيق', NULL, 1),
(5, 'Video Views', 'مشاهدات الفيديو', NULL, 1),
(6, 'Lead Generation', 'تقود الجيل', NULL, 1),
(7, 'Messages', 'الرسائل', NULL, 1),
(8, 'Conversions', 'التحويلات', NULL, 1),
(9, 'Catalog Sales', 'كتالوج المبيعات', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ads_products`
--

CREATE TABLE `ads_products` (
  `id` int(11) NOT NULL,
  `ads_objective_id` int(11) NOT NULL,
  `name_en` varchar(225) NOT NULL,
  `name_ar` varchar(225) NOT NULL,
  `placements` text NOT NULL,
  `price` int(11) DEFAULT NULL,
  `top_description_en` text DEFAULT NULL,
  `top_description_ar` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `description_ar` varchar(225) DEFAULT NULL,
  `youtube_link` varchar(225) DEFAULT NULL,
  `is_available` tinyint(4) NOT NULL DEFAULT 1,
  `rate` int(11) NOT NULL DEFAULT 0,
  `position` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ads_products`
--

INSERT INTO `ads_products` (`id`, `ads_objective_id`, `name_en`, `name_ar`, `placements`, `price`, `top_description_en`, `top_description_ar`, `description_en`, `description_ar`, `youtube_link`, `is_available`, `rate`, `position`, `status`) VALUES
(3, 1, 'Single Image', 'صورة واحدة', 'f,i,m', NULL, 'dd', 'ww', '22', '22', 'null', 1, 0, 40, 1),
(4, 1, 'Single Video', 'فيديو واحد', 'f,i,m', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 41, 1),
(5, 1, 'Carousel', 'دائري', 'f,i,m', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 42, 1),
(6, 1, 'Slideshow', 'عرض الشرائح', 'f,i,m', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 43, 1),
(7, 1, 'Collection', 'مجموعة', 'f,i,m', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 44, 1),
(8, 1, 'Instant Experience', 'تجربة فورية', 'f,i,m', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 45, 1),
(9, 2, 'Single Image', 'صورة واحدة', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 34, 1),
(10, 2, 'Single Video', 'فيديو واحد', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 35, 1),
(11, 2, 'Carousel', 'دائري', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 36, 1),
(12, 2, 'Slideshow', 'عرض الشرائح', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 37, 1),
(13, 2, 'Collection', 'مجموعة', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 38, 1),
(14, 2, 'Instant Experience', 'تجربة فورية', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 39, 1),
(15, 3, 'Single Image', 'صورة واحدة', 'f,i', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 30, 1),
(16, 3, 'Single Video', 'فيديو واحد', 'f,i', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 31, 1),
(17, 3, 'Slideshow', 'عرض الشرائح', 'f,i', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 32, 1),
(18, 3, 'Instant Experience', 'تجربة فورية', 'f,i', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 33, 1),
(19, 4, 'Single Image', 'صورة واحدة', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 24, 1),
(20, 4, 'Single Video', 'فيديو واحد', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 25, 1),
(21, 4, 'Carousel', 'دائري', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 26, 1),
(22, 4, 'Slideshow', 'عرض الشرائح', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 27, 1),
(23, 4, 'Collection', 'مجموعة', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 28, 1),
(24, 4, 'Instant Experience', 'تجربة فورية', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 29, 1),
(25, 5, 'Single Video', 'فيديو واحد', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 21, 1),
(26, 5, 'Slideshow', 'عرض الشرائح', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 22, 1),
(27, 5, 'Instant Experience', 'تجربة فورية', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 23, 1),
(28, 6, 'Single Image', 'صورة واحدة', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 20, 1),
(29, 6, 'Single Video', 'فيديو واحد', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 16, 1),
(30, 6, 'Carousel', 'دائري', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 17, 1),
(31, 6, 'Slideshow', 'عرض الشرائح', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 18, 1),
(32, 6, 'Collection', 'مجموعة', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 19, 1),
(33, 7, 'Single Image', 'صورة واحدة', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 15, 1),
(34, 7, 'Single Video', 'فيديو واحد', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 14, 1),
(35, 7, 'Carousel', 'دائري', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 13, 1),
(36, 7, 'Slideshow', 'عرض الشرائح', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 11, 1),
(37, 7, 'Collection', 'مجموعة', 'f,i,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 12, 1),
(38, 8, 'Single Image', 'صورة واحدة', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 10, 1),
(39, 8, 'Single Video', 'فيديو واحد', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, 1),
(40, 8, 'Carousel', 'دائري', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 8, 1),
(41, 8, 'Slideshow', 'عرض الشرائح', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 5, 1),
(42, 8, 'Collection', 'مجموعة', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 7, 1),
(43, 8, 'Instant Experience', 'تجربة فورية', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 6, 1),
(44, 9, 'Single Image', 'صورة واحدة', 'f,i,m,a', NULL, '2\n2', '1\n1', 'ww\n2', 'w\n2', 'XrVPK2Y4lVM', 1, 0, 1, 1),
(45, 9, 'Carousel', 'دائري', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 4, 1),
(46, 9, 'Slideshow', 'عرض الشرائح', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, 1),
(47, 9, 'Collection', 'مجموعة', 'f,i,m,a', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ads_product_images`
--

CREATE TABLE `ads_product_images` (
  `id` int(11) NOT NULL,
  `ads_product_id` int(11) NOT NULL,
  `image` varchar(225) NOT NULL,
  `is_main` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ads_product_images`
--

INSERT INTO `ads_product_images` (`id`, `ads_product_id`, `image`, `is_main`) VALUES
(1, 3, 'AdProductImages_41927.jpg', 0),
(2, 3, 'AdProductImages_49668.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `base_products`
--

CREATE TABLE `base_products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name_en` varchar(225) NOT NULL,
  `name_ar` varchar(225) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `position` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `base_products`
--

INSERT INTO `base_products` (`id`, `category_id`, `name_en`, `name_ar`, `status`, `position`, `created_at`, `updated_at`) VALUES
(2, 1, 'logo Design', 'تصميم شعار', 1, 1, '2021-01-11 14:55:47', '2021-01-11 15:10:11'),
(3, 1, 'Character Design', 'تصميم الشخصية', 1, 2, '2021-01-11 14:56:52', '2021-01-11 15:10:11'),
(4, 2, '3D modeling', '3D النمذجة', 1, 3, '2021-01-11 14:57:38', '2021-01-11 15:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name_en` varchar(225) NOT NULL,
  `name_ar` varchar(225) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_en`, `name_ar`, `position`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Desgin', 'تصميم', 1, 1, '2021-01-11 13:57:23', '2021-01-11 14:01:14'),
(2, 'Motion', 'حركة', NULL, 1, '2021-01-11 14:01:38', '2021-01-11 14:01:38');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `phone` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `message` text NOT NULL,
  `is_contacted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `phone`, `email`, `message`, `is_contacted`, `created_at`, `updated_at`) VALUES
(1, 'ali', '010101010', 'm@m.xom', 'the current message', 1, '2018-12-30 13:19:36', '2019-02-17 14:34:19'),
(2, 'ali', '0101010101', 'm@m.com', 'ewelwkle', 0, '2018-12-30 14:19:34', '2018-12-30 14:19:34'),
(3, 'mona', '010101010010', 'm@m.xom', 'go thire', 1, '2019-01-02 14:34:30', '2019-02-17 14:44:11'),
(4, 'mona', '0101010', 'm@m.com', 'my message', 0, '2019-01-10 13:42:50', '2019-01-10 13:42:50'),
(5, 'test', '4576567567', 'test@test.com', 'test', 0, '2019-01-21 13:45:24', '2019-02-17 14:44:20'),
(8, 'dwdwd', '01099494949', 'm@m.com', 'wdwd', 0, '2019-02-18 11:10:08', '2019-02-18 11:10:45'),
(9, 'dwdw', '010949437932', 'mo20130123@gmail.com', 'sdsd', 0, '2020-08-09 11:03:11', '2020-08-09 11:03:11'),
(10, 'dwdw', '01094943793', 'mo20130123@gmail.com', 'dwd wdw', 1, '2020-08-09 11:03:54', '2020-08-25 14:28:24'),
(11, 'dwdw', '01094943793', 'mo20130123@gmail.com', 'wdwd', 1, '2020-08-09 11:05:03', '2020-08-25 14:28:22'),
(12, 'wdwd', '232323', 'mohamed.zayed@vhorus.com', 'wdwdwd', 0, '2020-11-11 16:12:46', '2020-11-11 16:12:46'),
(13, 'dd', '01095653245', 'ddd@s', 'wdwdwd', 0, '2020-12-06 15:28:23', '2020-12-06 15:28:23'),
(14, 'ali', '01234567567', 'ali@a.com', 'this is a message', 0, '2020-12-06 15:38:40', '2020-12-06 15:38:40'),
(15, 'ali', '01234567567', 'ali@a.com', 'this is a message', 0, '2020-12-06 15:39:09', '2020-12-06 15:39:09'),
(16, 'ww', '222222', 'mohamed.zayed@vhorus.com', '222', 0, '2020-12-13 17:48:35', '2020-12-13 17:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name_en` varchar(225) NOT NULL,
  `name_ar` varchar(225) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name_en`, `name_ar`, `position`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Egypt', 'مصر', 1, 1, '2021-01-17 15:11:16', '2021-01-17 15:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `home_sliders`
--

CREATE TABLE `home_sliders` (
  `id` int(11) NOT NULL,
  `title` varchar(225) DEFAULT NULL,
  `image_ar` varchar(225) DEFAULT NULL,
  `image_en` varchar(225) DEFAULT NULL,
  `link` varchar(225) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `home_sliders`
--

INSERT INTO `home_sliders` (`id`, `title`, `image_ar`, `image_en`, `link`, `position`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Superdeli', 'HomeSlider_53459.png', NULL, NULL, NULL, 1, '2020-08-17 14:22:42', NULL),
(9, 'dddd', 'HomeSliderAr_19684.png', 'HomeSliderEn_95168.png', 'ddd', NULL, 1, '2020-11-18 17:11:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `is_allowed` tinyint(4) NOT NULL DEFAULT 0,
  `country_id` int(11) NOT NULL,
  `wallet` int(11) NOT NULL DEFAULT 0,
  `name` varchar(225) NOT NULL,
  `company` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `title` int(11) NOT NULL,
  `company_size` varchar(225) DEFAULT NULL,
  `email` varchar(225) NOT NULL,
  `phone` varchar(225) NOT NULL,
  `remember_token` varchar(225) DEFAULT NULL,
  `forget_password` varchar(225) DEFAULT NULL,
  `should_rate_order_id` int(11) DEFAULT NULL,
  `reward_points` int(11) NOT NULL DEFAULT 0,
  `is_mail_send` int(11) DEFAULT NULL,
  `jwt` varchar(225) DEFAULT NULL,
  `os` enum('android','ios') DEFAULT NULL,
  `app_version` varchar(225) DEFAULT NULL,
  `model` varchar(225) DEFAULT NULL,
  `firebase_token` varchar(225) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `is_allowed`, `country_id`, `wallet`, `name`, `company`, `password`, `title`, `company_size`, `email`, `phone`, `remember_token`, `forget_password`, `should_rate_order_id`, `reward_points`, `is_mail_send`, `jwt`, `os`, `app_version`, `model`, `firebase_token`, `created_at`, `updated_at`) VALUES
(10, 0, 1, 0, 'Ehab Fares', '', 'bba7cf56c0f126780d8183f10c7aa86b', 0, NULL, 'efares@bsocial-eg.com', '01222187584', 'f3Kt9EUef3aAegra0pyDsRTtGsUCXwaUVWVJu1i9EE975mxrEj7YK5LNiz2B', 'FfV9M0DR9d75k53Nq0U8TnshVMb2ZapHgwxe6vsd1prBO0S0CCIXQ05FWzf2XMwx0jLjhF2pG1ztEPyT', 0, 10, 2, NULL, NULL, NULL, NULL, NULL, '2019-07-15 11:06:59', '2020-05-10 13:36:21'),
(12, 0, 1, 0, 'Hayam', '', 'ac2c147babb6052d69b463d811e67767', 0, NULL, 'hayamelhawary@gmail.com', '01024307057', 'ilHHmRTapbjZK2iXQ25DfLBgvsq3wOBHrDFKJvhdYyutT7Ku8TSyZ1eIBKo8', NULL, 0, 0, 2, 'r76qWA19BlrGmF66FE3snBp6cw2NxKZWv82R3ndOPsXGebiiLVy2', 'android', '1.0.0', 'oppo find x', 'wdwdwdwdwdwdwd', '2019-07-17 13:57:49', '2020-09-09 17:33:51'),
(13, 0, 1, 0, 'moahmed zayed', '', 'ac2c147babb6052d69b463d811e67767', 0, NULL, 'mohamed.zayed@vhorus.com', '01094943793', 'zPkqa4zwqdWdJSqAocVhjH1JWc0zI2mb5dErIuyStHPPvZBP1GAVeQWHcokc', 'ASApuThohClmv2I20vicvU4iAOVxN3nDqOj6fk30pQ3U86QvdOCLTp7MAbLjVQRBHv8lpEO9zy6E8muU', NULL, 23, NULL, 'T20qHKkLWRAtTTJrznhz2gl5X2DeFQSAh2G7RKtuW5vvot4tKbbS', 'android', '1.0.0', 'oppo find x', 'wdwdwdwdwdwdwd', '2020-06-07 15:06:02', '2021-01-03 13:13:29'),
(14, 0, 1, 0, 'www wddwd', '', '291bfeb2a016148083070cf0faa0f723', 0, NULL, 'mo20130123@gmail.com', '01094943793', 'EpkAWn9Fh5zIYxYAL8P1CjVQqXS7WW3ejNadL0A2NPfKMYgDoCAwms8uBrYC', '0DEjAIlK5QUUVOlsY1SpNyOfNhfSYRg3sofC6bgogelw57VQfj5DCmAeGgdTFAk82f17ZwXktDFdTga5', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-21 13:48:36', '2020-07-21 16:59:00'),
(15, 0, 1, 0, 'dwdw dsd', '', '4f06f6813fed91aa57da3b5d14df95c0', 0, NULL, 'mo201301234@gmail.com', '01094943793', 'QaVZrtLTDCCzDyzoVuOybp51khveCjzwIsFA2ASmdcuoHRsBG4SUXC1qvUqB', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-21 14:13:47', '2020-07-21 14:13:47'),
(16, 0, 1, 0, 'mohamed bahaa', '', 'a3e0586de14608f2239997f003c95299', 0, NULL, 'mbahaa@vhorus.com', '01001889852', 'MISSGLaADNGbKnR0rHj8dFHxWYbPLq6IS3eE2R1CwX9KswFE9KGDDgP58N65', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-17 13:34:59', '2020-08-17 13:34:59'),
(17, 0, 1, 0, 'hadeer elshamy', '', '68d1906e5f32c2faf396886a3a0a9660', 0, NULL, 'hadeer.elshamy@vhorus.com', '01111070745', '1yWvD48oaNU6MwOz9viFAzYh2GqAtRyXehCd2UU3rZRzr2v17CldPTMTB8Vt', 'HvDIjQmMYilc9rcX6ju0VwXB0Ur5qL0W10u52AT6FLpSpLvb54d9ju5n813n1KKL6OW4u8bYZpbiSUHL', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-18 14:51:34', '2020-08-25 15:47:51'),
(18, 0, 1, 0, 'Mostafa abosherif', '', '0a56b967d6c2fd1ab3c9de210c496539', 0, NULL, 'mostafa.abosherif@vhorus.com', '23432432423', 'IukoxYdWFbrGGeyEq8dmPCtm4FjFM7SSONfgilpqI0ely5g0mVgc7DPrALYv', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-18 18:52:33', '2020-08-20 16:18:27'),
(20, 0, 1, 0, 'Ehab Fares', '', '30979048a3a24257efca2ad5dc6fb1ce', 0, NULL, 'efares@hotmail.com', '01222187584', 'o6mZRLcTAdWvyQfVFJhcbNoKYkFrhmSVRiYQnWBJSgdiZcq0piTKbH6U8uXP', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-23 11:18:18', '2020-08-23 11:18:18'),
(21, 0, 1, 0, 'Bishoy', '', '93fdbd6e7532bc783bb5038f0e17382c', 0, NULL, 'bishoy.souser@vhorus.com', '01254545', 'ds2teWDkB1XcJ1WKlzQaNUoWBYCBOXtJuzie6xhNiZYoNMaStu14aJMxjgkY', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-23 11:23:31', '2020-08-24 13:00:32'),
(28, 0, 1, 0, 'ali 2', '', 'ac2c147babb6052d69b463d811e67767', 0, NULL, 'm@m.com', '01010101', NULL, NULL, NULL, 0, NULL, '7w82vN3rfX2Q6SljcUmPoFuRfEpdPwGBo8kw5L7KHm964RvAiKVO', 'android', '1.0.0', 'oppo find x', 'wdwdwdwdwdwdwd', '2020-08-24 16:31:58', '2020-08-25 14:07:08'),
(29, 0, 1, 0, 'www', '', 'ac2c147babb6052d69b463d811e67767', 0, NULL, 'm@mm.com', '00101010101', NULL, NULL, NULL, 0, NULL, 'tguRqL3wzzubSgFv1SGAM7be0KcW7hSYL9g0p60IuHgmdVCJjIFr', 'android', '1.0.0', NULL, 'wdwdwdwdwdwdwd', '2020-08-27 15:02:58', '2020-08-27 15:02:58'),
(30, 0, 1, 0, 'www', '', 'ac2c147babb6052d69b463d811e67767', 0, NULL, 'm@meum.com', '00101010101', NULL, NULL, NULL, 0, NULL, '5BPuITmTcscDxmYbrgLL17flpfDksuDtn7ckZqIa6abiLYpaGtAS', 'ios', '1', NULL, 'wdwdwdwdwdwdwd', '2020-08-30 14:06:42', '2020-08-30 14:06:42'),
(31, 0, 1, 0, 'www', '', 'ac2c147babb6052d69b463d811e67767', 0, NULL, 'm@lm.com', '00101010101', NULL, NULL, NULL, 0, NULL, 'qaI9jxkiIe1FVPOyPoi8IEz3pq4Dshp6Os3HhHOkU7aY4A4DWDWa', 'ios', '1', NULL, 'wdwdwdwdwdwdwd', '2020-08-30 14:10:10', '2020-08-30 14:10:10'),
(32, 0, 1, 0, 'wqwq', '', 'd76f7b6f54ee82c6ba7dc10ff3636d91', 0, NULL, 'ewe', '2323332', NULL, NULL, NULL, 0, NULL, 'le1OXQrraFQuXqMKQQygHQHtyTUURrRZp2eOwKoAEiowdiFqqdZT', 'ios', '1.0', NULL, 'toGetFireBaseToken', '2020-08-30 14:18:23', '2020-08-30 14:18:23'),
(33, 0, 1, 0, 'XX is', '', 'adde80c86639f63774c92b58894417ab', 0, NULL, 'x@vhrous.com', '123456789', NULL, NULL, NULL, 0, NULL, '49i9BGcPq4g6Riv0FxtVZgBnY9sEQGePGE8usrQGCqfBujlUAcW9', 'ios', '1.0', NULL, 'toGetFireBaseTokenRegister', '2020-08-30 15:52:23', '2020-08-30 15:52:23'),
(34, 0, 1, 0, 'Xcismans', '', 'adde80c86639f63774c92b58894417ab', 0, NULL, 'x@vhorus.com', '123456789', NULL, NULL, NULL, 0, NULL, 'NxB64bXW2b8ng3u66yINtwo4NHZlNmvWuNrVj8xTI8bx3ulAEYjo', 'ios', '1.0', NULL, 'toGetFireBaseTokenRegister', '2020-08-30 15:55:14', '2020-09-02 13:50:43'),
(36, 0, 1, 0, 'ali ahmed', '', '2f1cd4fd2f377eeb50fcb89bf6965909', 0, NULL, 'mjjj@j.com', '222', 'PIoebbhlTC16TcqbZgxBE1tcwviNtiAa4KZGy0S1xuzln5Iww5EJKASFUNb1', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-09 13:49:47', '2020-09-09 13:49:47'),
(37, 0, 1, 0, 'wdw dwdw', '', 'ac2c147babb6052d69b463d811e67767', 0, NULL, '222@s', '23232323', 'FXY0lRPRCFXQ8N5J7VYz8lMMSQqQdtbmit4Ruk976xHxswQhq5o30rg7FpGt', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-09 13:52:20', '2020-09-09 13:52:20'),
(38, 0, 1, 0, 'ali ahmed', '', 'ac2c147babb6052d69b463d811e67767', 0, NULL, 'mmkf@k.com', '3232323', 'qYabuS0JpYqEuRMxp21HVqpgknwW10kHWyyzfpAgqTXUgclffFGEmJNJ7dyE', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-09 14:04:23', '2020-09-09 14:04:23'),
(39, 0, 1, 0, 'ali ahmed', '', '2f1cd4fd2f377eeb50fcb89bf6965909', 0, NULL, '22323@ss', '2323232', 'pn82aHqpKJvVqICNElv24sy90JACDqXSOsBNU089Iv00hfIKuG7sOtgBCkjx', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-09 14:06:32', '2020-09-09 14:06:32'),
(47, 1, 1, 22, 'the one', 'the one', 'the one ', 0, 'the one', 'the one', '23232', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-25 15:05:19', '2021-01-25 15:05:19'),
(48, 0, 1, 221, 'dwdw1', 'wdw1', '21', 1, 'dwdw1', '2221', '2323231', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-25 15:05:36', '2021-01-25 15:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `member_files`
--

CREATE TABLE `member_files` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `related_to` varchar(225) NOT NULL,
  `file` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `member_marketing_brief`
--

CREATE TABLE `member_marketing_brief` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `about_brand` text DEFAULT NULL,
  `USPs` text NOT NULL,
  `site_link` varchar(225) DEFAULT NULL,
  `kpi` text NOT NULL,
  `talk_to_primary` varchar(225) NOT NULL,
  `talk_to_secondary` varchar(225) NOT NULL,
  `key_response` varchar(225) NOT NULL,
  `colors` text DEFAULT NULL,
  `competitors` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `member_promo`
--

CREATE TABLE `member_promo` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `used_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `member_promo`
--

INSERT INTO `member_promo` (`id`, `member_id`, `promo_id`, `city_id`, `is_used`, `used_date`, `created_at`) VALUES
(485, 17, 113, 22, 1, '2020-08-22 17:37:47', '2020-08-22 16:01:53'),
(486, 21, 114, 28, 1, '2020-08-23 15:51:35', '2020-08-23 11:42:01'),
(487, 17, 115, 22, 1, '2020-08-25 15:45:04', '2020-08-25 15:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `pages_banners`
--

CREATE TABLE `pages_banners` (
  `id` int(11) NOT NULL,
  `page` varchar(225) DEFAULT NULL,
  `imageen` varchar(225) DEFAULT NULL,
  `imagear` varchar(225) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `title` varchar(225) DEFAULT NULL,
  `link` varchar(225) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pages_banners`
--

INSERT INTO `pages_banners` (`id`, `page`, `imageen`, `imagear`, `body`, `title`, `link`, `position`, `created_at`, `updated_at`) VALUES
(3, 'Offers', 'PagesBanner_83013.png', 'PagesBanner_45395.png', 'TSAR', 'null', 'null', 5, NULL, NULL),
(4, 'ChefRecommends', 'PagesBanner_57364.png', 'PagesBanner_55554.png', 'TSAR', 'null', 'null', 4, NULL, NULL),
(5, 'newArrivals', 'PagesBanner_33766.png', 'PagesBanner_66540.png', 'TSAR', 'null', 'null', 3, NULL, NULL),
(6, 'Bundles', 'PagesBanner_39483.png', 'PagesBanner_83531.png', 'TSAR', 'null', 'null', 6, NULL, NULL),
(8, 'home_1', 'PagesBanner_54057.png', 'PagesBanner_94999.png', 'TSAR', 'null', 'swsw111', 1, NULL, NULL),
(10, 'Recipe', 'PagesBanner_99391.png', 'PagesBanner_94909.png', 'TSAR', 'null', 'swsw', 7, NULL, NULL),
(11, 'About', 'PagesBanner_89655.png', 'PagesBanner_75888.png', 'TSAR', 'null', 'swsw', 8, NULL, NULL),
(12, 'DeliveryPolicy', 'PagesBanner_67107.png', 'PagesBanner_92554.png', 'TSAR', 'null', 'swsw', 13, NULL, NULL),
(13, 'FAQ', 'PagesBanner_29025.png', 'PagesBanner_28811.png', 'TSAR', 'null', 'swsw', 9, NULL, NULL),
(14, 'TermsAndConditions', 'PagesBanner_33737.png', 'PagesBanner_25709.png', 'TSAR', 'null', 'swsw', 10, NULL, NULL),
(15, 'PrivacyPolicy', 'PagesBanner_20980.png', 'PagesBanner_39117.png', 'TSAR', 'null', 'swsw', 11, NULL, NULL),
(16, 'home_2', 'PagesBanner_30375.png', 'PagesBanner_50576.png', 'TSAR', 'null', 'swsw11', 2, NULL, NULL),
(17, 'Career', 'PagesBanner_26833.png', 'PagesBanner_27018.png', 'TSAR', 'null', 'swsw', 12, NULL, NULL),
(18, 'Contact_us', 'PagesBanner_89655.png', 'PagesBanner_75888.png', 'Contact_us', 'null', 'swsw', 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `related_to` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '2018-08-14 08:45:37'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `related_to`, `created_at`) VALUES
(1, 'DashBoard', 'DashBoard', '2018-08-14 08:45:37'),
(2, 'Members', 'Members', '2018-08-14 08:45:37'),
(3, 'CategoriesSubCategories', 'CategoriesSubCategories', '2018-08-14 08:45:37'),
(4, 'District', 'District', '2018-08-14 08:45:37'),
(9, 'City', 'City', '2018-08-14 08:45:37'),
(14, 'PopularQuestion', 'PopularQuestion', '2018-08-14 08:45:37'),
(16, 'PagesBanner', 'PagesBanner', '2018-08-14 08:45:37'),
(17, 'HomeSlider', 'HomeSlider', '2018-08-14 08:45:37'),
(18, 'Recipe', 'Recipe', '2018-08-14 08:45:37'),
(19, 'Product', 'Product', '2018-08-14 08:45:37'),
(20, 'Bundel', 'Bundel', '2018-08-14 08:45:37'),
(21, 'PromoCodes', 'PromoCodes', '2018-08-14 08:45:37'),
(22, 'ContactUs', 'ContactUs', '2018-08-14 08:45:37'),
(24, 'Setting', 'Setting', '2018-08-14 08:45:37'),
(25, 'SeoKeywords', 'SeoKeywords', '2018-08-14 08:45:37'),
(26, 'Applicant', 'Applicant', '2018-08-14 08:45:37'),
(27, 'Subscriber', 'Subscriber', '2018-08-14 08:45:37'),
(28, 'TermsAndConditions', 'TermsAndConditions', '2018-08-14 08:45:37'),
(29, 'PrivacyPolicy', 'PrivacyPolicy', '2018-08-14 08:45:37'),
(31, 'Order_Acknowledged', 'Orders', '2018-08-14 08:45:37'),
(32, 'Order_Preparing', 'Orders', '2018-08-14 08:45:37'),
(33, 'Order_Dispatched', 'Orders', '2018-08-14 08:45:37'),
(34, 'Order_Delivered', 'Orders', '2018-08-14 08:45:37'),
(35, 'Order_Canceled', 'Orders', '2018-08-14 08:45:37'),
(36, 'Order', 'Orders', '2018-08-14 08:45:37'),
(37, 'updateStockWithExcel', 'updateStockWithExcel', '2018-08-14 08:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `popular_questions`
--

CREATE TABLE `popular_questions` (
  `id` int(11) NOT NULL,
  `question_en` text NOT NULL,
  `question_ar` text NOT NULL,
  `answer_en` text NOT NULL,
  `answer_ar` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `position` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `popular_questions`
--

INSERT INTO `popular_questions` (`id`, `question_en`, `question_ar`, `answer_en`, `answer_ar`, `status`, `position`, `created_at`, `updated_at`) VALUES
(2, '1. Do I need to create an account to shop at mido.com.eg? How do I register?', '1. Do I need to create an account to shop at mido.com.eg? How do I register?', 'Yes, you do. Creating an account is an easy and convenient way to save delivery and order information, view current order status, record past orders, and save favorites that you can share. You may also check out as a guest if you don’t wish to create an account at this time. Click here to create your account!', 'Yes, you do. Creating an account is an easy and convenient way to save delivery and order information, view current order status, record past orders, and save favorites that you can share. You may also check out as a guest if you don’t wish to create an account at this time. Click here to create your account!', 1, 1, '2019-07-07 13:36:13', '2021-01-18 14:01:56'),
(3, '2. How do I find products at mido.com.eg?', '2. How do I find products at mido.com.eg?', '1. By Category – Think of our categories as shopping aisles. You can browse categories on the left navigation of the website. When you hover over a category or tap on it, it will open a list of more specific sub-categories. When you are on a Sub-category page, you can narrow your browsing further by selecting one of the filters.\r\n2. Product Search – Simply type the product you are looking for into the search bar at the top of the site and click Go! You can even search for brand names, categories and product attributes.', '1. By Category – Think of our categories as shopping aisles. You can browse categories on the left navigation of the website. When you hover over a category or tap on it, it will open a list of more specific sub-categories. When you are on a Sub-category page, you can narrow your browsing further by selecting one of the filters.\r\n2. Product Search – Simply type the product you are looking for into the search bar at the top of the site and click Go! You can even search for brand names, categories and product attributes.', 1, 2, '2019-07-07 13:39:35', '2021-01-18 14:01:56'),
(4, '3. When can I get my shopping delivered?', '3. When can I get my shopping delivered?', 'We deliver to you five days a week, from Sunday to Thursday. Our order hours are from 8:30 am to 2:30 pm sent to orders@midoonlinestore.com.eg . Orders usually take from 48 – 7 hours.', 'We deliver to you five days a week, from Sunday to Thursday. Our order hours are from 8:30 am to 2:30 pm sent to orders@midoonlinestore.com.eg . Orders usually take from 48 – 7 hours.', 1, 3, '2019-07-07 13:40:03', '2021-01-18 14:01:56'),
(5, '4. What if MIDO does not sell a product I would like to buy?', '4. What if MIDO does not sell a product I would like to buy?', 'We’d love to hear your suggestions on what you would like to buy! Please suggest a product to us, so that we can look into stocking it for your future purchases.', 'We’d love to hear your suggestions on what you would like to buy! Please suggest a product to us, so that we can look into stocking it for your future purchases.', 1, 4, '2019-07-07 13:40:45', '2021-01-18 14:01:56'),
(6, '5. How are my food items stored and delivered?', '5. How are my food items stored and delivered?', 'When it comes to your food, our top priority is ensuring your health and safety, and we work hard to ensure that you get the freshest food in the safest manner possible. We store and transport products in accordance with market standards and regulations. We carefully control the conditions in which your products are stored and transported, from the moment they are delivered to us to the time you receive them at your doorstep. Fresh items stay chilled and frozen items remain frozen.', 'When it comes to your food, our top priority is ensuring your health and safety, and we work hard to ensure that you get the freshest food in the safest manner possible. We store and transport products in accordance with market standards and regulations. We carefully control the conditions in which your products are stored and transported, from the moment they are delivered to us to the time you receive them at your doorstep. Fresh items stay chilled and frozen items remain frozen.', 1, 5, '2019-07-07 13:41:20', '2021-01-18 14:01:56'),
(7, '6. I have a problem with the products in my order. What can I do next?', '6. I have a problem with the products in my order. What can I do next?', 'We ask that you please check your order upon delivery. If you’re not completely happy with your products, please reach out to us via support@mido.com.eg and we’ll assist you from there.', 'We ask that you please check your order upon delivery. If you’re not completely happy with your products, please reach out to us via support@mido.com.eg and we’ll assist you from there.', 1, 6, '2019-07-07 13:42:10', '2021-01-18 14:01:56'),
(8, '7. How do I enter a promo code?', '7. How do I enter a promo code?', 'You’ll have the opportunity to enter a promo code during the payment stage of the checkout process. Simply enter the code (e.g. \'mido101\') followed by the \'Enter\' button on the right. Once the code has been successfully redeemed, the total amount will be updated. If there are any issues, you will see a small red box explaining the issue.', 'You’ll have the opportunity to enter a promo code during the payment stage of the checkout process. Simply enter the code (e.g. \'mido101\') followed by the \'Enter\' button on the right. Once the code has been successfully redeemed, the total amount will be updated. If there are any issues, you will see a small red box explaining the issue.', 1, 7, '2019-07-07 13:42:41', '2021-01-18 14:01:56'),
(9, '8. Is MIDO online store secure?', '8. Is MIDO online store secure?', 'Yes. We take every precaution to protect your privacy and to prevent misuse of the private information you provide us.', 'Yes. We take every precaution to protect your privacy and to prevent misuse of the private information you provide us.', 1, 8, '2019-07-07 13:43:16', '2021-01-18 14:01:56'),
(10, '9. There’s a problem with one of the items I ordered. Can I get a refund?', '9. There’s a problem with one of the items I ordered. Can I get a refund?', 'If an item is missing from your order or you have received a damaged item, please refund the order upon delivery or contact us for support via support@mido.com.eg', 'If an item is missing from your order or you have received a damaged item, please refund the order upon delivery or contact us for support via support@mido.com.eg', 1, 9, '2019-07-07 13:43:42', '2021-01-18 14:01:56'),
(11, '10. When will my order arrive once it’s ordered?', '10. When will my order arrive once it’s ordered?', 'The delivery for your order usually take from 48-72 hours.', 'The delivery for your order usually take from 48-72 hours.', 1, 10, '2019-07-07 13:44:25', '2021-01-18 14:01:56'),
(12, 'I need to cancel my order I placed for later in the week. Will I be charged?', 'I need to cancel my order I placed for later in the week. Will I be charged?', 'No. If you cancel an order before its scheduled delivery, we will not charge you.', 'No. If you cancel an order before its scheduled delivery, we will not charge you.', 1, 11, '2019-10-20 09:36:34', '2021-01-18 14:01:56'),
(13, 'How can I pay for my order?', 'How can I pay for my order?', 'In order to make your shopping as convenient as possible, we offer a selection of payment modes : Online by credit/debit card, Cash upon delivery & Card upon delivery.', 'In order to make your shopping as convenient as possible, we offer a selection of payment modes : Online by credit/debit card, Cash upon delivery & Card upon delivery.', 1, 12, '2019-10-20 09:37:20', '2021-01-18 14:01:56'),
(14, 'What is the minimum order?', 'What is the minimum order?', 'Minimum order is 499 LE', 'Minimum order is 499 LE', 1, 13, '2019-10-20 09:37:50', '2021-01-18 14:01:56');

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policy`
--

CREATE TABLE `privacy_policy` (
  `id` int(11) NOT NULL,
  `title_en` varchar(225) NOT NULL,
  `title_ar` varchar(225) NOT NULL,
  `text_en` text NOT NULL,
  `text_ar` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `position` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `privacy_policy`
--

INSERT INTO `privacy_policy` (`id`, `title_en`, `title_ar`, `text_en`, `text_ar`, `status`, `position`, `created_at`, `updated_at`) VALUES
(3, 'How Do We Deliver?', 'كيف نسلم؟', 'After you have placed your order, an e-mail will be sent to you to verify that we have received your order. When we receive your order, it will be prepared carefully and transported with our refrigerated trucks that are equipped at the highest market standards. Our professional delivery team will bring it to you, making sure your order stays intact until you receive it.', 'بعد تقديمك لطلبك ، سيتم إرسال بريد إلكتروني إليك للتحقق من استلامنا لطلبك. عندما نتلقى طلبك ، سيتم تحضيره بعناية ونقله بشاحناتنا المبردة المجهزة بأعلى معايير السوق. سيقوم فريق التوصيل المحترف لدينا بإحضارها إليك ، مع التأكد من بقاء طلبك على حاله حتى استلامه.', 1, 1, '2020-08-19 10:25:23', '2020-11-12 14:00:40'),
(4, 'What Is The Delivery Time?', 'ما هو وقت التسليم؟', 'Kindly note that we deliver within 24 hours from date of delivery except for weekends.', 'يرجى ملاحظة أننا نقوم بالتوصيل خلال 24 ساعة من تاريخ التسليم باستثناء عطلات نهاية الأسبوع.', 1, 2, '2020-08-19 10:26:50', '2020-11-12 14:00:40'),
(5, 'Where Do We Deliver?', 'أين نقوم بالتوصيل؟', 'We deliver to Cairo and Sahel.', 'نقوم بالتوصيل إلى القاهرة والساحل.', 1, 3, '2020-08-19 10:27:56', '2020-11-12 14:00:40'),
(6, 'How Much Is The Delivery Fee?', 'كم هي رسوم التوصيل؟', 'The delivery fee is EGP 0. Minimum order: 250 EGP.', 'مصاريف التوصيل 0 جنيه مصري. الحد الأدنى للطلب: 250 جنيه مصري.', 1, 4, '2020-08-19 10:28:52', '2020-11-12 14:00:40'),
(7, 'How Do You Pay?', 'كيف تدفع؟', 'The payment for your order is made upon delivery. We accept cash and credit card. When you place your order, you will see the total before you check out. The total includes all your products delivery fee.', 'يتم الدفع لطلبك عند التسليم. نحن نقبل النقد وبطاقات الائتمان. عند تقديم طلبك ، سترى الإجمالي قبل تسجيل المغادرة. يشمل الإجمالي جميع رسوم توصيل منتجاتك.', 1, 5, '2020-08-19 10:30:33', '2020-11-12 14:00:40'),
(8, 'Is It Possible To Return An Order?', 'هل من الممكن إرجاع الطلب؟', 'Because we only have food products, it is not possible to return them. If you do have complaints or questions about your order, please don’t hesitate to contact us on 01210765555. You can also send an e-mail to info@superdelionline.com or a letter to 13T Al Adeeb Aly Adham, Sheraton, Heliopolis, Cairo, Egypt. Our team will always be ready to listen to your comments and to find the right solution for every problem. When an item in your order is damaged upon delivery, we will replace it free of charge.', 'نظرًا لأن لدينا منتجات غذائية فقط ، فلا يمكن إرجاعها. إذا كانت لديك شكاوى أو أسئلة بخصوص طلبك ، من فضلك لا تتردد في الاتصال بنا على 01210765555. يمكنك أيضًا إرسال بريد إلكتروني إلى info@superdelionline.com أو خطاب إلى 13T Al Adeeb علي أدهم ، شيراتون ، مصر الجديدة ، القاهرة، مصر. سيكون فريقنا دائمًا على استعداد للاستماع إلى تعليقاتك وإيجاد الحل المناسب لكل مشكلة. عند تلف عنصر في طلبك عند التسليم ، سنقوم باستبداله مجانًا.', 1, 6, '2020-08-19 10:33:49', '2020-11-12 14:00:40'),
(9, 'Contact Us', 'اتصل بنا', 'If you have any further questions, you can contact SuperDeli by sending an e-mail to info@superdelionline.com or by sending a letter to SuperDeli, 13T Al Adeeb Aly Adham, Sheraton, Heliopolis, Cairo, Egypt.\nOur team is always ready to help you.', 'إذا كان لديك أي أسئلة أخرى ، يمكنك التواصل مع SuperDeli عن طريق إرسال بريد إلكتروني إلى info@superdelionline.com أو عن طريق إرسال رسالة إلى SuperDeli ، 13T Al Adeeb Aly Adham ، Sheraton ، Heliopolis ، Cairo ، Egypt.\nفريقنا مستعد دائمًا لمساعدتك.', 1, 7, '2020-08-19 10:35:02', '2020-11-12 14:00:40');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `base_product_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `name_en` varchar(225) NOT NULL,
  `name_ar` varchar(225) NOT NULL,
  `short_description_en` text DEFAULT NULL,
  `short_description_ar` text DEFAULT NULL,
  `description_en` text NOT NULL,
  `description_ar` text NOT NULL,
  `rate` int(11) DEFAULT NULL,
  `youtube_link` varchar(225) DEFAULT NULL,
  `offer_percentage` int(11) NOT NULL DEFAULT 0,
  `is_available` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_bundle` tinyint(4) NOT NULL DEFAULT 0,
  `selles_times` int(11) NOT NULL DEFAULT 0,
  `position` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `base_product_id`, `provider_id`, `name_en`, `name_ar`, `short_description_en`, `short_description_ar`, `description_en`, `description_ar`, `rate`, `youtube_link`, `offer_percentage`, `is_available`, `status`, `is_bundle`, `selles_times`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 'dwdw', 'dwd', 'dw', 'dwdw', 'dwdwd', 'dwdw w dwd', NULL, NULL, 0, 1, 1, 0, 0, 1, '2021-01-13 17:12:15', '2021-01-14 17:02:36'),
(2, 1, 2, 1, 'test name en', 'test name ar', 'desc en', 'desc ar', 'short en', 'short ar', NULL, NULL, 0, 1, 1, 0, 0, 2, '2021-01-13 17:25:47', '2021-01-14 17:02:36'),
(3, 2, 4, 1, 'test name en 1', 'test name ar 1', 'desc en  1', 'desc ar 1', 'short en  1', 'short ar', NULL, 'null 1', 0, 0, 1, 0, 0, 3, '2021-01-13 17:27:04', '2021-01-20 15:58:13'),
(4, 1, 2, 1, 'ww', 'www', 'ddd', 'ddd', 'fff', '222', NULL, NULL, 0, 1, 1, 0, 0, NULL, '2021-01-25 16:03:21', '2021-01-25 16:03:21');

-- --------------------------------------------------------

--
-- Table structure for table `products_key_words`
--

CREATE TABLE `products_key_words` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name_en` varchar(225) NOT NULL,
  `name_ar` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `products_key_words`
--

INSERT INTO `products_key_words` (`id`, `product_id`, `name_en`, `name_ar`, `created_at`, `updated_at`) VALUES
(1, 1, '3', '3', '2021-01-13 17:12:15', '2021-01-13 17:12:15'),
(2, 2, 'w', 'we', '2021-01-13 17:25:47', '2021-01-13 17:25:47'),
(9, 3, 'w', 'we', '2021-01-13 18:24:16', '2021-01-13 18:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(225) NOT NULL,
  `is_main` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `is_main`) VALUES
(1, 1, 'ProductImages_83987.png', 1),
(2, 2, 'ProductImages_96176.jpg', 1),
(3, 3, 'ProductImages_28391.jpg', 1),
(4, 4, 'ProductImages_48076.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_package_basic`
--

CREATE TABLE `product_package_basic` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `modifications` int(11) NOT NULL,
  `remaining_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_package_basic`
--

INSERT INTO `product_package_basic` (`id`, `product_id`, `price`, `days`, `modifications`, `remaining_text`) VALUES
(1, 3, 11, 22, 33, NULL),
(2, 4, 22, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_package_premium`
--

CREATE TABLE `product_package_premium` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `modifications` int(11) NOT NULL,
  `remaining_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_package_premium`
--

INSERT INTO `product_package_premium` (`id`, `product_id`, `price`, `days`, `modifications`, `remaining_text`) VALUES
(1, 3, 77, 88, 99, NULL),
(2, 4, 22, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_package_standard`
--

CREATE TABLE `product_package_standard` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `modifications` int(11) NOT NULL,
  `remaining_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_package_standard`
--

INSERT INTO `product_package_standard` (`id`, `product_id`, `price`, `days`, `modifications`, `remaining_text`) VALUES
(1, 3, 44, 55, 66, NULL),
(2, 4, 2, 222, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

CREATE TABLE `promo_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(225) NOT NULL,
  `discount_percentage` float NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `city_id` int(11) DEFAULT NULL,
  `allowed_number_of_usage` int(11) DEFAULT NULL,
  `actual_number_of_usage` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `promo_codes`
--

INSERT INTO `promo_codes` (`id`, `code`, `discount_percentage`, `from_date`, `to_date`, `status`, `city_id`, `allowed_number_of_usage`, `actual_number_of_usage`, `created_at`, `updated_at`) VALUES
(113, 'test2020', 10, '2020-08-21', '2020-08-23', 1, 0, 0, 1, '2020-08-21 23:25:12', '2020-08-22 16:01:53'),
(114, 'test123456', 10, '2020-08-05', '2020-08-26', 1, NULL, NULL, 1, '2020-08-23 11:37:17', '2020-08-23 11:49:44'),
(115, 'getmy50', 50, '2020-08-02', '2020-10-01', 1, NULL, NULL, 1, '2020-08-25 15:44:03', '2020-08-25 15:44:22'),
(116, 'go50', 50, '2020-11-08', '2020-12-05', 1, 0, 20, 20, '2020-11-24 15:15:07', '2020-11-24 16:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` int(11) NOT NULL,
  `name_en` varchar(225) NOT NULL,
  `name_ar` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`id`, `name_en`, `name_ar`, `created_at`, `updated_at`) VALUES
(1, 'BSocial', 'بي شوشيل', '2021-01-11 13:22:37', '2021-01-11 13:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `comment`, `created_at`, `updated_at`) VALUES
(6, 'Marketing Team', 'Marcomm', '2020-08-22 17:21:45', '2020-08-26 12:00:51'),
(7, 'Dispatched', 'Order', '2020-08-22 17:22:18', '2020-08-22 17:22:18'),
(8, 'Delivered', 'done', '2020-08-22 17:22:38', '2020-08-22 17:22:38'),
(9, 'cs', 'cs', '2020-08-25 15:55:58', '2020-08-25 15:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
(48, 7, 36),
(49, 7, 33),
(50, 8, 34),
(51, 8, 36),
(55, 6, 2),
(57, 6, 16),
(58, 6, 17),
(59, 6, 3),
(60, 6, 19),
(61, 6, 20),
(62, 6, 18),
(63, 6, 21),
(64, 6, 24),
(65, 6, 25),
(66, 6, 22),
(67, 6, 1),
(68, 6, 9),
(69, 6, 4),
(70, 9, 37),
(71, 9, 19);

-- --------------------------------------------------------

--
-- Table structure for table `seo_keywords`
--

CREATE TABLE `seo_keywords` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `seo_keywords`
--

INSERT INTO `seo_keywords` (`id`, `name`, `status`) VALUES
(1, 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `value`) VALUES
(24, 'our_location_en', '8 Fathy Talaat St. Sheraton Buildings, Heliopolis, Cairo, Egypt'),
(25, 'our_phone', ''),
(26, 'facebook_link', 'https://www.facebook.com/SuperDeli.Online/'),
(27, 'twitter_link', 'https://www.twitter.com/'),
(28, 'instagram_link', 'https://www.instagram.com/superdeli.online/'),
(40, 'about_us_text_ar', 'بواسطة الإمام فندي. تعتبر عائلة فندي اللاعبين الرئيسيين للمنتجات الحلوة والحلويات في مصر. Fourrée ، هارد كاندي (كور بيزنس) ، كانوي سويتيز (Éclairs ، توفي) ، دراجيس ، شوكولا (مقولب ، قضبان / عدد الكيلومترات ، فردي) ، البسكويت (كلاسيك-فيلد) والويفر. Horreia هي الرائدة في السوق في السوق المحلية الموقف في صناعة الحلوى الصلبة. ما جعل Horreia أبديًا ومتزايدًا طوال هذه العقود ، هو إخلاص الأجيال الأولى والثانية من Fendi إلى الحب المستمر للابتكارات في المنتجات التي تقدم أوسع نطاق بين جميع المسابقات تقديم الحلوى الصلبة من جميع الأنواع والابتكارات ، سواء كانت كبيرة وصغيرة ومليئة بالمركز الطبيعي أو الاقتصاد كل نوع من الوصفات ، بالإضافة إلى التوفي ، مجموعة من النكهات المختلفة من الرقاقات المليئة بالشوكولاته ، كريمات الفانيلا وغيرها ، وتطويرها للأسواق المحلية والدولية ، وعناصر Govrit التي نطورها للسوق المحلية ، والفول السوداني المغلفة بالشوكولاته ، والحلوى وأكثر في قسم من dragee. وقد نجح الجميع أيضًا في الوصول إلى التصدير من جميع الشركات المحيطة في الشرق الأوسط وأفريقيا ، وصولًا إلى الولايات المتحدة الأمريكية وكندا.'),
(35, 'youtube_link', 'https://www.youtube.com/'),
(36, 'shipping_price', '0'),
(37, 'tax_price', '0'),
(38, 'linkedin_link', 'https://www.linkedin.com/company/midodistributor'),
(39, 'about_us_text_en', 'by Imam Fendi. Fendi’s Family is the key players of sweet producers and confectionary in Egypt Horreia’s product portfolio covers; Fourrée, Hard Candy (Core Business), Chewy Candies (Éclairs, Toffee), Dragees, Chocolate (Moulded, Bars/Count-lines, Single), Biscuits (Classic-Filled) and wafers. Horreia is Market-Leader in Domestic Market Position in hard candy industry. What made Horreia everlasting and growing throughout these decades, the devotion of Fendi’s 1st & 2nd generations into constant love of product innovations offering the widest range among all competition Offering hard candy of all types and innovations, be it large, small, center filled, natural or economy all sort of recipes, plus toffee, range of different flavors of Wafers filled with chocolate, Vanilla creams etc. and develop it for the domestic and international markets, and Govrit items we develop it for the domestic market, chocolate coated peanuts, candy and more into the section of dragee. That all succeeded also into the export reaching from all surrounding companies in middle east & Africa, all the way to USA & Canada.'),
(41, 'our_phone_1', '+201210765555'),
(42, 'our_phone_2', '+20 1101600920'),
(43, 'our_email', 'info@superdelionline.com'),
(44, 'minimum_basket_amount', '10'),
(45, 'minimum_freeTast_amount', '999'),
(46, 'our_location_ar', '8 ش فتحى طلعت ، مساكن شيراتون ، مصر الجديدة\r\nالقاهرة، مصر'),
(92, 'in_1', 'nn'),
(93, 'in_2', '900'),
(94, 'in_3', 'nn'),
(95, 'PrivacyPolicy_INFORMATION_USE_en', 'to respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\n\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.'),
(96, 'PrivacyPolicy_INFORMATION_DISCLOSURE_en', 'to respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.'),
(97, 'PrivacyPolicy_INFORMATION_USE_ar', 'to respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.'),
(98, 'PrivacyPolicy_INFORMATION_DISCLOSURE_ar', 'to respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.'),
(100, 'aboutus_en', '<p>Welcome to SUPERDELI.</p>\r\n<p>We are an online webshop that delivers superior grocery, food, and non-food items to our client base in different cities across the country.</p>\r\n\r\n<p>Every product we sell is selected carefully to ensure we are serving our clients with only the top products in every\r\ncategory and ensure its availability as much as possible at all times.\r\n</p>\r\n<p>At SUPERDELI, we strive to serve our clients based on 3 core principles: </p>\r\n\r\n<ul>\r\n    <li> QUALITY </li>\r\n    <li> SERVICE </li>\r\n    <li> CONVENIENCE </li>\r\n</ul> \r\n\r\n<p>It is these 3 principles that define what we do at SUPERDELI and who we are. Our dedicated team of customer service professionals \r\n    is committed to help every client with their needs and requests and make sure that every client is satisfied whether with \r\n    the products that we deliver or resolving a problem that they might have. \r\n</p>\r\n\r\n<p>Our expert team of top senior and junior chefs are carefully selected and well trained to deliver quality with taste,\r\nhygienic and trendy solutions whether it’s for individual Indulgence or party groups like home gatherings or office\r\nbreakouts.\r\n</p>\r\n\r\n<p>\r\nOur delivery procedures <a href=\"{{url(\'About_us\')}}\"> {{url(\'Recipe\')}} </a>  is strict ensuring hygienic and\r\ntemperature-controlled deliveries using temperature-controlled trucks and equipment to ensure at all times that products\r\narrive to our clients in the best condition to enjoy. \r\n</p>\r\n\r\n<p>\r\n    At SUPERDELI, you can find your grocery needs for everyday use or special exclusive food items of world class standard or catering options for parties and gatherings. You can also enjoy our recipes <a href=\"{{url(\'Recipe\')}}\">{{url(\'Recipe\')}}</a> section prepared carefully by our Culinary team to offer our clients various recipe options for every diet.\r\n</p>\r\n\r\n<p>\r\n    You can also follow us on Facebook <a href=\"https://www.facebook.com/SuperDeli.Online/\">https://www.facebook.com/SuperDeli.Online/</a>  and Instagram <a href=\"https://www.instagram.com/superdeli.online/\">https://www.instagram.com/superdeli.online/</a> , to stay tuned to our announcements, new products we add or new services we provide or industry news we share, or exclusive recipe videos by top chefs. \r\n</p>\r\n\r\n<p>\r\n    On our website, we aim to provide our clients with a user friendly, and clear website for convenient navigation and to find what you need easily. Our point system <a href=\"{{url(\'ShoppingCart\')}}\">{{url(\'ShoppingCart\')}}</a> with every order gives an automatic rebate scheme to all our clients to build up points as they purchase from us that they can redeem at any time for any goods or services we offer. You can also save previous buying baskets <a href=\"{{url(\'saved_basket\')}}\"> {{url(\'saved_basket\')}} </a>  for quick repeat orders with a couple of clicks or you can create your list of favorite items <a href=\"{{url(\'WishList\')}}\">{{url(\'WishList\')}}</a>, with a one-button click on any picture to easily access your favourite items. We provide a lot of offers and product discounts. At our Bundles section <a href=\"{{url(\'bundles\')}}\">{{url(\'bundles\')}}</a>, you can find plenty of offers for grouped products at reduced prices, and at our products in discount section <a href=\"{{url(\'Offers\')}}\"> {{url(\'Offers\')}} </a>  , you can find a lot of products being offered at a decent discount rate.  We also add new products daily. You can also stay abreast of all new products we are adding by visiting the new New Products section <a href=\"{{url(\'new-arrivals\')}}\">{{url(\'new-arrivals\')}}</a> .\r\n</p>\r\n\r\nWe welcome all customer s feedback, praise, or improvement suggestions and take all customer feedback seriously, and respond to it promptly. You can reach us by phone at +201210765555 or by sending an email to info@superdelionline.com or by filling out our feedback form <a href=\"{{url(\'Contact_us\')}}\">{{url(\'Contact_us\')}}</a> and we will respond to your inquiry immediately and effectively\r\n\r\nWe hope you enjoy your shopping experience at SUPERDELI.\r\n<a href=\"{{url(\'\')}}\"> {{url(\'\')}} </a> \r\nThe SUPERDELI Team'),
(101, 'aboutus_ar', 'هذا نص قابل للتعديل من المسؤول -> المعلومات والمحتوى\ns\n     '),
(102, 'aboutus_side_image', '29911.png');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `type` enum('product','ad') NOT NULL DEFAULT 'product',
  `product_id` int(11) NOT NULL,
  `package` enum('Standard','Basic','Premium') DEFAULT NULL,
  `marketing_brief` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(225) NOT NULL,
  `is_contacted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `is_contacted`, `created_at`, `updated_at`) VALUES
(1, 'wdwd', 0, '2019-08-29 18:53:01', '2019-08-29 18:53:01'),
(2, 'sdsdsddsd', 0, '2019-10-15 12:06:04', '2019-10-15 12:06:04'),
(3, 'seragmounir7@gmail.com', 0, '2019-10-15 14:03:23', '2019-10-15 14:03:23'),
(4, 'bb@bb.com', 0, '2020-02-04 16:43:16', '2020-02-04 16:43:16'),
(5, 'dsd@s.c', 0, '2020-02-18 13:47:38', '2020-02-18 13:47:38'),
(6, 'dwdw@ss.com', 0, '2020-02-18 13:47:50', '2020-02-18 13:47:50'),
(7, 'test@m.com', 0, '2020-02-18 14:00:41', '2020-02-18 14:00:41'),
(8, 'dwdw@ss.com', 0, '2020-02-18 14:01:38', '2020-02-18 14:01:38'),
(9, 'test@m.com', 0, '2020-02-18 14:08:35', '2020-02-18 14:08:35'),
(10, 'test@m.com', 0, '2020-02-18 14:08:40', '2020-02-18 14:08:40'),
(11, 'test@m.com', 0, '2020-02-18 14:08:54', '2020-02-18 14:08:54'),
(12, 'dwdw@ss.com', 0, '2020-02-18 14:09:26', '2020-02-18 14:09:26'),
(13, 'test@m.com', 0, '2020-02-18 14:10:08', '2020-02-18 14:10:08'),
(14, 'dwdw@ss.com', 0, '2020-02-18 14:11:44', '2020-02-18 14:11:44'),
(15, 'test@m.com', 0, '2020-02-18 14:14:49', '2020-02-18 14:14:49'),
(16, 'dwdw@ss.com', 0, '2020-02-18 14:15:51', '2020-02-18 14:15:51'),
(17, 'test@m.com', 0, '2020-02-18 14:15:58', '2020-02-18 14:15:58'),
(18, 'mo20130123@gmail.com', 0, '2020-02-18 14:16:25', '2020-02-18 14:16:25'),
(19, 'mohamed.zayed@vhorus.com', 0, '2020-02-18 14:16:34', '2020-02-18 14:16:34'),
(20, 'dwdw@ss.com', 0, '2020-02-18 14:18:28', '2020-02-18 14:18:28'),
(21, 'test@m.com', 0, '2020-02-18 14:18:33', '2020-02-18 14:18:33'),
(22, 'mo20130123@gmail.com', 0, '2020-02-18 14:19:42', '2020-02-18 14:19:42'),
(23, 'mo20130123@gmail.com', 0, '2020-02-18 14:19:52', '2020-02-18 14:19:52'),
(24, 'mo20130123@gmail.com', 0, '2020-02-18 14:20:13', '2020-02-18 14:20:13'),
(25, 'mo20130123@gmail.com', 0, '2020-02-18 14:20:35', '2020-02-18 14:20:35'),
(26, 'dwdw@ss.com', 0, '2020-02-18 14:26:24', '2020-02-18 14:26:24'),
(27, 'dwdw@ss.com', 0, '2020-02-18 14:26:31', '2020-02-18 14:26:31'),
(28, 'mohamed.zayed@vhorus.com', 0, '2020-02-18 14:27:26', '2020-02-18 14:27:26'),
(29, 'test@m.com', 0, '2020-02-18 14:28:26', '2020-02-18 14:28:26'),
(30, 'm@m.com', 0, '2020-02-18 15:27:12', '2020-02-18 15:27:12'),
(31, 'mohamed.zayed@vhorus.com', 0, '2020-02-18 15:28:22', '2020-02-18 15:28:22'),
(32, 'mo20130123@gmail.com', 0, '2020-02-18 15:28:29', '2020-02-18 15:28:29'),
(33, 'mo20130123@gmail.com', 0, '2020-02-18 15:28:37', '2020-02-18 15:28:37'),
(34, 'mo20130123@gmail.com', 0, '2020-02-18 15:28:46', '2020-02-18 15:28:46'),
(35, 'vv@c.vom', 0, '2020-03-08 14:14:56', '2020-03-08 14:14:56'),
(36, 'vv@c.vom', 0, '2020-03-08 14:15:33', '2020-03-08 14:15:33'),
(37, 'vv@c.vom', 0, '2020-03-08 14:15:40', '2020-03-08 14:15:40'),
(38, 'dfsdfaf@mosfa.com', 0, '2020-03-15 13:01:03', '2020-03-15 13:01:03'),
(39, 'fdsafasdf@frgsdfg', 0, '2020-03-15 13:08:30', '2020-03-15 13:08:30'),
(40, 'fdsafsdfasdf@gdfgsdfg', 0, '2020-03-15 13:10:17', '2020-03-15 13:10:17'),
(41, 'adsfsdfa@dgfsdfgsdf', 0, '2020-03-15 13:10:33', '2020-03-15 13:10:33'),
(42, 'sadasda@gasdgasdfg', 0, '2020-03-15 13:11:01', '2020-03-15 13:11:01'),
(43, 'fasdfa@gfasdgasdf', 0, '2020-03-15 13:11:14', '2020-03-15 13:11:14'),
(44, 'fasdfa@gfasdgasdf', 0, '2020-03-15 13:12:20', '2020-03-15 13:12:20'),
(45, 'fasdfa@gfasdgasdf', 0, '2020-03-15 13:12:47', '2020-03-15 13:12:47'),
(46, 'fasdfa@gfasdgasdf', 0, '2020-03-15 13:13:03', '2020-03-15 13:13:03'),
(48, 'fasdfa@gfasdgasdf', 0, '2020-03-15 13:14:17', '2020-03-15 13:14:17'),
(49, 'fasdfa@gfasdgasdf', 0, '2020-03-15 13:15:12', '2020-03-15 13:15:12'),
(50, 'fasdfa@gfasdgasdf', 0, '2020-03-15 13:15:33', '2020-03-15 13:15:33'),
(52, 'dsdgfa@sdfhsdfh', 0, '2020-03-15 13:18:16', '2020-03-15 13:18:16'),
(53, 'hadeer1601@gmail.com', 0, '2020-03-16 10:30:28', '2020-03-16 10:30:28'),
(54, 'hadeer.elshamy@vhorus.com', 0, '2020-03-18 09:19:43', '2020-03-18 09:19:43'),
(55, 'mo201301234@gmail.com', 0, '2020-08-09 14:45:28', '2020-08-24 11:44:04'),
(57, 'tarazaneltayerr@gmail.com', 0, '2020-08-09 14:46:51', '2020-08-09 14:46:51'),
(58, 'hadeer1601@gmail.com', 0, '2020-08-19 10:22:40', '2020-08-24 11:45:11'),
(59, 'hadeer1601@gmail.com', 0, '2020-08-19 13:16:28', '2020-08-24 11:45:14'),
(60, 'hadeer.elshamy@vhorus.com', 0, '2020-08-22 16:40:00', '2020-08-24 11:44:53'),
(61, 'hadeer.elshamy@vhorus.com', 0, '2020-08-22 16:41:26', '2020-08-24 12:27:42'),
(63, 'test@test.com', 0, '2020-08-27 13:49:56', '2020-08-27 13:49:56'),
(64, 'hadeer1601@gmail.com', 0, '2020-08-27 13:50:14', '2020-08-27 13:50:14'),
(65, 'mohamed.zayed@vhorus.com', 1, '2020-11-12 13:05:35', '2021-01-17 15:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `terms_and_conditions`
--

CREATE TABLE `terms_and_conditions` (
  `id` int(11) NOT NULL,
  `title_en` varchar(225) NOT NULL,
  `title_ar` varchar(225) NOT NULL,
  `text_en` text NOT NULL,
  `text_ar` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `position` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `terms_and_conditions`
--

INSERT INTO `terms_and_conditions` (`id`, `title_en`, `title_ar`, `text_en`, `text_ar`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, 'ORDERING THROUGH THE PLATFORM', 'ORDERING THROUGH THE PLATFORM', '1-to respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other \r\n\r\n2-notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\n\r\n3-to respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.', '1-to respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other \r\n\r\n2-notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\n\r\n3-to respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.', 1, 1, '2020-06-28 00:00:00', '2021-01-18 14:01:20'),
(2, 'DELIVERY FREE\r\n', 'DELIVERY FREE\r\n', ' notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\n\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you. ', ' notifications , and contact and communicate with you.\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you.\r\n\r\nto respond to your inquiries or requests, process and fill customer orders, verify yours qualifications for certain products and services, process payments and prevent transactional fraud, provide delivery and other notifications , and contact and communicate with you. ', 1, 2, '2020-06-28 00:00:00', '2021-01-18 14:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `wish_list`
--

CREATE TABLE `wish_list` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `wish_list`
--

INSERT INTO `wish_list` (`id`, `member_id`, `product_id`, `created_at`) VALUES
(57, 13, 317, '2020-08-05 12:41:42'),
(59, 13, 198, '2020-08-05 12:41:45'),
(60, 13, 319, '2020-08-05 12:42:00'),
(64, 13, 322, '2020-08-05 12:45:08'),
(65, 13, 318, '2020-08-05 12:45:09'),
(66, 13, 345, '2020-08-05 12:46:02'),
(69, 13, 336, '2020-08-05 15:26:57'),
(77, 17, 399, '2020-08-18 20:05:38'),
(80, 17, 378, '2020-08-18 20:05:50'),
(88, 13, 426, '2020-08-20 12:43:08'),
(89, 16, 388, '2020-08-20 15:33:17'),
(90, 16, 375, '2020-08-20 15:33:18'),
(91, 16, 377, '2020-08-20 15:33:19'),
(92, 16, 379, '2020-08-20 15:33:20'),
(94, 17, 385, '2020-08-21 00:50:35'),
(95, 17, 475, '2020-08-22 15:43:12'),
(96, 16, 385, '2020-08-23 10:53:48'),
(97, 16, 426, '2020-08-23 10:53:50'),
(103, 17, 375, '2020-08-25 15:59:36'),
(104, 17, 480, '2020-08-25 15:59:40'),
(105, 13, 374, '2020-11-05 11:17:07'),
(106, 13, 1010, '2020-11-05 11:41:23'),
(107, 13, 476, '2020-11-05 13:05:59'),
(108, 13, 377, '2020-11-05 13:06:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `role_id` (`role_id`) USING BTREE;

--
-- Indexes for table `ads_objectives`
--
ALTER TABLE `ads_objectives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads_products`
--
ALTER TABLE `ads_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ads_objective_id` (`ads_objective_id`);

--
-- Indexes for table `ads_product_images`
--
ALTER TABLE `ads_product_images`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `product_id` (`ads_product_id`) USING BTREE;

--
-- Indexes for table `base_products`
--
ALTER TABLE `base_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_sliders`
--
ALTER TABLE `home_sliders`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `member_files`
--
ALTER TABLE `member_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `member_marketing_brief`
--
ALTER TABLE `member_marketing_brief`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `member_promo`
--
ALTER TABLE `member_promo`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `promo_id` (`promo_id`) USING BTREE,
  ADD KEY `member_id` (`member_id`) USING BTREE,
  ADD KEY `city_id` (`city_id`) USING BTREE;

--
-- Indexes for table `pages_banners`
--
ALTER TABLE `pages_banners`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `popular_questions`
--
ALTER TABLE `popular_questions`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `privacy_policy`
--
ALTER TABLE `privacy_policy`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `base_product_id` (`base_product_id`),
  ADD KEY `provider_id` (`provider_id`);

--
-- Indexes for table `products_key_words`
--
ALTER TABLE `products_key_words`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `product_id` (`product_id`) USING BTREE;

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `product_id` (`product_id`) USING BTREE;

--
-- Indexes for table `product_package_basic`
--
ALTER TABLE `product_package_basic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_id_2` (`product_id`);

--
-- Indexes for table `product_package_premium`
--
ALTER TABLE `product_package_premium`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_package_standard`
--
ALTER TABLE `product_package_standard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `city_id` (`city_id`) USING BTREE;

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `seo_keywords`
--
ALTER TABLE `seo_keywords`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `member_id` (`member_id`) USING BTREE,
  ADD KEY `product_id` (`product_id`) USING BTREE,
  ADD KEY `marketing_brief` (`marketing_brief`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `wish_list`
--
ALTER TABLE `wish_list`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `member_id` (`member_id`) USING BTREE,
  ADD KEY `product_id` (`product_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ads_objectives`
--
ALTER TABLE `ads_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ads_products`
--
ALTER TABLE `ads_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `ads_product_images`
--
ALTER TABLE `ads_product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `base_products`
--
ALTER TABLE `base_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `home_sliders`
--
ALTER TABLE `home_sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `member_files`
--
ALTER TABLE `member_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_marketing_brief`
--
ALTER TABLE `member_marketing_brief`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_promo`
--
ALTER TABLE `member_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=491;

--
-- AUTO_INCREMENT for table `pages_banners`
--
ALTER TABLE `pages_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `popular_questions`
--
ALTER TABLE `popular_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `privacy_policy`
--
ALTER TABLE `privacy_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products_key_words`
--
ALTER TABLE `products_key_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_package_basic`
--
ALTER TABLE `product_package_basic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_package_premium`
--
ALTER TABLE `product_package_premium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_package_standard`
--
ALTER TABLE `product_package_standard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `seo_keywords`
--
ALTER TABLE `seo_keywords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wish_list`
--
ALTER TABLE `wish_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ads_products`
--
ALTER TABLE `ads_products`
  ADD CONSTRAINT `ads_products_ibfk_1` FOREIGN KEY (`ads_objective_id`) REFERENCES `ads_objectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ads_product_images`
--
ALTER TABLE `ads_product_images`
  ADD CONSTRAINT `ads_product_images_ibfk_1` FOREIGN KEY (`ads_product_id`) REFERENCES `ads_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `base_products`
--
ALTER TABLE `base_products`
  ADD CONSTRAINT `base_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_marketing_brief`
--
ALTER TABLE `member_marketing_brief`
  ADD CONSTRAINT `member_marketing_brief_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_promo`
--
ALTER TABLE `member_promo`
  ADD CONSTRAINT `member_promo_ibfk_1` FOREIGN KEY (`promo_id`) REFERENCES `promo_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`base_product_id`) REFERENCES `base_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_package_basic`
--
ALTER TABLE `product_package_basic`
  ADD CONSTRAINT `product_package_basic_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_package_premium`
--
ALTER TABLE `product_package_premium`
  ADD CONSTRAINT `product_package_premium_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_package_standard`
--
ALTER TABLE `product_package_standard`
  ADD CONSTRAINT `product_package_standard_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
