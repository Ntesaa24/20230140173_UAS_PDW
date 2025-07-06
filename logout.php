<?php
session_start(); // Memulai session

// Hapus semua data session
$_SESSION = [];

// Hancurkan session
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit();
