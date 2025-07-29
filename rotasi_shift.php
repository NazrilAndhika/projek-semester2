<?php
// Mengimpor file class CircularLinkedList yang berisi struktur dan fungsi shift
require 'shift_class.php';

// Membuat objek CircularLinkedList untuk mengakses dan mengelola data shift
$manager = new CircularLinkedList();

// Memanggil fungsi rotasi untuk memindahkan shift ke orang berikutnya
$manager->rotasi();

// Mengalihkan kembali ke halaman utama (form_shift.php) setelah rotasi dilakukan
header("Location: form_shift.php");

// Menghentikan eksekusi script untuk memastikan redirect bekerja sempurna
exit;

