<?php
session_start();

// Get course code from URL parameter
$course_code = $_GET['course'] ?? '';

// Initialize session if not exists
if (!isset($_SESSION['registered_courses'])) {
    $_SESSION['registered_courses'] = ['PABD'];
}

// Check if course exists and user is registered
if (!$course_code || !in_array($course_code, $_SESSION['registered_courses'])) {
    header('Location: cari_praktikum.php');
    exit;
}

// Course data
$courses_data = [
    'PDW' => [
        'name' => 'PRAKTIKUM PDW',
        'full_name' => 'Praktikum Pemrograman Dasar Web',
        'description' => 'Praktikum Pemrograman Dasar Web yang mencakup HTML, CSS, JavaScript, dan framework modern untuk pengembangan web.',
        'instructor' => 'Dr. Ahmad Fauzi, M.Kom',
        'semester' => 'Semester 5',
        'schedule' => 'Rabu, 13:00 - 16:00',
        'room' => 'Lab Komputer 1',
        'progress' => 75,
        'credits' => 2,
        'objectives' => [
            'Memahami struktur dasar HTML dan semantik web',
            'Menguasai styling dengan CSS dan responsive design',
            'Mampu menggunakan JavaScript untuk interaksi web',
            'Memahami konsep framework modern seperti React/Vue'
        ],
        'materials' => [
            ['title' => 'Pengenalan HTML5', 'type' => 'pdf', 'status' => 'completed'],
            ['title' => 'CSS3 dan Flexbox', 'type' => 'video', 'status' => 'completed'],
            ['title' => 'JavaScript ES6+', 'type' => 'pdf', 'status' => 'in_progress'],
            ['title' => 'Framework Modern', 'type' => 'video', 'status' => 'locked']
        ]
    ],
    'ROUTING' => [
        'name' => 'PRAKTIKUM ROUTING',
        'full_name' => 'Praktikum Routing dan Switching',
        'description' => 'Praktikum Routing dan Switching yang mempelajari konfigurasi jaringan, protokol routing, dan administrasi network.',
        'instructor' => 'Ir. Budi Santoso, M.T',
        'semester' => 'Semester 6',
        'schedule' => 'Selasa, 08:00 - 11:00',
        'room' => 'Lab Jaringan',
        'progress' => 60,
        'credits' => 3,
        'objectives' => [
            'Memahami konsep dasar routing dan switching',
            'Mampu mengkonfigurasi router dan switch',
            'Menguasai protokol routing dinamis',
            'Dapat mengatasi troubleshooting jaringan'
        ],
        'materials' => [
            ['title' => 'Pengenalan Routing', 'type' => 'pdf', 'status' => 'completed'],
            ['title' => 'Konfigurasi Router', 'type' => 'video', 'status' => 'completed'],
            ['title' => 'OSPF Protocol', 'type' => 'pdf', 'status' => 'in_progress'],
            ['title' => 'Network Troubleshooting', 'type' => 'video', 'status' => 'locked']
        ]
    ],
    'STQA' => [
        'name' => 'PRAKTIKUM STQA',
        'full_name' => 'Praktikum Software Testing & Quality Assurance',
        'description' => 'Praktikum Software Testing & Quality Assurance yang mempelajari metodologi testing, automation testing, dan quality control.',
        'instructor' => 'Dr. Siti Nurhaliza, M.Kom',
        'semester' => 'Semester 7',
        'schedule' => 'Kamis, 10:00 - 13:00',
        'room' => 'Lab Komputer 2',
        'progress' => 40,
        'credits' => 2,
        'objectives' => [
            'Memahami metodologi software testing',
            'Mampu melakukan manual dan automated testing',
            'Menguasai tools testing seperti Selenium, JUnit',
            'Dapat menerapkan quality assurance dalam proyek'
        ],
        'materials' => [
            ['title' => 'Pengenalan Testing', 'type' => 'pdf', 'status' => 'completed'],
            ['title' => 'Manual Testing', 'type' => 'video', 'status' => 'in_progress'],
            ['title' => 'Automation Testing', 'type' => 'pdf', 'status' => 'locked'],
            ['title' => 'Quality Assurance', 'type' => 'video', 'status' => 'locked']
        ]
    ],
    'PABD' => [
        'name' => 'PRAKTIKUM PABD',
        'full_name' => 'Praktikum Pengembangan Aplikasi Berbasis Database',
        'description' => 'Praktikum Pengembangan Aplikasi Berbasis Database yang mempelajari desain database, SQL, dan integrasi aplikasi dengan database.',
        'instructor' => 'Prof. Dr. Indra Wijaya, M.Kom',
        'semester' => 'Semester 4',
        'schedule' => 'Senin, 14:00 - 17:00',
        'room' => 'Lab Database',
        'progress' => 85,
        'credits' => 3,
        'objectives' => [
            'Memahami konsep database relational dan NoSQL',
            'Mampu merancang skema database yang efisien',
            'Menguasai SQL untuk manipulasi data',
            'Dapat mengintegrasikan database dengan aplikasi'
        ],
        'materials' => [
            ['title' => 'Database Design', 'type' => 'pdf', 'status' => 'completed'],
            ['title' => 'SQL Fundamentals', 'type' => 'video', 'status' => 'completed'],
            ['title' => 'Advanced SQL', 'type' => 'pdf', 'status' => 'completed'],
            ['title' => 'Database Integration', 'type' => 'video', 'status' => 'in_progress']
        ]
    ]
];

$course = $courses_data[$course_code];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['name']); ?> - Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="max-w-7xl mx-auto p-6">
        
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border-t-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <nav class="text-sm text-gray-600 mb-3">
                        <a href="praktikum_saya.php" class="hover:text-indigo-600">Praktikum Saya</a>
                        <span class="mx-2">/</span>
                        <span class="text-indigo-600"><?php echo htmlspecialchars($course['name']); ?></span>
                    </nav>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-flask text-indigo-600 mr-3"></i><?php echo htmlspecialchars($course['name']); ?>
                    </h1>
                    <p class="text-gray-600 text-lg"><?php echo htmlspecialchars($course['full_name']); ?></p>
                </div>
                <div class="hidden md:block">
                    <a href="praktikum_saya.php" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-300 shadow-lg hover:shadow-xl mr-3">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <a href="materi_praktikum.php?course=<?php echo urlencode($course_code); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-book-open mr-2"></i>Materi
                    </a>
                </div>
            </div>
        </div>

        <!-- Course Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Course Description -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-info-circle text-indigo-600 mr-3"></i>Deskripsi Praktikum
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo htmlspecialchars($course['description']); ?>
                    </p>
                </div>

                <!-- Learning Objectives -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-bullseye text-indigo-600 mr-3"></i>Tujuan Pembelajaran
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($course['objectives'] as $index => $objective): ?>
                            <div class="flex items-start space-x-3">
                                <div class="bg-indigo-100 text-indigo-600 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">
                                    <?php echo $index + 1; ?>
                                </div>
                                <p class="text-gray-700 leading-relaxed"><?php echo htmlspecialchars($objective); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Materials -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-book text-indigo-600 mr-3"></i>Materi Pembelajaran
                    </h2>
                    <div class="space-y-4">
                        <?php foreach ($course['materials'] as $material): ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition duration-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center <?php echo $material['type'] === 'pdf' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600'; ?>">
                                        <i class="fas <?php echo $material['type'] === 'pdf' ? 'fa-file-pdf' : 'fa-play'; ?>"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($material['title']); ?></h4>
                                        <p class="text-sm text-gray-600"><?php echo $material['type'] === 'pdf' ? 'PDF Document' : 'Video'; ?></p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <?php if ($material['status'] === 'completed'): ?>
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-check mr-1"></i>Selesai
                                        </span>
                                    <?php elseif ($material['status'] === 'in_progress'): ?>
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-clock mr-1"></i>Sedang Dipelajari
                                        </span>
                                    <?php else: ?>
                                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-lock mr-1"></i>Terkunci
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($material['status'] !== 'locked'): ?>
                                        <a href="materi_praktikum.php?course=<?php echo urlencode($course_code); ?>&material=<?php echo urlencode($material['title']); ?>" 
                                           class="text-indigo-600 hover:text-indigo-800 font-medium">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Course Info -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Praktikum</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-user-tie text-indigo-600"></i>
                            <div>
                                <p class="text-sm text-gray-600">Pengajar</p>
                                <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($course['instructor']); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-calendar-alt text-indigo-600"></i>
                            <div>
                                <p class="text-sm text-gray-600">Semester</p>
                                <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($course['semester']); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-clock text-indigo-600"></i>
                            <div>
                                <p class="text-sm text-gray-600">Jadwal</p>
                                <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($course['schedule']); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-map-marker-alt text-indigo-600"></i>
                            <div>
                                <p class="text-sm text-gray-600">Ruangan</p>
                                <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($course['room']); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-graduation-cap text-indigo-600"></i>
                            <div>
                                <p class="text-sm text-gray-600">SKS</p>
                                <p class="font-semibold text-gray-800"><?php echo $course['credits']; ?> SKS</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Progress Pembelajaran</h3>
                    <div class="text-center">
                        <div class="relative inline-flex items-center justify-center w-24 h-24 mb-4">
                            <svg class="w-24 h-24 transform -rotate-90">
                                <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="none" class="text-gray-200" />
                                <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="none" 
                                        stroke-dasharray="<?php echo 2 * 3.14159 * 40; ?>" 
                                        stroke-dashoffset="<?php echo 2 * 3.14159 * 40 * (1 - $course['progress'] / 100); ?>" 
                                        class="text-indigo-600" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-2xl font-bold text-gray-800"><?php echo $course['progress']; ?>%</span>
                            </div>
                        </div>
                        <p class="text-gray-600">Kemajuan Pembelajaran</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="materi_praktikum.php?course=<?php echo urlencode($course_code); ?>" 
                           class="block bg-indigo-600 hover:bg-indigo-700 text-white text-center py-3 rounded-xl font-semibold transition duration-300">
                            <i class="fas fa-book-open mr-2"></i>Lihat Materi
                        </a>
                        <a href="#" 
                           class="block bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-xl font-semibold transition duration-300">
                            <i class="fas fa-tasks mr-2"></i>Tugas
                        </a>
                        <a href="#" 
                           class="block bg-yellow-600 hover:bg-yellow-700 text-white text-center py-3 rounded-xl font-semibold transition duration-300">
                            <i class="fas fa-chart-line mr-2"></i>Nilai
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>