<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login E-ABSENSI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="assets/img/title.png">
    <style>
        .eye-icon {
            width: 24px;
            height: 24px;
            position: absolute;
            top: 2.4rem;
            right: 1rem;
            cursor: pointer;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">

    <header class="flex flex-col items-center py-8 bg-white shadow-md">
        <img src="./img/gambar-isr.png" alt="Logo Sekolah" class="w-20 mb-4">
        <h1 class="text-3xl font-bold">Selamat Datang di E-Absensi</h1>
        <h1 class="text-2xl font-bold">SMP Ignatius Slamet Riyadi</h1>
        <p class="text-gray-600 mt-2">Platform absensi siswa berbasis web</p>
    </header>

    <main class="flex-grow flex flex-col items-center justify-center p-4">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
            <form action="proses_login.php" method="POST" class="space-y-4">
                <div>
                    <label class="block mb-1 font-semibold" for="username">Username</label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="relative">
                    <label class="block mb-1 font-semibold" for="password">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <img src="./img/hidden.png" alt="Show Password" class="eye-icon" onclick="toggleLoginPassword(this)">
                </div>
                <button type="submit" name="login"
                    class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Masuk
                </button>
            </form>
        </div>
    </main>

    <script>
    function toggleLoginPassword(img) {
        const input = document.getElementById("password");
        const open = "./img/hidden.png";
        const close = "./img/visible.png";

        if (input.type === "password") {
            input.type = "text";
            img.src = close;
        } else {
            input.type = "password";
            img.src = open;
        }
    }
    </script>
</body>
</html>
