<?php
// Mengimpor file yang berisi class CircularLinkedList dan logika shift
require 'shift_class.php';

// Mengambil data shift yang akan dihapus dari form (via POST)
// Jika tidak ada data, maka akan bernilai null
$shift_number = $_POST['hapus_shift'] ?? null;

// Jika shift yang akan dihapus tersedia
if ($shift_number !== null) {
    // Membuat objek CircularLinkedList baru
    $manager = new CircularLinkedList();

    // Memanggil fungsi untuk menghapus nama shift berdasarkan indeks/nomor
    $manager->hapusNama((int)$shift_number);  // pastikan dalam bentuk integer
}

// Mengalihkan pengguna kembali ke halaman daftar shift setelah proses selesai
header("Location: daftar_shift.php");

// Menghentikan eksekusi script agar tidak memproses lebih lanjut
exit;
