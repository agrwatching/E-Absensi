<!-- pengaturan.php -->
<div class="p-6 bg-white rounded-xl shadow-md">
  <h2 class="text-xl font-bold mb-4">Pengaturan</h2>
  <div class="flex items-center space-x-4">
    <label class="flex items-center space-x-2">
      <input type="checkbox" id="darkModeToggle" class="toggle-checkbox">
      <span>Aktifkan Mode Malam</span>
    </label>
  </div>
</div>

<script>
  const toggle = document.getElementById('darkModeToggle');

  // Load status dari localStorage
  toggle.checked = localStorage.getItem('darkMode') === 'enabled';

  // Ubah class body sesuai status
  if (toggle.checked) {
    document.body.classList.remove('bg-gray-300');
    document.body.classList.add('bg-black', 'text-black');
  }

  toggle.addEventListener('change', function () {
    if (this.checked) {
      document.body.classList.remove('bg-gray-300');
      document.body.classList.add('bg-black', 'text-black');
      localStorage.setItem('darkMode', 'enabled');
    } else {
      document.body.classList.remove('bg-black', 'text-black');
      document.body.classList.add('bg-gray-300');
      localStorage.setItem('darkMode', 'disabled');
    }
  });
</script>
