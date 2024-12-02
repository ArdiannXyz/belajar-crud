<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Buat instansi dari kelas Koneksi
$koneksiObj = new Koneksi();
$koneksi = $koneksiObj->getKoneksi(); // Mendapatkan koneksi

$query = "SELECT * FROM mahasiswa ORDER BY created_at DESC";
$result = $koneksi->query($query);

$mahasiswa = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mahasiswa[] = $row;
    }
}

// Mengembalikan data mahasiswa dalam format JSON
echo json_encode($mahasiswa);

// Tutup koneksi
$koneksiObj->tutupKoneksi();
exit();
?>