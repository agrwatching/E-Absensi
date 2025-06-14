<?php
require_once(__DIR__ . '/../../app/db.php');

// Ambil semua kelas
$kelasQuery = $db->query("SELECT * FROM kelas ORDER BY nama_kelas ASC");
$kelasList = $kelasQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📚 Daftar Siswa per Kelas</h2>
        <button onclick="openModal()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm">
            🔁 Proses Kenaikan Kelas
        </button>
    </div>
    <!-- Dropdown filter kelas -->
    <div>
        <label for="filterKelas" class="mr-2 text-sm text-gray-700">Filter Kelas:</label>
        <select id="filterKelas" class="border border-gray-300 rounded px-3 py-1 text-sm">
            <option value="all">Semua</option>
            <?php foreach ($kelasList as $kelas): ?>
                <option value="kelas_<?= $kelas['id_kelas'] ?>"><?= htmlspecialchars($kelas['nama_kelas']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<?php foreach ($kelasList as $kelas): ?>
    <?php
    $id_kelas = $kelas['id_kelas'];
    $nama_kelas = $kelas['nama_kelas'];
    $safeTableId = 'tabel_' . preg_replace('/[^a-zA-Z0-9]/', '', $nama_kelas);

    // Ambil siswa per kelas
    $stmt = $db->prepare("SELECT * FROM siswa WHERE id_kelas = ? ORDER BY nama ASC");
    $stmt->execute([$id_kelas]);
    $siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="kelas-section kelas_<?= $id_kelas ?> mb-10 bg-white p-5 rounded-xl shadow-md">
        <form action="dashboard.php?page=SiswaController/hapus_banyak_siswa" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa yang dipilih?')">
            <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Kelas <?= htmlspecialchars($nama_kelas) ?></h3>
                <div class="space-x-2 flex items-center">
                    <a href="dashboard.php?page=SiswaController/tambah_siswa&id_kelas=<?= $id_kelas ?>" 
                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">+ Tambah Siswa</a>
                    <a href="dashboard.php?page=SiswaController/tambah_banyak_siswa&id_kelas=<?= $id_kelas ?>" 
                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">+ Tambah Banyak Siswa</a>
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                        🗑️ Hapus yang Dipilih
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="<?= $safeTableId ?>" class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-3 py-2">No</th>
                            <th class="px-3 py-2">No Induk</th>
                            <th class="px-3 py-2">NISN</th>
                            <th class="px-3 py-2">Nama</th>
                            <th class="px-3 py-2">Jenis Kelamin</th>
                            <th class="px-3 py-2">Aksi</th>
                            <th class="px-3 py-2">Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($siswaList as $i => $siswa): ?>
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="px-3 py-2"><?= $i + 1 ?></td>
                                <td class="px-3 py-2"><?= htmlspecialchars($siswa['no_induk']) ?></td>
                                <td class="px-3 py-2"><?= htmlspecialchars($siswa['nisn']) ?></td>
                                <td class="px-3 py-2"><?= htmlspecialchars($siswa['nama']) ?></td>
                                <td class="px-3 py-2"><?= $siswa['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                <td class="px-3 py-2 flex gap-2">
                                    <a href="dashboard.php?page=SiswaController/edit_siswa&id=<?= $siswa['id_siswa'] ?>">✏️ <span class="hover:underline">Edit</span></a>
                                    <a href="dashboard.php?page=SiswaController/hapus_siswa&id=<?= $siswa['id_siswa'] ?>" onclick="return confirm('Yakin ingin menghapus siswa ini?')">🗑️<span class="hover:underline">Hapus</span></a>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <input type="checkbox" name="id_siswa[]" value="<?= $siswa['id_siswa'] ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
   <!-- Modal Konfirmasi Naik Kelas -->
<div id="modalNaikKelas" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full shadow-lg">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Konfirmasi Kenaikan Kelas</h3>
        <p class="text-sm text-gray-600 mb-3">
            Apakah Anda benar ingin melanjutkan? <br />
            <strong class="text-red-500">Data tidak akan bisa kembali!</strong>
        </p>
        <ul class="list-disc ml-5 mb-4 text-sm text-gray-600">
            <li>Siswa kelas 7 akan dipindahkan ke kelas 8</li>
            <li>Siswa kelas 8 akan dipindahkan ke kelas 9</li>
            <li>Siswa kelas 9 akan <strong>dihapus permanen</strong></li>
        </ul>

        <!-- Checkbox Konfirmasi -->
        <div class="flex items-start gap-2 mb-4">
            <input type="checkbox" id="konfirmasiCheckbox" class="mt-1" />
            <label for="konfirmasiCheckbox" class="text-sm text-gray-700">Saya yakin dan ingin melanjutkan proses ini</label>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-2">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded text-sm hover:bg-gray-300">
                Batal
            </button>
            <form action="dashboard.php?page=SiswaController/naik_kelas" method="post">
                <button type="submit" id="submitBtn" disabled
                    class="px-4 py-2 bg-green-500 text-white rounded text-sm hover:bg-green-600">
                    ✅ Proses Sekarang
                </button>
            </form>
        </div>
    </div>
</div>


<?php endforeach; ?>

<script>
    $(document).ready(function () {
        <?php foreach ($kelasList as $kelas): ?>
            $('#<?= 'tabel_' . preg_replace('/[^a-zA-Z0-9]/', '', $kelas['nama_kelas']) ?>').DataTable({
                responsive: true,
                pageLength: 10
            });
        <?php endforeach; ?>

        // Filter berdasarkan kelas
        $('#filterKelas').on('change', function () {
            const selected = $(this).val();
            if (selected === 'all') {
                $('.kelas-section').show();
            } else {
                $('.kelas-section').hide();
                $('.' + selected).show();
            }
        });
    });

    //modal centang
function openModal() {
        document.getElementById('modalNaikKelas').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalNaikKelas').classList.add('hidden');
    }

    // Aktifkan tombol saat checkbox dicentang
    document.getElementById('konfirmasiCheckbox').addEventListener('change', function () {
        document.getElementById('submitBtn').disabled = !this.checked;
    });
//tutup modal centang
</script>
