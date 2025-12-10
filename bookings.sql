-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 10 Des 2025 pada 10.50
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
