-- Hapus semua data konsol yang ada
DELETE FROM consoles;

-- Masukkan 8 unit PS3
INSERT INTO consoles (console_name, console_type, price_per_hour, status, note) VALUES
('Unit PS3 - 1', 'PS3', 10000, 'available', 'PlayStation 3 Unit 1'),
('Unit PS3 - 2', 'PS3', 10000, 'available', 'PlayStation 3 Unit 2'),
('Unit PS3 - 3', 'PS3', 10000, 'available', 'PlayStation 3 Unit 3'),
('Unit PS3 - 4', 'PS3', 10000, 'available', 'PlayStation 3 Unit 4'),
('Unit PS3 - 5', 'PS3', 10000, 'available', 'PlayStation 3 Unit 5'),
('Unit PS3 - 6', 'PS3', 10000, 'available', 'PlayStation 3 Unit 6'),
('Unit PS3 - 7', 'PS3', 10000, 'available', 'PlayStation 3 Unit 7'),
('Unit PS3 - 8', 'PS3', 10000, 'available', 'PlayStation 3 Unit 8');

-- Update console_type ke PS3 untuk semua
UPDATE consoles SET console_type = 'PS3';
