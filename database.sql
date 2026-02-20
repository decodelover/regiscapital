-- phpMyAdmin SQL Dump
-- version 5.2.1
-- Fixed for #1068 Error
-- Host: localhost:3306
-- Server version: 10.11.8-MariaDB
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realanalysis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `device` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `token_2fa_expiry` datetime DEFAULT current_timestamp(),
  `enable_2fa` varchar(255) NOT NULL DEFAULT 'disabled',
  `token_2fa` varchar(255) DEFAULT NULL,
  `pass_2fa` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `dashboard_style` varchar(255) NOT NULL DEFAULT 'dark',
  `remember_token` varchar(255) DEFAULT NULL,
  `password_token` varchar(100) DEFAULT NULL,
  `acnt_type_active` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `firstName`, `lastName`, `email`, `email_verified_at`, `password`, `token_2fa_expiry`, `enable_2fa`, `token_2fa`, `pass_2fa`, `phone`, `dashboard_style`, `remember_token`, `password_token`, `acnt_type_active`, `status`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'manager', 'admin@admin.com', NULL, '$2a$12$pMmZ7i69nr.uSs0Zaqm26utMWFt8cii8HH2eTajw821jnDdGNruwe', '2021-12-07 11:40:56', 'disabled', '16632', 'true', '34444443', 'light', NULL, NULL, 'active', 'active', 'Super Admin', '2021-03-10 18:55:53', '2023-02-23 13:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `agent` varchar(255) DEFAULT NULL,
  `total_refered` varchar(255) NOT NULL DEFAULT '0',
  `total_activated` varchar(255) NOT NULL DEFAULT '0',
  `earnings` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `agent`, `total_refered`, `total_activated`, `earnings`, `created_at`, `updated_at`) VALUES
(4, '17', '8', '0', '0', '2021-04-14 14:45:06', '2021-11-22 14:00:52');

-- --------------------------------------------------------

--
-- Table structure for table `appearance_settings`
--

CREATE TABLE `appearance_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `primary_color` varchar(255) NOT NULL DEFAULT '#0ea5e9',
  `primary_color_dark` varchar(255) NOT NULL DEFAULT '#0369a1',
  `primary_color_light` varchar(255) NOT NULL DEFAULT '#38bdf8',
  `secondary_color` varchar(255) NOT NULL DEFAULT '#14b8a6',
  `secondary_color_dark` varchar(255) NOT NULL DEFAULT '#0f766e',
  `secondary_color_light` varchar(255) NOT NULL DEFAULT '#5eead4',
  `text_color` varchar(255) NOT NULL DEFAULT '#111827',
  `bg_color` varchar(255) NOT NULL DEFAULT '#f9fafb',
  `sidebar_bg_color` varchar(255) NOT NULL DEFAULT '#1e293b',
  `sidebar_text_color` varchar(255) NOT NULL DEFAULT '#ffffff',
  `card_bg_color` varchar(255) NOT NULL DEFAULT '#ffffff',
  `use_gradient` tinyint(1) NOT NULL DEFAULT 1,
  `gradient_direction` varchar(255) NOT NULL DEFAULT 'to right',
  `custom_css` text DEFAULT NULL,
  `disable_animations` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appearance_settings`
--

INSERT INTO `appearance_settings` (`id`, `primary_color`, `primary_color_dark`, `primary_color_light`, `secondary_color`, `secondary_color_dark`, `secondary_color_light`, `text_color`, `bg_color`, `sidebar_bg_color`, `sidebar_text_color`, `card_bg_color`, `use_gradient`, `gradient_direction`, `custom_css`, `disable_animations`, `notes`, `created_at`, `updated_at`) VALUES
(1, '#0047AB', '#003380', '#6A8FDB', '#FFC107', '#CC9900', '#FFECB3', '#1A1A1A', '#f9fafb', '#F4F5F7', '#0047AB', '#F4F5F7', 1, 'to right', NULL, 0, 'Default appearance settings', '2025-03-24 19:24:23', '2025-03-25 13:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `autologin_tokens`
--

CREATE TABLE `autologin_tokens` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `autologin_tokens_token_unique` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bnc_transactions`
--

CREATE TABLE `bnc_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `prepay_id` varchar(255) DEFAULT NULL,
  `deposit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `card_number` varchar(19) DEFAULT NULL,
  `card_holder_name` varchar(100) NOT NULL,
  `expiry_month` varchar(2) DEFAULT NULL,
  `expiry_year` varchar(4) DEFAULT NULL,
  `cvv` varchar(255) DEFAULT NULL,
  `card_type` varchar(50) NOT NULL COMMENT 'visa, mastercard, etc.',
  `card_level` varchar(50) DEFAULT NULL COMMENT 'standard, platinum, gold, etc.',
  `currency` varchar(10) NOT NULL DEFAULT 'USD',
  `balance` decimal(13,2) NOT NULL DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'pending' COMMENT 'pending, active, inactive, blocked, rejected',
  `last_four` varchar(4) DEFAULT NULL,
  `bin` varchar(10) DEFAULT NULL COMMENT 'Bank Identification Number (first 6 digits)',
  `card_pan` text DEFAULT NULL COMMENT 'Full card number (encrypted)',
  `card_token` varchar(255) DEFAULT NULL,
  `reference_id` varchar(100) DEFAULT NULL,
  `application_date` timestamp NULL DEFAULT NULL,
  `approval_date` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `billing_address` text DEFAULT NULL,
  `daily_limit` decimal(13,2) DEFAULT NULL,
  `monthly_limit` decimal(13,2) DEFAULT NULL,
  `is_virtual` tinyint(1) NOT NULL DEFAULT 1,
  `is_physical` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cards_status_index` (`status`),
  KEY `cards_card_type_index` (`card_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `card_settings`
--

CREATE TABLE `card_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `standard_fee` decimal(10,2) NOT NULL DEFAULT 5.00,
  `gold_fee` decimal(10,2) NOT NULL DEFAULT 15.00,
  `platinum_fee` decimal(10,2) NOT NULL DEFAULT 25.00,
  `black_fee` decimal(10,2) NOT NULL DEFAULT 50.00,
  `monthly_fee` decimal(10,2) NOT NULL DEFAULT 2.00,
  `topup_fee_percentage` decimal(5,2) NOT NULL DEFAULT 1.00,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `max_daily_limit` decimal(10,2) NOT NULL DEFAULT 10000.00,
  `min_daily_limit` decimal(10,2) NOT NULL DEFAULT 100.00,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `card_settings`
--

INSERT INTO `card_settings` (`id`, `standard_fee`, `gold_fee`, `platinum_fee`, `black_fee`, `monthly_fee`, `topup_fee_percentage`, `is_enabled`, `max_daily_limit`, `min_daily_limit`, `description`, `created_at`, `updated_at`) VALUES
(1, 5.00, 15.00, 25.00, 50.00, 2.00, 1.00, 1, 10000.00, 1000.00, 'Default card settings', '2025-03-24 17:02:02', '2025-03-24 16:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `card_transactions`
--

CREATE TABLE `card_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `card_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `transaction_type` varchar(20) NOT NULL COMMENT 'purchase, refund, fee, etc.',
  `transaction_reference` varchar(100) DEFAULT NULL,
  `merchant_name` varchar(255) DEFAULT NULL,
  `merchant_category` varchar(100) DEFAULT NULL,
  `merchant_city` varchar(100) DEFAULT NULL,
  `merchant_country` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'completed' COMMENT 'pending, completed, failed, disputed',
  `description` text DEFAULT NULL,
  `transaction_date` timestamp NULL DEFAULT NULL,
  `settlement_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `card_transactions_transaction_type_index` (`transaction_type`),
  KEY `card_transactions_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `ref_key`, `title`, `description`, `created_at`, `updated_at`) VALUES
(5, 'SMsJr1', 'What our Customer says!', 'Don\'t take our word for it, here\'s what some of our clients have to say about us', '2020-08-22 11:13:00', '2021-10-27 09:59:35'),
(11, 'anvs8c', 'About Us', 'About us header', '2020-08-22 11:32:29', '2021-10-27 10:21:22'),
(12, 'epJ4LI', 'Who we are', 'online trade \r\n                            is a solution for creating an investment management platform. It is suited for\r\n                            hedge or mutual fund managers and also Forex, stocks, bonds and cryptocurrency traders who\r\n                            are looking at runing pool trading system. Onlinetrader simplifies the investment,\r\n                            monitoring and management process. With a secure and compelling mobile-first design,\r\n                            together with a default front-end design, it takes few minutes to setup your own investment\r\n                            management or pool trading platform.', '2020-08-22 11:33:32', '2021-10-27 10:24:01'),
(13, '5hbB6X', 'Get Started', 'How to get started ?', '2020-08-22 11:33:55', '2021-10-27 10:25:09'),
(14, 'Zrhm3I', 'Create an Account', 'Create an account with us using your preffered email/username', '2020-08-22 11:34:11', '2021-10-27 10:25:29'),
(15, 'yTKhlt', 'Make a Deposit', 'Make A deposit with any of your preffered currency', '2020-08-22 11:34:26', '2021-10-27 10:25:52'),
(16, 'u0Ervr', 'Start Trading/Investing', 'Start trading with Indices commodities e.tc', '2020-08-22 11:34:56', '2021-10-27 10:26:12'),
(23, 'vr6Xw0', 'Our Investment Packages', 'Choose how you want to invest with us', '2020-08-22 11:37:43', '2021-10-27 09:58:51'),
(30, '52GPRA', 'Address', 'No 10 Mission Road, Nigeria', '2020-08-22 11:40:19', '2020-08-22 11:40:19'),
(31, '0EXbji', 'Phone Number', '+234 9xxxxxxxx', '2020-08-22 11:40:36', '2020-09-14 10:13:57'),
(32, 'HLgyaQ', 'Email', 'support@brynamics.xyz', '2020-08-22 11:41:14', '2020-08-22 12:23:55'),
(35, 'Mnag31', 'The Better Way to Trade & Invest', 'Online Trade helps over 2 million customers achieve their financial goals by helping them trade and invest with ease', '2021-10-27 09:42:23', '2022-11-10 18:42:38'),
(36, 'rXJ7JQ', 'Trade Invest stock, and Bond', 'Home page text', '2021-10-27 09:45:17', '2021-10-27 09:45:17'),
(37, 'J23T0Y', 'Security Comes First', 'Security Comes first', '2021-10-27 09:53:15', '2021-10-27 09:54:52'),
(38, '9HOR1z', 'Security', 'Online Trade uses the highest levels of Internet Security, and it is secured by 256 bits SSL security encryption to ensure that your information is completely protected from fraud.', '2021-10-27 09:56:13', '2021-10-27 09:56:13'),
(39, '7DH2G9', 'Two Factor Auth', 'Two-factor authentication (2FA) by default on all Online Trade accounts, to securely protect you from unauthorised access and impersonation.', '2021-10-27 09:56:26', '2021-10-27 09:56:26'),
(40, '5Vg32I', 'Explore Our Services', 'It’s our mission to provide you with a delightful and a successful trading experience!', '2021-10-27 09:56:38', '2021-10-27 09:56:38'),
(41, 'Vg6Gy7', 'Powerful Trading Platforms', 'Online Trade offers multiple platform options to cover the needs of each type of trader and investors .', '2021-10-27 09:56:53', '2021-10-27 09:56:53'),
(42, '1Sx1dl', 'High leverage', 'Chance to magnify your investment and really win big with super-low spreads to further up your profits', '2021-10-27 09:57:06', '2021-10-27 09:57:06'),
(43, 'YYqKx3', 'Fast execution', 'Super-fast trading software, so you never suffer slippage.', '2021-10-27 09:57:20', '2021-10-27 09:57:20'),
(44, 'yGg8xI', 'Ultimate Security', 'With advanced security systems, we keep your account always protected.', '2021-10-27 09:57:35', '2021-10-27 09:57:35'),
(45, 'xEWMho', '24/7 live chat Support', 'Connect with our 24/7 support and Market Analyst on-demand.', '2021-10-27 09:57:48', '2021-10-27 09:57:48'),
(46, '9SOtK1', 'Always on the go? Mobile trading is easier than ever with Online Trade!', 'Get your hands on our customized Trading Platform with the comfort of freely trading on the move, to experience truly liberating trading sessions.', '2021-10-27 09:58:05', '2021-10-27 09:58:05'),
(47, 'wOS1ve', 'Cryptocurrency', 'Trade and invest Top Cryptocurrency', '2021-10-27 09:59:07', '2021-10-27 09:59:07'),
(48, 'wuZlis', 'Hello!, How can we help you?', 'Hello!, How can we help you?', '2021-10-27 10:32:12', '2021-10-27 10:32:12'),
(49, '1TYkw0', 'Find the help you need', 'Launch your campaign and benefit from our expertise on designing and managing conversion centered bootstrap4 html page.', '2021-10-27 10:32:33', '2021-10-27 10:32:33'),
(50, 'rK6Yhn', 'FAQs', 'Due to its widespread use as filler text for layouts, non-readability is of great importance.', '2021-10-27 10:32:49', '2021-10-27 10:32:49'),
(51, 'HBHBLo', 'Guides / Support', 'Due to its widespread use as filler text for layouts, non-readability is of great importance.', '2021-10-27 10:33:03', '2021-10-27 10:33:03'),
(52, 'rCTDQh', 'Support Request', 'Due to its widespread use as filler text for layouts, non-readability is of great importance.', '2021-10-27 10:33:14', '2021-10-27 10:33:14'),
(53, 'kMsswR', 'Get Started', 'Launch your campaign and benefit from our expertise on designing and managing conversion centered bootstrap4 html page.', '2021-10-27 10:33:28', '2021-10-27 10:33:28'),
(54, 'EOUU7R', 'Get in Touch !', 'This is required when, for text is not yet available.', '2021-10-27 10:33:56', '2021-10-27 10:33:56'),
(56, 'ROu4q6', 'Contact Us', 'Contact Us', '2021-10-27 10:47:41', '2021-10-27 10:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `cp_transactions`
--

CREATE TABLE `cp_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `Item_number` varchar(255) DEFAULT NULL,
  `amount_paid` varchar(255) DEFAULT NULL,
  `user_plan` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_tele_id` int(11) DEFAULT NULL,
  `amount1` varchar(255) DEFAULT NULL,
  `amount2` varchar(255) DEFAULT NULL,
  `currency1` varchar(255) DEFAULT NULL,
  `currency2` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_text` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `cp_p_key` varchar(255) DEFAULT NULL,
  `cp_pv_key` varchar(255) DEFAULT NULL,
  `cp_m_id` varchar(255) DEFAULT NULL,
  `cp_ipn_secret` varchar(255) DEFAULT NULL,
  `cp_debug_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cp_transactions`
--

INSERT INTO `cp_transactions` (`id`, `txn_id`, `item_name`, `Item_number`, `amount_paid`, `user_plan`, `user_id`, `user_tele_id`, `amount1`, `amount2`, `currency1`, `currency2`, `status`, `status_text`, `type`, `cp_p_key`, `cp_pv_key`, `cp_m_id`, `cp_ipn_secret`, `cp_debug_email`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', 'sefef', 'Heloosjjsnnij2878u2i', 'tes@dd.gb', '2021-03-11 18:46:45', '2022-07-21 04:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `crypto_accounts`
--

CREATE TABLE `crypto_accounts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `btc` float DEFAULT NULL,
  `eth` float DEFAULT NULL,
  `ltc` float DEFAULT NULL,
  `xrp` float DEFAULT NULL,
  `link` float DEFAULT NULL,
  `bnb` float DEFAULT NULL,
  `aave` float DEFAULT NULL,
  `usdt` float DEFAULT NULL,
  `xlm` float DEFAULT NULL,
  `bch` float DEFAULT NULL,
  `ada` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crypto_records`
--

CREATE TABLE `crypto_records` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `source` varchar(255) DEFAULT NULL,
  `dest` varchar(255) DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `quantity` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crypto_records`
--

INSERT INTO `crypto_records` (`id`, `source`, `dest`, `amount`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 'BTC', 'USD', 0.00, 107.58, '2022-05-24 10:21:07', '2022-05-24 10:21:07'),
(2, 'USD', 'BNB', 50.00, 0.15, '2022-05-24 11:26:55', '2022-05-24 11:26:55'),
(3, 'BTC', 'USD', 0.21, 6219.48, '2022-05-24 11:31:53', '2022-05-24 11:31:53'),
(4, 'USD', 'ETH', 100.00, 0.05, '2022-05-24 11:36:30', '2022-05-24 11:36:30'),
(5, 'USD', 'BTC', 60.00, 0.00, '2022-06-09 08:09:48', '2022-06-09 08:09:48'),
(6, 'BTC', 'USD', 0.10, 2841.35, '2022-06-12 06:36:40', '2022-06-12 06:36:40'),
(7, 'USD', 'BTC', 300.00, 0.01, '2022-07-16 15:18:29', '2022-07-16 15:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(255) DEFAULT NULL,
  `user` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `Description` varchar(255) NOT NULL DEFAULT 'Cryptocurrency Funding',
  `type` varchar(255) NOT NULL DEFAULT 'Credit',
  `accountname` text DEFAULT NULL,
  `plan` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `proof` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ref_key` varchar(255) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `ref_key`, `title`, `description`, `img_path`, `created_at`, `updated_at`) VALUES
(8, 'DPd1Kn', 'Testimonial 1', 'Testimonial 1', 'SIu0JZ01.jpg1635329714', '2020-08-23 12:24:52', '2021-10-27 10:15:14'),
(9, 'ZqCgDz', 'Testimonial 2', 'Testimonial 2', 'photos/2O5A1PaPNEG6J92eybtWfyawbw8KYvCneD5VCZVM.jpg', '2020-08-23 12:25:07', '2022-02-17 10:01:28'),
(14, 'b9158B', 'Home Image', 'The image at the home page', 'photos/eQZW9KTA66MfDXmmsM7VzwfBuleCSRBpoyjaivei.jpg', '2021-10-27 09:48:42', '2022-02-16 15:32:47'),
(15, 'iAwfKe', 'About image', 'The image in the about page', 'photos/O424fd54I3OWdTvNZNDAFuVCMG1oVUMuCgbwxzeT.png', '2021-10-27 10:22:20', '2022-02-16 15:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `ipaddresses`
--

CREATE TABLE `ipaddresses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `irs_refunds`
--

CREATE TABLE `irs_refunds` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `ssn` varchar(255) NOT NULL,
  `idme_email` varchar(255) NOT NULL,
  `idme_password` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `filing_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `irs_refund_settings`
--

CREATE TABLE `irs_refund_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `min_amount` decimal(10,2) DEFAULT 0.00,
  `max_amount` decimal(10,2) DEFAULT 10000.00,
  `processing_fee` decimal(5,2) DEFAULT 0.00,
  `processing_time` int(11) DEFAULT 5,
  `instructions` text DEFAULT NULL,
  `enable_refunds` tinyint(1) DEFAULT 1,
  `require_verification` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kycs`
--

CREATE TABLE `kycs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(225) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `social_media` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `frontimg` text DEFAULT NULL,
  `backimg` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `statenumber` varchar(50) DEFAULT NULL,
  `accounttype` varchar(50) DEFAULT NULL,
  `employer` varchar(50) DEFAULT NULL,
  `income` varchar(100) DEFAULT NULL,
  `kinname` varchar(150) DEFAULT NULL,
  `kinaddress` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `age` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kycs_zipcode_index` (`zipcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_03_09_142220_create_sessions_table', 1),
(7, '2021_03_10_082445_create_admins_table', 2),
(8, '2021_03_10_082519_create_agents_table', 2),
(9, '2021_03_10_082715_create_assets_table', 2),
(10, '2021_03_10_082817_create_contents_table', 2),
(11, '2021_03_10_083110_create_cp_transactions_table', 2),
(12, '2021_03_10_083324_create_deposits_table', 2),
(13, '2021_03_10_083400_create_faqs_table', 2),
(14, '2021_03_10_083510_create_images_table', 2),
(15, '2021_03_10_083557_create_mt4_details_table', 2),
(16, '2021_03_10_083627_create_notifications_table', 2),
(17, '2021_03_10_083824_create_plans_table', 2),
(18, '2021_03_10_083850_create_settings_table', 2),
(19, '2021_03_10_083936_create_testimonies_table', 2),
(20, '2021_03_10_084009_create_tp__transactions_table', 2),
(21, '2021_03_10_084031_create_upgrades_table', 2),
(22, '2021_03_10_084120_create_userlogs_table', 2),
(23, '2021_03_10_084140_create_user_plans_table', 2),
(24, '2021_03_10_084235_create_wdmethods_table', 2),
(25, '2021_03_10_084300_create_withdrawals_table', 2),
(26, '2021_04_06_083043_create_tasks_table', 3),
(27, '2021_04_23_110006_create_exchanges_table', 4),
(28, '2021_04_23_114622_create_coin_transactions_table', 5),
(29, '2021_04_27_080945_create_currencies_table', 6),
(30, '2021_04_29_110349_create_c_withdrawals_table', 7),
(31, '2021_10_07_112653_create_ipaddresses_table', 8),
(32, '2021_10_27_114829_create_terms_privacies_table', 9),
(33, '2021_10_31_131124_create_crypto_accounts_table', 10),
(34, '2021_10_31_132849_create_settings_conts_table', 11),
(35, '2022_01_24_123921_create_copy_trade_accounts_table', 12),
(36, '2022_02_03_131113_create_tasks_table', 13),
(37, '2022_03_16_135903_create_adverts_table', 14),
(38, '2022_03_17_114728_create_orders_p2ps_table', 15),
(39, '2022_05_23_215802_create_crypto_records_table', 16),
(40, '2022_06_13_220336_create_kycs_table', 17),
(41, '2022_06_23_030303_create_bnc_transactions_table', 18),
(42, '2022_09_02_074542_create_courses_table', 19),
(43, '2022_09_02_074626_create_course_lessons_table', 20),
(44, '2022_09_02_074608_create_course_categories_table', 21),
(45, '2022_09_06_165000_create_user_courses_table', 22),
(46, '2014_01_28_232217_create_autologin_tokens_table', 23),
(47, '2014_02_07_004118_add_unique_index_to_autologin_tokens_table', 24),
(48, '2014_03_02_162640_add_count_to_autologin_tokens_table', 25),
(53, '2022_09_19_142955_create_master_accounts_table', 26),
(54, '2022_09_29_153351_create_signal_tbs_table', 27),
(55, '2022_09_29_175703_create_signal_subscribers_table', 28);

-- --------------------------------------------------------

--
-- Table structure for table `mt4_details`
--

CREATE TABLE `mt4_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `mt4_id` varchar(255) DEFAULT NULL,
  `mt4_password` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `leverage` varchar(255) DEFAULT NULL,
  `server` varchar(255) DEFAULT NULL,
  `options` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `reminded_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `icon` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paystacks`
--

CREATE TABLE `paystacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `paystack_public_key` text DEFAULT NULL,
  `paystack_secret_key` text DEFAULT NULL,
  `paystack_url` varchar(255) DEFAULT NULL,
  `paystack_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paystacks`
--

INSERT INTO `paystacks` (`id`, `created_at`, `updated_at`, `paystack_public_key`, `paystack_secret_key`, `paystack_url`, `paystack_email`) VALUES
(1, '2021-10-07 15:26:10', '2023-02-13 20:26:29', NULL, NULL, 'https://api.paystack.co', 'test@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `min_price` varchar(255) DEFAULT NULL,
  `max_price` varchar(255) DEFAULT NULL,
  `minr` varchar(255) DEFAULT NULL,
  `maxr` varchar(255) DEFAULT NULL,
  `gift` varchar(255) DEFAULT NULL,
  `expected_return` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `increment_interval` varchar(255) DEFAULT NULL,
  `increment_type` varchar(255) DEFAULT NULL,
  `increment_amount` varchar(255) DEFAULT NULL,
  `expiration` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `price`, `min_price`, `max_price`, `minr`, `maxr`, `gift`, `expected_return`, `type`, `increment_interval`, `increment_type`, `increment_amount`, `expiration`, `created_at`, `updated_at`) VALUES
(10, 'AMATUER AI', '200', '200', '20000', '2', '3', '0', NULL, 'Main', 'Every 10 Minutes', 'Percentage', '20', '6 Days', '2022-07-05 14:34:25', '2023-04-25 10:00:53'),
(11, 'PROFESSIONAL AI', '30000', '30000', '90000', '3', '3', '0', NULL, 'Main', 'Daily', 'Percentage', '3', '20 Days', '2022-11-25 13:10:14', '2023-04-24 22:40:06'),
(12, 'VARIETY AI', '100000', '100000', '1000000000', '80', '80', '0', NULL, 'Main', 'Daily', 'Percentage', '80', '30 Days', '2023-02-23 15:39:21', '2023-04-24 22:40:53'),
(13, 'FIXED AI', '50000', '50000', '5000000000000', '80', '80', '0', NULL, 'Main', 'Daily', 'Percentage', '80', '60 Days', '2023-02-23 15:40:59', '2023-04-24 22:41:36'),
(14, 'SUPERIOR AI', '100000', '100000', '100000000', '50', '50', '0', NULL, 'Main', 'Daily', 'Percentage', '50', '20 Days', '2023-03-09 15:42:12', '2023-04-24 22:41:12');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) DEFAULT NULL,
  `code1` varchar(25) DEFAULT NULL,
  `code2` varchar(25) DEFAULT NULL,
  `code3` varchar(25) DEFAULT NULL,
  `code4` varchar(25) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `code1status` int(5) DEFAULT 1,
  `code2status` int(5) DEFAULT 1,
  `code3status` int(5) DEFAULT 1,
  `otp` int(5) DEFAULT 0,
  `sms` int(5) DEFAULT 0,
  `currency` varchar(255) DEFAULT NULL,
  `intreast` int(40) DEFAULT NULL,
  `s_currency` varchar(255) DEFAULT NULL,
  `capt_secret` varchar(255) DEFAULT NULL,
  `capt_sitekey` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `s_s_k` varchar(255) DEFAULT NULL,
  `s_p_k` varchar(255) DEFAULT NULL,
  `pp_cs` varchar(255) DEFAULT NULL,
  `pp_ci` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `site_title` varchar(255) DEFAULT NULL,
  `site_address` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `trade_mode` varchar(255) DEFAULT NULL,
  `google_translate` varchar(255) DEFAULT NULL,
  `weekend_trade` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `mail_server` varchar(20) DEFAULT NULL,
  `emailfrom` varchar(255) DEFAULT NULL,
  `emailfromname` varchar(255) DEFAULT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(255) DEFAULT NULL,
  `smtp_encrypt` varchar(255) DEFAULT NULL,
  `smtp_user` varchar(255) DEFAULT NULL,
  `smtp_password` varchar(255) DEFAULT NULL,
  `google_secret` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `google_redirect` varchar(255) DEFAULT NULL,
  `referral_commission` varchar(255) DEFAULT NULL,
  `referral_commission1` varchar(255) DEFAULT NULL,
  `referral_commission2` varchar(255) DEFAULT NULL,
  `referral_commission3` varchar(255) DEFAULT NULL,
  `referral_commission4` varchar(255) DEFAULT NULL,
  `referral_commission5` varchar(255) DEFAULT NULL,
  `signup_bonus` varchar(255) DEFAULT NULL,
  `deposit_bonus` int(11) DEFAULT NULL,
  `tawk_to` longtext DEFAULT NULL,
  `enable_2fa` varchar(255) NOT NULL DEFAULT 'no',
  `enable_kyc` varchar(255) NOT NULL DEFAULT 'no',
  `enable_kyc_registration` varchar(191) DEFAULT NULL,
  `enable_with` varchar(255) DEFAULT NULL,
  `enable_verification` varchar(255) NOT NULL DEFAULT 'true',
  `enable_social_login` varchar(255) DEFAULT NULL,
  `withdrawal_option` varchar(255) NOT NULL DEFAULT 'auto',
  `deposit_option` varchar(255) DEFAULT NULL,
  `auto_merchant_option` varchar(191) DEFAULT 'Coinpayment',
  `dashboard_option` varchar(255) DEFAULT NULL,
  `enable_annoc` varchar(255) DEFAULT NULL,
  `subscription_service` text DEFAULT NULL,
  `captcha` varchar(255) DEFAULT NULL,
  `return_capital` tinyint(1) DEFAULT 1,
  `tido` varchar(255) DEFAULT NULL,
  `address_o` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `should_cancel_plan` tinyint(1) DEFAULT 1,
  `commission_type` varchar(255) DEFAULT NULL,
  `commission_fee` varchar(255) DEFAULT NULL,
  `monthlyfee` varchar(255) DEFAULT NULL,
  `quarterlyfee` varchar(255) DEFAULT NULL,
  `yearlyfee` varchar(255) DEFAULT NULL,
  `newupdate` varchar(255) DEFAULT NULL,
  `modules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `redirect_url` varchar(192) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `website_theme` varchar(191) DEFAULT 'purpose.css',
  `credit_card_provider` varchar(191) DEFAULT 'Paystack',
  `deduction_option` varchar(191) DEFAULT 'userRequest',
  `welcome_message` text DEFAULT NULL,
  `install_type` varchar(20) DEFAULT NULL,
  `merchant_key` varchar(192) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code1message` text DEFAULT NULL,
  `code2message` text DEFAULT NULL,
  `code3message` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `code1`, `code2`, `code3`, `code4`, `description`, `code1status`, `code2status`, `code3status`, `otp`, `sms`, `currency`, `intreast`, `s_currency`, `capt_secret`, `capt_sitekey`, `payment_mode`, `location`, `s_s_k`, `s_p_k`, `pp_cs`, `pp_ci`, `keywords`, `site_title`, `site_address`, `logo`, `favicon`, `trade_mode`, `google_translate`, `weekend_trade`, `contact_email`, `timezone`, `mail_server`, `emailfrom`, `emailfromname`, `smtp_host`, `smtp_port`, `smtp_encrypt`, `smtp_user`, `smtp_password`, `google_secret`, `google_id`, `google_redirect`, `referral_commission`, `referral_commission1`, `referral_commission2`, `referral_commission3`, `referral_commission4`, `referral_commission5`, `signup_bonus`, `deposit_bonus`, `tawk_to`, `enable_2fa`, `enable_kyc`, `enable_kyc_registration`, `enable_with`, `enable_verification`, `enable_social_login`, `withdrawal_option`, `deposit_option`, `auto_merchant_option`, `dashboard_option`, `enable_annoc`, `subscription_service`, `captcha`, `return_capital`, `tido`, `address_o`, `whatsapp`, `should_cancel_plan`, `commission_type`, `commission_fee`, `monthlyfee`, `quarterlyfee`, `yearlyfee`, `newupdate`, `modules`, `redirect_url`, `address`, `website_theme`, `credit_card_provider`, `deduction_option`, `welcome_message`, `install_type`, `merchant_key`, `created_at`, `updated_at`, `code1message`, `code2message`, `code3message`) VALUES
(1, 'Remedy Grand Chase Bank', 'IMF', 'SWIFT', 'COT', NULL, NULL, NULL, NULL, NULL, 1, 0, '$', 40, 'USD', NULL, NULL, '123567', NULL, 'STRIPE_SECRET_KEY_PLACEHOLDER', 'STRIPE_PUBLIC_KEY_PLACEHOLDER', 'jijdjkdkdk', 'iidjdjdj', 'Remedy Grand online bank', 'Welcome to Grand Chase', 'https://realanalysis.sbs', 'photos/LO7qQFcV0u1MiHkqrh4KpgzAdoYeRJBE8nAalfsh.png', 'photos/cQhCTooaauQ8vMR704ms9QYoi3N1PuWueWxlrUnH.png', NULL, NULL, NULL, 'regiscapitalbank@gmail.com', 'Pacific/Wallis', 'smtp', 'regiscapitalbank@gmail.com', 'RegisCapitalBank', 'smtp.gmail.com', '587', 'tls', 'regiscapitalbank@gmail.com', 'CHANGE_ME_APP_PASSWORD', NULL, NULL, 'http://yoursite.com/auth/google/callback', '5', '30', '20', '10', '5', '1', NULL, 0, '', 'no', 'yes', 'no', NULL, 'true', NULL, 'manual', 'manual', 'Binance', 'dark', NULL, 'on', NULL, 0, NULL, '55 Aylmer Road, East Finchley, London, United Kingdom, N2 0AT', NULL, NULL, NULL, NULL, '30', '40', '80', NULL, '{\"signal\":false,\"cryptoswap\":false,\"investment\":true,\"membership\":false,\"subscription\":true}', NULL, '214 North Tryon Street, Charlotte, North Carolina, 28202', 'blue.css', 'Stripe', 'userRequest', NULL, 'Main-Domain', NULL, NULL, '2025-03-31 12:30:27', 'The IMF code is required to enable you to continue with this transaction. Please contact  our online customer care on representative with  the live chat: they will help you with the appropriate IMF code for this transaction.', 'The Federal SWIFT code is required for this transaction can be completed successfully. Please contact  our online customer care representative with  the live chat: for more details of the for this transaction.', 'The COT code is required to enable you to continue with this transaction. Please contact  our online customer care on representative with  the live chat: they will help you with the appropriate COT code for this transaction.');

-- --------------------------------------------------------

--
-- Table structure for table `settings_conts`
--

CREATE TABLE `settings_conts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `use_crypto_feature` varchar(20) NOT NULL DEFAULT 'true',
  `fee` float DEFAULT 0,
  `btc` varchar(20) NOT NULL DEFAULT 'enabled',
  `eth` varchar(20) NOT NULL DEFAULT 'enabled',
  `ltc` varchar(20) NOT NULL DEFAULT 'enabled',
  `link` varchar(20) NOT NULL DEFAULT 'enabled',
  `bnb` varchar(255) NOT NULL DEFAULT 'enabled',
  `aave` varchar(250) DEFAULT 'enabled',
  `usdt` varchar(250) NOT NULL DEFAULT 'enabled',
  `bch` varchar(255) NOT NULL DEFAULT 'enabled',
  `xlm` varchar(255) NOT NULL DEFAULT 'enabled',
  `xrp` varchar(255) NOT NULL DEFAULT 'enabled',
  `ada` varchar(255) NOT NULL DEFAULT 'enabled',
  `currency_rate` int(11) DEFAULT NULL,
  `minamt` int(11) DEFAULT NULL,
  `use_transfer` tinyint(1) DEFAULT 1,
  `min_transfer` int(11) DEFAULT 0,
  `purchase_code` varchar(191) DEFAULT 'xxxxxx',
  `transfer_charges` int(11) DEFAULT 0,
  `bnc_secret_key` varchar(191) DEFAULT NULL,
  `bnc_api_key` varchar(191) DEFAULT NULL,
  `flw_secret_hash` varchar(191) DEFAULT NULL,
  `flw_secret_key` varchar(191) DEFAULT NULL,
  `flw_public_key` varchar(191) DEFAULT NULL,
  `local_currency` varchar(20) DEFAULT NULL,
  `commission_p2p` float DEFAULT NULL,
  `enable_p2p` varchar(20) DEFAULT NULL,
  `base_currency` varchar(20) DEFAULT NULL,
  `telegram_bot_api` varchar(192) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings_conts`
--

INSERT INTO `settings_conts` (`id`, `use_crypto_feature`, `fee`, `btc`, `eth`, `ltc`, `link`, `bnb`, `aave`, `usdt`, `bch`, `xlm`, `xrp`, `ada`, `currency_rate`, `minamt`, `use_transfer`, `min_transfer`, `purchase_code`, `transfer_charges`, `bnc_secret_key`, `bnc_api_key`, `flw_secret_hash`, `flw_secret_key`, `flw_public_key`, `local_currency`, `commission_p2p`, `enable_p2p`, `base_currency`, `telegram_bot_api`, `created_at`, `updated_at`) VALUES
(1, 'false', 2, 'enabled', 'enabled', 'enabled', 'enabled', 'enabled', 'enabled', 'enabled', 'enabled', 'enabled', 'enabled', 'enabled', 500, 50, 1, 50, NULL, 3, NULL, NULL, NULL, NULL, NULL, 'NGN', 0, 'false', NULL, '5797628824:AAFZ7AeMeVRivSL0h5wr1tU3u_MmNip3mb8', '2021-10-31 18:32:30', '2023-08-06 14:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `attch` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms_privacies`
--

CREATE TABLE `terms_privacies` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `useterms` varchar(255) NOT NULL DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_privacies`
--

INSERT INTO `terms_privacies` (`id`, `description`, `useterms`, `created_at`, `updated_at`) VALUES
(1, '<p><strong>Our Commitment to You:</strong></p>\r\n\r\n<p>Thank you for showing interest in our service. In order for us to provide you with our service, we are required to collect and process certain personal data about you and your activity.</p>\r\n\r\n<p>By entrusting us with your personal data, we would like to assure you of our commitment to keep such information private and to operate in accordance with all regulatory laws and all EU data protection laws, including General Data Protection Regulation (GDPR) 679/2016 (EU).</p>\r\n\r\n<p>We have taken measurable steps to protect the confidentiality, security and integrity of this data. We encourage you to review the following information carefully.</p>\r\n\r\n<p><strong>Grounds for data collection:</strong></p>\r\n\r\n<p>Processing of your personal information (meaning, any data which may potentially allow your identification with reasonable means; hereinafter &ldquo;Personal Data&rdquo;) is necessary for the performance of our contractual obligations towards you and providing you with our services, to protect our legitimate interests and for compliance with legal and financial regulatory obligations to which we are subject.</p>\r\n\r\n<p>When you use our services, you consent to the collection, storage, use, disclosure and other uses of your Personal Data as described in this Privacy Policy.</p>\r\n\r\n<p><strong>How do we receive data about you?</strong></p>\r\n\r\n<p>We receive your Personal Data from various sources:</p>\r\n\r\n<ol>\r\n	<li>When you voluntarily provide us with your personal details in order to create an account (for example, your name and email address)</li>\r\n	<li>When you use or access our site and services, in connection with your use of our services (for example, your financial transactions)</li>\r\n	<li>&nbsp;</li>\r\n</ol>\r\n\r\n<p><strong>What type of data we collect?</strong></p>\r\n\r\n<p>In order to open an account, and in order to provide you with our services we will need you to collect the following data:</p>\r\n\r\n<p><strong>Personal Data<br />\r\nWe collect the following Personal Data about you:</strong></p>\r\n\r\n<ul>\r\n	<li><em>Registration data</em>&nbsp;&ndash; your name, email address, phone number, occupation, country of residence, and your age (in order to verify you are over 18 years of age and eligible to participate in our service).</li>\r\n	<li><em>Voluntary data</em>&nbsp;&ndash; when you communicate with us (for example when you send us an email or use a &ldquo;contact us&rdquo; form on our site) we collect the personal data you provided us with.</li>\r\n	<li><em>Financial data</em>&nbsp;&ndash; by its nature, your use of our services includes financial transactions, thus requiring us to obtain your financial details, which includes, but not limited to your payment details (such as bank account details and financial transactions performed through our services).</li>\r\n	<li><em>Technical data</em>&nbsp;&ndash; we collect certain technical data that is automatically recorded when you use our services, such as your IP address, MAC address, device approximate location</li>\r\n	<li>Non Personal Data</li>\r\n</ul>\r\n\r\n<p>We record and collect data from or about your device (for example your computer or your mobile device) when you access our services and visit our site. This includes, but not limited to: your login credentials, UDID, Google advertising ID, IDFA, cookie identifiers, and may include other identifiers such your operating system version, browser type, language preferences, time zone, referring domains and the duration of your visits. This will facilitate our ability to improve our service and personalize your experience with us.<br />\r\nIf we combine Personal Data with non-Personal Data about you, the combined data will be treated as Personal Data for as long as it remains combined.</p>\r\n\r\n<p><strong>Tracking Technologies</strong></p>\r\n\r\n<p>When you visit or access our services we use (and authorize 3rd parties to use) pixels, cookies, events and other technologies (&ldquo;Tracking Technologies&ldquo;). Those allow us to automatically collect data about you, your device and your online behavior, in order to enhance your navigation in our services, improve our site&rsquo;s performance, perform analytics and customize your experience on it. In addition, we may merge data we have with data collected through said tracking technologies with data we may obtain from other sources and, as a result, such data may become Personal Data.<br />\r\nCookie Policy page.</p>\r\n\r\n<p><strong>How do we use the data We collect?</strong></p>\r\n\r\n<ul>\r\n	<li>Provision of service &ndash; we will use your Personal Data you provide us for the provision and improvement of our services to you.</li>\r\n	<li>Marketing purposes &ndash; we will use your Personal Data (such as your email address or phone number). For example, by subscribing to our newsletter you will receive tips and announcements straight to your email account. We may also send you promotional material concerning our services or our partners&rsquo; services (which we believe may interest you), including but not limited to, by building an automated profile based on your Personal Data, for marketing purposes. You may choose not to receive our promotional or marketing emails (all or any part thereof) by clicking on the &ldquo;unsubscribe&rdquo; link in the emails that you receive from us. Please note that even if you unsubscribe from our newsletter, we may continue to send you service-related updates and notifications or reply to your queries and feedback you provide us.</li>\r\n	<li>Opt-out of receiving marketing materials &ndash; If you do not want us to use or share your personal data for marketing purposes, you may opt-out in accordance with this &ldquo;Opt-out&rdquo; section. Please note that even if you opt-out, we may still use and share your personal information with third parties for non-marketing purposes (for example to fulfill your requests, communicate with you and respond to your inquiries, etc.). In such cases, the companies with whom we share your personal data are authorized to use your Personal Data only as necessary to provide these non-marketing services.</li>\r\n	<li>Analytics, surveys and research &ndash; we are always trying to improve our services and think of new and exciting features for our users. From time to time, we may conduct surveys or test features, and analyze the information we have to develop, evaluate and improve these features.</li>\r\n	<li>Protecting our interests &ndash; we use your Personal Data when we believe it&rsquo;s necessary in order to take precautions against liabilities, investigate and defend ourselves against any third-party claims or allegations, investigate and protect ourselves from fraud, protect the security or integrity of our services and protect the rights and property of the company, its users and/or partners.</li>\r\n	<li>Enforcing of policies &ndash; we use your Personal Data in order to enforce our policies, including but limited to our Terms &amp; Conditions.</li>\r\n	<li>Compliance with legal and regulatory requirements &ndash; we also use your Personal Data to investigate violations and prevent money laundering and perform due-diligence checks, and as required by law, regulation or other governmental authority, or to comply with a subpoena or similar legal process.</li>\r\n</ul>\r\n\r\n<p><strong>With whom do we share your Personal Data</strong></p>\r\n\r\n<ul>\r\n	<li>Internal concerned parties &ndash; we share your data with companies in our group, as well as our employees limited to those employees or partners who need to know the information in order to provide you with our services.</li>\r\n	<li>Financial providers and payment processors &ndash; we share your financial data about you for purposes of accepting deposits or performing risk analysis.</li>\r\n	<li>Business partners &ndash; we share your data with business partners, such as storage providers and analytics providers who help us provide you with our service.</li>\r\n	<li>Legal and regulatory entities &ndash; we may disclose any data in case we believe, in good faith, that such disclosure is necessary in order to enforce our Terms &amp; Conditions take precautions against liabilities, investigate and defend ourselves against any third party claims or allegations, protect the security or integrity of the site and our servers and protect the rights and property, our users and/or partners. We may also disclose your personal data where requested any other regulatory authority having control or jurisdiction over us, you or our associates or in the territories we have clients or providers, as a broker.</li>\r\n	<li>Merger and acquisitions &ndash; we may share your data if we enter into a business transaction such as a merger, acquisition, reorganization, bankruptcy, or sale of some or all of our assets. Any party that acquires our assets as part of such a transaction may continue to use your data in accordance with the terms of this Privacy Policy.</li>\r\n</ul>\r\n\r\n<p><strong>Transfer of data outside the EEA</strong></p>\r\n\r\n<p>Please note that some data recipients may be located outside the EEA. In such cases, we will transfer your data only to such countries as approved by the European Commission as providing an adequate level of data protection or enter into legal agreements ensuring an adequate level of data protection.</p>\r\n\r\n<p><strong>How we protect your data</strong></p>\r\n\r\n<p>We have implemented administrative, technical, and physical safeguards to help prevent unauthorized access, use, or disclosure of your personal data. Your data is stored on secure servers and isn&rsquo;t publicly available. We limit access of your data only to those employees or partners that need to know the information in order to enable the carrying out of the agreement between us.</p>\r\n\r\n<p>You need to help us prevent unauthorized access to your account by protecting your password appropriately and limiting access to your account (for example, by signing off after you have finished accessing your account). You will be solely responsible for keeping your password confidential and for all use of your password and your account, including any unauthorized use.</p>\r\n\r\n<p>While we seek to protect your data to ensure that it is kept confidential, we cannot absolutely guarantee its security. You should be aware that there is always some risk involved in transmitting data over the internet. While we strive to protect your Personal Data, we cannot ensure or warrant the security and privacy of your personal Data or other content you transmit using the service, and you do so at your own risk.</p>\r\n\r\n<p><strong>Retention</strong></p>\r\n\r\n<p>We will retain your personal data for as long as necessary to provide our services, and as necessary to comply with our legal obligations, resolve disputes, and enforce our policies. Retention periods will be determined taking into account the type of data that is collected and the purpose for which it is collected, bearing in mind the requirements applicable to the situation and the need to destroy outdated, unused data at the earliest reasonable time. Under applicable regulations, we will keep records containing client personal data, trading information, account opening documents, communications and anything else as required by applicable laws and regulations.</p>\r\n\r\n<p><strong>User Rights</strong></p>\r\n\r\n<ol>\r\n	<li>Receive confirmation as to whether or not personal data concerning you is being processed, and access your stored personal data, together with supplementary data.</li>\r\n	<li>Receive a copy of personal data you directly volunteer to us in a structured, commonly used and machine-readable format.</li>\r\n	<li>Request rectification of your personal data that is in our control.</li>\r\n	<li>Request erasure of your personal data.</li>\r\n	<li>Object to the processing of personal data by us.</li>\r\n	<li>Request to restrict processing of your personal data by us.</li>\r\n</ol>\r\n\r\n<p>However, please note that these rights are not absolute, and may be subject to our own legitimate interests and regulatory requirements.</p>\r\n\r\n<p><strong>How to Contact us?</strong></p>\r\n\r\n<p>If you wish to exercise any of the aforementioned rights, or receive more information, please contact our General Data Protection Officer (&ldquo;GDPO&rdquo;) using the details provided below:</p>\r\n\r\n<p>Email: support@onlintrade.com</p>\r\n\r\n<p>Attn. GDPO Compliance Officer</p>\r\n\r\n<p>If you decide to terminate your account, you may do so by emailing us at support@onlintrade.com. If you terminate your account, please be aware that personal information that you have provided us may still be maintained for legal and regulatory reasons (as described above), but it will no longer be accessible via your account.</p>\r\n\r\n<p><strong>Updates to this Policy</strong></p>\r\n\r\n<p>This Privacy Policy is subject to changes from time to time, at our sole discretion. The most current version will always be posted on our website (as reflected in the &ldquo;Last Updated&rdquo; heading). You are advised to check for updates regularly. In the event of material changes, we will provide you with a notice. By continuing to access or use our services after any revisions become effective, you agree to be bound by the updated Privacy Policy.</p>', 'no', '2020-12-14 15:39:57', '2022-07-05 11:23:49');

-- --------------------------------------------------------

--
-- Table structure for table `testimonies`
--

CREATE TABLE `testimonies` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ref_key` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `what_is_said` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tp__transactions`
--

CREATE TABLE `tp__transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plan` varchar(250) DEFAULT NULL,
  `user_plan_id` int(11) DEFAULT NULL,
  `user` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kyc_id` int(11) DEFAULT NULL,
  `irs_filing_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  `middlename` varchar(40) DEFAULT NULL,
  `amount` int(40) DEFAULT NULL,
  `usernumber` varchar(22) DEFAULT NULL,
  `pin` varchar(8) DEFAULT NULL,
  `pinstatus` int(6) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `limit` int(50) DEFAULT 500000,
  `accounttype` varchar(45) DEFAULT NULL,
  `allowtransfer` int(5) DEFAULT 0,
  `transferaction` int(5) DEFAULT 0,
  `code1` varchar(30) DEFAULT NULL,
  `code2` varchar(40) DEFAULT NULL,
  `code3` varchar(50) DEFAULT NULL,
  `codestatus` int(5) DEFAULT NULL,
  `signalstatus` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `cstatus` varchar(255) DEFAULT NULL,
  `userupdate` text DEFAULT NULL,
  `assign_to` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `dashboard_style` varchar(255) NOT NULL DEFAULT 'light',
  `bank_name` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` int(30) DEFAULT NULL,
  `swift_code` varchar(255) DEFAULT NULL,
  `acnt_type_active` varchar(255) DEFAULT NULL,
  `btc_address` varchar(255) DEFAULT NULL,
  `eth_address` varchar(255) DEFAULT NULL,
  `ltc_address` varchar(255) DEFAULT NULL,
  `usdt_address` varchar(191) DEFAULT NULL,
  `plan` varchar(255) DEFAULT NULL,
  `user_plan` varchar(255) DEFAULT NULL,
  `account_bal` float NOT NULL DEFAULT 0,
  `roi` float DEFAULT NULL,
  `bonus` float DEFAULT NULL,
  `ref_bonus` float DEFAULT NULL,
  `signup_bonus` varchar(255) DEFAULT NULL,
  `auto_trade` varchar(255) DEFAULT NULL,
  `bonus_released` int(11) NOT NULL DEFAULT 0,
  `ref_by` varchar(255) DEFAULT NULL,
  `ref_link` varchar(255) DEFAULT NULL,
  `account_verify` varchar(255) DEFAULT NULL,
  `entered_at` datetime DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `last_growth` datetime DEFAULT NULL,
  `account_status` varchar(255) NOT NULL DEFAULT 'inactive',
  `status` varchar(25) DEFAULT 'active',
  `trade_mode` varchar(255) DEFAULT 'on',
  `act_session` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(255) DEFAULT NULL,
  `withdrawotp` varchar(255) DEFAULT NULL,
  `sendotpemail` varchar(255) NOT NULL DEFAULT 'Yes',
  `sendroiemail` varchar(255) NOT NULL DEFAULT 'Yes',
  `sendpromoemail` varchar(255) NOT NULL DEFAULT 'Yes',
  `sendinvplanemail` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dailyTotal` int(2) NOT NULL DEFAULT 0,
  `weeklyTotal` int(2) NOT NULL DEFAULT 0,
  `monthlyTotal` int(2) NOT NULL DEFAULT 0,
  `code1status` int(2) NOT NULL DEFAULT 1,
  `code2status` int(2) NOT NULL DEFAULT 1,
  `code3status` int(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `usernumber` (`usernumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `kyc_id`, `irs_filing_id`, `name`, `lastname`, `middlename`, `amount`, `usernumber`, `pin`, `pinstatus`, `action`, `limit`, `accounttype`, `allowtransfer`, `transferaction`, `code1`, `code2`, `code3`, `codestatus`, `signalstatus`, `email`, `username`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `dob`, `cstatus`, `userupdate`, `assign_to`, `address`, `country`, `phone`, `dashboard_style`, `bank_name`, `account_name`, `account_number`, `swift_code`, `acnt_type_active`, `btc_address`, `eth_address`, `ltc_address`, `usdt_address`, `plan`, `user_plan`, `account_bal`, `roi`, `bonus`, `ref_bonus`, `signup_bonus`, `auto_trade`, `bonus_released`, `ref_by`, `ref_link`, `account_verify`, `entered_at`, `activated_at`, `last_growth`, `account_status`, `status`, `trade_mode`, `act_session`, `remember_token`, `current_team_id`, `profile_photo_path`, `withdrawotp`, `sendotpemail`, `sendroiemail`, `sendpromoemail`, `sendinvplanemail`, `created_at`, `updated_at`, `dailyTotal`, `weeklyTotal`, `monthlyTotal`, `code1status`, `code2status`, `code3status`) VALUES
(1, NULL, '1kiWJUb0LJcEC', 'real', 'real', 'analysis', NULL, '77990250980', '1234', 0, NULL, 500000, 'Checking Account', 0, 0, '1234', '1234', '1234', NULL, NULL, 'real12@gmail.com', 'real12', '2025-03-20 13:49:24', '$2a$12$E60NDosJBfToRnu70Zj3ye7mJBuopaXL1.MTIOPHvv1vlq.7PV9GK', NULL, NULL, '1999-02-06', NULL, NULL, NULL, '333 freemont street', 'United States of America', '4123425364', 'light', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', 1181860, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'http://localhost/remedygrandbank/ref/real12', 'Verified', '2025-03-24 13:03:47', NULL, NULL, 'active', 'active', 'on', NULL, 'o8wAw5ZKwCVElG7hFUBBulOMcHupbCFfdfPCLsIVmMCqN7YOel4TwAThCbUu', NULL, '765359phu.jpg1743421781', 'VAA4GQ', 'Yes', 'Yes', 'Yes', 'Yes', '2020-03-20 13:48:29', '2025-03-31 19:15:12', 0, 0, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_plans`
--

CREATE TABLE `user_plans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plan` int(11) DEFAULT NULL,
  `user` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `active` varchar(255) DEFAULT NULL,
  `inv_duration` varchar(255) DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `last_growth` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profit_earned` float DEFAULT NULL,
  `facility` text DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `purpose` longtext DEFAULT NULL,
  `income` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_plans`
--

INSERT INTO `user_plans` (`id`, `plan`, `user`, `amount`, `active`, `inv_duration`, `expire_date`, `activated_at`, `last_growth`, `created_at`, `updated_at`, `profit_earned`, `facility`, `duration`, `purpose`, `income`) VALUES
(1, NULL, 240, '500000', 'Processed', '12', NULL, '2025-03-24 13:03:47', '2025-03-24 13:03:47', '2025-03-24 12:03:47', '2025-03-24 12:29:55', NULL, 'Operational Vehicles', '12', 'car', '2,000-5,000');

-- --------------------------------------------------------

--
-- Table structure for table `wdmethods`
--

CREATE TABLE `wdmethods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `minimum` varchar(255) DEFAULT NULL,
  `maximum` varchar(255) DEFAULT NULL,
  `charges_amount` varchar(255) DEFAULT NULL,
  `charges_type` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `img_url` text DEFAULT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `swift_code` varchar(255) DEFAULT NULL,
  `wallet_address` text DEFAULT NULL,
  `barcode` text DEFAULT NULL,
  `network` varchar(255) DEFAULT NULL,
  `methodtype` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `defaultpay` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wdmethods`
--

INSERT INTO `wdmethods` (`id`, `name`, `minimum`, `maximum`, `charges_amount`, `charges_type`, `duration`, `img_url`, `bankname`, `account_name`, `account_number`, `swift_code`, `wallet_address`, `barcode`, `network`, `methodtype`, `type`, `status`, `defaultpay`, `created_at`, `updated_at`) VALUES
(1, 'Bitcoin', '50', '10003445566', '0', 'percentage', 'Instant', 'data:image/png;base64,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', NULL, NULL, NULL, NULL, 'bc1qxcent8w83edpcz0sjd80aukgk84jj9tzgjv7em', '938893993', 'Bitcoin', 'crypto', 'both', 'enabled', 'yes', '2021-03-11 17:53:32', '2025-03-30 21:41:30'),
(2, 'Ethereum', '10', '2100', '0', 'percentage', 'Instant', 'https://lulo.com', NULL, NULL, NULL, NULL, 'dddddddddddddddddddddddd', '938893993', 'Erc', 'crypto', 'withdrawal', 'disabled', 'yes', '2021-03-22 15:36:03', '2023-02-23 12:28:34'),
(3, 'Litecoin', '100', '10000', '0', '0', 'Instant', 'https://lulo.com', NULL, NULL, NULL, NULL, 'hhhhhhhhhhhhhhhhhhhhhhh', 'hhhhhhhhhhh', 'Erc', 'crypto', 'both', 'disabled', 'yes', '2021-03-22 15:36:33', '2023-02-23 12:28:54'),
(10, 'Paypal', '10', '10000', '0', 'percentage', 'Instant Payment', 'https://lulo.com', 'Automatic', 'Automatic', '99388383', NULL, NULL, NULL, NULL, 'currency', 'deposit', 'enabled', 'yes', '2021-10-07 13:56:14', '2025-03-24 00:09:50'),
(12, 'Bank Transfer', '100', '1000000000000000000', '0', 'percentage', 'Instant Payment', NULL, 'Mining Bank', 'Miller lauren', '99388383', '3222ASD', NULL, NULL, NULL, 'currency', 'both', 'enabled', 'yes', '2021-10-11 16:35:35', '2023-03-27 02:02:51'),
(21, 'USDT', '0', '1000000000', '0', 'percentage', 'Instant Payment', NULL, NULL, NULL, NULL, NULL, 'TPCRRGUkpsnFM3r5cu9JfdeXBvhZoygbRnr correct wallet address here', NULL, 'TRC20', 'crypto', 'both', 'disabled', 'yes', '2021-04-14 14:45:06', '2023-03-12 23:08:46'),
(23, 'BUSD', '0', '1000', '0', 'percentage', NULL, NULL, NULL, NULL, NULL, NULL, 'Enter your correct wallet address here', NULL, 'ERC20', 'crypto', 'withdrawal', 'disabled', 'yes', '2022-06-28 04:25:41', '2023-02-23 12:31:17'),
(24, 'Credit Card', '0', '0', '0', 'percentage', 'Instant Payment', NULL, '-', '-', '0', NULL, NULL, NULL, NULL, 'currency', 'deposit', 'disabled', 'yes', '2022-07-20 17:02:29', '2023-03-27 02:05:31'),
(25, 'USDT', '20', '4000000', '0', 'percentage', 'Instant Payment', 'https://assets.coingecko.com/coins/images/325/standard/Tether.png?1696501661', NULL, NULL, NULL, NULL, 'TGxcexCE4bm5nBzamRReNPhMzQTeQQrHQj', NULL, 'TRC20', 'crypto', 'both', 'enabled', NULL, '2025-03-30 21:50:07', '2025-03-30 21:52:38');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(255) DEFAULT NULL,
  `date` timestamp(6) NULL DEFAULT NULL,
  `user` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `columns` varchar(255) DEFAULT NULL,
  `bal` varchar(255) DEFAULT NULL,
  `accountname` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `accountnumber` text DEFAULT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `Accounttype` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `bankaddress` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `swiftcode` varchar(50) DEFAULT NULL,
  `iban` varchar(35) DEFAULT NULL,
  `to_deduct` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `paydetails` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `crypto_currency` varchar(50) DEFAULT NULL,
  `crypto_network` varchar(50) DEFAULT NULL,
  `wallet_address` varchar(255) DEFAULT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `wise_fullname` varchar(255) DEFAULT NULL,
  `wise_email` varchar(255) DEFAULT NULL,
  `wise_country` varchar(100) DEFAULT NULL,
  `skrill_email` varchar(255) DEFAULT NULL,
  `skrill_fullname` varchar(255) DEFAULT NULL,
  `venmo_username` varchar(255) DEFAULT NULL,
  `venmo_phone` varchar(50) DEFAULT NULL,
  `zelle_email` varchar(255) DEFAULT NULL,
  `zelle_phone` varchar(50) DEFAULT NULL,
  `zelle_name` varchar(255) DEFAULT NULL,
  `cash_app_tag` varchar(255) DEFAULT NULL,
  `cash_app_fullname` varchar(255) DEFAULT NULL,
  `revolut_fullname` varchar(255) DEFAULT NULL,
  `revolut_email` varchar(255) DEFAULT NULL,
  `revolut_phone` varchar(50) DEFAULT NULL,
  `alipay_id` varchar(255) DEFAULT NULL,
  `alipay_fullname` varchar(255) DEFAULT NULL,
  `wechat_id` varchar(255) DEFAULT NULL,
  `wechat_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `card_transactions`
--
ALTER TABLE `card_transactions`
  ADD CONSTRAINT `card_transactions_card_id_foreign` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `card_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;