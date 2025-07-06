<?php
session_start();
require_once '../config.php';
require_once 'templates/header_mahasiswa.php';

// Initialize session arrays if not exists
if (!isset($_SESSION['registered_courses'])) {
    $_SESSION['registered_courses'] = ['PABD'];
}

if (!isset($_SESSION['available_courses'])) {
    $_SESSION['available_courses'] = ['PDW', 'ROUTING', 'STQA'];
}

// Handle form submissions
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $course = $_POST['course'] ?? '';
    
    if ($action === 'daftar' && $course) {
        if (in_array($course, $_SESSION['available_courses'])) {
            // Move course from available to registered
            $_SESSION['registered_courses'][] = $course;
            $_SESSION['available_courses'] = array_values(array_diff($_SESSION['available_courses'], [$course]));
            $message = "Berhasil mendaftar praktikum $course!";
            $message_type = 'success';
        } else {
            $message = "Praktikum $course tidak tersedia!";
            $message_type = 'error';
        }
    } elseif ($action === 'batal' && $course) {
        if (in_array($course, $_SESSION['registered_courses'])) {
            // Move course from registered to available
            $_SESSION['available_courses'][] = $course;
            $_SESSION['registered_courses'] = array_values(array_diff($_SESSION['registered_courses'], [$course]));
            $message = "Berhasil membatalkan pendaftaran praktikum $course!";
            $message_type = 'success';
        } else {
            $message = "Praktikum $course tidak ditemukan dalam daftar terdaftar!";
            $message_type = 'error';
        }
    }
}

// Course data
$courses_data = [
    'PDW' => [
        'name' => 'PRAKTIKUM PDW',
        'description' => 'Praktikum Pemrograman Dasar Web yang mencakup HTML, CSS, JavaScript, dan framework modern untuk pengembangan web.',
        'instructor' => 'Dr. Ahmad Fauzi, M.Kom',
        'semester' => 'Semester 5'
    ],
    'ROUTING' => [
        'name' => 'PRAKTIKUM ROUTING',
        'description' => 'Praktikum Routing dan Switching yang mempelajari konfigurasi jaringan, protokol routing, dan administrasi network.',
        'instructor' => 'Ir. Budi Santoso, M.T',
        'semester' => 'Semester 6'
    ],
    'STQA' => [
        'name' => 'PRAKTIKUM STQA',
        'description' => 'Praktikum Software Testing & Quality Assurance yang mempelajari metodologi testing, automation testing, dan quality control.',
        'instructor' => 'Dr. Siti Nurhaliza, M.Kom',
        'semester' => 'Semester 7'
    ],
    'PABD' => [
        'name' => 'PRAKTIKUM PABD',
        'description' => 'Praktikum Pengembangan Aplikasi Berbasis Database yang mempelajari desain database, SQL, dan integrasi aplikasi dengan database.',
        'instructor' => 'Prof. Dr. Indra Wijaya, M.Kom',
        'semester' => 'Semester 4'
    ]
];

$active_tab = $_GET['tab'] ?? 'tersedia';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Praktikum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen mb-4">
    <div class="max-w-6xl mx-auto p-4">
        
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border-t-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">
                        <i class="fas fa-search text-blue-600 mr-3"></i>Cari Praktikum
                    </h1>
                    <p class="text-gray-600 text-lg">Temukan dan daftarkan diri Anda pada praktikum yang tersedia</p>
                </div>
                <div class="hidden md:block">
                    <a href="praktikum_saya.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-clipboard-list mr-2"></i>Praktikum Saya
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if ($message): ?>
            <div class="<?php echo $message_type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700'; ?> border px-4 py-3 rounded-xl mb-6 shadow-md">
                <div class="flex items-center">
                    <i class="fas <?php echo $message_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-2"></i>
                    <span><?php echo htmlspecialchars($message); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Navigation Tabs -->
        <div class="mb-8">
            <div class="flex space-x-4 overflow-x-auto">
                <a href="?tab=tersedia" class="<?php echo $active_tab === 'tersedia' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700'; ?> px-6 py-3 rounded-xl font-semibold whitespace-nowrap">
                    <i class="fas fa-plus-circle mr-2"></i>Praktikum Tersedia
                </a>
                <a href="?tab=terdaftar" class="<?php echo $active_tab === 'terdaftar' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700'; ?> px-6 py-3 rounded-xl font-semibold whitespace-nowrap">
                    <i class="fas fa-check-circle mr-2"></i>Sudah Terdaftar
                </a>
                <a href="praktikum_saya.php" class="md:hidden bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold whitespace-nowrap">
                    <i class="fas fa-clipboard-list mr-2"></i>Praktikum Saya
                </a>
            </div>
        </div>

        <!-- Praktikum Tersedia -->
        <?php if ($active_tab === 'tersedia'): ?>
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="flex items-center mb-6">
                <i class="fas fa-graduation-cap text-blue-600 text-2xl mr-3"></i>
                <h2 class="text-2xl font-bold text-gray-800">Praktikum Tersedia</h2>
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium ml-4">
                    <?php echo count($_SESSION['available_courses']); ?> praktikum
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($_SESSION['available_courses'] as $course_code): ?>
                    <?php if (isset($courses_data[$course_code])): ?>
                        <?php $course = $courses_data[$course_code]; ?>
                        <div class="bg-gradient-to-br from-white to-blue-50 p-6 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 border border-blue-100 hover:border-blue-200">
                            <div class="flex items-start justify-between mb-4">
                                <div class="bg-blue-100 p-3 rounded-xl">
                                    <i class="fas fa-flask text-blue-600 text-xl"></i>
                                </div>
                                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                                    <?php echo htmlspecialchars($course['semester']); ?>
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-800 mb-2 leading-tight">
                                <?php echo htmlspecialchars($course['name']); ?>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                <?php echo htmlspecialchars($course['description']); ?>
                            </p>
                            
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-user-tie mr-2"></i>
                                <span><?php echo htmlspecialchars($course['instructor']); ?></span>
                            </div>
                            
                            <form method="POST" class="block w-full">
                                <input type="hidden" name="action" value="daftar">
                                <input type="hidden" name="course" value="<?php echo htmlspecialchars($course_code); ?>">
                                <button type="submit" onclick="return confirm('Yakin ingin mendaftar ke praktikum <?php echo htmlspecialchars($course_code); ?>?')" 
                                       class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl text-center font-semibold transition duration-300 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-plus mr-2"></i>Daftar Praktikum
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Praktikum Terdaftar -->
        <?php if ($active_tab === 'terdaftar'): ?>
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="flex items-center mb-6">
                <i class="fas fa-check-circle text-green-600 text-2xl mr-3"></i>
                <h2 class="text-2xl font-bold text-gray-800">Praktikum Sudah Terdaftar</h2>
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium ml-4">
                    <?php echo count($_SESSION['registered_courses']); ?> praktikum
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($_SESSION['registered_courses'] as $course_code): ?>
                    <?php if (isset($courses_data[$course_code])): ?>
                        <?php $course = $courses_data[$course_code]; ?>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow-lg border border-green-200">
                            <div class="flex items-start justify-between mb-4">
                                <div class="bg-green-100 p-3 rounded-xl">
                                    <i class="fas fa-check text-green-600 text-xl"></i>
                                </div>
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                                    Terdaftar
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-800 mb-2 leading-tight">
                                <?php echo htmlspecialchars($course['name']); ?>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                <?php echo htmlspecialchars($course['description']); ?>
                            </p>
                            
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span><?php echo htmlspecialchars($course['semester']); ?></span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-user-tie mr-1"></i>
                                <span><?php echo htmlspecialchars($course['instructor']); ?></span>
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="detail_praktikum.php?course=<?php echo urlencode($course_code); ?>" 
                                   class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-center font-semibold transition duration-300 text-sm">
                                    <i class="fas fa-eye mr-1"></i>Detail
                                </a>
                                <form method="POST" class="flex-1">
                                    <input type="hidden" name="action" value="batal">
                                    <input type="hidden" name="course" value="<?php echo htmlspecialchars($course_code); ?>">
                                    <button type="submit" onclick="return confirm('Yakin ingin membatalkan pendaftaran praktikum <?php echo htmlspecialchars($course_code); ?>?')" 
                                           class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-center font-semibold transition duration-300 text-sm">
                                        <i class="fas fa-times mr-1"></i>Batal
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.style.display = 'none', 500);
            });
        }, 5000);
    </script>
</body>
</html>