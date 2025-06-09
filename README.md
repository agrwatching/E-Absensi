E-ABSENSI/
├── data/                       # Folder untuk file database SQLite
│   └── absensidb.sqlite       # File database utama
│
├── public/                    # Semua file yang diakses langsung lewat browser
│   ├── assets/
│   │   ├── css/               # Jika kamu pakai CSS tambahan
│   │   └── js/                # JavaScript tambahan (validasi form, interaksi UI)
│   ├── login.php              # Halaman login
│   ├── dashboard.php          # Halaman utama setelah login
│   ├── absensi.php            # Form input absensi
│   ├── rekap.php              # Halaman rekap absensi + export
│   ├── siswa.php              # Manajemen data siswa
│   ├── profil.php             # Halaman profil guru/user
│   └── logout.php             # Untuk keluar dari sesi login
│
├── app/                       # Folder logika backend (opsional, kalau mau rapi)
│   ├── db.php                 # Koneksi SQLite
│   ├── auth.php               # Proses login/logout & validasi sesi
│   ├── functions.php          # Fungsi-fungsi umum (helper, absensi, siswa, export)
│   └── init.php               # Inisialisasi awal (create tabel kalau belum ada)
│
├── backup/                    # Tempat file hasil backup (bisa disambung ke Google Drive)
│
├── .gitignore                 # Ignore file yg tidak perlu saat push ke Git
├── README.md                  # Penjelasan proyek
