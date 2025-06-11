<?php
// setup_db.php

// Lokasi file database SQLite
$dbFile = __DIR__ . '/../data/absensidb.sqlite';

// Pastikan folder 'data/' sudah ada
if (!is_dir(__DIR__ . '/../data')) {
    mkdir(__DIR__ . '/../data', 0755, true);
}

// Buat koneksi
try {
    $db = new PDO("sqlite:$dbFile");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("PRAGMA foreign_keys = ON");

    // Buat tabel kelas
    $db->exec("
        CREATE TABLE IF NOT EXISTS kelas (
            id_kelas INTEGER PRIMARY KEY AUTOINCREMENT,
            nama_kelas TEXT UNIQUE NOT NULL
        )
    ");

    // Buat tabel siswa
    $db->exec("
        CREATE TABLE IF NOT EXISTS siswa (
            id_siswa INTEGER PRIMARY KEY AUTOINCREMENT,
            no_induk TEXT NOT NULL,
            nisn TEXT UNIQUE NOT NULL,
            nama TEXT NOT NULL,
            jenis_kelamin TEXT CHECK(jenis_kelamin IN ('L', 'P')) NOT NULL,
            id_kelas INTEGER NOT NULL,
            FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas)
        )
    ");

    // Buat tabel mata pelajaran
    $db->exec("
        CREATE TABLE IF NOT EXISTS mata_pelajaran (
            id_mapel INTEGER PRIMARY KEY AUTOINCREMENT,
            nama_mapel TEXT NOT NULL
        )
    ");

    // Buat tabel absensi
    $db->exec("
        CREATE TABLE IF NOT EXISTS absensi (
            id_absensi INTEGER PRIMARY KEY AUTOINCREMENT,
            id_siswa INTEGER NOT NULL,
            id_mapel INTEGER NOT NULL,
            tanggal DATE NOT NULL,
            jam_mulai TEXT,
            jam_akhir TEXT,
            status TEXT CHECK(status IN ('Hadir', 'Izin', 'Sakit', 'Alpa')) NOT NULL,
            keterangan TEXT,
            FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa),
            FOREIGN KEY (id_mapel) REFERENCES mata_pelajaran(id_mapel)
        )
    ");

    // Buat tabel user (login guru)
    $db->exec("
        CREATE TABLE IF NOT EXISTS user (
            id_user INTEGER PRIMARY KEY AUTOINCREMENT,
            nama_lengkap TEXT NOT NULL,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            foto_profil TEXT NOT NULL
        )
    ");

    // Tambahkan data kelas awal
    $kelas = ['7A', '7B', '7C', '8A', '8B', '8C', '9A', '9B', '9C'];
    $stmt = $db->prepare("INSERT OR IGNORE INTO kelas (nama_kelas) VALUES (?)");
    foreach ($kelas as $nama) {
        $stmt->execute([$nama]);
    }

    $cekUser = $db->query("SELECT COUNT(*) FROM user")->fetchColumn();
    if ($cekUser == 0) {
        $username = 'guru';
        $password = password_hash('guru123', PASSWORD_DEFAULT);
        $db->prepare("INSERT INTO user (username, password) VALUES (?, ?)")->execute([$username, $password]);
    }

    echo "✅ Database dan tabel berhasil dibuat.";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
