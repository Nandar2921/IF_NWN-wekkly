<?php
include 'koneksi.php';

// Ambil data dari form
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$jurusan = $_POST['jurusan'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];

// Upload foto
$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];
$error = $_FILES['foto']['error'];

// Tentukan folder penyimpanan
$folder = "assets/images/";

// Buat folder jika belum ada
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

if ($error === 0) {
    // Generate nama file unik
    $ext = pathinfo($foto, PATHINFO_EXTENSION);
    $foto_baru = time() . "_" . uniqid() . "." . $ext;
    
    // Upload file
    if (move_uploaded_file($tmp, $folder . $foto_baru)) {
        $foto_simpan = $foto_baru;
    } else {
        $foto_simpan = 'default.png';
    }
} else {
    $foto_simpan = 'default.png';
}

// Query insert
$query = "INSERT INTO mahasiswa (nama, nim, jurusan, email, no_hp, foto) 
          VALUES ('$nama', '$nim', '$jurusan', '$email', '$no_hp', '$foto_simpan')";

if (mysqli_query($conn, $query)) {
    header("Location: data-mahasiswa.php?success=Data berhasil ditambahkan!");
} else {
    header("Location: inputdata.php?error=Gagal menambahkan data: " . mysqli_error($conn));
}
?>