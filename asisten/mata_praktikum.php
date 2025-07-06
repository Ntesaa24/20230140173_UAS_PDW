<?php
require_once '../config.php';

$pageTitle = 'Mata Praktikum';
$activePage = 'matapraktikum';

// Hapus data jika ada parameter hapus via GET
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $conn->prepare("DELETE FROM praktikum WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: mata_praktikum.php?status=hapus");
        exit();
    }
}

// Ambil semua data praktikum
$result = $conn->query("SELECT * FROM praktikum ORDER BY id DESC");
$praktikum = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $praktikum[] = $row;
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
      <h1 class="text-3xl font-bold mb-6 text-blue-700 border-b pb-2">📚 Mata Praktikum</h1>

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
        <a href="tambah_praktikum.php" class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
          ➕ Tambah Praktikum
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse shadow-md">
          <thead class="bg-blue-100 text-blue-800 text-sm uppercase">
            <tr>
              <th class="px-4 py-3 text-left">No</th>
              <th class="px-4 py-3 text-left">Nama Praktikum</th>
              <th class="px-4 py-3 text-left">Semester</th>
              <th class="px-4 py-3 text-left">Dosen Pengampu</th>
              <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <?php foreach ($praktikum as $index => $p): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3"><?= $index + 1 ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($p['nama_praktikum']) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($p['semester']) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($p['dosen_pengampu']) ?></td>
                <td class="px-4 py-3 space-x-2">
                  <a href="edit_praktikum.php?id=<?= $p['id'] ?>" title="Edit" class="text-yellow-500 hover:text-yellow-700">
                    ✏️
                  </a>
                  <a href="?hapus=<?= $p['id'] ?>" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 hover:text-red-800">
                    🗑️
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($praktikum)): ?>
              <tr>
                <td colspan="5" class="px-4 py-4 text-center text-gray-500 italic">Belum ada data praktikum.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
