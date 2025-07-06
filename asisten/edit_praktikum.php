<?php
require_once '../config.php';

$pageTitle = 'Edit Mata Praktikum';
$activePage = 'matapraktikum';

$errors = [];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data dari database
$stmt = $conn->prepare("SELECT * FROM praktikum WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

// Proses saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_praktikum = trim($_POST['nama_praktikum']);
    $semester = trim($_POST['semester']);
    $dosen_pengampu = trim($_POST['dosen_pengampu']);

    if ($nama_praktikum === '' || $semester === '' || $dosen_pengampu === '') {
        $errors[] = 'Semua field wajib diisi.';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE praktikum SET nama_praktikum = ?, semester = ?, dosen_pengampu = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nama_praktikum, $semester, $dosen_pengampu, $id);
        if ($stmt->execute()) {
            header("Location: mata_praktikum.php?status=ubah");
            exit();
        } else {
            $errors[] = "Gagal mengupdate data: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $pageTitle ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 min-h-screen">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Edit Mata Praktikum</h1>

    <?php if (!empty($errors)): ?>
      <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li>• <?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block font-semibold mb-1">Nama Praktikum</label>
        <input type="text" name="nama_praktikum" value="<?= htmlspecialchars($data['nama_praktikum']) ?>" class="w-full border border-gray-300 rounded px-3 py-2" required>
      </div>

      <div>
        <label class="block font-semibold mb-1">Semester</label>
        <input type="text" name="semester" value="<?= htmlspecialchars($data['semester']) ?>" class="w-full border border-gray-300 rounded px-3 py-2" required>
      </div>

      <div>
        <label class="block font-semibold mb-1">Dosen Pengampu</label>
        <input type="text" name="dosen_pengampu" value="<?= htmlspecialchars($data['dosen_pengampu']) ?>" class="w-full border border-gray-300 rounded px-3 py-2" required>
      </div>

      <div class="flex justify-between mt-6">
        <a href="mata_praktikum.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Kembali</a>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</body>
</html>
