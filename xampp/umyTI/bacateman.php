<?php
/**
 * bacateman.php
 * GET /umyTI/bacateman.php
 * Mengembalikan seluruh isi tabel `teman` sebagai JSON array:
 * [{"id":1,"nama":"...","alamat":"...","telpon":"..."}, ...]
 *
 * Nama kolom telepon disesuaikan otomatis lewat kolomTelpon(),
 * tetapi kunci JSON-nya selalu `telpon` supaya cocok dengan model Android.
 */

require __DIR__ . '/koneksi.php';

$koneksi = koneksiTiumy();
$kolomTelpon = kolomTelpon($koneksi);

$sql = "SELECT id, nama, alamat, `$kolomTelpon` AS telpon FROM teman ORDER BY id ASC";
$hasil = $koneksi->query($sql);

if ($hasil === false) {
    http_response_code(500);
    echo json_encode([
        'status' => 'gagal',
        'pesan'  => 'Query gagal: ' . $koneksi->error,
    ]);
    $koneksi->close();
    exit;
}

$data = [];
while ($baris = $hasil->fetch_assoc()) {
    $data[] = [
        'id'     => (int) $baris['id'],
        'nama'   => $baris['nama'],
        'alamat' => $baris['alamat'],
        'telpon' => $baris['telpon'],
    ];
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$koneksi->close();
