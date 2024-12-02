<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Buat instansi dari kelas Koneksi
$koneksiObj = new Koneksi();
$koneksi = $koneksiObj->getKoneksi(); // Mendapatkan koneksi

$nama = $_POST['nama'];
$nim = $_POST['nim'];
$jurusan = $_POST['jurusan'];

// Validasi input
if (empty($nama) || empty($nim) || empty($jurusan)) {
    http_response_code(400);
    echo json_encode(['error' => 'Data tidak lengkap']);
    exit();
}

// Cek NIM unique
$cek_nim = $koneksi->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
$cek_nim->bind_param("s", $nim);
$cek_nim->execute();
$result = $cek_nim->get_result();

if ($result->num_rows > 0) {
    http_response_code(400);
    echo json_encode(['error' => 'NIM sudah terdaftar']);
    exit();
}

// Insert data
$query = $koneksi->prepare("INSERT INTO mahasiswa (nama, nim, jurusan) VALUES (?, ?, ?)");
$query->bind_param("sss", $nama, $nim, $jurusan);

if ($query->execute()) {
    echo json_encode(['message' => 'Berhasil tambah mahasiswa']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal tambah mahasiswa']);
}

// Tutup koneksi
$koneksiObj->tutupKoneksi();
exit();
?>