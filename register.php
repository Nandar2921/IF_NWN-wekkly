<?php
// ============================================
// FILE: register.php
// FUNGSI: Halaman registrasi user baru
// ============================================

session_start();
require 'fungsi.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: dashboard.php");
    exit;
}

// Proses register
if (isset($_POST['register'])) {
    $conn = koneksi(); // Ambil koneksi
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Validasi
    $errors = [];
    
    // Cek username sudah digunakan
    if (cekUsername($username)) {
        $errors[] = "Username sudah digunakan!";
    }
    
    // Cek email sudah digunakan
    if (cekEmail($email)) {
        $errors[] = "Email sudah terdaftar!";
    }
    
    // Cek password match
    if ($password !== $confirm_password) {
        $errors[] = "Password dan konfirmasi password tidak cocok!";
    }
    
    // Cek panjang password (minimal 6 karakter)
    if (strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter!";
    }
    
    // Jika tidak ada error, simpan data
    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert ke database
        $query = "INSERT INTO users (username, password, nama_lengkap, email, role) 
                  VALUES ('$username', '$hashed_password', '$nama_lengkap', '$email', 'mahasiswa')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: login.php?register_success=1");
            exit;
        } else {
            $errors[] = "Gagal mendaftar: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Informatika</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .register-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 40px 30px;
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2d3748;
        }
        .register-container .form-group {
            margin-bottom: 18px;
        }
        .register-container .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #4a5568;
            font-size: 14px;
        }
        .register-container .form-group input {
            width: 100%;
            padding: 11px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .register-container .form-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
            outline: none;
        }
        .register-container .form-actions {
            margin-top: 25px;
        }
        .register-container .form-actions button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
        }
        .register-container .login-link {
            text-align: center;
            margin-top: 20px;
            color: #4a5568;
        }
        .register-container .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .register-container .login-link a:hover {
            text-decoration: underline;
        }
        .register-logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .register-logo i {
            font-size: 50px;
            color: #667eea;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .register-logo h1 {
            font-size: 22px;
            color: #2d3748;
            margin-top: 8px;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #ef4444;
        }
        .alert-error ul {
            margin: 5px 0 0 20px;
            padding: 0;
        }
        .alert-error li {
            margin: 3px 0;
        }
        .password-hint {
            font-size: 12px;
            color: #718096;
            margin-top: 4px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        @media (max-width: 500px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 650px; margin: 30px auto;">
        <div class="register-container">
            <div class="register-logo">
                <i class="fas fa-user-plus"></i>
                <h1>Daftar Akun</h1>
                <p style="color: #718096; -webkit-text-fill-color: #718096; font-size: 14px;">Bergabunglah sebagai mahasiswa</p>
            </div>
            
            <?php if (!empty($errors)): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan:
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form action="" method="post">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama_lengkap" required placeholder="Masukkan nama lengkap" 
                           value="<?= isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : '' ?>">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-user-circle"></i> Username <span class="required">*</span></label>
                    <input type="text" name="username" required placeholder="Masukkan username" 
                           value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                    <small style="color: #718096; font-size: 12px;">Username akan digunakan untuk login</small>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email <span class="required">*</span></label>
                    <input type="email" name="email" required placeholder="contoh@email.com" 
                           value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Password <span class="required">*</span></label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter">
                        <div class="password-hint">
                            <i class="fas fa-info-circle"></i> Gunakan kombinasi huruf dan angka
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Konfirmasi Password <span class="required">*</span></label>
                        <input type="password" name="confirm_password" required placeholder="Ulangi password">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" name="register" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </button>
                </div>
            </form>
            
            <div class="login-link">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </div>
            
            <div style="text-align: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                <a href="index.php" style="color: #718096; text-decoration: none; font-size: 13px;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>