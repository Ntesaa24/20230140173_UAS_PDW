<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once 'templates/header_mahasiswa.php'; 
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    .gradient-card {
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #b8860b 100%);
        transition: all 0.3s ease;
    }
    
    .gradient-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(30, 58, 138, 0.3);
    }
    
    .stats-card {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #fbbf24 100%);
        transition: all 0.3s ease;
    }
    
    .stats-card-2 {
        background: linear-gradient(135deg, #b8860b 0%, #d97706 50%, #1e40af 100%);
        transition: all 0.3s ease;
    }
    
    .stats-card-3 {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 30%, #fbbf24 70%, #d97706 100%);
        transition: all 0.3s ease;
    }
    
    .stats-card:hover, .stats-card-2:hover, .stats-card-3:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 30px rgba(30, 58, 138, 0.2);
    }
    
    .notification-item {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .notification-item:hover {
        background: linear-gradient(90deg, #eff6ff 0%, #dbeafe 100%);
        border-left-color: #d97706;
        transform: translateX(5px);
    }
    
    .floating-animation {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .pulse-animation {
        animation: pulse 2s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }
    
    .premium-bg {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }
    
    .gold-accent {
        background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
    }
    
    .blue-accent {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    }
</style>

<!-- Welcome Section -->
<div class="gradient-card text-white p-6 rounded-2xl shadow-lg mb-6 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full -translate-y-10 translate-x-10"></div>
    <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full translate-y-8 -translate-x-8"></div>
    
    <div class="relative z-10">
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-yellow-400/30 to-amber-500/30 p-3 rounded-xl mr-4 backdrop-blur-sm">
                <i class="fas fa-graduation-cap text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold mb-1">
                    Hai, <?php echo htmlspecialchars($_SESSION['nama']); ?>! 👋
                </h1>
                <p class="text-sm opacity-80">Mari selesaikan praktikum hari ini dengan semangat!</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-4">
    <!-- Card 1 -->
    <div class="stats-card text-white p-8 rounded-3xl shadow-xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full -translate-y-10 translate-x-10"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-yellow-400/30 to-amber-500/30 p-3 rounded-2xl backdrop-blur-sm">
                    <i class="fas fa-book text-2xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-5xl font-bold">3</div>
                </div>
            </div>
            <div class="text-lg font-medium opacity-90">Praktikum Diikuti</div>
            <div class="text-sm opacity-75 mt-1">Aktif saat ini</div>
        </div>
    </div>
    
    <!-- Card 2 -->
    <div class="stats-card-2 text-white p-8 rounded-3xl shadow-xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full -translate-y-10 translate-x-10"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-blue-400/30 to-blue-500/30 p-3 rounded-2xl backdrop-blur-sm">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-5xl font-bold">8</div>
                </div>
            </div>
            <div class="text-lg font-medium opacity-90">Tugas Selesai</div>
            <div class="text-sm opacity-75 mt-1">Kerja bagus! 🎉</div>
        </div>
    </div>
    
    <!-- Card 3 -->
    <div class="stats-card-3 text-white p-8 rounded-3xl shadow-xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full -translate-y-10 translate-x-10"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-yellow-400/30 to-amber-500/30 p-3 rounded-2xl pulse-animation backdrop-blur-sm">
                    <i class="fas fa-hourglass-half text-2xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-5xl font-bold">4</div>
                </div>
            </div>
            <div class="text-lg font-medium opacity-90">Tugas Menunggu</div>
            <div class="text-sm opacity-75 mt-1">Ayo selesaikan! 💪</div>
        </div>
    </div>
</div>

<!-- Notifications Section -->
<div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-blue-100/50">
    <div class="flex items-center mb-4">
        <div class="bg-gradient-to-r from-blue-600 to-amber-600 p-2 rounded-xl mr-3">
            <i class="fas fa-bell text-white text-lg"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800">Notifikasi Terbaru</h3>
        <div class="ml-auto bg-gradient-to-r from-amber-500 to-yellow-500 text-white px-2 py-1 rounded-full text-xs font-medium shadow-md">
            3
        </div>
    </div>
    
    <div class="space-y-3">
        <!-- Notification 1 -->
        <div class="notification-item p-4 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/50">
            <div class="flex items-start">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-2 rounded-full mr-3 mt-1">
                    <i class="fas fa-star text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center mb-1">
                        <span class="text-lg mr-2">🎉</span>
                        <span class="bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">NILAI BARU</span>
                    </div>
                    <p class="text-gray-800 text-sm font-medium">
                        Nilai untuk <a href="#" class="font-bold text-blue-600 hover:text-amber-600 transition-colors">Modul 1: HTML & CSS</a> telah diberikan.
                    </p>
                    <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
                </div>
            </div>
        </div>

        <!-- Notification 2 -->
        <div class="notification-item p-4 rounded-xl bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200/50">
            <div class="flex items-start">
                <div class="bg-gradient-to-r from-amber-500 to-yellow-600 p-2 rounded-full mr-3 mt-1">
                    <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center mb-1">
                        <span class="text-lg mr-2">⚠️</span>
                        <span class="bg-gradient-to-r from-amber-100 to-yellow-200 text-amber-800 px-2 py-1 rounded-full text-xs font-medium">URGENT</span>
                    </div>
                    <p class="text-gray-800 text-sm font-medium">
                        Batas waktu pengumpulan laporan untuk <a href="#" class="font-bold text-amber-600 hover:text-blue-600 transition-colors">Modul 2: PHP Native</a> adalah besok!
                    </p>
                    <p class="text-xs text-gray-500 mt-1">5 jam yang lalu</p>
                </div>
            </div>
        </div>

        <!-- Notification 3 -->
        <div class="notification-item p-4 rounded-xl bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200/50">
            <div class="flex items-start">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-2 rounded-full mr-3 mt-1">
                    <i class="fas fa-user-plus text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center mb-1">
                        <span class="text-lg mr-2">✅</span>
                        <span class="bg-gradient-to-r from-blue-100 to-cyan-200 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">SUKSES</span>
                    </div>
                    <p class="text-gray-800 text-sm font-medium">
                        Anda berhasil mendaftar pada mata praktikum <a href="#" class="font-bold text-blue-600 hover:text-amber-600 transition-colors">Jaringan Komputer</a>.
                    </p>
                    <p class="text-xs text-gray-500 mt-1">1 hari yang lalu</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- View All Button -->
    <div class="mt-4 text-center">
        <a href="#" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-amber-600 text-white text-sm font-medium rounded-xl hover:from-blue-700 hover:to-amber-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            <i class="fas fa-eye mr-2"></i>
            Lihat Semua
        </a>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
    <a href="#" class="group block p-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:from-blue-700 hover:to-blue-800">
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-amber-400/30 to-yellow-500/30 p-3 rounded-2xl mr-4 group-hover:scale-110 transition-transform backdrop-blur-sm">
                <i class="fas fa-plus text-2xl"></i>
            </div>
            <div>
                <h4 class="text-lg font-bold">Tambah Praktikum</h4>
                <p class="text-sm opacity-90">Daftar praktikum baru</p>
            </div>
        </div>
    </a>
    
    <a href="#" class="group block p-6 bg-gradient-to-r from-amber-600 to-yellow-600 text-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:from-amber-700 hover:to-yellow-700">
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-blue-400/30 to-blue-500/30 p-3 rounded-2xl mr-4 group-hover:scale-110 transition-transform backdrop-blur-sm">
                <i class="fas fa-upload text-2xl"></i>
            </div>
            <div>
                <h4 class="text-lg font-bold">Upload Tugas</h4>
                <p class="text-sm opacity-90">Kumpulkan tugas Anda</p>
            </div>
        </div>
    </a>
</div>

<script>
// Add smooth scroll and enhanced interactions
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on scroll
    const cards = document.querySelectorAll('.stats-card, .stats-card-2, .stats-card-3');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    // Add click effects to notifications
    const notifications = document.querySelectorAll('.notification-item');
    notifications.forEach(notification => {
        notification.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });
    
    // Add premium glow effect on hover
    const premiumCards = document.querySelectorAll('.stats-card, .stats-card-2, .stats-card-3, .gradient-card');
    premiumCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.filter = 'drop-shadow(0 0 20px rgba(184, 134, 11, 0.3))';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.filter = 'none';
        });
    });
});
</script>

<?php
// Panggil Footer
require_once 'templates/footer_mahasiswa.php';
?>