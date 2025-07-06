<?php
require_once '../config.php';

$pageTitle = 'Modul Praktikum';
$activePage = 'modul';

// Hapus data jika ada parameter hapus via GET
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $conn->prepare("DELETE FROM modul WHERE id_modul = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: modul.php?status=hapus");
        exit();
    }
}

// Ambil data modul + nama praktikum via JOIN
$query = "
    SELECT 
        m.id_modul, 
        m.judul AS judul_modul, 
        m.pertemuan, 
        p.nama_praktikum
    FROM modul m
    JOIN praktikum p ON m.id_praktikum = p.id
    ORDER BY m.id_modul DESC
";
$result = $conn->query($query);
$modulList = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $modulList[] = $row;
    }
}

require_once 'templates/header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $pageTitle ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">
  <div class="max-w-6xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
      <h1 class="text-3xl font-bold mb-6 text-blue-700 border-b pb-2">📘 Modul Praktikum</h1>

      <!-- Notifikasi -->
      <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'hapus'): ?>
          <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md shadow">✅ Data berhasil dihapus.</div>
        <?php elseif ($_GET['status'] === 'tambah'): ?>
          <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md shadow">✅ Data berhasil ditambahkan.</div>
        <?php elseif ($_GET['status'] === 'ubah'): ?>
          <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-md shadow">✏️ Data berhasil diubah.</div>
        <?php endif; ?>
      <?php endif; ?>

      <div class="flex justify-end mb-4">
        <a href="tambah_modul.php" class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
          ➕ Tambah Modul
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse shadow-md">
          <thead class="bg-blue-100 text-blue-800 text-sm uppercase">
            <tr>
              <th class="px-4 py-3 text-left">No</th>
              <th class="px-4 py-3 text-left">Judul Modul</th>
              <th class="px-4 py-3 text-left">Pertemuan</th>
              <th class="px-4 py-3 text-left">Praktikum</th>
              <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <?php foreach ($modulList as $index => $m): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3"><?= $index + 1 ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($m['judul_modul']) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($m['pertemuan']) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($m['nama_praktikum']) ?></td>
                <td class="px-4 py-3 space-x-2">
                  <a href="edit_modul.php?id=<?= $m['id_modul'] ?>" title="Edit" class="text-yellow-500 hover:text-yellow-700">✏️</a>
                  <a href="?hapus=<?= $m['id_modul'] ?>" title="Hapus" onclick="return confirm('Yakin ingin menghapus modul ini?')" class="text-red-600 hover:text-red-800">🗑️</a>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($modulList)): ?>
              <tr>
                <td colspan="5" class="px-4 py-4 text-center text-gray-500 italic">Belum ada data modul.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
