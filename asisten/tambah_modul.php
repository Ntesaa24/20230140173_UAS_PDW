<?php
require_once '../config.php';
$pageTitle = 'Tambah Modul Praktikum';
$activePage = 'modul';

$error = '';
if (isset($_POST['simpan'])) {
    $judul = trim($_POST['judul']);
    $pertemuan = intval($_POST['pertemuan']);
    $id_praktikum = intval($_POST['id_praktikum']); // HARUS foreign key yang valid

    if ($judul && $pertemuan && $id_praktikum) {
        $stmt = $conn->prepare("INSERT INTO modul (judul, pertemuan, id_praktikum) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $judul, $pertemuan, $id_praktikum);

        if ($stmt->execute()) {
            header("Location: modul.php?status=tambah");
            exit();
        } else {
            $error = "Gagal menyimpan data. ID praktikum tidak valid.";
        }
    } else {
        $error = "Semua field wajib diisi.";
    }
}

// Ambil data praktikum dari tabel
$praktikumList = [];
$result = $conn->query("SELECT id, nama_praktikum FROM praktikum ORDER BY nama_praktikum ASC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $praktikumList[] = $row;
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
<body class="bg-gray-100 min-h-screen">
  <div class="max-w-xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow p-6">
      <h1 class="text-xl font-bold mb-4 text-blue-700">➕ Tambah Modul Praktikum</h1>

      <?php if ($error): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"><?= $error ?></div>
      <?php endif; ?>

      <form action="" method="post" class="space-y-4">
        <div>
          <label for="judul" class="block font-medium">Judul Modul:</label>
          <input type="text" name="judul" id="judul" required class="w-full border px-3 py-2 rounded" placeholder="Contoh: Modul 1 - Pengantar">
        </div>

        <div>
          <label for="pertemuan" class="block font-medium">Pertemuan Ke-:</label>
          <input type="number" name="pertemuan" id="pertemuan" required min="1" value="1" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
          <label for="id_praktikum" class="block font-medium">Praktikum:</label>
          <select name="id_praktikum" id="id_praktikum" required class="w-full border px-3 py-2 rounded">
            <option value="">-- Pilih Praktikum --</option>
            <?php foreach ($praktikumList as $praktikum): ?>
              <option value="<?= $praktikum['id'] ?>">
                <?= htmlspecialchars($praktikum['nama_praktikum']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="flex justify-between mt-6">
          <a href="modul.php" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">← Kembali</a>
          <button type="submit" name="simpan" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">📅 Simpan</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>