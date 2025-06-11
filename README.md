E-ABSENSI/
├── data/                       # Folder untuk file database SQLite
│   └── absensidb.sqlite       # File database utama
│
├── public/                    # Semua file yang diakses langsung lewat browser
│   ├── img/
│   │   ├──gambar-isr.png
│   │   └──hidden.png
│   │   └──sidebar on.png
│   │   └──title.png
│   │   └──visible.png
│   │   └──user.png
│   │
│   ├── layouts/
│   │       └──profil.php      # Halaman profil guru/user
│   │       └──info_siswa.php
│   │       └──absensi.php
│   │       └──rekap_absensi.php
│   │       └──backup.php
│   │       └──profil.php
│   │
│   ├── index.php               # Halaman login
│   ├── logout.php              # Halaman utama setelah login
│   ├── proses_login.php        # Form input absensi
│   ├── setup_db.php            # Halaman rekap absensi + export
│   ├── dashboard.php             # Manajemen data siswa
│
├── app/                       # Folder logika backend (opsional, kalau mau rapi)
│   ├── db.php                 # Koneksi SQLite
│   ├── auth.php               # Proses login/logout & validasi sesi
│   └── init.php               # Inisialisasi awal (create tabel kalau belum ada)
│
├── backup/                    # Tempat file hasil backup (bisa disambung ke Google Drive)
│
├── .gitignore                 # Ignore file yg tidak perlu saat push ke Git
├── README.md                  # Penjelasan proyek
