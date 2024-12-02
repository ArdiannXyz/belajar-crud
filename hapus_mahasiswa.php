<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Buat instansi dari kelas Koneksi
$koneksiObj = new Koneksi();
$koneksi = $koneksiObj->getKoneksi(); // Mendapatkan koneksi

$id = $_POST['id'];

// Validasi input
if (empty($id)) {
    http_response_code(400);
    echo json_encode(['error' => 'ID tidak valid']);
    exit();
}

// Hapus data
$query = $koneksi->prepare("DELETE FROM mahasiswa WHERE id = ?");
$query->bind_param("i", $id);

if ($query->execute()) {
    echo json_encode(['message' => 'Berhasil hapus mahasiswa']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal hapus mahasiswa']);
}

// Tutup koneksi
$koneksiObj->tutupKoneksi();
exit();
?>