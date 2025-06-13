<div class="bg-white shadow-md rounded-2xl p-6 mb-8">
    <h2 class="text-2xl font-bold mb-2">Selamat Datang, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>!</h2>
    <p class="text-gray-700">Ini adalah halaman utama dashboard admin. Gunakan navigasi di sebelah kiri untuk mengelola data user, siswa, serta absensi.</p>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card Jumlah Siswa -->
     <a href="dashboard.php?page=kelola_siswa">
    <div class="bg-white shadow-md rounded-2xl p-6 flex items-center space-x-4">
        <div class="text-3xl">🎓</div>
        <div>
            <p class="text-gray-600 text-sm">Total Siswa</p>
            <p class="text-xl font-bold"><?= $total_siswa ?></p>
        </div>
    </div>
     </a>
     <a href="dashboard.php?page=absensi">
    <div class="bg-white shadow-md rounded-2xl p-6 flex items-center space-x-4">
        <div class="text-3xl">📝</div>
        <div>
            <p class="text-gray-600 text-sm">Absensi Hari ini</p>
            <p class="text-xl font-bold"><?= $total_siswa ?></p>
        </div>
    </div>
     </a>
     <a href="dashboard.php?page=absensi">
    <div class="bg-white shadow-md rounded-2xl p-6 flex items-center space-x-4">
        <div class="text-3xl">📃</div>
        <div>
            <p class="text-gray-600 text-sm">Total Absensi</p>
            <p class="text-xl font-bold"><?= $total_siswa ?></p>
        </div>
    </div>
     </a>
     <a href="dashboard.php?page=rekap_absensi">
    <div class="bg-white shadow-md rounded-2xl p-6 flex items-center space-x-4">
        <div class="text-3xl">🧾</div>
        <div>
            <p class="text-gray-600 text-sm">Total Rekap</p>
            <p class="text-xl font-bold"><?= $total_siswa ?></p>
        </div>
    </div>
     </a>
</div>