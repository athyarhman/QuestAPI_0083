-- data_teman.sql
-- Data contoh supaya layar Home tidak kosong saat pertama kali dibuka.
-- Opsional: hapus saja kalau tidak ingin data dummy.

USE `tiumy`;

INSERT INTO `teman` (`nama`, `alamat`, `telepon`) VALUES
('Budi Santoso', 'Jl. Malioboro No. 12, Yogyakarta', '081234567890'),
('Siti Aminah', 'Jl. Kaliurang KM 5, Sleman', '085712345678'),
('Rizky Pratama', 'Jl. Gejayan No. 88, Yogyakarta', '089912345678');
