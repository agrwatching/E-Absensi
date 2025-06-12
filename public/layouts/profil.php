<?php
require_once(__DIR__ . '/../../app/db.php');

$id_user = $_SESSION['id_user'] ?? null;
if (!$id_user) {
  echo "Akses ditolak. Silakan login.";
  exit;
}

$stmt = $db->prepare("SELECT * FROM user WHERE id_user = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$namaLengkap = $user['nama_lengkap'] ?? '';
$username    = $user['username'] ?? '';
$fotoProfil  = !empty($user['foto_profil']) ? './uploads/' . $user['foto_profil'] : './img/user.png';
?>

<!-- Notifikasi -->
<?php if (!empty($_SESSION['success'])): ?>
  <div class="bg-green-100 text-green-800 border border-green-400 p-3 rounded mb-4">
    <?= $_SESSION['success'];
    unset($_SESSION['success']); ?>
  </div>
<?php elseif (!empty($_SESSION['error'])): ?>
  <div class="bg-red-100 text-red-800 border border-red-400 p-3 rounded mb-4">
    <?= $_SESSION['error'];
    unset($_SESSION['error']); ?>
  </div>
<?php endif; ?>

<!-- Kontainer Profil -->
<div class="max-w-sm mx-auto bg-white shadow-md rounded-xl p-6">

  <!-- AREA NAME TAG -->
  <div id="profilView">
    <div id="nametagArea" class="bg-gray-200 p-4 rounded-xl shadow-md border w-[340px] mx-auto">
  <!-- Header: Logo dan Nama Sekolah -->
  <div class="flex items-center justify-center mb-4 space-x-3">
    <img src="./img/gambar-isr.png" alt="Logo Sekolah" class="w-10 h-10">
    <h2 class="text-base font-bold text-gray-800 text-center leading-tight">
      SMP IGNIATUS SLAMET RIYADI
    </h2>
  </div>

  <!-- Body: Foto Profil dan Informasi -->
  <div class="flex items-start space-x-4">
    <img src="<?= htmlspecialchars($fotoProfil) ?>" alt="Foto Profil"
      class="w-20 h-20 rounded-full border object-cover">

    <div class="text-sm space-y-1 pt-1">
      <p><span class="font-semibold">Nama</span> : <?= htmlspecialchars($namaLengkap) ?></p>
      <p><span class="font-semibold">username</span> : <?= htmlspecialchars($username) ?></p>
    </div>
  </div>
</div>


    <!-- Tombol Aksi -->
    <div class="flex space-x-2 p-2 mt-4">
      <button onclick="toggleEditForm(true)" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">✏️ Edit</button>
      <button type="button" onclick="downloadNametag()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">⬇️ Unduh Name Tag</button>
    </div>
  </div>

  <!-- FORM EDIT PROFIL -->
  <form id="editForm" class="space-y-4 hidden mt-4" action="aksi/update_profil.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_user" value="<?= $id_user ?>">

    <!-- Foto Profil -->
    <div>
      <label for="foto_profil" class="block font-semibold mb-1">Foto Profil</label>
      <input type="file" name="foto_profil" id="foto_profil" accept="image/*" class="border p-2 w-full">
    </div>

    <!-- Nama Lengkap -->
    <div>
      <label for="nama_lengkap" class="block font-semibold mb-1">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= htmlspecialchars($namaLengkap) ?>" required class="border p-2 w-full">
    </div>

    <!-- Username -->
    <div>
      <label for="username" class="block font-semibold mb-1">Username Baru</label>
      <input type="text" name="username" id="username" value="<?= htmlspecialchars($username) ?>" required class="border p-2 w-full">
    </div>

    <!-- Password Lama -->
    <div>
      <label for="password_lama" class="block font-semibold mb-1">Password Lama</label>
      <input type="password" name="password_lama" id="password_lama" required class="border p-2 w-full">
    </div>

    <!-- Password Baru -->
    <div>
      <label for="password_baru" class="block font-semibold mb-1">Password Baru</label>
      <input type="password" name="password_baru" id="password_baru" class="border p-2 w-full">
    </div>

    <!-- Konfirmasi Password -->
    <div>
      <label for="konfirmasi_password" class="block font-semibold mb-1">Konfirmasi Password Baru</label>
      <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="border p-2 w-full">
    </div>

    <!-- Tombol Aksi Form -->
    <div class="flex space-x-2">
      <button type="button" onclick="toggleEditForm(false)" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
    </div>
  </form>
</div>

<!-- Script html2canvas -->
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<!-- Script Toggle & Download -->
<script>
  function toggleEditForm(show) {
    document.getElementById('profilView').style.display = show ? 'none' : 'block';
    document.getElementById('editForm').style.display = show ? 'block' : 'none';
  }

  function downloadNametag() {
    const element = document.getElementById('nametagArea');
    html2canvas(element).then(canvas => {
      const link = document.createElement('a');
      link.download = 'nametag-<?= htmlspecialchars($username) ?>.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    });
  }
</script>
