<?php
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek jika pengguna belum login atau bukan asisten
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'asisten') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Asisten - <?= $pageTitle ?? 'Dashboard'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-6 border-b border-gray-700 text-center">
            <h1 class="text-2xl font-bold">Panel Asisten</h1>
            <p class="text-sm text-gray-400 mt-1"><?= htmlspecialchars($_SESSION['nama']) ?></p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <?php 
                $activeClass = 'bg-blue-600 text-white font-semibold';
                $inactiveClass = 'text-gray-300 hover:bg-gray-800 hover:text-white';
            ?>
            <a href="dashboard.php" class="<?= ($activePage == 'dashboard') ? $activeClass : $inactiveClass; ?> flex items-center px-4 py-3 rounded-md transition duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
                </svg>
                Dashboard
            </a>
            <a href="mata_praktikum.php" class="<?= ($activePage == 'matapraktikum') ? $activeClass : $inactiveClass; ?> flex items-center px-4 py-3 rounded-md transition duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M5 6h14a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                </svg>
                Mata Praktikum
            </a>
            <a href="modul.php" class="<?= ($activePage == 'modul') ? $activeClass : $inactiveClass; ?> flex items-center px-4 py-3 rounded-md transition duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20h9m-9-6h9m-9-6h9M3 6h.01M3 12h.01M3 18h.01" />
                </svg>
                Manajemen Modul
            </a>
            <a href="laporan_masuk.php" class="<?= ($activePage == 'laporan') ? $activeClass : $inactiveClass; ?> flex items-center px-4 py-3 rounded-md transition duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m2 4H7m4 4v-16m8 0H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z" />
                </svg>
                Laporan Masuk
            </a>
            <a href="manajemen_akun.php" class="<?= ($activePage == 'manajemen') ? $activeClass : $inactiveClass; ?> flex items-center px-4 py-3 rounded-md transition duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9 9 0 1112 21a8.961 8.961 0 01-6.879-3.196zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Manajemen Akun
            </a>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6 lg:p-10 bg-gray-50">
        <header class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800"><?= $pageTitle ?? 'Dashboard'; ?></h1>
            <a href="../logout.php" class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-8v1" />
                </svg>
                Logout
            </a>
        </header>

        <!-- Konten halaman akan dimasukkan di sini -->
