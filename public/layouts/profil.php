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

<?php if (!empty($_SESSION['success'])): ?>
  <div class="bg-green-100 text-green-800 border border-green-400 p-3 rounded mb-4">
    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
  </div>
<?php elseif (!empty($_SESSION['error'])): ?>
  <div class="bg-red-100 text-red-800 border border-red-400 p-3 rounded mb-4">
    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
  </div>
<?php endif; ?>

<div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6">
  <h2 class="text-2xl font-semibold mb-4">Profil Pengguna</h2>

  <div id="profilView">
    <div class="flex items-center space-x-6 mb-4">
      <img src="<?= htmlspecialchars($fotoProfil) ?>" alt="Foto Profil" class="w-24 h-24 rounded-full border object-cover">
      <div>
        <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($namaLengkap) ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
      </div>
    </div>
    <button onclick="toggleEditForm(true)" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">✏️ Edit</button>
  </div>

  <form id="editForm" class="space-y-4 hidden mt-4" action="aksi/update_profil.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_user" value="<?= $id_user ?>">

    <div>
      <label for="foto_profil" class="block font-semibold mb-1">Foto Profil</label>
      <input type="file" name="foto_profil" id="foto_profil" accept="image/*" class="border p-2 w-full">
    </div>

    <div>
      <label for="nama_lengkap" class="block font-semibold mb-1">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= htmlspecialchars($namaLengkap) ?>" required class="border p-2 w-full">
    </div>

    <div>
      <label for="username" class="block font-semibold mb-1">Username Baru</label>
      <input type="text" name="username" id="username" value="<?= htmlspecialchars($username) ?>" required class="border p-2 w-full">
    </div>

    <div>
      <label for="password_lama" class="block font-semibold mb-1">Password Lama</label>
      <input type="password" name="password_lama" id="password_lama" required class="border p-2 w-full">
    </div>

    <div>
      <label for="password_baru" class="block font-semibold mb-1">Password Baru</label>
      <input type="password" name="password_baru" id="password_baru" class="border p-2 w-full">
    </div>

    <div>
      <label for="konfirmasi_password" class="block font-semibold mb-1">Konfirmasi Password Baru</label>
      <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="border p-2 w-full">
    </div>

    <div class="flex space-x-2">
      <button type="button" onclick="toggleEditForm(false)" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
    </div>
  </form>
</div>

<script>
  function toggleEditForm(show) {
    document.getElementById('profilView').style.display = show ? 'none' : 'block';
    document.getElementById('editForm').style.display = show ? 'block' : 'none';
  }
</script>
