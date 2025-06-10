<?php
session_start();
require_once(__DIR__ . '/../app/db.php');

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['id_user'] = $user['id_user'];           // <-- pastikan ini diset
    $_SESSION['username'] = $user['username'];    // <-- ini juga
    header("Location: sidebar.php");
    exit;
} else {
    echo "Login gagal. Username atau password salah.";
}
?>
