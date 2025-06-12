<?php
require_once(__DIR__ . '/../../app/db.php');

// Ambil semua data kelas
$kelasQuery = $db->query("SELECT * FROM kelas");
$kelasList = $kelasQuery->fetchAll(PDO::FETCH_ASSOC);

// Mapping kelas lama ke kelas baru
$naikKelas = [
    '7A' => '8A',
    '7B' => '8B',
    '7C' => '8C',
    '8A' => '9A',
    '8B' => '9B',
    '8C' => '9C',
];

// Ambil mapping id_kelas berdasarkan nama_kelas
$kelasIdMap = [];
foreach ($kelasList as $kelas) {
    $kelasIdMap[$kelas['nama_kelas']] = $kelas['id_kelas'];
}

// Step 1: Ambil semua siswa kelas 7 & 8 (kelas 9 tidak perlu karena lulus)
$siswaToPindah = [];

foreach ($naikKelas as $asal => $tujuan) {
    if (isset($kelasIdMap[$asal]) && isset($kelasIdMap[$tujuan])) {
        $id_kelas_asal = $kelasIdMap[$asal];
        $id_kelas_tujuan = $kelasIdMap[$tujuan];

        // Ambil siswa dari kelas asal
        $stmt = $db->prepare("SELECT * FROM siswa WHERE id_kelas = ?");
        $stmt->execute([$id_kelas_asal]);
        $siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Simpan untuk nanti dimasukkan ke tujuan
        foreach ($siswaList as $siswa) {
            $siswa['id_kelas'] = $id_kelas_tujuan;
            $siswaToPindah[] = $siswa;
        }
    }
}

// Step 2: Hapus semua siswa kelas 7, 8, dan 9
$kelasHapus = ['7A', '7B', '7C', '8A', '8B', '8C', '9A', '9B', '9C'];
foreach ($kelasHapus as $kelasNama) {
    if (isset($kelasIdMap[$kelasNama])) {
        $stmt = $db->prepare("DELETE FROM siswa WHERE id_kelas = ?");
        $stmt->execute([$kelasIdMap[$kelasNama]]);
    }
}

// Step 3: Masukkan kembali siswa yang naik kelas (tidak termasuk kelas 9)
foreach ($siswaToPindah as $siswa) {
    $stmt = $db->prepare("INSERT INTO siswa (no_induk, nisn, nama, jenis_kelamin, id_kelas) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $siswa['no_induk'],
        $siswa['nisn'],
        $siswa['nama'],
        $siswa['jenis_kelamin'],
        $siswa['id_kelas'],
    ]);
}

// ✅ Berhasil, redirect
echo "<script>
    alert('Proses kenaikan kelas berhasil!');
    window.location.href='../../dashboard.php?page=info_siswa';
</script>";
exit;
?>
