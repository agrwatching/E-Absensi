<?php
require_once(__DIR__ . '/../../app/db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID siswa tidak ditemukan.");
}

// Ambil data siswa
$stmt = $db->prepare("SELECT * FROM siswa WHERE id_siswa = ?");
$stmt->execute([$id]);
$siswa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$siswa) {
    die("Siswa tidak ditemukan.");
}

// Ambil semua kelas untuk dropdown
$kelasStmt = $db->query("SELECT * FROM kelas ORDER BY nama_kelas ASC");
$kelasList = $kelasStmt->fetchAll(PDO::FETCH_ASSOC);

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_induk = $_POST['no_induk'];
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $id_kelas = $_POST['id_kelas'];

    $stmt = $db->prepare("UPDATE siswa SET no_induk = ?, nisn = ?, nama = ?, jenis_kelamin = ?, id_kelas = ? WHERE id_siswa = ?");
    $stmt->execute([$no_induk, $nisn, $nama, $jenis_kelamin, $id_kelas, $id]);

    // Redirect pakai JS
    echo "<script>
        alert('✅ Data siswa berhasil diperbarui.');
        window.location.href = '../../dashboard.php?page=info_siswa';
    </script>";
    exit;
}
?>

<div class="p-6">
    <h2 class="text-xl font-bold mb-4">✏️ Edit Data Siswa</h2>
    <form method="post" class="space-y-4">
        <div>
            <label class="block">No Induk</label>
            <input type="text" name="no_induk" value="<?= htmlspecialchars($siswa['no_induk']) ?>" class="border rounded px-3 py-1 w-full" required>
        </div>
        <div>
            <label class="block">NISN</label>
            <input type="text" name="nisn" value="<?= htmlspecialchars($siswa['nisn']) ?>" class="border rounded px-3 py-1 w-full" required>
        </div>
        <div>
            <label class="block">Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" class="border rounded px-3 py-1 w-full" required>
        </div>
        <div>
            <label class="block">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="border rounded px-3 py-1 w-full" required>
                <option value="L" <?= $siswa['jenis_kelamin'] === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= $siswa['jenis_kelamin'] === 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>
        <div>
            <label class="block">Kelas</label>
            <select name="id_kelas" class="border rounded px-3 py-1 w-full" required>
                <?php foreach ($kelasList as $kelas): ?>
                    <option value="<?= $kelas['id_kelas'] ?>" <?= $siswa['id_kelas'] == $kelas['id_kelas'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kelas['nama_kelas']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="pt-3">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">💾 Simpan</button>
            <a href="../../dashboard.php?page=info_siswa" class="ml-2 text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>
