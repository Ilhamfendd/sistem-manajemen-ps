-- GO-KOPI Rental PS Manager - Database Schema Migration
-- Phase 1: New Tables

-- Create Console Types
CREATE TABLE IF NOT EXISTS `console_types` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Payment Methods
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT,
  `is_active` BOOLEAN DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `rental_id` INT NOT NULL,
  `amount` INT NOT NULL,
  `payment_method_id` INT NOT NULL,
  `paid_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `change_amount` INT DEFAULT 0,
  `notes` TEXT,
  `created_by` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `rental_id` (`rental_id`),
  KEY `payment_method_id` (`payment_method_id`),
  KEY `created_by` (`created_by`),
  KEY `paid_at` (`paid_at`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Console Price History
CREATE TABLE IF NOT EXISTS `console_price_history` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `console_id` INT NOT NULL,
  `old_price` INT,
  `new_price` INT NOT NULL,
  `changed_by` INT NOT NULL,
  `changed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `console_id` (`console_id`),
  KEY `changed_by` (`changed_by`),
  KEY `changed_at` (`changed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Data
INSERT IGNORE INTO `payment_methods` (`name`, `description`, `is_active`) VALUES
('Tunai', 'Pembayaran tunai langsung', 1),
('Transfer Bank', 'Transfer ke rekening GO-KOPI', 1),
('E-Wallet', 'Pembayaran via e-wallet', 1);

INSERT IGNORE INTO `console_types` (`name`, `description`) VALUES
('PlayStation 4', 'PS4 Standard + Game Populer'),
('PlayStation 5', 'PS5 Console Gen Terbaru'),
('Xbox One', 'Xbox One S + Game Collection');
