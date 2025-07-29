<?php
// Mengimpor file class CircularLinkedList yang menangani logika shift
require 'shift_class.php';

// Mengambil input nama dari form POST, jika tidak ada maka default ke string kosong
$nama = $_POST['nama_shift'] ?? '';

// Membuat objek CircularLinkedList untuk mengelola shift
$manager = new CircularLinkedList();

// Jika input nama tidak kosong
if ($nama) {
    // Coba tambahkan nama ke shift yang kosong
    if ($manager->tambahNama($nama)) {
        // Jika berhasil ditambahkan, simpan pesan sukses ke session
        $_SESSION['pesan'] = "✅ Nama telah ditambahkan.";
    } else {
        // Jika semua shift sudah penuh, simpan pesan gagal
        $_SESSION['pesan'] = "❌ Shift penuh! Maksimal 5 orang sudah terisi.";
    }
}

// Redirect kembali ke halaman utama form_shift.php setelah proses
header("Location: form_shift.php");

// Menghentikan eksekusi script agar redirect berjalan dengan benar
exit;
