<?php
session_start();
require_once(__DIR__ . '/../app/db.php');

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
    $_SESSION['username'] = $user['username'];
    header("Location: dashboard.php");
    exit;
} else {
    $_SESSION['error'] = "Username atau password yang Anda masukkan salah.";
    header("Location: index.php");
    exit;
}
