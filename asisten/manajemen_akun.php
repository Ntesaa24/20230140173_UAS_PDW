<?php
require_once '../config.php';

$pageTitle = 'Manajemen Akun';
$activePage = 'akun';

// Ambil data user dari tabel users
$query = "SELECT * FROM users ORDER BY role, nama";
$result = $conn->query($query);
$userList = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userList[] = $row;
    }
}

// Hapus akun jika ada parameter hapus
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: manajemen_akun.php?status=hapus");
        exit();
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
      <h1 class="text-3xl font-bold mb-6 text-blue-700 border-b pb-2">👤 Manajemen Akun</h1>

      <!-- Notifikasi -->
      <?php if (isset($_GET['status']) && $_GET['status'] === 'hapus'): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md shadow">✅ Akun berhasil dihapus.</div>
      <?php endif; ?>

      <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse shadow-md">
          <thead class="bg-blue-100 text-blue-800 text-sm uppercase">
            <tr>
              <th class="px-4 py-3 text-left">No</th>
              <th class="px-4 py-3 text-left">Nama</th>
              <th class="px-4 py-3 text-left">Username</th>
              <th class="px-4 py-3 text-left">Role</th>
              <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <?php foreach ($userList as $index => $user): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3"><?= $index + 1 ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($user['nama']) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($user['username']) ?></td>
                <td class="px-4 py-3 capitalize"><?= htmlspecialchars($user['role']) ?></td>
                <td class="px-4 py-3 space-x-2">
                  <a href="edit_user.php?id=<?= $user['id'] ?>" class="text-yellow-500 hover:text-yellow-700" title="Edit">✏️</a>
                  <a href="?hapus=<?= $user['id'] ?>" onclick="return confirm('Yakin ingin menghapus akun ini?')" class="text-red-600 hover:text-red-800" title="Hapus">🗑️</a>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($userList)): ?>
              <tr>
                <td colspan="5" class="px-4 py-4 text-center text-gray-500 italic">Belum ada akun terdaftar.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
