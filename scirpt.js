// ========== KONFIRMASI HAPUS ==========
document.addEventListener('DOMContentLoaded', function() {
    // Semua tombol hapus
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const confirmed = confirm('⚠️ Apakah Anda yakin ingin menghapus data ini?\n\nData yang dihapus tidak dapat dikembalikan!');
            
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });
    
    // ========== AUTO HIDE ALERT ==========
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                if (alert.style.display !== 'none') {
                    alert.style.display = 'none';
                }
            }, 300);
        }, 3000);
    });
    
    // ========== PREVIEW FOTO SEBELUM UPLOAD ==========
    const fotoInput = document.getElementById('foto');
    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            let preview = document.getElementById('preview-foto');
            
            // Buat elemen preview jika belum ada
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'preview-foto';
                preview.style.width = '100px';
                preview.style.height = '100px';
                preview.style.borderRadius = '10px';
                preview.style.objectFit = 'cover';
                preview.style.marginTop = '10px';
                preview.style.display = 'none';
                this.parentNode.appendChild(preview);
            }
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    }
    
    // ========== VALIDASI FORM ==========
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
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
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.style.borderColor = '#e2e8f0';
                    this.style.backgroundColor = 'white';
                }
            });
        });
    });
    
    // ========== TOOLTIP EFFECT ==========
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});

// ========== FUNCTION SEARCH DATA ==========
function searchData() {
    const input = document.getElementById('searchInput');
    if (!input) return;
    
    const filter = input.value.toUpperCase();
    const table = document.getElementById('dataTable');
    if (!table) return;
    
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        
        // Looping dari kolom ke-2 (skip kolom No dan Foto)
        for (let j = 2; j < cells.length - 1; j++) {
            if (cells[j]) {
                const text = cells[j].textContent || cells[j].innerText;
                if (text.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        
        rows[i].style.display = found ? '' : 'none';
    }
}

// ========== FUNCTION EXPORT TO CSV ==========
function exportToCSV() {
    const table = document.getElementById('dataTable');
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = [];
        
        cells.forEach((cell, index) => {
            // Skip kolom foto (biasanya index ke-1 atau ke-2 tergantung tabel)
            const isFotoColumn = (index === 1 && row.querySelectorAll('th').length === 0);
            
            if (!isFotoColumn) {
                let text = cell.innerText.replace(/"/g, '""');
                // Skip tombol aksi yang ada teks "Edit Hapus"
                if (text !== 'Edit' && text !== 'Hapus' && text !== '✏️ Edit' && text !== '🗑️ Hapus') {
                    rowData.push('"' + text + '"');
                }
            }
        });
        
        if (rowData.length > 0) {
            csv.push(rowData.join(','));
        }
    });
    
    // Download file CSV
    const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'data-mahasiswa-' + new Date().toISOString().slice(0,19) + '.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    // Notifikasi sukses
    alert('✅ Data berhasil diexport ke CSV!');
}

// ========== FUNCTION RESET SEARCH ==========
function resetSearch() {
    const input = document.getElementById('searchInput');
    if (input) {
        input.value = '';
        searchData();
    }
}