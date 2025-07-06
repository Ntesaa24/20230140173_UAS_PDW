<?php
require_once '../config.php';
session_start();

// Pastikan user adalah mahasiswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    die("Akses ditolak.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['user_id'];
    $id_modul = isset($_POST['id_modul']) ? intval($_POST['id_modul']) : 0;

    // Validasi id_modul tidak boleh 0
    if ($id_modul === 0) {
        die("Modul tidak dipilih.");
    }

    // Validasi id_modul ada di tabel modul
    $stmt = $conn->prepare("SELECT id_modul FROM modul WHERE id_modul = ?");
    if (!$stmt) {
        die("Kesalahan prepare: " . $conn->error);
    }
    $stmt->bind_param("i", $id_modul);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        die("ID modul ($id_modul) tidak valid atau tidak ditemukan di database.");
    }

    // Validasi file
    if (isset($_FILES['file_laporan']) && $_FILES['file_laporan']['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['file_laporan']['name']);
        $file_tmp = $_FILES['file_laporan']['tmp_name'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['pdf', 'doc', 'docx'];

        if (!in_array($ext, $allowed)) {
            die("Format file tidak didukung. Hanya PDF, DOC, dan DOCX.");
        }

        // Penamaan file aman
        $safe_name = time() . '_' . preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $file_name);
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $file_dest = $upload_dir . $safe_name;

        // Upload file ke folder uploads
        if (move_uploaded_file($file_tmp, $file_dest)) {
            // Cek apakah data sudah ada di praktikum_saya
            $stmt = $conn->prepare("SELECT id FROM praktikum_saya WHERE id_user = ? AND id_modul = ?");
            $stmt->bind_param("ii", $id_user, $id_modul);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update file laporan jika sudah ada
                $stmt = $conn->prepare("UPDATE praktikum_saya 
                    SET file_laporan = ?, tanggal_upload = NOW(), status = 'submitted' 
                    WHERE id_user = ? AND id_modul = ?");
                $stmt->bind_param("sii", $safe_name, $id_user, $id_modul);
            } else {
                // Insert baru jika belum ada
                $stmt = $conn->prepare("INSERT INTO praktikum_saya 
                    (id_user, id_modul, file_laporan, tanggal_upload, status) 
                    VALUES (?, ?, ?, NOW(), 'submitted')");
                $stmt->bind_param("iis", $id_user, $id_modul, $safe_name);
            }

            // Simpan ke database
            if ($stmt->execute()) {
                header("Location: praktikum_saya.php?success=upload");
                exit;
            } else {
                echo "Gagal menyimpan ke database: " . $stmt->error;
            }
        } else {
            echo "Gagal mengunggah file ke server. Error code: " . $_FILES['file_laporan']['error'];
        }
    } else {
        echo "Tidak ada file yang diunggah atau terjadi kesalahan saat upload. Error code: " . $_FILES['file_laporan']['error'];
    }
}
?>
