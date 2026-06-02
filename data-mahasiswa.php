<?php
include 'koneksi.php';

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
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 DATA MAHASISWA</h1>
            <p>Manajemen Data Mahasiswa Informatika</p>
        </div>
        
        <div class="navbar">
            <a href="index.php">🏠 Home</a>
            <a href="profile.php">👤 Profile</a>
            <a href="contact.php">📞 Contact</a>
            <a href="data-mahasiswa.php">📊 Data Mahasiswa</a>
        </div>
        
        <div class="content">
            <div class="toolbar">
                <a href="inputdata.php" class="btn btn-primary">➕ Tambah Data</a>
                <div>
                    <input type="text" id="searchInput" class="search-box" placeholder="🔍 Cari nama, nim, atau jurusan..." onkeyup="searchData()">
                    <button onclick="exportToCSV()" class="btn btn-primary">📥 Export CSV</button>
                </div>
            </div>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">✅ <?= htmlspecialchars($_GET['success']) ?></div>
            <?php endif; ?>
            
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
                        <td><?= $no++; ?></td>
                        <td>
                            <?php if ($row['foto'] && file_exists("assets/images/" . $row['foto'])): ?>
                                <img src="assets/images/<?= $row['foto']; ?>" class="foto-mahasiswa" alt="Foto">
                            <?php else: ?>
                                <img src="assets/images/default.png" class="foto-mahasiswa" alt="No Image">
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['nim']); ?></td>
                        <td><?= htmlspecialchars($row['jurusan']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['no_hp']); ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-edit">✏️ Edit</a>
                            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <?php if (mysqli_num_rows($data) == 0): ?>
                <div class="alert alert-error" style="text-align: center;">❌ Tidak ada data mahasiswa. Silakan tambah data!</div>
            <?php endif; ?>
        </div>
    </div>
    
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
                        rowData.push('"' + cell.innerText.replace(/"/g, '""') + '"');
                    }
                });
                csv.push(rowData.join(','));
            });
            const blob = new Blob([csv.join('\n')], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'data-mahasiswa.csv';
            a.click();
            URL.revokeObjectURL(url);
        }
    </script>
</body>
</html>