<?php
/**
 * insertTM.php
 * POST /umyTI/insertTM.php
 * Body JSON: {"id":0,"nama":"...","alamat":"...","telpon":"..."}
 * Kolom id diabaikan karena auto increment.
 * Nama kolom telepon menyesuaikan database lewat kolomTelpon().
 */

require __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'gagal', 'pesan' => 'Gunakan method POST']);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true);

if (!is_array($body)) {
    http_response_code(400);
    echo json_encode(['status' => 'gagal', 'pesan' => 'Body bukan JSON yang valid']);
    exit;
}

$nama   = trim((string) ($body['nama'] ?? ''));
$alamat = trim((string) ($body['alamat'] ?? ''));
$telpon = trim((string) ($body['telpon'] ?? ''));

if ($nama === '' || $alamat === '' || $telpon === '') {
    http_response_code(400);
    echo json_encode(['status' => 'gagal', 'pesan' => 'nama, alamat, dan telpon wajib diisi']);
    exit;
}

$koneksi = koneksiTiumy();
$kolomTelpon = kolomTelpon($koneksi);

$stmt = $koneksi->prepare("INSERT INTO teman (nama, alamat, `$kolomTelpon`) VALUES (?, ?, ?)");
if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['status' => 'gagal', 'pesan' => 'Prepare gagal: ' . $koneksi->error]);
    $koneksi->close();
    exit;
}

$stmt->bind_param('sss', $nama, $alamat, $telpon);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'sukses',
        'id'     => $stmt->insert_id,
        'pesan'  => 'Data siswa berhasil disimpan',
    ]);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'gagal', 'pesan' => 'Insert gagal: ' . $stmt->error]);
}

$stmt->close();
$koneksi->close();
