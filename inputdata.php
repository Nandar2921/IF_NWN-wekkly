<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>➕ TAMBAH DATA MAHASISWA</h1>
            <p>Silakan isi form di bawah ini</p>
        </div>
        
        <div class="navbar">
            <a href="index.php">🏠 Home</a>
            <a href="profile.php">👤 Profile</a>
            <a href="contact.php">📞 Contact</a>
            <a href="data-mahasiswa.php">📊 Data Mahasiswa</a>
        </div>
        
        <div class="content">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    ❌ <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>
            
            <div class="card">
                <form action="proses-input.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama">📝 Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" required placeholder="Masukkan nama lengkap">
                    </div>
                    
                    <div class="form-group">
                        <label for="nim">🆔 NIM</label>
                        <input type="number" name="nim" id="nim" required placeholder="Masukkan NIM">
                    </div>
                    
                    <div class="form-group">
                        <label for="jurusan">🎓 Jurusan</label>
                        <select name="jurusan" id="jurusan" required>
                            <option value="">Pilih Jurusan</option>
                            <option value="Informatika">Informatika</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Teknik Komputer">Teknik Komputer</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">📧 Email</label>
                        <input type="email" name="email" id="email" required placeholder="contoh@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="no_hp">📱 No. HP</label>
                        <input type="text" name="no_hp" id="no_hp" required placeholder="08123456789">
                    </div>
                    
                    <div class="form-group">
                        <label for="foto">🖼️ Foto</label>
                        <input type="file" name="foto" id="foto" accept="image/*">
                        <small style="color: #718096;">Format: JPG, PNG, GIF (Max 2MB)</small>
                        <div style="margin-top: 10px;">
                            <img id="preview-foto" style="display: none; width: 100px; height: 100px; border-radius: 10px; object-fit: cover;">
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn btn-primary">💾 Simpan Data</button>
                        <a href="data-mahasiswa.php" class="btn" style="background: #718096; color: white;">❌ Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>