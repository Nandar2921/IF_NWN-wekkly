<?php
// ============================================
// FILE: fungsi.php
// FUNGSI: Tempat semua fungsi database & CRUD
// ============================================

// ========== KONEKSI DATABASE ==========
function koneksi() {
    $host = "localhost";
    $user = "root";
    $pass = "root";
    $db = "ifnwn-wekkly";
    
    $conn = mysqli_connect($host, $user, $pass, $db);
    
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    
    return $conn;
}

// ========== TAMPIL DATA (READ) ==========
function tampildata($query) {
    $conn = koneksi();
    $result = mysqli_query($conn, $query);
    $rows = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    
    return $rows;
}

// ========== TAMBAH DATA (CREATE) ==========
function tambahdata($data) {
    $conn = koneksi();
    
    // Ambil data dari form
    $nama = htmlspecialchars($data['nama']);
    $nim = htmlspecialchars($data['nim']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $email = htmlspecialchars($data['email']);
    $no_hp = htmlspecialchars($data['no_hp']);
    
    // Upload foto
    $foto = uploadfoto();
    if (!$foto) {
        return false;
    }
    
    $query = "INSERT INTO mahasiswa (nama, nim, jurusan, email, no_hp, foto) 
              VALUES ('$nama', '$nim', '$jurusan', '$email', '$no_hp', '$foto')";
    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// ========== UPLOAD FOTO ==========
function uploadfoto() {
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];
    
    // Jika tidak upload foto, pakai default
    if ($error === 4) {
        return 'default.png';
    }
    
    // Cek ekstensi file yang diizinkan
    $ekstensiValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensi = explode('.', $namaFile);
    $ekstensi = strtolower(end($ekstensi));
    
    if (!in_array($ekstensi, $ekstensiValid)) {
        echo "<script>alert('Format file tidak valid! Gunakan JPG, JPEG, PNG, atau GIF.');</script>";
        return false;
    }
    
    // Cek ukuran file (max 2MB)
    if ($ukuranFile > 2000000) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.');</script>";
        return false;
    }
    
    // Buat nama file unik
    $namaFileBaru = uniqid() . '.' . $ekstensi;
    $folderTujuan = 'assets/images/';
    
    // Buat folder jika belum ada
    if (!is_dir($folderTujuan)) {
        mkdir($folderTujuan, 0777, true);
    }
    
    // Pindahkan file
    move_uploaded_file($tmpName, $folderTujuan . $namaFileBaru);
    
    return $namaFileBaru;
}

// ========== HAPUS DATA (DELETE) ==========
function hapusdata($id) {
    $conn = koneksi();
    
    // Ambil data foto untuk dihapus dari folder
    $query = "SELECT foto FROM mahasiswa WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $mhs = mysqli_fetch_assoc($result);
    
    // Hapus file foto jika bukan default
    if ($mhs['foto'] != 'default.png') {
        $path = 'assets/images/' . $mhs['foto'];
        if (file_exists($path)) {
            unlink($path);
        }
    }
    
    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// ========== EDIT DATA (UPDATE) ==========
function editdata($data) {
    $conn = koneksi();
    
    $id = $data['id'];
    $nama = htmlspecialchars($data['nama']);
    $nim = htmlspecialchars($data['nim']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $email = htmlspecialchars($data['email']);
    $no_hp = htmlspecialchars($data['no_hp']);
    $fotoLama = htmlspecialchars($data['foto_lama']);
    
    // Cek apakah user upload foto baru
    if ($_FILES['foto']['error'] === 4) {
        // Tidak upload foto baru
        $foto = $fotoLama;
    } else {
        // Upload foto baru
        $foto = uploadfoto();
        if (!$foto) {
            return false;
        }
        
        // Hapus foto lama jika bukan default
        if ($fotoLama != 'default.png') {
            $path = 'assets/images/' . $fotoLama;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
    
    $query = "UPDATE mahasiswa SET 
              nama = '$nama',
              nim = '$nim',
              jurusan = '$jurusan',
              email = '$email',
              no_hp = '$no_hp',
              foto = '$foto'
              WHERE id = $id";
    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// ========== CARI DATA (SEARCH) ==========
function caridata($keyword) {
    $query = "SELECT * FROM mahasiswa 
              WHERE nama LIKE '%$keyword%' 
              OR nim LIKE '%$keyword%' 
              OR jurusan LIKE '%$keyword%'
              OR email LIKE '%$keyword%'";
    
    return tampildata($query);
}

// ========== HITUNG JUMLAH DATA ==========
function hitungdata($table) {
    $conn = koneksi();
    $query = "SELECT COUNT(*) as total FROM $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// ========== HITUNG PER JURUSAN ==========
function hitungperjurusan($jurusan) {
    $conn = koneksi();
    $query = "SELECT COUNT(*) as total FROM mahasiswa WHERE jurusan = '$jurusan'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// ============================================
// FUNGSI UNTUK LOGIN & REGISTER (BARU)
// ============================================

// ========== GET USER BY USERNAME ==========
function getUserByUsername($username) {
    $conn = koneksi();
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// ========== CEK USERNAME ==========
function cekUsername($username) {
    $conn = koneksi();
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// ========== CEK EMAIL ==========
function cekEmail($email) {
    $conn = koneksi();
    $query = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// ========== REGISTER USER ==========
function registerUser($data) {
    $conn = koneksi();
    
    $username = mysqli_real_escape_string($conn, $data['username']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $nama_lengkap = mysqli_real_escape_string($conn, $data['nama_lengkap']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    
    $query = "INSERT INTO users (username, password, nama_lengkap, email, role) 
              VALUES ('$username', '$password', '$nama_lengkap', '$email', 'mahasiswa')";
    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
?>