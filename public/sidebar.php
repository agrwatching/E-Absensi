<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}

echo "<h1>Selamat datang, " . htmlspecialchars($_SESSION['username']) . "!</h1>";
echo "<p><a href='logout.php'>Logout</a></p>";
?>
