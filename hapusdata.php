<?php
// ============================================
// FILE: hapusdata.php
// FUNGSI: Proses hapus data mahasiswa
// ============================================

require 'fungsi.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Panggil fungsi hapus
if (hapusdata($id) > 0) {
    header("Location: mahasiswa.php?success=Data berhasil dihapus!");
} else {
    header("Location: mahasiswa.php?error=Data gagal dihapus!");
}
?>