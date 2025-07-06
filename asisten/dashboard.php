<?php
// 1. Definisi Variabel untuk Template
$pageTitle = 'Dashboard';
$activePage = 'dashboard';

// 2. Simulasi Data dari Database (ganti dengan query database yang sebenarnya)
// Contoh query: SELECT COUNT(*) FROM modules WHERE instructor_id = ?
$totalModules = 2;



// Contoh query: SELECT COUNT(*) FROM reports WHERE status = 'pending'
$pendingReports = 3;

// Contoh query: SELECT COUNT(*) FROM reports WHERE status = 'reviewed'
$reviewedReports = 2;

// Data aktivitas terbaru dari database
// Contoh query: SELECT r.*, s.name as student_name, m.name as module_name FROM reports r JOIN students s ON r.student_id = s.id JOIN modules m ON r.module_id = m.id ORDER BY r.created_at DESC LIMIT 5
$recentActivities = [
    [
        'student_name' => 'Budi Santoso',
        'module_name' => 'Pemrograman Web',
        'action' => 'mengumpulkan laporan',
        'time' => '10 menit lalu',
        'status' => 'pending'
    ],
    [
        'student_name' => 'Citra Lestari',
        'module_name' => 'Routing & Switching',
        'action' => 'mengumpulkan laporan',
        'time' => '45 menit lalu',
        'status' => 'reviewed'
    ],
    [
        'student_name' => 'Dina Marlina',
        'module_name' => 'Database Management',
        'action' => 'mengumpulkan laporan',
        'time' => '2 jam lalu',
        'status' => 'pending'
    ],
    [
        'student_name' => 'Eko Prasetyo',
        'module_name' => 'Network Security',
        'action' => 'mengumpulkan laporan',
        'time' => '3 jam lalu',
        'status' => 'reviewed'
    ],
    [
        'student_name' => 'Farah Nabila',
        'module_name' => 'Pemrograman Web',
        'action' => 'mengumpulkan laporan',
        'time' => '5 jam lalu',
        'status' => 'pending'
    ]
];

// 3. Panggil Header
require_once 'templates/header.php'; 
?>

<!-- Welcome Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-6 mb-8 text-white">
    <h1 class="text-3xl font-bold mb-2">Selamat Datang, Pak/Bu Dosen!</h1>
    <p class="text-blue-100">Kelola dan pantau aktivitas pembelajaran Anda dengan mudah</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Total Modules Card -->
    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Modul</p>
                <p class="text-3xl font-bold text-gray-800"><?php echo $totalModules; ?></p>
                <p class="text-xs text-green-600 mt-1">
                    <i class="fas fa-arrow-up"></i> Aktif
                </p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending Reports Card -->
    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Belum Dinilai</p>
                <p class="text-3xl font-bold text-gray-800"><?php echo $pendingReports; ?></p>
                <p class="text-xs text-yellow-600 mt-1">
                    <i class="fas fa-clock"></i> Perlu review
                </p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Reviewed Reports Card -->
    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Sudah Dinilai</p>
                <p class="text-3xl font-bold text-gray-800"><?php echo $reviewedReports; ?></p>
                <p class="text-xs text-green-600 mt-1">
                    <i class="fas fa-check-circle"></i> Selesai
                </p>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities Section -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h3>
            <span class="text-sm text-gray-500">
                <i class="fas fa-sync-alt"></i> Diperbarui otomatis
            </span>
        </div>
    </div>
    
    <div class="divide-y divide-gray-200">
        <?php if (empty($recentActivities)): ?>
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                <p class="text-lg">Belum ada aktivitas terbaru</p>
                <p class="text-sm">Aktivitas mahasiswa akan muncul di sini</p>
            </div>
        <?php else: ?>
            <?php foreach ($recentActivities as $activity): ?>
                <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-center space-x-4">
                        <!-- Avatar -->
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center shadow-md">
                            <span class="font-bold text-white text-sm">
                                <?php echo strtoupper(substr($activity['student_name'], 0, 1) . substr(strstr($activity['student_name'], ' '), 1, 1)); ?>
                            </span>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <p class="text-gray-800">
                                    <strong class="text-blue-600"><?php echo htmlspecialchars($activity['student_name']); ?></strong>
                                    <?php echo htmlspecialchars($activity['action']); ?> untuk
                                    <strong class="text-purple-600"><?php echo htmlspecialchars($activity['module_name']); ?></strong>
                                </p>
                                
                                <!-- Status Badge -->
                                <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo $activity['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'; ?>">
                                    <?php echo $activity['status'] === 'pending' ? 'Menunggu' : 'Dinilai'; ?>
                                </span>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                <?php echo htmlspecialchars($activity['time']); ?>
                            </div>
                        </div>
                        
                        <!-- Action Button -->
                        <div>
                            <?php if ($activity['status'] === 'pending'): ?>
                                <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition-colors duration-200">
                                    <i class="fas fa-eye mr-1"></i> Review
                                </button>
                            <?php else: ?>
                                <button class="px-4 py-2 bg-gray-100 text-gray-600 text-sm rounded-md hover:bg-gray-200 transition-colors duration-200">
                                    <i class="fas fa-check mr-1"></i> Dinilai
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- View All Link -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <a href="reports.php" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            <i class="fas fa-arrow-right mr-1"></i> Lihat Semua Laporan
        </a>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h4>
        <div class="space-y-3">
            <a href="modules.php" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                <div class="bg-blue-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Tambah Modul Baru</p>
                    <p class="text-sm text-gray-500">Buat modul pembelajaran baru</p>
                </div>
            </a>
            
            <a href="reports.php?status=pending" class="flex items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors duration-200">
                <div class="bg-yellow-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Review Laporan</p>
                    <p class="text-sm text-gray-500">Nilai laporan yang tertunda</p>
                </div>
            </a>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Minggu Ini</h4>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Laporan Masuk</span>
                <span class="font-bold text-blue-600">+3</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Laporan Dinilai</span>
                <span class="font-bold text-green-600">+2</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Mahasiswa Aktif</span>
                <span class="font-bold text-purple-600">15</span>
            </div>
        </div>
    </div>
</div>

<?php
// 4. Panggil Footer
require_once 'templates/footer.php';
?>