<?php
session_start();
require_once '../config.php';
require_once 'templates/header_mahasiswa.php';

// Initialize session if not exists
if (!isset($_SESSION['registered_courses'])) {
    $_SESSION['registered_courses'] = ['PABD'];
}

// Get user ID from session
$user_id = $_SESSION['user_id'] ?? 1; // Default to 1 if not set

// Function to get praktikum data from database
function getPraktikumData($conn, $user_id) {
    $query = "
    SELECT 
        ps.id_modul,
        m.judul AS name,
        m.deskripsi AS description,
        m.file_materi,
        ps.file_laporan,
        ps.tanggal_upload,
        ps.status,
        n.nilai,
        CASE 
            WHEN ps.status IS NULL THEN 0
            WHEN ps.status = 'submitted' THEN 50
            WHEN ps.status = 'reviewed' THEN 75
            WHEN ps.status = 'graded' THEN 100
            ELSE 0
        END as progress
    FROM modul m
    LEFT JOIN praktikum_saya ps ON m.id_modul = ps.id_modul AND ps.id_user = ?
    LEFT JOIN nilai n ON ps.id_user = n.id_user AND ps.id_modul = n.id_modul
    ORDER BY m.id_modul
";

    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $praktikum_data = [];
    while ($row = $result->fetch_assoc()) {
        $praktikum_data[] = $row;
    }
    
    return $praktikum_data;
}

// Get praktikum data from database
$praktikum_data = getPraktikumData($conn, $user_id);

// Calculate statistics
$total_courses = count($praktikum_data);
$completed_courses = 0;
$in_progress_courses = 0;
$average_progress = 0;

if ($total_courses > 0) {
    $total_progress = 0;
    foreach ($praktikum_data as $course) {
        $progress = $course['progress'];
        $total_progress += $progress;
        if ($progress >= 100) {
            $completed_courses++;
        } elseif ($progress > 0) {
            $in_progress_courses++;
        }
    }
    $average_progress = round($total_progress / $total_courses);
}

// Handle success/error messages
$success_message = $_GET['success'] ?? '';
$error_message = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="max-w-6xl mx-auto p-3">
        
        <!-- Success/Error Messages -->
        <?php if ($success_message): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>
                        <?php
                        switch ($success_message) {
                            case 'upload':
                                echo 'File berhasil diupload!';
                                break;
                            case 'update':
                                echo 'File berhasil diupdate!';
                                break;
                            default:
                                echo 'Operasi berhasil!';
                        }
                        ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>
                        <?php
                        switch ($error_message) {
                            case 'file_type':
                                echo 'Tipe file tidak diizinkan!';
                                break;
                            case 'file_size':
                                echo 'Ukuran file terlalu besar!';
                                break;
                            case 'upload_failed':
                                echo 'Gagal mengupload file!';
                                break;
                            case 'db_error':
                                echo 'Terjadi kesalahan database!';
                                break;
                            default:
                                echo 'Terjadi kesalahan!';
                        }
                        ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border-t-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-1">
                        <i class="fas fa-clipboard-list text-indigo-600 mr-3"></i>Praktikum Saya
                    </h1>
                    <p class="text-gray-600 text-lg">Dashboard praktikum yang sedang Anda ikuti</p>
                </div>
                <div class="hidden md:block">
                    <button onclick="showUploadModal()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-300 shadow-lg hover:shadow-xl mr-3">
                        <i class="fas fa-upload mr-2"></i>Upload Laporan
                    </button>
                    <a href="cari_praktikum.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-search mr-2"></i>Cari Praktikum
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Praktikum</p>
                        <p class="text-3xl font-bold text-gray-800"><?php echo $total_courses; ?></p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-xl">
                        <i class="fas fa-book text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Selesai</p>
                        <p class="text-3xl font-bold text-gray-800"><?php echo $completed_courses; ?></p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-xl">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Dalam Progress</p>
                        <p class="text-3xl font-bold text-gray-800"><?php echo $in_progress_courses; ?></p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-xl">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Progress Rata-rata</p>
                        <p class="text-3xl font-bold text-gray-800"><?php echo $average_progress; ?>%</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-xl">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Practical Courses List -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-indigo-600 text-2xl mr-3"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Praktikum yang Sedang Diikuti</h2>
                </div>
                <button onclick="showUploadModal()" class="md:hidden bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-semibold transition duration-300">
                    <i class="fas fa-upload mr-2"></i>Upload
                </button>
            </div>

            <?php if (empty($praktikum_data)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-500 mb-2">Belum Ada Praktikum Terdaftar</h3>
                    <p class="text-gray-400 mb-6">Anda belum mendaftar pada praktikum manapun</p>
                    <a href="cari_praktikum.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-300">
                        <i class="fas fa-search mr-2"></i>Cari Praktikum
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <?php foreach ($praktikum_data as $course): ?>
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-2xl shadow-lg border border-indigo-100">
                            <div class="flex items-start justify-between mb-4">
                                <div class="bg-indigo-100 p-3 rounded-xl">
                                    <i class="fas fa-flask text-indigo-600 text-xl"></i>
                                </div>
                                <div class="flex space-x-2">
                                    <?php
                                    $statusClass = '';
                                    $statusText = '';
                                    switch ($course['status']) {
                                        case 'submitted':
                                            $statusClass = 'bg-yellow-600';
                                            $statusText = 'Submitted';
                                            break;
                                        case 'reviewed':
                                            $statusClass = 'bg-blue-600';
                                            $statusText = 'Reviewed';
                                            break;
                                        case 'graded':
                                            $statusClass = 'bg-green-600';
                                            $statusText = 'Graded';
                                            break;
                                        default:
                                            $statusClass = 'bg-gray-600';
                                            $statusText = 'Not Started';
                                    }
                                    ?>
                                    <span class="<?php echo $statusClass; ?> text-white px-3 py-1 rounded-full text-xs font-medium">
                                        <?php echo $statusText; ?>
                                    </span>
                                </div>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-800 mb-2 leading-tight">
                                <?php echo htmlspecialchars($course['name']); ?>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 leading-relaxed text-sm">
                                <?php echo htmlspecialchars($course['description']); ?>
                            </p>
                            
                            <!-- File Status -->
                            <div class="mb-4">
                                <?php if ($course['file_laporan']): ?>
                                    <div class="flex items-center text-sm text-green-600 mb-2">
                                        <i class="fas fa-file-alt mr-2"></i>
                                        <span>File: <?php echo htmlspecialchars($course['file_laporan']); ?></span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-clock mr-2"></i>
                                        <span>Upload: <?php echo date('d-m-Y H:i', strtotime($course['tanggal_upload'])); ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="flex items-center text-sm text-red-600">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <span>Belum ada file laporan</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Nilai -->
                            <?php if ($course['nilai'] !== null): ?>
                                <div class="mb-4">
                                    <div class="flex items-center text-sm text-blue-600">
                                        <i class="fas fa-star mr-2"></i>
                                        <span>Nilai: <strong><?php echo htmlspecialchars($course['nilai']); ?></strong></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Progress</span>
                                    <span><?php echo $course['progress']; ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-300" 
                                         style="width: <?php echo $course['progress']; ?>%"></div>
                                </div>
                            </div>
                            
                            <div class="flex space-x-2">
                                <button onclick="showUploadModal(<?php echo $course['id_modul']; ?>)" 
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-center font-semibold transition duration-300 text-sm">
                                    <i class="fas fa-upload mr-1"></i>
                                    <?php echo $course['file_laporan'] ? 'Update' : 'Upload'; ?>
                                </button>
                                <?php if ($course['file_materi']): ?>
                                    <a href="../uploads/<?php echo urlencode($course['file_materi']); ?>" 
                                       target="_blank"
                                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-center font-semibold transition duration-300 text-sm">
                                        <i class="fas fa-download mr-1"></i>Materi
                                    </a>
                                <?php endif; ?>
                                <?php if ($course['file_laporan']): ?>
                                    <a href="../uploads/<?php echo urlencode($course['file_laporan']); ?>" 
                                       target="_blank"
                                       class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-center font-semibold transition duration-300 text-sm">
                                        <i class="fas fa-eye mr-1"></i>Lihat
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <i class="fas fa-calendar-check text-blue-600 text-xl mr-3"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Status Upload</h3>
                </div>
                <div class="space-y-3">
                    <?php
                    $uploaded_count = 0;
                    $not_uploaded_count = 0;
                    
                    foreach ($praktikum_data as $course) {
                        if ($course['file_laporan']) {
                            $uploaded_count++;
                        } else {
                            $not_uploaded_count++;
                        }
                    }
                    ?>
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            <span class="text-sm text-gray-800">Sudah Upload</span>
                        </div>
                        <span class="text-sm font-bold text-green-600"><?php echo $uploaded_count; ?></span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                            <span class="text-sm text-gray-800">Belum Upload</span>
                        </div>
                        <span class="text-sm font-bold text-red-600"><?php echo $not_uploaded_count; ?></span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <i class="fas fa-bell text-yellow-600 text-xl mr-3"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Pengumuman Terbaru</h3>
                </div>
                <div class="space-y-3">
                    <div class="p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
                        <p class="font-medium text-gray-800 text-sm">Deadline Upload Laporan</p>
                        <p class="text-xs text-gray-600 mt-1">Pastikan semua laporan sudah diupload</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                        <p class="font-medium text-gray-800 text-sm">Format File</p>
                        <p class="text-xs text-gray-600 mt-1">Gunakan format PDF, DOC, atau DOCX</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg border-l-4 border-green-400">
                        <p class="font-medium text-gray-800 text-sm">Penilaian</p>
                        <p class="text-xs text-gray-600 mt-1">Nilai akan keluar setelah direview</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Upload Laporan</h3>
                        <button onclick="closeUploadModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
                        <input type="hidden" name="id_modul" id="modalIdModul" value="">
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Modul</label>
                            <select name="id_modul" id="selectModul" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Pilih Modul...</option>
                                <?php foreach ($praktikum_data as $course): ?>
                                    <option value="<?php echo $course['id_modul']; ?>">
                                        <?php echo htmlspecialchars($course['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">File Laporan</label>
                            <input type="file" name="file_laporan" accept=".pdf,.doc,.docx" required 
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX (Max: 10MB)</p>
                        </div>
                        
                        <div class="flex space-x-3">
                            <button type="button" onclick="closeUploadModal()" 
                                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition duration-300">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300">
                                <i class="fas fa-upload mr-2"></i>Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showUploadModal(id_modul = null) {
            document.getElementById('uploadModal').classList.remove('hidden');
            if (id_modul) {
                document.getElementById('selectModul').value = id_modul;
            }
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.getElementById('uploadForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('uploadModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUploadModal();
            }
        });

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