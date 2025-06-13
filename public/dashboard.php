<?php
session_start();
require_once(__DIR__ . '/../app/db.php');

$id_user = $_SESSION['id_user'] ?? null;
$fotoProfil = './img/user.png';

$stmt = $db->query("SELECT COUNT(*) AS total FROM siswa");
$total_siswa = $stmt->fetch()['total'];

if ($id_user) {
  $stmt = $db->prepare("SELECT foto_profil FROM user WHERE id_user = ?");
  $stmt->execute([$id_user]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!empty($user['foto_profil'])) {
    $fotoProfil = './uploads/' . $user['foto_profil'];
  }
}
//untuk manggil nama lengkap di layouts/dashboard.php
if (!isset($_SESSION['nama_lengkap']) && isset($_SESSION['id_user'])) {
    $stmt = $db->prepare("SELECT * FROM user WHERE id_user = ?");
    $stmt->execute([$_SESSION['id_user']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
}
//tutup manggil nama lengkap di layouts/dashboard.php
// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
  header('Location: index.php');
  exit;
}
$currentPage = $_GET['page'] ?? 'home';
function isActive($targetPage, $currentPage)
{
  return $targetPage === $currentPage
    ? 'bg-white text-black border-l-4 border-blue-900 font-semibold'
    : 'hover:bg-white hover:text-black hover:border-l-4 hover:border-blue-900';
}
function isParentOpen($pages, $currentPage)
{
  return in_array($currentPage, $pages) ? '' : 'hidden';
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="./img/title.png">
</head>

<body class="h-screen flex flex-col transition-colors duration-300">
  <!-- Header -->
  <header class="flex items-center h-16 shadow">
    <div class="flex items-center bg-emerald-800 h-full px-6 w-56">
      <img src="./img/title.png" alt="Logo" class="h-10 w-auto mr-3">
      <h1 class="text-xl font-semibold text-white">E-ABSENSI</h1>
    </div>
    <div class="flex-1 bg-emerald-500 h-full w-full flex items-center px-4">
      <div class="cursor-pointer" onclick="toggleSidebar()">
        <img id="toggleSidebar" src="./img/sidebar on.png" alt="Toggle Sidebar"
          class="h-6 w-6 transition-transform duration-300 cursor-pointer">
      </div>
    </div>
    <div class="bg-emerald-500 h-full flex items-center px-6 relative">
      <button onclick="toggleUserDropdown()" id="userButton"
        class="flex items-center space-x-2 bg-blue-800 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <img src="<?= htmlspecialchars($fotoProfil) ?>" alt="Foto Profil" class="w-6 h-6 rounded-full object-cover">
        <span class="font-medium"><?= htmlspecialchars($_SESSION['username']) ?></span>
        <svg id="arrowIcon" class="w-4 h-4 ml-1 transition-transform duration-300 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div id="dropdown"
        class="origin-top-right absolute right-5 mt-36 w-36 bg-white rounded-xl shadow-xl z-20 hidden opacity-0 scale-95 transition-all duration-300 ease-out">
        <div class="py-2">
          <a href="dashboard.php?page=profil" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition duration-200 <?= isActive('profil', $currentPage) ?>">👨‍🏫 Profil</a>
          <form action="./logout.php" method="POST">
            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 hover:text-red-700 transition duration-200">
              🚪 Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <div class="flex overflow-hidden flex-1">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-56 bg-gray-900 text-white flex flex-col transition-all duration-300 ease-in-out">
      <!-- Header Sidebar -->
      <div class="p-4 font-bold text-xl border-b border-blue-700 flex justify-between items-center">
        <span>E-Absensi</span>
      </div>

      <!-- Menu navigasi -->
      <nav class="flex-1 text-sm space-y-1">
        <a href="dashboard.php"
          class="flex items-center space-x-2 px-4 py-3 w-full border-b border-gray-800 <?= isActive('home', $currentPage) ?>">
          <span>🏠</span><span>Dashboard</span>
        </a>
        <!-- Sidebar Menu -->
        <a href="dashboard.php?page=info_siswa" class="block px-6 py-3 w-full border-b border-gray-800 <?= isActive('info_siswa', $currentPage) ?>">🎓 Info Siswa</a>
        <a href="dashboard.php?page=absensi" class="block px-6 py-3 w-full border-b border-gray-800 <?= isActive('absensi', $currentPage) ?>">📝 Absensi</a>
        <a href="dashboard.php?page=rekap_absensi" class="block px-6 py-3 w-full border-b border-gray-800 <?= isActive('rekap_absensi', $currentPage) ?>">📋 Rekap Absensi</a>
        <a href="dashboard.php?page=backup" class="block px-6 py-3 w-full border-b border-gray-800 <?= isActive('backup', $currentPage) ?>">📤 Backup data</a>
        <a href="dashboard.php?page=pengaturan" class="block px-6 py-3 w-full border-b border-gray-800 <?= isActive('pengaturan', $currentPage) ?>">⚙️ pengaturan</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <main id="mainContent" class="flex-1 p-6 overflow-y-auto ml-0 transition-all duration-300 ease-in-out">
        <!-- Halaman Landingpage yg di tampilkan -->
        <?php
        $page = $_GET['page'] ?? 'home';

        $found = false;

        // Jika page mengandung slash (misalnya: "SiswaController/tambah_siswa")
        if (str_contains($page, '/')) {
          $file = $page . ".php";
          //hidupkan echo di bawah jika terjadi eror file tidak ditemukan untuk mengecek
          // echo "<pre>Langsung CEK FILE: $file</pre>";
          if (file_exists($file)) {
            include $file;
            $found = true;
          } else {
            echo "<pre>TIDAK DITEMUKAN</pre>";
          }
        } else {
          // Jika page cuma nama file biasa, cek di dalam folder yang diizinkan
          $allowed_paths = [
            'layouts/',
            'SiswaController/',
            'AbsensiController/',
            'RekapAbsensiController/'
          ];

          foreach ($allowed_paths as $path) {
            $file = $path . ($page === 'home' ? 'dashboard' : $page) . ".php";
            //hidupkan echo di bawah jika terjadi eror file tidak ditemukan untuk mengecek
            // echo "<pre>CEK FILE: $file</pre>";
            if (file_exists($file)) {
              include $file;
              $found = true;
              break;
            } else {
              echo "<pre>TIDAK DITEMUKAN</pre>";
            }
          }
        }

        if (!$found) {
          echo "<h2 class='text-xl font-bold'>404 - Halaman tidak ditemukan</h2>";
        }

        ?>
      </main>
    </div>
  </div>
  <?php include './copyright/footer.php'; ?>
  <!-- JS -->
  <script>
    // Cek mode malam dari localStorage
    window.addEventListener('DOMContentLoaded', () => {
      if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.remove('bg-gray-300');
        document.body.classList.add('bg-gray-900', 'text-black');
      } else {
        document.body.classList.remove('bg-gray-900', 'text-black');
        document.body.classList.add('bg-gray-300');
      }
    });
    //mode malam

    // Simpan otomatis setiap kali pengguna mengetik
    const excludedPages = ["tambah_siswa", "edit_siswa", "tambah_kelas"];
    const currentPage = "<?= $_GET['page'] ?? '' ?>";
    const pageName = currentPage.split('/').pop(); // ambil bagian terakhir setelah slash

    if (!excludedPages.includes(pageName)) {
      document.querySelectorAll('input, textarea, select').forEach(el => {
        el.addEventListener('input', () => {
          localStorage.setItem(el.name, el.value);
        });
      });

      window.addEventListener('load', () => {
        document.querySelectorAll('input, textarea, select').forEach(el => {
          if (localStorage.getItem(el.name)) {
            el.value = localStorage.getItem(el.name);
          }
        });
      });
    } else {
      // Bersihkan isi localStorage yang tersimpan (jika perlu)
      window.addEventListener('load', () => {
        document.querySelectorAll('input, textarea, select').forEach(el => {
          localStorage.removeItem(el.name);
        });
      });
    }
    //tutup simpan otomatis//

    function toggleUserDropdown() {
      const dropdown = document.getElementById("dropdown");
      const arrow = document.getElementById("arrowIcon");
      if (dropdown.classList.contains("hidden")) {
        dropdown.classList.remove("hidden");
        setTimeout(() => {
          dropdown.classList.remove("opacity-0", "scale-95");
          dropdown.classList.add("opacity-100", "scale-100");
        }, 10);
        if (arrow) arrow.classList.add("rotate-180");
      } else {
        dropdown.classList.remove("opacity-100", "scale-100");
        dropdown.classList.add("opacity-0", "scale-95");
        if (arrow) arrow.classList.remove("rotate-180");
        setTimeout(() => {
          dropdown.classList.add("hidden");
        }, 200);
      }
    }

    document.addEventListener("click", function(event) {
      const dropdown = document.getElementById("dropdown");
      const button = document.getElementById("userButton");
      const arrow = document.getElementById("arrowIcon");
      if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        if (!dropdown.classList.contains("hidden")) {
          dropdown.classList.remove("opacity-100", "scale-100");
          dropdown.classList.add("opacity-0", "scale-95");
          if (arrow) arrow.classList.remove("rotate-180");
          setTimeout(() => {
            dropdown.classList.add("hidden");
          }, 200);
        }
      }
    });

    document.getElementById("toggleSidebar").addEventListener("click", function() {
      const sidebar = document.getElementById("sidebar");
      const icon = document.getElementById("toggleSidebar");
      const mainContent = document.getElementById("mainContent");

      const isHidden = sidebar.classList.contains("w-0");

      // Toggle width
      sidebar.classList.toggle("w-0");
      sidebar.classList.toggle("w-56");

      // Toggle isi sidebar
      const sidebarChildren = Array.from(sidebar.children);
      sidebarChildren.forEach(child => {
        if (isHidden) {
          child.classList.remove("hidden");
        } else {
          child.classList.add("hidden");
        }
      });

      // Toggle margin konten utama
      if (isHidden) {
        mainContent.classList.remove("ml-0");
        mainContent.classList.add("ml-0");
      } else {
        mainContent.classList.remove("ml-56");
        mainContent.classList.add("ml-0");
      }

      icon.classList.toggle("rotate-180");
    });
  </script>
</body>

</html>