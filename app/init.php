<?php
require_once 'db.php';

// Buat tabel users jika belum ada
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL
)");

// Contoh insert user (username: guru, password: 12345)
// Password wajib di-hash supaya aman
$hash = password_hash('12345', PASSWORD_DEFAULT);

// Cek dulu apakah user 'guru' sudah ada
$stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
$stmt->execute(['guru']);
$count = $stmt->fetchColumn();

if ($count == 0) {
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute(['guru', $hash]);
    echo "User 'guru' berhasil dibuat dengan password '12345'.<br>";
} else {
    echo "User 'guru' sudah ada.<br>";
}
?>
