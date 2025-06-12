<?php
require_once(__DIR__ . '/../../app/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jumlah']) && isset($_POST['siswa'])) {
    $jumlah = (int) $_POST['jumlah'];
    $siswaData = $_POST['siswa'];

    foreach ($siswaData as $data) {
        $no_induk = $data['no_induk'] ?? '';
        $nisn = $data['nisn'] ?? '';
        $nama = $data['nama'] ?? '';
        $jenis_kelamin = $data['jenis_kelamin'] ?? '';
        $id_kelas = $data['id_kelas'] ?? '';

        // Lewati jika semua field kosong
        if (empty($no_induk) && empty($nisn) && empty($nama)) {
            continue;
        }

        // Simpan ke database
        $stmt = $db->prepare("INSERT INTO siswa (no_induk, nisn, nama, jenis_kelamin, id_kelas) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$no_induk, $nisn, $nama, $jenis_kelamin, $id_kelas]);
    }

    // Redirect setelah selesai
    header("Location: ../../dashboard.php?page=info_siswa&berhasil=1");
    exit;
} else {
    // Redirect jika akses tidak valid
    header("Location: ../../dashboard.php?page=info_siswa");
    exit;
}
