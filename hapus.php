<?php
include 'koneksi.php';

$id = $_GET['id'];

// Ambil nama file foto sebelum hapus (cek dulu kolom foto ada)
$query = mysqli_query($conn, "SELECT foto FROM mahasiswa WHERE id = $id");
$row = mysqli_fetch_assoc($query);

// Hapus file foto dari folder (cek apakah foto tidak kosong dan bukan default)
if ($row && isset($row['foto']) && $row['foto'] && $row['foto'] != 'default.png') {
    $path = "assets/images/" . $row['foto'];
    if (file_exists($path)) {
        unlink($path);
    }
}

// Hapus data dari database
mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

header("Location: data-mahasiswa.php?success=Data berhasil dihapus!");
?>