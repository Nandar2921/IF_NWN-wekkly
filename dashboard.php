<?php
// ============================================
// FILE: dashboard.php
// FUNGSI: Dashboard user setelah login
// ============================================

session_start();
require 'fungsi.php';

// Cek session login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$nama_lengkap = $_SESSION['nama_lengkap'];
$role = $_SESSION['role'];

// Ambil data mahasiswa (jika ada relasi)
$query = "SELECT * FROM mahasiswa WHERE user_id = '$user_id'";
$mahasiswa = tampildata($query);
$data_mhs = !empty($mahasiswa) ? $mahasiswa[0] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Informatika</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 24px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .dashboard-header .user-info h2 {
            font-size: 28px;
            margin-bottom: 5px;
        }
        .dashboard-header .user-info p {
            opacity: 0.9;
        }
        .dashboard-header .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .dashboard-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            text-align: center;
            border: 1px solid rgba(102,126,234,0.1);
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }
        .dashboard-card i {
            font-size: 40px;
            color: #667eea;
            margin-bottom: 15px;
        }
        .dashboard-card h3 {
            color: #2d3748;
            margin-bottom: 5px;
        }
        .dashboard-card p {
            color: #718096;
            font-size: 14px;
        }
        .logout-btn {
            background: #ef4444;
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239,68,68,0.3);
        }
        .btn-profile {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.3);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-profile:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        .welcome-text {
            font-size: 16px;
            color: #4a5568;
            line-height: 1.8;
        }
        .badge-role {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: rgba(255,255,255,0.25);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-tachometer-alt"></i> DASHBOARD</h1>
            <p>Selamat datang, <?= htmlspecialchars($nama_lengkap) ?></p>
        </div>
        
        <!-- NAVIGASI -->
        <div class="navbar">
            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="profile.php"><i class="fas fa-user-graduate"></i> Profile</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
            <a href="logout.php" style="background: rgba(239,68,68,0.3);"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        
        <div class="content">
            <!-- DASHBOARD HEADER -->
            <div class="dashboard-header">
                <div class="user-info">
                    <h2><i class="fas fa-hand-wave"></i> Halo, <?= htmlspecialchars($nama_lengkap) ?>!</h2>
                    <p>
                        <i class="fas fa-user"></i> @<?= htmlspecialchars($username) ?> 
                        <span class="badge-role"><?= ucfirst($role) ?></span>
                    </p>
                    <p style="margin-top: 10px;">
                        <i class="fas fa-calendar-alt"></i> Terakhir login: <?= date('d F Y H:i') ?>
                    </p>
                </div>
                <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                    <a href="edit_profile.php" class="btn-profile">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </a>
                    <a href="logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
            
            <!-- STATISTIK CARD -->
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <i class="fas fa-user-graduate"></i>
                    <h3>Mahasiswa</h3>
                    <p>Status: <?= $data_mhs ? 'Terdaftar' : 'Belum Terdaftar' ?></p>
                </div>
                <div class="dashboard-card">
                    <i class="fas fa-calendar-check"></i>
                    <h3>Semester Aktif</h3>
                    <p>Semester <?= date('Y') % 2 == 0 ? 'Genap' : 'Ganjil' ?></p>
                </div>
                <div class="dashboard-card">
                    <i class="fas fa-book"></i>
                    <h3>Mata Kuliah</h3>
                    <p>6 Mata Kuliah</p>
                </div>
                <div class="dashboard-card">
                    <i class="fas fa-tasks"></i>
                    <h3>Progress</h3>
                    <p>75% Selesai</p>
                </div>
            </div>
            
            <!-- INFO AKUN -->
            <div class="card">
                <h2><i class="fas fa-info-circle"></i> Informasi Akun</h2>
                <div class="welcome-text">
                    <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($nama_lengkap) ?></p>
                    <p><strong>Username:</strong> @<?= htmlspecialchars($username) ?></p>
                    <p><strong>Role:</strong> <?= ucfirst($role) ?></p>
                    <?php if ($data_mhs): ?>
                        <p><strong>Data Mahasiswa:</strong> <?= htmlspecialchars($data_mhs['nama']) ?> (<?= htmlspecialchars($data_mhs['nim']) ?>)</p>
                        <p><strong>Jurusan:</strong> <?= htmlspecialchars($data_mhs['jurusan']) ?></p>
                    <?php else: ?>
                        <p style="color: #f59e0b;">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Anda belum terdaftar sebagai mahasiswa. <a href="inputdata.php">Daftar sekarang</a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- QUICK LINKS -->
            <div class="card">
                <h2><i class="fas fa-link"></i> Quick Links</h2>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="profile.php" class="btn btn-primary">
                        <i class="fas fa-user-graduate"></i> Lihat Profile
                    </a>
                    <a href="contact.php" class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Hubungi Kami
                    </a>
                    <?php if ($role === 'admin'): ?>
                        <a href="mahasiswa.php" class="btn btn-primary">
                            <i class="fas fa-users"></i> Kelola Mahasiswa
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>