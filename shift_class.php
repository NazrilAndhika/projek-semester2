<?php
// Memulai session jika belum aktif, untuk menyimpan data linked list
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kelas Node mewakili satu elemen dalam circular linked list
class Node {
    public $shift; // Nomor shift
    public $jam;   // Waktu shift
    public $nama;  // Nama orang yang bertugas (bisa null)
    public $next;  // Pointer ke node berikutnya (untuk circular)

    // Konstruktor untuk inisialisasi nilai node
    public function __construct($shift, $jam, $nama = null) {
        $this->shift = $shift;
        $this->jam = $jam;
        $this->nama = $nama;
        $this->next = null;
    }
}

// Kelas utama CircularLinkedList yang menangani seluruh operasi shift
class CircularLinkedList {
    private $head = null; // Pointer awal (shift aktif)
    private $tail = null; // Pointer akhir (terhubung ke head kembali)

    // Daftar jam shift yang tetap
    private $jam_shift = [
        "08.00 - 11.00",
        "11.00 - 14.00",
        "14.00 - 17.00",
        "17.00 - 20.00",
        "20.00 - 23.00"
    ];

    // Konstruktor kelas: buat list awal jika belum ada di session
    public function __construct() {
        if (!isset($_SESSION['linked_list'])) {
            $this->buatListAwal(); // Membuat 5 shift default
            $this->simpan();       // Simpan ke session
        } else {
            $this->ambilDariSession(); // Ambil data dari session jika sudah ada
        }
    }

    // Membuat node shift dari jam_shift dan menghubungkannya secara circular
    private function buatListAwal() {
        foreach ($this->jam_shift as $i => $jam) {
            $nodeBaru = new Node($i + 1, $jam, null); // shift ke-i
            if ($this->head === null) {
                // Jika list masih kosong, inisialisasi head dan tail
                $this->head = $this->tail = $nodeBaru;
                $nodeBaru->next = $this->head; // Circular: mengarah ke diri sendiri
            } else {
                // Menambahkan node baru di akhir dan buat circular kembali
                $this->tail->next = $nodeBaru;
                $this->tail = $nodeBaru;
                $this->tail->next = $this->head;
            }
        }
    }

    // Fungsi untuk menambahkan nama ke shift kosong pertama yang ditemukan
    public function tambahNama($nama) {
        $curr = $this->head;
        do {
            if ($curr->nama === null) {
                $curr->nama = $nama;
                $this->simpan(); // Update session
                return true;
            }
            $curr = $curr->next;
        } while ($curr !== $this->head);
        return false; // Jika semua shift sudah terisi
    }

    // Menghapus nama berdasarkan nomor shift
    public function hapusNama($shiftIndex) {
        $curr = $this->head;
        do {
            if ($curr->shift == $shiftIndex) {
                $curr->nama = null; // Kosongkan isian nama
                $this->simpan();    // Simpan perubahan
                break;
            }
            $curr = $curr->next;
        } while ($curr !== $this->head);
    }

    // Fungsi untuk merotasi shift aktif ke node berikutnya
    public function rotasi() {
        if ($this->head !== null && $this->head !== $this->tail) {
            $this->head = $this->head->next;
            $this->tail = $this->tail->next;
            $this->simpan(); // Simpan setelah rotasi
        }
    }

    // Menampilkan info shift aktif saat ini
    public function lihatShiftAktif() {
        if ($this->head === null) {
            return "Belum ada data shift.";
        }

        $shift = $this->head->shift;
        $jam = $this->head->jam;
        $nama = $this->head->nama;

        if ($nama === null) {
            return "Shift $shift ($jam) - Belum ada yang bertugas.";
        } else {
            return "Shift $shift ($jam) - $nama";
        }
    }

    // Mengambil semua data shift untuk ditampilkan dalam daftar
    public function getAllShifts() {
        $data = [];
        $curr = $this->head;

        // Cari node dengan shift == 1 agar daftar tampil dari awal
        $start = $this->head;
        do {
            if ($curr->shift == 1) {
                $start = $curr;
                break;
            }
            $curr = $curr->next;
        } while ($curr !== $this->head);

        // Ambil semua node dari shift 1 sampai 5 (1 putaran penuh)
        $curr = $start;
        do {
            $data[] = [
                'shift' => $curr->shift,
                'jam'   => $curr->jam,
                'nama'  => $curr->nama
            ];
            $curr = $curr->next;
        } while ($curr !== $start);

        return $data;
    }

    // Menyimpan struktur list ke dalam session (diserialisasi)
    private function simpan() {
        $_SESSION['linked_list'] = serialize([
            'head' => $this->head,
            'tail' => $this->tail
        ]);
    }

    // Mengambil kembali struktur list dari session (deserialisasi)
    private function ambilDariSession() {
        $data = unserialize($_SESSION['linked_list']);
        $this->head = $data['head'];
        $this->tail = $data['tail'];
    }
}
