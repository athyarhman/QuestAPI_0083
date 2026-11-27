-- tiumy.sql
-- Skema database untuk aplikasi QuestApi_0083.
-- Jalankan lewat phpMyAdmin kalau database `tiumy` belum ada.
-- Kalau database + tabel `teman` sudah ada, file ini boleh dilewati.
--
-- Catatan: kolom nomor telepon di sini bernama `telepon` (mengikuti database
-- yang sudah ada). Kalau database barumu memakai nama `telpon`, tidak masalah:
-- koneksi.php mendeteksi keduanya otomatis.

CREATE DATABASE IF NOT EXISTS `tiumy`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE `tiumy`;

CREATE TABLE IF NOT EXISTS `teman` (
    `id`      INT(11)      NOT NULL AUTO_INCREMENT,
    `nama`    VARCHAR(100) NOT NULL,
    `alamat`  VARCHAR(255) NOT NULL,
    `telepon` VARCHAR(30)  NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;
