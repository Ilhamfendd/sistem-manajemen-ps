-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 10 Des 2025 pada 10.05
-- Versi server: 9.1.0
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ps_manager`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nomor HP pelanggan',
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama pelanggan',
  `console_id` int NOT NULL,
  `booking_date` date NOT NULL COMMENT 'Tanggal yang diminta',
  `booking_start_time` time DEFAULT NULL COMMENT 'Jam mulai yang diminta',
  `duration_hours` decimal(5,2) NOT NULL COMMENT 'Durasi dalam jam',
  `estimated_cost` bigint NOT NULL COMMENT 'Biaya estimasi',
  `status` enum('pending','approved','waiting_customer','rejected','expired','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','paid') COLLATE utf8mb4_unicode_ci DEFAULT 'unpaid',
  `notes` text COLLATE utf8mb4_unicode_ci COMMENT 'Catatan dari kasir',
  `created_at` datetime NOT NULL,
  `approved_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL COMMENT '24 jam setelah created_at untuk auto-cancel',
  `paid_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `phone` (`phone`),
  KEY `console_id` (`console_id`),
  KEY `status` (`status`),
  KEY `payment_status` (`payment_status`),
  KEY `booking_date` (`booking_date`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `customer_id`, `phone`, `full_name`, `console_id`, `booking_date`, `booking_start_time`, `duration_hours`, `estimated_cost`, `status`, `payment_status`, `notes`, `created_at`, `approved_at`, `expires_at`, `paid_at`) VALUES
(7, 13, '081371301866', 'Hamilton', 25, '2025-12-10', '07:57:04', 1.00, 0, 'approved', 'unpaid', NULL, '2025-12-10 07:57:04', '2025-12-10 08:00:00', '2025-12-10 08:15:00', NULL),
(8, 13, '081371301866', 'Hamilton', 21, '2025-12-10', '08:02:55', 1.00, 0, 'approved', 'unpaid', NULL, '2025-12-10 08:02:55', '2025-12-10 08:03:33', '2025-12-10 08:18:33', NULL),
(9, 13, '081371301866', 'Hamilton', 31, '2025-12-10', '08:06:29', 1.00, 7000, 'approved', 'unpaid', NULL, '2025-12-10 08:06:29', '2025-12-10 08:06:34', '2025-12-10 08:21:34', NULL),
(10, 13, '081371301866', 'Hamilton', 21, '2025-12-10', '08:07:43', 1.00, 5000, 'approved', 'unpaid', NULL, '2025-12-10 08:07:43', '2025-12-10 08:07:49', '2025-12-10 08:22:49', NULL),
(11, 13, '081371301866', 'Hamilton', 21, '2025-12-10', '08:10:05', 1.00, 5000, 'approved', 'unpaid', NULL, '2025-12-10 08:10:05', '2025-12-10 08:10:10', '2025-12-10 08:25:10', NULL),
(12, 13, '081371301866', 'Hamilton', 22, '2025-12-10', '08:12:09', 1.00, 5000, 'approved', 'unpaid', NULL, '2025-12-10 08:12:09', '2025-12-10 08:12:13', '2025-12-10 08:27:13', NULL),
(13, 13, '081371301866', 'Hamilton', 22, '2025-12-10', '08:14:03', 1.00, 5000, 'approved', 'unpaid', NULL, '2025-12-10 08:14:03', '2025-12-10 08:14:11', '2025-12-10 08:29:11', NULL),
(14, 14, '081371301869', 'Ilham', 31, '2025-12-10', '08:15:31', 1.00, 7000, 'approved', 'unpaid', NULL, '2025-12-10 08:15:31', '2025-12-10 08:16:33', '2025-12-10 08:31:33', NULL),
(15, 13, '081371301866', 'Hamilton', 31, '2025-12-10', '08:20:05', 1.00, 7000, 'approved', 'unpaid', NULL, '2025-12-10 08:20:05', '2025-12-10 08:20:10', '2025-12-10 08:35:10', NULL),
(16, 14, '081371301869', 'Ilham', 27, '2025-12-10', '08:21:47', 1.00, 5000, 'approved', 'unpaid', NULL, '2025-12-10 08:21:47', '2025-12-10 08:21:53', '2025-12-10 08:36:53', NULL),
(17, 14, '081371301869', 'Ilham', 22, '2025-12-10', '08:22:09', 1.00, 5000, 'approved', 'unpaid', NULL, '2025-12-10 08:22:09', '2025-12-10 08:22:16', '2025-12-10 08:37:16', NULL),
(18, 19, '0869219961', 'Test Customer 5681', 21, '2025-12-10', '02:41:29', 2.00, 10000, 'approved', 'unpaid', NULL, '2025-12-10 02:41:29', '2025-12-10 02:41:29', '2025-12-10 02:56:29', NULL),
(19, 14, '081371301869', 'Ilham', 21, '2025-12-10', '09:45:40', 1.00, 5000, 'approved', 'unpaid', NULL, '2025-12-10 09:45:40', '2025-12-10 09:45:52', '2025-12-10 10:00:52', NULL),
(20, 14, '081371301869', 'Ilham', 27, '2025-12-10', '10:05:26', 1.00, 5000, 'completed', 'unpaid', NULL, '2025-12-10 10:05:26', '2025-12-10 10:05:42', '2025-12-10 10:20:42', NULL),
(21, 14, '081371301869', 'Ilham', 21, '2025-12-10', '10:13:07', 1.00, 5000, 'completed', 'unpaid', NULL, '2025-12-10 10:13:07', '2025-12-10 10:16:01', '2025-12-10 10:31:01', NULL),
(22, 14, '081371301869', 'Ilham', 21, '2025-12-10', '10:14:24', 1.00, 5000, 'completed', 'unpaid', NULL, '2025-12-10 10:14:24', '2025-12-10 10:15:37', '2025-12-10 10:30:37', NULL),
(23, 14, '081371301869', 'Ilham', 22, '2025-12-10', '10:21:03', 1.00, 5000, 'waiting_customer', 'unpaid', NULL, '2025-12-10 10:21:03', '2025-12-10 10:21:31', '2025-12-10 10:36:31', NULL),
(24, 14, '081371301869', 'Ilham', 23, '2025-12-10', '10:32:36', 1.00, 5000, 'rejected', 'unpaid', 'p', '2025-12-10 10:32:36', '2025-12-10 10:33:27', '2025-12-10 10:48:27', NULL),
(25, 14, '081371301869', 'Ilham', 24, '2025-12-10', '10:33:59', 1.00, 5000, 'completed', 'unpaid', NULL, '2025-12-10 10:33:59', '2025-12-10 10:38:49', '2025-12-10 10:53:49', NULL),
(26, 14, '081371301869', 'Ilham', 24, '2025-12-10', '10:38:42', 1.00, 5000, 'completed', 'unpaid', NULL, '2025-12-10 10:38:42', '2025-12-10 10:38:52', '2025-12-10 10:53:52', NULL),
(27, 14, '081371301869', 'Ilham', 25, '2025-12-10', '10:43:58', 1.00, 5000, 'rejected', 'unpaid', 'konsole suda h di pesan', '2025-12-10 10:43:58', NULL, NULL, NULL),
(28, 14, '081371301869', 'Ilham', 25, '2025-12-10', '10:44:19', 1.00, 5000, 'completed', 'unpaid', NULL, '2025-12-10 10:44:19', '2025-12-10 10:44:25', '2025-12-10 10:59:25', NULL),
(29, 14, '081371301869', 'Ilham', 21, '2025-12-10', '10:46:25', 1.00, 5000, 'completed', 'unpaid', NULL, '2025-12-10 10:46:25', '2025-12-10 10:48:12', '2025-12-10 11:03:12', NULL),
(30, 14, '081371301869', 'Ilham', 22, '2025-12-10', '10:51:36', 1.00, 5000, 'completed', 'unpaid', NULL, '2025-12-10 10:51:36', '2025-12-10 10:51:50', '2025-12-10 11:06:50', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `consoles`
--

DROP TABLE IF EXISTS `consoles`;
CREATE TABLE IF NOT EXISTS `consoles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `console_name` varchar(50) NOT NULL,
  `console_type` enum('PS3','PS4','PS5') DEFAULT NULL,
  `status` enum('available','di_pesan','in_use','maintenance') NOT NULL DEFAULT 'available',
  `price_per_hour` int DEFAULT '5000',
  `note` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `consoles`
--

INSERT INTO `consoles` (`id`, `console_name`, `console_type`, `status`, `price_per_hour`, `note`, `created_at`) VALUES
(21, 'Unit PS3 - 1', 'PS3', 'in_use', 5000, 'PlayStation 3 Unit 1', '2025-12-02 11:24:07'),
(22, 'Unit PS3 - 2', 'PS3', 'in_use', 5000, 'PlayStation 3 Unit 2', '2025-12-02 11:24:07'),
(23, 'Unit PS3 - 3', 'PS3', 'available', 5000, 'PlayStation 3 Unit 3', '2025-12-02 11:24:07'),
(24, 'Unit PS3 - 4', 'PS3', 'in_use', 5000, 'PlayStation 3 Unit 4', '2025-12-02 11:24:07'),
(25, 'Unit PS3 - 5', 'PS3', 'in_use', 5000, 'PlayStation 3 Unit 5', '2025-12-02 11:24:07'),
(26, 'Unit PS3 - 6', 'PS3', 'in_use', 5000, 'PlayStation 3 Unit 6', '2025-12-02 11:24:07'),
(27, 'Unit PS3 - 7', 'PS3', 'in_use', 5000, 'PlayStation 3 Unit 7', '2025-12-02 11:24:07'),
(28, 'Unit PS3 - 8', 'PS3', 'maintenance', 5000, 'PlayStation 3 Unit 8', '2025-12-02 11:24:07'),
(30, 'Unit PS4 - 1', 'PS4', 'maintenance', 6000, '', '2025-12-02 21:13:31'),
(31, 'Unit PS4 - 2', 'PS4', 'available', 7000, '', '2025-12-02 22:00:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `console_price_history`
--

DROP TABLE IF EXISTS `console_price_history`;
CREATE TABLE IF NOT EXISTS `console_price_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `console_id` int NOT NULL,
  `old_price` int DEFAULT NULL,
  `new_price` int NOT NULL,
  `changed_by` int NOT NULL,
  `changed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `console_id` (`console_id`),
  KEY `changed_by` (`changed_by`),
  KEY `changed_at` (`changed_at`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `console_price_history`
--

INSERT INTO `console_price_history` (`id`, `console_id`, `old_price`, `new_price`, `changed_by`, `changed_at`) VALUES
(1, 28, 10000, 5000, 2, '2025-12-02 04:26:33'),
(2, 27, 10000, 5000, 2, '2025-12-02 04:27:07'),
(3, 26, 10000, 5000, 2, '2025-12-02 04:27:13'),
(4, 25, 10000, 5000, 2, '2025-12-02 04:27:21'),
(5, 24, 10000, 5000, 2, '2025-12-02 04:27:29'),
(6, 23, 10000, 5000, 2, '2025-12-02 04:27:36'),
(7, 22, 10000, 5000, 2, '2025-12-02 04:27:44'),
(8, 21, 10000, 5000, 2, '2025-12-02 04:27:52'),
(9, 30, 7000, 6000, 1, '2025-12-02 15:01:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(120) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `note` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `phone`, `note`, `created_at`) VALUES
(13, 'Hamilton', '081371301866', '', '2025-12-09 20:53:46'),
(14, 'Ilham', '081371301869', NULL, '2025-12-09 21:43:25'),
(15, 'lana', '081371301860', NULL, '2025-12-09 22:16:34'),
(16, 'o', '081371301868', NULL, '2025-12-09 22:17:40'),
(17, 'minecraft', '0813713018677', NULL, '2025-12-09 22:18:04'),
(18, 'Test User', '081234567890', NULL, '2025-12-09 22:19:16'),
(19, 'Test Customer 5681', '0869219961', NULL, '2025-12-10 09:41:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `description`, `is_active`, `created_at`) VALUES
(1, 'Tunai', 'Pembayaran tunai langsung', 1, '2025-11-30 11:49:23'),
(2, 'Transfer Bank', 'Transfer ke rekening GO-KOPI', 1, '2025-11-30 11:49:23'),
(3, 'E-Wallet', 'Pembayaran via e-wallet', 1, '2025-11-30 11:49:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rentals`
--

DROP TABLE IF EXISTS `rentals`;
CREATE TABLE IF NOT EXISTS `rentals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `console_id` int NOT NULL,
  `start_time` datetime NOT NULL,
  `actual_start_time` datetime DEFAULT NULL,
  `estimated_hours` int DEFAULT '1',
  `end_time` datetime DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  `total_cost` int DEFAULT NULL,
  `status` enum('ongoing','finished') DEFAULT 'ongoing',
  `payment_status` enum('pending','paid','partial') DEFAULT 'pending',
  `total_amount` int DEFAULT '0',
  `estimated_cost` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `rentals`
--

INSERT INTO `rentals` (`id`, `customer_id`, `console_id`, `start_time`, `actual_start_time`, `estimated_hours`, `end_time`, `duration_minutes`, `total_cost`, `status`, `payment_status`, `total_amount`, `estimated_cost`, `created_at`) VALUES
(38, 4, 22, '2025-12-02 18:05:36', '2025-12-02 18:09:47', 2, '2025-12-02 18:10:04', 5, NULL, 'finished', 'paid', 10000, 10000, '2025-12-02 18:05:36'),
(28, 5, 23, '2025-12-02 11:59:56', NULL, 2, '2025-12-02 12:00:29', 1, NULL, 'finished', 'paid', 10000, 10000, '2025-12-02 11:59:56'),
(79, 18, 27, '2025-12-10 17:02:48', NULL, 3, NULL, NULL, NULL, 'ongoing', 'paid', 0, 15000, '2025-12-10 17:02:48'),
(30, 5, 23, '2025-12-02 12:01:03', NULL, 2, '2025-12-02 12:03:19', 3, NULL, 'finished', 'paid', 10000, 10000, '2025-12-02 12:01:03'),
(46, 9, 22, '2025-12-02 19:17:45', '2025-12-02 19:18:05', 2, '2025-12-02 20:04:52', 47, NULL, 'finished', 'paid', 10000, 10000, '2025-12-02 19:17:45'),
(35, 3, 23, '2025-12-02 17:25:59', NULL, 4, '2025-12-02 17:28:15', 3, NULL, 'finished', 'paid', 20000, 20000, '2025-12-02 17:25:59'),
(36, 3, 25, '2025-12-02 17:59:44', '2025-12-02 18:09:42', 4, '2025-12-02 18:10:05', 11, NULL, 'finished', 'paid', 20000, 20000, '2025-12-02 17:59:44'),
(37, 3, 24, '2025-12-02 18:04:20', '2025-12-02 18:09:44', 4, '2025-12-02 18:10:03', 6, NULL, 'finished', 'paid', 20000, 20000, '2025-12-02 18:04:20'),
(39, 4, 23, '2025-12-02 18:13:05', '2025-12-02 18:13:18', 4, '2025-12-02 18:13:23', 1, NULL, 'finished', 'paid', 20000, 20000, '2025-12-02 18:13:05'),
(40, 5, 24, '2025-12-02 18:13:51', '2025-12-02 18:14:08', 3, '2025-12-02 18:14:09', 1, NULL, 'finished', 'paid', 15000, 15000, '2025-12-02 18:13:51'),
(42, 4, 23, '2025-12-02 18:37:44', '2025-12-02 18:37:56', 2, '2025-12-02 18:37:57', 1, NULL, 'finished', 'paid', 10000, 10000, '2025-12-02 18:37:44'),
(45, 1, 21, '2025-12-02 18:49:39', '2025-12-02 18:49:55', 5, '2025-12-02 18:49:58', 1, NULL, 'finished', 'paid', 25000, 25000, '2025-12-02 18:49:39'),
(61, 11, 31, '2025-12-09 18:24:07', '2025-12-09 18:24:23', 4, '2025-12-09 18:24:31', 1, NULL, 'finished', 'paid', 28000, 28000, '2025-12-09 18:24:07'),
(48, 7, 24, '2025-12-02 19:18:33', '2025-12-02 19:18:37', 3, '2025-12-03 17:27:26', 1329, NULL, 'finished', 'paid', 110750, 15000, '2025-12-02 19:18:33'),
(60, 12, 21, '2025-12-02 22:02:58', '2025-12-02 22:03:10', 4, '2025-12-02 22:03:11', 1, NULL, 'finished', 'paid', 20000, 20000, '2025-12-02 22:02:58'),
(50, 3, 25, '2025-12-02 19:19:15', '2025-12-02 19:19:23', 3, '2025-12-02 21:48:53', 150, NULL, 'finished', 'paid', 15000, 15000, '2025-12-02 19:19:15'),
(59, 12, 31, '2025-12-02 22:01:51', '2025-12-02 22:02:19', 3, '2025-12-02 22:02:35', 1, NULL, 'finished', 'paid', 21000, 21000, '2025-12-02 22:01:51'),
(52, 9, 27, '2025-12-02 19:19:49', '2025-12-02 19:19:56', 1, '2025-12-02 19:22:22', 3, NULL, 'finished', 'paid', 5000, 5000, '2025-12-02 19:19:49'),
(53, 1, 27, '2025-12-02 19:25:41', '2025-12-02 19:25:58', 5, '2025-12-02 19:26:00', 1, NULL, 'finished', 'paid', 25000, 25000, '2025-12-02 19:25:41'),
(54, 10, 27, '2025-12-02 20:04:06', '2025-12-02 20:04:43', 4, '2025-12-03 17:27:26', 1283, NULL, 'finished', 'paid', 106917, 20000, '2025-12-02 20:04:06'),
(55, 4, 23, '2025-12-02 20:27:09', '2025-12-02 20:27:48', 4, '2025-12-03 17:27:26', 1260, NULL, 'finished', 'paid', 105000, 20000, '2025-12-02 20:27:09'),
(56, 10, 21, '2025-12-02 20:28:20', '2025-12-02 20:28:35', 3, '2025-12-02 20:28:40', 1, NULL, 'finished', 'paid', 15000, 15000, '2025-12-02 20:28:20'),
(57, 11, 21, '2025-12-02 20:34:25', '2025-12-02 20:34:39', 24, '2025-12-02 20:34:49', 1, NULL, 'finished', 'paid', 120000, 120000, '2025-12-02 20:34:25'),
(62, 13, 22, '2025-12-09 21:08:09', '2025-12-09 21:42:59', 3, '2025-12-09 21:43:01', 1, NULL, 'finished', 'paid', 15000, 15000, '2025-12-09 21:08:09'),
(63, 14, 27, '2025-12-10 10:06:25', '2025-12-10 10:06:37', 1, '2025-12-10 10:45:43', 40, NULL, 'finished', 'paid', 5000, 5000, '2025-12-10 10:06:25'),
(64, 14, 21, '2025-12-10 10:16:07', '2025-12-10 10:45:31', 1, '2025-12-10 10:45:41', 1, NULL, 'finished', 'paid', 5000, 5000, '2025-12-10 10:16:07'),
(65, 14, 21, '2025-12-10 10:16:18', '2025-12-10 10:45:27', 1, '2025-12-10 10:45:39', 1, NULL, 'finished', 'paid', 5000, 5000, '2025-12-10 10:16:18'),
(66, 14, 24, '2025-12-10 10:38:59', '2025-12-10 10:45:24', 1, '2025-12-10 10:45:37', 1, NULL, 'finished', 'paid', 5000, 5000, '2025-12-10 10:38:59'),
(67, 14, 24, '2025-12-10 10:39:12', '2025-12-10 10:45:22', 1, '2025-12-10 10:45:35', 1, NULL, 'finished', 'paid', 5000, 5000, '2025-12-10 10:39:12'),
(68, 14, 25, '2025-12-10 10:44:51', '2025-12-10 10:45:20', 1, '2025-12-10 10:45:33', 1, NULL, 'finished', 'paid', 5000, 5000, '2025-12-10 10:44:51'),
(69, 14, 21, '2025-12-10 10:50:22', '2025-12-10 10:50:45', 1, '2025-12-10 11:58:23', 68, NULL, 'finished', 'paid', 5667, 5000, '2025-12-10 10:50:22'),
(70, 14, 22, '2025-12-10 10:52:00', '2025-12-10 10:52:09', 1, '2025-12-10 11:58:23', 67, NULL, 'finished', 'paid', 5583, 5000, '2025-12-10 10:52:00'),
(71, 19, 23, '2025-12-10 15:12:04', NULL, 3, '2025-12-10 15:43:25', 32, NULL, 'finished', 'paid', 15000, 15000, '2025-12-10 15:12:04'),
(72, 18, 22, '2025-12-10 16:42:16', NULL, 2, '2025-12-10 16:42:25', 1, NULL, 'finished', 'paid', 10000, 10000, '2025-12-10 16:42:16'),
(73, 19, 22, '2025-12-10 16:43:00', NULL, 3, NULL, NULL, NULL, 'ongoing', 'paid', 0, 15000, '2025-12-10 16:43:00'),
(74, 19, 21, '2025-12-10 16:43:38', NULL, 2, NULL, NULL, NULL, 'ongoing', 'pending', 0, 10000, '2025-12-10 16:43:38'),
(75, 18, 25, '2025-12-10 16:45:43', NULL, 2, '2025-12-10 16:46:03', 1, NULL, 'finished', 'paid', 10000, 10000, '2025-12-10 16:45:43'),
(76, 19, 24, '2025-12-10 16:54:30', NULL, 3, NULL, NULL, NULL, 'ongoing', 'paid', 0, 15000, '2025-12-10 16:54:30'),
(77, 18, 25, '2025-12-10 16:56:24', NULL, 3, NULL, NULL, NULL, 'ongoing', 'paid', 0, 15000, '2025-12-10 16:56:24'),
(78, 18, 26, '2025-12-10 17:00:36', NULL, 3, NULL, NULL, NULL, 'ongoing', 'paid', 0, 15000, '2025-12-10 17:00:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rental_id` int NOT NULL,
  `amount` int NOT NULL,
  `payment_method_id` int NOT NULL,
  `paid_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_amount` int DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `rental_id` (`rental_id`),
  KEY `payment_method_id` (`payment_method_id`),
  KEY `created_by` (`created_by`),
  KEY `paid_at` (`paid_at`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `rental_id`, `amount`, `payment_method_id`, `paid_at`, `change_amount`, `notes`, `created_by`, `created_at`) VALUES
(15, 28, 10000, 2, '2025-12-02 12:00:01', 0, 'Pembayaran awal (estimasi). ', 1, '2025-12-02 05:00:01'),
(18, 30, 10000, 2, '2025-12-02 12:01:07', 0, 'Pembayaran awal (estimasi). ', 1, '2025-12-02 05:01:07'),
(25, 35, 19000, 1, '2025-12-02 17:28:04', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 10:28:04'),
(26, 36, 20000, 1, '2025-12-02 17:59:57', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 10:59:57'),
(27, 37, 20000, 3, '2025-12-02 18:04:24', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 11:04:24'),
(28, 38, 10000, 3, '2025-12-02 18:09:37', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 11:09:37'),
(29, 39, 10000, 3, '2025-12-02 18:13:12', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 11:13:12'),
(30, 39, 0, 1, '2025-12-02 18:13:38', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-02 11:13:38'),
(31, 40, 1000, 2, '2025-12-02 18:14:06', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 11:14:06'),
(32, 40, 0, 2, '2025-12-02 18:14:17', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-02 11:14:17'),
(34, 42, 1000, 1, '2025-12-02 18:37:53', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 11:37:53'),
(36, 39, 10000, 2, '2025-12-02 18:48:44', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-02 11:48:44'),
(37, 40, 14000, 1, '2025-12-02 18:48:59', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-02 11:48:59'),
(38, 45, 20000, 1, '2025-12-02 18:49:51', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 11:49:51'),
(39, 45, 5000, 1, '2025-12-02 18:55:17', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-02 11:55:17'),
(40, 46, 10000, 2, '2025-12-02 19:17:50', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 12:17:50'),
(42, 48, 15000, 2, '2025-12-02 19:18:36', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 12:18:36'),
(44, 50, 15000, 3, '2025-12-02 19:19:20', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 12:19:20'),
(46, 52, 5000, 3, '2025-12-02 19:19:55', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 12:19:55'),
(47, 53, 20000, 3, '2025-12-02 19:25:53', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 12:25:53'),
(48, 53, 5000, 3, '2025-12-02 19:26:17', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-02 12:26:17'),
(49, 54, 20000, 3, '2025-12-02 20:04:27', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 13:04:27'),
(50, 55, 20000, 3, '2025-12-02 20:27:28', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 13:27:28'),
(51, 56, 13000, 3, '2025-12-02 20:28:31', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 13:28:31'),
(52, 56, 2000, 3, '2025-12-02 20:29:05', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-02 13:29:05'),
(53, 57, 120000, 1, '2025-12-02 20:34:36', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 13:34:36'),
(56, 59, 21000, 1, '2025-12-02 22:02:05', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 15:02:05'),
(57, 60, 19000, 1, '2025-12-02 22:03:06', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-02 15:03:06'),
(58, 60, 1000, 3, '2025-12-02 22:03:35', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-02 15:03:35'),
(59, 48, 95750, 1, '2025-12-03 17:27:35', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-03 10:27:35'),
(60, 61, 20000, 1, '2025-12-09 18:24:20', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-09 11:24:20'),
(61, 61, 8000, 1, '2025-12-09 18:24:48', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-09 11:24:48'),
(62, 62, 15000, 1, '2025-12-09 21:43:07', 0, 'Penyesuaian pembayaran (durasi sebenarnya).', 1, '2025-12-09 14:43:07'),
(63, 63, 5000, 1, '2025-12-10 10:06:34', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-10 03:06:34'),
(64, 64, 5000, 1, '2025-12-10 10:16:16', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-10 03:16:16'),
(65, 65, 5000, 2, '2025-12-10 10:16:23', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-10 03:16:23'),
(66, 66, 5000, 1, '2025-12-10 10:39:06', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-10 03:39:06'),
(67, 67, 5000, 1, '2025-12-10 10:39:20', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-10 03:39:20'),
(68, 68, 5000, 1, '2025-12-10 10:44:58', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-10 03:44:58'),
(69, 69, 5000, 1, '2025-12-10 10:50:30', 0, 'Pembayaran awal (estimasi).', 1, '2025-12-10 03:50:30'),
(70, 72, 10000, 3, '2025-12-10 16:42:21', 0, 'Pembayaran awal (estimasi). ', 1, '2025-12-10 09:42:21'),
(71, 73, 15000, 2, '2025-12-10 16:43:15', 0, 'Pembayaran awal (estimasi). ', 1, '2025-12-10 09:43:15'),
(72, 75, 1000, 1, '2025-12-10 16:45:56', 0, 'Pembayaran awal (estimasi). ', 1, '2025-12-10 09:45:56'),
(73, 71, 15000, 1, '2025-12-10 16:52:11', 0, 'Pembayaran cicilan/pelunasan. ', 1, '2025-12-10 09:52:11'),
(74, 70, 5583, 2, '2025-12-10 16:54:12', 0, 'Pembayaran cicilan/pelunasan. ', 1, '2025-12-10 09:54:12'),
(75, 76, 15000, 3, '2025-12-10 16:54:34', 0, 'Pembayaran awal (estimasi). ', 1, '2025-12-10 09:54:34'),
(76, 77, 15000, 3, '2025-12-10 16:56:29', 0, 'Pembayaran awal (estimasi). ', 1, '2025-12-10 09:56:29'),
(77, 78, 15000, 2, '2025-12-10 17:00:40', 0, 'Pembayaran awal (estimasi). ', 1, '2025-12-10 10:00:40'),
(78, 79, 15000, 2, '2025-12-10 17:02:52', 0, 'Pembayaran awal (estimasi). ', 1, '2025-12-10 10:02:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('kasir','owner') DEFAULT 'kasir',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Kasir', 'kasir@example.com', 'kasir', 'kasir', '2025-11-09 17:39:45'),
(3, 'Owner', 'owner@ps.com', 'owner123', 'owner', '2025-11-30 19:17:42');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
