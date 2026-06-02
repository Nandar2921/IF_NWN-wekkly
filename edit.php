<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id = $id");
$row = mysqli_fetch_assoc($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✏️ EDIT DATA MAHASISWA</h1>
            <p>Silakan ubah data di bawah ini</p>
        </div>
        
        <div class="navbar">
            <a href="index.php">🏠 Home</a>
            <a href="profile.php">👤 Profile</a>
            <a href="contact.php">📞 Contact</a>
            <a href="data-mahasiswa.php">📊 Data Mahasiswa</a>
        </div>
        
        <div class="content">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">❌ <?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>
            
            <div class="card">
                <form action="proses-edit.php" method="post" enctype="multipart/form-data" id="formEdit">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    
                    <div class="form-group">
                        <label for="nama">📝 Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nim">🆔 NIM</label>
                        <input type="number" name="nim" id="nim" value="<?= $row['nim']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="jurusan">🎓 Jurusan</label>
                        <select name="jurusan" id="jurusan" required>
                            <option value="Informatika" <?= $row['jurusan'] == 'Informatika' ? 'selected' : '' ?>>Informatika</option>
                            <option value="Sistem Informasi" <?= $row['jurusan'] == 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                            <option value="Teknik Komputer" <?= $row['jurusan'] == 'Teknik Komputer' ? 'selected' : '' ?>>Teknik Komputer</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">📧 Email</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($row['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="no_hp">📱 No. HP</label>
                        <input type="text" name="no_hp" id="no_hp" value="<?= htmlspecialchars($row['no_hp']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="foto">🖼️ Ganti Foto</label>
                        <input type="file" name="foto" id="foto" accept="image/*">
                        <small style="color: #718096;">Kosongkan jika tidak ingin mengganti foto</small>
                        <div style="margin-top: 10px;">
                            <p>Foto saat ini:</p>
                            <?php if ($row['foto'] && file_exists("assets/images/" . $row['foto'])): ?>
                                <img src="assets/images/<?= $row['foto']; ?>" style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;">
                            <?php else: ?>
                                <img src="assets/images/default.png" style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;">
                            <?php endif; ?>
                            <img id="preview-foto" style="display: none; width: 100px; height: 100px; border-radius: 10px; object-fit: cover; margin-top: 10px;">
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn btn-primary">💾 Update Data</button>
                        <a href="data-mahasiswa.php" class="btn" style="background: #718096; color: white;">❌ Batal</a>
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
        
        // Validasi form sebelum submit
        const form = document.getElementById('formEdit');
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#f56565';
                    field.style.backgroundColor = '#fff5f5';
                    isValid = false;
                } else {
                    field.style.borderColor = '#e2e8f0';
                    field.style.backgroundColor = 'white';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('❌ Mohon isi semua field yang wajib diisi!');
            }
        });
        
        // Hilangkan border merah saat diketik
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.style.borderColor = '#e2e8f0';
                    this.style.backgroundColor = 'white';
                }
            });
        });
    </script>
</body>
</html>