<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Beranda</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="./img/title.png" />
</head>
<body class="h-screen flex flex-col bg-gray-100">
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
        <span class="text-lg">👤</span>
        <span class="font-medium"><?= htmlspecialchars($_SESSION['username']) ?></span>
        <svg id="arrowIcon" class="w-4 h-4 ml-1 transition-transform duration-300 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div id="dropdown"
        class="origin-top-right absolute right-5 mt-36 w-36 bg-white rounded-xl shadow-xl z-20 hidden opacity-0 scale-95 transition-all duration-300 ease-out">
        <div class="py-2">
          <a href="./layouts/profil.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition duration-200">👤 Profil</a>
          <form action="logout.php" method="POST">
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
      <div class="p-4 font-bold text-xl border-b border-blue-700 flex justify-between items-center">
        <span>E-Absensi</span>
      </div>
      <nav class="flex-1 text-sm space-y-1">
        <a href="beranda.php" class="flex items-center space-x-2 px-4 py-3 w-full border-b border-gray-800 bg-white text-black border-l-4 border-blue-900 font-semibold">
          <span>🏠</span><span>Beranda</span>
        </a>
        <a href="absensi.php" class="flex items-center space-x-2 px-4 py-3 w-full border-b border-gray-800 hover:bg-white hover:text-black hover:border-l-4 hover:border-blue-900">
          <span>📝</span><span>Absensi</span>
        </a>
        <a href="rekap.php" class="flex items-center space-x-2 px-4 py-3 w-full border-b border-gray-800 hover:bg-white hover:text-black hover:border-l-4 hover:border-blue-900">
          <span>📋</span><span>Rekap Absensi</span>
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <main class="flex-1 p-6 overflow-y-auto ml-0 transition-all duration-300 ease-in-out">
        <h2 class="text-2xl font-bold mb-4">Selamat Datang</h2>
        <p class="text-lg">Halo, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>! Selamat datang di sistem e-Absensi.</p>
      </main>
    </div>
  </div>

  <!-- JS -->
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById("sidebar");
      const icon = document.getElementById("toggleSidebar");
      const mainContent = document.querySelector("main");

      const isHidden = sidebar.classList.contains("w-0");
      sidebar.classList.toggle("w-0");
      sidebar.classList.toggle("w-56");

      const sidebarChildren = Array.from(sidebar.children);
      sidebarChildren.forEach(child => {
        if (isHidden) {
          child.classList.remove("hidden");
        } else {
          child.classList.add("hidden");
        }
      });

      icon.classList.toggle("rotate-180");
    }

    function toggleUserDropdown() {
      const dropdown = document.getElementById("dropdown");
      const arrow = document.getElementById("arrowIcon");
      if (dropdown.classList.contains("hidden")) {
        dropdown.classList.remove("hidden");
        setTimeout(() => {
          dropdown.classList.remove("opacity-0", "scale-95");
          dropdown.classList.add("opacity-100", "scale-100");
        }, 10);
        arrow.classList.add("rotate-180");
      } else {
        dropdown.classList.remove("opacity-100", "scale-100");
        dropdown.classList.add("opacity-0", "scale-95");
        arrow.classList.remove("rotate-180");
        setTimeout(() => {
          dropdown.classList.add("hidden");
        }, 200);
      }
    }

    document.addEventListener("click", function (event) {
      const dropdown = document.getElementById("dropdown");
      const button = document.getElementById("userButton");
      const arrow = document.getElementById("arrowIcon");
      if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        if (!dropdown.classList.contains("hidden")) {
          dropdown.classList.remove("opacity-100", "scale-100");
          dropdown.classList.add("opacity-0", "scale-95");
          arrow.classList.remove("rotate-180");
          setTimeout(() => {
            dropdown.classList.add("hidden");
          }, 200);
        }
      }
    });
  </script>
</body>
</html>

