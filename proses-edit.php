<?php
include 'koneksi.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$jurusan = $_POST['jurusan'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];

// Cek apakah upload foto baru
if ($_FILES['foto']['error'] === 0) {
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $folder = "assets/images/";
    
    // Hapus foto lama
    $query_old = mysqli_query($conn, "SELECT foto FROM mahasiswa WHERE id = $id");
    $old = mysqli_fetch_assoc($query_old);
    if ($old['foto'] != 'default.png' && file_exists($folder . $old['foto'])) {
        unlink($folder . $old['foto']);
    }
    
    // Upload foto baru
    $ext = pathinfo($foto, PATHINFO_EXTENSION);
    $foto_baru = time() . "_" . uniqid() . "." . $ext;
    move_uploaded_file($tmp, $folder . $foto_baru);
    
    $query = "UPDATE mahasiswa SET 
              nama='$nama', nim='$nim', jurusan='$jurusan', 
              email='$email', no_hp='$no_hp', foto='$foto_baru' 
              WHERE id=$id";
} else {
    // Update tanpa ganti foto
    $query = "UPDATE mahasiswa SET 
              nama='$nama', nim='$nim', jurusan='$jurusan', 
              email='$email', no_hp='$no_hp' 
              WHERE id=$id";
}

if (mysqli_query($conn, $query)) {
    header("Location: data-mahasiswa.php?success=Data berhasil diupdate!");
} else {
    header("Location: edit.php?id=$id&error=Gagal update: " . mysqli_error($conn));
}
?>