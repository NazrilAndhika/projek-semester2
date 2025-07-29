<?php
session_start(); // Memulai session untuk menyimpan atau membaca data sesi

require 'shift_class.php'; // Memanggil class CircularLinkedList dan fungsinya

$manager = new CircularLinkedList(); // Membuat objek dari CircularLinkedList
$shifts = $manager->getAllShifts();  // Mengambil semua data shift (1 sampai 5)
?>


<!DOCTYPE html>
<html>
<head>
    <title>Daftar Shift EXPO</title>
    <!-- Menghubungkan ke file style eksternal agar tampilan rapi -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- Bungkus konten utama dengan div container agar tampilan terpusat -->
    <div class="container">

        <!-- Judul halaman -->
        <h2>Daftar Shift EXPO</h2>

        <!-- Tabel untuk menampilkan daftar shift -->
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>SHIFT</th>
                <th>JAM</th>
                <th>NAMA</th>
                <th>HAPUS</th>
            </tr>

            <!-- Loop setiap data shift -->
            <?php foreach ($shifts as $i => $shift): ?>
            <tr>
                <!-- Menampilkan nomor shift -->
                <td><?= $shift['shift'] ?></td>

                <!-- Menampilkan jam shift -->
                <td><?= $shift['jam'] ?></td>

                <!-- Menampilkan nama petugas jika ada, atau tanda '-' jika belum -->
                <td><?= $shift['nama'] ?? '-' ?></td>

                <!-- Kolom hapus hanya muncul jika nama sudah diisi -->
                <td>
                    <?php if ($shift['nama'] !== null): ?>
                    <form method="POST" action="hapus_shift.php" style="display:inline;">
                        <!-- Kirim shift yang akan dihapus melalui hidden input -->
                        <input type="hidden" name="hapus_shift" value="<?= $shift['shift'] ?>">

                        <!-- Tombol hapus -->
                        <button type="submit">HAPUS</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Link kembali ke halaman utama -->
        <p><a href="form_shift.php">⬅️ Kembali ke Panel Utama</a></p>

    </div>
</body>
</html>

