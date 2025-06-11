<?php
session_start();
require_once(__DIR__ . '/../../app/db.php');

$id_user         = $_POST['id_user'];
$nama_lengkap    = trim($_POST['nama_lengkap']);
$username        = trim($_POST['username']);
$password_lama   = $_POST['password_lama'];
$password_baru   = $_POST['password_baru'] ?? '';
$konfirmasi_pass = $_POST['konfirmasi_password'] ?? '';

// Ambil data user lama
$stmt = $db->prepare("SELECT * FROM user WHERE id_user = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = 'User tidak ditemukan.';
    header('Location: ../dashboard.php?page=profil');
    exit;
}

// Cek password lama cocok
if (!password_verify($password_lama, $user['password'])) {
    $_SESSION['error'] = 'Password lama salah.';
    header('Location: ../dashboard.php?page=profil');
    exit;
}

// Update foto jika ada file
$foto_profil = $user['foto_profil'];
if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION);
    $namaBaru = uniqid() . '.' . strtolower($ext);
    $tujuan = __DIR__ . '/../uploads/' . $namaBaru;

    if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $tujuan)) {
        // Hapus foto lama jika bukan default
        if (!empty($foto_profil) && $foto_profil !== 'user.png') {
            @unlink(__DIR__ . '/../uploads/' . $foto_profil);
        }
        $foto_profil = $namaBaru;
    }
}

// Siapkan query & parameter
if (!empty($password_baru)) {
    // Jika password baru diisi, cek konfirmasi
    if ($password_baru !== $konfirmasi_pass) {
        $_SESSION['error'] = 'Konfirmasi password tidak cocok.';
        header('Location: ../dashboard.php?page=profil');
        exit;
    }

    $hashBaru = password_hash($password_baru, PASSWORD_DEFAULT);

    $stmt = $db->prepare("UPDATE user SET nama_lengkap = ?, username = ?, password = ?, foto_profil = ? WHERE id_user = ?");
    $stmt->execute([$nama_lengkap, $username, $hashBaru, $foto_profil, $id_user]);
} else {
    // Password tidak diubah
    $stmt = $db->prepare("UPDATE user SET nama_lengkap = ?, username = ?, foto_profil = ? WHERE id_user = ?");
    $stmt->execute([$nama_lengkap, $username, $foto_profil, $id_user]);
}

$_SESSION['success'] = 'Profil berhasil diperbarui.';
header('Location: ../dashboard.php?page=profil');
exit;
