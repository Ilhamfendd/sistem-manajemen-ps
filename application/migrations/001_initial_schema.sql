-- GO-KOPI Rental PS Manager - Initial Database Schema
-- Created: 2025-11-30

-- ============================================================
-- 1. ALTER EXISTING TABLES
-- ============================================================

-- Alter users table: update role enum to add kasir and owner
ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin','kasir','owner','staff') DEFAULT 'kasir';

-- Alter consoles table: add price_per_hour (if not exists)
ALTER TABLE `consoles` ADD COLUMN `price_per_hour` INT DEFAULT 5000 AFTER `status`;

-- Alter rentals table: add payment fields (if not exists)
ALTER TABLE `rentals` ADD COLUMN `payment_status` ENUM('pending','paid','partial') DEFAULT 'pending' AFTER `status`;
ALTER TABLE `rentals` ADD COLUMN `total_amount` INT DEFAULT 0 AFTER `payment_status`;

-- ============================================================
-- 2. CREATE NEW TABLES
-- ============================================================

-- Console Types/Categories
CREATE TABLE IF NOT EXISTS `console_types` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payment Methods
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT,
  `is_active` BOOLEAN DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Transactions
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
  FOREIGN KEY (`rental_id`) REFERENCES `rentals`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods`(`id`),
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`),
  KEY `rental_id` (`rental_id`),
  KEY `paid_at` (`paid_at`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Console Price History (Audit Trail)
CREATE TABLE IF NOT EXISTS `console_price_history` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `console_id` INT NOT NULL,
  `old_price` INT,
  `new_price` INT NOT NULL,
  `changed_by` INT NOT NULL,
  `changed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`console_id`) REFERENCES `consoles`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`changed_by`) REFERENCES `users`(`id`),
  KEY `console_id` (`console_id`),
  KEY `changed_at` (`changed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. INSERT DEFAULT DATA
-- ============================================================

-- Insert Default Payment Methods
INSERT IGNORE INTO `payment_methods` (`name`, `description`, `is_active`) VALUES
('Tunai', 'Pembayaran tunai langsung', 1),
('Transfer Bank', 'Transfer ke rekening GO-KOPI', 1),
('E-Wallet', 'Pembayaran via e-wallet (GCash, Dana, dll)', 1);

-- Insert Console Types
INSERT IGNORE INTO `console_types` (`name`, `description`) VALUES
('PlayStation 4', 'PS4 Standard + Game Populer'),
('PlayStation 5', 'PS5 Console Gen Terbaru'),
('Xbox One', 'Xbox One S + Game Collection');

-- ============================================================
-- END OF MIGRATION
-- ============================================================
