<?php
// ============================================
// FILE: login.php
// FUNGSI: Halaman login untuk user
// ============================================

session_start();
require 'fungsi.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: dashboard.php");
    exit;
}

// Proses login
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string(koneksi(), $_POST['username']);
    $password = $_POST['password'];
    
    // Cek username di database menggunakan fungsi
    $user = getUserByUsername($username);
    
    if ($user) {
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: mahasiswa.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Informatika</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .login-container {
            max-width: 450px;
            margin: 0 auto;
            padding: 40px 30px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2d3748;
        }
        .login-container .form-group {
            margin-bottom: 20px;
        }
        .login-container .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #4a5568;
        }
        .login-container .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .login-container .form-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
            outline: none;
        }
        .login-container .form-actions {
            margin-top: 25px;
        }
        .login-container .form-actions button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
        }
        .login-container .register-link {
            text-align: center;
            margin-top: 20px;
            color: #4a5568;
        }
        .login-container .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .login-container .register-link a:hover {
            text-decoration: underline;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-logo i {
            font-size: 60px;
            color: #667eea;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .login-logo h1 {
            font-size: 24px;
            color: #2d3748;
            margin-top: 10px;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #ef4444;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #10b981;
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 600px; margin: 40px auto;">
        <div class="login-container">
            <div class="login-logo">
                <i class="fas fa-graduation-cap"></i>
                <h1>Informatika</h1>
                <p style="color: #718096; -webkit-text-fill-color: #718096;">Silakan login untuk melanjutkan</p>
            </div>
            
            <?php if (isset($_GET['register_success'])): ?>
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> Registrasi berhasil! Silakan login.
                </div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>
            
            <form action="" method="post">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" required placeholder="Masukkan username" autofocus>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password">
                </div>
                
                <div class="form-actions">
                    <button type="submit" name="login" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </div>
            </form>
            
            <div class="register-link">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
            </div>
            
            <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <a href="index.php" style="color: #718096; text-decoration: none; font-size: 14px;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>