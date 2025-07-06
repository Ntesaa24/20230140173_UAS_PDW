<?php
require_once '../config.php';

$pageTitle = 'Beri Nilai';
$activePage = 'laporan';
$errors = [];
$success = false;

// Ambil parameter dari GET
$id_user = isset($_GET['id_user']) ? intval($_GET['id_user']) : 0;
$id_modul = isset($_GET['id_modul']) ? intval($_GET['id_modul']) : 0;

if ($id_user === 0 || $id_modul === 0) {
    die("Parameter tidak valid.");
}

// Ambil data mahasiswa dan modul
$stmt = $conn->prepare("
    SELECT u.nama AS nama_user, m.judul AS judul_modul 
    FROM users u
    JOIN praktikum_saya ps ON ps.id_user = u.id
    JOIN modul m ON ps.id_modul = m.id
    WHERE u.id = ? AND m.id = ?
    LIMIT 1
");
$stmt->bind_param("ii", $id_user, $id_modul);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data mahasiswa atau modul tidak ditemukan.");
}

// Proses form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nilai = trim($_POST['nilai']);
    $komentar = trim($_POST['komentar']);
    $feedback = trim($_POST['feedback']);

    if ($nilai === '') {
        $errors[] = 'Nilai tidak boleh kosong.';
    }

    if (empty($errors)) {
        // Cek apakah sudah ada nilai
        $cek = $conn->prepare("SELECT * FROM nilai WHERE id_user = ? AND id_modul = ?");
        $cek->bind_param("ii", $id_user, $id_modul);
        $cek->execute();
        $cekResult = $cek->get_result();

        if ($cekResult->num_rows > 0) {
            // Update nilai
            $stmt = $conn->prepare("UPDATE nilai SET nilai = ?, komentar = ?, feedback = ?, tanggal_nilai = NOW() WHERE id_user = ? AND id_modul = ?");
            $stmt->bind_param("sssii", $nilai, $komentar, $feedback, $id_user, $id_modul);
        } else {
            // Insert nilai baru
            $stmt = $conn->prepare("INSERT INTO nilai (id_user, id_modul, nilai, komentar, feedback, tanggal_nilai) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("iisss", $id_user, $id_modul, $nilai, $komentar, $feedback);
        }

        if ($stmt->execute()) {
            // Update status laporan jika perlu
            $updateStatus = $conn->prepare("UPDATE praktikum_saya SET status = 'graded' WHERE id_user = ? AND id_modul = ?");
            $updateStatus->bind_param("ii", $id_user, $id_modul);
            $updateStatus->execute();

            $success = true;
        } else {
            $errors[] = 'Gagal menyimpan nilai.';
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
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">📝 Beri Nilai</h1>

    <div class="mb-4">
      <p><strong>Nama Mahasiswa:</strong> <?= htmlspecialchars($data['nama_user']) ?></p>
      <p><strong>Modul:</strong> <?= htmlspecialchars($data['judul_modul']) ?></p>
    </div>

    <?php if ($success): ?>
      <div class="bg-green-100 text-green-800 p-4 rounded mb-4">✅ Nilai berhasil disimpan dan status laporan diperbarui.</div>
    <?php endif; ?>

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
        <label class="block font-semibold mb-1" for="nilai">Nilai</label>
        <input type="number" name="nilai" id="nilai" class="w-full border border-gray-300 px-3 py-2 rounded" required>
      </div>

      <div>
        <label class="block font-semibold mb-1" for="komentar">Komentar (opsional)</label>
        <textarea name="komentar" id="komentar" rows="3" class="w-full border border-gray-300 px-3 py-2 rounded"></textarea>
      </div>

      <div>
        <label class="block font-semibold mb-1" for="feedback">Feedback untuk Mahasiswa (opsional)</label>
        <textarea name="feedback" id="feedback" rows="3" class="w-full border border-gray-300 px-3 py-2 rounded"></textarea>
      </div>

      <div class="flex justify-between mt-4">
        <a href="laporan_masuk.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">← Kembali</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">💾 Simpan</button>
      </div>
    </form>
  </div>
</body>
</html>
