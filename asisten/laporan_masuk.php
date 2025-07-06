<?php
require_once '../config.php';
require_once 'templates/header.php';

$pageTitle = 'Laporan Masuk';
$activePage = 'laporan';

// Ambil data laporan dari praktikum_saya
$query = "
    SELECT 
        ps.id,
        u.nama AS nama_user,
        m.judul AS judul_modul,
        ps.file_laporan,
        ps.tanggal_upload,
        ps.status,
        n.nilai,
        ps.id_user,
        ps.id_modul
    FROM praktikum_saya ps
    LEFT JOIN users u ON ps.id_user = u.id
    LEFT JOIN modul m ON ps.id_modul = m.id_modul
    LEFT JOIN nilai n ON ps.id_user = n.id_user AND ps.id_modul = n.id_modul
    WHERE ps.file_laporan IS NOT NULL AND ps.file_laporan != ''
    ORDER BY ps.tanggal_upload DESC
";
$result = $conn->query($query);
$laporanList = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $laporanList[] = $row;
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
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">
<div class="max-w-7xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold mb-6 text-blue-700 border-b pb-2">📥 Laporan Masuk</h1>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse shadow-sm">
                <thead class="bg-blue-100 text-blue-800 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Mahasiswa</th>
                        <th class="px-4 py-3 text-left">Modul</th>
                        <th class="px-4 py-3 text-left">File</th>
                        <th class="px-4 py-3 text-left">Upload</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Nilai</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($laporanList as $index => $laporan): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3"><?= $index + 1 ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($laporan['nama_user']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($laporan['judul_modul']) ?></td>
                            <td class="px-4 py-3">
                                <a href="../uploads/<?= urlencode($laporan['file_laporan']) ?>" target="_blank" class="text-blue-600 underline">
                                    <?= htmlspecialchars($laporan['file_laporan']) ?>
                                </a>
                            </td>
                            <td class="px-4 py-3"><?= date('d-m-Y H:i', strtotime($laporan['tanggal_upload'])) ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs <?= $laporan['status'] === 'Diterima' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' ?>">
                                    <?= htmlspecialchars($laporan['status']) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3"><?= $laporan['nilai'] ?? '<span class="text-gray-400 italic">Belum dinilai</span>' ?></td>
                            <td class="px-4 py-3 space-x-2">
                                <a href="beri_nilai.php?id_user=<?= $laporan['id_user'] ?>&id_modul=<?= $laporan['id_modul'] ?>" class="text-green-600 hover:text-green-800 font-semibold">✅ Nilai</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($laporanList)): ?>
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500 italic">Belum ada laporan yang masuk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
