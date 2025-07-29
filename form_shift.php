<?php
// Mulai session untuk menangani notifikasi (pesan setelah aksi)
session_start();

// Import file class shift yang berisi struktur dan logika linked list circular
require 'shift_class.php';

// Membuat objek CircularLinkedList untuk mengelola data shift
$manager = new CircularLinkedList();

// Ambil pesan dari session jika ada, misalnya "Nama telah ditambahkan"
$pesan = $_SESSION['pesan'] ?? '';

// Hapus pesan dari session agar tidak muncul terus menerus
unset($_SESSION['pesan']);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Shift EXPO</title>
    <!-- Menghubungkan file CSS untuk styling -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
    <h2>Shift EXPO - Panel Utama</h2>

    <!-- Menampilkan pesan notifikasi jika ada -->
    <?php if ($pesan): ?>
        <p style="color: red;"><?= htmlspecialchars($pesan) ?></p>
    <?php endif; ?>

    <!-- Form untuk menambahkan shift baru -->
    <form method="POST" action="tambah_shift.php">
        <!-- Input nama shift -->
        <input type="text" name="nama_shift" placeholder="Nama" required>
        <!-- Tombol untuk submit form -->
        <button type="submit">Tambah Shift</button>
    </form>

    <!-- Menampilkan shift yang sedang aktif -->
    <h3>Yang Bertugas Saat Ini:</h3>
    <p><strong><?= htmlspecialchars($manager->lihatShiftAktif()) ?></strong></p>
    
    <!-- Form untuk melakukan rotasi shift ke orang berikutnya -->
    <form method="POST" action="rotasi_shift.php" style="margin-top:10px;" class="rotasi">
        <!-- Tombol rotasi shift -->
        <button type="submit">Rotasi Shift</button>
    </form>

    <!-- Link menuju halaman daftar semua shift -->
    <p><a href="daftar_shift.php">🔍 Lihat Daftar Shift</a></p>
    </div>
</body>
</html>