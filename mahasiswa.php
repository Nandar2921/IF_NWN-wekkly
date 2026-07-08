<?php
// ============================================
// FILE: mahasiswa.php
// FUNGSI: Menampilkan data mahasiswa (Admin Only)
// ============================================

session_start();
require 'fungsi.php';

// Cek login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

// Hanya admin yang bisa akses
if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

// Ambil semua data mahasiswa
$mahasiswas = tampildata("SELECT * FROM mahasiswa");

// Hitung statistik
$total_mahasiswa = hitungdata('mahasiswa');
$total_informatika = hitungperjurusan('Informatika');
$total_si = hitungperjurusan('Sistem Informasi');
$total_tk = hitungperjurusan('Teknik Komputer');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - Informatika</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-users"></i> DATA MAHASISWA</h1>
            <p>Manajemen Data Mahasiswa Informatika</p>
        </div>
        
        <!-- NAVIGASI -->
        <div class="navbar">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="profile.php"><i class="fas fa-user-graduate"></i> Profile</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
            <a href="mahasiswa.php"><i class="fas fa-table"></i> Data Mahasiswa</a>
            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="logout.php" style="background: rgba(239,68,68,0.3);"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        
        <div class="content">
            <!-- STATISTIK CARD -->
            <div class="stats-container">
                <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-users" style="font-size: 2.5em; margin-bottom: 10px;"></i>
                    <h3><?= $total_mahasiswa; ?></h3>
                    <p>Total Mahasiswa</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="fas fa-laptop-code" style="font-size: 2.5em; margin-bottom: 10px;"></i>
                    <h3><?= $total_informatika; ?></h3>
                    <p>Teknik Informatika</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-database" style="font-size: 2.5em; margin-bottom: 10px;"></i>
                    <h3><?= $total_si; ?></h3>
                    <p>Sistem Informasi</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="fas fa-microchip" style="font-size: 2.5em; margin-bottom: 10px;"></i>
                    <h3><?= $total_tk; ?></h3>
                    <p>Teknik Komputer</p>
                </div>
            </div>
            
            <!-- TOOLBAR -->
            <div class="toolbar">
                <a href="inputdata.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
                <div style="display: flex; gap: 10px;">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-box" placeholder="Cari data..." onkeyup="searchData()">
                    </div>
                    <button onclick="exportToCSV()" class="btn btn-primary">
                        <i class="fas fa-download"></i> Export CSV
                    </button>
                </div>
            </div>
            
            <!-- ALERT SUKSES -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>
            
            <!-- TABEL DATA -->
            <div class="table-wrapper">
                <table class="data-table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Jurusan</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($mahasiswas as $mhs) : ?>
                        <tr>
                            <td data-label="No"><?= $no++; ?></td>
                            <td data-label="Foto">
                                <?php if ($mhs['foto'] && file_exists("assets/images/" . $mhs['foto'])): ?>
                                    <img src="assets/images/<?= $mhs['foto']; ?>" class="foto-mahasiswa" alt="Foto">
                                <?php else: ?>
                                    <img src="assets/images/default.png" class="foto-mahasiswa" alt="No Image">
                                <?php endif; ?>
                            </td>
                            <td data-label="Nama"><strong><?= htmlspecialchars($mhs['nama']); ?></strong></td>
                            <td data-label="NIM"><code><?= htmlspecialchars($mhs['nim']); ?></code></td>
                            <td data-label="Jurusan">
                                <span class="badge jurusan-<?= strtolower(str_replace(' ', '', $mhs['jurusan'])); ?>">
                                    <?= htmlspecialchars($mhs['jurusan']); ?>
                                </span>
                            </td>
                            <td data-label="Email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($mhs['email']); ?></td>
                            <td data-label="No. HP"><i class="fas fa-phone"></i> <?= htmlspecialchars($mhs['no_hp']); ?></td>
                            <td data-label="Aksi" class="action-buttons">
                                <a href="editdata.php?id=<?= $mhs['id']; ?>" class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="hapusdata.php?id=<?= $mhs['id']; ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (count($mahasiswas) == 0): ?>
                <div class="alert alert-error" style="text-align: center;">
                    <i class="fas fa-exclamation-triangle"></i> Tidak ada data mahasiswa. Silakan tambah data!
                </div>
            <?php endif; ?>
        </div