<?php
$conn = mysqli_connect('localhost', 'root', 'root', 'ifnwn-wekkly');
//                                   ↑      ↑
//                                user    password

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// kode lo selanjutnya...
?>