CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','asisten') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE praktikum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_praktikum VARCHAR(100) NOT NULL,
    deskripsi TEXT
);



CREATE TABLE peserta_praktikum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_mahasiswa INT NOT NULL,
    id_praktikum INT NOT NULL,
    UNIQUE (id_mahasiswa, id_praktikum),
    FOREIGN KEY (id_mahasiswa) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_praktikum) REFERENCES praktikum(id) ON DELETE CASCADE
);


CREATE TABLE nilai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_modul INT NOT NULL,
    nilai VARCHAR(10),
    komentar TEXT,
    feedback TEXT,
    tanggal_nilai DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (id_user, id_modul),
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_modul) REFERENCES modul(id) ON DELETE CASCADE
);



$query = "SELECT id, nama, username, email, role FROM users ORDER BY role, nama";
ALTER TABLE users ADD username VARCHAR(100) AFTER nama;

ALTER TABLE praktikum
ADD COLUMN semester VARCHAR(10) AFTER nama_praktikum,
ADD COLUMN dosen_pengampu VARCHAR(100) AFTER semester;

ALTER TABLE laporan ADD COLUMN id_user INT NOT NULL;

CREATE TABLE notifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_mahasiswa INT NOT NULL,
    isi TEXT NOT NULL,
    waktu DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_mahasiswa) REFERENCES users(id) ON DELETE CASCADE
);

ALTER TABLE users ADD nim VARCHAR(20) AFTER nama;

CREATE TABLE praktikum_saya (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_modul INT NOT NULL,
    file_laporan VARCHAR(255),
    tanggal_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('submitted', 'graded', 'reviewed') DEFAULT 'submitted',
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_modul) REFERENCES modul(id)
);

ALTER TABLE modul ADD deskripsi TEXT AFTER judul;
ALTER TABLE modul ADD nama_praktikum VARCHAR(100) AFTER pertemuan;
