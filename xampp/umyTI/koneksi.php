<?php
/**
 * koneksi.php
 * Koneksi database MySQL XAMPP untuk aplikasi QuestApi_0083.
 * Dipakai bersama oleh bacateman.php dan insertTM.php.
 */

header('Content-Type: application/json; charset=utf-8');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tiumy');

function koneksiTiumy(): mysqli
{
    mysqli_report(MYSQLI_REPORT_OFF);

    $koneksi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($koneksi->connect_error) {
        http_response_code(500);
        echo json_encode([
            'status' => 'gagal',
            'pesan'  => 'Koneksi database gagal: ' . $koneksi->connect_error,
        ]);
        exit;
    }

    $koneksi->set_charset('utf8mb4');
    return $koneksi;
}

/**
 * Nama kolom nomor telepon bisa beda antar database latihan:
 * ada yang menamainya `telpon`, ada yang `telepon`.
 * Fungsi ini mendeteksi sekali saja, lalu hasilnya dipakai ulang.
 *
 * Aplikasi Android tetap memakai field `telpon` sesuai kontrak JSON,
 * jadi perbedaan nama kolom tidak perlu mengubah kode Kotlin.
 */
function kolomTelpon(mysqli $koneksi): string
{
    static $kolom = null;

    if ($kolom !== null) {
        return $kolom;
    }

    $hasil = $koneksi->query("SHOW COLUMNS FROM teman LIKE 'telpon'");
    $kolom = ($hasil !== false && $hasil->num_rows > 0) ? 'telpon' : 'telepon';

    return $kolom;
}
