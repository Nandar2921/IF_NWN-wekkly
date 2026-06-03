<?php
include 'koneksi.php';

// Hitung statistik
$total_mahasiswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mahasiswa"));
$total_informatika = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mahasiswa WHERE jurusan = 'Informatika'"));
$total_si = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mahasiswa WHERE jurusan = 'Sistem Informasi'"));
$total_tk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mahasiswa WHERE jurusan = 'Teknik Komputer'"));

$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$search%' OR nim LIKE '%$search%' OR jurusan LIKE '%$search%'";
} else {
    $query = "SELECT * FROM mahasiswa";
}
$data = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - Informatika</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-users"></i> DATA MAHASISWA</h1>
            <p>Manajemen Data Mahasiswa Informatika</p>
        </div>
        
        <div class="navbar">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="profile.php"><i class="fas fa-user-graduate"></i> Profile</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
            <a href="data-mahasiswa.php"><i class="fas fa-table"></i> Data Mahasiswa</a>
        </div>
        
        <div class="content">
            <!-- Statistics Cards -->
            <div class="stats-container">
                <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-users" style="font-size: 2.5em; margin-bottom: 10px;"></i>
                    <h3><?= $total_mahasiswa; ?></h3>
                    <p>Total Mahasiswa</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="fas fa-laptop-code" style="font-size: 2.5em; margin-bottom: 10px;"></i>
                    <h3><?= $total_informatika; ?></h3>
                    <p>Teknik Informatika</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-database" style="font-size: 2.5em; margin-bottom: 10px;"></i>
                    <h3><?= $total_si; ?></h3>
                    <p>Sistem Informasi</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="fas fa-microchip" style="font-size: 2.5em; margin-bottom: 10px;"></i>
                    <h3><?= $total_tk; ?></h3>
                    <p>Teknik Komputer</p>
                </div>
            </div>
            
            <div class="toolbar">
                <a href="inputdata.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
                <div style="display: flex; gap: 10px;">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-box" placeholder="Cari nama, nim, atau jurusan..." onkeyup="searchData()">
                    </div>
                    <button onclick="exportToCSV()" class="btn btn-primary">
                        <i class="fas fa-download"></i> Export CSV
                    </button>
                </div>
            </div>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>
            
            <div class="table-wrapper">
                <table class="data-table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Jurusan</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php while($row = mysqli_fetch_assoc($data)) : ?>
                        <tr>
                            <td data-label="No"><?= $no++; ?></td>
                            <td data-label="Foto">
                                <?php if ($row['foto'] && file_exists("assets/images/" . $row['foto'])): ?>
                                    <img src="assets/images/<?= $row['foto']; ?>" class="foto-mahasiswa" alt="Foto">
                                <?php else: ?>
                                    <img src="assets/images/default.png" class="foto-mahasiswa" alt="No Image">
                                <?php endif; ?>
                            </td>
                            <td data-label="Nama"><strong><?= htmlspecialchars($row['nama']); ?></strong></td>
                            <td data-label="NIM"><code><?= htmlspecialchars($row['nim']); ?></code></td>
                            <td data-label="Jurusan">
                                <span class="badge jurusan-<?= strtolower(str_replace(' ', '', $row['jurusan'])); ?>">
                                    <?= htmlspecialchars($row['jurusan']); ?>
                                </span>
                            </td>
                            <td data-label="Email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email']); ?></td>
                            <td data-label="No. HP"><i class="fas fa-phone"></i> <?= htmlspecialchars($row['no_hp']); ?></td>
                            <td data-label="Aksi" class="action-buttons">
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (mysqli_num_rows($data) == 0): ?>
                <div class="alert alert-error" style="text-align: center;">
                    <i class="fas fa-exclamation-triangle"></i> Tidak ada data mahasiswa. Silakan tambah data!
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="script.js"></script>
    <script>
        function searchData() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('dataTable');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let found = false;
                for (let j = 2; j < cells.length - 1; j++) {
                    if (cells[j] && cells[j].textContent.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
                rows[i].style.display = found ? '' : 'none';
            }
        }
        
        function exportToCSV() {
            const table = document.getElementById('dataTable');
            const rows = table.querySelectorAll('tr');
            let csv = [];
            rows.forEach(row => {
                const cells = row.querySelectorAll('th, td');
                const rowData = [];
                cells.forEach((cell, index) => {
                    if (index !== 1) {
                        let text = cell.innerText.replace(/"/g, '""');
                        if (text !== 'Edit' && text !== 'Hapus' && !text.includes('✏️') && !text.includes('🗑️')) {
                            rowData.push('"' + text + '"');
                        }
                    }
                });
                if (rowData.length > 0) {
                    csv.push(rowData.join(','));
                }
            });
            const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'data-mahasiswa-' + new Date().toISOString().slice(0,19) + '.csv';
            a.click();
            URL.revokeObjectURL(url);
            alert('✅ Data berhasil diexport ke CSV!');
        }
    </script>
</body>
</html>