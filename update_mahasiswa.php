<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Buat instansi dari kelas Koneksi
$koneksiObj = new Koneksi();
$koneksi = $koneksiObj->getKoneksi(); // Mendapatkan koneksi

$id = $_POST['id'];
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$jurusan = $_POST['jurusan'];

// Validasi input
if (empty($nama) || empty($nim) || empty($jurusan)) {
    http_response_code(400);
    echo json_encode(['error' => 'Data tidak lengkap']);
    exit();
}

// Cek NIM unique (kecuali data saat ini)
$cek_nim = $koneksi->prepare("SELECT * FROM mahasiswa WHERE nim = ? AND id != ?");
$cek_nim->bind_param("si", $nim, $id);
$cek_nim->execute();
$result = $cek_nim->get_result();

if ($result->num_rows > 0) {
    http_response_code(400);
    echo json_encode(['error' => 'NIM sudah terdaftar']);
    exit();
}

// Update data
$query = $koneksi->prepare("UPDATE mahasiswa SET nama = ?, nim = ?, jurusan = ? WHERE id = ?");
$query->bind_param("sssi", $nama, $nim, $jurusan, $id);

if ($query->execute()) {
    echo json_encode(['message' => 'Berhasil update mahasiswa']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal update mahasiswa']);
}

// Tutup koneksi
$koneksiObj->tutupKoneksi();
exit();
?>