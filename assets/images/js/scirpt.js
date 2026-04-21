// Data mahasiswa
const studentsData = [
    { nim: "220101001", nama: "Ahmad Fauzan", prodi: "Informatika", angkatan: "2022", status: "Aktif" },
    { nim: "220101002", nama: "Budi Santoso", prodi: "Informatika", angkatan: "2022", status: "Aktif" },
    { nim: "220101003", nama: "Citra Dewi Lestari", prodi: "Informatika", angkatan: "2022", status: "Aktif" },
    { nim: "220101004", nama: "Dian Permata Sari", prodi: "Informatika", angkatan: "2022", status: "Aktif" },
    { nim: "220101005", nama: "Eka Pratama", prodi: "Informatika", angkatan: "2022", status: "Aktif" },
    { nim: "220101006", nama: "Farah Azzahra", prodi: "Informatika", angkatan: "2022", status: "Aktif" },
    { nim: "220101007", nama: "Gilang Ramadan", prodi: "Informatika", angkatan: "2022", status: "Aktif" },
    { nim: "220101008", nama: "Hana Malika", prodi: "Informatika", angkatan: "2022", status: "Aktif" }
];

// Fungsi untuk menampilkan data mahasiswa di tabel
function loadStudentData() {
    const tableBody = document.getElementById('studentTableBody');
    const totalSpan = document.getElementById('totalStudents');
    
    if (tableBody && totalSpan) {
        // Kosongkan tabel terlebih dahulu
        tableBody.innerHTML = '';
        
        // Loop data dan tambahkan ke tabel
        studentsData.forEach(student => {
            const row = tableBody.insertRow();
            row.innerHTML = `
                <td>${student.nim}</td>
                <td><strong>${student.nama}</strong></td>
                <td>${student.prodi}</td>
                <td>${student.angkatan}</td>
                <td><span class="badge">✅ ${student.status}</span></td>
            `;
        });
        
        // Update total mahasiswa
        totalSpan.textContent = studentsData.length;
    }
}

// Fungsi untuk menangani form kontak
function initContactForm() {
    const form = document.getElementById('contactForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            const feedback = document.getElementById('formFeedback');
            
            if (!name || !email || !message) {
                feedback.innerHTML = '<div style="background: #ffe6e5; color: #c62828; padding: 10px; border-radius: 8px;">⚠️ Harap isi semua bidang!</div>';
                return;
            }
            
            if (!email.includes('@') || !email.includes('.')) {
                feedback.innerHTML = '<div style="background: #ffe6e5; color: #c62828; padding: 10px; border-radius: 8px;">📧 Email tidak valid!</div>';
                return;
            }
            
            feedback.innerHTML = '<div style="background: #e8f5e9; color: #2e7d32; padding: 10px; border-radius: 8px;">✅ Terima kasih ' + name + ', pesan Anda telah terkirim!</div>';
            
            // Reset form
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('message').value = '';
            
            // Hapus pesan setelah 3 detik
            setTimeout(() => {
                feedback.innerHTML = '';
            }, 3000);
        });
    }
}

// Set active navigation based on current page
function setActiveNav() {
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('nav ul li a');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === '' && href === 'index.html')) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

// Inisialisasi semua fungsi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    loadStudentData();  // Load data mahasiswa
    initContactForm();  // Inisialisasi form kontak
    setActiveNav();     // Set active navigation
});