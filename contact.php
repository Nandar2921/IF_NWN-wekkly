<?php
// ============================================
// FILE: contact.php
// FUNGSI: Halaman kontak
// ============================================

require 'fungsi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Informatika</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-headset"></i> CONTACT US</h1>
            <p>Hubungi kami melalui informasi di bawah ini</p>
        </div>
        
        <!-- NAVIGASI -->
        <div class="navbar">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="profile.php"><i class="fas fa-user-graduate"></i> Profile</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
            <a href="mahasiswa.php"><i class="fas fa-table"></i> Data Mahasiswa</a>
        </div>
        
        <div class="content">
            <!-- CONTACT INFO -->
            <div class="contact-grid">
                <div class="card contact-info">
                    <h2><i class="fas fa-map-marker-alt"></i> Alamat</h2>
                    <p><i class="fas fa-location-dot"></i> Jl. Informatika No. 123, Kota Semarang, Jawa Tengah 40123</p>
                    <p><i class="fas fa-clock"></i> Senin - Jumat, 08:00 - 16:00</p>
                </div>
                
                <div class="card contact-info">
                    <h2><i class="fas fa-phone-alt"></i> Kontak</h2>
                    <p><i class="fas fa-envelope"></i> info@informatika.ac.id</p>
                    <p><i class="fas fa-phone"></i> (022) 1234 5678</p>
                    <p><i class="fas fa-fax"></i> (022) 1234 5679</p>
                </div>
            </div>
            
            <!-- MEDIA SOSIAL -->
            <div class="card">
                <h2><i class="fas fa-share-alt"></i> Media Sosial</h2>
                <div class="social-grid">
                    <a href="#" class="social-card instagram">
                        <i class="fab fa-instagram"></i>
                        <div>
                            <h4>Instagram</h4>
                            <p>@informatika.official</p>
                        </div>
                    </a>
                    <a href="#" class="social-card twitter">
                        <i class="fab fa-twitter"></i>
                        <div>
                            <h4>Twitter</h4>
                            <p>@informatika</p>
                        </div>
                    </a>
                    <a href="#" class="social-card linkedin">
                        <i class="fab fa-linkedin"></i>
                        <div>
                            <h4>LinkedIn</h4>
                            <p>Informatika University</p>
                        </div>
                    </a>
                    <a href="#" class="social-card youtube">
                        <i class="fab fa-youtube"></i>
                        <div>
                            <h4>YouTube</h4>
                            <p>Informatika TV</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- MAP -->
            <div class="map-card">
                <h2><i class="fas fa-map"></i> Lokasi Kami</h2>
                <div class="map-placeholder">
                    <i class="fas fa-map-marked-alt"></i>
                    <p>Google Maps Interaktif</p>
                    <small>Jl. Informatika No. 123, Kota Semarang</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>