<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa - Informatika</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-user-plus"></i> TAMBAH DATA MAHASISWA</h1>
            <p>Silakan isi form di bawah ini dengan lengkap</p>
        </div>
        
        <div class="navbar">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="profile.php"><i class="fas fa-user-graduate"></i> Profile</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
            <a href="data-mahasiswa.php"><i class="fas fa-table"></i> Data Mahasiswa</a>
        </div>
        
        <div class="content">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>
            
            <div class="form-card">
                <form action="proses-input.php" method="post" enctype="multipart/form-data" id="formTambah">
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="nama" id="nama" required placeholder="Masukkan nama lengkap">
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-id-card"></i> NIM <span class="required">*</span></label>
                            <input type="number" name="nim" id="nim" required placeholder="Masukkan NIM">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-graduation-cap"></i> Jurusan <span class="required">*</span></label>
                            <select name="jurusan" id="jurusan" required>
                                <option value="">Pilih Jurusan</option>
                                <option value="Informatika">Informatika</option>
                                <option value="Sistem Informasi">Sistem Informasi</option>
                                <option value="Teknik Komputer">Teknik Komputer</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email <span class="required">*</span></label>
                            <input type="email" name="email" id="email" required placeholder="contoh@email.com">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> No. HP <span class="required">*</span></label>
                            <input type="text" name="no_hp" id="no_hp" required placeholder="08123456789">
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-image"></i> Foto</label>
                            <input type="file" name="foto" id="foto" accept="image/*">
                            <small><i class="fas fa-info-circle"></i> Format: JPG, PNG, GIF (Max 2MB)</small>
                            <div id="preview-container"></div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <a href="data-mahasiswa.php" class="btn btn-cancel">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        const fotoInput = document.getElementById('foto');
        const previewContainer = document.getElementById('preview-container');
        
        fotoInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                const preview = document.createElement('img');
                preview.style.width = '100px';
                preview.style.height = '100px';
                preview.style.borderRadius = '12px';
                preview.style.objectFit = 'cover';
                preview.style.marginTop = '10px';
                preview.style.border = '2px solid #667eea';
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
                previewContainer.appendChild(preview);
            }
        });
    </script>
</body>
</html>