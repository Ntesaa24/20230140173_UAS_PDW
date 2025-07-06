<?php
session_start();

// Cek login dan role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'asisten') {
    header("Location: ../login.php");
    exit();
}

$pageTitle = 'Kelola Praktikum';
$activePage = 'praktikum';

require_once 'templates/header.php';
require_once '../config.php';

// Ambil data praktikum
$sql = "SELECT * FROM praktikum ORDER BY created_at DESC";
$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Konfigurasi untuk table.php
$columns = ['Nama Praktikum', 'Deskripsi', 'Tanggal Buat'];
$fields  = ['nama_praktikum', 'deskripsi', 'created_at'];
?>

<!-- Notifikasi -->
<?php if (isset($_GET['status'])): ?>
  <?php
    $messages = [
      'tambah' => 'Praktikum berhasil ditambahkan.',
      'update' => 'Praktikum berhasil diperbarui.',
      'hapus'  => 'Praktikum berhasil dihapus.',
    ];
    $status = $_GET['status'];
  ?>
  <?php if (isset($messages[$status])): ?>
    <div id="notif" class="p-3 bg-green-100 text-green-800 rounded mb-4 max-w-4xl mx-auto transition-opacity duration-500">
      <?= $messages[$status] ?>
    </div>
  <?php endif; ?>
<?php endif; ?>

<!-- Tombol Tambah -->
<div class="mt-6 mx-auto max-w-6xl flex justify-end">
  <a href="tambah_praktikum.php" class="bg-blue-600 text-white px-4 py-2 text-sm rounded hover:bg-blue-700">
    + Tambah Praktikum
  </a>
</div>

<!-- Tabel Praktikum -->
<div class="bg-white shadow rounded-lg overflow-hidden mt-4 mx-auto max-w-6xl">
  <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
    <h3 class="text-lg font-semibold text-gray-800">Daftar Mata Praktikum</h3>
  </div>

  <div class="overflow-x-auto">
    <?php include '../templates/table.php'; ?>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const notif = document.getElementById('notif');
    function hideNotif() {
      if (notif) {
        notif.style.opacity = '0';
        setTimeout(() => notif.remove(), 300);
        window.removeEventListener('scroll', hideNotif);
        document.removeEventListener('click', hideNotif);
      }
    }
    window.addEventListener('scroll', hideNotif);
    document.addEventListener('click', hideNotif);
  });
</script>

<?php require_once '../templates/footer.php'; ?>
