<?php
require_once(__DIR__ . '/../../app/db.php');

// Ambil semua kelas
$kelasQuery = $db->query("SELECT * FROM kelas ORDER BY nama_kelas ASC");
$kelasList = $kelasQuery->fetchAll(PDO::FETCH_ASSOC);

// Ambil jumlah dan kelas yang dipilih
$jumlah = isset($_GET['jumlah']) ? (int) $_GET['jumlah'] : 1;
$jumlah = in_array($jumlah, [1, 3, 5, 10, 15]) ? $jumlah : 1;

$id_kelas = isset($_GET['id_kelas']) ? $_GET['id_kelas'] : '';
?>

<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">➕ Tambah Banyak Siswa</h2>

    <!-- Form GET untuk memilih jumlah siswa dan kelas -->
    <form method="GET" action="dashboard.php" class="mb-4 flex flex-wrap items-center gap-4">
        <input type="hidden" name="page" value="SiswaController/tambah_banyak_siswa">

        <label class="text-sm font-medium">Jumlah Siswa:</label>
        <select name="jumlah" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
            <?php foreach ([1, 3, 5, 10, 15] as $val): ?>
                <option value="<?= $val ?>" <?= $val == $jumlah ? 'selected' : '' ?>><?= $val ?></option>
            <?php endforeach; ?>
        </select>

        <label class="text-sm font-medium">Kelas:</label>
        <select name="id_kelas" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
            <option value="" disabled selected>-- Pilih Kelas --</option>
            <?php foreach ($kelasList as $kelas): ?>
                <option value="<?= $kelas['id_kelas'] ?>" <?= $id_kelas == $kelas['id_kelas'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kelas['nama_kelas']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Jika kelas belum dipilih, tampilkan peringatan -->
    <?php if ($id_kelas == ''): ?>
        <div class="text-red-600 text-sm mb-4">⚠️ Silakan pilih kelas terlebih dahulu.</div>
    <?php else: ?>
        <!-- Form POST untuk menyimpan siswa -->
        <form action="SiswaController/proses_tambah_banyak.php" method="POST" class="space-y-4">
            <input type="hidden" name="jumlah" value="<?= $jumlah ?>">
            <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">

            <?php for ($i = 0; $i < $jumlah; $i++): ?>
                <div class="grid grid-cols-5 gap-4 bg-gray-50 p-4 rounded shadow">
                    <div>
                        <label class="text-sm">No Induk</label>
                        <input type="text" name="siswa[<?= $i ?>][no_induk]" required maxlength="8" pattern="\d*"
                            class="w-full border rounded px-2 py-1 text-sm" title="Maksimal 8 digit angka" inputmode="numeric">
                    </div>
                    <div>
                        <label class="text-sm">NISN</label>
                        <input type="text" name="siswa[<?= $i ?>][nisn]" required maxlength="10" pattern="\d*"
                            class="w-full border rounded px-2 py-1 text-sm" title="Maksimal 10 digit angka" inputmode="numeric">
                    </div>
                    <div>
                        <label class="text-sm">Nama</label>
                        <input type="text" name="siswa[<?= $i ?>][nama]" required class="w-full border rounded px-2 py-1 text-sm">
                    </div>
                    <div>
                        <label class="text-sm">Jenis Kelamin</label>
                        <select name="siswa[<?= $i ?>][jenis_kelamin]" required class="w-full border rounded px-2 py-1 text-sm">
                            <option value="" disabled selected>-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm">Kelas</label>
                        <input type="text" value="<?= htmlspecialchars($kelasList[array_search($id_kelas, array_column($kelasList, 'id_kelas'))]['nama_kelas']) ?>" readonly disabled class="w-full border rounded px-2 py-1 text-sm bg-gray-100">
                        <input type="hidden" name="siswa[<?= $i ?>][id_kelas]" value="<?= $id_kelas ?>">
                    </div>
                </div>
            <?php endfor; ?>

            <div class="pt-4">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm">
                    💾 Simpan
                </button>
                <a href="dashboard.php?page=info_siswa" class="ml-3 text-gray-600 hover:underline text-sm">Batal</a>
            </div>
        </form>
    <?php endif; ?>
</div>