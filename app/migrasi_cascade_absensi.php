<?php
// migrasi_cascade_absensi.php
require_once(__DIR__ . '/../app/db.php');

try {
    $db->beginTransaction();

    // 1. Backup data absensi
    $absensiBackup = $db->query("SELECT * FROM absensi")->fetchAll(PDO::FETCH_ASSOC);

    // 2. Drop tabel absensi lama
    $db->exec("DROP TABLE IF EXISTS absensi");

    // 3. Buat ulang tabel absensi dengan ON DELETE CASCADE
    $db->exec("
        CREATE TABLE absensi (
            id_absensi INTEGER PRIMARY KEY AUTOINCREMENT,
            id_siswa INTEGER NOT NULL,
            id_mapel INTEGER NOT NULL,
            tanggal DATE NOT NULL,
            jam_mulai TEXT,
            jam_akhir TEXT,
            status TEXT CHECK(status IN ('Hadir', 'Izin', 'Sakit', 'Alpa')) NOT NULL,
            keterangan TEXT,
            FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
            FOREIGN KEY (id_mapel) REFERENCES mata_pelajaran(id_mapel)
        )
    ");

    // 4. Kembalikan data ke absensi
    $stmt = $db->prepare("
        INSERT INTO absensi (id_absensi, id_siswa, id_mapel, tanggal, jam_mulai, jam_akhir, status, keterangan)
        VALUES (:id_absensi, :id_siswa, :id_mapel, :tanggal, :jam_mulai, :jam_akhir, :status, :keterangan)
    ");

    foreach ($absensiBackup as $data) {
        $stmt->execute([
            ':id_absensi' => $data['id_absensi'],
            ':id_siswa' => $data['id_siswa'],
            ':id_mapel' => $data['id_mapel'],
            ':tanggal' => $data['tanggal'],
            ':jam_mulai' => $data['jam_mulai'],
            ':jam_akhir' => $data['jam_akhir'],
            ':status' => $data['status'],
            ':keterangan' => $data['keterangan']
        ]);
    }

    $db->commit();

    echo "✅ Migrasi berhasil. Foreign key sekarang ON DELETE CASCADE.";
} catch (Exception $e) {
    $db->rollBack();
    echo "❌ Gagal migrasi: " . $e->getMessage();
}
