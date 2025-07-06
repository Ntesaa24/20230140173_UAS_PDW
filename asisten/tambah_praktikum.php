<?php
require_once '../config.php';

$pageTitle = 'Tambah Mata Praktikum';
$activePage = 'matapraktikum';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_praktikum = trim($_POST['nama_praktikum']);
    $semester = trim($_POST['semester']);
    $dosen_pengampu = trim($_POST['dosen_pengampu']);
    $created_at = date('Y-m-d H:i:s'); // ambil waktu sekarang

    if ($nama_praktikum === '') {
        $errors[] = 'Nama praktikum wajib dipilih.';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO praktikum (nama_praktikum, semester, dosen_pengampu, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama_praktikum, $semester, $dosen_pengampu, $created_at);
        if ($stmt->execute()) {
            header("Location: mata_praktikum.php?status=tambah");
            exit();
        } else {
            $errors[] = "Gagal menambahkan data: " . $stmt->error;
        }
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
  <script>
    function confirmSubmit() {
        return confirm('Apakah Anda yakin ingin menyimpan data ini?');
    }
  </script>
</head>
<body class="bg-gray-100 p-6 min-h-screen">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Tambah Mata Praktikum</h1>

    <?php if (!empty($errors)): ?>
      <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li>• <?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="" class="space-y-4" onsubmit="return confirmSubmit();">
      <div>
        <label class="block font-semibold mb-1" for="nama_praktikum">Nama Praktikum</label>
        <select name="nama_praktikum" id="nama_praktikum" class="w-full border border-gray-300 rounded px-3 py-2" required>
          <option value="">-- Pilih Praktikum --</option>
          <option value="PRAKTIKUM SIBER">PRAKTIKUM SIBER</option>
          <option value="PRAKTIKUM PDW">PRAKTIKUM PDW</option>
          <option value="PRAKTIKUM ROUTING">PRAKTIKUM ROUTING</option>
          <option value="PRAKTIKUM STQA">PRAKTIKUM STQA</option>
          <option value="PRAKTIKUM PABD">PRAKTIKUM PABD</option>
        </select>
      </div>

      <div>
        <label class="block font-semibold mb-1" for="semester">Semester</label>
        <input type="text" name="semester" id="semester" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Contoh: 4" required>
      </div>

      <div>
        <label class="block font-semibold mb-1" for="dosen_pengampu">Dosen Pengampu</label>
        <input type="text" name="dosen_pengampu" id="dosen_pengampu" class="w-full border border-gray-300 rounded px-3 py-2" required>
      </div>

      <div class="flex justify-between mt-6">
        <a href="mata_praktikum.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Kembali</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
      </div>
    </form>
  </div>
</body>
</html>
