<?php
require_once(__DIR__ . '/../../app/db.php');

$id_kelas = $_GET['id_kelas'] ?? null;

// Ambil nama kelas (jika ada ID-nya)
$kelasNama = '';
if ($id_kelas) {
    $stmt = $db->prepare("SELECT nama_kelas FROM kelas WHERE id_kelas = ?");
    $stmt->execute([$id_kelas]);
    $kelas = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($kelas) {
        $kelasNama = $kelas['nama_kelas'];
    } else {
        echo "<p class='text-red-500'>Kelas tidak ditemukan.</p>";
        exit;
    }
} else {
    echo "<p class='text-red-500'>ID Kelas tidak valid.</p>";
    exit;
}

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_induk = $_POST['no_induk'];
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $stmt = $db->prepare("INSERT INTO siswa (no_induk, nisn, nama, jenis_kelamin, id_kelas) VALUES (?, ?, ?, ?, ?)");
    $success = $stmt->execute([$no_induk, $nisn, $nama, $jenis_kelamin, $id_kelas]);

    if ($success) {
        echo "<script>alert('Siswa berhasil ditambahkan!'); window.location.href = 'dashboard.php?page=info_siswa';</script>";
        exit;
    } else {
        echo "<p class='text-red-500'>Gagal menambahkan siswa.</p>";
    }
}
?>

<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">
  <h2 class="text-2xl font-semibold mb-4">+ Tambah Siswa - Kelas <?= htmlspecialchars($kelasNama) ?></h2>
  <form method="POST" class="space-y-4" onsubmit="return validateForm()">
    
    <!-- No Induk -->
    <div>
      <label for="no_induk" class="block text-sm font-medium">No Induk</label>
      <input 
        type="text" 
        name="no_induk" 
        maxlength="8" 
        pattern="\d{1,8}" 
        title="Maksimal 8 angka" 
        required 
        class="mt-1 w-full px-3 py-2 border rounded"
        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
      />
    </div>

    <!-- NISN -->
    <div>
      <label for="nisn" class="block text-sm font-medium">NISN</label>
      <input 
        type="text" 
        name="nisn" 
        maxlength="10" 
        pattern="\d{1,10}" 
        title="Maksimal 10 angka" 
        required 
        class="mt-1 w-full px-3 py-2 border rounded"
        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
      />
    </div>

    <!-- Nama -->
    <div>
      <label for="nama" class="block text-sm font-medium">Nama Lengkap</label>
      <input 
        type="text" 
        name="nama" 
        required 
        class="mt-1 w-full px-3 py-2 border rounded" 
      />
    </div>

    <!-- Jenis Kelamin -->
    <div>
      <label for="jenis_kelamin" class="block text-sm font-medium">Jenis Kelamin</label>
      <select 
        name="jenis_kelamin" 
        required 
        class="mt-1 w-full px-3 py-2 border rounded"
      >
        <option value="" disabled selected>-- Pilih --</option>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
      </select>
    </div>

    <!-- Tombol -->
    <div class="flex justify-between items-center pt-4">
      <a href="dashboard.php?page=info_siswa" class="text-blue-600 hover:underline">← Kembali</a>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </div>

  </form>
</div>

<script>
// Validasi tambahan (jika dibutuhkan di JS, tapi HTML sudah cukup)
function validateForm() {
  const noInduk = document.querySelector('input[name="no_induk"]').value;
  const nisn = document.querySelector('input[name="nisn"]').value;

  if (noInduk.length > 8 || isNaN(noInduk)) {
    alert("No Induk hanya boleh berisi angka maksimal 8 digit");
    return false;
  }

  if (nisn.length > 10 || isNaN(nisn)) {
    alert("NISN hanya boleh berisi angka maksimal 10 digit");
    return false;
  }

  return true;
}
</script>

