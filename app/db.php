<?php
// db.php - koneksi SQLite
$db_path = __DIR__ . '/../data/absensidb.sqlite';

try {
    $db = new PDO('sqlite:' . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi DB gagal: " . $e->getMessage());
}
?>
