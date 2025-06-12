<?php
require_once(__DIR__ . '/../../app/db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID siswa tidak ditemukan.");
}

// Cek apakah siswa ada
$stmt = $db->prepare("SELECT * FROM siswa WHERE id_siswa = ?");
$stmt->execute([$id]);
$siswa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$siswa) {
    die("Siswa tidak ditemukan.");
}

// Hapus siswa
$stmt = $db->prepare("DELETE FROM siswa WHERE id_siswa = ?");
$stmt->execute([$id]);
?>

<!-- Redirect pakai JavaScript -->
<script>
    alert("✅ Siswa berhasil dihapus.");
    window.location.href = "../../dashboard.php?page=info_siswa";
</script>
