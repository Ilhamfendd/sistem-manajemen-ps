-- ALTER EXISTING TABLES
ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin','kasir','owner','staff') DEFAULT 'kasir';

-- Add price_per_hour to consoles
ALTER TABLE `consoles` ADD COLUMN `price_per_hour` INT DEFAULT 5000 AFTER `status`;

-- Add payment fields to rentals
ALTER TABLE `rentals` ADD COLUMN `payment_status` ENUM('pending','paid','partial') DEFAULT 'pending' AFTER `status`;
ALTER TABLE `rentals` ADD COLUMN `total_amount` INT DEFAULT 0 AFTER `payment_status`;
