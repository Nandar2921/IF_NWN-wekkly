<?php
// ============================================
// FILE: editdata.php
// FUNGSI: Form edit data mahasiswa
// ============================================

require 'fungsi.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data mahasiswa berdasarkan ID
$mhs = tampildata("SELECT * FROM mahasiswa WHERE id = $id")[0];

// Proses edit data jika form disubmit
if (isset($_POST['submit'])) {
    if (editdata($_POST) > 0) {
        echo "<script>
                alert('✅ Data berhasil diupdate!');
                document.location.href = 'mahasiswa.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Data gagal diupdate!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa - Informatika</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-edit"></i> EDIT DATA MAHASISWA</h1>
            <p>Silakan ubah data di bawah ini</p>
        </div>
        
        <!-- NAVIGASI -->
        <div class="navbar">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="profile.php"><i class="fas fa-user-graduate"></i> Profile</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
            <a href="mahasiswa.php"><i class="fas fa-table"></i> Data Mahasiswa</a>
        </div>
        
        <div class="content">
            <!-- FORM EDIT DATA -->
            <div class="form-card">
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- Hidden fields -->
                    <input type="hidden" name="id" value="<?= $mhs['id']; ?>">
                    <input type="hidden" name="foto_lama" value="<?= $mhs['foto']; ?>">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="nama" id="nama" required value="<?= htmlspecialchars($mhs['nama']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-id-card"></i> NIM <span class="required">*</span></label>
                            <input type="number" name="nim" id="nim" required value="<?= $mhs['nim']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-graduation-cap"></i> Jurusan <span class="required">*</span></label>
                            <select name="jurusan" id="jurusan" required>
                                <option value="Informatika" <?= $mhs['jurusan'] == 'Informatika' ? 'selected' : '' ?>>Informatika</option>
                                <option value="Sistem Informasi" <?= $mhs['jurusan'] == 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                                <option value="Teknik Komputer" <?= $mhs['jurusan'] == 'Teknik Komputer' ? 'selected' : '' ?>>Teknik Komputer</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email <span class="required">*</span></label>
                            <input type="email" name="email" id="email" required value="<?= htmlspecialchars($mhs['email']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> No. HP <span class="required">*</span></label>
                            <input type="text" name="no_hp" id="no_hp" required value="<?= htmlspecialchars($mhs['no_hp']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-image"></i> Ganti Foto</label>
                            <input type="file" name="foto" id="foto" accept="image/*">
                            <small><i class="fas fa-info-circle"></i> Kosongkan jika tidak ingin mengganti foto</small>
                            <div style="margin-top: 10px;">
                                <p>Foto saat ini:</p>
                                <?php if ($mhs['foto'] && file_exists("assets/images/" . $mhs['foto'])): ?>
                                    <img src="assets/images/<?= $mhs['foto']; ?>" style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="assets/images/default.png" style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;">
                                <?php endif; ?>
                                <img id="preview-foto" style="display: none; width: 100px; height: 100px; border-radius: 10px; object-fit: cover; margin-top: 10px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Data
                        </button>
                        <a href="mahasiswa.php" class="btn btn-cancel">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Preview foto sebelum upload
        const fotoInput = document.getElementById('foto');
        const previewFoto = document.getElementById('preview-foto');
        
        fotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewFoto.src = e.target.result;
                    previewFoto.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewFoto.style.display = 'none';
            }
        });
    </script>
</body>
</html>