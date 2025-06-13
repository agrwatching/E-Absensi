<?php
require_once(__DIR__ . '/../../app/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_siswa']) && is_array($_POST['id_siswa'])) {
    $ids = $_POST['id_siswa'];

    if (count($ids) > 0) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $db->prepare("DELETE FROM siswa WHERE id_siswa IN ($placeholders)");

        if ($stmt->execute($ids)) {
            $jumlah = count($ids);
            echo "<script>
                alert('✅ $jumlah siswa berhasil dihapus.');
                window.location.href='../../dashboard.php?page=info_siswa';
            </script>";
            exit;
        } else {
            $error = $stmt->errorInfo();
            echo "<script>
                alert('❌ Gagal menghapus siswa: {$error[2]}');
                window.location.href='../../dashboard.php?page=info_siswa';
            </script>";
            exit;
        }
    } else {
        echo "<script>
            alert('⚠️ Tidak ada siswa yang dipilih.');
            window.location.href='../../dashboard.php?page=info_siswa';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('❌ Permintaan tidak valid.');
        window.location.href='../../dashboard.php?page=info_siswa';
    </script>";
    exit;
}
